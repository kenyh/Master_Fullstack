-- borrar tablas.
DROP TABLE IF EXISTS usuario CASCADE;
DROP TABLE IF EXISTS veterinario CASCADE;
DROP TABLE IF EXISTS cliente CASCADE;
DROP TABLE IF EXISTS vendedor CASCADE;
DROP TABLE IF EXISTS administrador CASCADE;
DROP TABLE IF EXISTS mascota CASCADE;
DROP TABLE IF EXISTS cita CASCADE;
DROP TABLE IF EXISTS item CASCADE;
DROP TABLE IF EXISTS tipo_servicio CASCADE;
DROP TABLE IF EXISTS servicio CASCADE;
DROP TABLE IF EXISTS mensualidad CASCADE;
DROP TABLE IF EXISTS producto CASCADE;
DROP TABLE IF EXISTS proveedor CASCADE;
DROP TABLE IF EXISTS compra CASCADE;
DROP TABLE IF EXISTS detalle_compra CASCADE;
DROP TABLE IF EXISTS suministro CASCADE;
DROP TABLE IF EXISTS venta CASCADE;

DROP TABLE IF EXISTS detalle_venta CASCADE;
DROP TABLE IF EXISTS pago CASCADE;

DROP DOMAIN IF EXISTS TIPO_USUARIO CASCADE;
DROP DOMAIN IF EXISTS CONDICION CASCADE;
DROP DOMAIN IF EXISTS ESPECIE CASCADE;

DROP SEQUENCE IF EXISTS cita_id_cita_seq CASCADE;
DROP SEQUENCE IF EXISTS mascota_id_mascota_seq CASCADE;
DROP SEQUENCE IF EXISTS item_codigo_seq CASCADE;
DROP SEQUENCE IF EXISTS usuario_id_usuario_seq CASCADE;
DROP SEQUENCE IF EXISTS proveedor_id_proveedor_seq CASCADE;
DROP SEQUENCE IF EXISTS compra_id_compra_seq CASCADE;
DROP SEQUENCE IF EXISTS venta_id_venta_seq CASCADE;
DROP SEQUENCE IF EXISTS pago_id_pago_seq CASCADE;

--- CREAR TODO
CREATE DOMAIN TIPO_USUARIO AS VARCHAR(50) CHECK (
	VALUE IN (
		'cliente',
		'administrador',
		'veterinario',
		'vendedor'
	)
);

CREATE DOMAIN CONDICION AS VARCHAR(50) CHECK (VALUE IN ('contado', 'credito'));

CREATE DOMAIN ESPECIE AS VARCHAR(50) CHECK (VALUE IN ('canino', 'felino'));

CREATE TABLE
	IF NOT EXISTS usuario (
		id_usuario SERIAL PRIMARY KEY,
		nombres VARCHAR(255) NOT NULL,
		apellidos VARCHAR(255) NOT NULL,
		direccion VARCHAR(255) NOT NULL,
		telefono VARCHAR(50) NOT NULL,
		email VARCHAR(255) NOT NULL UNIQUE,
		contraseña TEXT,
		tipos TIPO_USUARIO[] NOT NULL
	);

CREATE TABLE
	IF NOT EXISTS veterinario (
		id_veterinario INTEGER NOT NULL PRIMARY KEY,
		activo BOOLEAN NOT NULL DEFAULT TRUE,
		CONSTRAINT veterinario_id_veterinario_fk FOREIGN KEY (id_veterinario) REFERENCES usuario (id_usuario) ON DELETE RESTRICT ON UPDATE CASCADE
	);

CREATE TABLE
	IF NOT EXISTS cliente (
		id_cliente INTEGER NOT NULL PRIMARY KEY,
		notificar BOOLEAN NOT NULL DEFAULT FALSE,
		saldo NUMERIC(7, 1) NOT NULL DEFAULT 0,
		activo BOOLEAN NOT NULL DEFAULT TRUE,
		CONSTRAINT cliente_id_cliente_fk FOREIGN KEY (id_cliente) REFERENCES usuario (id_usuario) ON DELETE RESTRICT ON UPDATE CASCADE
	);

CREATE TABLE
	IF NOT EXISTS vendedor (
		id_vendedor INTEGER NOT NULL PRIMARY KEY,
		activo BOOLEAN NOT NULL DEFAULT TRUE,
		CONSTRAINT vendedor_id_vendedor_fk FOREIGN KEY (id_vendedor) REFERENCES usuario (id_usuario) ON DELETE RESTRICT ON UPDATE CASCADE
	);

CREATE TABLE
	IF NOT EXISTS administrador (
		id_administrador INTEGER NOT NULL PRIMARY KEY,
		activo BOOLEAN NOT NULL DEFAULT TRUE,
		CONSTRAINT administrador_id_administrador_fk FOREIGN KEY (id_administrador) REFERENCES usuario (id_usuario) ON DELETE RESTRICT ON UPDATE CASCADE
	);

CREATE TABLE
	IF NOT EXISTS Mascota (
		id_mascota SERIAL NOT NULL PRIMARY KEY,
		nombre VARCHAR(100) NOT NULL,
		especie ESPECIE NOT NULL,
		raza VARCHAR(100) NOT NULL,
		nacimiento DATE NOT NULL,
		sexo VARCHAR(20) NOT NULL,
		observaciones TEXT,
		edad INTEGER NOT NULL,
		id_cliente INTEGER NOT NULL,
		CONSTRAINT mascota_id_cliente_nombre_uk UNIQUE (id_cliente, nombre),
		CONSTRAINT mascota_id_cliente_fk FOREIGN KEY (id_cliente) REFERENCES cliente (id_cliente) ON DELETE CASCADE ON UPDATE CASCADE
	);

CREATE TABLE
	IF NOT EXISTS cita (
		id_cita SERIAL NOT NULL PRIMARY KEY,
		motivo TEXT NOT NULL,
		fecha TIMESTAMP NOT NULL,
		observaciones TEXT,
		agendado_por INTEGER NOT NULL,
		atentido_por INTEGER NOT NULL,
		id_mascota INTEGER NOT NULL,
		CONSTRAINT fk_cita_agendado_por FOREIGN KEY (agendado_por) REFERENCES usuario (id_usuario) ON DELETE CASCADE ON UPDATE CASCADE,
		CONSTRAINT fk_cita_atentido_por FOREIGN KEY (atentido_por) REFERENCES veterinario (id_veterinario) ON DELETE RESTRICT ON UPDATE CASCADE,
		CONSTRAINT fk_cita_id_mascota FOREIGN KEY (id_mascota) REFERENCES mascota (id_mascota) ON DELETE CASCADE ON UPDATE CASCADE
	);

CREATE TABLE
	IF NOT EXISTS item (
		codigo SERIAL NOT NULL PRIMARY KEY,
		nombre VARCHAR(255) UNIQUE NOT NULL,
		descripcion TEXT NOT NULL,
		precio NUMERIC(7, 1) NOT NULL
	);

CREATE TABLE
	IF NOT EXISTS tipo_servicio (
		nombre VARCHAR(255) NOT NULL PRIMARY KEY,
		descripcion TEXT NOT NULL
	);

CREATE TABLE
	IF NOT EXISTS servicio (
		id_servicio INTEGER NOT NULL PRIMARY KEY,
		activo BOOLEAN NOT NULL,
		tipo VARCHAR(50) NOT NULL,
		CONSTRAINT servicio_id_servicio_fk FOREIGN KEY (id_servicio) REFERENCES item (codigo) ON DELETE RESTRICT ON UPDATE CASCADE,
		CONSTRAINT servicio_tipo_fk FOREIGN KEY (tipo) REFERENCES tipo_servicio (nombre) ON DELETE RESTRICT ON UPDATE CASCADE
	);

CREATE TABLE
	IF NOT EXISTS mensualidad (
		id_mensualidad INTEGER NOT NULL PRIMARY KEY,
		cantidad_mascotas INTEGER NOT NULL,
		CONSTRAINT mensualidad_id_mensualidad_fk FOREIGN KEY (id_mensualidad) REFERENCES item (codigo) ON DELETE CASCADE ON UPDATE CASCADE
	);

CREATE TABLE
	IF NOT EXISTS producto (
		id_producto INTEGER NOT NULL PRIMARY KEY, -- referencia a item.codigo
		stock_minimo INTEGER NOT NULL,
		costo NUMERIC(7, 1) NOT NULL,
		stock INTEGER NOT NULL DEFAULT 0,
		vencimiento DATE NOT NULL,
		dias_alerta INTEGER NOT NULL,
		porcentaje NUMERIC(4, 1) NOT NULL,
		CONSTRAINT producto_id_producto_fk FOREIGN KEY (id_producto) REFERENCES item (codigo) ON DELETE RESTRICT ON UPDATE CASCADE
	);

CREATE TABLE
	IF NOT EXISTS proveedor (
		id_proveedor SERIAL NOT NULL PRIMARY KEY,
		email VARCHAR(255) NOT NULL UNIQUE,
		nombre VARCHAR(255) NOT NULL,
		condiciones CONDICION NOT NULL,
		telefono VARCHAR(50) NOT NULL,
		direccion VARCHAR(255) NOT NULL
	);

CREATE TABLE
	IF NOT EXISTS compra (
		id_compra SERIAL NOT NULL PRIMARY KEY,
		fecha DATE NOT NULL,
		id_administrador INTEGER NOT NULL,
		id_proveedor INTEGER NOT NULL,
		CONSTRAINT compra_id_administrador_fk FOREIGN KEY (id_administrador) REFERENCES administrador (id_administrador) ON DELETE RESTRICT ON UPDATE CASCADE,
		CONSTRAINT compra_id_proveedor_fk FOREIGN KEY (id_proveedor) REFERENCES proveedor (id_proveedor) ON DELETE RESTRICT ON UPDATE CASCADE
	);

CREATE TABLE
	IF NOT EXISTS detalle_compra (
		id_compra INTEGER NOT NULL,
		id_producto INTEGER NOT NULL,
		cantidad INTEGER NOT NULL,
		precio NUMERIC(7, 1) NOT NULL,
		importe NUMERIC(8, 1) NOT NULL GENERATED ALWAYS AS (cantidad * precio) STORED,
		CONSTRAINT detalle_compra_pk PRIMARY KEY (id_compra, id_producto),
		CONSTRAINT detalle_compra_id_compra_fk FOREIGN KEY (id_compra) REFERENCES compra (id_compra) ON DELETE CASCADE ON UPDATE CASCADE,
		CONSTRAINT detalle_compra_id_producto_fk FOREIGN KEY (id_producto) REFERENCES producto (id_producto) ON DELETE RESTRICT ON UPDATE CASCADE
	);

CREATE TABLE
	IF NOT EXISTS suministro (
		id_producto INTEGER NOT NULL,
		id_proveedor INTEGER NOT NULL,
		CONSTRAINT suministro_pk PRIMARY KEY (id_producto, id_proveedor),
		CONSTRAINT suministro_id_producto_fk FOREIGN KEY (id_producto) REFERENCES producto (id_producto) ON DELETE CASCADE ON UPDATE CASCADE,
		CONSTRAINT suministro_id_proveedor_fk FOREIGN KEY (id_proveedor) REFERENCES proveedor (id_proveedor) ON DELETE CASCADE ON UPDATE CASCADE
	);

CREATE TABLE
	IF NOT EXISTS venta (
		id_venta SERIAL PRIMARY KEY,
		saldo NUMERIC(7, 1) NOT NULL DEFAULT 0,
		importe NUMERIC(7, 1) NOT NULL DEFAULT 0,
		id_cliente INTEGER NOT NULL,
		id_vendedor INTEGER NOT NULL,
		CONSTRAINT venta_id_cliente_fk FOREIGN KEY (id_cliente) REFERENCES cliente (id_cliente) ON DELETE RESTRICT ON UPDATE CASCADE,
		CONSTRAINT venta_id_vendedor_fk FOREIGN KEY (id_vendedor) REFERENCES vendedor (id_vendedor) ON DELETE RESTRICT ON UPDATE CASCADE
	);

CREATE TABLE
	IF NOT EXISTS detalle_venta (
		id_venta INTEGER NOT NULL,
		codigo INTEGER NOT NULL,
		cantidad INTEGER NOT NULL,
		precio NUMERIC(7, 1) NOT NULL,
		importe NUMERIC(8, 1) NOT NULL,
		CONSTRAINT detalle_venta_pk PRIMARY KEY (id_venta, codigo),
		CONSTRAINT detalle_venta_id_venta_fk FOREIGN KEY (id_venta) REFERENCES venta (id_venta) ON DELETE CASCADE ON UPDATE CASCADE,
		CONSTRAINT detalle_venta_codigo_fk FOREIGN KEY (codigo) REFERENCES item (codigo) ON DELETE RESTRICT ON UPDATE CASCADE
	);

CREATE TABLE
	IF NOT EXISTS Pago (
		id_pago SERIAL NOT NULL PRIMARY KEY,
		fecha DATE NOT NULL,
		id_venta INTEGER NOT NULL,
		importe NUMERIC(7, 1) NOT NULL,
		CONSTRAINT pago_id_venta_fk FOREIGN KEY (id_venta) REFERENCES venta (id_venta) ON DELETE RESTRICT ON UPDATE CASCADE
	);