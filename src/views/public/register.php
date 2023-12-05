<?php
require_once __DIR__ . '/../../infrastructure/middlewares/middleware-not-authenticated.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="../../assets/js/global.js"></script>
    <link rel="stylesheet" href="../../assets/css/authentication.css">
    
    <title>Criar conta | StreamSync</title>
</head>
<body class="font-sans text-gray-900 antialiased">
  <div class="min-h-screen d-flex flex-column justify-content-center items-center pt-6 sm:pt-0 bg-gray-100">
        <section class="bg-image vh-100 position-relative">
            <div class="container py-3 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-dark text-white rounded-4 bg-opacity-75">
                            <div class="card-body p-3 text-center"> 
                                <div class="mb-md-3 mt-md-2">
                                    <img src="../../assets/images/logo.png" alt="StreamSync Logo" class="img-fluid">
                                    <form action="/StreamSync/src/controllers/auth/register.php" method="post" class="p-4">
                                      <div class="row mt-3">
                                        <div class="col-md-6 mb-3"> 
                                          <label class="form-label d-flex justify-content-start align-items-start" for="first_name">Primeiro Nome</label>
                                          <input id="first_name" class="form-control" type="text" name="first_name" 
                                            value="<?= isset($_REQUEST['first_name']) ? $_REQUEST['first_name'] : null ?>"  required  />
                                          <?php
                                            if (isset($_SESSION['errors']['first_name'])) {
                                                echo '<p class="alert" style="color: red;">' . $_SESSION['errors']['first_name'] . '</p>';
                                            }
                                          ?>
                                        </div>
                                        <div class="col-md-6 mb-3"> 
                                          <label class="form-label d-flex justify-content-start align-items-start" for="last_name">Último Nome</label>
                                          <input id="last_name" class="form-control" type="text" name="last_name" 
                                            value="<?= isset($_REQUEST['last_name']) ? $_REQUEST['last_name'] : null ?>" required />
                                          <?php
                                            if (isset($_SESSION['errors']['last_name'])) {
                                                echo '<p class="alert" style="color: red;">' . $_SESSION['errors']['last_name'] . '</p>';
                                            }
                                          ?>
                                        </div>
                                      </div>

                                      <div class="row">
                                        <div class="col-md-6 mb-3"> 
                                          <label class="form-label d-flex justify-content-start align-items-start" for="username">Username</label>
                                          <input id="username" class="form-control " type="text" name="username" 
                                            value="<?= isset($_REQUEST['username']) ? $_REQUEST['username'] : null ?>" required  />
                                          <?php
                                            if (isset($_SESSION['errors']['username'])) {
                                                echo '<p class="alert" style="color: red;">' . $_SESSION['errors']['username'] . '</p>';
                                            }
                                          ?>
                                        </div>
                                        <div class="col-md-6 mb-3"> 
                                          <label class="form-label d-flex justify-content-start align-items-start" for="birthdate">Data de Nascimento</label>
                                          <input id="birthdate" class="form-control " type="date" name="birthdate" 
                                            value="<?= isset($_REQUEST['birthdate']) ? $_REQUEST['birthdate'] : null ?>" required />
                                          <?php
                                            if (isset($_SESSION['errors']['birthdate'])) {
                                                echo '<p class="alert" style="color: red;">' . $_SESSION['errors']['birthdate'] . '</p>';
                                            }
                                          ?>
                                        </div>
                                      </div>

                                      <div class="mb-3"> 
                                        <label class="form-label d-flex justify-content-start align-items-start" for="email">Email</label>
                                        <input id="email" class="form-control " type="email" name="email"
                                          value="<?= isset($_REQUEST['email']) ? $_REQUEST['email'] : null ?>"  required  />
                                        <?php
                                          if (isset($_SESSION['errors']['email'])) {
                                              echo '<p class="alert" style="color: red;">' . $_SESSION['errors']['email'] . '</p>';
                                          }
                                        ?>
                                      </div>

                                      <div class="row mb-3">
                                        <div class="col-md-6 mb-3"> 
                                          <label class="form-label d-flex justify-content-start align-items-start" for="password">Password</label>
                                          <input id="password" class="form-control" type="password" name="password" required />
                                          <?php
                                            if (isset($_SESSION['errors']['password'])) {
                                                echo '<p class="alert" style="color: red;">' . $_SESSION['errors']['password'] . '</p>';
                                            }
                                          ?>
                                        </div>
                                        <div class="col-md-6 mb-3"> 
                                          <label class="form-label d-flex justify-content-start align-items-start" for="password_confirmation">Confirmar Password</label>
                                          <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required />
                                          <?php
                                            if (isset($_SESSION['errors']['password_confirmation'])) {
                                                echo '<p class="alert" style="color: red;">' . $_SESSION['errors']['password_confirmation'] . '</p>';
                                            }
                                          ?>
                                        </div>
                                      </div>

                                      <button class="btn btn-outline-light btn-lg px-4 mt-3" type="submit" name="user" value="signUp">Registar</button> 
                                    </form>

                                </div>
                                <div>
                                    <p>Já tem conta StreamSync?<a href="/StreamSync/src/views/public/login.php" class="text-white-50 fw-bold ms-2">Inicia sessão agora!</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
</html>
