<?php
$title = 'Login | StreamSync';
require_once __DIR__ . '/../../infrastructure/middlewares/middleware-not-authenticated.php';
require_once __DIR__ . '/../../templates/header.php'; 
?>

  <div class="min-h-screen d-flex flex-column justify-content-center items-center pt-6 sm:pt-0 bg-gray-100">
    <section class="bg-image bg-cover bg-p-center bg-no-repeat vh-100 position-relative">
      <div class="container py-3 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="card bg-dark text-white rounded-4 bg-opacity-75">
              <div class="card-body p-3 text-center">

                <div class="mb-md-3 mt-md-2 pb-3">
                  <a href="/StreamSync/">
                    <img src="../../assets/images/logo.png" alt="StreamSync Logo" class="img-fluid">
                  </a>

                  <form action="/StreamSync/src/controllers/auth/login.php" method="post" class="p-4">
                    <div class="form-group mb-3 mt-3">
                      <label for="Email"
                        class="form-label d-flex justify-content-start align-items-start">Email</label>
                      <input type="email" class="form-control" id="Email" placeholder="Email" name="email" maxlength="255"/>
                    </div>

                    <div class="form-group mb-3">
                      <label for="password"
                        class="form-label d-flex justify-content-start align-items-start">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Password" name="password" maxlength="255" />
                    </div>
                    <div class="block mt-3 d-flex justify-content-start align-items-start"> 
                      <div class="form-check mb-3">
                        <input id="remember_me" type="checkbox" class="form-check-input" value="remember_me" name="remember">
                        <label for="remember_me" class="form-check-label">Remember me</label>
                      </div>
                    </div>  
                    <?php
                      if (isset($_SESSION['errors']) && is_array($_SESSION['errors'])) {
                        foreach ($_SESSION['errors'] as $error) {
                          echo '<p class="alert" style="color: red;">' . $error . '</p>';
                        }
                        unset($_SESSION['errors']);  
                      }
                    ?>    
                    <button class="btn btn-outline-light btn-lg px-4 mt-3" type="submit" name="user" value="login">Login</button>
                    <div class="d-flex justify-content-center text-center mt-4 pt-1">
                      <a href="https://github.com/DiogoBernardes/Movies-and-or-Series-Management" class="text-white transition"><i
                          class="bi bi-github bi-4x"></i></a>
                      <a href="https://www.instagram.com/streamsync_/" class="text-white mx-4 px-2 transition"><i
                          class="bi bi-instagram"></i></a>
                      <a href="https://twitter.com/SSync27157" class="text-white transition"><i class="bi bi-twitter"></i></a>
                    </div>

                    <div class="mt-2">
                      <p>Ainda não tem conta?<a href="/StreamSync/src/views/public/register.php"
                          class="text-white-50 fw-bold ms-2">Registe-se agora!</a></p>
                    </div>

                  </form>
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
 