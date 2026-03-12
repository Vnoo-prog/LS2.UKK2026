
<?php $__env->startSection('content'); ?>
<h3 class="fw-bold mb-3">Riwayat Peminjaman Saya</h3>
<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-bordered mb-0 text-center align-middle">
            <thead class="table-light">
                <tr>
                    <th>Judul Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Tenggat Waktu</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $peminjamans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($p->buku->judul); ?></td>
                    <td><?php echo e($p->tanggal_peminjaman); ?></td>
                    <td><?php echo e($p->tanggal_pengembalian); ?></td>
                    <td>
                        <span class="badge <?php echo e($p->status_peminjaman == 'Dikembalikan' ? 'bg-success' : ($p->status_peminjaman == 'Sedang Cek' ? 'bg-warning' : 'bg-primary')); ?>">
                            <?php echo e($p->status_peminjaman); ?>

                        </span>
                    </td>
                    <td>
                        <?php if($p->status_peminjaman == 'Dipinjam'): ?>
                        <form action="<?php echo e(route('peminjaman.ajukan', $p->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-sm btn-warning">Ajukan Pengembalian</button>
                        </form>
                        <?php else: ?>
                            <span class="text-muted small">-</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Dipus\resources\views/peminjaman/index.blade.php ENDPATH**/ ?>