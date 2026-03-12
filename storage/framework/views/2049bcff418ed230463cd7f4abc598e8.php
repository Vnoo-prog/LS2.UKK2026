<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/dashboard">PerpusDigital</a>
            <div class="collapse navbar-collapse">
                
                <ul class="navbar-nav me-auto">
                    <?php if(auth()->guard()->check()): ?>
                        <li class="nav-item"><a class="nav-link text-white" href="/dashboard">Dashboard</a></li>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('kelola-barang')): ?>
                            <li class="nav-item"><a class="nav-link text-white" href="/buku">Kelola Buku</a></li>
                            
                            <li class="nav-item"><a class="nav-link text-warning fw-bold" href="/laporan">Laporan</a></li>
                        <?php endif; ?>
                        
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('meminjam')): ?>
                            <li class="nav-item"><a class="nav-link text-white" href="/peminjaman/riwayat">Koleksi & Riwayatku</a></li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>

                <ul class="navbar-nav ms-auto">
                    <?php if(auth()->guard()->check()): ?>
                        <li class="nav-item">
                            <span class="nav-link text-white fw-bold">Halo, <?php echo e(Auth::user()->username); ?> (<?php echo e(Auth::user()->role); ?>)</span>
                        </li>
                        <li class="nav-item">
                            <form action="<?php echo e(route('logout')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button class="btn btn-sm btn-danger mt-1 ms-2" type="submit">Logout</button>
                            </form>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link text-white fw-bold" href="<?php echo e(route('login')); ?>">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white fw-bold" href="<?php echo e(route('register')); ?>">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </div>
</body>
</html><?php /**PATH C:\xampp\htdocs\Dipus\resources\views/layouts/app.blade.php ENDPATH**/ ?>