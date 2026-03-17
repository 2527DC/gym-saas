{{Form::open(array('route'=>array('classes.user.assign.store',[$class_id,$user_type]),'method'=>'post'))}}
<div class="modal-body wrapper">
    <div class="row">
        <div class="form-group col-md-12">
            {{Form::label('user',__($user),array('class'=>'form-label')) }}
            {!! Form::select('user[]', $users, null,array('class' => 'form-control select2','multiple')) !!}
        </div>
    </div>
</div>
<div class="modal-footer">

    {{Form::submit(__('Assign'),array('class'=>'btn btn-secondary ml-10'))}}
</div>
{{Form::close()}}
