@extends('layouts.app')

@section('page-title')
    {{ __('Classes') }}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">
                {{ __('Classes') }}
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
                            <h5>{{ __('Classes List') }}</h5>
                        </div>
                        @if (Gate::check('create class'))
                            <div class="col-auto">
                                <a href="#" class="btn btn-secondary customModal" data-size="lg"
                                    data-url="{{ route('classes.create') }}" data-title="{{ __('Create Classes') }}">
                                    <i class="ti ti-circle-plus align-text-bottom"></i> {{ __('Create Classes') }}</a>
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
                                    <th>{{ __('Fees') }}</th>
                                    <th>{{ __('Address') }}</th>
                                    <th>{{ __('Trainer') }}</th>
                                    <th>{{ __('Total Trainee') }}</th>
                                    @if (Gate::check('edit class') || Gate::check('delete class') || Gate::check('show class'))
                                        <th>{{ __('Action') }}</th>
                                    @endif

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($classes as $class)
                                    <tr>
                                        <td>{{ $class->title }} </td>
                                        <td>{{ priceFormat($class->fees) }} </td>
                                        <td>{{ $class->address }} </td>
                                        <td>
                                            @foreach ($class->classAssignTrainer as $trainer)
                                                {{ !empty($trainer->userDetail) ? $trainer->userDetail->name : '-' }}<br>
                                            @endforeach
                                        </td>
                                        <td>{{ count($class->classAssignTrainee) }} </td>
                                        @if (Gate::check('edit class') || Gate::check('delete class') || Gate::check('show class'))
                                            <td>
                                                <div class="cart-action">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['classes.destroy', $class->id]]) !!}
                                                    @can('show class')
                                                        <a class="btn btn-icon avtar-xs btn-link-warning " data-bs-toggle="tooltip" data-size="lg"
                                                            data-bs-original-title="{{ __('Details') }}"
                                                            href="{{ route('classes.show', \Illuminate\Support\Facades\Crypt::encrypt($class->id)) }}">
                                                            <i data-feather="eye"></i></a>
                                                    @endcan
                                                    @can('edit class')
                                                        <a class="btn btn-icon btn-xs btn-link-secondary customModal" data-bs-toggle="tooltip"
                                                            data-size="lg" data-bs-original-title="{{ __('Edit') }}"
                                                            href="#" data-url="{{ route('classes.edit', encrypt($class->id)) }}"
                                                            data-title="{{ __('Edit Class') }}"> <i
                                                                data-feather="edit"></i></a>
                                                    @endcan
                                                    @can('delete class')
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
