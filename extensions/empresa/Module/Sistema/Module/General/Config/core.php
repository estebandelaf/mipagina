<?php

// Menú para el módulo
Configure::write('nav.module', array(
	'/actividad_economicas/listar' => array(
		'name' => 'Actividad económica',
		'desc' => 'Listado de actividades económicas del SII',
		'imag' => '/sistema/general/img/icons/48x48/actividad_economica.png',
	),
	'/division_geopolitica' => array(
		'name' => 'División geopolítica',
		'desc' => 'Regiones, provincias y comunas del país',
		'imag' => '/sistema/general/division_geopolitica/img/icons/48x48/region.png',
	),
));
