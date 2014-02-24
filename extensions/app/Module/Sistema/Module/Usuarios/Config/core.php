<?php

/**
 * MiPaGiNa (MP)
 * Copyright (C) 2014 Esteban De La Fuente Rubio (esteban[at]delaf.cl)
 *
 * Este programa es software libre: usted puede redistribuirlo y/o
 * modificarlo bajo los términos de la Licencia Pública General GNU
 * publicada por la Fundación para el Software Libre, ya sea la versión
 * 3 de la Licencia, o (a su elección) cualquier versión posterior de la
 * misma.
 *
 * Este programa se distribuye con la esperanza de que sea útil, pero
 * SIN GARANTÍA ALGUNA; ni siquiera la garantía implícita
 * MERCANTIL o de APTITUD PARA UN PROPÓSITO DETERMINADO.
 * Consulte los detalles de la Licencia Pública General GNU para obtener
 * una información más detallada.
 *
 * Debería haber recibido una copia de la Licencia Pública General GNU
 * junto a este programa.
 * En caso contrario, consulte <http://www.gnu.org/licenses/gpl.html>.
 */

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
