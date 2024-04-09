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
            <?php echo form_open(route_to('services.update', $servico->id), hidden: ['_method' => 'PUT']); ?>

            <?php echo $this->include('Back/Services/_form') ?>


            <?php echo form_close() ?>
        </div>
    </div>


</div>
<!-- /.container-fluid -->


<?php echo $this->endSection(); ?>

<?php echo $this->section('js'); ?>

<?php echo $this->endSection(); ?>