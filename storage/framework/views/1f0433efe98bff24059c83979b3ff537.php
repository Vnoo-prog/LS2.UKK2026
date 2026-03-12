

<?php $__env->startSection('content'); ?>
<div class="card shadow-sm col-md-6 mx-auto">
    <div class="card-header bg-white fw-bold">Edit Data Buku</div>
    <div class="card-body">
        <form action="<?php echo e(route('buku.update', $buku->id)); ?>" method="POST">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <div class="mb-3"><label>Judul Buku</label><input type="text" name="judul" class="form-control" value="<?php echo e($buku->judul); ?>" required></div>
            <div class="mb-3"><label>Penulis</label><input type="text" name="penulis" class="form-control" value="<?php echo e($buku->penulis); ?>" required></div>
            <div class="mb-3"><label>Penerbit</label><input type="text" name="penerbit" class="form-control" value="<?php echo e($buku->penerbit); ?>" required></div>
            <div class="mb-3"><label>Tahun Terbit</label><input type="number" name="tahun_terbit" class="form-control" value="<?php echo e($buku->tahun_terbit); ?>" required></div>
            <button type="submit" class="btn btn-warning w-100">Update Buku</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Dipus\resources\views/buku/edit.blade.php ENDPATH**/ ?>