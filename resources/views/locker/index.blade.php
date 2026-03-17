@extends('layouts.app')
@section('page-title')
    {{ __('Locker') }}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#"> {{ __('Locker') }}</a>
        </li>
    </ul>
@endsection
@section('content')
    <div class="row">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center g-2">
                            <div class="col">
                                <h5>{{ __('Locker List') }}</h5>
                            </div>
                            @if (Gate::check('create locker'))
                                <div class="col-auto">
                                    <a href="#" class="btn btn-secondary customModal" data-size="md"
                                        data-url="{{ route('locker.create') }}" data-title="{{ __('Create locker') }}">
                                        <i class="ti ti-circle-plus align-text-bottom"></i> {{ __('Create Locker') }}</a>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="dt-responsive table-responsive">
                            <table class="table table-hover advance-datatable">
                                <thead>
                                    <tr>
                                        <th>{{ __('Id') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Avaiable') }}</th>
                                        @if (Gate::check('edit locker') || Gate::check('delete locker') || Gate::check('show locker'))
                                            <th>{{ __('Action') }}</th>
                                        @endif

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lockers as $locker)
                                        <tr>
                                            <td>{{ lockerPrefix() . $locker->id }} </td>
                                            <td>
                                                {!! $locker->status_badge_html !!}
                                            </td>
                                            <td>
                                                {!! $locker->available_badge_html !!}
                                            </td>

                                            @if (Gate::check('edit locker') || Gate::check('delete locker') || Gate::check('show locker'))
                                                <td>
                                                    <div class="cart-action">
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['locker.destroy', encrypt($locker->id)]]) !!}
                                                        @can('show locker')
                                                            <a class="btn btn-icon avtar-xs btn-link-warning "
                                                                data-bs-toggle="tooltip"
                                                                data-bs-original-title="{{ __('Details') }}"
                                                                href="{{ route('locker.show', \Illuminate\Support\Facades\Crypt::encrypt($locker->id)) }}">
                                                                <i data-feather="eye"></i></a>
                                                        @endcan
                                                        @can('edit locker')
                                                            <a class="btn btn-icon avtar-xs btn-link-secondary customModal"
                                                                data-bs-toggle="tooltip" data-size="md"
                                                                data-bs-original-title="{{ __('Edit') }}" href="#"
                                                                data-url="{{ route('locker.edit', encrypt($locker->id)) }}"
                                                                data-title="{{ __('Edit Locker') }}"> <i
                                                                    data-feather="edit"></i></a>
                                                        @endcan
                                                        @can('delete locker')
                                                            <a class=" btn btn-icon avtar-xs btn-link-danger confirm_dialog"
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
    </div>
@endsection
