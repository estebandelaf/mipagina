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
App::uses('{class}Base', '{module}Model');

/**
 * Clase final para mapear la tabla {table} de la base de datos
 * {comment}
 * Esta clase permite trabajar sobre un registro de la tabla {table}
 * @author {author}
 * @version {version}
 */
final class {class} extends {class}Base {

	/**
	 * Constructor de la clase final
	 * @author {author}
	 * @version {version}
	 */
	public function __construct ({pk_parameter}) {
		self::$fkModule = array({fkModule});
		parent::__construct ({pk_variable});
	}

}

/**
 * Clase final para mapear la tabla {table} de la base de datos
 * {comment}
 * Esta clase permite trabajar sobre un conjunto de registros de la tabla {table}
 * @author {author}
 * @version {version}
 */
final class {classs} extends {classs}Base {
}
