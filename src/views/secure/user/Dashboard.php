<?php
$title = 'Dashboard | StreamSync';
require_once __DIR__ .  '/../../../../vendor/autoload.php';
require_once __DIR__ . '/../../../infrastructure/middlewares/middleware-user.php';
@require_once __DIR__ . '/../../../validations/session.php';
require_once __DIR__ . '/../../../repositories/userRepository.php';
require_once __DIR__ . '/../../../repositories/contentRepository.php';
require_once __DIR__ . '/../../../templates/header.php';

$user = user();
$watchedEvents = getWatchedDatesForCalendar($user['id']);
?>

<body class="vh-100">
  <div class="container-fluid h-100">
    <div class="row flex-nowrap h-100">
      <div id="sidebar" class="col-3 col-sm-2 px-0 sidebar-color ">
        <div class="d-flex flex-column p-4 min-vh-100">

          <div class="d-flex justify-content-center align-items-center mt-4">
            <a href="/StreamSync/" class="mx-auto">
              <img src="../../../assets/images/logo.png" alt="StreamSync Logo" height="24" />
            </a>
          </div>
          <ul class="nav nav-pills d-flex flex-column mb-sm-auto mb-0 align-items-sm-start align-items-center mt-5" id="menu">
            <li class="nav-item">
              <a href="/StreamSync/src/views/secure/user/Dashboard.php" class="nav-link align-middle px-0 transition">
                <i class="fs-4 bi-house text-white"></i> <span class="ms-1 d-none d-sm-inline text-white">Home</span>
              </a>
            </li>
            <li>
              <a href="javascript:void(0)" class="nav-link px-0 align-middle transition" onclick="loadContent('Lists')">
                <i class="fs-4 bi-list text-white"></i> <span class="ms-1 d-none d-sm-inline text-white">Listas</span>
              </a>
            </li>
            <li>
              <a href="javascript:void(0)" class="nav-link px-0 align-middle transition" onclick="loadContent('sharedLists')">
                <i class="fs-5 bi bi-share text-white"></i>
                <span class="ms-1 d-none d-sm-inline text-white">Listas Partilhadas</span>
              </a>
            </li>
            <li>
              <a href="javascript:void(0)" class="nav-link px-0 align-middle transition" onclick="loadContent('profile')">
                <i class="fs-4 bi-person text-white"></i> <span class="ms-1 d-none d-sm-inline text-white">Perfil</span>
              </a>
            </li>
          </ul>


          <div id="user" class="mt-auto mb-3 text-sm-start text-center d-flex justify-content-between align-items-center">
            <div>
              <?php if ($user['avatar'] !== null) : ?>
                <img src="data:image/png;base64,<?= base64_encode($user['avatar']) ?>" alt="User Avatar" class="rounded-circle " style="width: 42px; height: 42px;">
              <?php else : ?>
                <img src="https://cdn3.iconfinder.com/data/icons/network-communication-vol-3-1/48/111-512.png" alt="Default Avatar" class="rounded-circle" style="width: 42px; height: 42px;">
              <?php endif; ?>
              <span class="d-none d-sm-inline mx-1 text-white"><?= $user['first_name'] ?? null ?></span>
            </div>
            <button type="button" class="btn btn-link transition" style="color: white;" data-bs-toggle="modal" data-bs-target="#logoutModal">
              <i class="bi bi-box-arrow-right"></i>
            </button>
          </div>
        </div>
      </div>



      <!-- Content -->
      <div id="content" class="col d-flex flex-column justify-content-center align-items-center bg-color overflow-auto h-100 py-3">
        <div id='calendar' class="col-12 col-md-10 col-lg-8 p-3 mx-auto mt-3 mt-md-0 bg-light">
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
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          events: <?php echo json_encode($watchedEvents); ?>,
          eventColor: '#f95959',
          headerToolbar: {
            left: 'title',
            center: '',
            right: 'prev,next today'
          },
          themeSystem: 'bootstrap',
        });

        calendar.render();
      });
    </script>
</body>

</html>