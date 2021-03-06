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
 * @file @core.php
 * Configuración de la extensión aulavirtual
 * @version 2014-02-26
 */

// Tema de la página (diseño)
Configure::write('page.layout', 'sinorca');

// about me
Configure::write('page.aboutme', '');

// Enlaces útiles (parte superior)
Configure::write('page.header.useful_links', array(
	'left' => array(
	),
	'right' => array(
	),
));

// banners
Configure::write('banners.right', array(
	// índice es la url del enlace, valor es la url de la imagen (banner)
));
Configure::write('banners.google.ads', array(
	'client' => '',
	'ads' => array(
		'160x600' => '',
		'468x60' => '',
	),
));

// Módulos que usará esta aplicación
Module::uses(array(
	'Exportar',
));
