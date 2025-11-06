CREATE TABLE IF NOT EXISTS cargos(
    idcargo INT PRIMARY KEY AUTO_INCREMENT,
    cargo VARCHAR (100) NOT NULL,
    funcion TEXT
)ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS tipodocumento(
    idtipodocumento INT PRIMARY KEY AUTO_INCREMENT,
    tipodocumento VARCHAR (100) NOT NULL
)ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS personal (
    idpersonal INT PRIMARY KEY AUTO_INCREMENT,
    idcargo INT NOT NULL, 
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR (100) NOT NULL,
    idtipodocumento INT NOT NULL,
    identificacion VARCHAR (20) NOT NULL,
    telefono VARCHAR (20) NOT NULL,
    direccion VARCHAR (100) NOT NULL,
    correo VARCHAR (100) NOT NULL,
    clave VARCHAR (100) NOT NULL,
    fecha DATE NOT NUll,
    FOREIGN KEY (idcargo) REFERENCES cargos(idcargo),
    FOREIGN KEY (idtipodocumento) REFERENCES tipodocumento(idtipodocumento)
)ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS lotes (
    idlote INT PRIMARY KEY AUTO_INCREMENT,
    codigolote VARCHAR(50) UNIQUE NOT NULL,
    nombre VARCHAR (100) NOT NULL, 
    fecharecepcion DATE NOT NULL,
    descripcion TEXT
)ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS muestras (
    idmuestra INT PRIMARY KEY AUTO_INCREMENT,
    idpersonal INT NOT NUll,
    codigomuestra VARCHAR(50) UNIQUE NOT NULL,
    tipomuestra VARCHAR (100) NOT NULL,
    idlote INT NOT NULL,
    FOREIGN KEY(idpersonal) REFERENCES personal(idpersonal),
    FOREIGN KEY (idlote) REFERENCES lotes(idlote)
)ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS tiposensayo (
    idtipoensayo INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    condiciones TEXT
)ENGINE=INNODB; 

CREATE TABLE IF NOT EXISTS ensayos (
    idensayo INT PRIMARY KEY AUTO_INCREMENT,
    idmuestra INT NOT NULL,
    idtipoensayo INT NOT NULL,
    fechaensayo DATE NOT NULL,
    observaciones TEXT,
    FOREIGN KEY (idmuestra) REFERENCES muestras(idmuestra),
    FOREIGN KEY (idtipoensayo) REFERENCES tiposensayo(idtipoensayo)
)ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS controlcalidad (
    idcontrol INT PRIMARY KEY AUTO_INCREMENT,
    idensayo INT NOT NULL,
    idpersonal INT NOT NULL,
    parametro VARCHAR(100) NOT NULL,
    unidad VARCHAR(50),
    FOREIGN KEY (idensayo) REFERENCES ensayos(idensayo),
    FOREIGN KEY (idpersonal) REFERENCES personal(idpersonal)
)ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS Certificados (
    idcertificado INT PRIMARY KEY AUTO_INCREMENT,
    idlote INT NOT NULL,
    idcontrol INT NOT NULL,
    fechaemision DATE NOT NULL,
    idpersonal INT NOT NULL,
    cumplerequisitos VARCHAR(50) NOT NULL,
    firmadigital VARCHAR(255), 
    observaciones TEXT,
    FOREIGN KEY (idlote) REFERENCES lotes(idlote),
    FOREIGN KEY (idpersonal) REFERENCES personal(idpersonal),
    FOREIGN KEY (idcontrol) REFERENCES controlcalidad(idcontrol)
)ENGINE=INNODB;