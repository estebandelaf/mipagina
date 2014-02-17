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
 * Clase abstracta para mapear la tabla usuario_grupo de la base de datos
 * Relación entre usuarios y los grupos a los que pertenecen
 * Esta clase permite trabajar sobre un registro de la tabla usuario_grupo
 * @author MiPaGiNa Code Generator
 * @version 2014-02-16 17:36:25
 */
abstract class UsuarioGrupoBase extends AppModel {

	// Atributos de la clase (columnas en la base de datos)
	public $usuario; ///< Usuario de la aplicación: integer(32) NOT NULL DEFAULT '' PK FK:usuario.id
	public $grupo; ///< Grupo al que pertenece el usuario: integer(32) NOT NULL DEFAULT '' PK FK:grupo.id
	public $primario; ///< Indica si el grupo es el grupo primario del usuario: boolean() NOT NULL DEFAULT 'false' 

	// Información de las columnas de la tabla en la base de datos
	public static $columnsInfo = array(
		'usuario' => array(
			'name' => 'Usuario',
			'comment' => 'Usuario de la aplicación',
			'type' => 'integer',
			'length' => 32,
			'null' => false,
			'default' => "",
			'auto' => false,
			'pk' => true,
			'fk' => array('table' => 'usuario', 'column' => 'id')
		),
		'grupo' => array(
			'name' => 'Grupo',
			'comment' => 'Grupo al que pertenece el usuario',
			'type' => 'integer',
			'length' => 32,
			'null' => false,
			'default' => "",
			'auto' => false,
			'pk' => true,
			'fk' => array('table' => 'grupo', 'column' => 'id')
		),
		'primario' => array(
			'name' => 'Primario',
			'comment' => 'Indica si el grupo es el grupo primario del usuario',
			'type' => 'boolean',
			'length' => null,
			'null' => false,
			'default' => "false",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),

	);

	public static $fkModule; ///< Modelos utilizados (se asigna en UsuarioGrupo)
	
	/**
	 * Constructor de la clase abstracta
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-16 17:36:25
	 */
	public function __construct ($usuario = null, $grupo = null) {
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
				$this->usuario = $usuario;
				$this->grupo = $grupo;
			}
		}
		// obtener otros atributos del objeto
		$this->get();
	}
	
	/**
	 * Setea a null los atributos de la clase (los que sean columnas de
	 * la tabla)
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-16 17:36:25
	 */
	protected function clear () {
		$this->usuario = null;
		$this->grupo = null;
		$this->primario = null;
	}
	
	/**
	 * Método para obtener los atributos del objeto, esto es cada una
	 * de las columnas que representan al objeto en la base de datos
	 */
	public function get () {
		// solo se recuperan los datos si se seteo la PK
		if(!empty($this->usuario) && !empty($this->grupo)) {
			// obtener columnas desde la base de datos
			$datos = $this->db->getRow("
				SELECT *
				FROM usuario_grupo
				WHERE usuario = '".$this->db->sanitize($this->usuario)."' AND grupo = '".$this->db->sanitize($this->grupo)."'
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
	 * @version 2014-02-16 17:36:25
	 */
	public function exists () {
		// solo se ejecuta si la PK existe seteada
		if(!empty($this->usuario) && !empty($this->grupo)) {
			return (boolean) $this->db->getValue("
				SELECT COUNT(*) FROM usuario_grupo
				WHERE usuario = '".$this->db->sanitize($this->usuario)."' AND grupo = '".$this->db->sanitize($this->grupo)."'
			");
		} else {
			return false;
		}
	}

	/**
	 * Método para borrar el objeto de la base de datos
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-16 17:36:25
	 */
	public function delete () {
		$this->db->transaction();
		if(!$this->beforeDelete()) { $this->db->rollback(); return false; }
		$this->db->query("
			DELETE FROM usuario_grupo
			WHERE usuario = '".$this->db->sanitize($this->usuario)."' AND grupo = '".$this->db->sanitize($this->grupo)."'
		");
		if(!$this->afterDelete()) { $this->db->rollback(); return false; }
		$this->db->commit();
		return true;
	}

	/**
	 * Método para insertar el objeto en la base de datos
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-16 17:36:25
	 */
	protected function insert () {
		$this->db->transaction();
		if(!$this->beforeInsert()) { $this->db->rollback(); return false; }
		$this->db->query("
			INSERT INTO usuario_grupo (
				usuario,
				grupo,
				primario
			) VALUES (
				".(!empty($this->usuario) || $this->usuario=='0' ? "'".$this->db->sanitize($this->usuario)."'" : 'NULL').",
				".(!empty($this->grupo) || $this->grupo=='0' ? "'".$this->db->sanitize($this->grupo)."'" : 'NULL').",
				".(!empty($this->primario) || $this->primario=='0' ? "'".$this->db->sanitize($this->primario)."'" : 'NULL')."
			)
		");
		if(!$this->afterInsert()) { $this->db->rollback(); return false; }
		$this->db->commit();
		return true;
	}

	/**
	 * Método para actualizar el objeto en la base de datos
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-16 17:36:25
	 */
	protected function update () {
		$this->db->transaction();
		if(!$this->beforeUpdate()) { $this->db->rollback(); return false; }
		$this->db->query("
			UPDATE usuario_grupo SET
				primario = ".(!empty($this->primario) || $this->primario=='0' ? "'".$this->db->sanitize($this->primario)."'" : 'NULL')."
			WHERE
				usuario = '".$this->db->sanitize($this->usuario)."' AND grupo = '".$this->db->sanitize($this->grupo)."'
		");
		if(!$this->afterUpdate()) { $this->db->rollback(); return false; }
		$this->db->commit();
		return true;
	}

	/**
	 * Recupera un objeto de tipo Usuario asociado al objeto UsuarioGrupo
	 * @return Usuario Objeto de tipo Usuario con datos seteados o null en caso de que no existe la asociación
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-16 17:36:25
	 */
	public function getUsuario () {
		App::uses('Usuario', UsuarioGrupo::$fkModule['Usuario'].'Model');
		$Usuario = new Usuario($this->usuario);
		if($Usuario->exists()) {
			return $Usuario;
		}
		return null;
	}

	/**
	 * Recupera un objeto de tipo Grupo asociado al objeto UsuarioGrupo
	 * @return Grupo Objeto de tipo Grupo con datos seteados o null en caso de que no existe la asociación
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-16 17:36:25
	 */
	public function getGrupo () {
		App::uses('Grupo', UsuarioGrupo::$fkModule['Grupo'].'Model');
		$Grupo = new Grupo($this->grupo);
		if($Grupo->exists()) {
			return $Grupo;
		}
		return null;
	}


	/**
	 * Método que guarda un archivo en la base de datos
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-16 17:36:25
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
			UPDATE usuario_grupo
			SET
				${name}_data = '".$file['data']."'
				, ${name}_name = '".$this->db->sanitize($file['name'])."'
				, ${name}_type = '".$this->db->sanitize($file['type'])."'
				, ${name}_size = ".(integer)$this->db->sanitize($file['size'])."
			WHERE
				usuario = '".$this->db->sanitize($this->usuario)."' AND grupo = '".$this->db->sanitize($this->grupo)."'
		");
		if(!$this->afterUpdate()) { $this->db->rollback(); return false; }
		$this->db->commit();
		return true;
	}

}

/**
 * Clase abstracta para mapear la tabla usuario_grupo de la base de datos
 * Relación entre usuarios y los grupos a los que pertenecen
 * Esta clase permite trabajar sobre un conjunto de registros de la tabla usuario_grupo
 * @author MiPaGiNa Code Generator
 * @version 2014-02-16 17:36:25
 */
abstract class UsuarioGruposBase extends AppModels {
}
