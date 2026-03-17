{!! Form::model($assignLocker, ['method' => 'put', 'route' => ['assign.locker.update', $assignLocker->id]]) !!}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            {!! Form::label('end_date', __('End Date'), ['class' => 'form-label']) !!}
            {!! Form::date('end_date', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="modal-footer">
    {{ Form::submit(__('Update'), ['class' => 'btn btn-secondary ml-10']) }}
</div>
{!! Form::close() !!}
