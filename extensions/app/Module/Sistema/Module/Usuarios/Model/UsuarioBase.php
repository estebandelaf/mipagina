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
 * Tabla para usuarios del sistema
 * Esta clase permite trabajar sobre un registro de la tabla usuario
 * @author MiPaGiNa Code Generator
 * @version 2013-07-01 01:49:02
 */
abstract class UsuarioBase extends AppModel {

	// Atributos de la clase (columnas en la base de datos)
	public $id; ///< Identificador del usuario: integer(32) NOT NULL DEFAULT 'nextval('usuario_id_seq'::regclass)' AUTO PK 
	public $persona; ///< RUN de la persona asociada al usuario: integer(32) NOT NULL DEFAULT '' FK:persona.run
	public $usuario; ///< Nombre único para identificar al usuario: character varying(20) NOT NULL DEFAULT '' 
	public $contrasenia; ///< Contraseña encriptada utilizando SHA256: character(64) NULL DEFAULT '' 
	public $activo; ///< Indica si el grupo está o no activo en el sistema: date() NOT NULL DEFAULT '2099-12-31' 

	// Información de las columnas de la tabla en la base de datos
	public static $columnsInfo = array(
		'id' => array(
			'name' => 'Id',
			'comment' => 'Identificador del usuario',
			'type' => 'integer',
			'length' => 32,
			'null' => false,
			'default' => "nextval('usuario_id_seq'::regclass)",
			'auto' => true,
			'pk' => true,
			'fk' => null
		),
		'persona' => array(
			'name' => 'Persona',
			'comment' => 'RUN de la persona asociada al usuario',
			'type' => 'integer',
			'length' => 32,
			'null' => false,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => array('table' => 'persona', 'column' => 'run')
		),
		'usuario' => array(
			'name' => 'Usuario',
			'comment' => 'Nombre único para identificar al usuario',
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
			'comment' => 'Contraseña encriptada utilizando SHA256',
			'type' => 'character',
			'length' => 64,
			'null' => true,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'activo' => array(
			'name' => 'Activo',
			'comment' => 'Indica si el grupo está o no activo en el sistema',
			'type' => 'date',
			'length' => null,
			'null' => false,
			'default' => "2099-12-31",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),

	);
	
	/**
	 * Constructor de la clase abstracta
	 * @author MiPaGiNa Code Generator
	 * @version 2013-07-01 01:49:02
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
	 * @version 2013-07-01 01:49:02
	 */
	protected function clear () {
		$this->id = null;
		$this->persona = null;
		$this->usuario = null;
		$this->contrasenia = null;
		$this->activo = null;
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
	 * Setea los atributos del objeto UsuarioModel mediante un arreglo,
	 * la key del arreglo es el nombre del atributo, si la key no existe
	 * el campo quedará seteado a null
	 * @param array Array Arreglo con la relacion columna=>valor
	 * @param clear Boolean Verdadero para limpiar atributos antes de hacer el set
	 * @author MiPaGiNa Code Generator
	 * @version 2013-07-01 01:49:02
	 */
	public function set ($array) {
		// asignar atributos con los valores del arreglo
		if(isset($array['id']))
			$this->id = $array['id'];
		if(isset($array['persona']))
			$this->persona = $array['persona'];
		if(isset($array['usuario']))
			$this->usuario = $array['usuario'];
		if(isset($array['contrasenia']))
			$this->contrasenia = $array['contrasenia'];
		if(isset($array['activo']))
			$this->activo = $array['activo'];
	}
	
	/**
	 * Método para determinar si el objeto existe en la base de datos
	 * @author MiPaGiNa Code Generator
	 * @version 2013-07-01 01:49:02
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
	 * @version 2013-07-01 01:49:02
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
	 * @version 2013-07-01 01:49:02
	 */
	protected function insert () {
		$this->db->transaction();
		if(!$this->beforeInsert()) { $this->db->rollback(); return false; }
		$this->db->query("
			INSERT INTO usuario (
				persona,
				usuario,
				contrasenia,
				activo
			) VALUES (
				".(!empty($this->persona) || $this->persona=='0' ? "'".$this->db->sanitize($this->persona)."'" : 'NULL').",
				".(!empty($this->usuario) || $this->usuario=='0' ? "'".$this->db->sanitize($this->usuario)."'" : 'NULL').",
				".(!empty($this->contrasenia) || $this->contrasenia=='0' ? "'".$this->db->sanitize($this->contrasenia)."'" : 'NULL').",
				".(!empty($this->activo) || $this->activo=='0' ? "'".$this->db->sanitize($this->activo)."'" : 'NULL')."
			)
		");
		if(!$this->afterInsert()) { $this->db->rollback(); return false; }
		$this->db->commit();
		return true;
	}

	/**
	 * Método para actualizar el objeto en la base de datos
	 * @author MiPaGiNa Code Generator
	 * @version 2013-07-01 01:49:02
	 */
	protected function update () {
		$this->db->transaction();
		if(!$this->beforeUpdate()) { $this->db->rollback(); return false; }
		$this->db->query("
			UPDATE usuario SET
				persona = ".(!empty($this->persona) || $this->persona=='0' ? "'".$this->db->sanitize($this->persona)."'" : 'NULL').",
				usuario = ".(!empty($this->usuario) || $this->usuario=='0' ? "'".$this->db->sanitize($this->usuario)."'" : 'NULL').",
				contrasenia = ".(!empty($this->contrasenia) || $this->contrasenia=='0' ? "'".$this->db->sanitize($this->contrasenia)."'" : 'NULL').",
				activo = ".(!empty($this->activo) || $this->activo=='0' ? "'".$this->db->sanitize($this->activo)."'" : 'NULL')."
			WHERE
				id = '".$this->db->sanitize($this->id)."'
		");
		if(!$this->afterUpdate()) { $this->db->rollback(); return false; }
		$this->db->commit();
		return true;
	}

	/**
	 * Recupera un objeto de tipo Persona asociado al objeto Usuario
	 * @return Persona Objeto de tipo Persona con datos seteados o null en caso de que no existe la asociación
	 * @author MiPaGiNa Code Generator
	 * @version 2013-07-01 01:49:02
	 */
	public function getPersona () {
		App::uses('Persona', $this->fkModule['Persona'].'Model');
		$Persona = new Persona($this->persona);
		if($Persona->exists()) {
			return $Persona;
		}
		return null;
	}


	/**
	 * Método que guarda un archivo en la base de datos
	 * @author MiPaGiNa Code Generator
	 * @version 2013-07-01 01:49:02
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
 * Tabla para usuarios del sistema
 * Esta clase permite trabajar sobre un conjunto de registros de la tabla usuario
 * @author MiPaGiNa Code Generator
 * @version 2013-07-01 01:49:02
 */
abstract class UsuariosBase extends AppModels {
	
	/**
	 * Constructor de la clase abstracta
	 * @author MiPaGiNa Code Generator
	 * @version 2013-07-01 01:49:02
	 */
	public function __construct () {
		// asignar base de datos y tabla
		$this->_database = 'default';
		$this->_table = 'usuario';
		// ejecutar constructor de la clase padre
		parent::__construct();
	}

}
