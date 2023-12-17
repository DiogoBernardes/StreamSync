<?php
require_once __DIR__ . '/../../../infrastructure/middlewares/middleware-administrator.php';
require_once __DIR__ . '/../../../templates/header.php';
@require_once __DIR__ . '/../../../validations/session.php';

$user = user();
$users = getAll();
$title = ' - user';
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
              <a href="/StreamSync/src/views/secure/admin/index.php" class="nav-link align-middle px-0 transition">
                <i class="fs-4 bi-house text-white"></i> <span class="ms-1 d-none d-sm-inline text-white">Dashboard</span>
              </a>
            </li>
            <li>
              <a href="javascript:void(0)" class="nav-link px-0 align-middle transition" onclick="loadContent('Lists')">
                <i class="fs-4 bi-person-fill-gear text-white"></i> <span class="ms-1 d-none d-sm-inline text-white">Gestão</span>
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

      <div id="content" class="col bg-color overflow-auto w-100 h-100 py-3">
        <section class="mb-5 mt-5">
          <?php
          if (isset($_SESSION['success_message'])) {
            echo '<div class="alert alert-success" role="alert">' . $_SESSION['success_message'] . '</div>';
            unset($_SESSION['success_message']);
          } elseif (isset($_SESSION['error_message'])) {
            echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error_message'] . '</div>';
            unset($_SESSION['error_message']);
          }
          ?>
          <div class="row d-flex align-items-start">
            <div class="col-md-6 col-sm-12 mb-3">
              <form enctype="multipart/form-data" action="/StreamSync/src/controllers/admin/category.php" method="post">
                <div class="mb-3">
                  <label for="newCategory" class="form-label">Nova Categoria</label>
                  <input type="text" class="form-control" id="newCategory" name="name" required>
                </div>
                <button type="submit" id="submit" name="category" value="create" class="btn btn-outline-info btn-sm">Adicionar</button>
              </form>
            </div>
            <div class="col-md-6 col-sm-12 mb-3">
              <form enctype="multipart/form-data" action="/StreamSync/src/controllers/admin/contentType.php" method="post">
                <div class="mb-3">
                  <label for="newContentType" class="form-label">Novo Tipo Conteúdo</label>
                  <input type="text" class="form-control" id="newContentType" name="name" required>
                </div>
                <button type="submit" id="submit" name="contentType" value="create" class="btn btn-outline-info btn-sm">Adicionar</button>
              </form>
            </div>
          </div>
        </section>
        <section>
          <div class="table-responsive mt-5">
            <table class="table">
              <thead class="table-secondary">
                <tr>
                  <th scope="col"><i class="bi bi-person"></i></th>
                  <th scope="col">Name</th>
                  <th scope="col">Lastname</th>
                  <th scope="col">Birthdate</th>
                  <th scope="col">Email</th>
                  <th scope="col">Username</th>
                  <th scope="col">Administrator</th>
                  <th scope="col">Manage</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($users as $user) {
                ?>
                  <tr>
                    <td>
                      <?php if ($user['avatar'] !== null) : ?>
                        <img src="data:image/png;base64,<?= base64_encode($user['avatar']) ?>" alt="User Avatar" class="rounded-circle " style="width: 42px; height: 42px;">
                      <?php else : ?>
                        <img src="https://cdn3.iconfinder.com/data/icons/network-communication-vol-3-1/48/111-512.png" alt="Default Avatar" class="rounded-circle" style="width: 42px; height: 42px;">
                      <?php endif; ?>
                    </td>
                    <th scope="row">
                      <?= $user['first_name'] ?>
                    </th>
                    <td>
                      <?= $user['last_name'] ?>
                    </td>
                    <td>
                      <?= $user['birthdate'] ?>
                    </td>
                    <td>
                      <?= $user['email'] ?>
                    </td>
                    <td>
                      <?= $user['username'] ?>
                    </td>
                    <td>
                      <?= $user['role_id'] == '1' ? 'Yes' : 'No' ?>
                    </td>
                    <td>
                      <div class="d-flex justify-content">
                        <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#delete<?= $user['id'] ?>">delete</button>
                      </div>
                    </td>
                  </tr>
                  <div class="modal fade" id="delete<?= $user['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">Delete user</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          Are you sure you want to delete this user?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          <a href="/crud/controllers/admin/user.php?<?= 'user=delete&id=' . $user['id'] ?>"><button type="button" class="btn btn-danger">Confirm</button></a>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
        </section>
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

</body>