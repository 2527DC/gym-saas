<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Locker')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#"> <?php echo e(__('Locker')); ?></a>
        </li>
    </ul>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center g-2">
                            <div class="col">
                                <h5><?php echo e(__('Locker List')); ?></h5>
                            </div>
                            <?php if(Gate::check('create locker')): ?>
                                <div class="col-auto">
                                    <a href="#" class="btn btn-secondary customModal" data-size="md"
                                        data-url="<?php echo e(route('locker.create')); ?>" data-title="<?php echo e(__('Create locker')); ?>">
                                        <i class="ti ti-circle-plus align-text-bottom"></i> <?php echo e(__('Create Locker')); ?></a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="dt-responsive table-responsive">
                            <table class="table table-hover advance-datatable">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('Id')); ?></th>
                                        <th><?php echo e(__('Status')); ?></th>
                                        <th><?php echo e(__('Avaiable')); ?></th>
                                        <?php if(Gate::check('edit locker') || Gate::check('delete locker') || Gate::check('show locker')): ?>
                                            <th><?php echo e(__('Action')); ?></th>
                                        <?php endif; ?>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $lockers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $locker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e(lockerPrefix() . $locker->id); ?> </td>
                                            <td>
                                                <?php echo $locker->status_badge_html; ?>

                                            </td>
                                            <td>
                                                <?php echo $locker->available_badge_html; ?>

                                            </td>

                                            <?php if(Gate::check('edit locker') || Gate::check('delete locker') || Gate::check('show locker')): ?>
                                                <td>
                                                    <div class="cart-action">
                                                        <?php echo Form::open(['method' => 'DELETE', 'route' => ['locker.destroy', encrypt($locker->id)]]); ?>

                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show locker')): ?>
                                                            <a class="btn btn-icon avtar-xs btn-link-warning "
                                                                data-bs-toggle="tooltip"
                                                                data-bs-original-title="<?php echo e(__('Details')); ?>"
                                                                href="<?php echo e(route('locker.show', \Illuminate\Support\Facades\Crypt::encrypt($locker->id))); ?>">
                                                                <i data-feather="eye"></i></a>
                                                        <?php endif; ?>
                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit locker')): ?>
                                                            <a class="btn btn-icon avtar-xs btn-link-secondary customModal"
                                                                data-bs-toggle="tooltip" data-size="md"
                                                                data-bs-original-title="<?php echo e(__('Edit')); ?>" href="#"
                                                                data-url="<?php echo e(route('locker.edit', encrypt($locker->id))); ?>"
                                                                data-title="<?php echo e(__('Edit Locker')); ?>"> <i
                                                                    data-feather="edit"></i></a>
                                                        <?php endif; ?>
                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete locker')): ?>
                                                            <a class=" btn btn-icon avtar-xs btn-link-danger confirm_dialog"
                                                                data-bs-toggle="tooltip"
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
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\gym software\resources\views/locker/index.blade.php ENDPATH**/ ?>