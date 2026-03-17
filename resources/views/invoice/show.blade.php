@extends('layouts.app')
@section('page-title')
    {{ __('Invoice') }}
@endsection
@php
    $admin_logo = getSettingsValByName('company_logo');
    $settings = settings();
@endphp
@push('script-page')
    <script>
        $(document).on('click', '.print', function() {
            var printContents = document.getElementById('invoice-print').innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;

        });
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
            <a href="#">{{ __('Details') }}</a>
        </li>
    </ul>
@endsection
@section('content')
    <div class="row">
        <div id="invoice-print">
            <div class="col-sm-12">
                <div class="d-print-none card mb-3">
                    <div class="card-body p-3">
                        <ul class="list-inline ms-auto mb-0 d-flex justify-content-end flex-wrap">

                            <li class="list-inline-item align-bottom me-2">
                                @can('create invoice payment')
                                    @if ($invoice->getInvoiceTotalDueAmount() >= 0)
                                        <a href="#" class="avtar avtar-s btn-link-secondary customModal"
                                            data-bs-toggle="tooltip" data-bs-original-title="{{ __('Payment') }}" data-size="md"
                                            data-url="{{ route('invoice.payment.create', $invoice->id) }}"
                                            data-title="{{ __('Add Payment') }}">
                                            <i class="ph-duotone ph-credit-card f-22"></i>
                                        </a>
                                    @endif
                                @endcan
                            </li>
                            <li class="list-inline-item align-bottom me-2">
                                <a href="#" class="avtar avtar-s btn-link-secondary print" data-bs-toggle="tooltip"
                                    data-bs-original-title="{{ __('Download') }}">
                                    <i class="ph-duotone ph-printer f-22"></i>
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>
                <div class="card">

                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="row align-items-center g-3">
                                    <div class="col-sm-6">
                                        <div class="d-flex align-items-center mb-2 navbar-brand img-fluid invoice-logo">
                                            <img src="{{ asset(Storage::url('upload/logo/')) . '/' . (isset($admin_logo) && !empty($admin_logo) ? $admin_logo : 'logo.png') }}"
                                                class="img-fluid brand-logo" alt="images" />
                                        </div>
                                        <p class="mb-0">{{ invoicePrefix() . $invoice->invoice_id }}</p>
                                    </div>
                                    <div class="col-sm-6 text-sm-end">
                                        <h6>
                                            {{ __('Date') }}
                                            <span
                                                class="text-muted f-w-400">{{ dateFormat($invoice->invoice_date) }}</span>
                                        </h6>
                                        <h6>
                                            {{ __('Due Date') }}
                                            <span
                                                class="text-muted f-w-400">{{ dateFormat($invoice->invoice_due_date) }}</span>
                                        </h6>
                                        <h6>
                                            {{ __('Status') }}
                                            <span class="text-muted f-w-400">
                                                @if ($invoice->status == 'unpaid')
                                                    <span
                                                        class="badge text-bg-danger">{{ \App\Models\Invoice::$status[$invoice->status] }}</span>
                                                @elseif($invoice->status == 'paid')
                                                    <span
                                                        class="badge text-bg-success">{{ \App\Models\Invoice::$status[$invoice->status] }}</span>
                                                @elseif($invoice->status == 'partial_paid')
                                                    <span
                                                        class="badge text-bg-warning">{{ \App\Models\Invoice::$status[$invoice->status] }}</span>
                                                @endif
                                            </span>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="border rounded p-3">
                                    <h6 class="mb-0">From:</h6>
                                    <h5>{{ $settings['company_name'] }}</h5>
                                    <p class="mb-0">{{ $settings['company_phone'] }}</p>
                                    <p class="mb-0">{{ $settings['company_email'] }}</p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="border rounded p-3">
                                    <h6 class="mb-0">To:</h6>
                                    <h5>{{ !empty($invoice->users) ? $invoice->users->name : '' }}</h5>
                                    <p class="mb-0">{{ !empty($invoice->users) ? $invoice->users->phone_number : '' }}
                                    </p>
                                    <p class="mb-0">
                                        {{ !empty($invoice->users) && !empty($invoice->users->traineeDetail) ? $invoice->users->traineeDetail->address : '' }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Type') }}</th>
                                                <th>{{ __('Title') }}</th>
                                                <th>{{ __('Description') }}</th>
                                                <th>{{ __('Amount') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($invoice->types as $k => $type)
                                                {{-- @dd($type) --}}
                                                <tr>
                                                    <td>{{ !empty($type->invoicetypes) ? $type->invoicetypes->title : '-' }}
                                                    </td>
                                                    <td>{{ $type->title }}</td>
                                                    <td class="text-wrap text-justify">{{ $type->description }}</td>
                                                    <td>{{ priceFormat($type->amount) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-start">
                                    <hr class="mb-2 mt-1 border-secondary border-opacity-50" />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="invoice-total ms-auto">
                                    <div class="row">

                                        <div class="col-6">
                                            <p class="f-w-600 mb-1 text-start">{{ __('Total') }} :</p>
                                        </div>
                                        <div class="col-6">
                                            <p class="f-w-600 mb-1 text-end">
                                                {{ priceFormat($invoice->getInvoiceSubTotalAmount()) }}
                                            </p>
                                        </div>
                                        <div class="col-6">
                                            <p class="f-w-600 mb-1 text-start">{{ __('Due Amount') }} :</p>
                                        </div>
                                        <div class="col-6">
                                            <p class="f-w-600 mb-1 text-end">
                                                {{ priceFormat($invoice->getInvoiceTotalDueAmount()) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Payment History') }}</h5>
                </div>
                <div class="card-body pt-0">
                    <div class="dt-responsive table-responsive">
                        <table class="table table-hover ">
                            <thead>
                                <tr>
                                    <th>{{ __('Transaction Id') }}</th>
                                    <th>{{ __('Payment Date') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('Notes') }}</th>
                                    <th>{{ __('Receipt') }}</th>
                                    @can('delete invoice payment')
                                        <th class="text-right">{{ __('Action') }}</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoice->payments as $payment)
                                    <tr role="row">
                                        <td>{{ $payment->transaction_id }} </td>
                                        <td>{{ dateFormat($payment->payment_date) }} </td>
                                        <td>{{ priceFormat($payment->amount) }} </td>
                                        <td>{{ $payment->notes }} </td>
                                        <td>
                                            @if (!empty($payment->receipt))
                                                <a href="{{ asset(Storage::url('upload/receipt')) . '/' . $payment->receipt }}"
                                                    download="download"><i data-feather="download"></i></a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        @can('delete invoice payment')
                                            <td class="text-right">
                                                <div class="cart-action">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['invoice.payment.destroy', $invoice->id, $payment->id]]) !!}
                                                    <a class=" text-danger confirm_dialog" data-bs-toggle="tooltip"
                                                        data-bs-original-title="{{ __('Detete') }}" href="#"> <i
                                                            data-feather="trash-2"></i></a>
                                                    {!! Form::close() !!}
                                                </div>
                                            </td>
                                        @endcan
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">

    </div>
@endsection
