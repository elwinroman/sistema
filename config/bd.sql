-- Tabla usuarios login
CREATE TABLE usuarios (
	id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(30) NOT NULL,
    password VARCHAR(30) NOT NULL,
    role enum('administrador', 'observador') NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT uq_username UNIQUE (username)
) ENGINE=INNODB;