

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold">Laporan & Persetujuan Pengembalian</h3>
</div>

<div class="card shadow-sm border-0 mb-4 bg-light">
    <div class="card-body">
        <form action="<?php echo e(route('laporan.index')); ?>" method="GET" class="row align-items-end">
            <div class="col-md-3">
                <label class="small fw-bold">Dari Tanggal (Peminjaman)</label>
                <input type="date" name="tgl_awal" class="form-control" value="<?php echo e(request('tgl_awal')); ?>">
            </div>
            <div class="col-md-3">
                <label class="small fw-bold">Sampai Tanggal</label>
                <input type="date" name="tgl_akhir" class="form-control" value="<?php echo e(request('tgl_akhir')); ?>">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary fw-bold">Filter</button>
                <a href="<?php echo e(route('laporan.index')); ?>" class="btn btn-outline-secondary">Reset</a>
                
                <a href="<?php echo e(route('laporan.cetak', ['tgl_awal' => request('tgl_awal'), 'tgl_akhir' => request('tgl_akhir')])); ?>" target="_blank" class="btn btn-warning fw-bold">🖨️ Cetak PDF</a>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 text-center">
            <thead class="table-dark">
                <tr>
                    <th>Peminjam</th>
                    <th>Judul Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Tenggat</th>
                    <th>Status</th>
                    <th>Persetujuan Petugas</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $peminjamans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="fw-bold"><?php echo e($p->user->nama_lengkap); ?></td>
                    <td><?php echo e($p->buku->judul); ?></td>
                    <td><?php echo e($p->tanggal_peminjaman); ?></td>
                    <td class="<?php echo e(now()->greaterThan($p->tanggal_pengembalian) && $p->status_peminjaman != 'Dikembalikan' ? 'text-danger fw-bold' : ''); ?>">
                        <?php echo e($p->tanggal_pengembalian); ?>

                    </td>
                    <td><span class="badge bg-secondary"><?php echo e($p->status_peminjaman); ?></span></td>
                    <td>
                        <?php if($p->status_peminjaman == 'Sedang Cek'): ?>
                        <div class="d-flex justify-content-center gap-2">
                            <form action="<?php echo e(route('peminjaman.terima', $p->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?> <button class="btn btn-sm btn-success fw-bold">Terima</button>
                            </form>
                            <form action="<?php echo e(route('peminjaman.tolak', $p->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?> <button class="btn btn-sm btn-danger fw-bold">Tolak</button>
                            </form>
                        </div>
                        <?php else: ?>
                        <span class="text-muted small">Selesai / Belum Diajukan</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Dipus\resources\views/laporan/index.blade.php ENDPATH**/ ?>