<?php
require_once __DIR__ .  '/../../../../vendor/autoload.php';
require_once __DIR__ . '/../../../repositories/userRepository.php';
require_once __DIR__ . '/../../../repositories/contentRepository.php';
require_once __DIR__ . '/../../../infrastructure/middlewares/middleware-administrator.php';
require_once __DIR__ . '/../../../templates/header.php';
$user = user();
$userCountsByMonth = getUsersCountByMonth();
$deletedUsersCountByMonth = getDeletedUsersCountByMonth();
$contentCountByCategory = getContentCountByCategory();
$title = 'Admin management';
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
                <i class="fs-4 bi-people text-white"></i> <span class="ms-1 d-none d-sm-inline text-white">Utilizadores</span>
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

        <div class="row w-100 d-flex justify-content-center align-items-center">
          <div class="col-6 ">
            <canvas id="myChart"></canvas>
          </div>
          <div class="col-6">
            <canvas id="doughnutChart"></canvas>
          </div>
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
  </div>

  <script>
    // Chart
    const ctx = document.getElementById('myChart');
    const userCountsByMonth = <?php echo json_encode($userCountsByMonth); ?>;
    const deletedUsersCountByMonth = <?php echo json_encode($deletedUsersCountByMonth); ?>; // Certifique-se de ter essa variável

    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        datasets: [{
            label: 'Número de utilizadores registados',
            data: userCountsByMonth,
            backgroundColor: 'rgba(75, 192, 192, 0.8)',
            borderWidth: 1
          },
          {
            label: 'Número de utilizadores eliminados',
            data: deletedUsersCountByMonth,
            backgroundColor: 'rgba(255, 99, 132, 0.8)',
            borderWidth: 1
          }
        ]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });

    // Doughnut Chart
    function generateRandomColor() {
      const randomColor = `rgba(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, 0.8)`;
      return randomColor;
    }

    const doughnutCtx = document.getElementById('doughnutChart');
    const contentCountByCategory = <?php echo json_encode($contentCountByCategory); ?>;
    const categoryColors = Object.keys(contentCountByCategory).map(() => generateRandomColor());

    new Chart(doughnutCtx, {
      type: 'doughnut',
      data: {
        labels: Object.keys(contentCountByCategory),
        datasets: [{
          data: Object.values(contentCountByCategory),
          backgroundColor: categoryColors,
        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          title: {
            display: true,
            text: 'Conteúdo Total por Categorias',
            position: 'top',
          },
          legend: {
            position: 'right',
          },
        },
      },
    });
  </script>





</body>

</html>