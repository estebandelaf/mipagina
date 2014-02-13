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
 * Clase abstracta para mapear la tabla auth de la base de datos
 * Permisos de grupos para acceder a recursos
 * Esta clase permite trabajar sobre un registro de la tabla auth
 * @author MiPaGiNa Code Generator
 * @version 2014-02-13 19:41:02
 */
abstract class AuthBase extends AppModel {

	// Atributos de la clase (columnas en la base de datos)
	public $id; ///< Identificador (serial): integer(32) NOT NULL DEFAULT 'nextval('auth_id_seq'::regclass)' AUTO PK 
	public $grupo; ///< Grupo al que se le condede el permiso: integer(32) NOT NULL DEFAULT '' FK:grupo.id
	public $recurso; ///< Recurso al que el grupo tiene acceso: character varying(300) NULL DEFAULT '' 

	// Información de las columnas de la tabla en la base de datos
	public static $columnsInfo = array(
		'id' => array(
			'name' => 'Id',
			'comment' => 'Identificador (serial)',
			'type' => 'integer',
			'length' => 32,
			'null' => false,
			'default' => "nextval('auth_id_seq'::regclass)",
			'auto' => true,
			'pk' => true,
			'fk' => null
		),
		'grupo' => array(
			'name' => 'Grupo',
			'comment' => 'Grupo al que se le condede el permiso',
			'type' => 'integer',
			'length' => 32,
			'null' => false,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => array('table' => 'grupo', 'column' => 'id')
		),
		'recurso' => array(
			'name' => 'Recurso',
			'comment' => 'Recurso al que el grupo tiene acceso',
			'type' => 'character varying',
			'length' => 300,
			'null' => true,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),

	);

	public static $fkModule; ///< Modelos utilizados (se asigna en Auth)
	
	/**
	 * Constructor de la clase abstracta
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-13 19:41:02
	 */
	public function __construct ($id = null) {
		// asignar base de datos y tabla
		$this->_database = 'default';
		$this->_table = 'auth';
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
	 * @version 2014-02-13 19:41:02
	 */
	protected function clear () {
		$this->id = null;
		$this->grupo = null;
		$this->recurso = null;
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
				FROM auth
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
	 * @version 2014-02-13 19:41:02
	 */
	public function exists () {
		// solo se ejecuta si la PK existe seteada
		if(!empty($this->id)) {
			return (boolean) $this->db->getValue("
				SELECT COUNT(*) FROM auth
				WHERE id = '".$this->db->sanitize($this->id)."'
			");
		} else {
			return false;
		}
	}

	/**
	 * Método para borrar el objeto de la base de datos
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-13 19:41:02
	 */
	public function delete () {
		$this->db->transaction();
		if(!$this->beforeDelete()) { $this->db->rollback(); return false; }
		$this->db->query("
			DELETE FROM auth
			WHERE id = '".$this->db->sanitize($this->id)."'
		");
		if(!$this->afterDelete()) { $this->db->rollback(); return false; }
		$this->db->commit();
		return true;
	}

	/**
	 * Método para insertar el objeto en la base de datos
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-13 19:41:02
	 */
	protected function insert () {
		$this->db->transaction();
		if(!$this->beforeInsert()) { $this->db->rollback(); return false; }
		$this->db->query("
			INSERT INTO auth (
				grupo,
				recurso
			) VALUES (
				".(!empty($this->grupo) || $this->grupo=='0' ? "'".$this->db->sanitize($this->grupo)."'" : 'NULL').",
				".(!empty($this->recurso) || $this->recurso=='0' ? "'".$this->db->sanitize($this->recurso)."'" : 'NULL')."
			)
		");
		if(!$this->afterInsert()) { $this->db->rollback(); return false; }
		$this->db->commit();
		return true;
	}

	/**
	 * Método para actualizar el objeto en la base de datos
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-13 19:41:02
	 */
	protected function update () {
		$this->db->transaction();
		if(!$this->beforeUpdate()) { $this->db->rollback(); return false; }
		$this->db->query("
			UPDATE auth SET
				grupo = ".(!empty($this->grupo) || $this->grupo=='0' ? "'".$this->db->sanitize($this->grupo)."'" : 'NULL').",
				recurso = ".(!empty($this->recurso) || $this->recurso=='0' ? "'".$this->db->sanitize($this->recurso)."'" : 'NULL')."
			WHERE
				id = '".$this->db->sanitize($this->id)."'
		");
		if(!$this->afterUpdate()) { $this->db->rollback(); return false; }
		$this->db->commit();
		return true;
	}

	/**
	 * Recupera un objeto de tipo Grupo asociado al objeto Auth
	 * @return Grupo Objeto de tipo Grupo con datos seteados o null en caso de que no existe la asociación
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-13 19:41:02
	 */
	public function getGrupo () {
		App::uses('Grupo', Auth::$fkModule['Grupo'].'Model');
		$Grupo = new Grupo($this->grupo);
		if($Grupo->exists()) {
			return $Grupo;
		}
		return null;
	}


	/**
	 * Método que guarda un archivo en la base de datos
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-13 19:41:02
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
			UPDATE auth
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
 * Clase abstracta para mapear la tabla auth de la base de datos
 * Permisos de grupos para acceder a recursos
 * Esta clase permite trabajar sobre un conjunto de registros de la tabla auth
 * @author MiPaGiNa Code Generator
 * @version 2014-02-13 19:41:02
 */
abstract class AuthsBase extends AppModels {
	
	/**
	 * Constructor de la clase abstracta
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-13 19:41:02
	 */
	public function __construct () {
		// asignar base de datos y tabla
		$this->_database = 'default';
		$this->_table = 'auth';
		// ejecutar constructor de la clase padre
		parent::__construct();
	}

}
