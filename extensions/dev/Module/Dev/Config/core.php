<?php

// Menú para el módulo
Configure::write('nav.module', array(
	'/bd/tablas' => array(
		'name' => 'Tablas BD',
		'desc' => 'Información de las tablas de la base de datos',
		'imag' => '/dev/img/icons/48x48/database.png',
	),
	'/bd/poblar' => array(
		'name' => 'Poblar tablas BD',
		'desc' => 'Cargar datos a tablas de la base de datos',
		'imag' => '/img/icons/48x48/subir.png',
	),
	'/bd/descargar' => array(
		'name' => 'Descargar datos de tablas BD',
		'desc' => 'Descargar datos de tablas de la base de datos',
		'imag' => '/img/icons/48x48/descargar.png',
	),
));
