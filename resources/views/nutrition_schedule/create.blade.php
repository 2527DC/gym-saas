@extends('layouts.app')

@section('page-title')
    {{ __('Create Nutrition Schedule') }}
@endsection

@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Nutrition Schedule') }}</li>
    </ul>
@endsection

@section('content')
    @php
        $days = ['All', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $meals = [
            'break_fast' => 'Breakfast',
            'mid_morning_snacks' => 'Mid-Morning Snacks',
            'lunch' => 'Lunch',
            'afternoon_snacks' => 'Afternoon Snacks',
            'dinner' => 'Dinner',
        ];
    @endphp

    <div class="row">
        {!! Form::open([
            'method' => 'post',
            'id' => 'nutrition-form',
            'route' => 'nutrition-schedule.store',
            'novalidate' => 'novalidate',
        ]) !!}
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-header"><strong>{{ __('Nutrition Schedule Details') }}</strong></div>
                <div class="card-body row">
                    <div class="form-group col-md-4 mb-3">
                        {!! Form::label('trainee',__('Trainee') . ' <span class="text-danger">*</span>', ['class' => 'form-label'], false,) !!}
                        {!! Form::select('trainee', $trainee, null, ['class' => 'form-control select2', 'required', 'id' => 'trainee']) !!}
                        <span class="text-danger error-message" id="user_id_error"></span>
                    </div>
                    <div class="form-group col-md-4 mb-3">
                        {!! Form::label('start_date', __('Start Date') . ' <span class="text-danger">*</span>', ['class' => 'form-label'], false,) !!}
                        {!! Form::date('start_date', null, ['class' => 'form-control', 'required', 'id' => 'start_date']) !!}
                        <span class="text-danger error-message" id="start_date_error"></span>
                    </div>
                    <div class="form-group col-md-4 mb-3">
                        {!! Form::label('end_date', __('End Date') . ' <span class="text-danger">*</span>', ['class' => 'form-label'], false,) !!}
                        {!! Form::date('end_date', null, ['class' => 'form-control', 'required', 'id' => 'end_date']) !!}
                        <span class="text-danger error-message" id="end_date_error"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <div class="card mb-3">
                <div class="card-header"><strong>{{ __('Select Days') }}</strong></div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        {!! Form::select('selected_days[]', array_combine($days, $days), null, [ 'class' => 'form-control select2', 'multiple' => 'multiple', 'id' => 'selected_days', 'data-placeholder' => __('Select one or more days'), 'required',]) !!}
                        <span class="text-danger error-message" id="selected_days_error"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-8" id="meal_section" style="display: none;">
            <div class="card">
                <div class="card-header"><strong>{{ __('Daily Nutrition Plan') }}</strong></div>
                <div class="card-body">
                    @foreach ($meals as $mealKey => $mealLabel)
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input shared-meal-checkbox"
                                        data-meal="{{ $mealKey }}" id="meal-{{ $mealKey }}" name="meals[]"
                                        value="{{ $mealKey }}">
                                    <label class="form-check-label" for="meal-{{ $mealKey }}">{{ $mealLabel }}
                                        <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="meal-textarea" id="textarea-{{ $mealKey }}" style="display:none;">
                                    {!! Form::textarea("meal_description[{$mealKey}]", null, [
                                        'class' => 'form-control',
                                        'rows' => 2,
                                        'placeholder' => "Enter description for $mealLabel",
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <span class="text-danger error-message" id="meals_error"></span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">

            <div class="card-body text-end">
                {{ Form::submit(__('Create'), ['class' => 'btn btn-secondary ml-10']) }}
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@push('script-page')
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            $('.shared-meal-checkbox').on('change', function() {
                const key = $(this).data('meal');
                $('#textarea-' + key).toggle(this.checked);
                validateMeals();
            });

            $('#selected_days').on('change', function() {
                let selected = $(this).val() || [];
                if (selected.length > 0) {
                    $('#meal_section').show();
                    validateMeals();
                } else {
                    $('#meal_section').hide();
                    $('.shared-meal-checkbox').prop('checked', false);
                    $('.meal-textarea').hide();
                    clearError('meals');
                }
            }).trigger('change');

            function showError(elementId, message) {
                $(`#${elementId}_error`).text(message).show();
                const $element = $(`#${elementId}`);
                if ($element.hasClass('select2-hidden-accessible')) {
                    $element.next('.select2-container').find('.select2-selection').css({
                        'border': '1px solid red',
                        'border-radius': '4px'
                    });
                } else {
                    $element.css({
                        'border': '1px solid red',
                        'border-radius': '4px'
                    });
                }
            }

            function clearError(elementId) {
                $(`#${elementId}_error`).text('').hide();
                const $element = $(`#${elementId}`);
                if ($element.hasClass('select2-hidden-accessible')) {
                    $element.next('.select2-container').find('.select2-selection').css('border', '');
                } else {
                    $element.css('border', '');
                }
            }

            function validateRequired(elementId) {
                const $element = $(`#${elementId}`);
                let value = $element.val();

                if ($element.is('select[multiple]')) {
                    if (!value || value.length === 0) {
                        showError(elementId, 'This field is required');
                        return false;
                    }
                } else {
                    if (!value || value.trim() === '') {
                        showError(elementId, 'This field is required');
                        return false;
                    }
                }
                clearError(elementId);
                return true;
            }

            function validateMeals() {
                const checkedMeals = $('.shared-meal-checkbox:checked');
                if (checkedMeals.length === 0 && $('#meal_section').is(':visible')) {
                    showError('meals', 'At least one meal is required');
                    return false;
                }
                clearError('meals');
                return true;
            }

            $('#nutrition-form').on('submit', function(e) {
                e.preventDefault();
                let isValid = true;

                const fields = ['trainee', 'start_date', 'end_date', 'selected_days'];
                fields.forEach(field => {
                    if (!validateRequired(field)) {
                        isValid = false;
                    }
                });

                if (!validateMeals()) {
                    isValid = false;
                }

                if (isValid) {
                    this.submit();
                }
            });

            $('#trainee, #start_date, #end_date, #selected_days, .shared-meal-checkbox').on('change input',
                function() {
                    validateRequired($(this).attr('id') || $(this).closest('.form-check').find('input').attr(
                        'id'));
                    if ($(this).hasClass('shared-meal-checkbox')) {
                        validateMeals();
                    }
                });
        });
    </script>
@endpush
