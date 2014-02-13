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
App::uses('UsuarioGrupoBase', 'Sistema.Usuarios.Model');

/**
 * Clase final para mapear la tabla usuario_grupo de la base de datos
 * Relación entre usuarios y los grupos a los que pertenecen
 * Esta clase permite trabajar sobre un registro de la tabla usuario_grupo
 * @author MiPaGiNa Code Generator
 * @version 2013-06-30 12:54:20
 */
final class UsuarioGrupo extends UsuarioGrupoBase {

	/**
	 * Constructor de la clase final
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-13 19:09:38
	 */
	public function __construct ($usuario = null, $grupo = null) {
		self::$fkModule = array(
			'Usuario' => 'Sistema.Usuarios.',
			'Grupo' => 'Sistema.Usuarios.'
		);
		parent::__construct ($usuario, $grupo);
	}

}

/**
 * Clase final para mapear la tabla usuario_grupo de la base de datos
 * Relación entre usuarios y los grupos a los que pertenecen
 * Esta clase permite trabajar sobre un conjunto de registros de la tabla usuario_grupo
 * @author MiPaGiNa Code Generator
 * @version 2013-06-30 12:54:20
 */
final class UsuarioGrupos extends UsuarioGruposBase {
}
