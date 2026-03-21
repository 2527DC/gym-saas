@extends('layouts.app')
@php
    $profile = asset(Storage::url('upload/profile/'));
@endphp
@section('page-title')
    {{ __('Trainees') }}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">
                {{ __('Trainees') }}
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
                            <h5>{{ __('Trainees List') }}</h5>
                        </div>
                        @if (Gate::check('create trainee'))
                            <div class="col-auto">
                                <a href="{{ route('trainees.create') }}" class="btn btn-secondary" data-size="lg"
                                    data-title="{{ __('Create Trainee') }}"> <i
                                        class="ti ti-circle-plus align-text-bottom"></i> {{ __('Create Trainee') }}</a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="dt-responsive table-responsive">
                        <table class="table table-hover advance-datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('User') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Phone Number') }}</th>
                                    <th>{{ __('Category') }}</th>
                                    <th>{{ __('Membership') }}</th>
                                    <th>{{ __('Expiry Date') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    @if (Gate::check('edit trainee') || Gate::check('delete trainee') || Gate::check('show trainee'))
                                        <th>{{ __('Action') }}</th>
                                    @endif

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trainees as $trainee)
                                    <tr>
                                        <td>{{ traineePrefix() . $trainee->traineeDetail->trainee_id }} </td>
                                        <td class="table-user">
                                            <img src="{{ !empty($trainee->profile) ? asset(Storage::url('upload/profile/' . $trainee->profile)) : asset(Storage::url('upload/profile/avatar.png')) }}"
                                                alt="" class="mr-2 avatar-sm rounded-circle user-avatar">
                                            <a href="#"
                                                class="text-body font-weight-semibold">{{ $trainee->name }}</a>
                                        </td>
                                        <td>{{ $trainee->email }} </td>
                                        <td>{{ !empty($trainee->phone_number) ? $trainee->phone_number : '-' }} </td>
                                        <td>{{ !empty($trainee->traineeDetail) ? (!empty($trainee->traineeDetail->categorys) ? $trainee->traineeDetail->categorys->title : '-') : '-' }}
                                        </td>
                                        <td>{{ !empty($trainee->traineeDetail) ? (!empty($trainee->traineeDetail->membership) ? $trainee->traineeDetail->membership->title : '-') : '-' }}
                                        </td>
                                        <td>{{ !empty($trainee->traineeDetail) ? (!empty($trainee->traineeDetail->membership_expiry_date) ? dateFormat($trainee->traineeDetail->membership_expiry_date) : __('Lifetime')) : '-' }}
                                        </td>
                                        <td>
                                            @if (!empty($trainee->traineeDetail) && $trainee->traineeDetail->status == 1)
                                                <span
                                                    class="badge text-bg-success">{{ App\Models\traineeDetail::$status[$trainee->traineeDetail->status] }}</span>
                                            @else
                                                <span
                                                    class="badge text-bg-danger">{{ App\Models\traineeDetail::$status[$trainee->traineeDetail->status] }}</span>
                                            @endif

                                        </td>
                                        @if (Gate::check('edit trainee') || Gate::check('delete trainee') || Gate::check('show trainee'))
                                            <td>
                                                <div class="cart-action">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['trainees.destroy', encrypt($trainee->id)]]) !!}
                                                    @can('show trainee')
                                                        <a class="btn btn-icon avtar-xs btn-link-warning "
                                                            data-bs-toggle="tooltip" data-size="lg"
                                                            data-bs-original-title="{{ __('Details') }}"
                                                            href="{{ route('trainees.show', \Illuminate\Support\Facades\Crypt::encrypt($trainee->id)) }}">
                                                            <i data-feather="eye"></i></a>
                                                    @endcan
                                                    @can('edit trainee')
                                                        <a class="btn btn-icon avtar-xs btn-link-secondary"
                                                            data-bs-toggle="tooltip" data-size="lg"
                                                            data-bs-original-title="{{ __('Edit') }}" href="{{ route('trainees.edit', encrypt($trainee->id)) }}"
                                                            data-title="{{ __('Edit Trainee') }}"> <i
                                                                data-feather="edit"></i></a>
                                                    @endcan
                                                    @can('send manual reminder')
                                                        <a class="btn btn-icon avtar-xs btn-link-primary"
                                                            data-bs-toggle="tooltip" data-size="lg"
                                                            data-bs-original-title="{{ __('Send Manual Reminder') }}" 
                                                            href="{{ route('trainees.sendReminder', encrypt($trainee->id)) }}">
                                                            <i data-feather="send"></i></a>
                                                    @endcan
                                                    @can('delete trainee')
                                                        <a class="btn btn-icon avtar-xs btn-link-danger confirm_dialog"
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
@endsection
