# Gym Management System - Module Usage Guide

## Class Module
The **Class Module** is designed to manage specialized fitness sessions (e.g., Yoga, HIIT, Zumba).

### Business Use Cases:
- **Revenue Stream**: Charge extra fees for specialized sessions separate from general membership.
- **Scheduling**: Define specific days and times for group activities.
- **Staffing**: Assign specific trainers to lead these sessions.

### How it works:
1. **Create a Class**: Go to the Classes section, define a title, physical address, and the fee.
2. **Set Schedule**: Add multiple "days" and "times" to define when the class repeats.
3. **Assign People**:
   - **Trainers**: Assign staff to lead the class.
   - **Trainees**: Assign members. Note: When a trainee is assigned, the system **automatically generates an invoice** for the class fee.

---

## Membership & Trainee Management (FAQ)

### 1. Is the "Class" field mandatory when adding a member?
**No.** When creating a new trainee, the "Select Class" field is optional. You can add a member just for general gym access by selecting a **Category** and a **Membership Plan** without selecting a class.

### 2. How are start and end dates handled for mid-month joins?
The system uses **Anniversary-based Billing**.
- **Start Date**: This is the date you select in the "Membership Start Date" field.
- **End Date**: The system automatically calculates the expiry date by adding the package duration to the start date. 
  - *Example*: if a member joins on **March 15th** with a **Monthly Package**, their membership will end on **April 15th**.
- This ensures the member gets a full 30 days of access regardless of when they join in the month.

### 3. Automated Onboarding SMS
When you create a new trainee, the system now automatically sends a **Welcome SMS** if:
1.  The **Communication Preference** is set to "SMS" or "Both".
2.  The **Trainee Create** notification is enabled for SMS in settings.
3.  Your **Twilio Configuration** is complete.

This message is sent immediately upon the trainee's creation, using the phone number you provided.
