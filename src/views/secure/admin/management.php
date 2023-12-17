<?php
require_once __DIR__ . '/../../../infrastructure/middlewares/middleware-administrator.php';
require_once __DIR__ . '/../../../repositories/contentRepository.php';
require_once __DIR__ . '/../../../repositories/userRepository.php';
require_once __DIR__ . '/../../../templates/header.php';
@require_once __DIR__ . '/../../../validations/session.php';

$user = user();
$users = getAll();
$roles = getAllRoles();
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
              <a href="/StreamSync/src/views/secure/admin/management.php" class="nav-link px-0 align-middle transition">
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
                <button type="submit" id="submitCategory" name="category" value="create" class="btn btn-outline-info btn-sm">Adicionar</button>
              </form>
            </div>
            <div class="col-md-6 col-sm-12 mb-3">
              <form enctype="multipart/form-data" action="/StreamSync/src/controllers/admin/contentType.php" method="post">
                <div class="mb-3">
                  <label for="newContentType" class="form-label">Novo Tipo Conteúdo</label>
                  <input type="text" class="form-control" id="newContentType" name="name" required>
                </div>
                <button type="submit" id="submitContentType" name="contentType" value="create" class="btn btn-outline-info btn-sm">Adicionar</button>
              </form>
            </div>
          </div>
        </section>
        <section>
          <div class="d-flex justify-content-end">
            <button type=" button" class="btn btn-outline-info" data-toggle="modal" data-target="#userModal">Adicionar Utilizador</button>
          </div>
          <div class="table-responsive mt-3">
            <table class="table">
              <thead class="table-secondary text-center">
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
                  <tr class="text-center">
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
                      <?= $user['role_id'] == '1' ? 'Sim' : 'Não' ?>
                    </td>
                    <td>
                      <div class="d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $user['id']; ?>">Apagar</button>
                      </div>
                    </td>
                  </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
        </section>
      </div>

    </div>


    <!-- Modal Inserir User -->
    <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title text-primary" id="contentModalLabel">Inserir Conteúdo</h3>
          </div>
          <div class="modal-body">

            <form action="/StreamSync/src/controllers/admin/user.php" method="post" class="p-4">
              <div class="row mt-3">
                <div class="col-md-6 mb-3">
                  <label class="form-label d-flex justify-content-start align-items-start" for="first_name">Primeiro Nome</label>
                  <input id="first_name" class="form-control" type="text" name="first_name" value="<?= isset($_REQUEST['first_name']) ? $_REQUEST['first_name'] : null ?>" required />
                  <?php
                  if (isset($_SESSION['errors']['first_name'])) {
                    echo '<p class="alert" style="color: red;">' . $_SESSION['errors']['first_name'] . '</p>';
                  }
                  ?>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label d-flex justify-content-start align-items-start" for="last_name">Último Nome</label>
                  <input id="last_name" class="form-control" type="text" name="last_name" value="<?= isset($_REQUEST['last_name']) ? $_REQUEST['last_name'] : null ?>" required />
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
                  <input id="username" class="form-control " type="text" name="username" value="<?= isset($_REQUEST['username']) ? $_REQUEST['username'] : null ?>" required />
                  <?php
                  if (isset($_SESSION['errors']['username'])) {
                    echo '<p class="alert" style="color: red;">' . $_SESSION['errors']['username'] . '</p>';
                  }
                  ?>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label d-flex justify-content-start align-items-start" for="birthdate">Data de Nascimento</label>
                  <input id="birthdate" class="form-control " type="date" name="birthdate" value="<?= isset($_REQUEST['birthdate']) ? $_REQUEST['birthdate'] : null ?>" required />
                  <?php
                  if (isset($_SESSION['errors']['birthdate'])) {
                    echo '<p class="alert" style="color: red;">' . $_SESSION['errors']['birthdate'] . '</p>';
                  }
                  ?>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6 mb-3">
                  <label class="form-label d-flex justify-content-start align-items-start" for="email">Email</label>
                  <input id="email" class="form-control " type="email" name="email" value="<?= isset($_REQUEST['email']) ? $_REQUEST['email'] : null ?>" required />
                  <?php
                  if (isset($_SESSION['errors']['email'])) {
                    echo '<p class="alert" style="color: red;">' . $_SESSION['errors']['email'] . '</p>';
                  }
                  ?>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label d-flex justify-content-start align-items-start">Roles</label>
                  <select class="form-select" aria-label="Default select example" name="role_id" required style="color: black;">
                    <?php
                    foreach ($roles as $role) {
                      echo "<option value='{$role['id']}'>{$role['roleName']}</option>";
                    }
                    ?>
                  </select>
                </div>

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

              <button class="btn btn-outline-success btn-lg px-4 mt-3" type="submit" name="user" value="create">Registar</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal de confirmação de delete -->
    <?php foreach ($users as $user) : ?>
      <div class="modal fade" id="deleteModal<?= $user['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $user['id']; ?>" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="deleteModalLabel<?= $user['id']; ?>">Eliminar utilizador</h5>
            </div>
            <div class="modal-body">
              <p class="card-title">
                Tem certeza de que deseja eliminar o utilizador <?= $user['username']; ?>?
              </p>
              <br>
              <p>Não poderá recuperar a mesma posteriormente.</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <form action="/StreamSync/src/controllers/admin/user.php" method="post">
                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                <input type="hidden" name="user" value="delete">
                <button type="submit" class="btn btn-danger">Sim, eliminar utilizador</button>
              </form>

            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>


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