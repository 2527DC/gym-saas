@extends('layouts.app')

@section('page-title', __('Bulk Attendance'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Bulk Attendance') }}</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body">
                    {{ Form::open(['url' => route('bulk.attendance'), 'method' => 'GET', 'class' => 'row gx-3 gy-2 align-items-end']) }}

                    <div class="col-md-3">
                        {{ Form::label('type', __('Type') . ' <span class="text-danger">*</span>', ['class' => 'form-label'], false) }}
                        {{ Form::select('type', ['trainer' => __('Trainer'), 'trainee' => __('Trainee')], $type, [
                            'class' => 'form-control select2',
                            'placeholder' => __('Select Type'),
                            'required',
                        ]) }}
                    </div>

                    <div class="col-md-3">
                        {{ Form::label('date', __('Date') . ' <span class="text-danger">*</span>', ['class' => 'form-label'], false) }}
                        {{ Form::date('date', $date ?? date('Y-m-d'), ['class' => 'form-control', 'required']) }}
                    </div>

                    <div class="col-md-2">
                        <label class="form-label d-none"> </label>
                        <button type="submit" class="btn btn-primary w-100">{{ __('Apply') }}</button>
                    </div>

                    {{ Form::close() }}
                </div>
            </div>

            @if (!empty($users) && $type && $date)
                <div class="card">
                    <div class="card-body">
                        {{ Form::open(['url' => route('attendance.bulk.store'), 'method' => 'POST']) }}
                        {{ Form::hidden('type', $type) }}
                        {{ Form::hidden('date', $date) }}

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Present/Absent') }}</th>
                                        <th>{{ __('Checked In') }}</th>
                                        <th>{{ __('Checked Out') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $id => $name)
                                        <tr>
                                            <td>{{ $name }}</td>
                                            <td class="col-md-1 text-center">
                                                <input type="checkbox" name="attendances[{{ $loop->index }}][present]"
                                                    value="1" class="present-checkbox" data-row="{{ $loop->index }}">
                                            </td>

                                            <td>
                                                <input type="hidden" name="attendances[{{ $loop->index }}][user_id]"
                                                    value="{{ $id }}">
                                                <input type="time" name="attendances[{{ $loop->index }}][checked_in_time]"
                                                    class="form-control time-input-{{ $loop->index }}" step="1">
                                            </td>
                                            <td>
                                                <input type="time"
                                                    name="attendances[{{ $loop->index }}][checked_out_time]"
                                                    class="form-control time-input-{{ $loop->index }}" step="1">
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="text-center mt-3">
                            {{ Form::submit(__('Save'), ['class' => 'btn btn-primary']) }}
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
@push('script-page')
    <script>
        $(function() {
            function toggleTimeInputs(rowIndex, show) {
                var $timeInputs = $('.time-input-' + rowIndex);
                if (show) {
                    $timeInputs.show().prop('disabled', false);
                } else {
                    $timeInputs.hide().val('').prop('disabled', true);
                }
            }

            $('.present-checkbox').each(function() {
                var rowIndex = $(this).data('row');
                toggleTimeInputs(rowIndex, $(this).is(':checked'));
            });

            $('.present-checkbox').change(function() {
                var rowIndex = $(this).data('row');
                toggleTimeInputs(rowIndex, $(this).is(':checked'));
            });
        });
    </script>
@endpush
