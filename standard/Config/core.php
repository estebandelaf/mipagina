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
 * @file core.php
 * Configuración estándar de las páginas o aplicaciones
 */

// Errores
Configure::write('debug', true);
Configure::write('error.level', E_ALL | E_STRICT);

// Tiempo
Configure::write('time.zone', 'America/Santiago');
Configure::write('time.format', 'Y-m-d H:i:s');

// Variables que deberán ser tratadas como globales al renderizar (si
// es que existen, sino se omitirán)
Configure::write('page.globals', array('db'));

// Extensiones para las páginas que se desean renderizar
Configure::write('page.extensions', array('php', 'markdown'));

// Página inicial
Configure::write('homepage', 'inicio');

// Textos de la página
Configure::write('page.footer', 'powered by <a href="http://mi.delaf.cl/mipagina">MiPaGiNa</a>');
