{{ Form::model($membership, array('route' => array('membership.update', $membership->id), 'method' => 'PUT')) }}
<div class="modal-body wrapper">
    <div class="row">
        <div class="form-group col-md-12">
            {{Form::label('title',__('Title'),array('class'=>'form-label')) }}
            {{Form::text('title',null,array('class'=>'form-control','placeholder'=>__('Enter title'),'required'=>'required'))}}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('package',__('Package'),array('class'=>'form-label')) }}
            {!! Form::select('package', $package, null,array('class' => 'form-control select2')) !!}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('amount',__('Amount'),array('class'=>'form-label'))}}
            {{Form::number('amount',null,array('class'=>'form-control','placeholder'=>__('Enter amount'),'required'=>'required'))}}
        </div>
        <div class="form-group col-md-12">
            {{Form::label('classes_id',__('Class'),array('class'=>'form-label')) }}
            {!! Form::select('classes_id[]', $classes, explode(',',$membership->classes_id),array('class' => 'form-control select2','multiple')) !!}
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

