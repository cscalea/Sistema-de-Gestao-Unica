create database control;
use control;

create table users(
id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
name VARCHAR(55),
login VARCHAR(50),
email VARCHAR(120) UNIQUE,
setor VARCHAR(200),
token VARCHAR(200)
);

INSERT into users (name, login, email, setor) VALUES ("carlos", "casjun", "cas@ipem.com", "dadm");

select * from users;

ALTER TABLE users
ADD column setor VARCHAR(200);

UPDATE users SET token = '013158ba6dee909508c1850562df7a19' where login = "casjunior";

create table menus(
id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
menu VARCHAR(50) UNIQUE,
link VARCHAR(100),
class VARCHAR(45)
);

select * from menus;
UPDATE menus SET link = "bi.php" where id = 13;

create table permissions(
id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
fk_idusers INT NOT NULL,
fk_idmenus INT NOT NULL,
adm INT NOT NULL,
FOREIGN KEY (fk_idusers) REFERENCES users(id),
FOREIGN KEY (fk_idmenus) REFERENCES menus(id)
);
/*tst*/