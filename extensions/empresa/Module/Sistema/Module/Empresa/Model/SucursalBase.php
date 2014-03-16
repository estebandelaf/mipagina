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
 * Clase abstracta para mapear la tabla sucursal de la base de datos
 * Sucursales de la empresa
 * Esta clase permite trabajar sobre un registro de la tabla sucursal
 * @author MiPaGiNa Code Generator
 * @version 2014-03-08 14:09:23
 */
abstract class SucursalBase extends AppModel {

	// Atributos de la clase (columnas en la base de datos)
	public $id; ///< Identificador de la sucursal: integer(32) NOT NULL DEFAULT 'nextval('sucursal_id_seq'::regclass)' AUTO PK 
	public $codigo; ///< character varying(10) NULL DEFAULT '' 
	public $sucursal; ///< Nombre de la sucursal: character varying(30) NOT NULL DEFAULT '' 
	public $matriz; ///< Indica si la sucursal es la casa matriz: boolean() NOT NULL DEFAULT 'false' 
	public $email; ///< Correo electrónico principal de la sucursal: character varying(50) NULL DEFAULT '' 
	public $telefono; ///< Teléfono principal de la sucursal: character varying(20) NULL DEFAULT '' 
	public $fax; ///< Fax principal de la sucursal: character varying(20) NULL DEFAULT '' 
	public $direccion; ///< Dirección de la sucursal: character varying(100) NULL DEFAULT '' 
	public $comuna; ///< Comuna de la sucursal: character(5) NULL DEFAULT '' FK:comuna.codigo
	public $empleado; ///< Empleado a cargo de la sucursal: integer(32) NULL DEFAULT '' FK:empleado.run

	// Información de las columnas de la tabla en la base de datos
	public static $columnsInfo = array(
		'id' => array(
			'name' => 'Id',
			'comment' => 'Identificador de la sucursal',
			'type' => 'integer',
			'length' => 32,
			'null' => false,
			'default' => "nextval('sucursal_id_seq'::regclass)",
			'auto' => true,
			'pk' => true,
			'fk' => null
		),
		'codigo' => array(
			'name' => 'Codigo',
			'comment' => '',
			'type' => 'character varying',
			'length' => 10,
			'null' => true,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'sucursal' => array(
			'name' => 'Sucursal',
			'comment' => 'Nombre de la sucursal',
			'type' => 'character varying',
			'length' => 30,
			'null' => false,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'matriz' => array(
			'name' => 'Matriz',
			'comment' => 'Indica si la sucursal es la casa matriz',
			'type' => 'boolean',
			'length' => null,
			'null' => false,
			'default' => "false",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'email' => array(
			'name' => 'Email',
			'comment' => 'Correo electrónico principal de la sucursal',
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
			'comment' => 'Teléfono principal de la sucursal',
			'type' => 'character varying',
			'length' => 20,
			'null' => true,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'fax' => array(
			'name' => 'Fax',
			'comment' => 'Fax principal de la sucursal',
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
			'comment' => 'Dirección de la sucursal',
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
			'comment' => 'Comuna de la sucursal',
			'type' => 'character',
			'length' => 5,
			'null' => true,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => array('table' => 'comuna', 'column' => 'codigo')
		),
		'empleado' => array(
			'name' => 'Empleado',
			'comment' => 'Empleado a cargo de la sucursal',
			'type' => 'integer',
			'length' => 32,
			'null' => true,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => array('table' => 'empleado', 'column' => 'run')
		),

	);

	public static $fkModule; ///< Modelos utilizados (se asigna en Sucursal)
	
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
		$this->codigo = null;
		$this->sucursal = null;
		$this->matriz = null;
		$this->email = null;
		$this->telefono = null;
		$this->fax = null;
		$this->direccion = null;
		$this->comuna = null;
		$this->empleado = null;
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
				FROM sucursal
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
				SELECT COUNT(*) FROM sucursal
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
			DELETE FROM sucursal
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
			INSERT INTO sucursal (
				codigo,
				sucursal,
				matriz,
				email,
				telefono,
				fax,
				direccion,
				comuna,
				empleado
			) VALUES (
				".(!empty($this->codigo) || $this->codigo=='0' ? "'".$this->db->sanitize($this->codigo)."'" : 'NULL').",
				".(!empty($this->sucursal) || $this->sucursal=='0' ? "'".$this->db->sanitize($this->sucursal)."'" : 'NULL').",
				".(!empty($this->matriz) || $this->matriz=='0' ? "'".$this->db->sanitize($this->matriz)."'" : 'NULL').",
				".(!empty($this->email) || $this->email=='0' ? "'".$this->db->sanitize($this->email)."'" : 'NULL').",
				".(!empty($this->telefono) || $this->telefono=='0' ? "'".$this->db->sanitize($this->telefono)."'" : 'NULL').",
				".(!empty($this->fax) || $this->fax=='0' ? "'".$this->db->sanitize($this->fax)."'" : 'NULL').",
				".(!empty($this->direccion) || $this->direccion=='0' ? "'".$this->db->sanitize($this->direccion)."'" : 'NULL').",
				".(!empty($this->comuna) || $this->comuna=='0' ? "'".$this->db->sanitize($this->comuna)."'" : 'NULL').",
				".(!empty($this->empleado) || $this->empleado=='0' ? "'".$this->db->sanitize($this->empleado)."'" : 'NULL')."
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
			UPDATE sucursal SET
				codigo = ".(!empty($this->codigo) || $this->codigo=='0' ? "'".$this->db->sanitize($this->codigo)."'" : 'NULL').",
				sucursal = ".(!empty($this->sucursal) || $this->sucursal=='0' ? "'".$this->db->sanitize($this->sucursal)."'" : 'NULL').",
				matriz = ".(!empty($this->matriz) || $this->matriz=='0' ? "'".$this->db->sanitize($this->matriz)."'" : 'NULL').",
				email = ".(!empty($this->email) || $this->email=='0' ? "'".$this->db->sanitize($this->email)."'" : 'NULL').",
				telefono = ".(!empty($this->telefono) || $this->telefono=='0' ? "'".$this->db->sanitize($this->telefono)."'" : 'NULL').",
				fax = ".(!empty($this->fax) || $this->fax=='0' ? "'".$this->db->sanitize($this->fax)."'" : 'NULL').",
				direccion = ".(!empty($this->direccion) || $this->direccion=='0' ? "'".$this->db->sanitize($this->direccion)."'" : 'NULL').",
				comuna = ".(!empty($this->comuna) || $this->comuna=='0' ? "'".$this->db->sanitize($this->comuna)."'" : 'NULL').",
				empleado = ".(!empty($this->empleado) || $this->empleado=='0' ? "'".$this->db->sanitize($this->empleado)."'" : 'NULL')."
			WHERE
				id = '".$this->db->sanitize($this->id)."'
		");
		if(!$this->afterUpdate()) { $this->db->rollback(); return false; }
		$this->db->commit();
		return true;
	}

	/**
	 * Recupera un objeto de tipo Comuna asociado al objeto Sucursal
	 * @return Comuna Objeto de tipo Comuna con datos seteados o null en caso de que no existe la asociación
	 * @author MiPaGiNa Code Generator
	 * @version 2014-03-08 14:09:23
	 */
	public function getComuna () {
		App::uses('Comuna', Sucursal::$fkModule['Comuna'].'Model');
		$Comuna = new Comuna($this->comuna);
		if($Comuna->exists()) {
			return $Comuna;
		}
		return null;
	}

	/**
	 * Recupera un objeto de tipo Empleado asociado al objeto Sucursal
	 * @return Empleado Objeto de tipo Empleado con datos seteados o null en caso de que no existe la asociación
	 * @author MiPaGiNa Code Generator
	 * @version 2014-03-08 14:09:23
	 */
	public function getEmpleado () {
		App::uses('Empleado', Sucursal::$fkModule['Empleado'].'Model');
		$Empleado = new Empleado($this->empleado);
		if($Empleado->exists()) {
			return $Empleado;
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
			UPDATE sucursal
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
 * Clase abstracta para mapear la tabla sucursal de la base de datos
 * Sucursales de la empresa
 * Esta clase permite trabajar sobre un conjunto de registros de la tabla sucursal
 * @author MiPaGiNa Code Generator
 * @version 2014-03-08 14:09:23
 */
abstract class SucursalesBase extends AppModels {
}
