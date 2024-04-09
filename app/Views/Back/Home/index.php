<?php echo $this->extend('Back/Layout/main'); ?>


<?php echo $this->section('title'); ?>

<?php echo $title ??  'Home'; ?>

<?php echo $this->endSection(); ?>


<?php echo $this->section('css'); ?>


<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>


    <div class="d-flex flex-column align-items-center">
        <div class="p-2">
            <h1>Olá <?php echo auth()->user()->username; ?> </h1>
        </div>
    </div>




<?php echo $this->endSection(); ?>

<?php echo $this->section('js'); ?>



<?php echo $this->endSection(); ?>