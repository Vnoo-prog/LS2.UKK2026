

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-12">
        <h3 class="fw-bold">Dashboard Perpustakaan</h3>
        <p class="text-muted">Selamat datang, <?php echo e(Auth::user()->nama_lengkap); ?> (<?php echo e(ucfirst(Auth::user()->role)); ?>).</p>
    </div>
</div>

<?php if(Auth::user()->role === 'admin'): ?>
<div class="card shadow-sm mb-5 border-0">
    <div class="card-header bg-primary text-white fw-bold">
        Kelola Akun Petugas
    </div>
    <div class="card-body">

        <?php if($errors->any()): ?>
            <div class="alert alert-danger py-2 small">
                <ul class="mb-0">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('petugas.store')); ?>" method="POST" class="mb-4">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-md-3 mb-2">
                    <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama Lengkap" required>
                </div>
                <div class="col-md-3 mb-2">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="col-md-2 mb-2">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="col-md-2 mb-2">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="col-md-2 mb-2">
                    <button type="submit" class="btn btn-primary w-100 fw-bold">+ Tambah</button>
                </div>
                <div class="col-md-12 mt-2">
                    <input type="text" name="alamat" class="form-control" placeholder="Alamat Lengkap" required>
                </div>
            </div>
        </form>

        <h6 class="fw-bold border-bottom pb-2">Daftar Petugas Aktif</h6>
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th width="150" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $daftar_petugas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $petugas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($petugas->nama_lengkap); ?></td>
                        <td><?php echo e($petugas->username); ?></td>
                        <td><?php echo e($petugas->email); ?></td>
                        <td class="text-center">
                            <form action="<?php echo e(route('petugas.destroy', $petugas->id)); ?>" method="POST" onsubmit="return confirm('Pecat petugas ini?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted py-3">Belum ada akun petugas.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="row mb-3">
    <div class="col-12"><h4 class="fw-bold">Katalog Buku</h4></div>
</div>

<div class="row">
    <?php $__empty_1 = true; $__currentLoopData = $bukus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title fw-bold text-primary mb-1"><?php echo e($b->judul); ?></h5>
                <h6 class="card-subtitle mb-3 text-muted">Penulis: <?php echo e($b->penulis); ?></h6>
                
                <ul class="list-unstyled small mb-3">
                    <li><strong>Penerbit:</strong> <?php echo e($b->penerbit); ?></li>
                    <li><strong>Tahun:</strong> <?php echo e($b->tahun_terbit); ?></li>
                    <li><strong>Stok:</strong> <span class="badge <?php echo e($b->stok > 0 ? 'bg-info' : 'bg-danger'); ?> text-dark"><?php echo e($b->stok); ?> Tersisa</span></li>
                </ul>
                
                <hr>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('meminjam')): ?>
                    <form action="<?php echo e(route('peminjaman.store', $b->id)); ?>" method="POST" class="mb-3">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-<?php echo e($b->stok > 0 ? 'success' : 'secondary'); ?> btn-sm w-100 fw-bold" <?php echo e($b->stok < 1 ? 'disabled' : ''); ?>>
                            <?php echo e($b->stok > 0 ? 'Pinjam Buku Ini' : 'Stok Buku Habis'); ?>

                        </button>
                    </form>

                    <?php
                        $pernahPinjam = \App\Models\Peminjaman::where('user_id', Auth::id())
                                            ->where('buku_id', $b->id)
                                            ->exists();
                    ?>

                    <?php if($pernahPinjam): ?>
                        <form action="<?php echo e(route('ulasan.store', $b->id)); ?>" method="POST" class="mb-3">
                            <?php echo csrf_field(); ?>
                            <div class="input-group input-group-sm">
                                <input type="number" name="rating" class="form-control" placeholder="⭐ 1-5" min="1" max="5" required style="max-width: 80px;">
                                <input type="text" name="ulasan" class="form-control" placeholder="Tulis ulasan..." required>
                                <button class="btn btn-outline-primary" type="submit">Kirim</button>
                            </div>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-secondary py-1 px-2 small text-center mb-3 border-0">
                            🔒 Pinjam buku ini terlebih dahulu untuk memberikan ulasan.
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <div class="mt-2">
                    <strong class="small d-block mb-2">Ulasan Pembaca:</strong>
                    <div style="max-height: 120px; overflow-y: auto; padding-right: 5px;">
                        <?php $__empty_2 = true; $__currentLoopData = $b->ulasans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                            <div class="mb-2 pb-2 border-bottom small">
                                <strong class="text-dark"><?php echo e($u->user->username); ?></strong> 
                                <span class="text-warning">
                                    <?php for($i=1; $i<=5; $i++): ?>
                                        <?php if($i <= $u->rating): ?> ★ <?php else: ?> ☆ <?php endif; ?>
                                    <?php endfor; ?>
                                </span>
                                <br>
                                <span class="text-muted"><?php echo e($u->ulasan); ?></span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                            <span class="text-muted small">Belum ada ulasan.</span>
                        <?php endif; ?>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="col-12 text-center py-5">
        <h5 class="text-muted">Belum ada buku di katalog.</h5>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Dipus\resources\views/dashboard.blade.php ENDPATH**/ ?>