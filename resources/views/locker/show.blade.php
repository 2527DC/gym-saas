@extends('layouts.app')

@section('page-title')
    {{ lockerPrefix() . $locker->id }}
@endsection

@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('locker.index') }}">{{ __('Locker') }}</a>
        </li>
        <li class="breadcrumb-item active">
            {{ lockerPrefix() . $locker->id }}
        </li>
    </ul>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">{{ __('Locker Details') }}</h4>
                </div>
                <div class="card-body">
                    <table class="table table-responsive table-borderless">
                        <tr>
                            <th>{{ __('Locker ID') }}</th>
                            <td>{{ lockerPrefix() . $locker->id }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Status') }}</th>
                            <td>{!! $locker->status_badge_html !!}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Availability') }}</th>
                            <td>{!! $locker->available_badge_html !!}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5>{{ __('Assigned Users') }}</h5>
                        </div>
                        @if (Gate::check('create assign locker'))
                            @if ($locker->status == 1 && $locker->available == 1)
                                <div class="col-auto">
                                    <a href="#" class="btn btn-secondary customModal" data-size="md"
                                        data-url="{{ route('assign.locker', $locker->id) }}"
                                        data-title="{{ __('Assign Locker') }}">
                                        <i class="ti ti-circle-plus align-text-bottom"></i> {{ __('Assign Locker') }}
                                    </a>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>

                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-hover advance-datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('User Name') }}</th>
                                    <th>{{ __('Assign Date') }}</th>
                                    <th>{{ __('End Date') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($assignLockers as $assigned)
                                    <tr>
                                        <td>{{ $assigned->user->name ?? '-' }}</td>
                                        <td>{{ date($setting['company_date_format'], strtotime($assigned->assign_date)) }}
                                        </td>
                                        <td>{{ $assigned->end_date ? date($setting['company_date_format'], strtotime($assigned->end_date)) : __('N/A') }}
                                        </td>
                                        <td>
                                            @if (Gate::check('edit assign locker'))
                                                @if (!$assigned->end_date)
                                                    <div class="cart-action d-flex gap-1">
                                                        <a class="btn btn-icon avtar-xs btn-link-secondary customModal"
                                                            data-bs-toggle="tooltip" data-size="md"
                                                            data-bs-original-title="{{ __('Edit') }}" href="#"
                                                            data-url="{{ route('assign.locker.edit', $assigned->id) }}"
                                                            data-title="{{ __('Edit Locker') }}">
                                                            <i data-feather="edit"></i>
                                                        </a>

                                                    </div>
                                                @endif
                                            @endif
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
