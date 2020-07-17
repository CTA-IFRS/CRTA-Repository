<?php $__env->startSection('content'); ?>
    <h1>Editar Loja</h1>
    <form action="<?php echo e(route('admin.stores.update', ['store'=>$store->id])); ?>" method="post" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field("PUT"); ?>

        <div class="form-group">
            <label>Nome Loja</label>
            <input type="text" name="name" class="form-control" value="<?php echo e($store->name); ?>">
        </div>

        <div class="form-group">
            <label>Descrição</label>
            <input type="text" name="description" class="form-control" value="<?php echo e($store->description); ?>">
        </div>

        <div class="form-group">
            <label>Telefone</label>
            <input type="text" name="phone" class="form-control" value="<?php echo e($store->phone); ?>">
        </div>

        <div class="form-group">
            <label>Celular whatsapp</label>
            <input type="text" name="mobile_phone" class="form-control" value="<?php echo e($store->mobile_phone); ?>">
        </div>

        <div class="form-group">
            <p>
                <img src="<?php echo e(asset('storage/' . $store->logo)); ?>" alt="">
            </p>
            <label>Fotos de produto</label>
            <input type="file" name="logo" class="form-control">
        </div>

        <div class="form-group">
            <label>Slug</label>
            <input type="text" name="slug" class="form-control" value="<?php echo e($store->slug); ?>">
        </div>


        <div>
            <button type="submit" class="btn btn-lg btn-primary">Atualizar Loja</button>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\gigatech\repositorio\resources\views/admin/stores/edit.blade.php ENDPATH**/ ?>