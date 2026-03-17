<div class="modal-body wrapper">

    <div class="row align-items-center">
        <div class="col-md-4">
            <p class="mb-1 mt-2">
                <b>{{ __('Assign') }} :</b>
                @if ($workout->assign_to == 'trainee')
                    {{ !empty($workout->assignDetail) ? $workout->assignDetail->name : '-' }}
                @else
                    {{ !empty($workout->assignDetail) ? $workout->assignDetail->title : '-' }}
                @endif
            </p>
        </div>

        <div class="col-md-4">
            <p class="mb-1 mt-2">
                <b>{{ __('Start Date') }} :</b>
                {{ dateFormat($workout->start_date) }}
            </p>
        </div>

        <div class="col-md-4">
            <p class="mb-1 mt-2">
                <b>{{ __('End Date') }} :</b>
                {{ dateFormat($workout->end_date) }}
            </p>
        </div>

        <div class="col-md-12">
            <p class="mb-1 mt-2">
                <b>{{ __('Notes') }} :</b>
                {{ $workout->notes }}
            </p>
        </div>


    </div>
    <div class="row">
        <div class="card-body pt-0">
            <div class="dt-responsive table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>{{ __('Days') }}</th>
                            <th>{{ __('Activity') }}</th>
                            <th>{{ __('Weight') }}</th>
                            <th>{{ __('Sets') }}</th>
                            <th>{{ __('Reps') }}</th>
                            <th>{{ __('Rest') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($histories as $history)
                            <tr>
                                <td>{{ $history->days }}</td>
                                <td>{{ \App\Models\Workout::activities($history->activity) }}</td>
                                <td>{{ $history->weight }}</td>
                                <td>{{ $history->sets }}</td>
                                <td>{{ $history->reps }}</td>
                                <td>{{ $history->rest }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
</div>
