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

// Tema de la página (diseño)
Configure::write('page.layout', 'App');

// Textos de la página
Configure::write('page.footer', array(
	'left'	=> '',
	'right'	=> 'Página web generada utilizando el framework <a href="http://mi.delaf.cl/mipagina">MiPaGiNa</a>'
));

// Menú principal del sitio web
Configure::write('nav.website', array(
	'/inicio'=>'Inicio',
	'/contacto'=>'Contacto'
));

// Menú principal de la aplicación
Configure::write('nav.app', array(
	'/sistema'=>'Sistema'
));

// Módulos que usará esta aplicación
Module::uses(array(
	'Exportar',
	'Sistema',
	'Sistema.Usuarios' => array('autoLoad' => true),
));

// Registros por página
Configure::write('app.registers_per_page', 20);
