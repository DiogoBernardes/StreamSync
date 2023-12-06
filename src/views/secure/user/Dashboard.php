<?php
$title = 'Dashboard | StreamSync';
require_once __DIR__ .  '/../../../../vendor/autoload.php';
require_once __DIR__ . '/../../../infrastructure/middlewares/middleware-user.php';
@require_once __DIR__ . '/../../../validations/session.php';
require_once __DIR__ . '/../../../repositories/userRepository.php';
require_once __DIR__ . '/../../../templates/header.php'; 
$user = user();
$userAvatar = getAvatarById($user['id']);
?>

  <div class="container-fluid">
    <div class="row flex-nowrap ">
      <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
        <div class="d-flex flex-column p-4  min-vh-100">

          <div class="d-flex justify-content-center align-items-center mt-4">
            <a href="/StreamSync/" class="mx-auto">
              <img src="../../../assets/images/logo.png" alt="StreamSync Logo" height="24" />
            </a>
          </div>
          <ul class="nav nav-pills d-flex flex-column mb-sm-auto mb-0 align-items-sm-start align-items-center mt-5"
            id="menu">
            <li class="nav-item">
              <a href="/" class="nav-link align-middle px-0 transition">
                <i class="fs-4 bi-house text-white"></i> <span class="ms-1 d-none d-sm-inline text-white">Home</span>
              </a>
            </li>
            <li>
              <a href="#submenu1" class="nav-link px-0 align-middle transition">
                <i class="fs-4 bi-list text-white"></i> <span class="ms-1 d-none d-sm-inline text-white">Listas</span>
                
              </a>
            </li>
            <li>
              <a href="#" class="nav-link px-0 align-middle transition">
                <i class="fs-4 bi-calendar text-white"></i> 
                <span class="ms-1 d-none d-sm-inline text-white">Calendarização</span>
              </a>
            </li>
            <li>
              <a href="/StreamSync/src/views/secure/user/profile.php" class="nav-link px-0 align-middle transition">
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
                <button type="button" class="btn btn-link transition" style="color: white;" data-bs-toggle="modal"
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

