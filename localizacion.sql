DROP TABLE IF EXISTS usuarios CASCADE;
DROP TABLE IF EXISTS trabajadores CASCADE;
DROP TABLE IF EXISTS incidencias CASCADE;
DROP FUNCTION IF EXISTS check_trabajadores_controlador_exists CASCADE;


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
    controlador boolean         NOT NULL
);

CREATE FUNCTION check_trabajadores_controlador_exists(id BIGINT, controlador BOOLEAN) RETURNS BOOLEAN AS $$
BEGIN
    RETURN EXISTS (
        SELECT 1 FROM trabajadores WHERE id = $1 AND controlador = $2
    );
END;
$$ LANGUAGE plpgsql;

CREATE TABLE incidencias (
    trabajador_id   bigserial       NOT NULL REFERENCES trabajadores (id),
    fecha           date            NOT NULL,
    hora            time            NOT NULL,
    controlador_id  bigserial       NOT NULL REFERENCES trabajadores (id),
    longitud        float           NOT NULL,
    latitud         float           NOT NULL,
    produccion      varchar(255)    NOT NULL,
    CONSTRAINT trabajadores_controlador_check CHECK (
        check_trabajadores_controlador_exists(trabajador_id::BIGINT, true::BOOLEAN)
    )
);

INSERT INTO usuarios (usuario, contrasena, rol)
     VALUES (md5('javi'), md5('javi'), 'admin');

INSERT INTO usuarios (usuario, contrasena, rol)
     VALUES (md5('normal'), md5('normal'), 'normal');
