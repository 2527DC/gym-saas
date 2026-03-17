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
            <a href="#"> {{ __('Product') }}</a>
        </li>
    </ul>
@endsection
@section('content')
    <div class="row">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center g-2">
                            <div class="col">
                                <h5>{{ __('Product List') }}</h5>
                            </div>
                            @if (Gate::check('create product'))
                                <div class="col-auto">
                                    <a href="#" class="btn btn-secondary customModal" data-size="lg"
                                        data-url="{{ route('product.create') }}" data-title="{{ __('Create product') }}">
                                        <i class="ti ti-circle-plus align-text-bottom"></i> {{ __('Create Product') }}</a>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="dt-responsive table-responsive">
                            <table class="table table-hover advance-datatable">
                                <thead>
                                    <tr>
                                        <th>{{ __('Title') }}</th>
                                        <th>{{ __('Price') }}</th>
                                        <th>{{ __('Discount') }}</th>
                                        @if (Gate::check('edit product') || Gate::check('delete product') || Gate::check('show product'))
                                            <th>{{ __('Action') }}</th>
                                        @endif

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $product->title }} </td>
                                            <td>
                                               {{ $product->price }}
                                            </td>
                                            <td>
                                               {{ $product->discount }}
                                            </td>

                                            @if (Gate::check('edit product') || Gate::check('delete product') || Gate::check('show product'))
                                                <td>
                                                    <div class="cart-action">
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['product.destroy', $product->id]]) !!}
                                                        @can('show product')
                                                            <a class="btn btn-icon avtar-xs btn-link-warning customModal"
                                                                data-bs-toggle="tooltip"
                                                                data-size="lg"
                                                                data-url="{{ route('product.show', encrypt($product->id)) }}"
                                                                data-bs-original-title="{{ __('Details') }}"
                                                                href="#">
                                                                <i data-feather="eye"></i></a>
                                                        @endcan
                                                        @can('edit product')
                                                            <a class="btn btn-icon avtar-xs btn-link-secondary customModal"
                                                                data-bs-toggle="tooltip" data-size="lg"
                                                                data-bs-original-title="{{ __('Edit') }}" href="#"
                                                                data-url="{{ route('product.edit', encrypt($product->id)) }}"
                                                                data-title="{{ __('Edit Product') }}"> <i
                                                                    data-feather="edit"></i></a>
                                                        @endcan
                                                        @can('delete product')
                                                            <a class=" btn btn-icon avtar-xs btn-link-danger confirm_dialog"
                                                                data-bs-toggle="tooltip"
                                                                data-bs-original-title="{{ __('Detete') }}" href="#"> <i
                                                                    data-feather="trash-2"></i></a>
                                                        @endcan
                                                        {!! Form::close() !!}
                                                    </div>
                                                </td>
                                            @endif
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
