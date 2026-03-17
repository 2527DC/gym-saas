{!! Form::model($product, ['method' => 'put', 'route' => ['product.update', $product->id]]) !!}
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                {!! Form::label(
                    'title',
                    __('Title') . '<span class = "text-danger"> *</span>',
                    ['class' => 'form-label'],
                    false,
                ) !!}
                {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter title', 'required']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('price', __('Price') . '<span class="text-danger"> *</span>', ['class' => 'form-label'], false) !!}
                {!! Form::number('price', null, ['class' => 'form-control', 'required', 'placeholder' => 'Enter price']) !!}
            </div>
            <div class="form-group">
                {!! Form::label(
                    'discount',
                    __('Discount (%)') . '<span class="text-danger"> *</span>',
                    ['class' => 'form-label'],
                    false,
                ) !!}
                {!! Form::number('discount', null, ['class' => 'form-control', 'placeholder' => 'Enter discount', 'step' => '0.01']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('description', __('description'), ['class' => 'form-label']) !!}
                {!! Form::textarea('description', null, [
                    'class' => 'form-control',
                    'id' => 'classic-editor',
                    'rows' => 5,
                    'placeholder' => 'Enter description',
                ]) !!}
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    {!! Form::submit(__('Update'), ['class' => 'btn btn-secondary ml-10']) !!}
</div>
{!! Form::close() !!}
