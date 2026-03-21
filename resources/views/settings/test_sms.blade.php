{{ Form::open(['route' => 'setting.sms.testing', 'method' => 'post']) }}
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            {{ Form::label('test_phone_number', __('Receiver Phone Number'), ['class' => 'form-label']) }}
            {{ Form::text('test_phone_number', null, ['class' => 'form-control', 'placeholder' => __('Enter phone number with country code (e.g. +1234567890)'), 'required' => 'required']) }}
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            {{ Form::label('test_message', __('Test Message'), ['class' => 'form-label']) }}
            {{ Form::textarea('test_message', __('Test SMS from Gym Management System'), ['class' => 'form-control', 'rows' => 3, 'placeholder' => __('Enter test message'), 'required' => 'required']) }}
        </div>
    </div>
</div>
<div class="modal-footer pb-0">
    <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Send') }}" class="btn btn-primary">
</div>
{{ Form::close() }}
