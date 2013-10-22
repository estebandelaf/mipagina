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

// Clase abstracta para el controlador (padre de esta)
App::uses('PersonasBaseController', 'Sistema.Usuarios.Controller');

// Clase para el modelo de este controlador
App::uses('Persona', 'Sistema.Usuarios.Model');

/**
 * Clase final para el controlador asociado a la tabla persona de la base de datos
 * Comentario de la tabla: Listado de personas (sean o no usuarios del sistema)
 * Esta clase permite controlar las acciones entre el modelo y vista para la tabla persona
 * @author MiPaGiNa Code Generator
 * @version 2013-06-25 14:08:16
 */
final class PersonasController extends PersonasBaseController {

	protected $module_url = '/sistema/usuarios/';

}
