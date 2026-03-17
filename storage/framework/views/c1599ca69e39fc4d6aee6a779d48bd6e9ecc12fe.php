<?php
    $admin_logo = getSettingsValByName('company_logo');
    $theme_mode = getSettingsValByName('theme_mode');
    $light_logo = getSettingsValByName('light_logo');

    $ids = parentId();
    $authUser = \App\Models\User::find($ids);
    $subscription = \App\Models\Subscription::find($authUser->subscription);
    $routeName = \Request::route()->getName();
    $pricing_feature_settings = getSettingsValByIdName(1, 'pricing_feature');
?>
<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="#" class="b-brand text-primary">
                <?php if($theme_mode == 'dark'): ?>
                    <img src="<?php echo e(asset(Storage::url('upload/logo/')) . '/' . (isset($light_logo) && !empty($light_logo) ? $light_logo : 'logo.png')); ?>"
                        alt="" class="logo logo-lg" />
                <?php else: ?>
                    <img src="<?php echo e(asset(Storage::url('upload/logo/')) . '/' . (isset($admin_logo) && !empty($admin_logo) ? $admin_logo : 'logo.png')); ?>"
                        alt="" class="logo logo-lg" />
                <?php endif; ?>

            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                <li class="pc-item pc-caption">
                    <label><?php echo e(__('Home')); ?></label>
                    <i class="ti ti-dashboard"></i>
                </li>
                <li class="pc-item <?php echo e(in_array($routeName, ['dashboard', 'home', '']) ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('dashboard')); ?>" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                        <span class="pc-mtext"><?php echo e(__('Dashboard')); ?></span>
                    </a>
                </li>
                <?php if(\Auth::user()->type == 'super admin'): ?>
                    <?php if(Gate::check('manage user')): ?>
                        <li class="pc-item <?php echo e(in_array($routeName, ['users.index', 'users.show']) ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('users.index')); ?>" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-user-plus"></i></span>
                                <span class="pc-mtext"><?php echo e(__('Customers')); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php else: ?>
                    <?php if(Gate::check('manage user') || Gate::check('manage role') || Gate::check('manage logged history')): ?>
                        <li
                            class="pc-item pc-hasmenu <?php echo e(in_array($routeName, ['users.index', 'logged.history', 'role.index', 'role.create', 'role.edit']) ? 'pc-trigger active' : ''); ?>">
                            <a href="#!" class="pc-link">
                                <span class="pc-micon">
                                    <i class="ti ti-users"></i>
                                </span>
                                <span class="pc-mtext"><?php echo e(__('Staff Management')); ?></span>
                                <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                            </a>
                            <ul class="pc-submenu"
                                style="display: <?php echo e(in_array($routeName, ['users.index', 'logged.history', 'role.index', 'role.create', 'role.edit']) ? 'block' : 'none'); ?>">
                                <?php if(Gate::check('manage user')): ?>
                                    <li class="pc-item <?php echo e(in_array($routeName, ['users.index']) ? 'active' : ''); ?>">
                                        <a class="pc-link" href="<?php echo e(route('users.index')); ?>"><?php echo e(__('Users')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if(Gate::check('manage role')): ?>
                                    <li
                                        class="pc-item  <?php echo e(in_array($routeName, ['role.index', 'role.create', 'role.edit']) ? 'active' : ''); ?>">
                                        <a class="pc-link" href="<?php echo e(route('role.index')); ?>"><?php echo e(__('Roles')); ?> </a>
                                    </li>
                                <?php endif; ?>
                                <?php if($pricing_feature_settings == 'off' || $subscription->enabled_logged_history == 1): ?>
                                    <?php if(Gate::check('manage logged history')): ?>
                                        <li
                                            class="pc-item  <?php echo e(in_array($routeName, ['logged.history']) ? 'active' : ''); ?>">
                                            <a class="pc-link"
                                                href="<?php echo e(route('logged.history')); ?>"><?php echo e(__('Logged History')); ?></a>
                                        </li>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if(Gate::check('manage health trainer') ||
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
                        Gate::check('manage note')): ?>
                    <li class="pc-item pc-caption">
                        <label><?php echo e(__('Business Management')); ?></label>
                        <i class="ti ti-chart-arcs"></i>
                    </li>
                    <?php if(Gate::check('manage trainer')): ?>
                        <li
                            class="pc-item <?php echo e(in_array($routeName, ['trainers.index', 'trainers.show']) ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('trainers.index')); ?>" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-user-check"></i></span>
                                <span class="pc-mtext"><?php echo e(__('Trainers')); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if(Gate::check('manage trainee')): ?>
                        <li
                            class="pc-item <?php echo e(in_array($routeName, ['trainees.index', 'trainees.show']) ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('trainees.index')); ?>" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-user"></i></span>
                                <span class="pc-mtext"><?php echo e(__('Trainees')); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if(Gate::check('manage class')): ?>
                        <li
                            class="pc-item <?php echo e(in_array($routeName, ['classes.index', 'classes.show']) ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('classes.index')); ?>" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-calendar"></i></span>
                                <span class="pc-mtext"><?php echo e(__('Classes')); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if(Gate::check('manage membership')): ?>
                        <li
                            class="pc-item <?php echo e(in_array($routeName, ['membership.index', 'membership.show']) ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('membership.index')); ?>" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-gift"></i></span>
                                <span class="pc-mtext"><?php echo e(__('Membership')); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if(Gate::check('manage workout') || Gate::check('manage today workout')): ?>
                        <li
                            class="pc-item pc-hasmenu <?php echo e(in_array($routeName, ['workouts.index', 'today.workout']) ? 'active' : ''); ?>">
                            <a href="#!" class="pc-link">
                                <span class="pc-micon">
                                    <i class="ti ti-award"></i>
                                </span>
                                <span class="pc-mtext"><?php echo e(__('Workouts')); ?></span>
                                <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                            </a>
                            <ul class="pc-submenu"
                                style="display: <?php echo e(in_array($routeName, ['workouts.index', 'today.workout']) ? 'block' : 'none'); ?>">
                                <?php if(Gate::check('manage workout')): ?>
                                    <li class="pc-item <?php echo e(in_array($routeName, ['workouts.index']) ? 'active' : ''); ?>">
                                        <a class="pc-link"
                                            href="<?php echo e(route('workouts.index')); ?>"><?php echo e(__('All Workout')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if(Gate::check('manage today workout')): ?>
                                    <li class="pc-item  <?php echo e(in_array($routeName, ['today.workout']) ? 'active' : ''); ?>">
                                        <a class="pc-link"
                                            href="<?php echo e(route('today.workout')); ?>"><?php echo e(__('Today Workout')); ?>

                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if(Gate::check('manage health update')): ?>
                        <li class="pc-item <?php echo e(in_array($routeName, ['health-update.index']) ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('health-update.index')); ?>" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-database"></i></span>
                                <span class="pc-mtext"><?php echo e(__('Health Update')); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if(Gate::check('manage attendance') || Gate::check('manage today attendance')): ?>
                        <li
                            class="pc-item pc-hasmenu <?php echo e(in_array($routeName, ['attendances.index', 'today.attendance']) ? 'pc-trigger active' : ''); ?>">
                            <a href="#!" class="pc-link">
                                <span class="pc-micon">
                                    <i class="ti ti-user-check"></i>
                                </span>
                                <span class="pc-mtext"><?php echo e(__('Attendances')); ?></span>
                                <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                            </a>
                            <ul class="pc-submenu"
                                style="display: <?php echo e(in_array($routeName, ['attendances.index', 'today.attendance']) ? 'block' : 'none'); ?>">
                                <?php if(Gate::check('manage attendance')): ?>
                                    <li
                                        class="pc-item <?php echo e(in_array($routeName, ['attendances.index']) ? 'active' : ''); ?>">
                                        <a class="pc-link"
                                            href="<?php echo e(route('attendances.index')); ?>"><?php echo e(__('All Attendance')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if('create bulk attendance'): ?>
                                    <li
                                        class="pc-item <?php echo e(in_array($routeName, ['bulk.attendance']) ? 'active' : ''); ?>">
                                        <a class="pc-link"
                                            href="<?php echo e(route('bulk.attendance')); ?>"><?php echo e(__('Bulk Attendance')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if(Gate::check('manage today attendance')): ?>
                                    <li
                                        class="pc-item  <?php echo e(in_array($routeName, ['today.attendance']) ? 'active' : ''); ?>">
                                        <a class="pc-link"
                                            href="<?php echo e(route('today.attendance')); ?>"><?php echo e(__('Today Attendance')); ?> </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if(Gate::check('manage invoice') || Gate::check('manage expense')): ?>
                        <li
                            class="pc-item pc-hasmenu <?php echo e(in_array($routeName, ['invoices.index', 'invoices.edit', 'invoices.create', 'invoices.show', 'expense.index']) ? ' pc-trigger active' : ''); ?>">
                            <a href="#!" class="pc-link">
                                <span class="pc-micon">
                                    <i class="ti ti-credit-card"></i>
                                </span>
                                <span class="pc-mtext"><?php echo e(__('Finance')); ?></span>
                                <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                            </a>
                            <ul class="pc-submenu"
                                style="display: <?php echo e(in_array($routeName, ['invoices.index', 'invoices.edit', 'invoices.create', 'invoices.show', 'expense.index']) ? 'block' : 'none'); ?>">
                                <?php if(Gate::check('manage invoice')): ?>
                                    <li
                                        class="pc-item <?php echo e(in_array($routeName, ['invoices.index', 'invoices.create', 'invoices.show', 'invoices.edit']) ? 'active' : ''); ?>">
                                        <a class="pc-link"
                                            href="<?php echo e(route('invoices.index')); ?>"><?php echo e(__('All Invoice')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if(Gate::check('manage expense')): ?>
                                    <li
                                        class="pc-item  <?php echo e(in_array($routeName, ['expense.index']) ? 'active' : ''); ?>">
                                        <a class="pc-link" href="<?php echo e(route('expense.index')); ?>"><?php echo e(__('Expense')); ?>

                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <?php if(Gate::check('manage locker')): ?>
                        <li class="pc-item <?php echo e(in_array($routeName, ['locker.index']) ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('locker.index')); ?>" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-lock"></i></span>
                                <span class="pc-mtext"><?php echo e(__('Locker')); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if(Gate::check('manage event')): ?>
                        <li class="pc-item <?php echo e(in_array($routeName, ['event.index']) ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('event.index')); ?>" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-calendar-event"></i></span>
                                <span class="pc-mtext"><?php echo e(__('Event')); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if(Gate::check('manage nutrition schedule')): ?>
                        <li class="pc-item <?php echo e(in_array($routeName, ['nutrition-schedule.index']) ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('nutrition-schedule.index')); ?>" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-calendar-time"></i></span>
                                <span class="pc-mtext"><?php echo e(__('Nutrition Schedule')); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if(Gate::check('manage product')): ?>
                        <li
                            class="pc-item pc-hasmenu <?php echo e(in_array($routeName, ['invoices.index']) ? ' pc-trigger active' : ''); ?>">
                            <a href="#!" class="pc-link">
                                <span class="pc-micon">
                                    <i class="ti ti-brand-producthunt"></i>
                                </span>
                                <span class="pc-mtext"><?php echo e(__('Product Management')); ?></span>
                                <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                            </a>
                            <ul class="pc-submenu"
                                style="display: <?php echo e(in_array($routeName, ['product.index']) ? 'block' : 'none'); ?>">
                                <?php if(Gate::check('manage product')): ?>
                                    <li class="pc-item <?php echo e(in_array($routeName, ['product.index']) ? 'active' : ''); ?>">
                                        <a class="pc-link"
                                            href="<?php echo e(route('product.index')); ?>"><?php echo e(__('Product')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <li
                                    class="pc-item <?php echo e(in_array($routeName, ['product-booking.index']) ? 'active' : ''); ?>">
                                    <a class="pc-link"
                                        href="<?php echo e(route('product-booking.index')); ?>"><?php echo e(__('Product Booking')); ?></a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <?php if(Gate::check('manage contact')): ?>
                        <li class="pc-item <?php echo e(in_array($routeName, ['contact.index']) ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('contact.index')); ?>" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-phone-call"></i></span>
                                <span class="pc-mtext"><?php echo e(__('Contact Diary')); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if(Gate::check('manage note')): ?>
                        <li class="pc-item <?php echo e(in_array($routeName, ['note.index']) ? 'active' : ''); ?> ">
                            <a href="<?php echo e(route('note.index')); ?>" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-notebook"></i></span>
                                <span class="pc-mtext"><?php echo e(__('Notice Board')); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>

                <?php endif; ?>


                <?php if(Gate::check('manage category') ||
                        Gate::check('manage workout activity') ||
                        Gate::check('manage finance type') ||
                        Gate::check('manage notification')): ?>
                    <li class="pc-item pc-caption">
                        <label><?php echo e(__('System Configuration')); ?></label>
                        <i class="ti ti-chart-arcs"></i>
                    </li>

                    <?php if(Gate::check('manage category')): ?>
                        <li class="pc-item <?php echo e(in_array($routeName, ['category.index']) ? 'active' : ''); ?> ">
                            <a href="<?php echo e(route('category.index')); ?>" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-book"></i></span>
                                <span class="pc-mtext"><?php echo e(__('Category')); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if(Gate::check('manage workout activity')): ?>
                        <li class="pc-item <?php echo e(in_array($routeName, ['activity.index']) ? 'active' : ''); ?> ">
                            <a href="<?php echo e(route('activity.index')); ?>" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-layout"></i></span>
                                <span class="pc-mtext"><?php echo e(__('Workout Activity')); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if(Gate::check('manage finance type')): ?>
                        <li class="pc-item <?php echo e(in_array($routeName, ['types.index']) ? 'active' : ''); ?> ">
                            <a href="<?php echo e(route('types.index')); ?>" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-list"></i></span>
                                <span class="pc-mtext"><?php echo e(__('Finance Type')); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if(Gate::check('manage event type')): ?>
                        <li class="pc-item <?php echo e(in_array($routeName, ['event-type.index']) ? 'active' : ''); ?> ">
                            <a href="<?php echo e(route('event-type.index')); ?>" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-clipboard-list"></i></span>
                                <span class="pc-mtext"><?php echo e(__('Event Type')); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if(Gate::check('manage notification')): ?>
                        <li class="pc-item <?php echo e(in_array($routeName, ['notification.index']) ? 'active' : ''); ?> ">
                            <a href="<?php echo e(route('notification.index')); ?>" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-bell"></i></span>
                                <span class="pc-mtext"><?php echo e(__('Email Notification')); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if(Gate::check('manage FAQ')): ?>
                        <li class="pc-item <?php echo e(in_array($routeName, ['FAQ.index']) ? 'active' : ''); ?> ">
                            <a href="<?php echo e(route('FAQ.index')); ?>" class="pc-link">
                                <span class="pc-micon"><i data-feather="message-square"> </i></span>
                                <span class="pc-mtext"><?php echo e(__('FAQ')); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if(Gate::check('manage Page')): ?>
                        <li class="pc-item <?php echo e(in_array($routeName, ['pages.index']) ? 'active' : ''); ?> ">
                            <a href="<?php echo e(route('pages.index')); ?>" class="pc-link">
                                <span class="pc-micon"><i data-feather="file"> </i></span>
                                <span class="pc-mtext"><?php echo e(__('Page')); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>


                <?php if(Gate::check('manage pricing packages') ||
                        Gate::check('manage pricing transation') ||
                        Gate::check('manage account settings') ||
                        Gate::check('manage password settings') ||
                        Gate::check('manage general settings') ||
                        Gate::check('manage email settings') ||
                        Gate::check('manage payment settings') ||
                        Gate::check('manage company settings') ||
                        Gate::check('manage seo settings') ||
                        Gate::check('manage google recaptcha settings')): ?>
                    <li class="pc-item pc-caption">
                        <label><?php echo e(__('System Settings')); ?></label>
                        <i class="ti ti-chart-arcs"></i>
                    </li>

                    <?php if(Gate::check('manage FAQ') || Gate::check('manage Page')): ?>
                        <li
                            class="pc-item pc-hasmenu <?php echo e(in_array($routeName, ['homepage.index', 'FAQ.index', 'pages.index', 'footerSetting']) ? 'active' : ''); ?>">
                            <a href="#!" class="pc-link">
                                <span class="pc-micon">
                                    <i class="ti ti-layout-rows"></i>
                                </span>
                                <span class="pc-mtext"><?php echo e(__('CMS')); ?></span>
                                <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                            </a>
                            <ul class="pc-submenu"
                                style="display: <?php echo e(in_array($routeName, ['homepage.index', 'FAQ.index', 'pages.index', 'footerSetting']) ? 'block' : 'none'); ?>">
                                <?php if(Gate::check('manage home page')): ?>
                                    <li
                                        class="pc-item <?php echo e(in_array($routeName, ['homepage.index']) ? 'active' : ''); ?> ">
                                        <a href="<?php echo e(route('homepage.index')); ?>"
                                            class="pc-link"><?php echo e(__('Home Page')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if(Gate::check('manage Page')): ?>
                                    <li class="pc-item <?php echo e(in_array($routeName, ['pages.index']) ? 'active' : ''); ?> ">
                                        <a href="<?php echo e(route('pages.index')); ?>"
                                            class="pc-link"><?php echo e(__('Custom Page')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if(Gate::check('manage FAQ')): ?>
                                    <li class="pc-item <?php echo e(in_array($routeName, ['FAQ.index']) ? 'active' : ''); ?> ">
                                        <a href="<?php echo e(route('FAQ.index')); ?>" class="pc-link"><?php echo e(__('FAQ')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if(Gate::check('manage footer')): ?>
                                    <li
                                        class="pc-item <?php echo e(in_array($routeName, ['footerSetting']) ? 'active' : ''); ?> ">
                                        <a href="<?php echo e(route('footerSetting')); ?>"
                                            class="pc-link"><?php echo e(__('Footer')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if(Gate::check('manage auth page')): ?>
                                    <li
                                        class="pc-item <?php echo e(in_array($routeName, ['authPage.index']) ? 'active' : ''); ?> ">
                                        <a href="<?php echo e(route('authPage.index')); ?>"
                                            class="pc-link"><?php echo e(__('Auth Page')); ?></a>
                                    </li>
                                <?php endif; ?>

                            </ul>
                        </li>
                    <?php endif; ?>
                    <?php if(Auth::user()->type == 'super admin' || $pricing_feature_settings == 'on'): ?>
                        <?php if(Gate::check('manage pricing packages') || Gate::check('manage pricing transation')): ?>
                            <li
                                class="pc-item pc-hasmenu <?php echo e(in_array($routeName, ['subscriptions.index', 'subscriptions.show', 'subscription.transaction']) ? 'active' : ''); ?>">
                                <a href="#!" class="pc-link">
                                    <span class="pc-micon">
                                        <i class="ti ti-package"></i>
                                    </span>
                                    <span class="pc-mtext"><?php echo e(__('Pricing')); ?></span>
                                    <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                                </a>
                                <ul class="pc-submenu"
                                    style="display: <?php echo e(in_array($routeName, ['subscriptions.index', 'subscriptions.show', 'subscription.transaction']) ? 'block' : 'none'); ?>">
                                    <?php if(Gate::check('manage pricing packages')): ?>
                                        <li
                                            class="pc-item <?php echo e(in_array($routeName, ['subscriptions.index', 'subscriptions.show']) ? 'active' : ''); ?>">
                                            <a class="pc-link"
                                                href="<?php echo e(route('subscriptions.index')); ?>"><?php echo e(__('Packages')); ?></a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if(Gate::check('manage pricing transation')): ?>
                                        <li
                                            class="pc-item <?php echo e(in_array($routeName, ['subscription.transaction']) ? 'active' : ''); ?>">
                                            <a class="pc-link"
                                                href="<?php echo e(route('subscription.transaction')); ?>"><?php echo e(__('Transactions')); ?></a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if(Gate::check('manage coupon') || Gate::check('manage coupon history')): ?>
                        <li
                            class="pc-item pc-hasmenu <?php echo e(in_array($routeName, ['coupons.index', 'coupons.history']) ? 'active' : ''); ?>">
                            <a href="#!" class="pc-link">
                                <span class="pc-micon">
                                    <i class="ti ti-shopping-cart-discount"></i>
                                </span>
                                <span class="pc-mtext"><?php echo e(__('Coupons')); ?></span>
                                <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                            </a>
                            <ul class="pc-submenu"
                                style="display: <?php echo e(in_array($routeName, ['coupons.index', 'coupons.history']) ? 'block' : 'none'); ?>">
                                <?php if(Gate::check('manage coupon')): ?>
                                    <li
                                        class="pc-item <?php echo e(in_array($routeName, ['coupons.index']) ? 'active' : ''); ?>">
                                        <a class="pc-link"
                                            href="<?php echo e(route('coupons.index')); ?>"><?php echo e(__('All Coupon')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if(Gate::check('manage coupon history')): ?>
                                    <li
                                        class="pc-item <?php echo e(in_array($routeName, ['coupons.history']) ? 'active' : ''); ?>">
                                        <a class="pc-link"
                                            href="<?php echo e(route('coupons.history')); ?>"><?php echo e(__('Coupon History')); ?></a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <?php if(Gate::check('manage account settings') ||
                            Gate::check('manage password settings') ||
                            Gate::check('manage general settings') ||
                            Gate::check('manage email settings') ||
                            Gate::check('manage payment settings') ||
                            Gate::check('manage company settings') ||
                            Gate::check('manage seo settings') ||
                            Gate::check('manage google recaptcha settings')): ?>
                        <li class="pc-item <?php echo e(in_array($routeName, ['setting.index']) ? 'active' : ''); ?> ">
                            <a href="<?php echo e(route('setting.index')); ?>" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-settings"></i></span>
                                <span class="pc-mtext"><?php echo e(__('Settings')); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>

                <?php endif; ?>
            </ul>
            <div class="w-100 text-center">
                <div class="badge theme-version badge rounded-pill bg-light text-dark f-12"></div>
            </div>
        </div>
    </div>
</nav>
<?php /**PATH /Users/admin/Downloads/gym software/resources/views/admin/menu.blade.php ENDPATH**/ ?>