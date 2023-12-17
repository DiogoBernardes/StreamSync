<?php
require_once __DIR__ .  '/../../../../vendor/autoload.php';
require_once __DIR__ . '/../../../repositories/userRepository.php';
require_once __DIR__ . '/../../../repositories/contentRepository.php';
require_once __DIR__ . '/../../../repositories/reviewsRepository.php';
require_once __DIR__ . '/../../../repositories/shareRepository.php';
require_once __DIR__ . '/../../../infrastructure/middlewares/middleware-administrator.php';
require_once __DIR__ . '/../../../templates/header.php';
$user = user();
$userCountsByMonth = getUsersCountByMonth();
$deletedUsersCountByMonth = getDeletedUsersCountByMonth();
$contentCountByCategory = getContentCountByCategory();
$contentCountByType = getContentCountByType();
$rating = getRatingStatistics();
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
        <div class="row w-100 d-flex justify-content-center align-items-center mb-5 mt-5">
          <div class="col-3 mb-3">
            <div class="card text-white bg-primary">
              <div class="card-body">
                <h5 class="card-title">Média de Idades</h5>
                <p class="card-text">
                  <?php
                  $averageAge = calculateAverageAge();
                  echo "A média de idades dos utilizadores é: " . number_format($averageAge, 2) . " anos";
                  ?>
                </p>
              </div>
            </div>
          </div>
          <div class="col-3 mb-3">
            <div class="card text-white bg-secondary">
              <div class="card-body">
                <h5 class="card-title">Média de Conteúdos Diários</h5>
                <p class="card-text">
                  <?php
                  $averageContentPerDay = calculateAverageContentPerDay();
                  echo "A média de conteúdos inseridos diariamente é: " . number_format($averageContentPerDay, 2);
                  ?>
                </p>
              </div>
            </div>
          </div>
          <div class="col-3 mb-3">
            <div class="card text-white bg-success">
              <div class="card-body">
                <h5 class="card-title">Média de Compartilhamentos Diários</h5>
                <p class="card-text">
                  <?php
                  $averageSharesPerDay = calculateAverageSharesPerDay();
                  if ($averageSharesPerDay !== false) {
                    echo "A média de compartilhamentos diários é: " . number_format($averageSharesPerDay, 2);
                  } else {
                    echo "Erro ao calcular a média de compartilhamentos diários.";
                  }
                  ?>
                </p>
              </div>
            </div>
          </div>
          <div class="col-3 mb-3">
            <div class="card text-white bg-warning">
              <div class="card-body">
                <h5 class="card-title">Média de Avaliações Diárias</h5>
                <p class="card-text">
                  <?php
                  $averageReviewsPerDay = calculateAverageReviewsPerDay();
                  if ($averageReviewsPerDay !== false) {
                    echo "A média de avaliações diárias é: " . number_format($averageReviewsPerDay, 2);
                  } else {
                    echo "Erro ao calcular a média de avaliações diárias.";
                  }
                  ?>
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="row w-100 d-flex justify-content-center align-items-center mb-5">
          <div class="col-6 ">
            <canvas id="lineChart"></canvas>
          </div>
          <div class="col-6">
            <canvas id="doughnutChart"></canvas>
          </div>
        </div>
        <div class="row w-100 d-flex justify-content-center align-items-center mt-5">
          <div class="col-6 ">
            <canvas id="barChart"></canvas>
          </div>
          <div class="col-6">
            <canvas id="polarAreaChart"></canvas>
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
    //Line Chart
    const ctx = document.getElementById('lineChart');
    const userCountsByMonth = <?php echo json_encode($userCountsByMonth); ?>;
    const deletedUsersCountByMonth = <?php echo json_encode($deletedUsersCountByMonth); ?>;

    new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        datasets: [{
            label: 'Número de utilizadores registados',
            data: userCountsByMonth,
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1,
            fill: false
          },
          {
            label: 'Número de utilizadores eliminados',
            data: deletedUsersCountByMonth,
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1,
            fill: false
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
    //barChart
    const contentTypeCtx = document.getElementById('barChart');
    const contentCountByType = <?php echo json_encode($contentCountByType); ?>;
    const typeColors = Object.keys(contentCountByType).map(() => generateRandomColor());

    new Chart(barChart, {
      type: 'bar',
      data: {
        labels: Object.keys(contentCountByType),
        datasets: [{
          data: Object.values(contentCountByType),
          backgroundColor: typeColors,
          borderWidth: 1,
        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true
          }
        },
        plugins: {
          legend: {
            display: false,
          },
          title: {
            display: true,
            text: 'Conteúdo por Tipo',
            position: 'top',
          },
        },
      },
    });

    // Polar Area Chart
    const polarAreaCtx = document.getElementById('polarAreaChart');
    const ratingStatistics = <?php echo json_encode(getRatingStatistics()); ?>;
    const ratingLabels = Object.keys(ratingStatistics);
    const ratingData = Object.values(ratingStatistics);

    new Chart(polarAreaCtx, {
      type: 'polarArea',
      data: {
        labels: ratingLabels,
        datasets: [{
          data: ratingData,
          backgroundColor: [
            'rgba(255, 99, 132, 0.7)',
            'rgba(255, 159, 64, 0.7)',
            'rgba(255, 205, 86, 0.7)',
            'rgba(75, 192, 192, 0.7)',
            'rgba(54, 162, 235, 0.7)',
          ],
        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          title: {
            display: true,
            text: 'Distribuição da Pontuação de Ratings',
            position: 'top',
          },
        },
      },
    });
  </script>
</body>

</html>