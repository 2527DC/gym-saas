{{Form::model($expense, array('route' => array('expense.update', $expense->id), 'method' => 'PUT','enctype' => "multipart/form-data")) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group  col-md-12 col-lg-12">
            {{Form::label('title',__('Expense Title'),array('class'=>'form-label'))}}
            {{Form::text('title',null,array('class'=>'form-control','placeholder'=>__('Enter Expense Title')))}}
        </div>
        <div class="form-group col-md-6 col-lg-6">
            {{Form::label('expense_id',__('Expense Number'),array('class'=>'form-label'))}}
            <div class="input-group">
                    <span class="input-group-text ">
                      {{expensePrefix()}}
                    </span>
                {{Form::text('expense_id',null,array('class'=>'form-control','placeholder'=>__('Enter Expense Number')))}}
            </div>
        </div>
        <div class="form-group col-md-6 col-lg-6">
            {{Form::label('expense_type',__('Expense Type'),array('class'=>'form-label'))}}
            {{Form::select('expense_type',$types,null,array('class'=>'form-control select2'))}}
        </div>
        <div class="form-group  col-md-6 col-lg-6">
            {{Form::label('date',__('Date'),array('class'=>'form-label'))}}
            {{Form::date('date',null,array('class'=>'form-control'))}}
        </div>
        <div class="form-group  col-md-6 col-lg-6">
            {{Form::label('amount',__('Amount'),array('class'=>'form-label'))}}
            {{Form::number('amount',null,array('class'=>'form-control','placeholder'=>__('Enter Expense Amount')))}}
        </div>
        <div class="form-group  col-md-12 col-lg-12">
            {{Form::label('receipt',__('Receipt'),array('class'=>'form-label'))}}
            {{Form::file('receipt',array('class'=>'form-control'))}}
        </div>
        <div class="form-group  col-md-12 col-lg-12">
            {{Form::label('notes',__('Notes'),array('class'=>'form-label'))}}
            {{Form::textarea('notes',null,array('class'=>'form-control','rows'=>3))}}
        </div>
    </div>
</div>
<div class="modal-footer">

    {{Form::submit(__('Update'),array('class'=>'btn btn-secondary btn-rounded'))}}
</div>
{{ Form::close() }}




