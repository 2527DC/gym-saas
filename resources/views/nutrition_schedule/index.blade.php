@extends('layouts.app')

@section('page-title')
    {{ __('Nutrition Schedule') }}
@endsection

@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">
                {{ __('Nutrition Schedule') }}
            </a>
        </li>
    </ul>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5>{{ __('Nutrition Schedule List') }}</h5>
                        </div>
                        @if (Gate::check('create nutrition schedule'))
                            <div class="col-auto">
                                <a href="{{ route('nutrition-schedule.create') }}" class="btn btn-secondary" data-size="lg"
                                    data-title="{{ __('Create Nutrition Schedule') }}">
                                    <i class="ti ti-circle-plus align-text-bottom"></i>
                                    {{ __('Create Nutrition Schedule') }}</a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="dt-responsive table-responsive">
                        <table class="table table-hover advance-datatable" data-sort="false">
                            <thead>
                                <tr>
                                    <th>{{ __('User') }}</th>
                                    <th>{{ __('Start Date') }}</th>
                                    <th>{{ __('End Date') }}</th>
                                    @if (Gate::check('edit nutrition schedule') || Gate::check('delete nutrition schedule') || Gate::check('show nutrition schedule'))
                                        <th>{{ __('Action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($nutritionSchedules as $nutritionSchedule)
                                    <tr>
                                        <td class="table-user">
                                            <img src="{{ !empty($nutritionSchedule->user->profile) ? asset(Storage::url('upload/profile/' . $nutritionSchedule->user->profile)) : asset(Storage::url('upload/profile/avatar.png')) }}"
                                                alt="" class="mr-2 avatar-sm rounded-circle user-avatar">
                                            <a href="#"
                                                class="text-body font-weight-semibold">{{ !empty($nutritionSchedule->user->name) ? $nutritionSchedule->user->name : '-' }}</a>
                                        </td>
                                        <td>{{ $nutritionSchedule->start_date }}</td>
                                        <td>{{ $nutritionSchedule->end_date }}</td>
                                        @if (Gate::check('edit nutrition schedule') || Gate::check('delete nutrition schedule') || Gate::check('show nutrition schedule'))
                                            <td>
                                                <div class="cart-action">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['nutrition-schedule.destroy', encrypt($nutritionSchedule->id)]]) !!}
                                                    @can('show nutrition schedule')
                                                        <a class="avtar avtar-xs btn-link-warning text-warning"
                                                            data-bs-toggle="tooltip" data-size="lg"
                                                            data-bs-original-title="{{ __('Details') }}"
                                                            href="{{ route('nutrition-schedule.show', \Illuminate\Support\Facades\Crypt::encrypt($nutritionSchedule->id)) }}">
                                                            <i data-feather="eye"></i></a>
                                                    @endcan
                                                    @can('delete nutrition schedule')
                                                        <a class="avtar avtar-xs btn-link-danger text-danger confirm_dialog"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-original-title="{{ __('Delete') }}" href="#">
                                                            <i data-feather="trash-2"></i></a>
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
