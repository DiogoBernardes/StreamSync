<?php
require_once __DIR__ . '/../../repositories/userRepository.php';
require_once __DIR__ . '/../../validations/app/validate-login-password.php';
require_once __DIR__ . '/../../validations/session.php';
if (isset($_POST['user'])) {
    if ($_POST['user'] == 'login') {
        login($_POST);
    }

    if ($_POST['user'] == 'logout') {
        logout();
    }
}

function login($req)
{
    $data = isLoginValid($req);
    $valido = checkErrors($data, $req);

    if ($valido) {
        $data = isPasswordValid($data);
    }

    $user = checkErrors($data, $req);

    if ($user) {
        doLogin($data);
    }
}

function checkErrors($data, $req)
{
    if (isset($data['invalid'])) {
        $_SESSION['errors'] = $data['invalid'];
        $params = '?' . http_build_query($req);
        header('location: /StreamSync/src/views/public/login.php' . $params);
        return false;
    }

    unset($_SESSION['errors']);
    return true;
}

function isAdmin($userID)
{
    $user = getById($userID);
    return $user['role_id'] == 1 ? true : false;
}

function doLogin($data)
{
    $_SESSION['id'] = $data['id'];
    $_SESSION['name'] = $data['first_name'];

    setcookie("id", $data['id'], time() + (60 * 60 * 24 * 30), "/");
    setcookie("name", $data['first_name'], time() + (60 * 60 * 24 * 30), "/");

    if (isAdmin($data['id'])) {
        $home_url = 'http://' . $_SERVER['HTTP_HOST'] . '/StreamSync/src/views/secure/admin/index.php';
        header('Location: ' . $home_url);
    } else {
        $home_url = 'http://' . $_SERVER['HTTP_HOST'] . '/StreamSync/src/views/secure/user/Dashboard.php';
        header('Location: ' . $home_url);
    }
}

function logout()
{
    if (isset($_SESSION['id'])) {

        $_SESSION = array();

        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600);
        }
        session_destroy();
    }

    setcookie('id', '', time() - 3600, "/");
    setcookie('first_name', '', time() - 3600, "/");

    $home_url = 'http://' . $_SERVER['HTTP_HOST'] . '/StreamSync';
    header('Location: ' . $home_url);
}
