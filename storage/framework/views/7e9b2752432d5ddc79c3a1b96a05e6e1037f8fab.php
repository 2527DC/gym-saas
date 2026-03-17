<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Health Update')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">
                <?php echo e(__('Health Update')); ?>

            </a>
        </li>
    </ul>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('card-action-btn'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="card">
            <div class="col-12">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5><?php echo e(__('Health Update List')); ?></h5>
                        </div>
                        <?php if(Gate::check('create health update')): ?>
                            <div class="col-auto">
                                <a href="#" class="btn btn-secondary customModal" data-size="lg"
                                    data-url="<?php echo e(route('health-update.create')); ?>"
                                    data-title="<?php echo e(__('Create Health Update')); ?>">
                                    <i class="ti ti-circle-plus align-text-bottom"></i>
                                    <?php echo e(__('Create Health Update')); ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="dt-responsive table-responsive">
                        <table class="table table-hover advance-datatable">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('Trainee')); ?></th>
                                    <th><?php echo e(__('Date')); ?></th>
                                    <th><?php echo e(__('Notes')); ?></th>
                                    <?php if(Gate::check('edit health update') || Gate::check('delete health update') || Gate::check('show health update')): ?>
                                        <th><?php echo e(__('Action')); ?></th>
                                    <?php endif; ?>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $healthUpdates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $health): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e(!empty($health->users) ? $health->users->name : '-'); ?> </td>
                                        <td><?php echo e(dateFormat($health->measurement_date)); ?> </td>
                                        <td><?php echo e($health->notes); ?> </td>
                                        <?php if(Gate::check('edit health update') || Gate::check('delete health update') || Gate::check('show health update')): ?>
                                            <td>
                                                <div class="cart-action">
                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['health-update.destroy', encrypt($health->id)]]); ?>

                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show health update')): ?>
                                                        <a class="btn btn-icon avtar-xs btn-link-warning customModal" data-bs-toggle="tooltip"
                                                            data-size="lg" data-bs-original-title="<?php echo e(__('Details')); ?>"
                                                            data-title="<?php echo e(__('Details')); ?>"
                                                            data-url="<?php echo e(route('health-update.show', encrypt($health->id))); ?>"
                                                            href="#"> <i data-feather="eye"></i></a>
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit health update')): ?>
                                                        <a class="btn btn-icon avtar-xs btn-link-secondary customModal" data-bs-toggle="tooltip"
                                                            data-size="lg" data-bs-original-title="<?php echo e(__('Edit')); ?>"
                                                            href="#"
                                                            data-url="<?php echo e(route('health-update.edit', encrypt($health->id))); ?>"
                                                            data-title="<?php echo e(__('Edit Health Update')); ?>"> <i
                                                                data-feather="edit"></i></a>
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete health update')): ?>
                                                        <a class="btn btn-icon avtar-xs btn-link-danger confirm_dialog" data-bs-toggle="tooltip"
                                                            data-bs-original-title="<?php echo e(__('Detete')); ?>" href="#"> <i
                                                                data-feather="trash-2"></i></a>
                                                    <?php endif; ?>
                                                    <?php echo Form::close(); ?>

                                                </div>

                                            </td>
                                        <?php endif; ?>

                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/admin/Downloads/gym software/resources/views/health_update/index.blade.php ENDPATH**/ ?>