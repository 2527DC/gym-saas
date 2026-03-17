{!! Form::open(['method' => 'post', 'route' => 'assign.locker.store']) !!}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            {!! Form::label('user', __('User'), ['class' => 'form-label']) !!}
            {!! Form::select('user_id', $users, null, ['class' => 'form-control select2', 'placeholder' => 'Select User']) !!}
        </div>
        <div class="form-group col-md-12">
            {!! Form::label('assign_date', __('Assign Date'), ['class' => 'form-label']) !!}
            {!! Form::date('assign_date', null, ['class' => 'form-control']) !!}
        </div>
        {!! Form::hidden('locker_id', $id) !!}
    </div>
</div>
<div class="modal-footer">
    {{ Form::submit(__('Create'), ['class' => 'btn btn-secondary ml-10']) }}
</div>
{!! Form::close() !!}
