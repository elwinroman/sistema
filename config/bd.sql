-- Tabla USUARIOS (login)
CREATE TABLE usuarios (
  id INT NOT NULL AUTO_INCREMENT,
  username VARCHAR(30) NOT NULL,
  password VARCHAR(30) NOT NULL,
  role enum('admin', 'user') NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT uq_username UNIQUE (username)
) ENGINE=INNODB;

-- Tabla OFICINA
CREATE TABLE oficina (
  id INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(60) NOT NULL,
  observacion VARCHAR(200) NULL,
  oficina_id INT NULL,
  PRIMARY KEY(id),
  CONSTRAINT uq_nombre UNIQUE(nombre),
  CONSTRAINT fk_oficina_oficinaid FOREIGN KEY(oficina_id) 
    REFERENCES oficina(id) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=INNODB;

-- Tabla CARGO
CREATE TABLE cargo (
  id INT NOT NULL AUTO_INCREMENT,
  situacion CHAR(1) NOT NULL,
  presupuesto BOOLEAN NOT NULL DEFAULT 1,
  observacion VARCHAR(200) DEFAULT '',
  PRIMARY KEY(id)
) ENGINE=INNODB;

-- Tabla HISTORIAL-CARGO
CREATE TABLE historial_cargo (
  id INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(60) NOT NULL,
  nro_plaza CHAR(3) NOT NULL,
  clasificacion VARCHAR(8) NOT NULL,
  codigo VARCHAR(10) DEFAULT '',
  ordenanza VARCHAR(50) NOT NULL,
  fecha_ordenanza DATE NOT NULL,
  oficina_id INT NOT NULL,
  cargo_id INT NOT NULL,
  PRIMARY KEY(id),
  CONSTRAINT fk_cargo_oficinaid FOREIGN KEY(oficina_id) 
    REFERENCES oficina(id) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT fk_cargo_cargoid FOREIGN KEY(cargo_id) 
    REFERENCES cargo(id) ON DELETE RESTRICT ON UPDATE RESTRICT
)