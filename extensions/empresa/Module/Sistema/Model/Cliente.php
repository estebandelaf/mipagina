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
App::uses('ClienteBase', 'Sistema.Model');

/**
 * Clase final para mapear la tabla cliente de la base de datos
 * Listado de clientes de la empresa
 * Esta clase permite trabajar sobre un registro de la tabla cliente
 * @author MiPaGiNa Code Generator
 * @version 2014-02-13 19:09:38
 */
final class Cliente extends ClienteBase {

	public static $fkModule = array(
		'ActividadEconomica' => 'Sistema.General.',
		'Comuna' => 'Sistema.General.DivisionGeopolitica.'
	); ///< Módulos que utiliza esta clase

	/**
	 * Método para actualizar el objeto en la base de datos excepto la contraseña que debe actualizarce con $this->saveContrasenia
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-13 19:41:02
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
				comuna = ".(!empty($this->comuna) || $this->comuna=='0' ? "'".$this->db->sanitize($this->comuna)."'" : 'NULL')."
			WHERE
				rut = '".(integer)$this->db->sanitize($this->rut)."'
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
			UPDATE cliente SET
				contrasenia = '".hash($hash, $password)."'
			WHERE rut = ".(integer)$this->db->sanitize($this->rut)."
		");
	}

}

/**
 * Clase final para mapear la tabla cliente de la base de datos
 * Listado de clientes de la empresa
 * Esta clase permite trabajar sobre un conjunto de registros de la tabla cliente
 * @author MiPaGiNa Code Generator
 * @version 2014-02-13 19:09:38
 */
final class Clientes extends ClientesBase {
}
