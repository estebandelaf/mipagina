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
 * Clase abstracta para mapear la tabla empleado de la base de datos
 * Listado de empleados de la empresa
 * Esta clase permite trabajar sobre un registro de la tabla empleado
 * @author MiPaGiNa Code Generator
 * @version 2014-03-08 16:31:48
 */
abstract class EmpleadoBase extends AppModel {

	// Atributos de la clase (columnas en la base de datos)
	public $run; ///< RUN de la persona, sin puntos ni dígito verificador: integer(32) NOT NULL DEFAULT '' PK 
	public $dv; ///< Dígito verificador del RUN: character(1) NOT NULL DEFAULT '' 
	public $nombres; ///< Nombres de la persona: character varying(30) NOT NULL DEFAULT '' 
	public $apellidos; ///< Apellidos de la persona: character varying(30) NOT NULL DEFAULT '' 
	public $activo; ///< Activo o no en la empresa: boolean() NOT NULL DEFAULT 'true' 
	public $cargo; ///< Cargo que ocupa dentro de la empresa: integer(32) NULL DEFAULT '' FK:cargo.id
	public $foto_data; ///< Fotografía de la persona: bytea() NULL DEFAULT '' 
	public $foto_name; ///< Nombre de la fotografía: character varying(100) NULL DEFAULT '' 
	public $foto_type; ///< Mimetype de la fotografía: character varying(10) NULL DEFAULT '' 
	public $foto_size; ///< Tamaño de la fotografía: integer(32) NULL DEFAULT '' 
	public $fecha_nacimiento; ///< Fecha de nacimiento de la persona: date() NULL DEFAULT '' 
	public $sucursal; ///< Sucursal en la que trabaja este empleado: integer(32) NULL DEFAULT '' FK:sucursal.id
	public $usuario; ///< Usuario del sistema (si es que tiene uno asignado): integer(32) NULL DEFAULT '' FK:usuario.id

	// Información de las columnas de la tabla en la base de datos
	public static $columnsInfo = array(
		'run' => array(
			'name' => 'Run',
			'comment' => 'RUN de la persona, sin puntos ni dígito verificador',
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
			'comment' => 'Dígito verificador del RUN',
			'type' => 'character',
			'length' => 1,
			'null' => false,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'nombres' => array(
			'name' => 'Nombres',
			'comment' => 'Nombres de la persona',
			'type' => 'character varying',
			'length' => 30,
			'null' => false,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'apellidos' => array(
			'name' => 'Apellidos',
			'comment' => 'Apellidos de la persona',
			'type' => 'character varying',
			'length' => 30,
			'null' => false,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'activo' => array(
			'name' => 'Activo',
			'comment' => 'Activo o no en la empresa',
			'type' => 'boolean',
			'length' => null,
			'null' => false,
			'default' => "true",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'cargo' => array(
			'name' => 'Cargo',
			'comment' => 'Cargo que ocupa dentro de la empresa',
			'type' => 'integer',
			'length' => 32,
			'null' => true,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => array('table' => 'cargo', 'column' => 'id')
		),
		'foto_data' => array(
			'name' => 'Foto Data',
			'comment' => 'Fotografía de la persona',
			'type' => 'bytea',
			'length' => null,
			'null' => true,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'foto_name' => array(
			'name' => 'Foto Name',
			'comment' => 'Nombre de la fotografía',
			'type' => 'character varying',
			'length' => 100,
			'null' => true,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'foto_type' => array(
			'name' => 'Foto Type',
			'comment' => 'Mimetype de la fotografía',
			'type' => 'character varying',
			'length' => 10,
			'null' => true,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'foto_size' => array(
			'name' => 'Foto Size',
			'comment' => 'Tamaño de la fotografía',
			'type' => 'integer',
			'length' => 32,
			'null' => true,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'fecha_nacimiento' => array(
			'name' => 'Fecha Nacimiento',
			'comment' => 'Fecha de nacimiento de la persona',
			'type' => 'date',
			'length' => null,
			'null' => true,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'sucursal' => array(
			'name' => 'Sucursal',
			'comment' => 'Sucursal en la que trabaja este empleado',
			'type' => 'integer',
			'length' => 32,
			'null' => true,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => array('table' => 'sucursal', 'column' => 'id')
		),
		'usuario' => array(
			'name' => 'Usuario',
			'comment' => 'Usuario del sistema (si es que tiene uno asignado)',
			'type' => 'integer',
			'length' => 32,
			'null' => true,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => array('table' => 'usuario', 'column' => 'id')
		),

	);

	public static $fkModule; ///< Modelos utilizados (se asigna en Empleado)
	
	/**
	 * Constructor de la clase abstracta
	 * @author MiPaGiNa Code Generator
	 * @version 2014-03-08 16:31:48
	 */
	public function __construct ($run = null) {
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
				$this->run = $run;
			}
		}
		// obtener otros atributos del objeto
		$this->get();
	}
	
	/**
	 * Setea a null los atributos de la clase (los que sean columnas de
	 * la tabla)
	 * @author MiPaGiNa Code Generator
	 * @version 2014-03-08 16:31:48
	 */
	protected function clear () {
		$this->run = null;
		$this->dv = null;
		$this->nombres = null;
		$this->apellidos = null;
		$this->activo = null;
		$this->cargo = null;
		$this->foto_data = null;
		$this->foto_name = null;
		$this->foto_type = null;
		$this->foto_size = null;
		$this->fecha_nacimiento = null;
		$this->sucursal = null;
		$this->usuario = null;
	}
	
	/**
	 * Método para obtener los atributos del objeto, esto es cada una
	 * de las columnas que representan al objeto en la base de datos
	 */
	public function get () {
		// solo se recuperan los datos si se seteo la PK
		if(!empty($this->run)) {
			// obtener columnas desde la base de datos
			$datos = $this->db->getRow("
				SELECT *
				FROM empleado
				WHERE run = '".$this->db->sanitize($this->run)."'
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
	 * @version 2014-03-08 16:31:48
	 */
	public function exists () {
		// solo se ejecuta si la PK existe seteada
		if(!empty($this->run)) {
			return (boolean) $this->db->getValue("
				SELECT COUNT(*) FROM empleado
				WHERE run = '".$this->db->sanitize($this->run)."'
			");
		} else {
			return false;
		}
	}

	/**
	 * Método para borrar el objeto de la base de datos
	 * @author MiPaGiNa Code Generator
	 * @version 2014-03-08 16:31:48
	 */
	public function delete () {
		$this->db->transaction();
		if(!$this->beforeDelete()) { $this->db->rollback(); return false; }
		$this->db->query("
			DELETE FROM empleado
			WHERE run = '".$this->db->sanitize($this->run)."'
		");
		if(!$this->afterDelete()) { $this->db->rollback(); return false; }
		$this->db->commit();
		return true;
	}

	/**
	 * Método para insertar el objeto en la base de datos
	 * @author MiPaGiNa Code Generator
	 * @version 2014-03-08 16:31:48
	 */
	protected function insert () {
		$this->db->transaction();
		if(!$this->beforeInsert()) { $this->db->rollback(); return false; }
		$this->db->query("
			INSERT INTO empleado (
				run,
				dv,
				nombres,
				apellidos,
				activo,
				cargo,
				foto_data,
				foto_name,
				foto_type,
				foto_size,
				fecha_nacimiento,
				sucursal,
				usuario
			) VALUES (
				".(!empty($this->run) || $this->run=='0' ? "'".$this->db->sanitize($this->run)."'" : 'NULL').",
				".(!empty($this->dv) || $this->dv=='0' ? "'".$this->db->sanitize($this->dv)."'" : 'NULL').",
				".(!empty($this->nombres) || $this->nombres=='0' ? "'".$this->db->sanitize($this->nombres)."'" : 'NULL').",
				".(!empty($this->apellidos) || $this->apellidos=='0' ? "'".$this->db->sanitize($this->apellidos)."'" : 'NULL').",
				".(!empty($this->activo) || $this->activo=='0' ? "'".$this->db->sanitize($this->activo)."'" : 'NULL').",
				".(!empty($this->cargo) || $this->cargo=='0' ? "'".$this->db->sanitize($this->cargo)."'" : 'NULL').",
				".(!empty($this->foto_data) || $this->foto_data=='0' ? "'".$this->db->sanitize($this->foto_data)."'" : 'NULL').",
				".(!empty($this->foto_name) || $this->foto_name=='0' ? "'".$this->db->sanitize($this->foto_name)."'" : 'NULL').",
				".(!empty($this->foto_type) || $this->foto_type=='0' ? "'".$this->db->sanitize($this->foto_type)."'" : 'NULL').",
				".(!empty($this->foto_size) || $this->foto_size=='0' ? "'".$this->db->sanitize($this->foto_size)."'" : 'NULL').",
				".(!empty($this->fecha_nacimiento) || $this->fecha_nacimiento=='0' ? "'".$this->db->sanitize($this->fecha_nacimiento)."'" : 'NULL').",
				".(!empty($this->sucursal) || $this->sucursal=='0' ? "'".$this->db->sanitize($this->sucursal)."'" : 'NULL').",
				".(!empty($this->usuario) || $this->usuario=='0' ? "'".$this->db->sanitize($this->usuario)."'" : 'NULL')."
			)
		");
		if(!$this->afterInsert()) { $this->db->rollback(); return false; }
		$this->db->commit();
		return true;
	}

	/**
	 * Método para actualizar el objeto en la base de datos
	 * @author MiPaGiNa Code Generator
	 * @version 2014-03-08 16:31:48
	 */
	protected function update () {
		$this->db->transaction();
		if(!$this->beforeUpdate()) { $this->db->rollback(); return false; }
		$this->db->query("
			UPDATE empleado SET
				dv = ".(!empty($this->dv) || $this->dv=='0' ? "'".$this->db->sanitize($this->dv)."'" : 'NULL').",
				nombres = ".(!empty($this->nombres) || $this->nombres=='0' ? "'".$this->db->sanitize($this->nombres)."'" : 'NULL').",
				apellidos = ".(!empty($this->apellidos) || $this->apellidos=='0' ? "'".$this->db->sanitize($this->apellidos)."'" : 'NULL').",
				activo = ".(!empty($this->activo) || $this->activo=='0' ? "'".$this->db->sanitize($this->activo)."'" : 'NULL').",
				cargo = ".(!empty($this->cargo) || $this->cargo=='0' ? "'".$this->db->sanitize($this->cargo)."'" : 'NULL').",
				foto_data = ".(!empty($this->foto_data) || $this->foto_data=='0' ? "'".$this->db->sanitize($this->foto_data)."'" : 'NULL').",
				foto_name = ".(!empty($this->foto_name) || $this->foto_name=='0' ? "'".$this->db->sanitize($this->foto_name)."'" : 'NULL').",
				foto_type = ".(!empty($this->foto_type) || $this->foto_type=='0' ? "'".$this->db->sanitize($this->foto_type)."'" : 'NULL').",
				foto_size = ".(!empty($this->foto_size) || $this->foto_size=='0' ? "'".$this->db->sanitize($this->foto_size)."'" : 'NULL').",
				fecha_nacimiento = ".(!empty($this->fecha_nacimiento) || $this->fecha_nacimiento=='0' ? "'".$this->db->sanitize($this->fecha_nacimiento)."'" : 'NULL').",
				sucursal = ".(!empty($this->sucursal) || $this->sucursal=='0' ? "'".$this->db->sanitize($this->sucursal)."'" : 'NULL').",
				usuario = ".(!empty($this->usuario) || $this->usuario=='0' ? "'".$this->db->sanitize($this->usuario)."'" : 'NULL')."
			WHERE
				run = '".$this->db->sanitize($this->run)."'
		");
		if(!$this->afterUpdate()) { $this->db->rollback(); return false; }
		$this->db->commit();
		return true;
	}

	/**
	 * Recupera un objeto de tipo Cargo asociado al objeto Empleado
	 * @return Cargo Objeto de tipo Cargo con datos seteados o null en caso de que no existe la asociación
	 * @author MiPaGiNa Code Generator
	 * @version 2014-03-08 16:31:48
	 */
	public function getCargo () {
		App::uses('Cargo', Empleado::$fkModule['Cargo'].'Model');
		$Cargo = new Cargo($this->cargo);
		if($Cargo->exists()) {
			return $Cargo;
		}
		return null;
	}

	/**
	 * Recupera un objeto de tipo Sucursal asociado al objeto Empleado
	 * @return Sucursal Objeto de tipo Sucursal con datos seteados o null en caso de que no existe la asociación
	 * @author MiPaGiNa Code Generator
	 * @version 2014-03-08 16:31:48
	 */
	public function getSucursal () {
		App::uses('Sucursal', Empleado::$fkModule['Sucursal'].'Model');
		$Sucursal = new Sucursal($this->sucursal);
		if($Sucursal->exists()) {
			return $Sucursal;
		}
		return null;
	}

	/**
	 * Recupera un objeto de tipo Usuario asociado al objeto Empleado
	 * @return Usuario Objeto de tipo Usuario con datos seteados o null en caso de que no existe la asociación
	 * @author MiPaGiNa Code Generator
	 * @version 2014-03-08 16:31:48
	 */
	public function getUsuario () {
		App::uses('Usuario', Empleado::$fkModule['Usuario'].'Model');
		$Usuario = new Usuario($this->usuario);
		if($Usuario->exists()) {
			return $Usuario;
		}
		return null;
	}


	/**
	 * Método que guarda un archivo en la base de datos
	 * @author MiPaGiNa Code Generator
	 * @version 2014-03-08 16:31:48
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
			UPDATE empleado
			SET
				${name}_data = '".$file['data']."'
				, ${name}_name = '".$this->db->sanitize($file['name'])."'
				, ${name}_type = '".$this->db->sanitize($file['type'])."'
				, ${name}_size = ".(integer)$this->db->sanitize($file['size'])."
			WHERE
				run = '".$this->db->sanitize($this->run)."'
		");
		if(!$this->afterUpdate()) { $this->db->rollback(); return false; }
		$this->db->commit();
		return true;
	}

}

/**
 * Clase abstracta para mapear la tabla empleado de la base de datos
 * Listado de empleados de la empresa
 * Esta clase permite trabajar sobre un conjunto de registros de la tabla empleado
 * @author MiPaGiNa Code Generator
 * @version 2014-03-08 16:31:48
 */
abstract class EmpleadosBase extends AppModels {
}
