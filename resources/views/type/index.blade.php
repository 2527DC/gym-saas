@extends('layouts.app')
@section('page-title')
    {{ __('Type') }}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">
                {{ __('Type') }}
            </a>
        </li>
    </ul>
@endsection
@section('card-action-btn')
    @if (Gate::check('create finance type'))
        <a class="btn btn-secondary btn-sm ml-20 customModal" href="#" data-size="md"
            data-url="{{ route('types.create') }}" data-title="{{ __('Create Type') }}"> <i class="ti-plus mr-5"></i>
            {{ __('Create Type') }}
        </a>
    @endif
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5>{{ __('Finance Type List') }}</h5>
                        </div>
                        @if (Gate::check('create finance type'))
                            <div class="col-auto">
                                <a href="#" class="btn btn-secondary customModal" data-size="lg"
                                    data-url="{{ route('types.create') }}"data-title="{{ __('Create Finance Type') }}">
                                    <i class="ti ti-circle-plus align-text-bottom"></i>
                                    {{ __('Create Type') }}</a>
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
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Created At') }}</th>
                                    @if (Gate::check('edit finance type') || Gate::check('delete finance type'))
                                        <th>{{ __('Action') }}</th>
                                    @endif

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($types as $type)
                                    <tr>
                                        <td>{{ $type->title }} </td>
                                        <td>{{ \App\Models\Type::$types[$type->type] }} </td>
                                        <td>{{ dateFormat($type->created_at) }} </td>
                                        @if (Gate::check('edit finance type') || Gate::check('delete finance type'))
                                            <td>
                                                <div class="cart-action">
                                                    @if (!in_array($type->title, ['Class Fees', 'Membership Fees', 'Product']))
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['types.destroy', $type->id]]) !!}

                                                        @can('edit finance type')
                                                            <a class="btn btn-icon avtar-xs btn-link-secondary customModal"
                                                                data-bs-toggle="tooltip" data-size="md"
                                                                data-bs-original-title="{{ __('Edit') }}" href="#"
                                                                data-url="{{ route('types.edit', encrypt($type->id)) }}"
                                                                data-title="{{ __('Edit Type') }}">
                                                                <i data-feather="edit"></i>
                                                            </a>
                                                        @endcan

                                                        @can('delete finance type')
                                                            <a class="btn btn-icon avtar-xs btn-link-danger confirm_dialog"
                                                                data-bs-toggle="tooltip"
                                                                data-bs-original-title="{{ __('Delete') }}" href="#">
                                                                <i data-feather="trash-2"></i>
                                                            </a>
                                                        @endcan

                                                        {!! Form::close() !!}
                                                    @endif
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
@endsection
