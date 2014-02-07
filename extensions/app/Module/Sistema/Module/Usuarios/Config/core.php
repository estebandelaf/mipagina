<?php

// Menú para el módulo
Configure::write('nav.module', array(
	'/usuarios/listar' => array(
		'name' => 'Usuarios',
		'desc' => 'Usuarios del sistema',
		'imag' => '/sistema/usuarios/img/icons/48x48/usuario.png',
	),
	'/grupos/listar' => array(
		'name' => 'Grupos',
		'desc' => 'Grupos del sistema',
		'imag' => '/sistema/usuarios/img/icons/48x48/grupo.png',
	),
	'/usuario_grupos/listar' => array(
		'name' => 'Usuarios y grupos',
		'desc' => 'Pertenencia de usuarios a grupos',
		'imag' => '/sistema/usuarios/img/icons/48x48/grupo.png',
	),
	'/auths/listar' => array(
		'name' => 'Autorización',
		'desc' => 'Autorización y control de acceso sobre recursos',
		'imag' => '/sistema/usuarios/img/icons/48x48/auth.png',
	),
));
