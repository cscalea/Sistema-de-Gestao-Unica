create database control;
use control;

create table users(
id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
name VARCHAR(55),
login VARCHAR(50),
email VARCHAR(120) UNIQUE
);


create table menus(
id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
menu VARCHAR(50) UNIQUE,
link VARCHAR(100),
class VARCHAR(45)
);

create table permissions(
id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
fk_idusers INT NOT NULL,
fk_idmenus INT NOT NULL,
adm INT NOT NULL,
FOREIGN KEY (fk_idusers) REFERENCES users(id),
FOREIGN KEY (fk_idmenus) REFERENCES menus(id)
);
/*tst*/