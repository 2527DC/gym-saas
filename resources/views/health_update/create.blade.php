{{Form::open(array('url'=>'health-update','method'=>'post'))}}
<div class="modal-body wrapper">
    <div class="row">
        <div class="form-group col-md-12">
            {{Form::label('trainee',__('Trainee'),array('class'=>'form-label ')) }}
            {!! Form::select('trainee', $trainee, null,array('class' => 'form-control select2')) !!}
        </div>
        <div class="form-group col-md-12">
            {{Form::label('measurement_date',__('Measurement Date'),array('class'=>'form-label')) }}
            {{Form::date('measurement_date',null,array('class'=>'form-control','required'=>'required'))}}
        </div>
        <div class="form-group col-md-12">
            {{Form::label('notes',__('Notes'),array('class'=>'form-label')) }}
            {{Form::textarea('notes',null,array('class'=>'form-control','rows'=>2,'placeholder'=>__('Enter notes')))}}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <a href="#" class="btn btn-secondary btn-xs health_clone float-end"><i class="ti ti-plus"></i></a>
        </div>
    </div>
    <div class="row health">
        <div class="form-group col">
            {{Form::label('type',__('Measurement Type'),array('class'=>'form-label')) }}
            {!! Form::select('type[]', $measurement_type, null,array('class' => 'form-control')) !!}
        </div>
        <div class="form-group col">
            {{Form::label('result',__('Measurement Result'),array('class'=>'form-label')) }}
            {{Form::number('result[]',null,array('class'=>'form-control','required'=>'required'))}}
        </div>
        <div class="col-auto">
            <a href="#" class="text-danger schedule_remove health_remove f-20"> <i class="ti ti-trash"></i></a>
        </div>
    </div>
    <div class="health_results"></div>
</div>
<div class="modal-footer">

    {{Form::submit(__('Create'),array('class'=>'btn btn-secondary ml-10'))}}
</div>
{{Form::close()}}
<script>
    $('.wrapper').on('click', '.health_remove', function () {
        $('.health_remove').closest('.wrapper').find('.health').not(':first').last().remove();
    });
    $('.wrapper').on('click', '.health_clone', function () {
        $('.health_clone').closest('.wrapper').find('.health').first().clone().find("input").val("").end().show().appendTo(".health_results:last");
    });
</script>
