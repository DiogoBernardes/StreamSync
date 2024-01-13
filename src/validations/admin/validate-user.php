<?php

function validatedUser($req)
{
    foreach ($req as $key => $value) {
        $req[$key] =  trim($req[$key]);
    }

    if (empty($req['first_name']) || strlen($req['first_name']) < 3 || strlen($req['first_name']) > 255) {
        $errors['name'] = 'The Name field cannot be empty and must be between 3 and 255 characters';
    }

    if (empty($req['last_name']) || strlen($req['last_name']) < 3 || strlen($req['last_name']) > 255) {
        $errors['lastname'] = 'The Last Name field cannot be empty and must be between 3 and 255 characters';
    }


    if (!filter_var($req['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'The Email field cannot be empty and must have the email format, for example: nome@example.com.';
    }

    $req['administrator'] = !empty($req['administrator']) == 'on' ? true : false;

    if (isset($errors)) {
        return ['invalid' => $errors];
    }
    return $req;
}
