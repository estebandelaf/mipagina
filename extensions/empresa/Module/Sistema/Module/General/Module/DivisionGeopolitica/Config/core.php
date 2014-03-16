<?php

// Menú para el módulo
Configure::write('nav.module', array(
	'/comunas/listar' => array(
		'name' => 'Comunas',
		'imag' => '/sistema/general/division_geopolitica/img/icons/48x48/comuna.png',
	),
	'/provincias/listar' => array(
		'name' => 'Provincias',
		'imag' => '/sistema/general/division_geopolitica/img/icons/48x48/provincia.png',
	),
	'/regiones/listar' => array(
		'name' => 'Regiones',
		'imag' => '/sistema/general/division_geopolitica/img/icons/48x48/region.png',
	),
));
