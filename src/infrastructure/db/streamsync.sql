CREATE TABLE roles (
  id INT NOT NULL AUTO_INCREMENT,
  roleName VARCHAR(50),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
);

CREATE TABLE users (
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

CREATE TABLE category_type(
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
);

CREATE TABLE content_type(
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
);

CREATE TABLE content (
  id INT NOT NULL AUTO_INCREMENT,
  type_id INT NOT NULL,
  title VARCHAR(255) NOT NULL,
  release_date DATE NOT NULL,
  end_date DATE,
  number_seasons INT,
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


CREATE TABLE lists (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(255),
  user_id INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY(id),
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE listContent (
  id INT NOT NULL AUTO_INCREMENT,
  list_id INT NOT NULL,
  content_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY(id),
  FOREIGN KEY (list_id) REFERENCES lists(id),
  FOREIGN KEY (content_id) REFERENCES content(id)
);

CREATE TABLE reviews (
  user_id INT NOT NULL,
  content_id INT NOT NULL,
  rating INT NOT NULL,
  comment TEXT NOT NULL,
  review_date DATE NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (user_id, content_id),
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (content_id) REFERENCES content(id)
);

CREATE TABLE shares (
  id INT NOT NULL AUTO_INCREMENT,
  share_date DATE NOT NULL,
  origin_user_id INT NOT NULL,
  destination_user_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY(id),
  FOREIGN KEY (origin_user_id) REFERENCES users(id),
  FOREIGN KEY (destination_user_id) REFERENCES users(id)
);

CREATE TABLE listShares (
  id INT NOT NULL AUTO_INCREMENT,
  share_id INT NOT NULL,
  content_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY(id),
  FOREIGN KEY (share_id) REFERENCES shares(id),
  FOREIGN KEY (content_id) REFERENCES content(id)
);

INSERT INTO roles (roleName) 
VALUES ('Administrador');
INSERT INTO roles (roleName) 
VALUES ('Utilizador');

INSERT INTO users (first_name, last_name, birthdate, email, password, username, role_id) 
VALUES ('Admin', 'Admin', '2023-12-05', 'admin@ipvc.pt', 'admin', 'admin', 1);

INSERT INTO content_type (name) 
VALUES ('Filmes');
INSERT INTO content_type (name) 
VALUES ('Séries');
INSERT INTO content_type (name) 
VALUES ('Documentários');
INSERT INTO content_type (name) 
VALUES ('Talk Show');
INSERT INTO content_type (name) 
VALUES ('Curta-Metragem');


INSERT INTO category_type (name) 
VALUES ('Comédia');
INSERT INTO category_type (name) 
VALUES ('Policial');
INSERT INTO category_type (name) 
VALUES ('Guerra');
INSERT INTO category_type (name) 
VALUES ('Mistério');
INSERT INTO category_type (name) 
VALUES ('Familía');
INSERT INTO category_type (name) 
VALUES ('Animação');
INSERT INTO category_type (name) 
VALUES ('Ação');
INSERT INTO category_type (name) 
VALUES ('Drama');
INSERT INTO category_type (name) 
VALUES ('Aventura');
INSERT INTO category_type (name) 
VALUES ('Romance');
INSERT INTO category_type (name) 
VALUES ('Terror');
INSERT INTO category_type (name) 
VALUES ('Documentário');
INSERT INTO category_type (name) 
VALUES ('Suspense');
INSERT INTO category_type (name) 
VALUES ('Musical');
INSERT INTO category_type (name) 
VALUES ('Ficção Científica');