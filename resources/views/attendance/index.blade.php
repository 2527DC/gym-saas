@extends('layouts.app')
@section('page-title')
    {{ __('Attendance') }}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">
                {{ __('Attendance') }}
            </a>
        </li>
    </ul>
@endsection
@section('card-action-btn')
    @if (Gate::check('create attendance'))
        <a class="btn btn-secondary btn-sm ml-20 customModal" href="#" data-size="md"
            data-url="{{ route('attendances.create') }}" data-title="{{ __('Create Attendance') }}"> <i
                class="ti-plus mr-5"></i>
            {{ __('Create Attendance') }}
        </a>
    @endif
@endsection
@section('content')
    <div class="row">

        <div class="card">
            <div class="col-12">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5>{{ __('Attendance List') }}</h5>
                        </div>
                        @if (Gate::check('create attendance'))
                            <div class="col-auto">
                                <a href="#" class="btn btn-secondary customModal" data-size="lg"
                                    data-url="{{ route('attendances.create') }}" data-title="{{ __('Create Attendance') }}">
                                    <i class="ti ti-circle-plus align-text-bottom"></i>
                                    {{ __('Create Attendance') }}</a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="dt-responsive table-responsive">
                        <table class="table table-hover advance-datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('User') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Checked In Time') }}</th>
                                    <th>{{ __('Checked Out Time') }}</th>
                                    <th>{{ __('Notes') }}</th>
                                    @if (Gate::check('edit attendance') || Gate::check('delete attendance'))
                                        <th>{{ __('Action') }}</th>
                                    @endif

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendances as $attendance)
                                    <tr>
                                        <td>{{ !empty($attendance->users) ? $attendance->users->name : '-' }} </td>
                                        <td>{{ dateFormat($attendance->date) }} </td>
                                        <td>{{ timeFormat($attendance->checked_in_time) }} </td>
                                        <td>{{ timeFormat($attendance->checked_out_time) }} </td>
                                        <td>{{ $attendance->notes }} </td>
                                        @if (Gate::check('edit attendance') || Gate::check('delete attendance'))
                                            <td>
                                                <div class="cart-action">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['attendances.destroy', encrypt($attendance->id)]]) !!}

                                                    @can('edit attendance')
                                                        <a class="btn btn-icon avtar-xs btn-link-secondary customModal" data-bs-toggle="tooltip"
                                                            data-size="md" data-bs-original-title="{{ __('Edit') }}"
                                                            href="#"
                                                            data-url="{{ route('attendances.edit', encrypt($attendance->id)) }}"
                                                            data-title="{{ __('Edit Attendance') }}"> <i
                                                                data-feather="edit"></i></a>
                                                    @endcan
                                                    @can('delete attendance')
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
