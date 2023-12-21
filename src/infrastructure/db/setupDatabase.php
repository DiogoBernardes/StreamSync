<?php

# connection.php
$host = "localhost";
$user = "root";
$pass = '';

try {
  $pdo = new PDO("mysql:host=$host", $user, $pass);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Error: " . $e->getMessage());
}

# Criar o banco de dados
try {
  $pdo->exec("CREATE DATABASE IF NOT EXISTS StreamSync");
} catch (PDOException $e) {
  die("Error creating database: " . $e->getMessage());
}

# Selecionar o banco de dados recém-criado
$pdo->exec("USE StreamSync");

try {
  # CREATE TABLES
  $pdo->exec('
        CREATE TABLE IF NOT EXISTS roles (
            id INT NOT NULL AUTO_INCREMENT,
            roleName VARCHAR(50),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        );

        CREATE TABLE IF NOT EXISTS users (
            id INT NOT NULL AUTO_INCREMENT,
            first_name VARCHAR(255) NOT NULL,
            last_name VARCHAR(255) NOT NULL,
            birthdate DATE NOT NULL,
            email VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL,
            username VARCHAR(255) NOT NULL,
            avatar LONGBLOB,
            role_id INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP NULL,
            PRIMARY KEY(id),
            FOREIGN KEY (role_id) REFERENCES roles(id)
        );

        CREATE TABLE IF NOT EXISTS category_type(
            id INT NOT NULL AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        );

        CREATE TABLE IF NOT EXISTS content_type(
            id INT NOT NULL AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        );

        CREATE TABLE IF NOT EXISTS content (
            id INT NOT NULL AUTO_INCREMENT,
            type_id INT NOT NULL,
            title VARCHAR(255) NOT NULL,
            release_date DATE NOT NULL,
            end_date DATE,
            number_seasons INT,
            duration INT,
            synopsis TEXT,
            category_id INT NOT NULL,
            poster LONGBLOB,
            trailer TEXT,
            watched_date DATE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY(id),
            FOREIGN KEY (type_id) REFERENCES content_type(id),
            FOREIGN KEY (category_id) REFERENCES category_type(id)
        );

        CREATE TABLE IF NOT EXISTS lists (
            id INT NOT NULL AUTO_INCREMENT,
            name VARCHAR(255),
            user_id INT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY(id),
            FOREIGN KEY (user_id) REFERENCES users(id)
        );

        CREATE TABLE IF NOT EXISTS listContent (
            id INT NOT NULL AUTO_INCREMENT,
            list_id INT NOT NULL,
            content_id INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY(id),
            FOREIGN KEY (list_id) REFERENCES lists(id),
            FOREIGN KEY (content_id) REFERENCES content(id)
        );

        CREATE TABLE IF NOT EXISTS reviews (
            id INT NOT NULL AUTO_INCREMENT,
            user_id INT NOT NULL,
            content_id INT NOT NULL,
            rating INT NOT NULL,
            comment TEXT NOT NULL,
            review_date TIMESTAMP NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            FOREIGN KEY (user_id) REFERENCES users(id),
            FOREIGN KEY (content_id) REFERENCES content(id)
        );

        CREATE TABLE IF NOT EXISTS shares (
            id INT NOT NULL AUTO_INCREMENT,
            share_date TIMESTAMP NOT NULL,
            origin_user_id INT NOT NULL,
            destination_user_id INT NOT NULL,
            list_id INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY(id),
            FOREIGN KEY (origin_user_id) REFERENCES users(id),
            FOREIGN KEY (destination_user_id) REFERENCES users(id),
            FOREIGN KEY (list_id) REFERENCES lists(id)
        );
    ');


  $pdo->exec('
        INSERT INTO roles (roleName) SELECT * FROM (SELECT "Administrador") AS tmp WHERE NOT EXISTS (SELECT roleName FROM roles WHERE roleName = "Administrador") LIMIT 1;
        INSERT INTO roles (roleName) SELECT * FROM (SELECT "Utilizador") AS tmp WHERE NOT EXISTS (SELECT roleName FROM roles WHERE roleName = "Utilizador") LIMIT 1;
  ');

  # Verificar se o usuário Admin já existe
  $stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE username = 'admin'");
  $adminExists = $stmt->fetchColumn() > 0;

  if (!$adminExists) {
      $adminPassword = 'admin123';  // Altere para a senha desejada
      $hashedAdminPassword = password_hash($adminPassword, PASSWORD_DEFAULT);

      $pdo->exec("INSERT INTO users (first_name, last_name, birthdate, email, password, username, role_id) VALUES ('Admin', 'Admin', '2023-12-05', 'admin@ipvc.pt', '$hashedAdminPassword', 'admin', 1)");
  }

  $pdo->exec('

        INSERT INTO content_type (name) SELECT * FROM (SELECT "Filmes") AS tmp WHERE NOT EXISTS (SELECT name FROM content_type WHERE name = "Filmes") LIMIT 1;
        INSERT INTO content_type (name) SELECT * FROM (SELECT "Séries") AS tmp WHERE NOT EXISTS (SELECT name FROM content_type WHERE name = "Séries") LIMIT 1;
        INSERT INTO content_type (name) SELECT * FROM (SELECT "Documentários") AS tmp WHERE NOT EXISTS (SELECT name FROM content_type WHERE name = "Documentários") LIMIT 1;
        INSERT INTO content_type (name) SELECT * FROM (SELECT "Talk Show") AS tmp WHERE NOT EXISTS (SELECT name FROM content_type WHERE name = "Talk Show") LIMIT 1;
        INSERT INTO content_type (name) SELECT * FROM (SELECT "Curta-Metragem") AS tmp WHERE NOT EXISTS (SELECT name FROM content_type WHERE name = "Curta-Metragem") LIMIT 1;

        INSERT INTO category_type (name) SELECT * FROM (SELECT "Comédia") AS tmp WHERE NOT EXISTS (SELECT name FROM category_type WHERE name = "Comédia") LIMIT 1;
        INSERT INTO category_type (name) SELECT * FROM (SELECT "Policial") AS tmp WHERE NOT EXISTS (SELECT name FROM category_type WHERE name = "Policial") LIMIT 1;
        INSERT INTO category_type (name) SELECT * FROM (SELECT "Guerra") AS tmp WHERE NOT EXISTS (SELECT name FROM category_type WHERE name = "Guerra") LIMIT 1;
        INSERT INTO category_type (name) SELECT * FROM (SELECT "Mistério") AS tmp WHERE NOT EXISTS (SELECT name FROM category_type WHERE name = "Mistério") LIMIT 1;
        INSERT INTO category_type (name) SELECT * FROM (SELECT "Familía") AS tmp WHERE NOT EXISTS (SELECT name FROM category_type WHERE name = "Familía") LIMIT 1;
        INSERT INTO category_type (name) SELECT * FROM (SELECT "Animação") AS tmp WHERE NOT EXISTS (SELECT name FROM category_type WHERE name = "Animação") LIMIT 1;
        INSERT INTO category_type (name) SELECT * FROM (SELECT "Ação") AS tmp WHERE NOT EXISTS (SELECT name FROM category_type WHERE name = "Ação") LIMIT 1;
        INSERT INTO category_type (name) SELECT * FROM (SELECT "Drama") AS tmp WHERE NOT EXISTS (SELECT name FROM category_type WHERE name = "Drama") LIMIT 1;
        INSERT INTO category_type (name) SELECT * FROM (SELECT "Aventura") AS tmp WHERE NOT EXISTS (SELECT name FROM category_type WHERE name = "Aventura") LIMIT 1;
        INSERT INTO category_type (name) SELECT * FROM (SELECT "Romance") AS tmp WHERE NOT EXISTS (SELECT name FROM category_type WHERE name = "Romance") LIMIT 1;
        INSERT INTO category_type (name) SELECT * FROM (SELECT "Terror") AS tmp WHERE NOT EXISTS (SELECT name FROM category_type WHERE name = "Terror") LIMIT 1;
        INSERT INTO category_type (name) SELECT * FROM (SELECT "Documentário") AS tmp WHERE NOT EXISTS (SELECT name FROM category_type WHERE name = "Documentário") LIMIT 1;
        INSERT INTO category_type (name) SELECT * FROM (SELECT "Suspense") AS tmp WHERE NOT EXISTS (SELECT name FROM category_type WHERE name = "Suspense") LIMIT 1;
        INSERT INTO category_type (name) SELECT * FROM (SELECT "Musical") AS tmp WHERE NOT EXISTS (SELECT name FROM category_type WHERE name = "Musical") LIMIT 1;
        INSERT INTO category_type (name) SELECT * FROM (SELECT "Ficção Científica") AS tmp WHERE NOT EXISTS (SELECT name FROM category_type WHERE name = "Ficção Científica") LIMIT 1;
    ');
} catch (PDOException $e) {
  die("Error: " . $e->getMessage());
}
