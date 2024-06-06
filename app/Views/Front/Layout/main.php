<!doctype html>
<html lang="en" class="h-100">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.84.0">
  <title>Meus agendamentos <?php echo $this->renderSection('title'); ?></title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sticky-footer-navbar/">



  <!-- Bootstrap core CSS -->
  <link href="<?php echo base_url('front/'); ?>bootstrap.min.css" rel="stylesheet"  crossorigin="anonymous">




  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

   
  </style>


  <!-- Custom styles for this template -->
  <?php echo $this->renderSection('css'); ?>

</head>

<body class="d-flex flex-column h-100">

  <header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-primary" style="background-color: #007BFF;"> <!--navbar navbar-expand-md navbar-dark fixed-top bg-dark -->
      <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo route_to('home') ?>">Clínica Odonto</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav me-auto mb-2 mb-md-0">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="<?php echo route_to('home') ?>">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo route_to('schedules.new') ?>">Criar agendamentos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo route_to('schedules.my') ?>">Meus agendamentos</a>
            </li>
          </ul>
          <div class="d-flex">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
              <?php if (auth()->loggedIn()) : ?>
                <?php if (auth()->user()->inGroup('superadmin')) : ?>
                  <li class="nav-item">
                    <a href="http://localhost:8080/super" class="nav-link active">Painel administrativo</a>
                  </li>
                <?php endif; ?>
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="<?php echo route_to('logout') ?>">Sair</a>
                </li>
              <?php else : ?>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo route_to('login') ?>">Entrar | Registrar-se</a>
                </li>
              <?php endif; ?>
            </ul>

          </div>
        </div>
      </div>
    </nav>
  </header>

  <!-- Begin page content -->
  <main class="flex-shrink-0">

    <?php echo $this->renderSection('content'); ?>


  </main>




  <script src="<?php echo base_url('front/'); ?>bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <?php echo $this->renderSection('js'); ?>

  <script>
    const setParameters = (object) => {
      return (new URLSearchParams(object)).toString()
    }

    const setHeadersRequest = () => {
      return {
        "Content-Type": "application/json",
        "X-Requested-With": "XMLHttpRequest"
      }
    }

    const showErrorMessage = (message) => {
      boxErrors.innerHTML = '';
      return `<div class="alert alert-danger">${message}</div>`
    }
  </script>

</body>

</html>