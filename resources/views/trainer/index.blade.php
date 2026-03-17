@extends('layouts.app')
@php
    $profile = asset(Storage::url('upload/profile/'));
@endphp
@section('page-title')
    {{ __('Trainers') }}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">
                {{ __('Dashboard') }}
            </a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">
                {{ __('Trainers') }}
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
                            <h5>{{ __('Trainer List') }}</h5>
                        </div>
                        @if (Gate::check('create trainer'))
                            <div class="col-auto">
                                <a href="{{ route('trainers.create') }}" class="btn btn-secondary" data-size="lg" data-title="{{ __('Create Trainer') }}"> <i
                                        class="ti ti-circle-plus align-text-bottom"></i> {{ __('Create Trainer') }}</a>
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
                                    <th>{{ __('Classes') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    @if (Gate::check('edit trainer') || Gate::check('delete trainer') || Gate::check('show trainer'))
                                        <th>{{ __('Action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trainers as $trainer)
                                    <tr>
                                        <td>{{ trainerPrefix() . $trainer->trainerDetail->trainer_id }} </td>
                                        <td class="table-user">
                                            <img src="{{ !empty($trainer->profile) ? asset(Storage::url('upload/profile/' . $trainer->profile)) : asset(Storage::url('upload/profile/avatar.png')) }}"
                                                alt="" class="mr-2 avatar-sm rounded-circle user-avatar">
                                            <a href="#"
                                                class="text-body font-weight-semibold">{{ $trainer->name }}</a>
                                        </td>

                                        <td>{{ $trainer->email }} </td>
                                        <td>{{ !empty($trainer->phone_number) ? $trainer->phone_number : '-' }} </td>
                                        <td>
                                            @foreach ($trainer->classAssign() as $class)
                                                {{ $class }}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @if (!empty($trainer->trainerDetail) && $trainer->trainerDetail->status == 1)
                                                <span
                                                    class="badge text-bg-success">{{ App\Models\TrainerDetail::$status[$trainer->trainerDetail->status] }}</span>
                                            @else
                                                <span
                                                    class="badge text-bg-danger">{{ App\Models\TrainerDetail::$status[$trainer->trainerDetail->status] }}</span>
                                            @endif

                                        </td>
                                        @if (Gate::check('edit trainer') || Gate::check('delete trainer') || Gate::check('show trainer'))
                                            <td>
                                                <div class="cart-action">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['trainers.destroy', encrypt($trainer->id)]]) !!}
                                                    @can('show trainer')
                                                        <a class="avtar avtar-xs btn-link-warning text-warning "
                                                            data-bs-toggle="tooltip" data-size="lg"
                                                            data-bs-original-title="{{ __('Details') }}"
                                                            href="{{ route('trainers.show', \Illuminate\Support\Facades\Crypt::encrypt($trainer->id)) }}">
                                                            <i data-feather="eye"></i></a>
                                                    @endcan
                                                    @can('edit trainer')
                                                        <a class="avtar avtar-xs btn-link-secondary text-secondary"
                                                            data-bs-toggle="tooltip" data-size="lg"
                                                            data-bs-original-title="{{ __('Edit') }}"
                                                            href="{{ route('trainers.edit', encrypt($trainer->id)) }}"
                                                            data-title="{{ __('Edit Trainer') }}"> <i
                                                                data-feather="edit"></i></a>
                                                    @endcan
                                                    @can('delete trainer')
                                                        <a class="avtar avtar-xs btn-link-danger text-danger confirm_dialog"
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
