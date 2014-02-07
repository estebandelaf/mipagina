<?php

/**
 * MiPaGiNa (MP)
 * Copyright (C) 2012 Esteban De La Fuente Rubio (esteban[at]delaf.cl)
 * 
 * Este programa es software libre: usted puede redistribuirlo y/o
 * modificarlo bajo los términos de la Licencia Pública General GNU
 * publicada por la Fundación para el Software Libre, ya sea la versión
 * 3 de la Licencia, o (a su elección) cualquier versión posterior de la
 * misma.
 * 
 * Este programa se distribuye con la esperanza de que sea útil, pero
 * SIN GARANTÍA ALGUNA; ni siquiera la garantía implícita
 * MERCANTIL o de APTITUD PARA UN PROPÓSITO DETERMINADO.
 * Consulte los detalles de la Licencia Pública General GNU para obtener
 * una información más detallada.
 * 
 * Debería haber recibido una copia de la Licencia Pública General GNU
 * junto a este programa.
 * En caso contrario, consulte <http://www.gnu.org/licenses/gpl.html>.
 */

// Clase para acceso a la base de datos
App::uses('Database', 'Model/Datasource/Database');

// Clase que será extendida por esta clase
App::uses('AppModel', 'Model');

/**
 * Clase abstracta para mapear la tabla usuario de la base de datos
 * Usuarios de la aplicación
 * Esta clase permite trabajar sobre un registro de la tabla usuario
 * @author MiPaGiNa Code Generator
 * @version 2014-02-07 17:00:18
 */
abstract class UsuarioBase extends AppModel {

	// Atributos de la clase (columnas en la base de datos)
	public $id; ///< Identificador (serial): integer(32) NOT NULL DEFAULT 'nextval('usuario_id_seq'::regclass)' AUTO PK 
	public $nombre; ///< Nombre real del usuario: character varying(30) NOT NULL DEFAULT '' 
	public $usuario; ///< Nombre de usuario: character varying(20) NOT NULL DEFAULT '' 
	public $email; ///< Correo electrónico del usuario: character varying(20) NOT NULL DEFAULT '' 
	public $contrasenia; ///< Contraseña del usuario: character(64) NOT NULL DEFAULT '' 
	public $hash; ///< Hash único del usuario: character(32) NOT NULL DEFAULT '' 
	public $activo; ///< Indica si el usuario está o no activo en la aplicación: boolean() NOT NULL DEFAULT 'true' 
	public $ultimo_ingreso_fecha_hora; ///< Fecha y hora del último ingreso del usuario: timestamp without time zone() NULL DEFAULT '' 
	public $ultimo_ingreso_desde; ///< Dirección IP del último ingreso del usuario: character varying(45) NULL DEFAULT '' 
	public $ultimo_ingreso_hash; ///< Hash del último ingreso del usuario: character(32) NULL DEFAULT '' 

	// Información de las columnas de la tabla en la base de datos
	public static $columnsInfo = array(
		'id' => array(
			'name' => 'Id',
			'comment' => 'Identificador (serial)',
			'type' => 'integer',
			'length' => 32,
			'null' => false,
			'default' => "nextval('usuario_id_seq'::regclass)",
			'auto' => true,
			'pk' => true,
			'fk' => null
		),
		'nombre' => array(
			'name' => 'Nombre',
			'comment' => 'Nombre real del usuario',
			'type' => 'character varying',
			'length' => 30,
			'null' => false,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'usuario' => array(
			'name' => 'Usuario',
			'comment' => 'Nombre de usuario',
			'type' => 'character varying',
			'length' => 20,
			'null' => false,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'email' => array(
			'name' => 'Email',
			'comment' => 'Correo electrónico del usuario',
			'type' => 'character varying',
			'length' => 20,
			'null' => false,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'contrasenia' => array(
			'name' => 'Contrasenia',
			'comment' => 'Contraseña del usuario',
			'type' => 'character',
			'length' => 64,
			'null' => false,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'hash' => array(
			'name' => 'Hash',
			'comment' => 'Hash único del usuario',
			'type' => 'character',
			'length' => 32,
			'null' => false,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'activo' => array(
			'name' => 'Activo',
			'comment' => 'Indica si el usuario está o no activo en la aplicación',
			'type' => 'boolean',
			'length' => null,
			'null' => false,
			'default' => "true",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'ultimo_ingreso_fecha_hora' => array(
			'name' => 'Ultimo Ingreso Fecha Hora',
			'comment' => 'Fecha y hora del último ingreso del usuario',
			'type' => 'timestamp without time zone',
			'length' => null,
			'null' => true,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'ultimo_ingreso_desde' => array(
			'name' => 'Ultimo Ingreso Desde',
			'comment' => 'Dirección IP del último ingreso del usuario',
			'type' => 'character varying',
			'length' => 45,
			'null' => true,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'ultimo_ingreso_hash' => array(
			'name' => 'Ultimo Ingreso Hash',
			'comment' => 'Hash del último ingreso del usuario',
			'type' => 'character',
			'length' => 32,
			'null' => true,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),

	);
	
	/**
	 * Constructor de la clase abstracta
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-07 17:00:18
	 */
	public function __construct ($id = null) {
		// asignar base de datos y tabla
		$this->_database = 'default';
		$this->_table = 'usuario';
		// ejecutar constructor de la clase padre
		parent::__construct();
		// setear todo a nulo
		$this->clear();
		// setear atributos del objeto con lo que se haya pasado al
		// constructor como parámetros
		if(func_num_args()>0) {
			$firstArg = func_get_arg(0);
			if(is_array($firstArg)) {
				$this->set($firstArg);
			} else {
				$this->id = $id;
			}
		}
		// obtener otros atributos del objeto
		$this->get();
	}
	
	/**
	 * Setea a null los atributos de la clase (los que sean columnas de
	 * la tabla)
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-07 17:00:18
	 */
	protected function clear () {
		$this->id = null;
		$this->nombre = null;
		$this->usuario = null;
		$this->email = null;
		$this->contrasenia = null;
		$this->hash = null;
		$this->activo = null;
		$this->ultimo_ingreso_fecha_hora = null;
		$this->ultimo_ingreso_desde = null;
		$this->ultimo_ingreso_hash = null;
	}
	
	/**
	 * Método para obtener los atributos del objeto, esto es cada una
	 * de las columnas que representan al objeto en la base de datos
	 */
	public function get () {
		// solo se recuperan los datos si se seteo la PK
		if(!empty($this->id)) {
			// obtener columnas desde la base de datos
			$datos = $this->db->getRow("
				SELECT *
				FROM usuario
				WHERE id = '".$this->db->sanitize($this->id)."'
			");
			// si se encontraron datos asignar columnas a los atributos
			// del objeto
			if(count($datos)) {
				foreach($datos as $key => &$value) {
					$this->{$key} = $value;
				}
			}
			// si no se encontraron limpiar atributos
			else {
				$this->clear();
			}
			// eliminar variable datos
			unset($datos);
		}
	}
	
	/**
	 * Método para determinar si el objeto existe en la base de datos
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-07 17:00:18
	 */
	public function exists () {
		// solo se ejecuta si la PK existe seteada
		if(!empty($this->id)) {
			return (boolean) $this->db->getValue("
				SELECT COUNT(*) FROM usuario
				WHERE id = '".$this->db->sanitize($this->id)."'
			");
		} else {
			return false;
		}
	}

	/**
	 * Método para borrar el objeto de la base de datos
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-07 17:00:18
	 */
	public function delete () {
		$this->db->transaction();
		if(!$this->beforeDelete()) { $this->db->rollback(); return false; }
		$this->db->query("
			DELETE FROM usuario
			WHERE id = '".$this->db->sanitize($this->id)."'
		");
		if(!$this->afterDelete()) { $this->db->rollback(); return false; }
		$this->db->commit();
		return true;
	}

	/**
	 * Método para insertar el objeto en la base de datos
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-07 17:00:18
	 */
	protected function insert () {
		$this->db->transaction();
		if(!$this->beforeInsert()) { $this->db->rollback(); return false; }
		$this->db->query("
			INSERT INTO usuario (
				nombre,
				usuario,
				email,
				contrasenia,
				hash,
				activo,
				ultimo_ingreso_fecha_hora,
				ultimo_ingreso_desde,
				ultimo_ingreso_hash
			) VALUES (
				".(!empty($this->nombre) || $this->nombre=='0' ? "'".$this->db->sanitize($this->nombre)."'" : 'NULL').",
				".(!empty($this->usuario) || $this->usuario=='0' ? "'".$this->db->sanitize($this->usuario)."'" : 'NULL').",
				".(!empty($this->email) || $this->email=='0' ? "'".$this->db->sanitize($this->email)."'" : 'NULL').",
				".(!empty($this->contrasenia) || $this->contrasenia=='0' ? "'".$this->db->sanitize($this->contrasenia)."'" : 'NULL').",
				".(!empty($this->hash) || $this->hash=='0' ? "'".$this->db->sanitize($this->hash)."'" : 'NULL').",
				".(!empty($this->activo) || $this->activo=='0' ? "'".$this->db->sanitize($this->activo)."'" : 'NULL').",
				".(!empty($this->ultimo_ingreso_fecha_hora) || $this->ultimo_ingreso_fecha_hora=='0' ? "'".$this->db->sanitize($this->ultimo_ingreso_fecha_hora)."'" : 'NULL').",
				".(!empty($this->ultimo_ingreso_desde) || $this->ultimo_ingreso_desde=='0' ? "'".$this->db->sanitize($this->ultimo_ingreso_desde)."'" : 'NULL').",
				".(!empty($this->ultimo_ingreso_hash) || $this->ultimo_ingreso_hash=='0' ? "'".$this->db->sanitize($this->ultimo_ingreso_hash)."'" : 'NULL')."
			)
		");
		if(!$this->afterInsert()) { $this->db->rollback(); return false; }
		$this->db->commit();
		return true;
	}

	/**
	 * Método para actualizar el objeto en la base de datos
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-07 17:00:18
	 */
	protected function update () {
		$this->db->transaction();
		if(!$this->beforeUpdate()) { $this->db->rollback(); return false; }
		$this->db->query("
			UPDATE usuario SET
				nombre = ".(!empty($this->nombre) || $this->nombre=='0' ? "'".$this->db->sanitize($this->nombre)."'" : 'NULL').",
				usuario = ".(!empty($this->usuario) || $this->usuario=='0' ? "'".$this->db->sanitize($this->usuario)."'" : 'NULL').",
				email = ".(!empty($this->email) || $this->email=='0' ? "'".$this->db->sanitize($this->email)."'" : 'NULL').",
				contrasenia = ".(!empty($this->contrasenia) || $this->contrasenia=='0' ? "'".$this->db->sanitize($this->contrasenia)."'" : 'NULL').",
				hash = ".(!empty($this->hash) || $this->hash=='0' ? "'".$this->db->sanitize($this->hash)."'" : 'NULL').",
				activo = ".(!empty($this->activo) || $this->activo=='0' ? "'".$this->db->sanitize($this->activo)."'" : 'NULL').",
				ultimo_ingreso_fecha_hora = ".(!empty($this->ultimo_ingreso_fecha_hora) || $this->ultimo_ingreso_fecha_hora=='0' ? "'".$this->db->sanitize($this->ultimo_ingreso_fecha_hora)."'" : 'NULL').",
				ultimo_ingreso_desde = ".(!empty($this->ultimo_ingreso_desde) || $this->ultimo_ingreso_desde=='0' ? "'".$this->db->sanitize($this->ultimo_ingreso_desde)."'" : 'NULL').",
				ultimo_ingreso_hash = ".(!empty($this->ultimo_ingreso_hash) || $this->ultimo_ingreso_hash=='0' ? "'".$this->db->sanitize($this->ultimo_ingreso_hash)."'" : 'NULL')."
			WHERE
				id = '".$this->db->sanitize($this->id)."'
		");
		if(!$this->afterUpdate()) { $this->db->rollback(); return false; }
		$this->db->commit();
		return true;
	}



	/**
	 * Método que guarda un archivo en la base de datos
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-07 17:00:18
	 */
	public function saveFile ($name, $file) {
		$this->db->transaction();
		if(!$this->beforeUpdate()) { $this->db->rollback(); return false; }
		if(get_class($this->db)=='PostgreSQL')
			$file['data'] = pg_escape_bytea($file['data']);
		else
			$file['data'] = $this->db->sanitize($file['data']);
		$name = $this->db->sanitize($name);
		$this->db->query("
			UPDATE usuario
			SET
				${name}_data = '".$file['data']."'
				, ${name}_name = '".$this->db->sanitize($file['name'])."'
				, ${name}_type = '".$this->db->sanitize($file['type'])."'
				, ${name}_size = ".(integer)$this->db->sanitize($file['size'])."
			WHERE
				id = '".$this->db->sanitize($this->id)."'
		");
		if(!$this->afterUpdate()) { $this->db->rollback(); return false; }
		$this->db->commit();
		return true;
	}

}

/**
 * Clase abstracta para mapear la tabla usuario de la base de datos
 * Usuarios de la aplicación
 * Esta clase permite trabajar sobre un conjunto de registros de la tabla usuario
 * @author MiPaGiNa Code Generator
 * @version 2014-02-07 17:00:18
 */
abstract class UsuariosBase extends AppModels {
	
	/**
	 * Constructor de la clase abstracta
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-07 17:00:18
	 */
	public function __construct () {
		// asignar base de datos y tabla
		$this->_database = 'default';
		$this->_table = 'usuario';
		// ejecutar constructor de la clase padre
		parent::__construct();
	}

}
