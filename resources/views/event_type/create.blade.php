{{Form::open(array('url'=>'event-type','method'=>'POST'))}}
<div class="modal-body">
    <div class="row">
        <div class="form-group  col-md-12">
            {{Form::label('name',__('Event Type'). ' <span class="text-danger">*</span>',array('class'=>'form-label'), false)}}
            {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter training type'), 'required'))}}
        </div>
    </div>
</div>
<div class="modal-footer">
    {{Form::submit(__('Create'),array('class'=>'btn btn-secondary btn-rounded'))}}
</div>
{{ Form::close() }}
