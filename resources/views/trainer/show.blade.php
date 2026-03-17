@extends('layouts.app')
@section('page-title')
    {{ traineePrefix() . $trainerDetail->id }} {{ __('Details') }}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('trainers.index') }}">{{ __('Trainer') }}</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">
                {{ traineePrefix() . $trainerDetail->id }} {{ __('Details') }}
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
                    <div class="tab-content">
                        <div class="tab-pane show active" id="profile-1" role="tabpanel" aria-labelledby="profile-tab-1">
                            <div class="row">
                                <div class="col-lg-4 col-xxl-3">
                                    <div class="card border">
                                        <div class="card-header">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="{{ !empty($trainer->profile) ? asset(Storage::url('upload/profile/' . $trainer->profile)) : asset(Storage::url('upload/profile/avatar.png')) }}"
                                                alt="" class="mr-2 avatar-sm rounded-circle user-avatar">
                                                </div>
                                                <div class="flex-grow-1 mx-3">
                                                    <h5 class="mb-1">{{ $trainer->name }}</h5>
                                                    <h6 class="text-muted mb-0">{{ $trainerDetail->qualification }}</h6>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="card-body px-2 pb-0">
                                            <div class="list-group list-group-flush">
                                                <a href="#" class="list-group-item list-group-item-action">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="material-icons-two-tone f-20">email</i>
                                                        </div>
                                                        <div class="flex-grow-1 mx-3">
                                                            <h5 class="m-0">{{ __('Email') }}</h5>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <small>{{ $trainer->email }}</small>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="#" class="list-group-item list-group-item-action">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="material-icons-two-tone f-20">phonelink_ring</i>
                                                        </div>
                                                        <div class="flex-grow-1 mx-3">
                                                            <h5 class="m-0">{{ __('Phone') }}</h5>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <small>{{ $trainer->phone_number }}</small>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="#" class="list-group-item list-group-item-action">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="material-icons-two-tone f-20">accessibility</i>
                                                        </div>
                                                        <div class="flex-grow-1 mx-3">
                                                            <h5 class="m-0">{{ __('Gender') }}</h5>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <small>{{ $trainerDetail->gender }}</small>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="#" class="list-group-item list-group-item-action">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="material-icons-two-tone f-20">date_range</i>
                                                        </div>
                                                        <div class="flex-grow-1 mx-3">
                                                            <h5 class="m-0">{{ __('Date of Birth') }}</h5>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <small>{{  dateFormat($trainerDetail->dob) }}</small>
                                                        </div>
                                                    </div>
                                                </a>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-8 col-xxl-9">
                                    <div class="card border">
                                        <div class="card-header">
                                            <h5>{{ __('Additional Details') }}</h5>
                                        </div>
                                        <div class="card-body">

                                            <div class="table-responsive">
                                                <table class="table table-borderless">
                                                    <tbody>

                                                        <tr>
                                                            <td><b class="text-header">{{ __('Address') }}</b></td>
                                                            <td>:</td>
                                                            <td>{{ $trainerDetail->address }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b class="text-header">{{ __('Country') }}</b></td>
                                                            <td>:</td>
                                                            <td>{{ $trainerDetail->country }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b class="text-header">{{ __('State') }}</b></td>
                                                            <td>:</td>
                                                            <td>{{ $trainerDetail->state }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b class="text-header">{{ __('City') }}</b></td>
                                                            <td>:</td>
                                                            <td>{{ $trainerDetail->city }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b class="text-header">{{ __('Zip Code') }}</b></td>
                                                            <td>:</td>
                                                            <td>{{ $trainerDetail->zip_code }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b class="text-header">{{ __('Class') }}</b></td>
                                                            <td>:</td>
                                                            <td>
                                                                @foreach ($trainer->classAssign() as $class)
                                                                    {{ $class }}
                                                                    <br>
                                                                @endforeach
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
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
    </div>


    <div class="row">
        <div class="col-xxl-12 cdx-xxl-100">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Assign Trainee') }}</h4>
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
                                    <th>{{ __('Membership') }}</th>
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
                                        <td>{{ !empty($trainee->membership) ? $trainee->membership->title : '-' }} </td>
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
