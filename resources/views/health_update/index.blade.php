@extends('layouts.app')

@section('page-title')
    {{ __('Health Update') }}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">
                {{ __('Health Update') }}
            </a>
        </li>
    </ul>
@endsection
@section('card-action-btn')

@endsection
@section('content')
    <div class="row">
        <div class="card">
            <div class="col-12">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5>{{ __('Health Update List') }}</h5>
                        </div>
                        @if (Gate::check('create health update'))
                            <div class="col-auto">
                                <a href="#" class="btn btn-secondary customModal" data-size="lg"
                                    data-url="{{ route('health-update.create') }}"
                                    data-title="{{ __('Create Health Update') }}">
                                    <i class="ti ti-circle-plus align-text-bottom"></i>
                                    {{ __('Create Health Update') }}</a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="dt-responsive table-responsive">
                        <table class="table table-hover advance-datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('Trainee') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Notes') }}</th>
                                    @if (Gate::check('edit health update') || Gate::check('delete health update') || Gate::check('show health update'))
                                        <th>{{ __('Action') }}</th>
                                    @endif

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($healthUpdates as $health)
                                    <tr>
                                        <td>{{ !empty($health->users) ? $health->users->name : '-' }} </td>
                                        <td>{{ dateFormat($health->measurement_date) }} </td>
                                        <td>{{ $health->notes }} </td>
                                        @if (Gate::check('edit health update') || Gate::check('delete health update') || Gate::check('show health update'))
                                            <td>
                                                <div class="cart-action">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['health-update.destroy', encrypt($health->id)]]) !!}
                                                    @can('show health update')
                                                        <a class="btn btn-icon avtar-xs btn-link-warning customModal" data-bs-toggle="tooltip"
                                                            data-size="lg" data-bs-original-title="{{ __('Details') }}"
                                                            data-title="{{ __('Details') }}"
                                                            data-url="{{ route('health-update.show', encrypt($health->id)) }}"
                                                            href="#"> <i data-feather="eye"></i></a>
                                                    @endcan
                                                    @can('edit health update')
                                                        <a class="btn btn-icon avtar-xs btn-link-secondary customModal" data-bs-toggle="tooltip"
                                                            data-size="lg" data-bs-original-title="{{ __('Edit') }}"
                                                            href="#"
                                                            data-url="{{ route('health-update.edit', encrypt($health->id)) }}"
                                                            data-title="{{ __('Edit Health Update') }}"> <i
                                                                data-feather="edit"></i></a>
                                                    @endcan
                                                    @can('delete health update')
                                                        <a class="btn btn-icon avtar-xs btn-link-danger confirm_dialog" data-bs-toggle="tooltip"
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
@endsection
