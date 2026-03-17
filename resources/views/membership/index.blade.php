@extends('layouts.app')

@section('page-title')
    {{ __('Membership') }}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">
                {{ __('Membership') }}
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
                            <h5>{{ __('Membership List') }}</h5>
                        </div>
                        @if (Gate::check('create membership'))
                            <div class="col-auto">
                                <a href="#" class="btn btn-secondary customModal" data-size="lg"
                                    data-url="{{ route('membership.create') }}" data-title="{{ __('Create Membership') }}">
                                    <i class="ti ti-circle-plus align-text-bottom"></i> {{ __('Create Membership') }}</a>
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
                                    <th>{{ __('Package') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('Class') }}</th>
                                    @if (Gate::check('edit membership') || Gate::check('delete membership') || Gate::check('show membership'))
                                        <th>{{ __('Action') }}</th>
                                    @endif

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($memberships as $membership)
                                    <tr>
                                        <td>{{ $membership->title }} </td>
                                        <td>
                                            {{ \App\Models\Membership::$package[$membership->package] }}
                                        </td>
                                        <td>{{ priceFormat($membership->amount) }} </td>

                                        <td>
                                            @if (!empty($membership->classes_id))
                                                @foreach ($membership->claases() as $class)
                                                    {{ $class->title }}<br>
                                                @endforeach
                                            @else
                                                -
                                            @endif
                                        </td>

                                        @if (Gate::check('edit membership') || Gate::check('delete membership') || Gate::check('show membership'))
                                            <td>
                                                <div class="cart-action">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['membership.destroy', encrypt($membership->id)]]) !!}
                                                    @can('show membership')
                                                        <a class="btn btn-icon avtar-xs btn-link-warning " data-bs-toggle="tooltip" data-size="lg"
                                                            data-bs-original-title="{{ __('Details') }}"
                                                            href="{{ route('membership.show', \Illuminate\Support\Facades\Crypt::encrypt($membership->id)) }}">
                                                            <i data-feather="eye"></i></a>
                                                    @endcan
                                                    @can('edit membership')
                                                        <a class="btn btn-icon avtar-xs btn-link-secondary customModal" data-bs-toggle="tooltip"
                                                            data-size="lg" data-bs-original-title="{{ __('Edit') }}"
                                                            href="#"
                                                            data-url="{{ route('membership.edit', encrypt($membership->id)) }}"
                                                            data-title="{{ __('Edit Membership') }}"> <i
                                                                data-feather="edit"></i></a>
                                                    @endcan
                                                    @can('delete membership')
                                                        <a class=" btn btn-icon avtar-xs btn-link-danger confirm_dialog" data-bs-toggle="tooltip"
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
