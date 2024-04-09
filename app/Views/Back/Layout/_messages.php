<div class="container-fluid">
    <?php if (session()->has('info')) : ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <?php echo session('info') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>


    <?php if (session()->has('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo session('success') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    
    <?php if (session()->has('danger')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo session('danger') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
</div>