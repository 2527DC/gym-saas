@extends('layouts.app')
@section('page-title')
    {{ __('Workout Activity') }}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">
                {{ __('Workout Activity') }}
            </a>
        </li>
    </ul>
@endsection
@section('card-action-btn')
    @if (Gate::check('create workout activity'))
        <a class="btn btn-secondary btn-sm ml-20 customModal" href="#" data-size="md"
            data-url="{{ route('activity.create') }}" data-title="{{ __('Create Activity') }}"> <i class="ti-plus mr-5"></i>
            {{ __('Create Activity') }}
        </a>
    @endif
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5>{{ __('Activity List') }}</h5>
                        </div>
                        @if (Gate::check('create workout activity'))
                            <div class="col-auto">
                                <a href="#" class="btn btn-secondary customModal" data-size="lg"
                                    data-url="{{ route('activity.create') }}"data-title="{{ __('Create Activity') }}">
                                    <i class="ti ti-circle-plus align-text-bottom"></i>
                                    {{ __('Create Activity') }}</a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="dt-responsive table-responsive">
                        <table class="table table-hover advance-datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Created At') }}</th>
                                    @if (Gate::check('edit workout activity') || Gate::check('delete workout activity'))
                                        <th>{{ __('Action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($activities as $activity)
                                    <tr>
                                        <td>{{ $activity->title }} </td>
                                        <td>{{ dateFormat($activity->created_at) }} </td>
                                        @if (Gate::check('edit workout activity') || Gate::check('delete workout activity'))
                                            <td>
                                                <div class="cart-action">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['activity.destroy', $activity->id]]) !!}
                                                    @can('edit workout activity')
                                                        <a class="btn btn-icon avtar-xs btn-link-secondary customModal" data-bs-toggle="tooltip"
                                                            data-size="md" data-bs-original-title="{{ __('Edit') }}"
                                                            href="#"
                                                            data-url="{{ route('activity.edit', $activity->id) }}"
                                                            data-title="{{ __('Edit Activity') }}"> <i
                                                                data-feather="edit"></i></a>
                                                    @endcan
                                                    @can('delete workout activity')
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
