<?php

use PhpParser\Node\Stmt\Echo_;

echo $this->extend('Front/Layout/main'); ?>


<?php echo $this->section('title'); ?>

<?php echo $title ??  'Home'; ?>

<?php echo $this->endSection(); ?>


<?php echo $this->section('css'); ?>



<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>

<div class="container pt-5">
    <h1 class="mt-5"><?php echo $title; ?></h1>

    <div id="boxSuccess" class="mb-4 mt-3">

    </div>

    <div id="boxErrors" class="mb-4 mt-3">

    </div>

    <div id="boxUserSchedules" class="mb-4 mt-3">
        
    </div>


</div>


<?php echo $this->endSection(); ?>

<?php echo $this->section('js'); ?>

<script>
    const URL_GET_USER_SCHEDULES = '<?php echo route_to('schedules.my.all'); ?>'
    const URL_CANCEL_USER_SCHEDULES = '<?php echo route_to('schedules.my.cancel'); ?>'

    let csrfTokenName = '<?php echo csrf_token(); ?>';
    let csrfTokenValue = '<?php echo csrf_hash(); ?>';

    const boxSuccess = document.getElementById('boxSuccess');
    const boxErrors = document.getElementById('boxErrors');
    const boxUserSchedules = document.getElementById('boxUserSchedules');

    const getUserSchedules = async () => {

        boxErrors.innerHTML = '';

        const response = await fetch(URL_GET_USER_SCHEDULES, {
            method: "get",
            headers: setHeadersRequest(),
        });

        if (!response.ok) {
            boxErrors.innerHTML = showErrorMessage('Não foi possível recuperar os agendamentos');
            throw new Error(`HTTP error! Status: ${response.status}`);
            return;
        }

        const data = await response.json()

        boxUserSchedules.innerHTML = data.schedules;

        const buttonsCancelSchedule = document.querySelectorAll('.btnCancelSchedule');

        buttonsCancelSchedule.forEach(button => {

            button.addEventListener('click', (event) => {
                const schedule = event.target.dataset.schedule;

                if(!schedule) {
                    boxErrors.innerHTML = showErrorMessage('Não conseguimos identificar o agendamento');
                    return;
                }

                const result = confirm("Tem certeza do cancelamento? \n Essa ação não poderá ser desfeita");

                if(!result) {
                    return;
                }

                button.disabled = true;

                button.innerText = 'Estamos cancelando..';

                tryCancelUserSchedule(schedule);
            });

        });
    };

    //cancela o agendamento

    const tryCancelUserSchedule = async (schedule) => {
        boxSuccess.innerHTML = '';
        boxErrors.innerHTML = '';

        const body = {
            schedule: parseInt(schedule)
        }

        body[csrfTokenName] = csrfTokenValue;

        const response = await fetch(URL_CANCEL_USER_SCHEDULES, {
            method: "delete",
            headers: setHeadersRequest(),
            body: JSON.stringify(body),
        });

        if (!response.ok) {
            boxErrors.innerHTML = showErrorMessage('Não foi possível cancelar o agendamento');
            throw new Error(`HTTP error! Status: ${response.status}`);
            return;
        }

        const data = await response.json()

        //atualizo o token do CSRF
        csrfTokenValue = data.token;

        //tudo certo..
        boxSuccess.innerHTML = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                                    Agendamento cancelado
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>`;



        //recuperamos os agendamentos para atualizar as divs                       
        getUserSchedules();
    };

    window.addEventListener('load', () => {
        getUserSchedules();
    });
</script>

<?php echo $this->endSection(); ?>