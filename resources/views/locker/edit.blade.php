{!! Form::model($locker, ['method' => 'put', 'route' => ['locker.update', $locker->id]]) !!}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            {!! Form::label('status', __('status'), ['class' => 'form-label']) !!}
            {!! Form::select('status', $status, null,['class' => 'form-control select2', 'placeholder' => ' Select status']) !!}
        </div>
        <div class="form-group col-md-12">
            {!! Form::label('available', __('available'), ['class' => 'form-label']) !!}
            {!! Form::select('available', $available, null,[
                'class' => 'form-control select2',
                'placeholder' => ' Select available',
            ]) !!}
        </div>
    </div>
</div>
<div class="modal-footer">
    {{ Form::submit(__('Update'), ['class' => 'btn btn-secondary ml-10']) }}
</div>
{!! Form::close() !!}
