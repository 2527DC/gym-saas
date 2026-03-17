{!! Form::open(['method' => 'post', 'route' => 'membership.renew.store']) !!}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6 mb-3">
            {{ Form::label('membership_plan', __('Membership') . '<span class="text-danger"> *</span>', ['class' => 'form-label'], false) }}
            {!! Form::select('membership_plan', $membership, null, [
                'class' => 'form-control select2 select2',
                'required' => 'required',
            ]) !!}
        </div>
        <div class="form-group col-md-6 mb-3">
            {{ Form::label('membership_start_date', __('Membership Start Date') . '<span class="text-danger"> *</span>', ['class' => 'form-label'], false) }}
            {{ Form::date('membership_start_date', null, ['class' => 'form-control', 'required' => 'required']) }}
        </div>
        {{ Form::hidden('trainee_id', $id) }}
    </div>
</div>

<div class="modal-footer">
    {{ Form::submit(__('Update'), ['class' => 'btn btn-secondary ml-10']) }}
</div>
{!! Form::close() !!}
