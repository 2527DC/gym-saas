{{ Form::open(array('url' => 'permission')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            {{Form::label('title',__('Permission Title'),['class'=>'form-label'])}}
            {{Form::text('title',null,array('class'=>'form-control', 'placeholder' => __('Enter permission name (comma separated for multiple)')))}}
        </div>
        
        <div class="form-group col-md-12">
            {{ Form::label('module_id', __('Module'),['class'=>'form-label']) }}
            {!! Form::select('module_id', ['' => __('Select Module')] + $modules->toArray(), null, array('class' => 'form-control select2', 'id' => 'module_id')) !!}
        </div>

        <div class="form-group col-md-12 d-none" id="new_module_group">
            {{Form::label('new_module',__('New Module Name'),['class'=>'form-label'])}}
            {{Form::text('new_module',null,array('class'=>'form-control', 'placeholder' => __('Enter new module name')))}}
        </div>

        <div class="form-group col-md-12">
            <div class="form-check custom-checkbox">
                <input type="checkbox" class="form-check-input" id="toggle_new_module">
                <label class="form-check-label" for="toggle_new_module">{{ __('Or Create New Module') }}</label>
            </div>
        </div>

        <div class="form-group col-md-12">
            {{ Form::label('user_roles', __('Assign to Roles'),['class'=>'form-label']) }}
            {!! Form::select('user_roles[]', $userRoles, null,array('class' => 'form-control select2','multiple')) !!}
        </div>
        
        <div class="col-md-12 text-end">
            <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
            {{Form::submit(__('Create'),array('class'=>'btn btn-secondary btn-rounded'))}}
        </div>
    </div>
</div>
{{ Form::close() }}

<script>
    $(document).ready(function() {
        $('#toggle_new_module').on('change', function() {
            if ($(this).is(':checked')) {
                $('#new_module_group').removeClass('d-none');
                $('#module_id').prop('disabled', true);
            } else {
                $('#new_module_group').addClass('d-none');
                $('#module_id').prop('disabled', false);
            }
        });
    });
</script>
