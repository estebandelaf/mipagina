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
App::uses('ProveedoresBaseController', 'Sistema.Controller');

// Clase para el modelo de este controlador
App::uses('Proveedor', 'Sistema.Model');

/**
 * Clase final para el controlador asociado a la tabla proveedor de la base de datos
 * Comentario de la tabla: Listado de proveedores de la empresa
 * Esta clase permite controlar las acciones entre el modelo y vista para la tabla proveedor
 * @author MiPaGiNa Code Generator
 * @version 2014-02-19 17:22:05
 */
final class ProveedoresController extends ProveedoresBaseController {

	protected $module_url = '/sistema/';

}
