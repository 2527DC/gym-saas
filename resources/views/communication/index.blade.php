@extends('layouts.app')
@section('page-title')
    {{ __('Communication Logs') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Communication Logs') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="pc-dt-simple">
                            <thead>
                                <tr>
                                    <th>{{ __('Member') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Scheduled At') }}</th>
                                    <th>{{ __('Sent At') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('External ID') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reminders as $reminder)
                                    <tr>
                                        <td>{{ $reminder->trainee->name ?? 'N/A' }}</td>
                                        <td>{{ ucfirst($reminder->type) }}</td>
                                        <td>{{ $reminder->scheduled_at }}</td>
                                        <td>{{ $reminder->sent_at ?? __('Pending') }}</td>
                                        <td>
                                            @if ($reminder->status == 'pending')
                                                <span class="badge bg-warning">{{ __('Pending') }}</span>
                                            @elseif($reminder->status == 'sent')
                                                <span class="badge bg-success">{{ __('Sent') }}</span>
                                            @elseif($reminder->status == 'failed')
                                                <span class="badge bg-danger">{{ __('Failed') }}</span>
                                            @elseif($reminder->status == 'canceled')
                                                <span class="badge bg-secondary">{{ __('Canceled') }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $reminder->external_schedule_id ?? 'N/A' }}</td>
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
