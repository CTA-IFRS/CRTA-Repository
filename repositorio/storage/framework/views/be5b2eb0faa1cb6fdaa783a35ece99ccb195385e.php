<?php $__env->startSection('content'); ?>
    <h1>Editar produto</h1>
    <form action="<?php echo e(route('admin.products.update', ['product' => $product->id])); ?>" method="post">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="form-group">
            <label>Nome produto</label>
            <input type="text" name="name" class="form-control" value="<?php echo e($product->name); ?>">
        </div>

        <div class="form-group">
            <label>Descrição</label>
            <input type="text" name="description" class="form-control" value="<?php echo e($product->description); ?>">
        </div>

        <div class="form-group">
            <label>conteúdo</label>
            <textarea name="body" id="" cols="30"  rows="10" class="form-control"><?php echo e($product->body); ?>"</textarea>
        </div>

        <div class="form-group">
            <label>Preço</label>
            <input type="text" name="price" class="form-control" value="<?php echo e($product->price); ?>">
        </div>

        <div class="form-group">
            <label>Slug</label>
            <input type="text" name="slug" class="form-control" value="<?php echo e($product->slug); ?>">
        </div>


        <div>
            <button type="submit" class="btn btn-lg btn-primary">Atualizar Produto</button>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\gigatech\repositorio\resources\views/admin/products/edit.blade.php ENDPATH**/ ?>