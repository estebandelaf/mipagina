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
App::uses('ActividadEconomicasBaseController', 'Sistema.General.Controller');

// Clase para el modelo de este controlador
App::uses('ActividadEconomica', 'Sistema.General.Model');

/**
 * Clase final para el controlador asociado a la tabla actividad_economica de la base de datos
 * Comentario de la tabla: Actividades económicas del país
 * Esta clase permite controlar las acciones entre el modelo y vista para la tabla actividad_economica
 * @author MiPaGiNa Code Generator
 * @version 2014-02-13 15:24:39
 */
final class ActividadEconomicasController extends ActividadEconomicasBaseController {

	protected $module_url = '/sistema/general/';

}
