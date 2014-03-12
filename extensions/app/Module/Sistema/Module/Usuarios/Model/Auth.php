<?php

/**
 * MiPaGiNa (MP)
 * Copyright (C) 2013 Esteban De La Fuente Rubio (esteban[at]delaf.cl)
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
App::uses('AuthBase', 'Sistema.Usuarios.Model');

/**
 * Clase final para mapear la tabla auth de la base de datos
 * Permisos de grupos sobre recursos en la aplicación
 * Esta clase permite trabajar sobre un registro de la tabla auth
 * @author MiPaGiNa Code Generator
 * @version 2014-02-23
 */
final class Auth extends AuthBase {

	public static $fkModule = array(
		'Grupo' => 'Sistema.Usuarios.'
	); ///< Módulos que utiliza esta clase
	
	/**
	 * Método que revisa los permisos de un usuario sobre un recurso
	 */
	public function check ($usuario, $recurso) {
		// limpiar parámetros
		$usuario = $this->db->sanitize($usuario);
		if(!is_string($recurso) && get_class($recurso)=='Request')
			$recurso = $this->db->sanitize($recurso->request);
		else
			$recurso = $this->db->sanitize($recurso);
		// obtener permisos
		return (boolean) $this->db->getValue("
			SELECT COUNT(*)
			FROM auth
			WHERE
				grupo IN (
					SELECT grupo
					FROM usuario_grupo
					WHERE usuario = '".$usuario."'
				)
				AND (
					-- verificar el recurso de forma exacta
					recurso = '".$recurso."'
					-- verificar el recurso con / al final
					OR recurso||'/' = '".$recurso."'
					-- verificar si existe algo del tipo recurso*
					OR
						CASE WHEN strpos(recurso,'*')!=0 THEN
							CASE WHEN strpos('".$recurso."', substring(recurso from 1 for length(recurso)-1))=1 THEN
								true
							ELSE
								false
							END
						ELSE
							false
						END
				)
		");
	}

}

/**
 * Clase final para mapear la tabla auth de la base de datos
 * Permisos de grupos sobre recursos en la aplicación
 * Esta clase permite trabajar sobre un conjunto de registros de la tabla auth
 * @author MiPaGiNa Code Generator
 * @version 2012-11-12 13:05:38
 */
final class Auths extends AuthsBase {
}
