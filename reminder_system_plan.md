# Implementation Plan: Membership Reminder System (SMS/Email)

This plan outlines the architecture for a robust notification system that alerts members before their membership expires.

## 📋 1. Requirement Store

### A. Configuration & Settings:
- **Provider Setup**:
    - **SMS Configuration**: API Keys, Sender ID, and Provider URL (e.g., Twilio, Msg91, or custom).
    - **Email Configuration**: SMTP details or transactional email API (e.g., SendGrid, Mailgun).
- **Notification Logic**:
    - **Trigger Points**: 
        - **Onboarding**: Immediate "Welcome" message when a member is added.
        - **Expiry**: Scheduled alerts before the membership ends.
    - **Trigger Mode**: Toggle between **Automatic** (scheduled on creation) and **Manual**.
    - **Channels**: Selection for **SMS**, **Email**, or **Both**.
    - **Timing (Expiry)**: Number of days before expiry to send the reminder (e.g., 7 days, 3 days, 1 day).
- **Template Management**:
    - Customizable **Welcome Message** (SMS/Email).
    - Customizable **Expiry Reminder** (SMS/Email).
    - **Dynamic Placeholders**: Support for `{{member_name}}`, `{{expiry_date}}`, `{{membership_type}}`.

### B. Member Onboarding & Management:
- **Communication Preference**: Option to set preferred channel (SMS/Email/Both) for each member during creation.
- **Bulk Actions**: Ability to select multiple members from the list and manually trigger or schedule a reminder.

---

## 🗄️ 2. Database Changes

### [settings](file:///Users/admin/Downloads/gym%20software/app/Helper/Helper.php#121-153) Table (Existing):
Store global configurations as key-value pairs:
- `sms_provider_details` (JSON)
- `email_reminder_template`
- `sms_reminder_template`
- `reminder_auto_schedule_days` (e.g., "7,3,1")

### [users](file:///Users/admin/Downloads/gym%20software/app/Models/Attendance.php#21-25) / `trainees` Table (New Columns):
- `communication_preference`: `ENUM('sms', 'email', 'both')` (Default: 'email')

### `reminders` Table (New):
Track individual notification jobs:
- [id](file:///Users/admin/Downloads/gym%20software/app/Providers/AuthServiceProvider.php#8-31) (Primary Key)
- `trainee_id` (Foreign Key)
- `type`: `ENUM('sms', 'email')`
- `scheduled_at`: `DATETIME` (When it should be sent)
- `sent_at`: `DATETIME` (NULL if pending)
- `status`: `ENUM('pending', 'sent', 'failed')`
- `response_log`: `TEXT` (API response for debugging)

---

## ⚙️ 3. Implementation Logic

### Step 1: Sidebar & Permissions
1. **New Module**: Create a module named **"Communication"** in the `modules` table.
2. **Permissions**:
    - `manage communication config`: For settings.
    - `send manual reminder`: For bulk actions.
    - `view reminder logs`: To track what was sent.
3. **Sidebar**: Add a "Communication" or "Reminders" menu under **Business Management**, visible only if `Gate::check('view reminder logs')`.

### Step 2: Automatic Notifications (On Member Creation)
1. **Event Listener**: Attach a listener to the `Trainee::created` or `Membership::created` event.
2. **Immediate Action (Welcome)**:
    - If "Onboarding Notification" is enabled, call the SMS/Email API **immediately** to send the Welcome message.
3. **Scheduled Action (Expiry)**:
    - Fetch the `end_date` of the membership.
    - Subtract the configured "reminder_days" (e.g., 7 days).
    - Insert a record into the `reminders` table with the `scheduled_at` timestamp for the future alert.

### Step 3: The Background Task (Automation)
1. **Cron Job**: Run a task every hour (via Laravel's Task Scheduler).
2. **Logic**:
    - Query `reminders` where `status = 'pending'` and `scheduled_at <= NOW()`.
    - If `type = 'sms'`, call the configured SMS Provider API.
    - If `type = 'email'`, dispatch a `Mailable` class.
    - Update `sent_at` and `status` based on success or failure.

### Step 4: Manual/Bulk Reminders (Listing View)
1. **Frontend**: Add checkboxes to the Member index table.
2. **Bulk Action Dropdown**: Add "Schedule Expiry Reminder" option.
3. **Controller**: A new `ReminderController@bulkSchedule` method that inserts records into the `reminders` table immediately (or for a future date).

---

## 🛡️ 4. Handling Permissions in Sidebar
The sidebar elements are shown based on permissions linked to Roles.
- **How it works**:
    - You create a permission (e.g., `manage communication`).
    - You assign this permission to a Role (e.g., Admin).
    - In [menu.blade.php](file:///Users/admin/Downloads/gym%20software/resources/views/admin/menu.blade.php), we wrap the menu item in `@if(Gate::check('manage communication'))`.
- **New Module Integration**: 
    - Since we have a `modules` table now, you can create a **"Reminders"** module.
    - Add permissions to it.
    - Any user with a role containing those permissions will see the new sidebar link.
