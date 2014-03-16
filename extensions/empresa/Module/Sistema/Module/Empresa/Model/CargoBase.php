<?php

/**
 * MiPaGiNa (MP)
 * Copyright (C) 2014 Esteban De La Fuente Rubio (esteban[at]delaf.cl)
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
 * Clase abstracta para mapear la tabla cargo de la base de datos
 * Cargos de la empresa
 * Esta clase permite trabajar sobre un registro de la tabla cargo
 * @author MiPaGiNa Code Generator
 * @version 2014-03-08 14:09:23
 */
abstract class CargoBase extends AppModel {

	// Atributos de la clase (columnas en la base de datos)
	public $id; ///< Identificador del cargo: integer(32) NOT NULL DEFAULT 'nextval('cargo_id_seq'::regclass)' AUTO PK 
	public $cargo; ///< Nombre del cargo: character varying(30) NOT NULL DEFAULT '' 
	public $jefe; ///< Jefe o supervisor de este cargo. El cargo que está sobre este cargo.: integer(32) NULL DEFAULT '' FK:cargo.id
	public $area; ///< Área de la empresa en la que se desempeña este cargo: integer(32) NULL DEFAULT '' FK:area.id

	// Información de las columnas de la tabla en la base de datos
	public static $columnsInfo = array(
		'id' => array(
			'name' => 'Id',
			'comment' => 'Identificador del cargo',
			'type' => 'integer',
			'length' => 32,
			'null' => false,
			'default' => "nextval('cargo_id_seq'::regclass)",
			'auto' => true,
			'pk' => true,
			'fk' => null
		),
		'cargo' => array(
			'name' => 'Cargo',
			'comment' => 'Nombre del cargo',
			'type' => 'character varying',
			'length' => 30,
			'null' => false,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'jefe' => array(
			'name' => 'Jefe',
			'comment' => 'Jefe o supervisor de este cargo. El cargo que está sobre este cargo.',
			'type' => 'integer',
			'length' => 32,
			'null' => true,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => array('table' => 'cargo', 'column' => 'id')
		),
		'area' => array(
			'name' => 'Area',
			'comment' => 'Área de la empresa en la que se desempeña este cargo',
			'type' => 'integer',
			'length' => 32,
			'null' => true,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => array('table' => 'area', 'column' => 'id')
		),

	);

	public static $fkModule; ///< Modelos utilizados (se asigna en Cargo)
	
	/**
	 * Constructor de la clase abstracta
	 * @author MiPaGiNa Code Generator
	 * @version 2014-03-08 14:09:23
	 */
	public function __construct ($id = null) {
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
	 * @version 2014-03-08 14:09:23
	 */
	protected function clear () {
		$this->id = null;
		$this->cargo = null;
		$this->jefe = null;
		$this->area = null;
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
				FROM cargo
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
	 * @version 2014-03-08 14:09:23
	 */
	public function exists () {
		// solo se ejecuta si la PK existe seteada
		if(!empty($this->id)) {
			return (boolean) $this->db->getValue("
				SELECT COUNT(*) FROM cargo
				WHERE id = '".$this->db->sanitize($this->id)."'
			");
		} else {
			return false;
		}
	}

	/**
	 * Método para borrar el objeto de la base de datos
	 * @author MiPaGiNa Code Generator
	 * @version 2014-03-08 14:09:23
	 */
	public function delete () {
		$this->db->transaction();
		if(!$this->beforeDelete()) { $this->db->rollback(); return false; }
		$this->db->query("
			DELETE FROM cargo
			WHERE id = '".$this->db->sanitize($this->id)."'
		");
		if(!$this->afterDelete()) { $this->db->rollback(); return false; }
		$this->db->commit();
		return true;
	}

	/**
	 * Método para insertar el objeto en la base de datos
	 * @author MiPaGiNa Code Generator
	 * @version 2014-03-08 14:09:23
	 */
	protected function insert () {
		$this->db->transaction();
		if(!$this->beforeInsert()) { $this->db->rollback(); return false; }
		$this->db->query("
			INSERT INTO cargo (
				cargo,
				jefe,
				area
			) VALUES (
				".(!empty($this->cargo) || $this->cargo=='0' ? "'".$this->db->sanitize($this->cargo)."'" : 'NULL').",
				".(!empty($this->jefe) || $this->jefe=='0' ? "'".$this->db->sanitize($this->jefe)."'" : 'NULL').",
				".(!empty($this->area) || $this->area=='0' ? "'".$this->db->sanitize($this->area)."'" : 'NULL')."
			)
		");
		if(!$this->afterInsert()) { $this->db->rollback(); return false; }
		$this->db->commit();
		return true;
	}

	/**
	 * Método para actualizar el objeto en la base de datos
	 * @author MiPaGiNa Code Generator
	 * @version 2014-03-08 14:09:23
	 */
	protected function update () {
		$this->db->transaction();
		if(!$this->beforeUpdate()) { $this->db->rollback(); return false; }
		$this->db->query("
			UPDATE cargo SET
				cargo = ".(!empty($this->cargo) || $this->cargo=='0' ? "'".$this->db->sanitize($this->cargo)."'" : 'NULL').",
				jefe = ".(!empty($this->jefe) || $this->jefe=='0' ? "'".$this->db->sanitize($this->jefe)."'" : 'NULL').",
				area = ".(!empty($this->area) || $this->area=='0' ? "'".$this->db->sanitize($this->area)."'" : 'NULL')."
			WHERE
				id = '".$this->db->sanitize($this->id)."'
		");
		if(!$this->afterUpdate()) { $this->db->rollback(); return false; }
		$this->db->commit();
		return true;
	}

	/**
	 * Recupera un objeto de tipo Cargo asociado al objeto Cargo
	 * @return Cargo Objeto de tipo Cargo con datos seteados o null en caso de que no existe la asociación
	 * @author MiPaGiNa Code Generator
	 * @version 2014-03-08 14:09:23
	 */
	public function getJefe () {
		App::uses('Cargo', Cargo::$fkModule['Cargo'].'Model');
		$Cargo = new Cargo($this->jefe);
		if($Cargo->exists()) {
			return $Cargo;
		}
		return null;
	}

	/**
	 * Recupera un objeto de tipo Area asociado al objeto Cargo
	 * @return Area Objeto de tipo Area con datos seteados o null en caso de que no existe la asociación
	 * @author MiPaGiNa Code Generator
	 * @version 2014-03-08 14:09:23
	 */
	public function getArea () {
		App::uses('Area', Cargo::$fkModule['Area'].'Model');
		$Area = new Area($this->area);
		if($Area->exists()) {
			return $Area;
		}
		return null;
	}


	/**
	 * Método que guarda un archivo en la base de datos
	 * @author MiPaGiNa Code Generator
	 * @version 2014-03-08 14:09:23
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
			UPDATE cargo
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
 * Clase abstracta para mapear la tabla cargo de la base de datos
 * Cargos de la empresa
 * Esta clase permite trabajar sobre un conjunto de registros de la tabla cargo
 * @author MiPaGiNa Code Generator
 * @version 2014-03-08 14:09:23
 */
abstract class CargosBase extends AppModels {
}
