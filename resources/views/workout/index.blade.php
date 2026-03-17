@extends('layouts.app')

@section('page-title')
    {{ __('Workout') }}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">
                {{ __('Workout') }}
            </a>
        </li>
    </ul>
@endsection
@section('card-action-btn')
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5>{{ __('Workout List') }}</h5>
                        </div>
                        @if (Gate::check('create workout'))
                            <div class="col-auto">
                                <a href="#" class="btn btn-secondary customModal" data-size="xl"
                                    data-url="{{ route('workouts.create') }}" data-title="{{ __('Create Workout') }}">
                                    <i class="ti ti-circle-plus align-text-bottom"></i> {{ __('Create Workout') }}</a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="dt-responsive table-responsive">
                        <table class="table table-hover advance-datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('Assign To') }}</th>
                                    <th>{{ __('Assign') }}</th>
                                    <th>{{ __('Start Date') }}</th>
                                    <th>{{ __('End Date') }}</th>
                                    @if (Gate::check('edit workout') || Gate::check('delete workout') || Gate::check('show workout'))
                                        <th>{{ __('Action') }}</th>
                                    @endif

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($workouts as $workout)
                                    <tr>
                                        <td>{{ ucfirst($workout->assign_to) }} </td>
                                        <td>
                                            @if ($workout->assign_to == 'trainee')
                                                {{ !empty($workout->assignDetail) ? $workout->assignDetail->name : '-' }}
                                            @else
                                                {{ !empty($workout->assignDetail) ? $workout->assignDetail->title : '-' }}
                                            @endif
                                        </td>
                                        <td>{{ dateFormat($workout->start_date) }} </td>
                                        <td>{{ dateFormat($workout->end_date) }} </td>
                                        @if (Gate::check('edit workout') || Gate::check('delete workout') || Gate::check('show workout'))
                                            <td>
                                                <div class="cart-action">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['workouts.destroy', $workout->id]]) !!}
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
                                                            data-url="{{ route('workouts.edit', encrypt($workout->id)) }}"
                                                            data-title="{{ __('Edit Workout') }}"> <i
                                                                data-feather="edit"></i></a>
                                                    @endcan
                                                    @can('delete workout')
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
