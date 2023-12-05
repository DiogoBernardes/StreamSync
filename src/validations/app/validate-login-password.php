<?php

function isLoginValid($req)
{
    foreach ($req as $key => $value) {
        $req[$key] =  trim($req[$key]);
    }

    if (!filter_var($req['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'O email deve ser válido. (name@example.com)';
    }

    if (empty($req['password']) || strlen($req['password']) < 8) {
        $errors['password'] = 'A password deve ter pelo menos 8 caracteres.';
    }

    if (isset($errors)) {
        return ['invalid' => $errors];
    }

    return $req;
}

function isPasswordValid($req)
{
    if (!isset($_SESSION['id'])) {

        $user = getByEmail($req['email']);

        if (!$user || !password_verify($req['password'], $user['password'])) {
            $errors['email'] = 'Email ou Password incorretos!';
        }

        if (isset($errors)) {
            return ['invalid' => $errors];
        }

        return $user;
    }
}
