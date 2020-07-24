<?php $__env->startSection('content'); ?>
    <div class="row front">
        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-4">
                <div class="card" style="width: 100%;">
                    <?php if($product->photos->count()): ?>
                        <img src="<?php echo e(asset('storage/' . $product->image)); ?>" alt="" class="card-img-top">
                    <?php else: ?>
                        <img src="<?php echo e(asset('assets/img/no-photo.jpg')); ?>" alt="" class="card-img-top">
                    <?php endif; ?>

                    <div class="card-body">
                        <h2 class="card-title"><?php echo e($product->name); ?></h2>
                        <p class="card-text">
                            <?php echo e($product->description); ?>

                        </p>
                        <a href="<?php echo e(route('product.single', ['slug' => $product->slug])); ?>" class="btn btn-primary">
                            Ver Produto
                        </a>
                    </div>
                </div>
            </div>
            <?php if(($key + 1) % 3 == 0): ?> </div><div class="row front"> <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\gigatech\repositorio\resources\views/welcome.blade.php ENDPATH**/ ?>