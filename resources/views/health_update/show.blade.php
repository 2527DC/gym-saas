<div class="modal-body wrapper">
    <div class="row align-items-center">
        <div class="col-md-6">
            <p class="mb-1 mt-2">
                <b>{{ __('Trainee') }} :</b>
            {{ !empty($health->users) ? $health->users->name : '-' }}
            </p>
        </div>
        <div class="col-md-6">
            <p class="mb-1 mt-2">
                <b>{{ __('Date') }} :</b>
            {{ dateFormat($health->measurement_date) }}
            </p>
        </div>
        <div class="col-md-12">
            <p class="mb-1 mt-2">
                <b>{{ __('Notes') }} :</b>
            {{ $health->notes }}
            </p>
        </div>

    </div>
    <div class="row">
        <div class="card-body pt-0">
            <div class="dt-responsive table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>{{ __('Measurement Type') }}</th>
                            <th>{{ __('Measurement Result') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($healthHistory as $history)
                            <tr>
                                <td>{{ $history->type }}</td>
                                <td>{{ $history->result }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
