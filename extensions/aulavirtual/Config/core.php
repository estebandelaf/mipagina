<?php

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
