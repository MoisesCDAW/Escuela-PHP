
DROP DATABASE IF EXISTS escuela;

CREATE DATABASE escuela;
USE escuela;


CREATE TABLE asignaturas (
    ID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    abreviatura varchar(5) NOT NULL,
    nombre varchar(50) NOT NULL
);


CREATE TABLE alumnos (
    ID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    dni varchar(9) NOT NULL,
    nombre varchar(30) DEFAULT NULL,
    apellidos varchar(30) DEFAULT NULL
);


CREATE TABLE cursantes (
    ID_alumn int,
    ID_asig int,
    PRIMARY KEY (ID_alumn, ID_asig),
    FOREIGN KEY (ID_alumn) REFERENCES alumnos(ID) ON DELETE CASCADE,
    FOREIGN KEY (ID_asig) REFERENCES asignaturas(ID) ON DELETE CASCADE
);


CREATE TABLE unidades (
    ID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    numero int NOT NULL,
    ID_asig int NOT NULL,
    FOREIGN KEY (ID_asig) REFERENCES asignaturas(ID) ON DELETE CASCADE
);


CREATE TABLE actividades (
    ID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    titulo varchar(30) NOT NULL,
    ID_unid int NOT NULL,
    FOREIGN KEY (ID_unid) REFERENCES unidades(ID) ON DELETE CASCADE
);


CREATE TABLE notas (
    nota int NOT NULL,
    ID_act int NOT NULL,
    ID_alumn int NOT NULL,
    PRIMARY KEY (ID_act, ID_alumn),
    FOREIGN KEY (ID_act) REFERENCES actividades(ID) ON DELETE CASCADE,
    FOREIGN KEY (ID_alumn) REFERENCES alumnos(ID) ON DELETE CASCADE
);