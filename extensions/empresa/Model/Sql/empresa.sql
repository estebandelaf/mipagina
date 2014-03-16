BEGIN;

DROP TABLE IF EXISTS sucursal CASCADE;
CREATE TABLE sucursal (
	id serial PRIMARY KEY,
	codigo CHARACTER VARYING (10),
	sucursal VARCHAR (30) NOT NULL,
	matriz BOOLEAN NOT NULL DEFAULT false,
	email CHARACTER VARYING (50),
	telefono CHARACTER VARYING (20),
	fax CHARACTER VARYING (20),
	direccion CHARACTER VARYING (100),
	comuna CHAR (5),
	empleado INTEGER,
	CONSTRAINT sucursal_comuna_fk
		FOREIGN KEY (comuna)
		REFERENCES comuna (codigo) MATCH FULL
		ON UPDATE CASCADE ON DELETE CASCADE
);
CREATE UNIQUE INDEX ON sucursal (codigo);
COMMENT ON TABLE sucursal IS 'Sucursales de la empresa';
COMMENT ON COLUMN sucursal.id IS 'Identificador de la sucursal';
COMMENT ON COLUMN sucursal.sucursal IS 'Nombre de la sucursal';
COMMENT ON COLUMN sucursal.matriz IS 'Indica si la sucursal es la casa matriz';
COMMENT ON COLUMN sucursal.email IS 'Correo electrónico principal de la sucursal';
COMMENT ON COLUMN sucursal.telefono IS 'Teléfono principal de la sucursal';
COMMENT ON COLUMN sucursal.fax IS 'Fax principal de la sucursal';
COMMENT ON COLUMN sucursal.direccion IS 'Dirección de la sucursal';
COMMENT ON COLUMN sucursal.comuna IS 'Comuna de la sucursal';
COMMENT ON COLUMN sucursal.empleado IS 'Empleado a cargo de la sucursal';

DROP TABLE IF EXISTS area CASCADE;
CREATE TABLE area (
	id serial PRIMARY KEY,
	area VARCHAR (30) NOT NULL,
	superior INTEGER,
	CONSTRAINT area_superior_fk
		FOREIGN KEY (superior)
		REFERENCES area (id) MATCH FULL
		ON UPDATE CASCADE ON DELETE SET NULL
);
COMMENT ON TABLE area IS 'Áreas de la empresa';
COMMENT ON COLUMN area.id IS 'Identificador del área';
COMMENT ON COLUMN area.area IS 'Nombre del área';
COMMENT ON COLUMN area.superior IS 'Área a la que pertenece esta área';

DROP TABLE IF EXISTS cargo CASCADE;
CREATE TABLE cargo (
	id serial PRIMARY KEY,
	cargo VARCHAR (30) NOT NULL,
	jefe INTEGER,
	area INTEGER,
	CONSTRAINT cargo_jefe_fk
		FOREIGN KEY (jefe)
		REFERENCES cargo (id) MATCH FULL
		ON UPDATE CASCADE ON DELETE SET NULL,
	CONSTRAINT cargo_area_fk
		FOREIGN KEY (area)
		REFERENCES area (id) MATCH FULL
		ON UPDATE CASCADE ON DELETE SET NULL
);
CREATE INDEX ON cargo USING HASH (jefe);
CREATE INDEX ON cargo USING HASH (area);
COMMENT ON TABLE cargo IS 'Cargos de la empresa';
COMMENT ON COLUMN cargo.id IS 'Identificador del cargo';
COMMENT ON COLUMN cargo.cargo IS 'Nombre del cargo';
COMMENT ON COLUMN cargo.jefe IS 'Jefe o supervisor de este cargo. El cargo que está sobre este cargo.';
COMMENT ON COLUMN cargo.area IS 'Área de la empresa en la que se desempeña este cargo';

DROP TABLE IF EXISTS empleado CASCADE;
CREATE TABLE empleado (
	run INTEGER PRIMARY KEY,
	dv CHAR (1) NOT NULL,
	nombres CHARACTER VARYING (30) NOT NULL,
	apellidos CHARACTER VARYING (30) NOT NULL,
	activo BOOLEAN NOT NULL DEFAULT true,
	cargo INTEGER,
	foto_data bytea,
	foto_name character varying(100),
	foto_type character varying(10),
	foto_size integer,
	fecha_nacimiento DATE,
	sucursal INTEGER,
	usuario INTEGER,
	CONSTRAINT empleado_cargo_fk
		FOREIGN KEY (cargo)
		REFERENCES cargo (id) MATCH FULL
		ON UPDATE CASCADE ON DELETE SET NULL,
	CONSTRAINT empleado_usuario_fk
		FOREIGN KEY (usuario)
		REFERENCES usuario (id) MATCH FULL
		ON UPDATE CASCADE ON DELETE SET NULL,
	CONSTRAINT empleado_sucursal_fk
		FOREIGN KEY (sucursal)
		REFERENCES sucursal (id) MATCH FULL
		ON UPDATE CASCADE ON DELETE SET NULL
);
CREATE INDEX ON empleado USING HASH (cargo);
CREATE UNIQUE INDEX ON empleado (usuario);
COMMENT ON TABLE empleado IS 'Listado de empleados de la empresa';
COMMENT ON COLUMN empleado.run IS 'RUN de la persona, sin puntos ni dígito verificador';
COMMENT ON COLUMN empleado.dv IS 'Dígito verificador del RUN';
COMMENT ON COLUMN empleado.nombres IS 'Nombres de la persona';
COMMENT ON COLUMN empleado.apellidos IS 'Apellidos de la persona';
COMMENT ON COLUMN empleado.activo IS 'Activo o no en la empresa';
COMMENT ON COLUMN empleado.cargo IS 'Cargo que ocupa dentro de la empresa';
COMMENT ON COLUMN empleado.foto_data IS 'Fotografía de la persona';
COMMENT ON COLUMN empleado.foto_name IS 'Nombre de la fotografía';
COMMENT ON COLUMN empleado.foto_type IS 'Mimetype de la fotografía';
COMMENT ON COLUMN empleado.foto_size IS 'Tamaño de la fotografía';
COMMENT ON COLUMN empleado.fecha_nacimiento IS 'Fecha de nacimiento de la persona';
COMMENT ON COLUMN empleado.sucursal IS 'Sucursal en la que trabaja este empleado';
COMMENT ON COLUMN empleado.usuario IS 'Usuario del sistema (si es que tiene uno asignado)';

ALTER TABLE sucursal ADD
	CONSTRAINT sucursal_empleado_fk
		FOREIGN KEY (empleado)
		REFERENCES empleado (run) MATCH FULL
		ON UPDATE CASCADE ON DELETE SET NULL
;

DROP TABLE IF EXISTS cliente CASCADE;
CREATE TABLE cliente (
	rut INTEGER PRIMARY KEY,
	dv CHAR (1) NOT NULL,
	razon_social CHARACTER VARYING (60) NOT NULL,
	actividad_economica INTEGER,
	email CHARACTER VARYING (50),
	telefono CHARACTER VARYING (20),
	direccion CHARACTER VARYING (100),
	comuna CHAR (5),
	contrasenia CHAR (64),
	CONSTRAINT cliente_actividad_economica_fk
		FOREIGN KEY (actividad_economica)
		REFERENCES actividad_economica (codigo) MATCH FULL
		ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT cliente_comuna_fk
		FOREIGN KEY (comuna)
		REFERENCES comuna (codigo) MATCH FULL
		ON UPDATE CASCADE ON DELETE CASCADE
);
COMMENT ON TABLE cliente IS 'Listado de clientes de la empresa';
COMMENT ON COLUMN cliente.rut IS 'RUT del cliente, sin puntos ni dígito verificador';
COMMENT ON COLUMN cliente.dv IS 'Dígito verificador del rut';
COMMENT ON COLUMN cliente.razon_social IS 'Nombre o razón social';
COMMENT ON COLUMN cliente.actividad_economica IS 'Actividad económica o bien nulo si es Particular';
COMMENT ON COLUMN cliente.email IS 'Correo electrónico principal de contacto';
COMMENT ON COLUMN cliente.telefono IS 'Teléfono principal de contacto';
COMMENT ON COLUMN cliente.direccion IS 'Dirección de la casa matriz';
COMMENT ON COLUMN cliente.comuna IS 'Comuna de la casa matriz';
COMMENT ON COLUMN cliente.contrasenia IS 'Contraseña para acceder a servicios de la aplicación';

DROP TABLE IF EXISTS proveedor CASCADE;
CREATE TABLE proveedor (
	rut INTEGER PRIMARY KEY,
	dv CHAR (1) NOT NULL,
	razon_social CHARACTER VARYING (60) NOT NULL,
	email CHARACTER VARYING (50),
	telefono CHARACTER VARYING (20),
	direccion CHARACTER VARYING (100),
	comuna CHAR (5),
	web CHARACTER VARYING (50),
	CONSTRAINT proveedor_comuna_fk
		FOREIGN KEY (comuna)
		REFERENCES comuna (codigo) MATCH FULL
		ON UPDATE CASCADE ON DELETE CASCADE
);
COMMENT ON TABLE proveedor IS 'Listado de proveedores de la empresa';
COMMENT ON COLUMN proveedor.rut IS 'RUT del proveedor, sin puntos ni dígito verificador';
COMMENT ON COLUMN proveedor.dv IS 'Dígito verificador del rut';
COMMENT ON COLUMN proveedor.razon_social IS 'Nombre o razón social';
COMMENT ON COLUMN proveedor.email IS 'Correo electrónico de contacto';
COMMENT ON COLUMN proveedor.telefono IS 'Teléfono de contacto';
COMMENT ON COLUMN proveedor.direccion IS 'Dirección de contacto';
COMMENT ON COLUMN proveedor.comuna IS 'Comuna de contacto';
COMMENT ON COLUMN proveedor.web IS 'Página web del proveedor';

COMMIT;
