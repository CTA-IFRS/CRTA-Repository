<?php $__env->startSection('content'); ?>
<a href="<?php echo e(route('admin.stores.create')); ?>" class="btn btn-lg btn-primary">Cadastrar TA</a>
<table class="table table-striped">
    <thead>
    <tr>
        <th>#</th>
        <th>TA</th>
        <th>Opções</th>
    </tr>
    </thead>
    <tbody>
    <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($store->id); ?></td>
            <td><?php echo e($store->name); ?></td>
            <td>
                <div class="btn-group">
                    <a href="<?php echo e(route('admin.stores.edit', ['store'=> $store->id])); ?>" class="btn btn-sm btn-primary">EDITAR</a>
                    <form action="<?php echo e(route('admin.stores.destroy', ['store'=> $store->id])); ?>" method="post">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field("DELETE"); ?>
                        <button type="submit" class="btn btn-sm btn-danger">REMOVER</button>
                    </form>
                </div>
            </td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>

<?php echo e($stores->links()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\gigatech\repositorio\resources\views/admin/stores/index.blade.php ENDPATH**/ ?>