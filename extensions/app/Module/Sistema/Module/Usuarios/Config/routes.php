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

Router::connect('/usuarios/imagen/*', array(
	'module' => 'Sistema.Usuarios',
	'controller' => 'usuarios',
	'action' => 'imagen',
));
