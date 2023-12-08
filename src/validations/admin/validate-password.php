<?php
function validatePasswordChange($req) {
    $errors = [];

    if (!empty($req['password'])) {
        if (strlen($req['password']) < 8) {
            $errors['password'] = 'O campo deve ter pelo menos 8 caracteres.';
        } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $req['password'])) {
            $errors['password'] = 'Deve incluir pelo menos uma letra maiúscula, uma letra minúscula, um número e um caractere especial.';
        }

        if ($req['confirm_password'] !== $req['password']) {
            $errors['confirm_password'] = 'As passwords não coincidem.';
        }
    } else {
        $errors['password'] = 'O campo de senha é obrigatório.';
    }

    if (!empty($errors)) {
        return ['invalid' => $errors];
    }
    return $req;
}
?>
