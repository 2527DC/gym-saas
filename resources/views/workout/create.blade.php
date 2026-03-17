{{Form::open(array('url'=>'workouts','method'=>'post'))}}
<div class="modal-body wrapper">
    <div class="row">
        <div class="form-group col-md-12">
            <label class="form-label me-2">{{__('Assign To')}} : </label>
            <div class="form-check custom-chek form-check-inline ">
                <input class="form-check-input assign_to" type="radio" value="trainee" id="trainee" name="assign_to" checked>
                <label class="form-check-label" for="trainee">{{__('Trainee')}} </label>
            </div>
            <div class="form-check custom-chek form-check-inline ">
                <input class="form-check-input assign_to" type="radio" value="class" id="class" name="assign_to">
                <label class="form-check-label" for="class">{{__('Class')}} </label>
            </div>
        </div>
        <div class="form-group col-md-12 assign trainee">
            {{Form::label('trainee',__('Trainee'),array('class'=>'form-label ')) }}
            {!! Form::select('trainee', $trainee, null,array('class' => 'form-control select2')) !!}
        </div>
        <div class="form-group col-md-12 d-none assign class">
            {{Form::label('class',__('Class'),array('class'=>'form-label')) }}
            {!! Form::select('class', $classes, null,array('class' => 'form-control select2')) !!}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('start_date',__('Start Date'),array('class'=>'form-label')) }}
            {{Form::date('start_date',null,array('class'=>'form-control','required'=>'required'))}}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('end_date',__('End Date'),array('class'=>'form-label')) }}
            {{Form::date('end_date',null,array('class'=>'form-control','required'=>'required'))}}
        </div>
        <div class="form-group col-md-12">
            {{Form::label('notes',__('Notes'),array('class'=>'form-label')) }}
            {{Form::textarea('notes',null,array('class'=>'form-control','rows'=>1,'placeholder'=>__('Enter notes')))}}
        </div>
    </div>

        <div class="row">
            <div class="col-sm-12">
                <a href="#" class="btn btn-secondary btn-xs schedule_clone float-end"><i class="ti ti-plus"></i></a>
            </div>
        </div>
        <div class="row schedule">
            <div class="form-group col-md-3 col-lg-3">
                {{Form::label('days',__('Days'),array('class'=>'form-label')) }}
                {!! Form::select('days[]', $days, null,array('class' => 'form-control')) !!}
            </div>
            <div class="form-group col-md-3 col-lg-3">
                {{Form::label('activity',__('Activity'),array('class'=>'form-label')) }}
                {!! Form::select('activity[]', $activity, null,array('class' => 'form-control')) !!}
            </div>
            <div class="form-group col">
                {{Form::label('weight',__('Weight (Kg)'),array('class'=>'form-label')) }}
                {{Form::number('weight[]',null,array('class'=>'form-control','required'=>'required'))}}
            </div>
            <div class="form-group col">
                {{Form::label('sets',__('Sets'),array('class'=>'form-label')) }}
                {{Form::number('sets[]',null,array('class'=>'form-control','required'=>'required'))}}
            </div>
            <div class="form-group col">
                {{Form::label('reps',__('Reps'),array('class'=>'form-label')) }}
                {{Form::number('reps[]',null,array('class'=>'form-control','required'=>'required'))}}
            </div>
            <div class="form-group col">
                {{Form::label('rest',__('Rest (min)'),array('class'=>'form-label')) }}
                {{Form::number('rest[]',null,array('class'=>'form-control','required'=>'required'))}}
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
    $('.assign_to').on('click', function () {
       var assign=$(this).val();
        $('.assign').addClass('d-none');
       $('.'+assign+'').removeClass('d-none');

    });
    $('.wrapper').on('click', '.schedule_remove', function () {
        $('.schedule_remove').closest('.wrapper').find('.schedule').not(':first').last().remove();
    });
    $('.wrapper').on('click', '.schedule_clone', function () {
        $('.schedule_clone').closest('.wrapper').find('.schedule').first().clone().find("input").val("").end().show().appendTo(".schedule_results:last");


    });
</script>
