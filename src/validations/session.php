<?php
session_start();
require_once __DIR__ . '/../repositories/userRepository.php';

function isAuthenticated()
{
    return isset($_SESSION['id']) ? true : false;
}

function user()
{
    if (isAuthenticated()) {
        return getById($_SESSION['id']);
    } else {
        return false;
    }
}

function userId()
{
    return  $_SESSION['id'];
}

function administrator()
{
    $user = user();
    return $user['role_id'] == 1 ? true : false;
}
