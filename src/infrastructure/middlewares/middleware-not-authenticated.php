<?php

require_once __DIR__ . '/../../validations/session.php';

if (isset($_SESSION['id']) || isset($_COOKIE['id'])) {
    if (administrator()) {
        $admin_home_url = 'http://' . $_SERVER['HTTP_HOST'] . '/StreamSync/src/views/secure/admin/index.php';
        header('Location: ' . $admin_home_url);
    } else {
        $user_home_url = 'http://' . $_SERVER['HTTP_HOST'] . '/StreamSync/src/views/secure/user/Dashboard.php';
        header('Location: ' . $user_home_url);
    }
}
