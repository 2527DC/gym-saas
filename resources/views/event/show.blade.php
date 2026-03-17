<div id="ajaxModalBodyContent">
    <div class="row">
        <div class="col-12">
            <p><strong>{{ __('Title') }}:</strong> {{ $event->title }}</p>
            <p><strong>{{ __('Start Date') }}:</strong> {{ $event->start_date }}</p>
            <p><strong>{{ __('End Date') }}:</strong> {{ $event->end_date }}</p>
            <p><strong>{{ __('Status') }}:</strong>
                {{ \App\Models\Event::status()[$event->status] ?? $event->status }}</p>
            <p><strong>{{ __('Event Type') }}:</strong> {{ $event->eventType->name ?? '-' }}</p>
            <p><strong>{{ __('Description') }}:</strong> {!! nl2br(e($event->description)) !!}</p>
        </div>
    </div>
</div>

<div id="ajaxModalFooterContent">
    @if (Gate::check('edit event') || Gate::check('delete event'))
        <div class="d-flex gap-2 align-items-center">
            {!! Form::open(['method' => 'DELETE', 'route' => ['event.destroy', encrypt($event->id)]]) !!}

            @can('edit event')
                <a class="btn btn-icon avtar-xs btn-link-secondary" data-bs-toggle="tooltip" data-size="lg"
                    data-bs-original-title="{{ __('Edit') }}" href="{{ route('event.edit', encrypt($event->id)) }}" data-title="{{ __('Edit Event') }}"> <i
                        data-feather="edit"></i></a>
            @endcan
            @can('delete event')
                <a class="btn btn-icon avtar-xs btn-link-danger confirm_dialog" data-bs-toggle="tooltip"
                    data-bs-original-title="{{ __('Detete') }}" href="#"> <i data-feather="trash-2"></i></a>
            @endcan
            {!! Form::close() !!}
        </div>
    @endif
</div>
