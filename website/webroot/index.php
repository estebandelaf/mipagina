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

/**
 * @file index.php
 * Dispatcher para la página web
 * @version 2013-10-22
 */

// Directorio que contiene las funcionalidades estándares (entregadas
// por MiPaGiNa)
define('DIR_STANDARD', '/usr/share/mipagina/standard');
// Directorio que contiene el sitio web propiamente tal (padre del directorio
// donde está este archivo)
define('DIR_WEBSITE', dirname(dirname(__FILE__)));
// Extensiones que se cargarán al sistema standard (ruta absoluta, o relativa a
// dirname(DIR_STANDARD).'/extensions';)
$_EXTENSIONS = array();

// Cargar bootstrap ("arrancador") de la aplicación
if (!@include(DIR_STANDARD.DIRECTORY_SEPARATOR.'bootstrap.php')) {
	echo 'Bootstrap no ha podido ser ejecutado, revisar DIR_STANDARD en ',DIR_WEBSITE,DIRECTORY_SEPARATOR,'webroot',DIRECTORY_SEPARATOR,'index.php';
	exit;
}

// Despachar/ejecutar la página
App::uses('Dispatcher', 'Routing');
$Dispatcher = new Dispatcher();
$Dispatcher->dispatch(new Request(), new Response());
