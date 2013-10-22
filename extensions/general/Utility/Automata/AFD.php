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
 * Clase para trabajar con un autómata finito determinístico (AFD)
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
 * @version 2013-08-17
 */

class AFD {

	private $transitions; ///< Transiciones del autómata
	private $q0; ///< Estado inicial del autómata
	private $F; ///< Conjunto de estados finales
	private $status; ///< Estado en que se detuvo el AFD

	/**
	 * Constructor de la clase
	 *
	 * Ejemplo de llamada:
	 * \code
	   $t = array(0=>array('a'=>1, 'b'=>'0'), 1=>array('a'=>0, 'b'=>'1'));
	   $F = array(1);
	   $q0 = 0;
	   $afd = new AFD($t, $F, $q0);
	   \endcode
	 *
	 * @param transitions Transiciones definidas para el AFD
	 * @param F Estados finales de aceptación
	 * @param q0 Estado inicial del AFD
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2013-08-15
	 */
	public function AFD ($transitions = array(), $F = array(), $q0 = 0) {
		$this->transitions = $transitions;
		$this->F = $F;
		$this->q0 = $q0;
	}

	/**
	 * Método que evalua la entrada según las transiciones del autómata
	 * @param input Entrada para el AFD (un string o un arreglo de símbolos)
	 * @return =true si el estado de detención es de aceptación
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2013-08-15
	 */
	public function run ($input) {
		$estado = $this->q0;
		$simbols = is_array($input) ? count($input) : strlen($input);
		for ($i=0; $i<$simbols; ++$i) {
			if (isset($this->transitions[$estado][$input[$i]])) {
				$estado =
					$this->transitions[$estado][$input[$i]];
			}
		}
		$this->status = $estado;
		return in_array($estado, $this->F);	
	}

	/**
	 * Obtener el estado final en que se detuvo el AFD
	 * @return Entrega el estado donde se detuvo el AFD después de correr
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2013-08-17
	 */
	public function getFinalState () {
		return $this->status;
	}

}
