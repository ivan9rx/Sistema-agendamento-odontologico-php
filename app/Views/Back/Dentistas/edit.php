<?php echo $this->extend('Back/Layout/main'); ?>


<?php echo $this->section('title'); ?>

<?php echo $title ?? 'Home'; ?>

<?php echo $this->endSection(); ?>


<?php echo $this->section('css'); ?>


<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <?php echo $title ?? 'Home' ?>
            </h6>
        </div>
        <div class="card-body">
            <?php echo form_open(route_to('dentistas.update', $dentista->id), hidden: ['_method' => 'PUT']); ?>

            <?php echo $this->include('Back/Dentistas/_form') ?>


            <?php echo form_close() ?>
        </div>
    </div>


</div>
<!-- /.container-fluid -->


<?php echo $this->endSection(); ?>

<?php echo $this->section('js'); ?>

<script src="<?php echo base_url('back/mask/jquery.mask.min.js'); ?>"></script>
<script src="<?php echo base_url('back/mask/app.js'); ?>"></script>

<?php echo $this->endSection(); ?>