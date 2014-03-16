<?php

// Menú para el módulo
Configure::write('nav.module', array(
	'/clientes/listar' => array(
		'name' => 'Clientes',
		'desc' => 'Mantenedor de clientes',
		'imag' => '/sistema/img/icons/48x48/cliente.png',
	),
	'/proveedores/listar' => array(
		'name' => 'Proveedores',
		'desc' => 'Mantenedor de proveedores',
		'imag' => '/sistema/img/icons/48x48/proveedor.png',
	),
	'/empresa' => array(
		'name' => 'Empresa',
		'desc' => 'Configuración y parámetros de la empresa',
		'imag' => '/sistema/empresa/img/icons/48x48/empresa.png',
	),
	'/usuarios' => array(
		'name' => 'Usuarios',
		'desc' => 'Mantenedor de usuarios y grupos del sistema',
		'imag' => '/sistema/usuarios/img/icons/48x48/grupo.png',
	),
	'/general' => array(
		'name' => 'Configuración general',
		'desc' => 'Módulo de configuraciones generales',
		'imag' => '/sistema/general/img/icons/48x48/configuracion.png',
	),
));
