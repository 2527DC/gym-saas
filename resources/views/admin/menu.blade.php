@php
    $admin_logo = getSettingsValByName('company_logo');
    $theme_mode = getSettingsValByName('theme_mode');
    $light_logo = getSettingsValByName('light_logo');

    $ids = parentId();
    $authUser = \App\Models\User::find($ids);
    $subscription = \App\Models\Subscription::find($authUser->subscription);
    $routeName = \Request::route()->getName();
    $pricing_feature_settings = getSettingsValByIdName(1, 'pricing_feature');
@endphp
<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="#" class="b-brand text-primary">
                @if ($theme_mode == 'dark')
                    <img src="{{ asset(Storage::url('upload/logo/')) . '/' . (isset($light_logo) && !empty($light_logo) ? $light_logo : 'logo.png') }}"
                        alt="" class="logo logo-lg" />
                @else
                    <img src="{{ asset(Storage::url('upload/logo/')) . '/' . (isset($admin_logo) && !empty($admin_logo) ? $admin_logo : 'logo.png') }}"
                        alt="" class="logo logo-lg" />
                @endif

            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                <li class="pc-item pc-caption">
                    <label>{{ __('Home') }}</label>
                    <i class="ti ti-dashboard"></i>
                </li>
                <li class="pc-item {{ in_array($routeName, ['dashboard', 'home', '']) ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                        <span class="pc-mtext">{{ __('Dashboard') }}</span>
                    </a>
                </li>
                @if (\Auth::user()->type == 'super admin')
                    @if (Gate::check('manage user'))
                        <li class="pc-item {{ in_array($routeName, ['users.index', 'users.show']) ? 'active' : '' }}">
                            <a href="{{ route('users.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-user-plus"></i></span>
                                <span class="pc-mtext">{{ __('Customers') }}</span>
                            </a>
                        </li>
                    @endif
                @else
                    @if (Gate::check('manage user') || Gate::check('manage role') || Gate::check('manage logged history'))
                        <li
                            class="pc-item pc-hasmenu {{ in_array($routeName, ['users.index', 'logged.history', 'role.index', 'role.create', 'role.edit']) ? 'pc-trigger active' : '' }}">
                            <a href="#!" class="pc-link">
                                <span class="pc-micon">
                                    <i class="ti ti-users"></i>
                                </span>
                                <span class="pc-mtext">{{ __('Staff Management') }}</span>
                                <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                            </a>
                            <ul class="pc-submenu"
                                style="display: {{ in_array($routeName, ['users.index', 'logged.history', 'role.index', 'role.create', 'role.edit']) ? 'block' : 'none' }}">
                                @if (Gate::check('manage user'))
                                    <li class="pc-item {{ in_array($routeName, ['users.index']) ? 'active' : '' }}">
                                        <a class="pc-link" href="{{ route('users.index') }}">{{ __('Users') }}</a>
                                    </li>
                                @endif
                                @if (Gate::check('manage role'))
                                    <li
                                        class="pc-item  {{ in_array($routeName, ['role.index', 'role.create', 'role.edit']) ? 'active' : '' }}">
                                        <a class="pc-link" href="{{ route('role.index') }}">{{ __('Roles') }} </a>
                                    </li>
                                @endif
                                @if ($pricing_feature_settings == 'off' || $subscription->enabled_logged_history == 1)
                                    @if (Gate::check('manage logged history'))
                                        <li
                                            class="pc-item  {{ in_array($routeName, ['logged.history']) ? 'active' : '' }}">
                                            <a class="pc-link"
                                                href="{{ route('logged.history') }}">{{ __('Logged History') }}</a>
                                        </li>
                                    @endif
                                @endif
                            </ul>
                        </li>
                    @endif
                @endif
                @if (Gate::check('manage health trainer') ||
                        Gate::check('manage trainee') ||
                        Gate::check('manage health update') ||
                        Gate::check('manage workout') ||
                        Gate::check('manage today workout') ||
                        Gate::check('manage class') ||
                        Gate::check('manage membership') ||
                        Gate::check('manage attendance') ||
                        Gate::check('manage today attendance') ||
                        Gate::check('manage invoice') ||
                        Gate::check('manage expense') ||
                        Gate::check('manage nutrition schedule') ||
                        Gate::check('manage locker') ||
                        Gate::check('manage event') ||
                        Gate::check('manage product') ||
                        Gate::check('manage contact') ||
                        Gate::check('manage note'))
                    <li class="pc-item pc-caption">
                        <label>{{ __('Business Management') }}</label>
                        <i class="ti ti-chart-arcs"></i>
                    </li>
                    @if (Gate::check('manage trainer'))
                        <li
                            class="pc-item {{ in_array($routeName, ['trainers.index', 'trainers.show']) ? 'active' : '' }}">
                            <a href="{{ route('trainers.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-user-check"></i></span>
                                <span class="pc-mtext">{{ __('Trainers') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (Gate::check('manage trainee'))
                        <li
                            class="pc-item {{ in_array($routeName, ['trainees.index', 'trainees.show']) ? 'active' : '' }}">
                            <a href="{{ route('trainees.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-user"></i></span>
                                <span class="pc-mtext">{{ __('Trainees') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (Gate::check('manage class'))
                        <li
                            class="pc-item {{ in_array($routeName, ['classes.index', 'classes.show']) ? 'active' : '' }}">
                            <a href="{{ route('classes.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-calendar"></i></span>
                                <span class="pc-mtext">{{ __('Classes') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (Gate::check('manage membership'))
                        <li
                            class="pc-item {{ in_array($routeName, ['membership.index', 'membership.show']) ? 'active' : '' }}">
                            <a href="{{ route('membership.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-gift"></i></span>
                                <span class="pc-mtext">{{ __('Membership') }}</span>
                            </a>
                        </li>
                    @endif

                    @if (Gate::check('manage workout') || Gate::check('manage today workout'))
                        <li
                            class="pc-item pc-hasmenu {{ in_array($routeName, ['workouts.index', 'today.workout']) ? 'active' : '' }}">
                            <a href="#!" class="pc-link">
                                <span class="pc-micon">
                                    <i class="ti ti-award"></i>
                                </span>
                                <span class="pc-mtext">{{ __('Workouts') }}</span>
                                <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                            </a>
                            <ul class="pc-submenu"
                                style="display: {{ in_array($routeName, ['workouts.index', 'today.workout']) ? 'block' : 'none' }}">
                                @if (Gate::check('manage workout'))
                                    <li class="pc-item {{ in_array($routeName, ['workouts.index']) ? 'active' : '' }}">
                                        <a class="pc-link"
                                            href="{{ route('workouts.index') }}">{{ __('All Workout') }}</a>
                                    </li>
                                @endif
                                @if (Gate::check('manage today workout'))
                                    <li class="pc-item  {{ in_array($routeName, ['today.workout']) ? 'active' : '' }}">
                                        <a class="pc-link"
                                            href="{{ route('today.workout') }}">{{ __('Today Workout') }}
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    @if (Gate::check('manage health update'))
                        <li class="pc-item {{ in_array($routeName, ['health-update.index']) ? 'active' : '' }}">
                            <a href="{{ route('health-update.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-database"></i></span>
                                <span class="pc-mtext">{{ __('Health Update') }}</span>
                            </a>
                        </li>
                    @endif

                    @if (Gate::check('manage attendance') || Gate::check('manage today attendance'))
                        <li
                            class="pc-item pc-hasmenu {{ in_array($routeName, ['attendances.index', 'today.attendance']) ? 'pc-trigger active' : '' }}">
                            <a href="#!" class="pc-link">
                                <span class="pc-micon">
                                    <i class="ti ti-user-check"></i>
                                </span>
                                <span class="pc-mtext">{{ __('Attendances') }}</span>
                                <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                            </a>
                            <ul class="pc-submenu"
                                style="display: {{ in_array($routeName, ['attendances.index', 'today.attendance']) ? 'block' : 'none' }}">
                                @if (Gate::check('manage attendance'))
                                    <li
                                        class="pc-item {{ in_array($routeName, ['attendances.index']) ? 'active' : '' }}">
                                        <a class="pc-link"
                                            href="{{ route('attendances.index') }}">{{ __('All Attendance') }}</a>
                                    </li>
                                @endif
                                @if ('create bulk attendance')
                                    <li
                                        class="pc-item {{ in_array($routeName, ['bulk.attendance']) ? 'active' : '' }}">
                                        <a class="pc-link"
                                            href="{{ route('bulk.attendance') }}">{{ __('Bulk Attendance') }}</a>
                                    </li>
                                @endif
                                @if (Gate::check('manage today attendance'))
                                    <li
                                        class="pc-item  {{ in_array($routeName, ['today.attendance']) ? 'active' : '' }}">
                                        <a class="pc-link"
                                            href="{{ route('today.attendance') }}">{{ __('Today Attendance') }} </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    @if (Gate::check('manage invoice') || Gate::check('manage expense'))
                        <li
                            class="pc-item pc-hasmenu {{ in_array($routeName, ['invoices.index', 'invoices.edit', 'invoices.create', 'invoices.show', 'expense.index']) ? ' pc-trigger active' : '' }}">
                            <a href="#!" class="pc-link">
                                <span class="pc-micon">
                                    <i class="ti ti-credit-card"></i>
                                </span>
                                <span class="pc-mtext">{{ __('Finance') }}</span>
                                <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                            </a>
                            <ul class="pc-submenu"
                                style="display: {{ in_array($routeName, ['invoices.index', 'invoices.edit', 'invoices.create', 'invoices.show', 'expense.index']) ? 'block' : 'none' }}">
                                @if (Gate::check('manage invoice'))
                                    <li
                                        class="pc-item {{ in_array($routeName, ['invoices.index', 'invoices.create', 'invoices.show', 'invoices.edit']) ? 'active' : '' }}">
                                        <a class="pc-link"
                                            href="{{ route('invoices.index') }}">{{ __('All Invoice') }}</a>
                                    </li>
                                @endif
                                @if (Gate::check('manage expense'))
                                    <li
                                        class="pc-item  {{ in_array($routeName, ['expense.index']) ? 'active' : '' }}">
                                        <a class="pc-link" href="{{ route('expense.index') }}">{{ __('Expense') }}
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if (Gate::check('manage locker'))
                        <li class="pc-item {{ in_array($routeName, ['locker.index']) ? 'active' : '' }}">
                            <a href="{{ route('locker.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-lock"></i></span>
                                <span class="pc-mtext">{{ __('Locker') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (Gate::check('manage event'))
                        <li class="pc-item {{ in_array($routeName, ['event.index']) ? 'active' : '' }}">
                            <a href="{{ route('event.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-calendar-event"></i></span>
                                <span class="pc-mtext">{{ __('Event') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (Gate::check('manage nutrition schedule'))
                        <li class="pc-item {{ in_array($routeName, ['nutrition-schedule.index']) ? 'active' : '' }}">
                            <a href="{{ route('nutrition-schedule.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-calendar-time"></i></span>
                                <span class="pc-mtext">{{ __('Nutrition Schedule') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (Gate::check('manage product'))
                        <li
                            class="pc-item pc-hasmenu {{ in_array($routeName, ['invoices.index']) ? ' pc-trigger active' : '' }}">
                            <a href="#!" class="pc-link">
                                <span class="pc-micon">
                                    <i class="ti ti-brand-producthunt"></i>
                                </span>
                                <span class="pc-mtext">{{ __('Product Management') }}</span>
                                <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                            </a>
                            <ul class="pc-submenu"
                                style="display: {{ in_array($routeName, ['product.index']) ? 'block' : 'none' }}">
                                @if (Gate::check('manage product'))
                                    <li class="pc-item {{ in_array($routeName, ['product.index']) ? 'active' : '' }}">
                                        <a class="pc-link"
                                            href="{{ route('product.index') }}">{{ __('Product') }}</a>
                                    </li>
                                @endif
                                <li
                                    class="pc-item {{ in_array($routeName, ['product-booking.index']) ? 'active' : '' }}">
                                    <a class="pc-link"
                                        href="{{ route('product-booking.index') }}">{{ __('Product Booking') }}</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if (Gate::check('manage contact'))
                        <li class="pc-item {{ in_array($routeName, ['contact.index']) ? 'active' : '' }}">
                            <a href="{{ route('contact.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-phone-call"></i></span>
                                <span class="pc-mtext">{{ __('Contact Diary') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (Gate::check('manage note'))
                        <li class="pc-item {{ in_array($routeName, ['note.index']) ? 'active' : '' }} ">
                            <a href="{{ route('note.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-notebook"></i></span>
                                <span class="pc-mtext">{{ __('Notice Board') }}</span>
                            </a>
                        </li>
                    @endif

                @endif


                @if (Gate::check('manage category') ||
                        Gate::check('manage workout activity') ||
                        Gate::check('manage finance type') ||
                        Gate::check('manage notification'))
                    <li class="pc-item pc-caption">
                        <label>{{ __('System Configuration') }}</label>
                        <i class="ti ti-chart-arcs"></i>
                    </li>

                    @if (Gate::check('manage category'))
                        <li class="pc-item {{ in_array($routeName, ['category.index']) ? 'active' : '' }} ">
                            <a href="{{ route('category.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-book"></i></span>
                                <span class="pc-mtext">{{ __('Category') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (Gate::check('manage workout activity'))
                        <li class="pc-item {{ in_array($routeName, ['activity.index']) ? 'active' : '' }} ">
                            <a href="{{ route('activity.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-layout"></i></span>
                                <span class="pc-mtext">{{ __('Workout Activity') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (Gate::check('manage finance type'))
                        <li class="pc-item {{ in_array($routeName, ['types.index']) ? 'active' : '' }} ">
                            <a href="{{ route('types.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-list"></i></span>
                                <span class="pc-mtext">{{ __('Finance Type') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (Gate::check('manage event type'))
                        <li class="pc-item {{ in_array($routeName, ['event-type.index']) ? 'active' : '' }} ">
                            <a href="{{ route('event-type.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-clipboard-list"></i></span>
                                <span class="pc-mtext">{{ __('Event Type') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (Gate::check('manage notification'))
                        <li class="pc-item {{ in_array($routeName, ['notification.index']) ? 'active' : '' }} ">
                            <a href="{{ route('notification.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-bell"></i></span>
                                <span class="pc-mtext">{{ __('Email Notification') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (Gate::check('manage FAQ'))
                        <li class="pc-item {{ in_array($routeName, ['FAQ.index']) ? 'active' : '' }} ">
                            <a href="{{ route('FAQ.index') }}" class="pc-link">
                                <span class="pc-micon"><i data-feather="message-square"> </i></span>
                                <span class="pc-mtext">{{ __('FAQ') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (Gate::check('manage Page'))
                        <li class="pc-item {{ in_array($routeName, ['pages.index']) ? 'active' : '' }} ">
                            <a href="{{ route('pages.index') }}" class="pc-link">
                                <span class="pc-micon"><i data-feather="file"> </i></span>
                                <span class="pc-mtext">{{ __('Page') }}</span>
                            </a>
                        </li>
                    @endif
                @endif


                @if (Gate::check('manage pricing packages') ||
                        Gate::check('manage pricing transation') ||
                        Gate::check('manage account settings') ||
                        Gate::check('manage password settings') ||
                        Gate::check('manage general settings') ||
                        Gate::check('manage email settings') ||
                        Gate::check('manage payment settings') ||
                        Gate::check('manage company settings') ||
                        Gate::check('manage seo settings') ||
                        Gate::check('manage google recaptcha settings'))
                    <li class="pc-item pc-caption">
                        <label>{{ __('System Settings') }}</label>
                        <i class="ti ti-chart-arcs"></i>
                    </li>

                    @if (Gate::check('manage FAQ') || Gate::check('manage Page'))
                        <li
                            class="pc-item pc-hasmenu {{ in_array($routeName, ['homepage.index', 'FAQ.index', 'pages.index', 'footerSetting']) ? 'active' : '' }}">
                            <a href="#!" class="pc-link">
                                <span class="pc-micon">
                                    <i class="ti ti-layout-rows"></i>
                                </span>
                                <span class="pc-mtext">{{ __('CMS') }}</span>
                                <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                            </a>
                            <ul class="pc-submenu"
                                style="display: {{ in_array($routeName, ['homepage.index', 'FAQ.index', 'pages.index', 'footerSetting']) ? 'block' : 'none' }}">
                                @if (Gate::check('manage home page'))
                                    <li
                                        class="pc-item {{ in_array($routeName, ['homepage.index']) ? 'active' : '' }} ">
                                        <a href="{{ route('homepage.index') }}"
                                            class="pc-link">{{ __('Home Page') }}</a>
                                    </li>
                                @endif
                                @if (Gate::check('manage Page'))
                                    <li class="pc-item {{ in_array($routeName, ['pages.index']) ? 'active' : '' }} ">
                                        <a href="{{ route('pages.index') }}"
                                            class="pc-link">{{ __('Custom Page') }}</a>
                                    </li>
                                @endif
                                @if (Gate::check('manage FAQ'))
                                    <li class="pc-item {{ in_array($routeName, ['FAQ.index']) ? 'active' : '' }} ">
                                        <a href="{{ route('FAQ.index') }}" class="pc-link">{{ __('FAQ') }}</a>
                                    </li>
                                @endif
                                @if (Gate::check('manage footer'))
                                    <li
                                        class="pc-item {{ in_array($routeName, ['footerSetting']) ? 'active' : '' }} ">
                                        <a href="{{ route('footerSetting') }}"
                                            class="pc-link">{{ __('Footer') }}</a>
                                    </li>
                                @endif
                                @if (Gate::check('manage auth page'))
                                    <li
                                        class="pc-item {{ in_array($routeName, ['authPage.index']) ? 'active' : '' }} ">
                                        <a href="{{ route('authPage.index') }}"
                                            class="pc-link">{{ __('Auth Page') }}</a>
                                    </li>
                                @endif

                            </ul>
                        </li>
                    @endif
                    @if (Auth::user()->type == 'super admin' || $pricing_feature_settings == 'on')
                        @if (Gate::check('manage pricing packages') || Gate::check('manage pricing transation'))
                            <li
                                class="pc-item pc-hasmenu {{ in_array($routeName, ['subscriptions.index', 'subscriptions.show', 'subscription.transaction']) ? 'active' : '' }}">
                                <a href="#!" class="pc-link">
                                    <span class="pc-micon">
                                        <i class="ti ti-package"></i>
                                    </span>
                                    <span class="pc-mtext">{{ __('Pricing') }}</span>
                                    <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                                </a>
                                <ul class="pc-submenu"
                                    style="display: {{ in_array($routeName, ['subscriptions.index', 'subscriptions.show', 'subscription.transaction']) ? 'block' : 'none' }}">
                                    @if (Gate::check('manage pricing packages'))
                                        <li
                                            class="pc-item {{ in_array($routeName, ['subscriptions.index', 'subscriptions.show']) ? 'active' : '' }}">
                                            <a class="pc-link"
                                                href="{{ route('subscriptions.index') }}">{{ __('Packages') }}</a>
                                        </li>
                                    @endif
                                    @if (Gate::check('manage pricing transation'))
                                        <li
                                            class="pc-item {{ in_array($routeName, ['subscription.transaction']) ? 'active' : '' }}">
                                            <a class="pc-link"
                                                href="{{ route('subscription.transaction') }}">{{ __('Transactions') }}</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                    @endif
                    @if (Gate::check('manage coupon') || Gate::check('manage coupon history'))
                        <li
                            class="pc-item pc-hasmenu {{ in_array($routeName, ['coupons.index', 'coupons.history']) ? 'active' : '' }}">
                            <a href="#!" class="pc-link">
                                <span class="pc-micon">
                                    <i class="ti ti-shopping-cart-discount"></i>
                                </span>
                                <span class="pc-mtext">{{ __('Coupons') }}</span>
                                <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                            </a>
                            <ul class="pc-submenu"
                                style="display: {{ in_array($routeName, ['coupons.index', 'coupons.history']) ? 'block' : 'none' }}">
                                @if (Gate::check('manage coupon'))
                                    <li
                                        class="pc-item {{ in_array($routeName, ['coupons.index']) ? 'active' : '' }}">
                                        <a class="pc-link"
                                            href="{{ route('coupons.index') }}">{{ __('All Coupon') }}</a>
                                    </li>
                                @endif
                                @if (Gate::check('manage coupon history'))
                                    <li
                                        class="pc-item {{ in_array($routeName, ['coupons.history']) ? 'active' : '' }}">
                                        <a class="pc-link"
                                            href="{{ route('coupons.history') }}">{{ __('Coupon History') }}</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if (Gate::check('manage account settings') ||
                            Gate::check('manage password settings') ||
                            Gate::check('manage general settings') ||
                            Gate::check('manage email settings') ||
                            Gate::check('manage payment settings') ||
                            Gate::check('manage company settings') ||
                            Gate::check('manage seo settings') ||
                            Gate::check('manage google recaptcha settings'))
                        <li class="pc-item {{ in_array($routeName, ['setting.index']) ? 'active' : '' }} ">
                            <a href="{{ route('setting.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-settings"></i></span>
                                <span class="pc-mtext">{{ __('Settings') }}</span>
                            </a>
                        </li>
                    @endif

                @endif
            </ul>
            <div class="w-100 text-center">
                <div class="badge theme-version badge rounded-pill bg-light text-dark f-12"></div>
            </div>
        </div>
    </div>
</nav>
