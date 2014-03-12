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

/**
 * @file core.php
 * Configuración del módulo
 * @version 2014-02-25
 */

// Menú para el módulo
Configure::write('nav.module', array(
	'/bd/tablas' => array(
		'name' => 'Listado de tablas',
		'desc' => 'Información de las tablas de la base de datos',
		'imag' => '/dev/img/icons/48x48/database.png',
	),
	'/bd/poblar' => array(
		'name' => 'Poblar tablas',
		'desc' => 'Cargar datos a tablas de la base de datos',
		'imag' => '/img/icons/48x48/subir.png',
	),
	'/bd/descargar' => array(
		'name' => 'Descargar datos de tablas',
		'desc' => 'Descargar datos de tablas de la base de datos',
		'imag' => '/img/icons/48x48/descargar.png',
	),
));
