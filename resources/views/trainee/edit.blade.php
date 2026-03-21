@extends('layouts.app')
@section('page-title')
    {{ __('Business') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('trainees.index') }}">{{ __('Trainees') }}</a></li>
    <li class="breadcrumb-item" aria-current="Edit"> {{ __('Edit') }}</li>
@endsection

@push('script-page')
    <script>
        const totalTabs = $(".nav-pills li").length;

        function updateProgressBar() {
            const currentIndex = $(".nav-pills li a.active").closest('li').index() + 1;
            const percent = (currentIndex / totalTabs) * 100;
            $(".bar").css("width", percent + "%");
            if (currentIndex === totalTabs) {
                $(".next").hide();
            } else {
                $(".next").show();
            }
        }

        updateProgressBar();

        function showError(element, message) {
            const $element = $(element);
            const $parent = $element.closest('.mb-3');
            $parent.find('.error-message').remove();
            $parent.append(`<span class="error-message text-danger" style="font-size: 0.875rem;">${message}</span>`);
            if ($element.hasClass('select2-hidden-accessible')) {
                $element.next('.select2-container').find('.select2-selection').css('border', '1px solid red');
            } else {
                $element.css('border', '1px solid red');
            }
        }

        function clearError(element) {
            const $element = $(element);
            const $parent = $element.closest('.mb-3');
            $parent.find('.error-message').remove();
            if ($element.hasClass('select2-hidden-accessible')) {
                $element.next('.select2-container').find('.select2-selection').css('border', '');
            } else {
                $element.css('border', '');
            }
        }

        function validateElement(element) {
            const $element = $(element);
            let isValid = true;
            let errorMessage = 'This field is required';

            if (!element.checkValidity()) {
                isValid = false;
            } else {
                if ($element.attr('name') === 'email') {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test($element.val())) {
                        isValid = false;
                        errorMessage = 'Please enter a valid email address';
                    }
                } else if ($element.attr('name') === 'phone_number') {
                    const phoneRegex = /^\d{10,15}$/;
                    if (!phoneRegex.test($element.val())) {
                        isValid = false;
                        errorMessage = 'Please enter a valid phone number (10-15 digits)';
                    }
                } else if ($element.attr('name') === 'dob') {
                    const dob = new Date($element.val());
                    const today = new Date();
                    if (dob >= today) {
                        isValid = false;
                        errorMessage = 'Date of birth must be in the past';
                    }
                }
            }

            if (!isValid) {
                showError(element, errorMessage);
            } else {
                clearError(element);
            }
            return isValid;
        }

        function validateTab(tabId) {
            const currentTab = $(`#${tabId}`);
            const inputs = currentTab.find("input[required], select[required], textarea[required]");
            let valid = true;

            inputs.each(function() {
                if (!validateElement(this)) {
                    valid = false;
                }
            });
            return valid;
        }

        $('input[required], select[required].select2, textarea[required]').on('input change keyup', function() {
            validateElement(this);
        });

        $('input[type="file"]').on('change', function() {
            const $element = $(this);
            const file = this.files[0];
            if (file) {
                const validTypes = $element.attr('accept').split(',');
                const fileType = file.type;
                if (!validTypes.some(type => fileType.includes(type.replace('.', '')))) {
                    showError(this, `Invalid file type. Allowed types: ${$element.attr('accept')}`);
                    $element.val('');
                } else if (file.size > 5 * 1024 * 1024) { // 5MB limit
                    showError(this, 'File size must be less than 5MB');
                    $element.val('');
                } else {
                    clearError(this);
                }
            }
        });

        $(".next a").click(function(e) {
            e.preventDefault();
            const currentTab = $(".tab-pane.active");
            if (validateTab(currentTab.attr('id'))) {
                const nextTabLink = $(".nav-pills .nav-link.active").closest('li').next().find("a");
                if (nextTabLink.length) {
                    nextTabLink.tab('show');
                    updateProgressBar();
                }
            }
        });

        $(".previous a").click(function(e) {
            e.preventDefault();
            const prevTabLink = $(".nav-pills .nav-link.active").closest('li').prev().find("a");
            if (prevTabLink.length) {
                prevTabLink.tab('show');
                updateProgressBar();
            }
        });

        $(".first a").click(function(e) {
            e.preventDefault();
            $(".nav-pills li:first-child a").tab('show');
            updateProgressBar();
        });

        $(".last a").click(function(e) {
            e.preventDefault();
            if (validateAllTabs()) {
                $(".nav-pills li:last-child a").tab('show');
                updateProgressBar();
            }
        });

        function validateAllTabs() {
            let valid = true;
            $('.tab-pane').each(function() {
                if (!validateTab($(this).attr('id'))) {
                    valid = false;
                }
            });
            return valid;
        }

        document.getElementById('finishBtn').addEventListener('click', function(e) {
            e.preventDefault();
            if (validateAllTabs()) {
                document.getElementById('businessForm').submit();
            }
        });

        $('.nav-pills a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
            updateProgressBar();
        });

        function calculateAge(dob) {
            const birthDate = new Date(dob);
            const today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            const m = today.getMonth() - birthDate.getMonth();

            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }

            const ageInput = document.getElementById('age');
            ageInput.value = age;
            validateElement(ageInput);
        }
    </script>
@endpush
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div id="basicwizard" class="form-wizard row justify-content-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-3">
                            <ul class="nav nav-pills nav-justified">
                                <li class="nav-item" data-target-form="#basicDetailForm">
                                    <a href="#basicDetail" data-bs-toggle="tab" data-toggle="tab" class="nav-link active">
                                        <i class="ph-duotone ph-user-circle"></i>
                                        <span class="d-none d-sm-inline">{{ __('Basic Information') }}</span>
                                    </a>
                                </li>
                                <li class="nav-item" data-target-form="#addressDetailForm">
                                    <a href="#addressDetail" data-bs-toggle="tab" data-toggle="tab"
                                        class="nav-link icon-btn">
                                        <i class="ph-duotone ph-map-pin"></i>
                                        <span class="d-none d-sm-inline">{{ __('Address') }}</span>
                                    </a>
                                </li>
                                <li class="nav-item" data-target-form="#additionalDetailForm">
                                    <a href="#additionalDetail" data-bs-toggle="tab" data-toggle="tab"
                                        class="nav-link icon-btn">
                                        <i class="ph-duotone ph-phone"></i>
                                        <span class="d-none d-sm-inline">{{ __('Additional Detail') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    {{ Form::model($trainee, ['route' => ['trainees.update', $trainee->id], 'method' => 'put', 'id' => 'businessForm', 'enctype' => 'multipart/form-data']) }}
                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content">
                                <div id="bar" class="progress mb-3" style="height: 7px">
                                    <div class="bar progress-bar progress-bar-striped progress-bar-animated bg-success">
                                    </div>
                                </div>

                                <div class="tab-pane show active" id="basicDetail">
                                    <div id='basicDetailForm'>
                                        <div class="row mt-4">
                                            <div class="col">
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
                                                        {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter name'), 'required' => 'required']) }}
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        {{ Form::label('email', __('Email'), ['class' => 'form-label']) }}
                                                        {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => __('Enter email'), 'required' => 'required']) }}
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        {{ Form::label('phone_number', __('Phone Number'), ['class' => 'form-label']) }}
                                                        {{ Form::text('phone_number', null, ['class' => 'form-control', 'placeholder' => __('Enter phone number'), 'required' => 'required']) }}
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        {{ Form::label('dob', __('Date of Birth'), ['class' => 'form-label']) }}
                                                        {{ Form::date('dob', !empty($trainee->traineeDetail) ? $trainee->traineeDetail->dob : null, ['class' => 'form-control', 'required' => 'required']) }}
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        {{ Form::label('age', __('Age'), ['class' => 'form-label']) }}
                                                        {{ Form::number('age', !empty($trainee->traineeDetail) ? $trainee->traineeDetail->age : null, ['class' => 'form-control', 'placeholder' => __('Enter age'), 'required' => 'required']) }}
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        {{ Form::label('gender', __('Gender'), ['class' => 'form-label']) }}
                                                        {!! Form::select('gender', $gender, !empty($trainee->traineeDetail) ? $trainee->traineeDetail->gender : null, [
                                                            'class' => 'form-control select2',
                                                            'required' => 'required',
                                                        ]) !!}
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        {{ Form::label('communication_preference', __('Communication Preference'), ['class' => 'form-label']) }}
                                                        {!! Form::select('communication_preference', ['sms' => 'SMS', 'email' => 'Email', 'both' => 'Both'], !empty($trainee->traineeDetail) ? $trainee->traineeDetail->communication_preference : 'email', [
                                                            'class' => 'form-control select2',
                                                            'required' => 'required',
                                                        ]) !!}
                                                    </div>
                                                    <div class="form-group col-md-6 mb-3">
                                                        {{ Form::label('profile', __('Profile'), ['class' => 'form-label']) }}
                                                        {{ Form::file('profile', ['class' => 'form-control', 'accept' => '.jpg,.png,.jpeg']) }}
                                                    </div>
                                                    <div class="form-group col-md-6 mb-3">
                                                        {{ Form::label('document', __('Document  (Adhar card, Pancard, Passport, Driving license)'), ['class' => 'form-label']) }}
                                                        {{ Form::file('document', ['class' => 'form-control', 'accept' => '.jpg,.png,.jpeg,.pdf']) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="addressDetail">
                                    <div id='addressDetailForm'>
                                        <div class="row mt-4">
                                            <div class="form-group col-md-6">
                                                {{ Form::label('country', __('Country'), ['class' => 'form-label']) }}
                                                {{ Form::text('country', !empty($trainee->traineeDetail) ? $trainee->traineeDetail->country : null, ['class' => 'form-control', 'placeholder' => __('Enter country')]) }}
                                            </div>
                                            <div class="form-group col-md-6">
                                                {{ Form::label('state', __('State'), ['class' => 'form-label']) }}
                                                {{ Form::text('state', !empty($trainee->traineeDetail) ? $trainee->traineeDetail->state : null, ['class' => 'form-control', 'placeholder' => __('Enter state')]) }}
                                            </div>
                                            <div class="form-group col-md-6">
                                                {{ Form::label('city', __('City'), ['class' => 'form-label']) }}
                                                {{ Form::text('city', !empty($trainee->traineeDetail) ? $trainee->traineeDetail->city : null, ['class' => 'form-control', 'placeholder' => __('Enter city')]) }}
                                            </div>
                                            <div class="form-group col-md-6">
                                                {{ Form::label('zip_code', __('Zip Code'), ['class' => 'form-label']) }}
                                                {{ Form::text('zip_code', !empty($trainee->traineeDetail) ? $trainee->traineeDetail->zip_code : null, ['class' => 'form-control', 'placeholder' => __('Enter zip code')]) }}
                                            </div>
                                            <div class="form-group col-md-12">
                                                {{ Form::label('address', __('Address'), ['class' => 'form-label']) }}
                                                {{ Form::textarea('address', !empty($trainee->traineeDetail) ? $trainee->traineeDetail->address : null, ['class' => 'form-control', 'rows' => 1, 'placeholder' => __('Enter address')]) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="additionalDetail">
                                    <div id='additionalDetailForm'>
                                        <div class="row mt-4">
                                            <div class="form-group col-md-6">
                                                {{ Form::label('fitness_goal', __('Fitness Goal'), ['class' => 'form-label']) }}
                                                {{ Form::text('fitness_goal', !empty($trainee->traineeDetail) ? $trainee->traineeDetail->fitness_goal : null, ['class' => 'form-control', 'placeholder' => __('Enter fitness goal')]) }}
                                            </div>
                                            <div class="form-group col-md-6">
                                                {{ Form::label('category', __('Category'), ['class' => 'form-label']) }}
                                                {!! Form::select(
                                                    'category',
                                                    $category,
                                                    !empty($trainee->traineeDetail) ? $trainee->traineeDetail->category : null,
                                                    ['class' => 'form-control select2', 'required' => 'required'],
                                                ) !!}
                                            </div>
                                            <div class="form-group col-md-6">
                                                {{ Form::label('membership_plan', __('Membership'), ['class' => 'form-label']) }}
                                                {!! Form::select(
                                                    'membership_plan',
                                                    $membership,
                                                    !empty($trainee->traineeDetail) ? $trainee->traineeDetail->membership_plan : null,
                                                    ['class' => 'form-control select2', 'required' => 'required'],
                                                ) !!}
                                            </div>
                                            <div class="form-group col-md-6">
                                                {{ Form::label('membership_start_date', __('Membership Start Date'), ['class' => 'form-label']) }}
                                                {{ Form::date('membership_start_date', !empty($trainee->traineeDetail) ? $trainee->traineeDetail->membership_start_date : null, ['class' => 'form-control']) }}
                                            </div>
                                            <div class="form-group col-md-6">
                                                {{ Form::label('trainer_assign', __('Trainer Assign'), ['class' => 'form-label']) }}
                                                {!! Form::select(
                                                    'trainer_assign',
                                                    $trainer,
                                                    !empty($trainee->traineeDetail) ? $trainee->traineeDetail->trainer_assign : null,
                                                    ['class' => 'form-control select2'],
                                                ) !!}
                                            </div>
                                            <div class="form-group col-md-6">
                                                {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}
                                                {!! Form::select('status', $status, !empty($trainee->traineeDetail) ? $trainee->traineeDetail->status : null, [
                                                    'class' => 'form-control select2',
                                                    'required' => 'required',
                                                ]) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex wizard justify-content-between flex-wrap gap-2 mt-3">
                                    <div class="first">
                                        <a href="#" class="btn btn-secondary">First</a>
                                    </div>
                                    <div class="d-flex">
                                        <div class="previous me-2">
                                            <a href="#" class="btn btn-secondary">Back To Previous</a>
                                        </div>
                                        <div class="next">
                                            <a href="#" class="btn btn-secondary">Next Step</a>
                                        </div>
                                    </div>
                                    <div class="last">
                                        <a href="#" class="">
                                            {{ Form::submit(__('Finish'), ['class' => 'btn btn-secondary', 'id' => 'finishBtn']) }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
        <style>
            .select2-container {
                width: 100% !important;
            }

            input[type=number]::-webkit-inner-spin-button,
            input[type=number]::-webkit-outer-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            input[type=number] {
                -moz-appearance: textfield;
            }

            .bar {
                transition: width 0.4s ease;
            }

            .form-control.is-invalid {
                border-color: #dc3545;
                padding-right: calc(1.5em + 0.75rem);
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
                background-repeat: no-repeat;
                background-position: right calc(0.375em + 0.1875rem) center;
                background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
            }

            .error-message {
                display: block;
                margin-top: 0.25rem;
            }
        </style>
    </div>
@endsection
