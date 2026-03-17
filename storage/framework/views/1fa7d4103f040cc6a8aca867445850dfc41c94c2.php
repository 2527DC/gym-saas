<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Workout')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">
                <?php echo e(__('Workout')); ?>

            </a>
        </li>
    </ul>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('card-action-btn'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5><?php echo e(__('Workout List')); ?></h5>
                        </div>
                        <?php if(Gate::check('create workout')): ?>
                            <div class="col-auto">
                                <a href="#" class="btn btn-secondary customModal" data-size="xl"
                                    data-url="<?php echo e(route('workouts.create')); ?>" data-title="<?php echo e(__('Create Workout')); ?>">
                                    <i class="ti ti-circle-plus align-text-bottom"></i> <?php echo e(__('Create Workout')); ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="dt-responsive table-responsive">
                        <table class="table table-hover advance-datatable">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('Assign To')); ?></th>
                                    <th><?php echo e(__('Assign')); ?></th>
                                    <th><?php echo e(__('Start Date')); ?></th>
                                    <th><?php echo e(__('End Date')); ?></th>
                                    <?php if(Gate::check('edit workout') || Gate::check('delete workout') || Gate::check('show workout')): ?>
                                        <th><?php echo e(__('Action')); ?></th>
                                    <?php endif; ?>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $workouts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $workout): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e(ucfirst($workout->assign_to)); ?> </td>
                                        <td>
                                            <?php if($workout->assign_to == 'trainee'): ?>
                                                <?php echo e(!empty($workout->assignDetail) ? $workout->assignDetail->name : '-'); ?>

                                            <?php else: ?>
                                                <?php echo e(!empty($workout->assignDetail) ? $workout->assignDetail->title : '-'); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e(dateFormat($workout->start_date)); ?> </td>
                                        <td><?php echo e(dateFormat($workout->end_date)); ?> </td>
                                        <?php if(Gate::check('edit workout') || Gate::check('delete workout') || Gate::check('show workout')): ?>
                                            <td>
                                                <div class="cart-action">
                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['workouts.destroy', $workout->id]]); ?>

                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show workout')): ?>
                                                        <a class="btn btn-icon avtar-xs btn-link-warning customModal"
                                                            data-bs-toggle="tooltip" data-size="lg"
                                                            data-bs-original-title="<?php echo e(__('Details')); ?>"
                                                            data-title="<?php echo e(__('Details')); ?>"
                                                            data-url="<?php echo e(route('workouts.show', \Illuminate\Support\Facades\Crypt::encrypt($workout->id))); ?>"
                                                            href="#"> <i data-feather="eye"></i></a>
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit workout')): ?>
                                                        <a class="btn btn-icon avtar-xs btn-link-secondary customModal"
                                                            data-bs-toggle="tooltip" data-size="xl"
                                                            data-bs-original-title="<?php echo e(__('Edit')); ?>" href="#"
                                                            data-url="<?php echo e(route('workouts.edit', encrypt($workout->id))); ?>"
                                                            data-title="<?php echo e(__('Edit Workout')); ?>"> <i
                                                                data-feather="edit"></i></a>
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete workout')): ?>
                                                        <a class="btn btn-icon avtar-xs btn-link-danger confirm_dialog"
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/admin/Downloads/gym software/resources/views/workout/index.blade.php ENDPATH**/ ?>