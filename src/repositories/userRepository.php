<?php
require_once __DIR__ . '/../infrastructure/db/connection.php';

function createUser($user)
{
    // Role Utilizador por default
    $user['role_id'] = isset($user['role_id']) ? $user['role_id'] : 2;

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
    $PDOStatement = $GLOBALS['pdo']->prepare('SELECT * FROM users WHERE id = ? AND deleted_at IS NULL;');
    $PDOStatement->bindValue(1, $id, PDO::PARAM_INT);
    $PDOStatement->execute();
    return $PDOStatement->fetch();
}

function getByEmail($email)
{
    $PDOStatement = $GLOBALS['pdo']->prepare('SELECT * FROM users WHERE email = ? AND deleted_at IS NULL LIMIT 1;');
    $PDOStatement->bindValue(1, $email);
    $PDOStatement->execute();
    return $PDOStatement->fetch();
}

function getAll()
{
    $PDOStatement = $GLOBALS['pdo']->query('SELECT * FROM users WHERE deleted_at IS NULL;');
    $users = [];
    while ($listOfusers = $PDOStatement->fetch()) {
        $users[] = $listOfusers;
    }
    return $users;
}

function updateUser($user)
{
    // Role Utilizador por default
    $user['role_id'] = 2;

    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $user['avatar'] = uploadAvatar($_FILES['avatar']);
    } else {
        $existingUser = getById($user['id']);
        $user['avatar'] = $existingUser['avatar'];
    }

    if (isset($user['password']) && !empty($user['password'])) {
        $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);

        $sqlUpdate = "UPDATE  
        users SET
            first_name = :first_name, 
            last_name = :last_name, 
            birthdate = :birthdate, 
            email = :email,
            username = :username, 
            avatar = :avatar, 
            role_id = :role_id
        WHERE id = :id AND deleted_at IS NULL;";
    } else {
        $sqlUpdate = "UPDATE  
        users SET
            first_name = :first_name, 
            last_name = :last_name, 
            birthdate = :birthdate, 
            email = :email,
            username = :username, 
            avatar = :avatar,
            role_id = :role_id
        WHERE id = :id AND deleted_at IS NULL;";
    }

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

function updatePassword($req)
{
    $hashedPassword = password_hash($req['password'], PASSWORD_DEFAULT);

    $sqlUpdate = "UPDATE users SET password = :password WHERE id = :id AND deleted_at IS NULL;";
    $PDOStatement = $GLOBALS['pdo']->prepare($sqlUpdate);

    return $PDOStatement->execute([
        ':id' => $req['id'],
        ':password' => $hashedPassword
    ]);
}

function softDeleteUser($id)
{
    $sqlSoftDelete = "UPDATE users SET deleted_at = CURRENT_TIMESTAMP WHERE id = :id AND deleted_at IS NULL;";
    $PDOStatement = $GLOBALS['pdo']->prepare($sqlSoftDelete);

    return $PDOStatement->execute([
        ':id' => $id,
    ]);
}

function uploadAvatar($file)
{
    $allowTypes = array('jpg', 'png', 'jpeg');
    $statusMsg = '';

    if ($file && $file['error'] === UPLOAD_ERR_OK) {
        $fileName = basename($file["name"]);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

        if (in_array($fileType, $allowTypes)) {
            $imgContent = file_get_contents($file["tmp_name"]);

            if ($imgContent) {
                $statusMsg = 'Ficheiro carregado com sucesso!';

                return $imgContent;
            } else {
                $statusMsg = 'Erro ao tentar ler o ficheiro!';
            }
        } else {
            $statusMsg = 'Desculpe, apenas são suportados ficheiros JPG, JPEG, PNG.';
        }
    }
    throw new Exception($statusMsg);
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
function getUsersCountByMonth()
{
    $sql = "SELECT MONTH(created_at) AS month, COUNT(*) AS user_count FROM users GROUP BY month";

    $stmt = $GLOBALS['pdo']->query($sql);
    $result = array_fill(1, 12, 0);

    while ($row = $stmt->fetch()) {
        $result[$row['month']] = $row['user_count'];
    }

    return array_values($result);
}

function getDeletedUsersCountByMonth()
{
    $sql = "SELECT MONTH(deleted_at) AS month, COUNT(*) AS user_count FROM users GROUP BY month";

    $stmt = $GLOBALS['pdo']->query($sql);

    $result = array_fill(1, 12, 0);

    while ($row = $stmt->fetch()) {
        $result[$row['month']] = $row['user_count'];
    }

    return array_values($result);
}


function calculateAverageAge()
{
    $sql = "SELECT AVG(YEAR(CURDATE()) - YEAR(birthdate)) AS average_age FROM users WHERE deleted_at IS NULL;";
    $stmt = $GLOBALS['pdo']->query($sql);
    $result = $stmt->fetch();

    return $result['average_age'];
}

function getAllRoles()
{
    $PDOStatement = $GLOBALS['pdo']->query('SELECT * FROM roles;');
    $role = [];
    while ($listOfRoles = $PDOStatement->fetch()) {
        $role[] = $listOfRoles;
    }
    return $role;
}
