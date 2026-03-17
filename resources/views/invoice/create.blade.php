@extends('layouts.app')
@section('page-title')
    {{ __('Invoice') }}
@endsection
@push('script-page')
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/jquery.repeater.min.js') }}"></script>

    <script>
        var selector = "body";
        if ($(selector + " .repeater").length) {
            var $dragAndDrop = $("body .repeater tbody").sortable({
                handle: '.sort-handler'
            });
            var $repeater = $(selector + ' .repeater').repeater({
                initEmpty: false,
                defaultValues: {
                    'status': 1
                },
                // show: function() {
                //     $('.select2').select2({
                //         minimumResultsForSearch: -1
                //     });
                //     $(this).slideDown();
                // },
                hide: function(deleteElement) {
                    if (confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                        $(this).remove();
                    }
                },
                ready: function(setIndexes) {
                    $dragAndDrop.on('drop', setIndexes);
                },
                isFirstItemUndeletable: true
            });
            var value = $(selector + " .repeater").attr('data-value');
            if (typeof value != 'undefined' && value.length != 0) {
                value = JSON.parse(value);
                $repeater.setList(value);
            }
        }
    </script>
@endpush
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('invoices.index') }}">{{ __('Invoice') }}</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{ __('Create') }}</a>
        </li>
    </ul>
@endsection

@section('content')
    <div class="row">
        {{ Form::open(['url' => 'invoices', 'method' => 'post', 'id' => 'invoice_form']) }}
        <div class="col-12">
            <div class="card">

                <div class="card-body">

                    <div class="row">
                        <div class="form-group col-md-6 col-lg-4">
                            {{ Form::label('user_id', __('Trainee'), ['class' => 'form-label']) }}
                            {{ Form::select('user_id', $trainee, null, ['class' => 'form-control select2']) }}
                        </div>

                        <div class="form-group col-md-6 col-lg-4">
                            <div class="form-group">
                                {{ Form::label('invoice_id', __('Invoice Number'), ['class' => 'form-label']) }}
                                <div class="input-group">
                                    <span class="input-group-text ">
                                        {{ invoicePrefix() }}
                                    </span>
                                    {{ Form::text('invoice_id', $invoiceNumber, ['class' => 'form-control', 'placeholder' => __('Enter Invoice Number')]) }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6 col-lg-4">
                            {{ Form::label('invoice_date', __('Invoice Date'), ['class' => 'form-label']) }}
                            {{ Form::date('invoice_date', null, ['class' => 'form-control']) }}
                        </div>
                        <div class="form-group col-md-6 col-lg-4">
                            {{ Form::label('invoice_due_date', __('Invoice Due Date'), ['class' => 'form-label']) }}
                            {{ Form::date('invoice_due_date', null, ['class' => 'form-control']) }}
                        </div>
                        <div class="form-group col-md-8 col-lg-8">
                            {{ Form::label('notes', __('Notes'), ['class' => 'form-label']) }}
                            {{ Form::textarea('notes', null, ['class' => 'form-control', 'rows' => 1, 'placeholder' => __('Enter Notes')]) }}
                        </div>
                    </div>

                </div>
            </div>
            <div class="card repeater">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5>{{ __('Types') }}</h5>
                        </div>

                        <div class="col-auto">
                            <a href="#" class="btn btn-secondary" data-title="{{ __('Create Invoice') }}"
                                data-repeater-create="">
                                <i class="ti ti-circle-plus align-text-bottom"></i>
                                {{ __('Add Type') }}</a>

                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <table class="display dataTable cell-border" data-repeater-list="types">
                        <thead>
                            <tr>
                                <th>{{ __('Type') }}</th>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Amount') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody data-repeater-item>
                            <tr>
                                <td width="30%">
                                    {{ Form::select('type_id', $types, null, ['class' => 'form-control select2']) }}
                                </td>
                                <td>
                                    {{ Form::text('title', null, ['class' => 'form-control']) }}
                                </td>
                                <td>
                                    {{ Form::number('amount', null, ['class' => 'form-control']) }}
                                </td>
                                <td>
                                    {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => 1]) }}
                                </td>
                                <td>
                                    <a class="text-danger" data-repeater-delete data-bs-toggle="tooltip"
                                        data-bs-original-title="{{ __('Detete') }}" href="#">
                                        <i data-feather="trash-2"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="group-button text-end">
                    {{ Form::submit(__('Create'), ['class' => 'btn btn-secondary btn-rounded', 'id' => 'invoice-submit']) }}
                </div>
            </div>
        </div>
        {{ Form::close() }}
    </div>
@endsection
