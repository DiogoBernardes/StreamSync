<?php
require_once __DIR__ . '/../../../infrastructure/middlewares/middleware-user.php';
@require_once __DIR__ . '/../../../validations/session.php';
require_once __DIR__ . '/../../../repositories/userRepository.php';
$user = user();
$userAvatar = getAvatarById($user['id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!--Bootstrap-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <!--Bootstrap Fonts and icons-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@1,200&display=swap" rel="stylesheet">
  <!--Bootstrap bundle js-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
  </script>
  <!-- Bootstrap JS e Popper.js são necessários para modais -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-QC2iCZ3/wtFNAesF+Aeb3DcwoKRa5QD4l3wrqO1kQQjKd50oXjtX1z1v9U+HfnR"
    crossorigin="anonymous"></script>
  <title>Dashboard | StreamSync</title>
</head>

<body>
  <div class="container-fluid">
    <div class="row flex-nowrap ">
      <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark opacity-75">
        <div class="d-flex flex-column p-4  min-vh-100">

          <div class="d-flex justify-content-center align-items-center mt-4">
            <a href="/" class="mx-auto">
              <img src="../../../assets/images/logo.png" alt="StreamSync Logo" height="24" />
            </a>
          </div>
          <ul class="nav nav-pills d-flex flex-column mb-sm-auto mb-0 align-items-sm-start align-items-center mt-5"
            id="menu">
            <li class="nav-item">
              <a href="/" class="nav-link align-middle px-0">
                <i class="fs-4 bi-house text-white"></i> <span class="ms-1 d-none d-sm-inline text-white">Home</span>
              </a>
            </li>
            <li>
              <a href="#submenu1" class="nav-link px-0 align-middle">
                <i class="fs-4 bi-list text-white"></i> <span class="ms-1 d-none d-sm-inline text-white">Listas</span>
                
              </a>
            </li>
            <li>
              <a href="#" class="nav-link px-0 align-middle">
                <i class="fs-4 bi-calendar-date text-white"></i> 
                <span class="ms-1 d-none d-sm-inline text-white">Calendarização</span>
              </a>
            </li>
            <li>
              <a href="/StreamSync/src/views/secure/user/profile.php" class="nav-link px-0 align-middle ">
                <i class="fs-4 bi-person text-white"></i> <span
                  class="ms-1 d-none d-sm-inline text-white">Perfil</span>
              </a>
            </li>
          </ul>

            <hr>
            <div id="user" class="mt-auto mb-3 text-sm-start text-center d-flex justify-content-between align-items-center">
                <div>
                    <?php if ($userAvatar !== null) : ?>
                        <img src="<?= $userAvatar ?>" alt="User Avatar" class="rounded-circle" style="width: 42px; height: 42px;">
                    <?php else : ?>
                        <img src="https://cdn3.iconfinder.com/data/icons/network-communication-vol-3-1/48/111-512.png"
                            alt="Default Avatar" class="rounded-circle" style="width: 42px; height: 42px;">
                    <?php endif; ?>
                    <span class="d-none d-sm-inline mx-1 text-white"><?= $user['first_name'] ?? null ?></span>
                </div>
                <button type="button" class="btn btn-link" style="color: white;" data-bs-toggle="modal"
                    data-bs-target="#logoutModal">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </div>
        </div>
      </div>

      <!-- Content -->
      <div class="col py-3">
        <h3>Left Sidebar with Submenus</h3>
        <p class="lead">
          An example 2-level sidebar with collasible menu items. The menu functions like an "accordion" where only a
          single
          menu is be open at a time. While the sidebar itself is not toggle-able, it does responsively shrink in width
          on smaller screens.</p>
        <ul class="list-unstyled">
          <li>
            <h5>Responsive</h5> shrinks in width, hides text labels and collapses to icons only on mobile
          </li>
        </ul>
      </div>
    </div>
  </div>

    <!-- Modal de confirmação de logout -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="logoutModalLabel">Terminar Sessão</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Tem certeza de que deseja encerrar a sessão?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <form action="/StreamSync/src/controllers/auth/login.php" method="post">
            <button type="submit" name="user" value="logout" class="btn btn-danger">Sim, encerrar a sessão</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  
</body>
</html>

