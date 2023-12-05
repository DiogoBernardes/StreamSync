<?php
require_once __DIR__ . '/../infrastructure/db/connection.php';

function createUser($user)
{
    //Role Utilizador por default
    $user['role_id'] = 2;

    $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
    $sqlCreate = "INSERT INTO 
    users (
        first_name, 
        last_name, 
        birthdate, 
        email, 
        password,
        username,
        avatar, 
        role_id) 
    VALUES (
        :first_name, 
        :last_name, 
        :birthdate, 
        :email, 
        :password,
        :username,
        :avatar, 
        :role_id
    )";

    $PDOStatement = $GLOBALS['pdo']->prepare($sqlCreate);

    $success = $PDOStatement->execute([
        ':first_name' => $user['first_name'],
        ':last_name' => $user['last_name'],
        ':birthdate' => $user['birthdate'],
        ':email' => $user['email'],
        ':password' => $user['password'],
        ':username' => $user['username'],
        ':avatar' => $user['avatar'],
        ':role_id' => $user['role_id'],
    ]);

    if ($success) {
        $user['id'] = $GLOBALS['pdo']->lastInsertId();
    }
    return $success;
}

function getById($id)
{
    $PDOStatement = $GLOBALS['pdo']->prepare('SELECT * FROM users WHERE id = ?;');
    $PDOStatement->bindValue(1, $id, PDO::PARAM_INT);
    $PDOStatement->execute();
    return $PDOStatement->fetch();
}

function getByEmail($email)
{
    $PDOStatement = $GLOBALS['pdo']->prepare('SELECT * FROM users WHERE email = ? LIMIT 1;');
    $PDOStatement->bindValue(1, $email);
    $PDOStatement->execute();
    return $PDOStatement->fetch();
}


function getAll()
{
    $PDOStatement = $GLOBALS['pdo']->query('SELECT * FROM users;');
    $users = [];
    while ($listOfusers = $PDOStatement->fetch()) {
        $users[] = $listOfusers;
    }
    return $users;
}

function getAvatarById($id)
{
    $PDOStatement = $GLOBALS['pdo']->prepare('SELECT avatar FROM users WHERE id = ?;');
    $PDOStatement->bindValue(1, $id, PDO::PARAM_INT);
    $PDOStatement->execute();
    $result = $PDOStatement->fetchColumn();

    // Se o resultado for vazio, retorne um avatar padrão
    return $result;
}


function updateUser($user)
{
    if (isset($user['password']) && !empty($user['password'])) {
        $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);

        $sqlUpdate = "UPDATE  
        users SET
            first_name = :first_name, 
            last_name = :last_name, 
            birthdate = :birthdate, 
            email = :email,
            password = :password,
            username = :username, 
            avatar = :avatar, 
            role_id = :role_id
        WHERE id = :id;";

        $PDOStatement = $GLOBALS['pdo']->prepare($sqlUpdate);

        return $PDOStatement->execute([
            ':id' => $user['id'],
            ':first_name' => $user['first_name'],
            ':last_name' => $user['last_name'],
            ':birthdate' => $user['birthdate'],
            ':email' => $user['email'],
            ':password' => $user['password'],
            ':username' => $user['username'],
            ':avatar' => $user['avatar'],
            ':role_id' => $user['role_id']
        ]);
    }

    $sqlUpdate = "UPDATE  
    users SET
        first_name = :first_name, 
        last_name = :last_name, 
        birthdate = :birthdate, 
        email = :email,
        username = :username, 
        avatar = :avatar,
        role_id = :role_id
    WHERE id = :id;";

    $PDOStatement = $GLOBALS['pdo']->prepare($sqlUpdate);

    return $PDOStatement->execute([
        ':id' => $user['id'],
        ':first_name' => $user['first_name'],
        ':last_name' => $user['last_name'],
        ':birthdate' => $user['birthdate'],
        ':email' => $user['email'],
        ':username' => $user['username'],
        ':avatar' => $user['avatar'],
        ':role_id' => $user['role_id']
    ]);
}

function updatePassword($user)
{
    if (isset($user['password']) && !empty($user['password'])) {
        $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);

        $sqlUpdate = "UPDATE  
        users SET
            first_name = :first_name, 
            password = :password
        WHERE id = :id;";

        $PDOStatement = $GLOBALS['pdo']->prepare($sqlUpdate);

        return $PDOStatement->execute([
            ':id' => $user['id'],
            ':first_name' => $user['first_name'],
            ':password' => $user['password']
        ]);
    }
}

function deleteUser($id)
{
    $PDOStatement = $GLOBALS['pdo']->prepare('DELETE FROM users WHERE id = ?;');
    $PDOStatement->bindValue(1, $id, PDO::PARAM_INT);
    return $PDOStatement->execute();
}

function createNewUser($user)
{  
     $user['role_id'] = 2;

    $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
    $sqlCreate = "INSERT INTO 
    users (
        first_name, 
        last_name, 
        birthdate, 
        email, 
        password,
        username,
        avatar, 
        role_id) 
    VALUES (
        :first_name, 
        :last_name, 
        :birthdate, 
        :email, 
        :password,
        :username,
        :avatar, 
        :role_id
    )";

    $PDOStatement = $GLOBALS['pdo']->prepare($sqlCreate);

    $success = $PDOStatement->execute([
        ':first_name' => $user['first_name'],
        ':last_name' => $user['last_name'],
        ':birthdate' => $user['birthdate'],
        ':email' => $user['email'],
        ':password' => $user['password'],
        ':username' => $user['username'],
        ':avatar' => $user['avatar'],
        ':role_id' => $user['role_id'],
    ]);

    if ($success) {
        $user['id'] = $GLOBALS['pdo']->lastInsertId();
    }
    return $success;
}

