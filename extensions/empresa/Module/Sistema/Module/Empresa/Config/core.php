<?php

// Menú para el módulo
Configure::write('nav.module', array(
	'/cargos/listar' => array(
		'name' => 'Cargos',
		'imag' => '/sistema/empresa/img/icons/48x48/cargo.png',
	),
	'/areas/listar' => array(
		'name' => 'Áreas',
		'imag' => '/sistema/empresa/img/icons/48x48/area.png',
	),
	'/sucursales/listar' => array(
		'name' => 'Sucursales',
		'imag' => '/sistema/empresa/img/icons/48x48/sucursal.png',
	),
));
