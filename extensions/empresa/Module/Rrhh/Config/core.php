<?php

// Menú para el módulo
Configure::write('nav.module', array(
	'/empleados/listar?search=activo:t' => array(
		'name' => 'Empleados',
		'imag' => '/rrhh/img/icons/48x48/empleados.png',
	),
	'/empleados/edad' => array(
		'name' => 'Grupo etáreo',
		'imag' => '/rrhh/img/icons/48x48/edad.png',
	),
	'/empleados/cumpleanios' => array(
		'name' => 'Cumpleaños',
		'imag' => '/rrhh/img/icons/48x48/cumpleanios.png',
	),
));
