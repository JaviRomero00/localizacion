DROP TABLE IF EXISTS usuarios CASCADE;
DROP TABLE IF EXISTS trabajadores CASCADE;
DROP TABLE IF EXISTS incidencias CASCADE;
DROP FUNCTION IF EXISTS check_trabajadores_controlador_exists CASCADE;


CREATE TABLE usuarios (
    id          bigserial   PRIMARY KEY,
    usuario     varchar(255) NOT NULL UNIQUE,
    contrasena  varchar(255) NOT NULL,
    rol         varchar(255) NOT NULL,
    dni_usuario char(9)      NOT NULL REFERENCES trabajadores (dni)
);

CREATE TABLE trabajadores (
    id          bigserial       PRIMARY KEY,
    dni         char(9)         NOT NULL UNIQUE,
    nombre      varchar(255)    NOT NULL,
    apellidos   varchar(255)    NOT NULL,
    direccion   varchar(255)    NOT NULL,
    poblacion   varchar(255)    NOT NULL,
    provincia   varchar(255)    NOT NULL,
    cp          char(5)         NOT NULL,
    puesto      varchar(255)    NOT NULL,
    plaza       varchar(255)    NOT NULL,
    controlador bool            NOT NULL
);


CREATE TABLE incidencias (
    trabajador_id   bigserial       NOT NULL REFERENCES trabajadores (id),
    fecha           date            NOT NULL,
    hora            time            NOT NULL,
    controlador_id  bigserial       NOT NULL REFERENCES trabajadores (id),
    longitud        float           NOT NULL,
    latitud         float           NOT NULL,
    produccion      varchar(255)    NOT NULL
);

INSERT INTO usuarios (usuario, contrasena, rol, dni_usuario)
     VALUES (md5('javi'), md5('javi'), 'admin', '87651234N');

INSERT INTO usuarios (usuario, contrasena, rol, dni_usuario)
     VALUES (md5('normal'), md5('normal'), 'normal', '43215678M');

INSERT INTO trabajadores (dni, nombre, apellidos, direccion,
poblacion, provincia, cp, puesto, plaza, controlador)
    VALUES ('43215678M', 'NoControlador', 'NoES', 'Calle Falsa 1234', 'Ciudad Falsa',
    'Falsa', '11540', 'Puesto falso', 'Jefe Falso', false);

INSERT INTO trabajadores (dni, nombre, apellidos, direccion,
poblacion, provincia, cp, puesto, plaza, controlador)
    VALUES ('87651234N', 'Controlador', 'ES', 'Calle Falsa 4321', 'Ciudad Falsa',
    'Falsa', '11540', 'Puesto falso', 'Asistente', true);
