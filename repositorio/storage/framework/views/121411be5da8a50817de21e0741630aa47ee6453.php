<?php $__env->startSection('content'); ?>

    <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn btn-lg btn-success">Criar Categoria</a>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($category->id); ?></td>
                <td><?php echo e($category->name); ?></td>
                <td width="15%">
                    <div class="btn-group">
                        <a href="<?php echo e(route('admin.categories.edit', ['category' => $category->id])); ?>" class="btn btn-sm btn-primary">EDITAR</a>
                        <form action="<?php echo e(route('admin.categories.destroy', ['category' => $category->id])); ?>" method="post">
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\gigatech\repositorio\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>