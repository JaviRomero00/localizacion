DROP TABLE IF EXISTS usuarios CASCADE;
DROP TABLE IF EXISTS trabajadores CASCADE;
DROP TABLE IF EXISTS incidencias CASCADE;


CREATE TABLE usuarios (
    id          bigserial   PRIMARY KEY,
    usuario     varchar(255) NOT NULL UNIQUE,
    contrasena  varchar(255) NOT NULL,
    rol         varchar(255) NOT NULL
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
)

CREATE TABLE incidencias (
    trabajador_id   bigserial       NOT NULL REFERENCES trabajadores (id),
    fecha           date            NOT NULL,
    hora            time            NOT NULL,
    controlador_id  bigserial       NOT NULL REFERENCES trabajadores (id),
    longitud        float           NOT NULL,
    latitud         float           NOT NULL,
    produccion      varchar(255)    NOT NULL
)
