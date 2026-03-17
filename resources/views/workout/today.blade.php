@extends('layouts.app')

@section('page-title')
    {{ __('Today Workout') }}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">
                {{ __('Today Workout') }}
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
                <div class="card-body pt-0">
                    <div class="dt-responsive table-responsive">
                        <table class="table table-hover advance-datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Phone Number') }}</th>
                                    <th>{{ __('End Date') }}</th>
                                    @if (Gate::check('edit workout') || Gate::check('show workout'))
                                        <th>{{ __('Action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($workouts as $workout)
                                    <tr>
                                        <td class="table-user">
                                            <img src="{{ !empty($workout->assignDetail) && !empty($workout->assignDetail->avatar) ? asset(Storage::url('upload/profile')) . '/' . $workout->assignDetail->avatar : asset(Storage::url('upload/profile')) . '/avatar.png' }}"
                                                alt="" class="mr-2 avatar-sm rounded-circle user-avatar">
                                            <a href="#" class="text-body font-weight-semibold">
                                                {{ !empty($workout->assignDetail) ? $workout->assignDetail->name : '-' }}</a>
                                        </td>
                                        <td>
                                            {{ !empty($workout->assignDetail) ? $workout->assignDetail->email : '-' }}
                                        </td>
                                        <td>
                                            {{ !empty($workout->assignDetail) ? $workout->assignDetail->phone_number : '-' }}
                                        </td>
                                        <td>{{ dateFormat($workout->end_date) }} </td>
                                        @if (Gate::check('edit workout') || Gate::check('show workout'))
                                            <td>
                                                <div class="cart-action">
                                                    @can('show workout')
                                                        <a class="btn btn-icon avtar-xs btn-link-warning customModal"
                                                            data-bs-toggle="tooltip" data-size="lg"
                                                            data-bs-original-title="{{ __('Details') }}"
                                                            data-title="{{ __('Details') }}"
                                                            data-url="{{ route('workouts.show', \Illuminate\Support\Facades\Crypt::encrypt($workout->id)) }}"
                                                            href="#"> <i data-feather="eye"></i></a>
                                                    @endcan
                                                    @can('edit workout')
                                                        <a class="btn btn-icon avtar-xs btn-link-secondary customModal"
                                                            data-bs-toggle="tooltip" data-size="xl"
                                                            data-bs-original-title="{{ __('Edit') }}" href="#"
                                                            data-url="{{ route('workouts.edit', $workout->id) }}"
                                                            data-title="{{ __('Edit Workout') }}"> <i
                                                                data-feather="edit"></i></a>
                                                    @endcan
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
