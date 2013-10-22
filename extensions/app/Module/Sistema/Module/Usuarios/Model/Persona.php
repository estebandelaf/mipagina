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

// Clase abstracta para el acceso a la base de datos (padre de esta)
App::uses('PersonaBase', 'Sistema.Usuarios.Model');

/**
 * Clase final para mapear la tabla persona de la base de datos
 * Listado de personas (sean o no usuarios del sistema)
 * Esta clase permite trabajar sobre un registro de la tabla persona
 * @author MiPaGiNa Code Generator
 * @version 2013-06-25 14:08:16
 */
final class Persona extends PersonaBase {

	protected $fkModule = array(); ///< Modelos utilizados

	public function __construct ($run = null) {
		parent::__construct ($run);
		$this->persona = trim($this->nombres.' '.$this->apellido_paterno.' '.$this->apellido_materno);
	}

	/**
	 * Método que guarda una imagen
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2013-07-01
	 */
	public function saveImagen ($foto, $avatar) {
		$foto['data'] = pg_escape_bytea($foto['data']);
		$avatar['data'] = pg_escape_bytea($avatar['data']);
		$this->db->query("
			UPDATE persona
			SET
				imagen_data = '".$foto['data']."'
				, imagen_name = '".$this->db->sanitize($foto['name'])."'
				, imagen_type = '".$this->db->sanitize($foto['type'])."'
				, imagen_size = ".(integer)$this->db->sanitize($foto['size'])."
				, imagen_t_data = '".$avatar['data']."'
				, imagen_t_size = ".(integer)$this->db->sanitize($avatar['size'])."
				, imagen_x1 = '".$this->db->sanitize($avatar['x1'])."'
				, imagen_y1 = '".$this->db->sanitize($avatar['y1'])."'
				, imagen_x2 = '".$this->db->sanitize($avatar['x2'])."'
				, imagen_y2 = '".$this->db->sanitize($avatar['y2'])."'
			WHERE run = '".$this->run."'
		");
	}

}

/**
 * Clase final para mapear la tabla persona de la base de datos
 * Listado de personas (sean o no usuarios del sistema)
 * Esta clase permite trabajar sobre un conjunto de registros de la tabla persona
 * @author MiPaGiNa Code Generator
 * @version 2013-06-25 14:08:16
 */
final class Personas extends PersonasBase {

	public function getList () {
		return $this->db->getTable('
			SELECT
				run,
				CASE WHEN apellido_materno IS NOT NULL THEN
					CONCAT(nombres || \' \' || apellido_paterno || \' \' || apellido_materno)
				ELSE
					CONCAT(nombres || \' \' || apellido_paterno)
				END AS persona
			FROM persona
			ORDER BY nombres, apellido_paterno
		');
	}

}
