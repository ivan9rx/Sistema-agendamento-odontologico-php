<?php echo $this->extend('Front/Layout/main'); ?>


<?php echo $this->section('title'); ?>

<?php echo $title ??  'Home'; ?>

<?php echo $this->endSection(); ?>


<?php echo $this->section('css'); ?>


<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>



<div class="container pt-5 text-center">


    <div class="container">
        <?php if (auth()->loggedIn()) : ?>
            <?php if (auth()->user()->inGroup('user')) : ?>
                <li class="nav-item">
                    <h1>Olá <?php echo auth()->user()->username; ?> Seja bem vindo a nossa clínica</h1>
                </li>
            <?php endif; ?>
            <?php if (auth()->user()->inGroup('superadmin')) : ?>
                <li class="nav-item">
                    <h1>Olá Superadmin Seja bem vindo a nossa clínica</h1>
                </li>
            <?php endif; ?>

        <?php else : ?>
            <li class="nav-item">
                <h1>Olá Seja bem vindo a nossa clínica</h1>
            </li>
        <?php endif; ?>
    </div>


    <h2 class="mt-5">Veja como é facil criar seu agendamento</h2>

    <div class="row mt-4">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    Primeiro
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        Autentifique-se
                    </h5>
                    <p class="card-text">
                        Realize o login ou crie a sua conta
                    </p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card">
                <div class="card-header">
                    Segundo
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        Escolha a Profissional
                    </h5>
                    <p class="card-text">
                        Com quem você gostaria de ser atendido
                    </p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card">
                <div class="card-header">
                    Terceiro
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        Escolha o serviço
                    </h5>
                    <p class="card-text">
                        Serviço que deseja atendimento
                    </p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card">
                <div class="card-header">
                    Quarto
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        Escolha a data
                    </h5>
                    <p class="card-text">
                        Escolha a melhor data e horário
                    </p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card">
                <div class="card-header">
                    Pronto
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        Confirmação
                    </h5>
                    <p class="card-text">
                        Revise os dados e crie o agendamento
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">

        <div class="col-m-12">

            <a href="<?php echo route_to('schedules.new') ?>" class="btn btn-lg btn-primary">Criar Agendamento</a>

        </div>

    </div>

</div>


<?php echo $this->endSection(); ?>

<?php echo $this->section('js'); ?>

<script>

</script>


<?php echo $this->endSection(); ?>