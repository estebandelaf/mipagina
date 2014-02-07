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
 * @version 2014-02-06
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
	 * @version 2014-02-06
	 */
	public function __construct ($id = null) {
		if (!is_numeric($id)) {
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
	 * Método que hace un UPDATE del usuario en la BD
	 * Actualiza todos los campos, excepto la contraseña, ya que esta debe cambiarse con $this->saveContrasenia()
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2014-02-07
	 */
	protected function update () {
		$this->db->transaction();
		if(!$this->beforeUpdate()) { $this->db->rollback(); return false; }
		$this->db->query("
			UPDATE usuario SET
				nombre = ".(!empty($this->nombre) || $this->nombre=='0' ? "'".$this->db->sanitize($this->nombre)."'" : 'NULL').",
				usuario = ".(!empty($this->usuario) || $this->usuario=='0' ? "'".$this->db->sanitize($this->usuario)."'" : 'NULL').",
				email = ".(!empty($this->email) || $this->email=='0' ? "'".$this->db->sanitize($this->email)."'" : 'NULL').",
				hash = ".(!empty($this->hash) || $this->hash=='0' ? "'".$this->db->sanitize($this->hash)."'" : 'NULL').",
				activo = ".(!empty($this->activo) || $this->activo=='0' ? "'".$this->db->sanitize($this->activo)."'" : 'NULL').",
				ultimo_ingreso_fecha_hora = ".(!empty($this->ultimo_ingreso_fecha_hora) || $this->ultimo_ingreso_fecha_hora=='0' ? "'".$this->db->sanitize($this->ultimo_ingreso_fecha_hora)."'" : 'NULL').",
				ultimo_ingreso_desde = ".(!empty($this->ultimo_ingreso_desde) || $this->ultimo_ingreso_desde=='0' ? "'".$this->db->sanitize($this->ultimo_ingreso_desde)."'" : 'NULL').",
				ultimo_ingreso_hash = ".(!empty($this->ultimo_ingreso_hash) || $this->ultimo_ingreso_hash=='0' ? "'".$this->db->sanitize($this->ultimo_ingreso_hash)."'" : 'NULL')."
			WHERE
				id = '".$this->db->sanitize($this->id)."'
		");
		if(!$this->afterUpdate()) { $this->db->rollback(); return false; }
		$this->db->commit();
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

	/**
	 * Método que revisa si el nombre de usuario ya existe en la base de datos
	 */
	public function checkIfUsuarioAlreadyExists () {
		if (empty($this->id)) {
			return (boolean)$this->db->getValue('
				SELECT COUNT(*)
				FROM usuario
				WHERE usuario = \''.$this->db->sanitize($this->usuario).'\'
			');
		} else {
			return (boolean)$this->db->getValue('
				SELECT COUNT(*)
				FROM usuario
				WHERE
					id != '.$this->db->sanitize($this->id).'
					AND usuario = \''.$this->db->sanitize($this->usuario).'\'
			');
		}
	}

	/**
	 * Método que revisa si el hash del usuario ya existe en la base de datos
	 */
	public function checkIfHashAlreadyExists () {
		if (empty($this->id)) {
			return (boolean)$this->db->getValue('
				SELECT COUNT(*)
				FROM usuario
				WHERE hash = \''.$this->db->sanitize($this->hash).'\'
			');
		} else {
			return (boolean)$this->db->getValue('
				SELECT COUNT(*)
				FROM usuario
				WHERE
					id != '.$this->db->sanitize($this->id).'
					AND hash = \''.$this->db->sanitize($this->hash).'\'
			');
		}
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
