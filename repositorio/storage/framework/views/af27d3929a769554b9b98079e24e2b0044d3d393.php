<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RETACE</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .front.row {
            margin-bottom: 40px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light" style="margin-bottom: 40px;">

    <a class="navbar-brand" href="<?php echo e(route('home')); ?>">RETACE</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <ul class="navbar-nav mr-auto">
            <li class="nav-item <?php if(request()->is('/')): ?> active <?php endif; ?>">
                <a class="nav-link" href="<?php echo e(route('home')); ?>">Home <span class="sr-only">(current)</span></a>
            </li>
        </ul>

        <?php if(auth()->guard()->check()): ?>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item <?php if(request()->is('admin/stores*')): ?> active <?php endif; ?>">
                    <a class="nav-link" href="<?php echo e(route('admin.stores.index')); ?>">Repositório <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item <?php if(request()->is('admin/products*')): ?> active <?php endif; ?>">
                    <a class="nav-link" href="<?php echo e(route('admin.products.index')); ?>">Tecnologias</a>
                </li>
                <li class="nav-item <?php if(request()->is('admin/categories*')): ?> active <?php endif; ?>">
                    <a class="nav-link" href="<?php echo e(route('admin.categories.index')); ?>">Categorias</a>
                </li>
            </ul>

            <div class="my-2 my-lg-0">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="event.preventDefault();
                                                                  document.querySelector('form.logout').submit(); ">Sair</a>

                        <form action="<?php echo e(route('logout')); ?>" class="logout" method="POST" style="display:none;">
                            <?php echo csrf_field(); ?>
                        </form>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link"><?php echo e(auth()->user()->name); ?></span>
                    </li>
                </ul>
            </div>
        <?php endif; ?>

    </div>
</nav>

<div class="container">
    <?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldContent('content'); ?>
</div>
</body>
</html>
<?php /**PATH C:\Users\gigatech\repositorio\resources\views/layouts/front.blade.php ENDPATH**/ ?>