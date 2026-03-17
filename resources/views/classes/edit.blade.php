{{ Form::model($classes, array('route' => array('classes.update', $classes->id), 'method' => 'PUT')) }}
<div class="modal-body wrapper">
    <div class="row">
        <div class="form-group col-md-6">
            {{Form::label('title',__('Title'),array('class'=>'form-label')) }}
            {{Form::text('title',null,array('class'=>'form-control','placeholder'=>__('Enter title'),'required'=>'required'))}}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('fees',__('Fees'),array('class'=>'form-label'))}}
            {{Form::number('fees',!empty($classes->fees)?$classes->fees:0,array('class'=>'form-control','placeholder'=>__('Enter fees'),'required'=>'required'))}}
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
    @foreach($classes->classSchedule as $schedule)
        <input type="hidden" name="id[]" value="{{$schedule->id}}">
        <div class="row schedule">
            <div class="form-group col">
                {{Form::label('days',__('Days'),array('class'=>'form-label')) }}
                {!! Form::select('days[]', $days, $schedule->days,array('class' => 'form-control')) !!}
            </div>
            <div class="form-group col-md-3">
                {{Form::label('start_time',__('Start Time'),array('class'=>'form-label')) }}
                {{Form::time('start_time[]',$schedule->start_time,array('class'=>'form-control','required'=>'required'))}}
            </div>
            <div class="form-group col-md-3">
                {{Form::label('end_time',__('End Time'),array('class'=>'form-label')) }}
                {{Form::time('end_time[]',$schedule->end_time,array('class'=>'form-control','required'=>'required'))}}
            </div>
            <div class="col-auto">
                <a href="#" class="f-20 text-danger schedule_remove" data-val="{{$schedule->id}}"> <i class="ti ti-trash"></i></a>
            </div>
        </div>
    @endforeach
    <div class="schedule_results"></div>

</div>
<div class="modal-footer">

    {{Form::submit(__('Update'),array('class'=>'btn btn-secondary ml-10'))}}
</div>
{{Form::close()}}

<script>
    $('.wrapper').on('click', '.schedule_remove', function () {
        var id=$(this).data('val');
        if(id!=''){
            if (confirm('Are you sure you want to delete this element?')) {
                $.ajax({
                    url: '{{route('classes.schedule.destroy')}}',
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'id': id
                    },
                    cache: false,
                    success: function (data) {

                    },
                });
            }
        }
        $('.schedule_remove').closest('.wrapper').find('.schedule').not(':first').last().remove();
    });

    $('.wrapper').on('click', '.schedule_clone', function () {
        var clonedSchedule =$('.schedule_clone').closest('.wrapper').find('.schedule').first().clone();
        clonedSchedule.find('.schedule_remove').removeAttr('data-val');
        $(clonedSchedule).appendTo('.schedule_results');
    });
</script>

