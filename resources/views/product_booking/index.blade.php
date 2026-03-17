@extends('layouts.app')
@section('page-title')
    {{ __('Product') }}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#"> {{ __('Product Booking') }}</a>
        </li>
    </ul>
@endsection
@php
    $setting = settings();
@endphp
@section('content')
    <div class="row">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center g-2">
                            <div class="col">
                                <h5>{{ __('Product Booking List') }}</h5>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('product-booking.create') }}" class="btn btn-secondary" data-size="lg"
                                    data-title="{{ __('Create product booking') }}">
                                    <i class="ti ti-circle-plus align-text-bottom"></i>
                                    {{ __('Create Product Booking') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="dt-responsive table-responsive">
                            <table class="table table-hover advance-datatable">
                                <thead>
                                    <tr>
                                        <th>{{ __('User') }}</th>
                                        <th>{{ __('Title') }}</th>
                                        <th>{{ __('Quantity') }}</th>
                                        <th>{{ __('Date') }}</th>
                                        <th>{{ __('Price') }}</th>
                                        @if (Gate::check('delete product booking'))
                                            <th>{{ __('Action') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productBookings as $product)
                                        <tr>
                                            <td>{{ $product->user->name ?? '-' }} </td>
                                            <td>
                                                @if ($product->items->count() === 1)
                                                    {{ $product->items->first()->product->title }}
                                                @else
                                                    <ul class="mb-0 ps-3">
                                                        @foreach ($product->items as $item)
                                                            <li>{{ $item->product->title }}</li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </td>

                                            <td>
                                                @if ($product->items->count() === 1)
                                                    {{ $product->items->first()->quantity }}
                                                @else
                                                    <ul class="mb-0 ps-3">
                                                        @foreach ($product->items as $item)
                                                            <li>{{ $item->quantity }}</li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </td>

                                            <td>
                                                {{ \Carbon\Carbon::parse($product->invoice_date)->format($setting['company_date_format']) }}
                                            </td>

                                            <td>
                                                {{ number_format($product->price, 2) }}
                                            </td>
                                            <td>
                                                <div class="cart-action">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['product-booking.destroy', encrypt($product->id)]]) !!}
                                                    @can('delete product booking')
                                                        <a class="avtar avtar-xs btn-link-danger text-danger confirm_dialog"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-original-title="{{ __('Detete') }}" href="#"> <i
                                                                data-feather="trash-2"></i></a>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
