@extends('layouts.app')
@section('page-title')
    {{ __('Create Event') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('event.index') }}">{{ __('Event') }}</a></li>
    <li class="breadcrumb-item" aria-current="page"> {{ __('Create') }}</li>
@endsection
@push('script-page')
    <script src="{{ asset('assets/js/plugins/ckeditor/classic/ckeditor.js') }}"></script>
@endpush
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                {!! Form::model($event, ['route' => ['event.update', $event->id], 'method' => 'PuT']) !!}
                <div class="card-body row">
                    <div class="form-group col-md-6 mb-3">
                        {{ Form::label('event_type_id', __('Event Type') . ' <span class="text-danger">*</span>', ['class' => 'form-label'], false) }}
                        {{ Form::select('event_type_id', $eventTypes, old('event_type_id'), [
                            'class' => 'form-control select2',
                            'placeholder' => 'Select Event Type',
                            'required',
                        ]) }}
                    </div>

                    <div class="form-group col-md-6 mb-3">
                        {{ Form::label('title', __('Event name') . ' <span class="text-danger">*</span>', ['class' => 'form-label'], false) }}
                        {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter event name', 'required']) !!}
                    </div>

                    <div class="form-group col-md-6 mb-3">
                        {{ Form::label('start_date', __('Start Date') . ' <span class="text-danger">*</span>', ['class' => 'form-label'], false) }}
                        {{ Form::date('start_date', old('start_date'), ['class' => 'form-control', 'required']) }}
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        {{ Form::label('end_date', __('End Date') . ' <span class="text-danger">*</span>', ['class' => 'form-label'], false) }}
                        {{ Form::date('end_date', old('end_date'), ['class' => 'form-control', 'required']) }}
                    </div>
                    <div class="form-group col-md-6">
                        {{ Form::label('description', __('Description') . '<span class="text-danger"> *</span>', ['class' => 'form-label'], false) }}
                        {{ Form::textarea('description', null, [
                            'class' => 'form-control',
                            'required' => 'required',
                            'placeholder' => __('Enter description'),
                            'cols' => 30,
                            'rows' => 4,
                        ]) }}
                    </div>
                    <div class="form-group col-md-6">
                        {{ Form::label('status', __('Status') . ' <span class="text-danger">*</span>', ['class' => 'form-label'], false) }}
                        {{ Form::select('status', $status, null, ['class' => 'form-select', 'placeholder' => __('Select Status'), 'required']) }}
                    </div>
                </div>
                <div class="card-footer text-end">
                    {{ Form::submit(__('Create'), ['class' => 'btn btn-secondary btn-rounded']) }}
                </div>
                {!! Form::close() !!}
            </div>
        </div>

    </div>
@endsection
