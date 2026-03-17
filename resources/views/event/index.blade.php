@extends('layouts.app')

@section('page-title')
    {{ __('Event') }}
@endsection

@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
        </li>
        <li class="breadcrumb-item active">{{ __('Event') }}</li>
    </ul>
@endsection

@section('page-class')
    codex-calendar
@endsection

@push('script-page')
    <script src="{{ asset('assets/js/plugins/index.global.min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const calendarEl = document.getElementById("codex-calendar");
            const eventData = {!! json_encode($eventData) !!};

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                navLinks: true,
                editable: false,
                selectable: false,
                dayMaxEvents: true,
                events: eventData,
                eventClick: function (info) {
                    const eventId = info.event.extendedProps.id;
                    const url = `{{ route('event.show', ':id') }}`.replace(':id', eventId);

                    fetch(url)
                        .then(response => response.text())
                        .then(html => {
                            const wrapper = document.createElement('div');
                            wrapper.innerHTML = html;

                            const bodyContent = wrapper.querySelector('#ajaxModalBodyContent');
                            const footerContent = wrapper.querySelector('#ajaxModalFooterContent');

                            if (bodyContent) {
                                document.getElementById('ajaxModalBody').innerHTML = bodyContent.innerHTML;
                            }

                            const modalFooter = document.querySelector('#ajaxEventModal .modal-footer');
                            if (modalFooter) {
                                modalFooter.innerHTML = footerContent ? footerContent.innerHTML : '';
                            }

                            new bootstrap.Modal(document.getElementById('ajaxEventModal')).show();
                        })
                        .catch(error => {
                            console.error('Error loading event details:', error);
                            alert('Could not load event details.');
                        });
                },
                eventDidMount: function (info) {
                    info.el.style.cursor = 'pointer';
                },
                height: 'auto',
                buttonText: {
                    today: '{{ __('Today') }}',
                    month: '{{ __('Month') }}',
                    week: '{{ __('Week') }}',
                    day: '{{ __('Day') }}',
                    list: '{{ __('List') }}'
                }
            });

            calendar.render();
        });
    </script>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5>{{ __('Event Calendar') }}</h5>
                        </div>
                        @if (Gate::check('create event'))
                            <div class="col-auto">
                                <a href="{{ route('event.create') }}" class="btn btn-secondary"
                                    data-title="{{ __('Create Event') }}">
                                    <i class="ti ti-circle-plus align-text-bottom"></i>
                                    {{ __('Create event') }}</a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div id="codex-calendar"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ajaxEventModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Event Details') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="{{ __('Close') }}"></button>
                </div>
                <div class="modal-body" id="ajaxModalBody">
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
@endsection
