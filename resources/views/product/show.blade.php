<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <h3 class="card-title mb-3 fw-bold text-primary">
                        {{ $product->title }}
                    </h3>

                    <p class="card-text text-muted mb-3">
                        {!! $product->description !!}
                    </p>

                    <div class="d-flex align-items-center mb-2">
                        <label class="form-label fw-semibold text-lg text-muted me-2 mb-0">
                            {{ __('Price') }}:
                        </label>
                        <p class="form-control-plaintext fw-bold text-dark mb-0">
                           {{ $setting['CURRENCY_SYMBOL'] }}  {{  $product->price }}
                        </p>
                    </div>

                    <div class="d-flex align-items-center mb-2">
                        <label class="form-label fw-semibold text-lg text-muted me-2 mb-0">
                            {{ __('Discount') }}:
                        </label>
                        <p class="form-control-plaintext fw-bold text-dark mb-0">
                           {{ $product->discount }} %
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
