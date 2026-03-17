<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Membership')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">
                <?php echo e(__('Membership')); ?>

            </a>
        </li>
    </ul>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5><?php echo e(__('Membership List')); ?></h5>
                        </div>
                        <?php if(Gate::check('create membership')): ?>
                            <div class="col-auto">
                                <a href="#" class="btn btn-secondary customModal" data-size="lg"
                                    data-url="<?php echo e(route('membership.create')); ?>" data-title="<?php echo e(__('Create Membership')); ?>">
                                    <i class="ti ti-circle-plus align-text-bottom"></i> <?php echo e(__('Create Membership')); ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="dt-responsive table-responsive">
                        <table class="table table-hover advance-datatable">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('Title')); ?></th>
                                    <th><?php echo e(__('Package')); ?></th>
                                    <th><?php echo e(__('Amount')); ?></th>
                                    <th><?php echo e(__('Class')); ?></th>
                                    <?php if(Gate::check('edit membership') || Gate::check('delete membership') || Gate::check('show membership')): ?>
                                        <th><?php echo e(__('Action')); ?></th>
                                    <?php endif; ?>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $memberships; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $membership): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($membership->title); ?> </td>
                                        <td>
                                            <?php echo e(\App\Models\Membership::$package[$membership->package]); ?>

                                        </td>
                                        <td><?php echo e(priceFormat($membership->amount)); ?> </td>

                                        <td>
                                            <?php if(!empty($membership->classes_id)): ?>
                                                <?php $__currentLoopData = $membership->claases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php echo e($class->title); ?><br>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>

                                        <?php if(Gate::check('edit membership') || Gate::check('delete membership') || Gate::check('show membership')): ?>
                                            <td>
                                                <div class="cart-action">
                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['membership.destroy', encrypt($membership->id)]]); ?>

                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show membership')): ?>
                                                        <a class="btn btn-icon avtar-xs btn-link-warning " data-bs-toggle="tooltip" data-size="lg"
                                                            data-bs-original-title="<?php echo e(__('Details')); ?>"
                                                            href="<?php echo e(route('membership.show', \Illuminate\Support\Facades\Crypt::encrypt($membership->id))); ?>">
                                                            <i data-feather="eye"></i></a>
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit membership')): ?>
                                                        <a class="btn btn-icon avtar-xs btn-link-secondary customModal" data-bs-toggle="tooltip"
                                                            data-size="lg" data-bs-original-title="<?php echo e(__('Edit')); ?>"
                                                            href="#"
                                                            data-url="<?php echo e(route('membership.edit', encrypt($membership->id))); ?>"
                                                            data-title="<?php echo e(__('Edit Membership')); ?>"> <i
                                                                data-feather="edit"></i></a>
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete membership')): ?>
                                                        <a class=" btn btn-icon avtar-xs btn-link-danger confirm_dialog" data-bs-toggle="tooltip"
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/admin/Downloads/gym software/resources/views/membership/index.blade.php ENDPATH**/ ?>