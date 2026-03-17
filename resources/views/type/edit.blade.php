
{{ Form::model($type, array('route' => array('types.update', $type->id), 'method' => 'PUT')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            {{Form::label('title',__('Title'),array('class'=>'form-label')) }}
            {{Form::text('title',null,array('class'=>'form-control','placeholder'=>__('Enter title'),'required'=>'required'))}}
        </div>
    </div>
    <div class="form-group col-md-12">
        {{Form::label('type',__('Type'),array('class'=>'form-label')) }}
        {!! Form::select('type', $types, null,array('class' => 'form-control select2','required'=>'required')) !!}
    </div>
</div>
<div class="modal-footer">

    {{Form::submit(__('Update'),array('class'=>'btn btn-secondary ml-10'))}}
</div>
{{Form::close()}}



