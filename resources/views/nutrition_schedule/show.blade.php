@extends('layouts.app')

@section('page-title')
    {{ __('Show Nutrition Schedule') }}
@endsection

@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('nutrition-schedule.index') }}">{{ __('Nutrition Schedule') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Detail') }}</li>
    </ul>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Nutrition Schedule') }}</h5>
                </div>

                <div class="card-body">
                    <div class="mb-4 row">
                        <div class="col-md-4">
                            <p><strong>{{ __('Trainee Name') }}:</strong> {{ $nutritionSchedule->user->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>{{ __('Start Date') }}:</strong> {{ \Carbon\Carbon::parse($nutritionSchedule->start_date)->format('F j, Y') }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>{{ __('End Date') }}:</strong> {{ \Carbon\Carbon::parse($nutritionSchedule->end_date)->format('F j, Y') }}</p>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle table-bordered">
                            <thead class="table-secondary">
                                <tr>
                                    <th style="width: 15%">{{ __('Day') }}</th>
                                    <th style="width: 20%">{{ __('Meal Time') }}</th>
                                    <th>{{ __('Meal Description') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $schedule = json_decode($nutritionSchedule->schedules, true);
                                    $selectedDays = $schedule['selected_days'] ?? [];
                                    $meals = $schedule['daily_nutrition_plan']['meals'] ?? [];
                                    $mealDescriptions = $schedule['daily_nutrition_plan']['meal_descriptions'] ?? [];
                                    $days = [
                                        'Sunday',
                                        'Monday',
                                        'Tuesday',
                                        'Wednesday',
                                        'Thursday',
                                        'Friday',
                                        'Saturday',
                                    ];
                                    $displayDays = in_array('All', $selectedDays) ? $days : $selectedDays;
                                @endphp

                                @forelse ($displayDays as $day)
                                    @foreach ($meals as $index => $meal)
                                        <tr>
                                            @if ($index == 0)
                                                <td rowspan="{{ count($meals) }}" class="fw-bold align-middle">
                                                    {{ $day }}</td>
                                            @endif
                                            <td>{{ ucwords(str_replace('_', ' ', $meal)) }}</td>
                                            <td class="text-wrap text-justify">{{ $mealDescriptions[$meal] ?? 'No description available.' }}</td>
                                        </tr>
                                    @endforeach
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">
                                            {{ __('No schedule data available.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css-page')
    <style>
        .table th,
        .table td {
            vertical-align: middle;
        }

        .card-header {
            font-size: 1rem;
            font-weight: 600;
        }

        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
        }
    </style>
@endpush
