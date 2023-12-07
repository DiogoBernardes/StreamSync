<?php
$title = 'Perfil';
require_once __DIR__ . '../../../../infrastructure/middlewares/middleware-user.php';
include_once __DIR__ . '../../../../templates/header.php';
@require_once __DIR__ . '/../../../validations/session.php';
$user = user();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user']) && $_POST['user'] === 'profile') {
  $_REQUEST['avatar'] = $_FILES['avatar'] ?? null;
}
?>

<div class="container mt-5">
  <div class="row gutters">

    <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
      <div class="card h-100">
        <div class="card-body">
          <form enctype="multipart/form-data" action="/StreamSync/src/controllers/admin/user.php" method="post" class="form-control py-3 border-0">
            <div class="account-settings mt-5">
              <div class="user-profile">
                <div class="d-flex justify-content-center">
                  <?php if ($user['avatar'] !== null) : ?>
                    <img src="data:image/png;base64,<?= base64_encode($user['avatar']) ?>" alt="User Avatar" class="rounded-circle w-50 h-50">
                  <?php else : ?>
                    <img src="https://cdn3.iconfinder.com/data/icons/network-communication-vol-3-1/48/111-512.png" alt="Default Avatar" class="rounded-circle  w-50 h-50">
                  <?php endif; ?>
                </div>
                <div class="text-center mt-3">
                  <h5 class="user-name"><?= $user['first_name'] ?? null ?> <?= $user['last_name'] ?? null ?></h5>
                  <h6 class="user-email"><?= $user['email'] ?? null ?></h6>
                </div>
                <div class="card-body media align-items-center">

                  <div class="media-body ml-4">
                    <label class="btn btn-outline-primary d-flex justify-content-center">
                      Upload new photo
                      <input id="avatarInput" accept="image/*" type="file" class="form-control position-absolute invisible" name="avatar" />
                    </label>
                    <label class="text-muted small d-flex justify-content-center">Allowed JPG, PNG or JPEG</label>
                  </div>
                </div>
              </div>

            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
      <div class="card h-100">
        <div class="card-body">
          <div class="row gutters">
            <form enctype="multipart/form-data" action="/StreamSync/src/controllers/admin/user.php" method="post" class="form-control py-3 border-0">
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <h6 class="mb-2 text-primary">Dados Pessoais</h6>
              </div>
              <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                    <label for="fullName">Primeiro Nome</label>
                    <input type="text" class="form-control" name="first_name" placeholder="First Name" maxlength="100" size="100" value="<?= isset($_REQUEST['first_name']) ? $_REQUEST['first_name'] : $user['first_name'] ?>" required>
                  </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                    <label for="fullName">Ultimo Nome</label>
                    <input type="text" class="form-control" name="last_name" placeholder="Last Name" maxlength="100" size="100" value="<?= isset($_REQUEST['last_name']) ? $_REQUEST['last_name'] : $user['last_name'] ?>" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                    <label for="eMail">Email</label>
                    <input type="email" class="form-control" name="email" maxlength="255" value="<?= isset($_REQUEST['email']) ? $_REQUEST['email'] : $user['email'] ?>" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                    <label for="phone">Username</label>
                    <input type="text" class="form-control" name="username" placeholder="Username" maxlength="100" size="100" value="<?= isset($_REQUEST['username']) ? $_REQUEST['username'] : $user['username'] ?>" required>
                  </div>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                    <label for="website">Data de Nascimento</label>
                    <input type="date" class="form-control" name="birthdate" value="<?= isset($_REQUEST['birthdate']) ? $_REQUEST['birthdate'] : $user['birthdate'] ?>" required>
                  </div>
                </div>

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-4 d-flex justify-content-end">
                  <div class="text-right">
                    <button type="submit" id="submit" name="user" value="profile" class="btn btn-primary">Update</button>
                  </div>
                </div>
              </div>
            </form>


            <div class="row gutters">
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <h6 class="mt-3 mb-2 text-primary">Alterar Password</h6>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="form-group">
                  <label for="Street">Password</label>
                  <input type="name" class="form-control" id="Street" placeholder="Password">
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="form-group">
                  <label for="ciTy">Confirmar Password</label>
                  <input type="name" class="form-control" id="ciTy" placeholder="Confirmar Password">
                </div>
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-4 d-flex justify-content-end">
                <div class="text-right">
                  <button type="button" id="submit" name="submit" class="btn btn-primary">Update</button>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>