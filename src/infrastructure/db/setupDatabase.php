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


  # INSERT DEFAULT DATA
  $adminPassword = 'admin123';  // Change this to the desired password
  $hashedAdminPassword = password_hash($adminPassword, PASSWORD_DEFAULT);

  $pdo->exec('
        INSERT INTO roles (roleName) VALUES ("Administrador");
        INSERT INTO roles (roleName) VALUES ("Utilizador");

        INSERT INTO users (first_name, last_name, birthdate, email, password, username, role_id) 
        VALUES ("Admin", "Admin", "2023-12-05", "admin@ipvc.pt", "' . $hashedAdminPassword . '", "admin", 1);
        
        INSERT INTO content_type (name) VALUES ("Filmes");
        INSERT INTO content_type (name) VALUES ("Séries");
        INSERT INTO content_type (name) VALUES ("Documentários");
        INSERT INTO content_type (name) VALUES ("Talk Show");
        INSERT INTO content_type (name) VALUES ("Curta-Metragem");

        INSERT INTO category_type (name) VALUES ("Comédia");
        INSERT INTO category_type (name) VALUES ("Policial");
        INSERT INTO category_type (name) VALUES ("Guerra");
        INSERT INTO category_type (name) VALUES ("Mistério");
        INSERT INTO category_type (name) VALUES ("Familía");
        INSERT INTO category_type (name) VALUES ("Animação");
        INSERT INTO category_type (name) VALUES ("Ação");
        INSERT INTO category_type (name) VALUES ("Drama");
        INSERT INTO category_type (name) VALUES ("Aventura");
        INSERT INTO category_type (name) VALUES ("Romance");
        INSERT INTO category_type (name) VALUES ("Terror");
        INSERT INTO category_type (name) VALUES ("Documentário");
        INSERT INTO category_type (name) VALUES ("Suspense");
        INSERT INTO category_type (name) VALUES ("Musical");
        INSERT INTO category_type (name) VALUES ("Ficção Científica");
    ');
} catch (PDOException $e) {
  die("Error: " . $e->getMessage());
}
