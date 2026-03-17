@extends('layouts.app')

@section('page-title')
    {{ __('Create Product Booking') }}
@endsection

@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('product-booking.index') }}">{{ __('Product Booking') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Create') }}</li>
    </ul>
@endsection

@section('content')
    <div class="row wrapper">
        {!! Form::open(['route' => 'product-booking.store', 'method' => 'post']) !!}

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ __('Create Product Booking') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-4">
                            {{ Form::label('user_id', __('Trainee') . ' <span class="text-danger">*</span>', ['class' => 'form-label'], false) }}
                            {!! Form::select('user_id', $trainees, null, [
                                'class' => 'form-control select2',
                                'required' => 'required',
                                'placeholder' => 'Select trainee',
                            ]) !!}
                        </div>

                        <div class="form-group col-md-4">
                            {{ Form::label('invoice_date', __('Date') . ' <span class="text-danger">*</span>', ['class' => 'form-label'], false) }}
                            {!! Form::date('invoice_date', now(), [
                                'class' => 'form-control',
                                'required' => 'required',
                            ]) !!}
                        </div>
                        {!! Form::hidden('grand_total', null,['id' => 'grand_total']) !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Item List -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ __('Item List') }}</h5>
                </div>
                <div class="card-body">
                    <div class="cdx-invoice">
                        <div class="body-invoice">
                            <table class="dataTable table-responsive">
                                <thead>
                                    <tr>
                                        <th width="25%">{{ __('Product') }}</th>
                                        <th>{{ __('Quantity') }}</th>
                                        <th>{{ __('Price') }}</th>
                                        <th>{{ __('Discount') }}</th>
                                        <th>{{ __('Final Amount') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="invoice-items-body">
                                    <tr>
                                        <td>
                                            {!! Form::select('product_id[]', $products, null, [
                                                'class' => 'form-control select2 item-select',
                                                'required' => 'required',
                                                'placeholder' => 'Select product',
                                            ]) !!}
                                        </td>
                                        <td>
                                            {!! Form::number('quantity[]', 1, ['class' => 'form-control quantity', 'min' => 1]) !!}
                                        </td>
                                        <td>
                                            {!! Form::number('price[]', null, ['class' => 'form-control price', 'step' => '0.01', 'readonly' => true]) !!}
                                        </td>
                                        <td>
                                            {!! Form::number('discount[]', null, ['class' => 'form-control discount', 'step' => '0.01', 'readonly' => true]) !!}
                                        </td>
                                        <td>
                                            {!! Form::text('amount[]', null, ['class' => 'form-control amount', 'readonly' => true]) !!}
                                        </td>
                                        <td>
                                            <button type="button" class="text-danger border-0 bg-transparent remove-row">
                                                <i data-feather="trash-2"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="footer-invoice">
                            <table class="table">
                                <tr>
                                    <td>{{ __('Total Price') }}:</td>
                                    <td class="sub_total">0</td>
                                </tr>
                                <tr>
                                    <td>{{ __('Grand Total') }}:</td>
                                    <td class="grand_total">0</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="text-left mt-3">
                        <button type="button" id="add-item" class="btn btn-primary">{{ __('Add Item') }}</button>
                    </div>
                </div>

                <div class="col-12">
                    <div class="group-button text-end p-3">
                        {{ Form::submit(__('Create'), ['class' => 'btn btn-primary btn-rounded']) }}
                    </div>
                </div>
            </div>
        </div>

        {!! Form::close() !!}
    </div>

    <style>
        .select2-container {
            width: 100% !important;
        }

        .cdx-invoice {
            margin-top: 20px;
        }

        .footer-invoice {
            margin-top: 20px;
            text-align: right;
        }

        .footer-invoice table {
            width: 50%;
            float: right;
        }
    </style>
@endsection

@push('script-page')
    <script>
        $(document).ready(function () {
            $('.select2').select2();

            $('#invoice-items-body').data('template', $('#invoice-items-body tr:first').prop('outerHTML'));

            function calculateTotals() {
                let subTotal = 0;

                $('#invoice-items-body tr').each(function () {
                    let row = $(this);
                    let unitPrice = parseFloat(row.find('.price').val()) || 0;
                    let quantity = parseFloat(row.find('.quantity').val()) || 1;
                    let discount = parseFloat(row.find('.discount').val()) || 0;

                    let amount = (unitPrice * quantity) - discount;
                    if (amount < 0) amount = 0;

                    row.find('.amount').val(amount.toFixed(2));
                    subTotal += amount;
                });

                $('.sub_total').text(subTotal.toFixed(2));
                $('.grand_total').text(subTotal.toFixed(2));
                $('#grand_total').val(subTotal.toFixed(2));

                let opportunityAmountField = $('#opportunity-amount');
                if (subTotal > 0) {
                    opportunityAmountField.val(subTotal.toFixed(2));
                    opportunityAmountField.prop('readonly', true);
                } else {
                    opportunityAmountField.val('');
                    opportunityAmountField.prop('readonly', false);
                }
            }

            $(document).on('change', '.item-select', function () {
                let row = $(this).closest('tr');
                let itemId = $(this).val();

                if (itemId) {
                    $.ajax({
                        url: "{{ route('product.detail', ':id') }}".replace(':id', itemId),
                        type: 'GET',
                        success: function (data) {
                            row.find('.price').val(data.price || 0);
                            row.find('.discount').val(data.discount || 0);
                            calculateTotals();
                        },
                        error: function () {
                            alert('Failed to fetch item details.');
                        }
                    });
                } else {
                    row.find('.price').val('');
                    row.find('.discount').val('');
                    row.find('.amount').val('');
                    calculateTotals();
                }
            });

            $('#add-item').click(function () {
                let newRow = $($('#invoice-items-body').data('template')).clone();
                newRow.find('input').val('');
                newRow.find('select').val(null).trigger('change');
                $('#invoice-items-body').append(newRow);
                $('.select2-container').remove();
                $('.select2').select2();
                calculateTotals();
            });

            $(document).on('click', '.remove-row', function () {
                $(this).closest('tr').remove();
                calculateTotals();
            });

            $(document).on('input', '.quantity', function () {
                calculateTotals();
            });

            calculateTotals();
        });
    </script>
@endpush
