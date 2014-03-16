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
 * Clase abstracta para mapear la tabla cliente de la base de datos
 * Listado de clientes de la empresa
 * Esta clase permite trabajar sobre un registro de la tabla cliente
 * @author MiPaGiNa Code Generator
 * @version 2014-03-08 14:06:34
 */
abstract class ClienteBase extends AppModel {

	// Atributos de la clase (columnas en la base de datos)
	public $rut; ///< RUT del cliente, sin puntos ni dígito verificador: integer(32) NOT NULL DEFAULT '' PK 
	public $dv; ///< Dígito verificador del rut: character(1) NOT NULL DEFAULT '' 
	public $razon_social; ///< Nombre o razón social: character varying(60) NOT NULL DEFAULT '' 
	public $actividad_economica; ///< Actividad económica o bien nulo si es Particular: integer(32) NULL DEFAULT '' FK:actividad_economica.codigo
	public $email; ///< Correo electrónico principal de contacto: character varying(50) NULL DEFAULT '' 
	public $telefono; ///< Teléfono principal de contacto: character varying(20) NULL DEFAULT '' 
	public $direccion; ///< Dirección de la casa matriz: character varying(100) NULL DEFAULT '' 
	public $comuna; ///< Comuna de la casa matriz: character(5) NULL DEFAULT '' FK:comuna.codigo
	public $contrasenia; ///< Contraseña para acceder a servicios de la aplicación: character(64) NULL DEFAULT '' 

	// Información de las columnas de la tabla en la base de datos
	public static $columnsInfo = array(
		'rut' => array(
			'name' => 'Rut',
			'comment' => 'RUT del cliente, sin puntos ni dígito verificador',
			'type' => 'integer',
			'length' => 32,
			'null' => false,
			'default' => "",
			'auto' => false,
			'pk' => true,
			'fk' => null
		),
		'dv' => array(
			'name' => 'Dv',
			'comment' => 'Dígito verificador del rut',
			'type' => 'character',
			'length' => 1,
			'null' => false,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'razon_social' => array(
			'name' => 'Razon Social',
			'comment' => 'Nombre o razón social',
			'type' => 'character varying',
			'length' => 60,
			'null' => false,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'actividad_economica' => array(
			'name' => 'Actividad Economica',
			'comment' => 'Actividad económica o bien nulo si es Particular',
			'type' => 'integer',
			'length' => 32,
			'null' => true,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => array('table' => 'actividad_economica', 'column' => 'codigo')
		),
		'email' => array(
			'name' => 'Email',
			'comment' => 'Correo electrónico principal de contacto',
			'type' => 'character varying',
			'length' => 50,
			'null' => true,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'telefono' => array(
			'name' => 'Telefono',
			'comment' => 'Teléfono principal de contacto',
			'type' => 'character varying',
			'length' => 20,
			'null' => true,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'direccion' => array(
			'name' => 'Direccion',
			'comment' => 'Dirección de la casa matriz',
			'type' => 'character varying',
			'length' => 100,
			'null' => true,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'comuna' => array(
			'name' => 'Comuna',
			'comment' => 'Comuna de la casa matriz',
			'type' => 'character',
			'length' => 5,
			'null' => true,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => array('table' => 'comuna', 'column' => 'codigo')
		),
		'contrasenia' => array(
			'name' => 'Contrasenia',
			'comment' => 'Contraseña para acceder a servicios de la aplicación',
			'type' => 'character',
			'length' => 64,
			'null' => true,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),

	);

	public static $fkModule; ///< Modelos utilizados (se asigna en Cliente)
	
	/**
	 * Constructor de la clase abstracta
	 * @author MiPaGiNa Code Generator
	 * @version 2014-03-08 14:06:34
	 */
	public function __construct ($rut = null) {
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
				$this->rut = $rut;
			}
		}
		// obtener otros atributos del objeto
		$this->get();
	}
	
	/**
	 * Setea a null los atributos de la clase (los que sean columnas de
	 * la tabla)
	 * @author MiPaGiNa Code Generator
	 * @version 2014-03-08 14:06:34
	 */
	protected function clear () {
		$this->rut = null;
		$this->dv = null;
		$this->razon_social = null;
		$this->actividad_economica = null;
		$this->email = null;
		$this->telefono = null;
		$this->direccion = null;
		$this->comuna = null;
		$this->contrasenia = null;
	}
	
	/**
	 * Método para obtener los atributos del objeto, esto es cada una
	 * de las columnas que representan al objeto en la base de datos
	 */
	public function get () {
		// solo se recuperan los datos si se seteo la PK
		if(!empty($this->rut)) {
			// obtener columnas desde la base de datos
			$datos = $this->db->getRow("
				SELECT *
				FROM cliente
				WHERE rut = '".$this->db->sanitize($this->rut)."'
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
	 * @version 2014-03-08 14:06:34
	 */
	public function exists () {
		// solo se ejecuta si la PK existe seteada
		if(!empty($this->rut)) {
			return (boolean) $this->db->getValue("
				SELECT COUNT(*) FROM cliente
				WHERE rut = '".$this->db->sanitize($this->rut)."'
			");
		} else {
			return false;
		}
	}

	/**
	 * Método para borrar el objeto de la base de datos
	 * @author MiPaGiNa Code Generator
	 * @version 2014-03-08 14:06:34
	 */
	public function delete () {
		$this->db->transaction();
		if(!$this->beforeDelete()) { $this->db->rollback(); return false; }
		$this->db->query("
			DELETE FROM cliente
			WHERE rut = '".$this->db->sanitize($this->rut)."'
		");
		if(!$this->afterDelete()) { $this->db->rollback(); return false; }
		$this->db->commit();
		return true;
	}

	/**
	 * Método para insertar el objeto en la base de datos
	 * @author MiPaGiNa Code Generator
	 * @version 2014-03-08 14:06:34
	 */
	protected function insert () {
		$this->db->transaction();
		if(!$this->beforeInsert()) { $this->db->rollback(); return false; }
		$this->db->query("
			INSERT INTO cliente (
				rut,
				dv,
				razon_social,
				actividad_economica,
				email,
				telefono,
				direccion,
				comuna,
				contrasenia
			) VALUES (
				".(!empty($this->rut) || $this->rut=='0' ? "'".$this->db->sanitize($this->rut)."'" : 'NULL').",
				".(!empty($this->dv) || $this->dv=='0' ? "'".$this->db->sanitize($this->dv)."'" : 'NULL').",
				".(!empty($this->razon_social) || $this->razon_social=='0' ? "'".$this->db->sanitize($this->razon_social)."'" : 'NULL').",
				".(!empty($this->actividad_economica) || $this->actividad_economica=='0' ? "'".$this->db->sanitize($this->actividad_economica)."'" : 'NULL').",
				".(!empty($this->email) || $this->email=='0' ? "'".$this->db->sanitize($this->email)."'" : 'NULL').",
				".(!empty($this->telefono) || $this->telefono=='0' ? "'".$this->db->sanitize($this->telefono)."'" : 'NULL').",
				".(!empty($this->direccion) || $this->direccion=='0' ? "'".$this->db->sanitize($this->direccion)."'" : 'NULL').",
				".(!empty($this->comuna) || $this->comuna=='0' ? "'".$this->db->sanitize($this->comuna)."'" : 'NULL').",
				".(!empty($this->contrasenia) || $this->contrasenia=='0' ? "'".$this->db->sanitize($this->contrasenia)."'" : 'NULL')."
			)
		");
		if(!$this->afterInsert()) { $this->db->rollback(); return false; }
		$this->db->commit();
		return true;
	}

	/**
	 * Método para actualizar el objeto en la base de datos
	 * @author MiPaGiNa Code Generator
	 * @version 2014-03-08 14:06:34
	 */
	protected function update () {
		$this->db->transaction();
		if(!$this->beforeUpdate()) { $this->db->rollback(); return false; }
		$this->db->query("
			UPDATE cliente SET
				dv = ".(!empty($this->dv) || $this->dv=='0' ? "'".$this->db->sanitize($this->dv)."'" : 'NULL').",
				razon_social = ".(!empty($this->razon_social) || $this->razon_social=='0' ? "'".$this->db->sanitize($this->razon_social)."'" : 'NULL').",
				actividad_economica = ".(!empty($this->actividad_economica) || $this->actividad_economica=='0' ? "'".$this->db->sanitize($this->actividad_economica)."'" : 'NULL').",
				email = ".(!empty($this->email) || $this->email=='0' ? "'".$this->db->sanitize($this->email)."'" : 'NULL').",
				telefono = ".(!empty($this->telefono) || $this->telefono=='0' ? "'".$this->db->sanitize($this->telefono)."'" : 'NULL').",
				direccion = ".(!empty($this->direccion) || $this->direccion=='0' ? "'".$this->db->sanitize($this->direccion)."'" : 'NULL').",
				comuna = ".(!empty($this->comuna) || $this->comuna=='0' ? "'".$this->db->sanitize($this->comuna)."'" : 'NULL').",
				contrasenia = ".(!empty($this->contrasenia) || $this->contrasenia=='0' ? "'".$this->db->sanitize($this->contrasenia)."'" : 'NULL')."
			WHERE
				rut = '".$this->db->sanitize($this->rut)."'
		");
		if(!$this->afterUpdate()) { $this->db->rollback(); return false; }
		$this->db->commit();
		return true;
	}

	/**
	 * Recupera un objeto de tipo ActividadEconomica asociado al objeto Cliente
	 * @return ActividadEconomica Objeto de tipo ActividadEconomica con datos seteados o null en caso de que no existe la asociación
	 * @author MiPaGiNa Code Generator
	 * @version 2014-03-08 14:06:34
	 */
	public function getActividadEconomica () {
		App::uses('ActividadEconomica', Cliente::$fkModule['ActividadEconomica'].'Model');
		$ActividadEconomica = new ActividadEconomica($this->actividad_economica);
		if($ActividadEconomica->exists()) {
			return $ActividadEconomica;
		}
		return null;
	}

	/**
	 * Recupera un objeto de tipo Comuna asociado al objeto Cliente
	 * @return Comuna Objeto de tipo Comuna con datos seteados o null en caso de que no existe la asociación
	 * @author MiPaGiNa Code Generator
	 * @version 2014-03-08 14:06:34
	 */
	public function getComuna () {
		App::uses('Comuna', Cliente::$fkModule['Comuna'].'Model');
		$Comuna = new Comuna($this->comuna);
		if($Comuna->exists()) {
			return $Comuna;
		}
		return null;
	}


	/**
	 * Método que guarda un archivo en la base de datos
	 * @author MiPaGiNa Code Generator
	 * @version 2014-03-08 14:06:34
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
			UPDATE cliente
			SET
				${name}_data = '".$file['data']."'
				, ${name}_name = '".$this->db->sanitize($file['name'])."'
				, ${name}_type = '".$this->db->sanitize($file['type'])."'
				, ${name}_size = ".(integer)$this->db->sanitize($file['size'])."
			WHERE
				rut = '".$this->db->sanitize($this->rut)."'
		");
		if(!$this->afterUpdate()) { $this->db->rollback(); return false; }
		$this->db->commit();
		return true;
	}

}

/**
 * Clase abstracta para mapear la tabla cliente de la base de datos
 * Listado de clientes de la empresa
 * Esta clase permite trabajar sobre un conjunto de registros de la tabla cliente
 * @author MiPaGiNa Code Generator
 * @version 2014-03-08 14:06:34
 */
abstract class ClientesBase extends AppModels {
}
