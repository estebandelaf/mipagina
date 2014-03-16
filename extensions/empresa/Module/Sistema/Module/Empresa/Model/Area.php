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

// Clase abstracta para el acceso a la base de datos (padre de esta)
App::uses('AreaBase', 'Sistema.Empresa.Model');

/**
 * Clase final para mapear la tabla area de la base de datos
 * Áreas de la empresa
 * Esta clase permite trabajar sobre un registro de la tabla area
 * @author MiPaGiNa Code Generator
 * @version 2014-03-08 14:09:23
 */
final class Area extends AreaBase {

	// Datos para la conexión a la base de datos
	protected $_database = 'default'; ///< Base de datos del modelo
	protected $_table = 'area'; ///< Tabla del modelo

	public static $fkModule = array(
		'Area' => 'Sistema.Empresa.'
	); ///< Módulos que utiliza esta clase

}

/**
 * Clase final para mapear la tabla area de la base de datos
 * Áreas de la empresa
 * Esta clase permite trabajar sobre un conjunto de registros de la tabla area
 * @author MiPaGiNa Code Generator
 * @version 2014-03-08 14:09:23
 */
final class Areas extends AreasBase {

	// Datos para la conexión a la base de datos
	protected $_database = 'default'; ///< Base de datos del modelo
	protected $_table = 'area'; ///< Tabla del modelo

}
