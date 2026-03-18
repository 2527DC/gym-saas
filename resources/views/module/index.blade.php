@extends('layouts.app')
@section('page-title')
    {{ __('Modules') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page"> {{ __('Modules') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Create New Module') }}</h5>
                </div>
                <div class="card-body">
                    {{ Form::open(['route' => 'modules.store', 'method' => 'POST']) }}
                    <div class="form-group">
                        {{ Form::label('name', __('Module Name'), ['class' => 'form-label']) }}
                        {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter module name'), 'required' => 'required']) }}
                    </div>
                    <div class="text-end mt-3">
                        {{ Form::submit(__('Create'), ['class' => 'btn btn-secondary btn-rounded']) }}
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card table-card">
                <div class="card-header">
                    <h5>{{ __('Modules List') }}</h5>
                </div>
                <div class="card-body pt-0">
                    <div class="dt-responsive table-responsive">
                        <table class="table table-hover advance-datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Permissions Count') }}</th>
                                    <th class="text-end">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($modules as $module)
                                    <tr>
                                        <td>{{ ucfirst($module->name) }}</td>
                                        <td>
                                            <span class="badge bg-primary rounded-pill">
                                                {{ $module->permissions_count }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <div class="cart-action">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['modules.destroy', $module->id]]) !!}
                                                <a class="avtar avtar-xs btn-link-danger text-danger confirm_dialog"
                                                    data-bs-toggle="tooltip" data-bs-original-title="{{ __('Delete') }}"
                                                    href="#">
                                                    <i data-feather="trash-2"></i>
                                                </a>
                                                {!! Form::close() !!}
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
@endsection
