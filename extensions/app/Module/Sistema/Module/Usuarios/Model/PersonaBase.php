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
 * Clase abstracta para mapear la tabla persona de la base de datos
 * Listado de personas (sean o no usuarios del sistema)
 * Esta clase permite trabajar sobre un registro de la tabla persona
 * @author MiPaGiNa Code Generator
 * @version 2013-07-01 01:49:02
 */
abstract class PersonaBase extends AppModel {

	// Atributos de la clase (columnas en la base de datos)
	public $run; ///< RUN sin puntos ni dígito verificador: integer(32) NOT NULL DEFAULT '' PK 
	public $dv; ///< Dígito verificador del RUN de la persona: character(1) NOT NULL DEFAULT '' 
	public $nombres; ///< Nombres, solo los nombres: character varying(40) NOT NULL DEFAULT '' 
	public $apellido_paterno; ///< Apellido paterno: character varying(40) NOT NULL DEFAULT '' 
	public $apellido_materno; ///< Apellido materno: character varying(40) NULL DEFAULT '' 
	public $sexo; ///< Sexo de la persona: masculino (m) o femenino (f): character(1) NOT NULL DEFAULT 'm' 
	public $fecha_de_nacimiento; ///< Fecha de nacimiento: date() NULL DEFAULT '' 
	public $email; ///< Correo electrónico: character varying(80) NULL DEFAULT '' 
	public $imagen_name; ///< Nombre de la imagen: character varying(50) NULL DEFAULT '' 
	public $imagen_type; ///< Tipo de la imagen: character varying(10) NULL DEFAULT '' 
	public $imagen_size; ///< Tamaño de la imagen: integer(32) NULL DEFAULT '' 
	public $imagen_data; ///< Datos de la imagen (la imagen en si): bytea() NULL DEFAULT '' 
	public $imagen_t_size; ///< Tamaño de la miniatura: integer(32) NULL DEFAULT '' 
	public $imagen_t_data; ///< Datos de la miniatura de la imagen: bytea() NULL DEFAULT '' 
	public $imagen_x1; ///< Coordenada x1 de la imagen grande para el recorde la miniatura: smallint(16) NULL DEFAULT '' 
	public $imagen_y1; ///< Coordenada y1 de la imagen grande para el recorde la miniatura: smallint(16) NULL DEFAULT '' 
	public $imagen_x2; ///< Coordenada x2 de la imagen grande para el recorde la miniatura: smallint(16) NULL DEFAULT '' 
	public $imagen_y2; ///< Coordenada y2 de la imagen grande para el recorde la miniatura: smallint(16) NULL DEFAULT '' 

	// Información de las columnas de la tabla en la base de datos
	public static $columnsInfo = array(
		'run' => array(
			'name' => 'Run',
			'comment' => 'RUN sin puntos ni dígito verificador',
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
			'comment' => 'Dígito verificador del RUN de la persona',
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
			'comment' => 'Nombres, solo los nombres',
			'type' => 'character varying',
			'length' => 40,
			'null' => false,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'apellido_paterno' => array(
			'name' => 'Apellido Paterno',
			'comment' => 'Apellido paterno',
			'type' => 'character varying',
			'length' => 40,
			'null' => false,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'apellido_materno' => array(
			'name' => 'Apellido Materno',
			'comment' => 'Apellido materno',
			'type' => 'character varying',
			'length' => 40,
			'null' => true,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'sexo' => array(
			'name' => 'Sexo',
			'comment' => 'Sexo de la persona: masculino (m) o femenino (f)',
			'type' => 'character',
			'length' => 1,
			'null' => false,
			'default' => "m",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'fecha_de_nacimiento' => array(
			'name' => 'Fecha De Nacimiento',
			'comment' => 'Fecha de nacimiento',
			'type' => 'date',
			'length' => null,
			'null' => true,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'email' => array(
			'name' => 'Email',
			'comment' => 'Correo electrónico',
			'type' => 'character varying',
			'length' => 80,
			'null' => true,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'imagen_name' => array(
			'name' => 'Imagen Name',
			'comment' => 'Nombre de la imagen',
			'type' => 'character varying',
			'length' => 50,
			'null' => true,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'imagen_type' => array(
			'name' => 'Imagen Type',
			'comment' => 'Tipo de la imagen',
			'type' => 'character varying',
			'length' => 10,
			'null' => true,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'imagen_size' => array(
			'name' => 'Imagen Size',
			'comment' => 'Tamaño de la imagen',
			'type' => 'integer',
			'length' => 32,
			'null' => true,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'imagen_data' => array(
			'name' => 'Imagen Data',
			'comment' => 'Datos de la imagen (la imagen en si)',
			'type' => 'bytea',
			'length' => null,
			'null' => true,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'imagen_t_size' => array(
			'name' => 'Imagen T Size',
			'comment' => 'Tamaño de la miniatura',
			'type' => 'integer',
			'length' => 32,
			'null' => true,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'imagen_t_data' => array(
			'name' => 'Imagen T Data',
			'comment' => 'Datos de la miniatura de la imagen',
			'type' => 'bytea',
			'length' => null,
			'null' => true,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'imagen_x1' => array(
			'name' => 'Imagen X1',
			'comment' => 'Coordenada x1 de la imagen grande para el recorde la miniatura',
			'type' => 'smallint',
			'length' => 16,
			'null' => true,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'imagen_y1' => array(
			'name' => 'Imagen Y1',
			'comment' => 'Coordenada y1 de la imagen grande para el recorde la miniatura',
			'type' => 'smallint',
			'length' => 16,
			'null' => true,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'imagen_x2' => array(
			'name' => 'Imagen X2',
			'comment' => 'Coordenada x2 de la imagen grande para el recorde la miniatura',
			'type' => 'smallint',
			'length' => 16,
			'null' => true,
			'default' => "",
			'auto' => false,
			'pk' => false,
			'fk' => null
		),
		'imagen_y2' => array(
			'name' => 'Imagen Y2',
			'comment' => 'Coordenada y2 de la imagen grande para el recorde la miniatura',
			'type' => 'smallint',
			'length' => 16,
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
	 * @version 2013-07-01 01:49:02
	 */
	public function __construct ($run = null) {
		// asignar base de datos y tabla
		$this->_database = 'default';
		$this->_table = 'persona';
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
	 * @version 2013-07-01 01:49:02
	 */
	protected function clear () {
		$this->run = null;
		$this->dv = null;
		$this->nombres = null;
		$this->apellido_paterno = null;
		$this->apellido_materno = null;
		$this->sexo = null;
		$this->fecha_de_nacimiento = null;
		$this->email = null;
		$this->imagen_name = null;
		$this->imagen_type = null;
		$this->imagen_size = null;
		$this->imagen_data = null;
		$this->imagen_t_size = null;
		$this->imagen_t_data = null;
		$this->imagen_x1 = null;
		$this->imagen_y1 = null;
		$this->imagen_x2 = null;
		$this->imagen_y2 = null;
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
				FROM persona
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
	 * Setea los atributos del objeto PersonaModel mediante un arreglo,
	 * la key del arreglo es el nombre del atributo, si la key no existe
	 * el campo quedará seteado a null
	 * @param array Array Arreglo con la relacion columna=>valor
	 * @param clear Boolean Verdadero para limpiar atributos antes de hacer el set
	 * @author MiPaGiNa Code Generator
	 * @version 2013-07-01 01:49:02
	 */
	public function set ($array) {
		// asignar atributos con los valores del arreglo
		if(isset($array['run']))
			$this->run = $array['run'];
		if(isset($array['dv']))
			$this->dv = $array['dv'];
		if(isset($array['nombres']))
			$this->nombres = $array['nombres'];
		if(isset($array['apellido_paterno']))
			$this->apellido_paterno = $array['apellido_paterno'];
		if(isset($array['apellido_materno']))
			$this->apellido_materno = $array['apellido_materno'];
		if(isset($array['sexo']))
			$this->sexo = $array['sexo'];
		if(isset($array['fecha_de_nacimiento']))
			$this->fecha_de_nacimiento = $array['fecha_de_nacimiento'];
		if(isset($array['email']))
			$this->email = $array['email'];
		if(isset($array['imagen_name']))
			$this->imagen_name = $array['imagen_name'];
		if(isset($array['imagen_type']))
			$this->imagen_type = $array['imagen_type'];
		if(isset($array['imagen_size']))
			$this->imagen_size = $array['imagen_size'];
		if(isset($array['imagen_data']))
			$this->imagen_data = $array['imagen_data'];
		if(isset($array['imagen_t_size']))
			$this->imagen_t_size = $array['imagen_t_size'];
		if(isset($array['imagen_t_data']))
			$this->imagen_t_data = $array['imagen_t_data'];
		if(isset($array['imagen_x1']))
			$this->imagen_x1 = $array['imagen_x1'];
		if(isset($array['imagen_y1']))
			$this->imagen_y1 = $array['imagen_y1'];
		if(isset($array['imagen_x2']))
			$this->imagen_x2 = $array['imagen_x2'];
		if(isset($array['imagen_y2']))
			$this->imagen_y2 = $array['imagen_y2'];
	}
	
	/**
	 * Método para determinar si el objeto existe en la base de datos
	 * @author MiPaGiNa Code Generator
	 * @version 2013-07-01 01:49:02
	 */
	public function exists () {
		// solo se ejecuta si la PK existe seteada
		if(!empty($this->run)) {
			return (boolean) $this->db->getValue("
				SELECT COUNT(*) FROM persona
				WHERE run = '".$this->db->sanitize($this->run)."'
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
			DELETE FROM persona
			WHERE run = '".$this->db->sanitize($this->run)."'
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
			INSERT INTO persona (
				run,
				dv,
				nombres,
				apellido_paterno,
				apellido_materno,
				sexo,
				fecha_de_nacimiento,
				email,
				imagen_name,
				imagen_type,
				imagen_size,
				imagen_data,
				imagen_t_size,
				imagen_t_data,
				imagen_x1,
				imagen_y1,
				imagen_x2,
				imagen_y2
			) VALUES (
				".(!empty($this->run) || $this->run=='0' ? "'".$this->db->sanitize($this->run)."'" : 'NULL').",
				".(!empty($this->dv) || $this->dv=='0' ? "'".$this->db->sanitize($this->dv)."'" : 'NULL').",
				".(!empty($this->nombres) || $this->nombres=='0' ? "'".$this->db->sanitize($this->nombres)."'" : 'NULL').",
				".(!empty($this->apellido_paterno) || $this->apellido_paterno=='0' ? "'".$this->db->sanitize($this->apellido_paterno)."'" : 'NULL').",
				".(!empty($this->apellido_materno) || $this->apellido_materno=='0' ? "'".$this->db->sanitize($this->apellido_materno)."'" : 'NULL').",
				".(!empty($this->sexo) || $this->sexo=='0' ? "'".$this->db->sanitize($this->sexo)."'" : 'NULL').",
				".(!empty($this->fecha_de_nacimiento) || $this->fecha_de_nacimiento=='0' ? "'".$this->db->sanitize($this->fecha_de_nacimiento)."'" : 'NULL').",
				".(!empty($this->email) || $this->email=='0' ? "'".$this->db->sanitize($this->email)."'" : 'NULL').",
				".(!empty($this->imagen_name) || $this->imagen_name=='0' ? "'".$this->db->sanitize($this->imagen_name)."'" : 'NULL').",
				".(!empty($this->imagen_type) || $this->imagen_type=='0' ? "'".$this->db->sanitize($this->imagen_type)."'" : 'NULL').",
				".(!empty($this->imagen_size) || $this->imagen_size=='0' ? "'".$this->db->sanitize($this->imagen_size)."'" : 'NULL').",
				".(!empty($this->imagen_data) || $this->imagen_data=='0' ? "'".$this->db->sanitize($this->imagen_data)."'" : 'NULL').",
				".(!empty($this->imagen_t_size) || $this->imagen_t_size=='0' ? "'".$this->db->sanitize($this->imagen_t_size)."'" : 'NULL').",
				".(!empty($this->imagen_t_data) || $this->imagen_t_data=='0' ? "'".$this->db->sanitize($this->imagen_t_data)."'" : 'NULL').",
				".(!empty($this->imagen_x1) || $this->imagen_x1=='0' ? "'".$this->db->sanitize($this->imagen_x1)."'" : 'NULL').",
				".(!empty($this->imagen_y1) || $this->imagen_y1=='0' ? "'".$this->db->sanitize($this->imagen_y1)."'" : 'NULL').",
				".(!empty($this->imagen_x2) || $this->imagen_x2=='0' ? "'".$this->db->sanitize($this->imagen_x2)."'" : 'NULL').",
				".(!empty($this->imagen_y2) || $this->imagen_y2=='0' ? "'".$this->db->sanitize($this->imagen_y2)."'" : 'NULL')."
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
			UPDATE persona SET
				dv = ".(!empty($this->dv) || $this->dv=='0' ? "'".$this->db->sanitize($this->dv)."'" : 'NULL').",
				nombres = ".(!empty($this->nombres) || $this->nombres=='0' ? "'".$this->db->sanitize($this->nombres)."'" : 'NULL').",
				apellido_paterno = ".(!empty($this->apellido_paterno) || $this->apellido_paterno=='0' ? "'".$this->db->sanitize($this->apellido_paterno)."'" : 'NULL').",
				apellido_materno = ".(!empty($this->apellido_materno) || $this->apellido_materno=='0' ? "'".$this->db->sanitize($this->apellido_materno)."'" : 'NULL').",
				sexo = ".(!empty($this->sexo) || $this->sexo=='0' ? "'".$this->db->sanitize($this->sexo)."'" : 'NULL').",
				fecha_de_nacimiento = ".(!empty($this->fecha_de_nacimiento) || $this->fecha_de_nacimiento=='0' ? "'".$this->db->sanitize($this->fecha_de_nacimiento)."'" : 'NULL').",
				email = ".(!empty($this->email) || $this->email=='0' ? "'".$this->db->sanitize($this->email)."'" : 'NULL').",
				imagen_name = ".(!empty($this->imagen_name) || $this->imagen_name=='0' ? "'".$this->db->sanitize($this->imagen_name)."'" : 'NULL').",
				imagen_type = ".(!empty($this->imagen_type) || $this->imagen_type=='0' ? "'".$this->db->sanitize($this->imagen_type)."'" : 'NULL').",
				imagen_size = ".(!empty($this->imagen_size) || $this->imagen_size=='0' ? "'".$this->db->sanitize($this->imagen_size)."'" : 'NULL').",
				imagen_data = ".(!empty($this->imagen_data) || $this->imagen_data=='0' ? "'".$this->db->sanitize($this->imagen_data)."'" : 'NULL').",
				imagen_t_size = ".(!empty($this->imagen_t_size) || $this->imagen_t_size=='0' ? "'".$this->db->sanitize($this->imagen_t_size)."'" : 'NULL').",
				imagen_t_data = ".(!empty($this->imagen_t_data) || $this->imagen_t_data=='0' ? "'".$this->db->sanitize($this->imagen_t_data)."'" : 'NULL').",
				imagen_x1 = ".(!empty($this->imagen_x1) || $this->imagen_x1=='0' ? "'".$this->db->sanitize($this->imagen_x1)."'" : 'NULL').",
				imagen_y1 = ".(!empty($this->imagen_y1) || $this->imagen_y1=='0' ? "'".$this->db->sanitize($this->imagen_y1)."'" : 'NULL').",
				imagen_x2 = ".(!empty($this->imagen_x2) || $this->imagen_x2=='0' ? "'".$this->db->sanitize($this->imagen_x2)."'" : 'NULL').",
				imagen_y2 = ".(!empty($this->imagen_y2) || $this->imagen_y2=='0' ? "'".$this->db->sanitize($this->imagen_y2)."'" : 'NULL')."
			WHERE
				run = '".$this->db->sanitize($this->run)."'
		");
		if(!$this->afterUpdate()) { $this->db->rollback(); return false; }
		$this->db->commit();
		return true;
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
			UPDATE persona
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
 * Clase abstracta para mapear la tabla persona de la base de datos
 * Listado de personas (sean o no usuarios del sistema)
 * Esta clase permite trabajar sobre un conjunto de registros de la tabla persona
 * @author MiPaGiNa Code Generator
 * @version 2013-07-01 01:49:02
 */
abstract class PersonasBase extends AppModels {
	
	/**
	 * Constructor de la clase abstracta
	 * @author MiPaGiNa Code Generator
	 * @version 2013-07-01 01:49:02
	 */
	public function __construct () {
		// asignar base de datos y tabla
		$this->_database = 'default';
		$this->_table = 'persona';
		// ejecutar constructor de la clase padre
		parent::__construct();
	}

}
