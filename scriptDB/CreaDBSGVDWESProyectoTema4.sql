CREATE USER 'userSGVDWESProyectoTema4'@'%' IDENTIFIED BY 'paso';
GRANT ALL PRIVILEGES ON *.* TO 'userSGVDWESProyectoTema4'@'%' WITH GRANT OPTION;
FLUSH PRIVILEGES;
CREATE DATABASE IF NOT EXISTS DBSGVDWESProyectoTema4;
CREATE TABLE T02_DEPARTAMENTO(
    T02_CodDepartamento VARCHAR(3) PRIMARY KEY,
    T02_DescDepartamento CHAR(255) not null,
    T02_FechaCreacionDepartamento DATETIME  default current_timestamp,
    T02_VolumenDeNegocio FLOAT default 0,
    T02_FechaBajaDepartamento DATETIME default current_timestamp);