{{Form::open(array('url'=>'classes','method'=>'post'))}}
<div class="modal-body wrapper">
    <div class="row">
        <div class="form-group col-md-6">
            {{Form::label('title',__('Title'),array('class'=>'form-label')) }}
            {{Form::text('title',null,array('class'=>'form-control','placeholder'=>__('Enter title'),'required'=>'required'))}}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('fees',__('Fees'),array('class'=>'form-label'))}}
            {{Form::number('fees',0,array('class'=>'form-control','placeholder'=>__('Enter fees'),'required'=>'required'))}}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('trainer',__('Trainer'),array('class'=>'form-label')) }}
            {!! Form::select('trainer[]', $trainer, null,array('class' => 'form-control select2','multiple', 'data-placeholder' => 'Select trainers')) !!}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('trainee',__('Trainee'),array('class'=>'form-label')) }}
            {!! Form::select('trainee[]', $trainee, null,array('class' => 'form-control select2','multiple', 'data-placeholder'=>'Select trainees')) !!}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('address',__('Address'),array('class'=>'form-label')) }}
            {{Form::textarea('address',null,array('class'=>'form-control','rows'=>2,'placeholder'=>__('Enter address')))}}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('notes',__('Notes'),array('class'=>'form-label')) }}
            {{Form::textarea('notes',null,array('class'=>'form-control','rows'=>2,'placeholder'=>__('Enter notes')))}}
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <a href="#" class="btn btn-secondary btn-xs schedule_clone float-end"><i class="ti ti-plus"></i></a>
        </div>
    </div>
    <div class="row schedule">
        <div class="form-group col">
            {{Form::label('days',__('Days'),array('class'=>'form-label')) }}
            {!! Form::select('days[]', $days, null,array('class' => 'form-control')) !!}
        </div>
        <div class="form-group col-md-3">
            {{Form::label('start_time',__('Start Time'),array('class'=>'form-label')) }}
            {{Form::time('start_time[]',null,array('class'=>'form-control','required'=>'required'))}}
        </div>
        <div class="form-group col-md-3">
            {{Form::label('end_time',__('End Time'),array('class'=>'form-label')) }}
            {{Form::time('end_time[]',null,array('class'=>'form-control','required'=>'required'))}}
        </div>
        <div class="col-auto">
            <a href="#" class="text-danger schedule_remove f-20"> <i class="ti ti-trash"></i></a>
        </div>
    </div>
    <div class="schedule_results"></div>

</div>
<div class="modal-footer">

    {{Form::submit(__('Create'),array('class'=>'btn btn-secondary ml-10'))}}
</div>
{{Form::close()}}

<script>
    $('.wrapper').on('click', '.schedule_remove', function () {
        $('.schedule_remove').closest('.wrapper').find('.schedule').not(':first').last().remove();
    });
    $('.wrapper').on('click', '.schedule_clone', function () {
        $('.schedule_clone').closest('.wrapper').find('.schedule').first().clone().appendTo('.schedule_results');
    });
</script>
