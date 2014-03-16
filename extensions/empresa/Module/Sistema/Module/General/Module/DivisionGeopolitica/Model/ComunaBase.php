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
 * Clase abstracta para mapear la tabla comuna de la base de datos
 * Comunas de cada provincia del país
 * Esta clase permite trabajar sobre un registro de la tabla comuna
 * @author MiPaGiNa Code Generator
 * @version 2014-02-16 17:36:25
 */
abstract class ComunaBase extends AppModel {

	// Atributos de la clase (columnas en la base de datos)
	public $codigo; ///< Código de la comuna: character(5) NOT NULL DEFAULT '' PK 
	public $comuna; ///< Nombre de la comuna: character varying(40) NOT NULL DEFAULT '' 
	public $provincia; ///< Provincia a la que pertenece la comuna: character(3) NOT NULL DEFAULT '' FK:provincia.codigo

	// Información de las columnas de la tabla en la base de datos
	public static $columnsInfo = array(
		'codigo' => array(
			'name' => 'Codigo',
			'comment' => 'Código de la comuna',
			'type' => 'character',
			'length' => 5,
			'null' => false,
			'default' => "",
			'auto' => false,
			'pk' => true,
			'fk' => null
		),
		'comuna' => array(
			'name' => 'Comuna',
			'comment' => 'Nombre de la comuna',
			'type' => 'character varying',
			'length' => 40,
			'null' => false,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'provincia' => array(
			'name' => 'Provincia',
			'comment' => 'Provincia a la que pertenece la comuna',
			'type' => 'character',
			'length' => 3,
			'null' => false,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => array('table' => 'provincia', 'column' => 'codigo')
		),

	);

	public static $fkModule; ///< Modelos utilizados (se asigna en Comuna)
	
	/**
	 * Constructor de la clase abstracta
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-16 17:36:25
	 */
	public function __construct ($codigo = null) {
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
				$this->codigo = $codigo;
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
		$this->codigo = null;
		$this->comuna = null;
		$this->provincia = null;
	}
	
	/**
	 * Método para obtener los atributos del objeto, esto es cada una
	 * de las columnas que representan al objeto en la base de datos
	 */
	public function get () {
		// solo se recuperan los datos si se seteo la PK
		if(!empty($this->codigo)) {
			// obtener columnas desde la base de datos
			$datos = $this->db->getRow("
				SELECT *
				FROM comuna
				WHERE codigo = '".$this->db->sanitize($this->codigo)."'
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
		if(!empty($this->codigo)) {
			return (boolean) $this->db->getValue("
				SELECT COUNT(*) FROM comuna
				WHERE codigo = '".$this->db->sanitize($this->codigo)."'
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
			DELETE FROM comuna
			WHERE codigo = '".$this->db->sanitize($this->codigo)."'
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
			INSERT INTO comuna (
				codigo,
				comuna,
				provincia
			) VALUES (
				".(!empty($this->codigo) || $this->codigo=='0' ? "'".$this->db->sanitize($this->codigo)."'" : 'NULL').",
				".(!empty($this->comuna) || $this->comuna=='0' ? "'".$this->db->sanitize($this->comuna)."'" : 'NULL').",
				".(!empty($this->provincia) || $this->provincia=='0' ? "'".$this->db->sanitize($this->provincia)."'" : 'NULL')."
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
			UPDATE comuna SET
				comuna = ".(!empty($this->comuna) || $this->comuna=='0' ? "'".$this->db->sanitize($this->comuna)."'" : 'NULL').",
				provincia = ".(!empty($this->provincia) || $this->provincia=='0' ? "'".$this->db->sanitize($this->provincia)."'" : 'NULL')."
			WHERE
				codigo = '".$this->db->sanitize($this->codigo)."'
		");
		if(!$this->afterUpdate()) { $this->db->rollback(); return false; }
		$this->db->commit();
		return true;
	}

	/**
	 * Recupera un objeto de tipo Provincia asociado al objeto Comuna
	 * @return Provincia Objeto de tipo Provincia con datos seteados o null en caso de que no existe la asociación
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-16 17:36:25
	 */
	public function getProvincia () {
		App::uses('Provincia', Comuna::$fkModule['Provincia'].'Model');
		$Provincia = new Provincia($this->provincia);
		if($Provincia->exists()) {
			return $Provincia;
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
			UPDATE comuna
			SET
				${name}_data = '".$file['data']."'
				, ${name}_name = '".$this->db->sanitize($file['name'])."'
				, ${name}_type = '".$this->db->sanitize($file['type'])."'
				, ${name}_size = ".(integer)$this->db->sanitize($file['size'])."
			WHERE
				codigo = '".$this->db->sanitize($this->codigo)."'
		");
		if(!$this->afterUpdate()) { $this->db->rollback(); return false; }
		$this->db->commit();
		return true;
	}

}

/**
 * Clase abstracta para mapear la tabla comuna de la base de datos
 * Comunas de cada provincia del país
 * Esta clase permite trabajar sobre un conjunto de registros de la tabla comuna
 * @author MiPaGiNa Code Generator
 * @version 2014-02-16 17:36:25
 */
abstract class ComunasBase extends AppModels {
}
