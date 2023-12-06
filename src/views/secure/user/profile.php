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

<div class="p-5 mb-2 bg-dark text-white">
  <h1>User</h1>
</div>
<main>
  <section class="py-4">
    <div class="d-flex justify-content">
      <a href="/StreamSync/src/views/secure/user/Dashboard.php"><button type="button" class="btn btn-secondary px-5 me-2">Back</button></a>
      <a href="./password.php"><button class="btn btn-warning px-2 me-2">Change Password</button></a>
    </div>
  </section>
  <section>
    <?php
    if (isset($_SESSION['success'])) {
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
      echo $_SESSION['success'] . '<br>';
      echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
      unset($_SESSION['success']);
    }
    if (isset($_SESSION['errors'])) {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
      foreach ($_SESSION['errors'] as $error) {
        echo $error . '<br>';
      }
      echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
      unset($_SESSION['errors']);
    }
    ?>
  </section>
  <section>
    <form enctype="multipart/form-data" action="/StreamSync/src/controllers/admin/user.php" method="post"
      class="form-control py-3">
      <div class="input-group mb-3">
        <span class="input-group-text">Primeiro Nome</span>
        <input type="text" class="form-control" name="first_name" placeholder="First Name" maxlength="100" size="100"
          value="<?= isset($_REQUEST['first_name']) ? $_REQUEST['first_name'] : $user['first_name'] ?>" required>
      </div>
      <div class="input-group mb-3">
        <span class="input-group-text">Último Nome</span>
        <input type="text" class="form-control" name="last_name" placeholder="Last Name" maxlength="100" size="100"
          value="<?= isset($_REQUEST['last_name']) ? $_REQUEST['last_name'] : $user['last_name'] ?>" required>
      </div>
      <div class="row mt-3">
        <div class="col-md-6 input-group mb-3 w-50">
          <span class="input-group-text">Username</span>
          <input type="text" class="form-control" name="username" placeholder="Username" maxlength="100" size="100"
            value="<?= isset($_REQUEST['username']) ? $_REQUEST['username'] : $user['username'] ?>" required>
        </div>
        <div class="col-md-6 input-group mb-3 w-50">
          <span class="input-group-text">Data de Nascimento</span>
          <input type="date" class="form-control" name="birthdate" 
            value="<?= isset($_REQUEST['birthdate']) ? $_REQUEST['birthdate'] : $user['birthdate'] ?>" required>
        </div>
      </div>
      <div class="input-group mb-3">
        <span class="input-group-text">email</span>
        <input type="email" class="form-control" name="email" maxlength="255"
          value="<?= isset($_REQUEST['email']) ? $_REQUEST['email'] : $user['email'] ?>" required>
      </div>
      <div class="input-group mb-3">
        <label class="input-group-text" for="inputGroupFile01">Picture</label>
        <input accept="image/*" type="file" class="form-control" id="inputGroupFile01" name="avatar" />
      </div>
      <div class="d-grid col-4 mx-auto">
        <button class="w-100 btn btn-lg btn-success mb-2" type="submit" name="user" value="profile">Change</button>
      </div>
    </form>
  </section>
</main>
<?php
include_once __DIR__ . '../../../../templates/footer.php';
?>