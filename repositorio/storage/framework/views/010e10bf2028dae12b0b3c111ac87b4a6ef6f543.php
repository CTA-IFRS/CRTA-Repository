<?php $__env->startSection('content'); ?>
    <h1>Cadastrar TA</h1>
    <form action="<?php echo e(route('admin.stores.store')); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

        <div class="form-group">
            <label>Nome da TA</label>
            <input type="text" name="name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('name')); ?>">

            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="invalid-feedback">
                <?php echo e($message); ?>

            </div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-group">
            <label>Descrição</label>
            <input type="text" name="description" class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('description')); ?>">

            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="invalid-feedback">
                <?php echo e($message); ?>

            </div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        </div>

        <div class="form-group">
            <label>Arquivos</label>
            <input type="text" name="phone" class="form-control" value="<?php echo e(old('phone')); ?>">

        </div>

        <div class="form-group">
            <label>Instituição</label>
            <input type="text" name="mobile_phone" class="form-control" value="<?php echo e(old('mobile_phone')); ?>">

        </div>

        <div class="form-group">
            <label>Fotos de produto</label>
            <input type="file" name="logo" class="form-control">
        </div>


        <div class="form-group">
            <label>Slug</label>
            <input type="text" name="slug" class="form-control" value="<?php echo e(old('slug')); ?>">

        </div>

        <div>
            <button type="submit" class="btn btn-lg btn-primary">Enviar</button>
        </div>
    </form>
<?php $__env->stopSection(); ?>










<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\gigatech\repositorio\resources\views/admin/stores/create.blade.php ENDPATH**/ ?>