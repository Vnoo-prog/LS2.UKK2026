

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold">Kelola Data Buku</h3>
    <a href="<?php echo e(route('buku.create')); ?>" class="btn btn-primary btn-sm">+ Tambah Buku</a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-bordered mb-0">
            <thead class="table-light">
                <tr>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Tahun</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $bukus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $buku): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($buku->judul); ?></td>
                    <td><?php echo e($buku->penulis); ?></td>
                    <td><?php echo e($buku->penerbit); ?></td>
                    <td><?php echo e($buku->tahun_terbit); ?></td>
                    <td><?php echo e($buku->stok); ?></td>
                    <td>
                        <a href="<?php echo e(route('buku.edit', $buku->id)); ?>" class="btn btn-warning btn-sm">Edit</a>
                        <form action="<?php echo e(route('buku.destroy', $buku->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Hapus buku ini?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Dipus\resources\views/buku/index.blade.php ENDPATH**/ ?>