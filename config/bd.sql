-- Tabla USUARIOS (login)
CREATE TABLE usuarios (
	id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(30) NOT NULL,
    password VARCHAR(30) NOT NULL,
    role enum('administrador', 'observador') NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT uq_username UNIQUE (username)
) ENGINE=INNODB;

-- Tabla OFICINAS
CREATE TABLE oficinas (
  id INT NOT NULL AUTO_INCREMENT,
  oficina_id INT NULL,
  nombre VARCHAR(100) NOT NULL,
  observacion VARCHAR(200) NULL
  PRIMARY KEY (id),
  CONSTRAINT uq_nombre UNIQUE(nombre),
  CONSTRAINT fk_oficina FOREIGN KEY (oficina_id) REFERENCES oficinas (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB;