{{ Form::model($attendance, array('route' => array('attendances.update', $attendance->id), 'method' => 'PUT')) }}
<div class="modal-body wrapper">
    <div class="row">
        <div class="form-group col-md-12">
            {{Form::label('user_id',__('User'),array('class'=>'form-label ')) }}
            {!! Form::select('user_id', $users, null,array('class' => 'form-control select2')) !!}
        </div>
        <div class="form-group col-md-12">
            {{Form::label('date',__('Date'),array('class'=>'form-label')) }}
            {{Form::date('date',date('Y-m-d'),array('class'=>'form-control','required'=>'required'))}}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('checked_in_time',__('Checked In Time'),array('class'=>'form-label')) }}
            {{Form::time('checked_in_time',null,array('class'=>'form-control','required'=>'required'))}}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('checked_out_time',__('Checked Out Time'),array('class'=>'form-label')) }}
            {{Form::time('checked_out_time',null,array('class'=>'form-control'))}}
        </div>
        <div class="form-group col-md-12">
            {{Form::label('notes',__('Notes'),array('class'=>'form-label')) }}
            {{Form::textarea('notes',null,array('class'=>'form-control','rows'=>2,'placeholder'=>__('Enter notes')))}}
        </div>
    </div>
</div>
<div class="modal-footer">

    {{Form::submit(__('Update'),array('class'=>'btn btn-secondary ml-10'))}}
</div>
{{Form::close()}}




