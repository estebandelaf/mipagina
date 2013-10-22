<?php

/**
 * MiPaGiNa (MP)
 * Copyright (C) 2012 Esteban De La Fuente Rubio (esteban[at]delaf.cl)
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
 * @file bootstrap.php
 * Archivo de arranque de la aplicación
 */

// Asignar nivel de error máximo (para reportes previo a que se asigne
// el valor real en Configure::bootstrap())
ini_set('display_errors', true);
error_reporting(E_ALL);

// Cambiar el tiempo de ejecución a infinito xD
ini_set('max_execution_time', '0');

// Cambiar la memoria máxima a utilizar por el script
ini_set('memory_limit', '128M');

// Definir el tiempo de inicio del script
define('TIME_START', microtime(true));

// Definir separador de directorio (versión corta)
define('DS', DIRECTORY_SEPARATOR);

// iniciar buffer
ob_start();

// Incluir archivos genéricos 
include DIR_STANDARD.DS.'basics.php';
include DIR_STANDARD.DS.'Core'.DS.'App.php';

// Asignar rutas/paths donde se buscarán las clases (en este mismo orden)
$_DIRS = array();
$_DIRS[] = DIR_WEBSITE;
$_EXTENSIONS_DIR = dirname(DIR_STANDARD).DS.'extensions';
foreach($_EXTENSIONS as &$_extension) {
	if($_extension[0]!='/') $_extension = $_EXTENSIONS_DIR.DS.$_extension;
	$_DIRS[] = $_extension;
}
$_DIRS[] = DIR_STANDARD;
App::paths($_DIRS);
unset($_EXTENSIONS, $_DIRS, $_EXTENSIONS_DIR, $_extension);

// Asociar App::load como la función que cargará todas las clases
spl_autoload_register(__NAMESPACE__ .'\App::load');

// Agregar clases genéricas
App::uses('Object', 'Core');
App::uses('Inflector', 'Utility');
App::uses('Configure', 'Core');
App::uses('Module', 'Core');
App::uses('Router', 'Routing');
App::uses('I18n', 'I18n');

// Clases para manejar errores y excepciones
App::uses('MiException', 'Error');
App::uses('ExceptionHandler', 'Error');
App::uses('ErrorHandler', 'Error');
include DIR_STANDARD.DS.'Error'.DS.'exceptions.php';

// Iniciar sesión
App::uses('Session', 'Model/Datasource');
Session::start();

// Cargar configuración del inicio
Configure::bootstrap();
