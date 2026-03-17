@extends('layouts.app')
@section('page-title')
    {{ $membership->title }} {{ __('Details') }}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('membership.index') }}">{{ __('Membership') }}</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">
                {{ $membership->title }} {{ __('Details') }}
            </a>
        </li>
    </ul>
@endsection
@section('card-action-btn')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">

                            <p class="mb-1 mt-2">
                                <b>{{ __('Title') }} :</b>
                                {{ $membership->title }}
                            </p>

                        </div>
                        <div class="col-md-6">

                            <p class="mb-1 mt-2">
                                <b>{{ __('Package') }} :</b>
                                {{ $membership->package }}
                            </p>

                        </div>
                        <div class="col-md-4">
                            <p class="mb-1">
                                <b>{{ __('Amount') }} :</b>
                                {{ priceFormat($membership->amount) }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1">
                                <b>{{ __('Class') }} :</b>

                                @if (!empty($membership->classes_id))
                                    @foreach ($membership->claases() as $class)
                                        {{ $class->title }},
                                    @endforeach
                                @else
                                    -
                                @endif

                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1">
                                <b>{{ __('Notes') }} :</b>
                                {{ $membership->notes }}
                            </p>
                        </div>

                    </div>
                </div>


            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-xxl-12 cdx-xxl-100">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Trainee') }}</h4>
                </div>
                <div class="card-body pt-0">
                    <div class="dt-responsive table-responsive">
                        <table class="table table-hover">

                            <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Phone Number') }}</th>
                                    <th>{{ __('Membership Start Date') }}</th>
                                    <th>{{ __('Membership Expiry Date') }}</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($trainees as $trainee)
                                    <tr>
                                        <td>{{ traineePrefix() . $trainee->trainee_id }} </td>
                                        <td class="table-user">
                                            <img src="{{ !empty($trainee->userDetail->avatar) ? asset(Storage::url('upload/profile')) . '/' . $trainee->userDetail->avatar : asset(Storage::url('upload/profile')) . '/avatar.png' }}"
                                                alt="" class="mr-2 avatar-sm rounded-circle user-avatar">
                                            <a href="#"
                                                class="text-body font-weight-semibold">{{ $trainee->userDetail->name }}</a>
                                        </td>
                                        <td>{{ !empty($trainee->userDetail->email) ? $trainee->userDetail->email : '-' }}
                                        </td>
                                        <td>{{ !empty($trainee->userDetail->phone_number) ? $trainee->userDetail->phone_number : '-' }}
                                        </td>
                                        <td>{{ !empty($trainee->membership_start_date) ? dateFormat($trainee->membership_start_date) : '-' }}
                                        </td>
                                        <td>{{ !empty($trainee->membership_expiry_date) ? dateFormat($trainee->membership_expiry_date) : __('Lifetime') }}
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
