<?php
session_start();

require_once __DIR__ . '/../../repositories/userRepository.php';
require_once __DIR__ . '/../../validations/app/validate-sign-up.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['user']) && $_POST['user'] === 'signUp') {
        signUp($_POST);
    }
}

function signUp($requestData)
{
    $data = isSignUpValid($requestData);

    if (isset($data['invalid'])) {
        $_SESSION['errors'] = $data['invalid'];
        $params = '?' . http_build_query($requestData);
        header('location: /StreamSync/src/views/public/register.php' . $params);
        exit();
    }

    $user = createNewUser($data);

    if ($user) {
        $_SESSION['id'] = $user['id'];
        $_SESSION['name'] = $user['first_name'];

        setcookie("id", $user['id'], time() + (60 * 60 * 24 * 30), "/");
        setcookie("name", $user['first_name'], time() + (60 * 60 * 24 * 30), "/");
        header('location: /StreamSync/src/views/public/login.php');
        exit();
    }

    // Tratar o caso em que a criação do usuário falha
    $_SESSION['errors'][] = 'Erro ao criar o usuário.';
    header('location: /StreamSync/src/views/public/register.php');
    exit();
}
