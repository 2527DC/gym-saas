<div class="modal-body">
    <div class="product-card">
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="mb-1 mt-2">
                    <b>{{ __('Expense Title') }} :</b>
                {{$expense->title}}
                </p>
            </div>

            <div class="col-md-6">
                <div class="mb-1 mt-2">
                    <b>{{__('Expense Number')}} :</b>
                    {{expensePrefix().$expense->expense_id}}
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1 mt-2">
                    <b>{{__('Expense Type')}} :</b>
                    {{!empty($expense->types)?$expense->types->title:'-'}}
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-1 mt-2">
                    <b>{{__('Date')}} :</b>
                     {{dateFormat($expense->date)}}
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1 mt-2">
                    <b>{{__('Amount')}} :</b>
                    {{priceFormat($expense->amount)}}
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1 mt-2">
                    <b>{{__('Receipt')}} :</b>

                        @if(!empty($expense->receipt))
                            <a href="{{asset(Storage::url('upload/receipt')).'/'.$expense->receipt}}" download="download"><i data-feather="download"></i></a>
                        @else
                            -
                        @endif

                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-1 mt-2">
                    <b>{{__('Notes')}} :</b>
                    {{$expense->notes}}
                </div>
            </div>
        </div>
    </div>
</div>
