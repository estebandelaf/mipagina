<?php

Router::connect('/usuarios/ingresar', array(
	'module' => 'Sistema.Usuarios',
	'controller' => 'usuarios',
	'action' => 'ingresar',
));

Router::connect('/usuarios/salir', array(
	'module' => 'Sistema.Usuarios',
	'controller' => 'usuarios',
	'action' => 'salir',
));

Router::connect('/usuarios/perfil', array(
	'module' => 'Sistema.Usuarios',
	'controller' => 'usuarios',
	'action' => 'perfil',
));

Router::connect('/usuarios/contrasenia/recuperar', array(
	'module' => 'Sistema.Usuarios',
	'controller' => 'usuarios',
	'action' => 'contrasenia_recuperar',
));

Router::connect('/usuarios/contrasenia/recuperar/*', array(
	'module' => 'Sistema.Usuarios',
	'controller' => 'usuarios',
	'action' => 'contrasenia_recuperar',
));
