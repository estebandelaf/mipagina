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
 * @file es.php
 * Reglas de español para clase Inflector
 * @author http://joecabezas.tumblr.com/post/572538183/espanolizando-cakephp-mediante-inflections-version
 * @version 2014-02-24
 */

Inflector::rules('singular', array(
	'rules' => array (
		'/bles$/i' => 'ble', // by DeLaF
		'/([r|d|j|n|l|m|y|z])es$/i' => '\1',
		'/as$/i' => 'a',
		'/([ti])a$/i' => '\1a'
	),
	'irregular' => array(),
	'uninflected' => array()
));

Inflector::rules('plural', array(
	'rules' => array (
		'/([r|d|j|n|l|m|y|z])$/i' => '\1es',
		'/a$/i' => '\1as'
	),
	'irregular' => array(),
	'uninflected' => array()
));
