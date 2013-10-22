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
App::uses('UsuarioBase', 'Sistema.Usuarios.Model');

/**
 * Clase final para mapear la tabla usuario de la base de datos
 * Tabla para usuarios del sistema
 * Esta clase permite trabajar sobre un registro de la tabla usuario
 * @author MiPaGiNa Code Generator
 * @version 2013-06-30
 */
final class Usuario extends UsuarioBase {

	protected $fkModule = array(
		'Persona' => 'Sistema.Usuarios.'
	); ///< Modelos utilizados

	/**
	 * Constructor de la clase usuario
	 * Permite crear el objeto usuario ya sea recibiendo el id del usuario
	 * o el nombre de usuario (en cuyo caso se rescata el id).
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2013-09-20
	 */
	public function __construct ($id) {
		if (is_string($id)) {
			$this->db = Database::get($this->_database);
			$id = $this->db->getValue('
				SELECT id
				FROM usuario
				WHERE usuario = \''.$this->db->sanitize($id).'\'
			');
		}
		parent::__construct ($id);
	}
	
	/**
	 * Método que guarda los datos generales de un usuario
	 * @return boolean siempre verdadero para evitar rollback
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2013-06-25
	 */
	public function update () {
		$this->db->query("
			UPDATE usuario SET
				persona = '".$this->db->sanitize($this->persona)."'
				, usuario = '".$this->db->sanitize($this->usuario)."'
				, activo = '".$this->db->sanitize($this->activo)."'
			WHERE id = ".(integer)$this->db->sanitize($this->id)."
		");
		return true;
	}

	/**
	 * Método que guarda los datos generales de un usuario
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2013-06-30
	 */
	public function saveContrasenia ($password, $hash = 'sha256') {
		$this->db->query("
			UPDATE usuario SET
				contrasenia = '".hash($hash, $password)."'
			WHERE id = ".(integer)$this->db->sanitize($this->id)."
		");
	}

}

/**
 * Clase final para mapear la tabla usuario de la base de datos
 * Tabla para usuarios del sistema
 * Esta clase permite trabajar sobre un conjunto de registros de la tabla usuario
 * @author MiPaGiNa Code Generator
 * @version 2013-06-25 14:08:16
 */
final class Usuarios extends UsuariosBase {
}
