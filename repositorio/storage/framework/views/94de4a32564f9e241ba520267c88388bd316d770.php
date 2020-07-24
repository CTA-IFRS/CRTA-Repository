<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-6">
            <?php if($product->photos->count()): ?>
                <img src="<?php echo e(asset('storage/' . $product->thumb)); ?>" alt="" class="card-img-top thumb">
                <div class="row" style="margin-top: 20px;">
                    <?php $__currentLoopData = $product->photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-4">
                            <img src="<?php echo e(asset('storage/' . $photo->image)); ?>" alt="" class="img-fluid img-small">
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <img src="<?php echo e(asset('assets/img/no-photo.jpg')); ?>" alt="" class="card-img-top">
            <?php endif; ?>
        </div>

        <div class="col-6">
            <div class="col-md-12">
                <h2><?php echo e($product->name); ?></h2>
                <p>
                    <?php echo e($product->description); ?>

                </p>





                <span>

                </span>
            </div>
















        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <hr>
            <?php echo e($product->body); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        let thumb = document.querySelector('img.thumb');
        let imgSmall = document.querySelectorAll('img.img-small');

        imgSmall.forEach(function(el) {
             el.addEventListener('click', function() {
                thumb.src = el.src;
             });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\gigatech\repositorio\resources\views/single.blade.php ENDPATH**/ ?>