<?php

/**
 * MiPaGiNa (MP)
 * Copyright (C) 2013 Esteban De La Fuente Rubio (esteban[at]delaf.cl)
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
 * Manejar archivos json
 *
 * Esta clase permite leer y generar archivos json
 * @author DeLaF, esteban[at]delaf.cl
 * @version 2013-07-05
 */
final class JSON {

	public static function read ($archivo) {
	}

	public static function generate ($data, $id) {
		// limpiar posible contenido envíado antes
		ob_clean();
		// cabeceras del archivo
		header('Content-type: application/json');
		header('Content-Disposition: inline; filename='.$id.'.json');
		header('Pragma: no-cache');
		header('Expires: 0');
		// cuerpo del archivo
		echo json_encode($data);
		// liberar memoria y terminar script
		unset($titles, $data, $id);
		exit(0);
	}

}
