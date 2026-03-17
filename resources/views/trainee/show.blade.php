@extends('layouts.app')
@section('page-title')
    {{ traineePrefix() . $traineeDetail->id }} {{ __('Details') }}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('trainees.index') }}">{{ __('Trainee') }}</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">
                {{ traineePrefix() . $traineeDetail->id }} {{ __('Details') }}
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
                                <div class="col-lg-6 col-xxl-4">
                                    <div class="card border">
                                        <div class="card-header">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="{{ !empty($trainee->profile) ? asset(Storage::url('upload/profile/' . $trainee->profile)) : asset(Storage::url('upload/profile/avatar.png')) }}"
                                                        alt="" class="mr-2 avatar-sm rounded-circle user-avatar">
                                                </div>
                                                <div class="flex-grow-1 mx-3">
                                                    <h5 class="mb-1">{{ $trainee->name }}</h5>
                                                    <h6 class="text-muted mb-0">{{ $traineeDetail->qualification }}</h6>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="card-body px-2 pb-0">
                                            <div class="list-group list-group-flush">
                                                <div class="list-group-item list-group-item-action">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="material-icons-two-tone f-20">email</i>
                                                        </div>
                                                        <div class="flex-grow-1 mx-3">
                                                            <h5 class="m-0">{{ __('Email') }}</h5>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <p>{{ $trainee->email }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="list-group-item list-group-item-action">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="material-icons-two-tone f-20">phonelink_ring</i>
                                                        </div>
                                                        <div class="flex-grow-1 mx-3">
                                                            <h5 class="m-0">{{ __('Phone') }}</h5>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <p>{{ $trainee->phone_number }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="list-group-item list-group-item-action">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="material-icons-two-tone f-20">accessibility</i>
                                                        </div>
                                                        <div class="flex-grow-1 mx-3">
                                                            <h5 class="m-0">{{ __('Gender') }}</h5>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <p>{{ $traineeDetail->gender }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="list-group-item list-group-item-action">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="material-icons-two-tone f-20">date_range</i>
                                                        </div>
                                                        <div class="flex-grow-1 mx-3">
                                                            <h5 class="m-0">{{ __('Date of Birth') }}</h5>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <p>{{ dateFormat($traineeDetail->dob) }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="list-group-item list-group-item-action">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="material-icons-two-tone f-20">data_usage</i>
                                                        </div>
                                                        <div class="flex-grow-1 mx-3">
                                                            <h5 class="m-0">{{ __('Age') }}</h5>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <p>{{ $traineeDetail->age }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="list-group-item list-group-item-action">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="material-icons-two-tone f-20">check_circle</i>
                                                        </div>
                                                        <div class="flex-grow-1 mx-3">
                                                            <h5 class="m-0">{{ __('Status') }}</h5>
                                                        </div>
                                                        <td>
                                                            @if (!empty($trainee->traineeDetail) && $trainee->traineeDetail->status == 1)
                                                                <span
                                                                    class="badge text-bg-success">{{ App\Models\traineeDetail::$status[$trainee->traineeDetail->status] }}</span>
                                                            @else
                                                                <span
                                                                    class="badge text-bg-danger">{{ App\Models\traineeDetail::$status[$trainee->traineeDetail->status] }}</span>
                                                            @endif
                                                        </td>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-6 col-xxl-4">
                                    <div class="card border">
                                        <div class="card-header">
                                            <h5>{{ __('Additional Details') }}</h5>
                                        </div>
                                        <div class="card-body">

                                            <div class="table-responsive">
                                                <table class="table table-borderless">
                                                    <tbody>
                                                        <tr>
                                                            <td><b class="text-header">{{ __('Category') }}</b></td>
                                                            <td>:</td>
                                                            <td>{{ !empty($traineeDetail->categorys) ? $trainee->traineeDetail->categorys->title : '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><b class="text-header">{{ __('Fitness Goal') }}</b></td>
                                                            <td>:</td>
                                                            <td>{{ $traineeDetail->fitness_goal }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b class="text-header">{{ __('Address') }}</b></td>
                                                            <td>:</td>
                                                            <td>{{ $traineeDetail->address }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b class="text-header">{{ __('Country') }}</b></td>
                                                            <td>:</td>
                                                            <td>{{ $traineeDetail->country }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b class="text-header">{{ __('State') }}</b></td>
                                                            <td>:</td>
                                                            <td>{{ $traineeDetail->state }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b class="text-header">{{ __('City') }}</b></td>
                                                            <td>:</td>
                                                            <td>{{ $traineeDetail->city }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b class="text-header">{{ __('Zip Code') }}</b></td>
                                                            <td>:</td>
                                                            <td>{{ $traineeDetail->zip_code }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b class="text-header">{{ __('Class') }}</b></td>
                                                            <td>:</td>
                                                            <td>
                                                                @foreach ($trainee->classAssign() as $class)
                                                                    {{ $class }}
                                                                    <br>
                                                                @endforeach
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><b class="text-header">{{ __('Document') }}</b></td>
                                                            <td>:</td>
                                                            <td>
                                                                @if (!empty($traineeDetail->document))
                                                                    <div class="d-flex flex-wrap align-items-center gap-2">
                                                                        <span
                                                                            class="text-wrap">{{ $traineeDetail->document }}</span>
                                                                        <a href="{{ asset('storage/upload/document/' . $traineeDetail->document) }}"
                                                                            download class="text-decoration-none"
                                                                            data-bs-toggle="tooltip"
                                                                            title="{{ __('Download') }}">
                                                                            <i class="fa fa-download fs-5"></i>
                                                                        </a>
                                                                    </div>
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-xxl-4">
                                    <div class="card border">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5>{{ __('Membership Details') }}</h5>
                                            @if (
                                                !empty($trainee->traineeDetail) &&
                                                    !empty($trainee->traineeDetail->membership_expiry_date) &&
                                                    \Carbon\Carbon::parse($trainee->traineeDetail->membership_expiry_date)->isPast())
                                                <div class="col-auto">
                                                    <a href="#" class="btn btn-secondary customModal" data-size="lg"
                                                        data-url="{{ route('membership.renew', [$trainee->id]) }}"
                                                        data-title="{{ __('Renew Membership') }}">
                                                        <i class="ti ti-circle-plus align-text-bottom"></i>
                                                        {{ __('Renew Membership') }}
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-borderless">
                                                    <tbody>
                                                        <tr>
                                                            <td><b class="text-header">{{ __('Membership') }}</b></td>
                                                            <td>:</td>
                                                            <td>{{ !empty($trainee->traineeDetail) ? (!empty($trainee->traineeDetail->membership) ? $trainee->traineeDetail->membership->title : '-') : '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><b
                                                                    class="text-header">{{ __('Membership Start Date') }}</b>
                                                            </td>
                                                            <td>:</td>
                                                            <td>{{ !empty($trainee->traineeDetail) ? (!empty($trainee->traineeDetail->membership_start_date) ? dateFormat($trainee->traineeDetail->membership_start_date) : __('Lifetime')) : '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><b
                                                                    class="text-header">{{ __('Membership Expiry Date') }}</b>
                                                            </td>
                                                            <td>:</td>
                                                            <td>{{ !empty($trainee->traineeDetail) ? (!empty($trainee->traineeDetail->membership_expiry_date) ? dateFormat($trainee->traineeDetail->membership_expiry_date) : __('Lifetime')) : '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><b class="text-header">{{ __('Membership Status') }}</b>
                                                            </td>
                                                            <td>:</td>
                                                            <td>
                                                                @if (!empty($trainee->traineeDetail) && !empty($trainee->traineeDetail->membership_expiry_date))
                                                                    <span
                                                                        class="badge {{ \Carbon\Carbon::parse($trainee->traineeDetail->membership_expiry_date)->isPast() ? 'bg-danger' : 'bg-success' }}">
                                                                        {{ \Carbon\Carbon::parse($trainee->traineeDetail->membership_expiry_date)->isPast() ? __('Expired') : __('Active') }}
                                                                    </span>
                                                                @else
                                                                    <span
                                                                        class="badge bg-success">{{ __('Active') }}</span>
                                                                @endif
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
    @if (Auth::user()->type === 'owner')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center g-2">
                            <div class="col">
                                <h5>{{ __('Invoice List') }}</h5>
                            </div>

                        </div>
                    </div>

                    <div class="card-body pt-0">
                        <div class="dt-responsive table-responsive">
                            <table class="table table-hover advance-datatable">
                                <thead>
                                    <tr>
                                        <th>{{ __('Invoice') }}</th>
                                        <th>{{ __('Invoice Date') }}</th>
                                        <th>{{ __('Due Date') }}</th>
                                        <th>{{ __('Amount') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        @if (Gate::check('edit invoice') || Gate::check('delete invoice') || Gate::check('show invoice'))
                                            <th class="text-right">{{ __('Action') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoices as $invoice)
                                        <tr role="row">
                                            <td>{{ invoicePrefix() . $invoice->invoice_id }} </td>
                                            <td>{{ dateFormat($invoice->invoice_date) }} </td>
                                            <td>{{ dateFormat($invoice->invoice_due_date) }} </td>
                                            <td>{{ priceFormat($invoice->getInvoiceSubTotalAmount()) }}</td>
                                            <td>
                                                @if ($invoice->status == 'unpaid')
                                                    <span
                                                        class="badge text-bg-danger">{{ \App\Models\Invoice::$status[$invoice->status] }}</span>
                                                @elseif($invoice->status == 'paid')
                                                    <span
                                                        class="badge text-bg-success">{{ \App\Models\Invoice::$status[$invoice->status] }}</span>
                                                @elseif($invoice->status == 'partial_paid')
                                                    <span
                                                        class="badge text-bg-warning">{{ \App\Models\Invoice::$status[$invoice->status] }}</span>
                                                @endif
                                            </td>
                                            @if (Gate::check('edit invoice') || Gate::check('delete invoice') || Gate::check('show invoice'))
                                                <td class="text-right">
                                                    <div class="cart-action">
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['invoices.destroy', $invoice->id]]) !!}
                                                        @can('show invoice')
                                                            <a class="btn btn-icon avtar-xs btn-link-warning"
                                                                href="{{ route('invoices.show', \Illuminate\Support\Facades\Crypt::encrypt($invoice->id)) }}"
                                                                data-bs-toggle="tooltip"
                                                                data-bs-original-title="{{ __('View') }}"> <i
                                                                    data-feather="eye"></i></a>
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
    @endif
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5>{{ __('Health Update List') }}</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="dt-responsive table-responsive">
                        <table class="table table-hover advance-datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('Trainee') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Notes') }}</th>
                                    @if (Gate::check('edit health update') || Gate::check('delete health update') || Gate::check('show health update'))
                                        <th>{{ __('Action') }}</th>
                                    @endif

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($healthUpdates as $health)
                                    <tr>
                                        <td>{{ !empty($health->users) ? $health->users->name : '-' }} </td>
                                        <td>{{ dateFormat($health->measurement_date) }} </td>
                                        <td>{{ $health->notes }} </td>
                                        @if (Gate::check('edit health update') || Gate::check('delete health update') || Gate::check('show health update'))
                                            <td>
                                                <div class="cart-action">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['health-update.destroy', $health->id]]) !!}
                                                    @can('show health update')
                                                        <a class="btn btn-icon avtar-xs btn-link-warning customModal"
                                                            data-bs-toggle="tooltip" data-size="lg"
                                                            data-bs-original-title="{{ __('Details') }}"
                                                            data-title="{{ __('Details') }}"
                                                            data-url="{{ route('health-update.show', $health->id) }}"
                                                            href="#"> <i data-feather="eye"></i></a>
                                                    @endcan
                                                    @can('edit health update')
                                                        <a class="btn btn-icon avtar-xs btn-link-secondary customModal"
                                                            data-bs-toggle="tooltip" data-size="lg"
                                                            data-bs-original-title="{{ __('Edit') }}" href="#"
                                                            data-url="{{ route('health-update.edit', $health->id) }}"
                                                            data-title="{{ __('Edit Health Update') }}"> <i
                                                                data-feather="edit"></i></a>
                                                    @endcan
                                                    @can('delete health update')
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5>{{ __('Workout List') }}</h5>
                        </div>

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
                                                            data-url="{{ route('workouts.edit', $workout->id) }}"
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5>{{ __('Nutrition Schedule List') }}</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="dt-responsive table-responsive">
                        <table class="table table-hover advance-datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('User') }}</th>
                                    <th>{{ __('Start Date') }}</th>
                                    <th>{{ __('End Date') }}</th>
                                    @if (Gate::check('edit nutrition schedule') ||
                                            Gate::check('delete nutrition schedule') ||
                                            Gate::check('show nutrition schedule'))
                                        <th>{{ __('Action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($nutritionSchedules as $nutritionSchedule)
                                    <tr>
                                        <td class="table-user">
                                            <img src="{{ !empty($nutritionSchedule->user->profile) ? asset(Storage::url('upload/profile/' . $nutritionSchedule->user->profile)) : asset(Storage::url('upload/profile/avatar.png')) }}"
                                                alt="" class="mr-2 avatar-sm rounded-circle user-avatar">
                                            <a href="#"
                                                class="text-body font-weight-semibold">{{ !empty($nutritionSchedule->user->name) ? $nutritionSchedule->user->name : '-' }}</a>
                                        </td>
                                        <td>{{ $nutritionSchedule->start_date }}</>
                                        <td>{{ $nutritionSchedule->end_date }}</td>
                                        @if (Gate::check('edit nutrition schedule') ||
                                                Gate::check('delete nutrition schedule') ||
                                                Gate::check('show nutrition schedule'))
                                            <td>
                                                <div class="cart-action">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['nutrition-schedule.destroy', $nutritionSchedule->id]]) !!}
                                                    @can('show nutrition schedule')
                                                        <a class="avtar avtar-xs btn-link-warning text-warning"
                                                            data-bs-toggle="tooltip" data-size="lg"
                                                            data-bs-original-title="{{ __('Details') }}"
                                                            href="{{ route('nutrition-schedule.show', \Illuminate\Support\Facades\Crypt::encrypt($nutritionSchedule->id)) }}">
                                                            <i data-feather="eye"></i></a>
                                                    @endcan
                                                    @can('delete nutrition schedule')
                                                        <a class="avtar avtar-xs btn-link-danger text-danger confirm_dialog"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-original-title="{{ __('Delete') }}" href="#">
                                                            <i data-feather="trash-2"></i></a>
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
