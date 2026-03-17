{{Form::open(array('url'=>['event-type', $eventtype->id],'method'=>'PUT'))}}
<div class="modal-body">
    <div class="row">
        <div class="form-group  col-md-12">
            {{Form::label('name',__('Eevent Type'). ' <span class="text-danger">*</span>',array('class'=>'form-label'), false)}}
            {{Form::text('name',$eventtype->name,array('class'=>'form-control','placeholder'=>__('Enter event type'), 'required'))}}
        </div>
    </div>
</div>
<div class="modal-footer">
    {{Form::submit(__('Update'),array('class'=>'btn btn-secondary btn-rounded'))}}
</div>
{{ Form::close() }}
