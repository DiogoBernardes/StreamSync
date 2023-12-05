<?php

function isSignUpValid($req)
{
    foreach ($req as $key => $value) {
        $req[$key] =  trim($req[$key]);
    }

    $errors = [];

    if (empty($req['first_name'])) {
        $errors['first_name'] = 'O campo não pode estar vazio.';
    } elseif (strlen($req['first_name']) < 3 || strlen($req['first_name']) > 255) {
        $errors['first_name'] = 'O campo deve ter entre 3 e 255 caracteres.';
    } elseif (!preg_match('/^[A-Za-zÀ-ÖØ-öø-ÿ\s]+$/', $req['first_name'])) {
        $errors['first_name'] = 'Apenas letras e espaços são permitidos.';
    }


    if (empty($req['last_name'])) {
        $errors['last_name'] = 'O campo não pode estar vazio.';
    } elseif (strlen($req['last_name']) < 3 || strlen($req['last_name']) > 255) {
        $errors['last_name'] = 'O campo deve ter entre 3 e 255 caracteres.';
    } elseif (!preg_match('/^[A-Za-zÀ-ÖØ-öø-ÿ\s]+$/', $req['last_name'])) {
        $errors['last_name'] = 'Apenas letras e espaços são permitidos.';
    }

    if (empty($req['username'])) {
        $errors['username'] = 'O campo não pode estar vazio.';
    } elseif (strlen($req['username']) < 3 || strlen($req['username']) > 255) {
        $errors['username'] = 'O campo deve ter entre 3 e 255 caracteres.';
    } elseif (!preg_match('/^[A-Za-z0-9_]+$/', $req['username'])) {
        $errors['username'] = 'Apenas letras, números e underscores são permitidos.';
    }

    if (empty($req['birthdate'])) {
        $errors['birthdate'] = 'O campo não pode estar vazio.';
    } else {
        $currentTimestamp = strtotime('now');
        $birthdateTimestamp = strtotime($req['birthdate']);

        if ($birthdateTimestamp > $currentTimestamp) {
            $errors['birthdate'] = 'A data de nascimento não pode ser no futuro.';
        }
    }

    if (empty($req['email'])) {
        $errors['email'] = 'O campo não pode estar vazio.';
    } elseif (!filter_var($req['email'], FILTER_VALIDATE_EMAIL) || !preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $req['email'])) {
        $errors['email'] = 'O email deve ser válido. (name@example.com)';
    } 
    
    if (getByEmail($req['email'])) {
        $errors['email'] = 'Email já registado no sistema.';
    }

    if (empty($req['password'])) {
        $errors['password'] = 'O campo não pode estar vazio.';
    } elseif (strlen($req['password']) < 8) {
        $errors['password'] = 'O campo deve ter pelo menos 8 caracteres.';
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $req['password'])) {
        $errors['password'] = 'Deve incluir pelo menos uma letra maiúscula, uma letra minúscula, um número e um caractere especial.';
    }

    if ($req['password_confirmation'] !== $req['password']) {
        $errors['password_confirmation'] = 'As passwords não coincidem.';
    }

    if (!empty($errors)) {
        return ['invalid' => $errors];
    }

    return $req;
}
?>
