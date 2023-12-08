<?php

require_once __DIR__ . '/../../repositories/userRepository.php';
require_once __DIR__ . '/../../validations/admin/validate-user.php';
require_once __DIR__ . '/../../validations/admin/validate-password.php';
require_once __DIR__ . '/../../validations/session.php';

if (isset($_POST['user'])) {
    if ($_POST['user'] == 'create') {
        create($_POST);
    }

    if ($_POST['user'] == 'update') {
        update($_POST);
    }

    if ($_POST['user'] == 'profile') {
        updateProfile($_POST);
    }

    if ($_POST['user'] == 'password') {
        changePassword($_POST);
    }
}

if (isset($_GET['user'])) {
    if ($_GET['user'] == 'update') {
        $user = getById($_GET['id']);
        $user['action'] = 'update';
        $params = '?' . http_build_query($user);
        header('location: /StreamSync/src/views/secure/admin/user.php' . $params);
    }

    if ($_GET['user'] == 'delete') {
        $user = getById($_GET['id']);
        if ($user['administrator']) {
            $_SESSION['errors'] = ['This user cannot be deleted!'];
            header('location: /StreamSync/src/views/secure/admin/');
            return false;
        }

        $success = delete_user($user);

        if ($success) {
            $_SESSION['success'] = 'User deleted successfully!';
            header('location: /StreamSync/src/views/secure/admin/');
        }
    }
}

function create($req)
{
    $data = validatedUser($req);

    if (isset($data['invalid'])) {
        $_SESSION['errors'] = $data['invalid'];
        $params = '?' . http_build_query($req);
        header('location: /StreamSync/src/views/secure/admin/user.php' . $params);
        return false;
    }

    $success = createUser($data);

    if ($success) {
        $_SESSION['success'] = 'User created successfully!';
        header('location: /StreamSync/src/views/secure/admin/');
    }
}

function update($req)
{
    $data = validatedUser($req);

    if (isset($data['invalid'])) {
        $_SESSION['errors'] = $data['invalid'];
        $_SESSION['action'] = 'update';
        $params = '?' . http_build_query($req);
        header('location: /StreamSync/src/views/secure/admin/user.php' . $params);

        return false;
    }

    $success = updateUser($data);

    if ($success) {
        $_SESSION['success'] = 'User successfully changed!';
        $data['action'] = 'update';
        $params = '?' . http_build_query($data);
        header('location: /StreamSync/src/views/secure/admin/user.php' . $params);
    }
}

function updateProfile($req)
{    
    $data = validatedUser($req);

    if (isset($data['invalid'])) {
        $_SESSION['errors'] = $data['invalid'];
        $params = '?' . http_build_query($req);
        header('location: /StreamSync/src/views/secure/user/Dashboard.php' . $params);
    } else {
        $user = user();
        $data['id'] = $user['id'];
        $data['administrator'] = $user['administrator'];

        $success = updateUser($data);

        if ($success) {
            $_SESSION['success'] = 'User successfully changed!';
            $_SESSION['action'] = 'update';
            $params = '?' . http_build_query($data);
            header('location: /StreamSync/src/views/secure/user/Dashboard.php' . $params);
        }
    }
}

function changePassword($req) 
{
    $validationResult = validatePasswordChange($req);
    if (isset($validationResult['invalid'])) {
        $_SESSION['errors'] = $validationResult['invalid'];
        header('location: /StreamSync/src/views/secure/user/Dashboard.php');
        exit;
    } else {
        $req['id'] = userId();
        $success = updatePassword($req);
        if ($success) {
            $_SESSION['success'] = 'Password successfully changed!';
            header('location: /StreamSync/src/views/secure/user/Dashboard.php');
        } else {
            $_SESSION['errors'] = ['Failed to update password.'];
            header('location: /StreamSync/src/views/secure/user/Dashboard.php');
        }
        exit;
    }
}

function delete_user($user)
{
    $data = deleteUser($user['id']);
    return $data;
}
