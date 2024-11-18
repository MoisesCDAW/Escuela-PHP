
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
    nombre varchar(60) NOT NULL,
    FOREIGN KEY (ID_asig) REFERENCES asignaturas(ID) ON DELETE CASCADE
);


CREATE TABLE actividades (
    ID int NOT NULL AUTO_INCREMENT PRIMARY KEY,  
    ID_unid int NOT NULL,
    numero int NOT NULL,
    nombre varchar(60) NOT NULL,
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


INSERT INTO alumnos (dni, nombre, apellidos) VALUES
('12345678A', 'Juan', 'Pérez'),
('23456789B', 'Ana', 'Gómez'),
('34567890C', 'Pedro', 'López'),
('45678901D', 'María', 'Martínez');

INSERT INTO asignaturas (abreviatura, nombre) VALUES
('DSW', 'Desarrollo web en entorno servidor'),
('DEW', 'Desarrollo Web en entorno cliente'),
('DOR', 'Diseño de Interfaces Web'),
('DPL', 'Despliegue de Aplicaciones Web'),
('EMR', 'Empresa e Iniciativa Emprendedora');

-- ========================= MATRICULA ==========================

INSERT INTO cursantes (ID_alumn, ID_asig)
VALUES
(1, 1), (1, 2), (1, 3), (1, 4), (1, 5), -- Juan en todas las asignaturas
(2, 1), (2, 2), (2, 3), (2, 4), (2, 5), -- Ana en todas las asignaturas
(3, 1), (3, 2), (3, 3), (3, 4), (3, 5), -- Pedro en todas las asignaturas
(4, 1), (4, 2), (4, 3), (4, 4), (4, 5); -- María en todas las asignaturas


-- ========================= UNIDADES ==========================


INSERT INTO unidades (numero, ID_asig, nombre) VALUES
(1, 1, 'Introducción al desarrollo web en servidor'),
(2, 1, 'Fundamentos de PHP y MySQL'),
(3, 1, 'Autenticación y gestión de sesiones');

INSERT INTO unidades (numero, ID_asig, nombre) VALUES
(1, 2, 'Introducción al desarrollo web en cliente'),
(2, 2, 'HTML5 y CSS3 para el diseño de interfaces'),
(3, 2, 'JavaScript y la manipulación del DOM');

INSERT INTO unidades (numero, ID_asig, nombre) VALUES
(1, 3, 'Principios básicos de diseño de interfaces web'),
(2, 3, 'Usabilidad y experiencia de usuario (UX)'),
(3, 3, 'Diseño adaptativo y diseño responsivo');

INSERT INTO unidades (numero, ID_asig, nombre) VALUES
(1, 4, 'Fundamentos del despliegue de aplicaciones web'),
(2, 4, 'Configuración de servidores web y bases de datos'),
(3, 4, 'Automatización del despliegue con CI/CD');

INSERT INTO unidades (numero, ID_asig, nombre) VALUES
(1, 5, 'Fundamentos del emprendimiento y la innovación'),
(2, 5, 'Modelos de negocio y planificación estratégica'),
(3, 5, 'Estrategias de marketing digital para emprendedores');


-- ========================= ACTIVIDADES ==========================

-- Actividades para la unidad 1 de la asignatura 1
INSERT INTO actividades (ID_unid, numero, nombre) VALUES
(1, 1, 'Configurar un entorno de desarrollo para PHP y MySQL'),
(1, 2, 'Crear un servidor local con XAMPP o similar'),
(1, 3, 'Explorar frameworks para desarrollo en servidor');

-- Actividades para la unidad 2 de la asignatura 1
INSERT INTO actividades (ID_unid, numero, nombre) VALUES
(2, 1, 'Crear un CRUD básico en PHP'),
(2, 2, 'Conectar una aplicación PHP a una base de datos MySQL'),
(2, 3, 'Diseñar y consultar bases de datos utilizando SQL');

-- Actividades para la unidad 3 de la asignatura 1
INSERT INTO actividades (ID_unid, numero, nombre) VALUES
(3, 1, 'Implementar autenticación de usuarios en PHP'),
(3, 2, 'Crear sesiones y cookies para gestionar accesos'),
(3, 3, 'Diseñar un sistema de roles y permisos básicos');

-- Actividades para la unidad 1 de la asignatura 2
INSERT INTO actividades (ID_unid, numero, nombre) VALUES
(4, 1, 'Diseñar una estructura HTML básica para un sitio web'),
(4, 2, 'Explorar etiquetas semánticas de HTML5'),
(4, 3, 'Crear un formulario simple con validaciones básicas');

-- Actividades para la unidad 2 de la asignatura 2
INSERT INTO actividades (ID_unid, numero, nombre) VALUES
(5, 1, 'Aplicar estilos CSS a un diseño estático'),
(5, 2, 'Crear un diseño responsivo usando media queries'),
(5, 3, 'Utilizar Flexbox para alinear elementos en una página web');

-- Actividades para la unidad 3 de la asignatura 2
INSERT INTO actividades (ID_unid, numero, nombre) VALUES
(6, 1, 'Manipular el DOM usando JavaScript'),
(6, 2, 'Crear una animación interactiva con JavaScript'),
(6, 3, 'Implementar eventos para mejorar la interacción de usuario');

-- Actividades para la unidad 1 de la asignatura 3
INSERT INTO actividades (ID_unid, numero, nombre) VALUES
(7, 1, 'Identificar características de un buen diseño de interfaz'),
(7, 2, 'Realizar un prototipo simple con herramientas de diseño'),
(7, 3, 'Implementar un diseño básico utilizando HTML y CSS');

-- Actividades para la unidad 2 de la asignatura 3
INSERT INTO actividades (ID_unid, numero, nombre) VALUES
(8, 1, 'Analizar casos de éxito de experiencia de usuario (UX)'),
(8, 2, 'Evaluar usabilidad de una página existente'),
(8, 3, 'Diseñar una mejora en la experiencia del usuario');

-- Actividades para la unidad 3 de la asignatura 3
INSERT INTO actividades (ID_unid, numero, nombre) VALUES
(9, 1, 'Crear un diseño responsivo con Bootstrap'),
(9, 2, 'Optimizar una interfaz para dispositivos móviles'),
(9, 3, 'Implementar un diseño adaptativo para múltiples resoluciones');

-- Actividades para la unidad 1 de la asignatura 4
INSERT INTO actividades (ID_unid, numero, nombre) VALUES
(10, 1, 'Identificar tipos de despliegue para aplicaciones web'),
(10, 2, 'Configurar un servidor para una aplicación web estática'),
(10, 3, 'Subir un proyecto web a un servidor local');

-- Actividades para la unidad 2 de la asignatura 4
INSERT INTO actividades (ID_unid, numero, nombre) VALUES
(11, 1, 'Instalar y configurar un servidor Apache'),
(11, 2, 'Configurar un entorno seguro con HTTPS'),
(11, 3, 'Realizar un backup de una base de datos');

-- Actividades para la unidad 3 de la asignatura 4
INSERT INTO actividades (ID_unid, numero, nombre) VALUES
(12, 1, 'Configurar un sistema de CI/CD para un proyecto web'),
(12, 2, 'Automatizar pruebas unitarias con un pipeline'),
(12, 3, 'Desplegar una aplicación en un entorno de producción');

-- Actividades para la unidad 1 de la asignatura 5
INSERT INTO actividades (ID_unid, numero, nombre) VALUES
(13, 1, 'Identificar elementos de un plan de negocio'),
(13, 2, 'Analizar ejemplos de emprendimientos exitosos'),
(13, 3, 'Realizar un brainstorming para ideas de negocio');

-- Actividades para la unidad 2 de la asignatura 5
INSERT INTO actividades (ID_unid, numero, nombre) VALUES
(14, 1, 'Crear un modelo Canvas para un proyecto'),
(14, 2, 'Evaluar la viabilidad financiera de un negocio'),
(14, 3, 'Diseñar estrategias para escalar un modelo de negocio');

-- Actividades para la unidad 3 de la asignatura 5
INSERT INTO actividades (ID_unid, numero, nombre) VALUES
(15, 1, 'Crear una campaña de marketing digital básica'),
(15, 2, 'Identificar herramientas de SEO para startups'),
(15, 3, 'Analizar resultados de campañas digitales');



-- ========================= NOTAS ==========================

DELIMITER $$

CREATE PROCEDURE GenerarNotas()
BEGIN
    DECLARE i INT DEFAULT 1; -- Contador para las actividades
    DECLARE j INT DEFAULT 1; -- Contador para los alumnos
    DECLARE nota INT;        -- Variable para almacenar la nota aleatoria

    WHILE i <= 45 DO -- Hay 45 actividades
        SET j = 1; -- Reinicia el contador de alumnos para cada actividad
        WHILE j <= 4 DO -- Hay 4 alumnos
            SET nota = FLOOR(1 + RAND() * 10); -- Genera una nota aleatoria entre 1 y 10
            INSERT INTO notas (nota, ID_act, ID_alumn) VALUES (nota, i, j);
            SET j = j + 1; -- Avanza al siguiente alumno
        END WHILE;
        SET i = i + 1; -- Avanza a la siguiente actividad
    END WHILE;
END$$

DELIMITER ;

CALL GenerarNotas();