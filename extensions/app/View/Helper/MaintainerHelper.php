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

// clase que extiende este helper
App::uses('FormHelper', 'View/Helper');

/**
 * Clase para generar los mantenedores
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
 * @version 2014-03-10
 */
class MaintainerHelper extends TableHelper {

	private $options; ///< Opciones del mantenedor
	private $form; ///< Formulario (objeto de FormHelper) que se está usando en el mantenedor

	/**
	 * Constructor de la clase
	 * @param options Arreglo con las opciones para el mantenedor
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2014-03-10
	 */
	public function __construct ($options) {
		$this->options = $options;
		$this->form = new FormHelper('normal');
		$this->setClass('mantenedor');
		$this->setExport(true);
		$this->setExportRemove(array('rows'=>array(2), 'cols'=>array(-1)));
	}

	/**
	 * Método que generará el mantenedor y listará los registros disponibles
	 * @param data Registros que se deben renderizar
	 * @param pages Cantidad total de páginas que tienen los registros
	 * @param page Página que se está revisando o 0 para no usar el paginador
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2014-03-10
	 */
	public function listar ($data, $pages, $page) {
		$_base = Request::getBase();
		$buffer = '<script type="text/javascript" src="'.$_base.'/js/mantenedor.js"></script>'."\n";
		$buffer .= $this->form->begin(array('onsubmit'=>'buscar(this)'))."\n";
		$buffer .= '<div style="float:left"><a href="'.$this->options['link'].'/crear" title="Crear nuevo registro"><img src="'.$_base.'/img/icons/16x16/actions/new.png" alt="" /></a></div>'."\n";
		if ($page)
			$buffer .= $this->paginator ($pages, $page)."\n";
		$buffer .= parent::generate ($data, 2);
		$buffer .= $this->form->end(array('type'=>null))."\n";
		$buffer .= '<div style="text-align:right;margin-bottom:1em;font-size:0.8em">'."\n";
		if($page)
			$buffer .= '<a href="'.$this->options['link'].'/listar/0'.$this->options['linkEnd'].'">Mostrar todos los registros (sin paginar)</a>'."\n";
		else
			$buffer .= '<a href="'.$this->options['link'].'/listar/1'.$this->options['linkEnd'].'">Paginar registros</a>'."\n";
		$buffer .= '</div>'."\n";
		return $buffer;
	}

	/**
	 * Método que genera el paginador para el mantenedor
	 * @param pages Cantidad total de páginas que tienen los registros
	 * @param page Página que se está revisando o 0 para no usar el paginador
	 * @param groupOfPages De a cuantas páginas se mostrará en el paginador
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2014-03-10
	 */
	private function paginator ($pages, $page, $groupOfPages = 10) {
		$_base = Request::getBase();
		// cálculoss necesarios para crear enlaces
		$group = ceil($page/$groupOfPages);
		$from = ($group-1)*$groupOfPages + 1;
		$to = min($from+$groupOfPages-1, $pages);
		// crear enlaces para paginador
		$buffer = '<div style="float:left;margin-left:20%;width:50%;text-align:center">'."\n";
		if ($page==1)
			$buffer .= '<img src="'.$_base.'/img/icons/20x20/paginator/firstpage_off.png" alt="" style="margin-right:10px" />';
		else
			$buffer .= '<a href="'.$this->options['link'].'/listar/1'.$this->options['linkEnd'].'" title="Ir a la primera página"><img src="'.$_base.'/img/icons/20x20/paginator/firstpage_on.png" alt="" style="margin-right:10px" /></a>';
		if ($group==1)
			$buffer .= '<img src="'.$_base.'/img/icons/20x20/paginator/prevgroup_off.png" alt="" style="margin-right:10px" />';
		else
			$buffer .= '<a href="'.$this->options['link'].'/listar/'.($from-1).$this->options['linkEnd'].'" title="Ir al grupo de páginas anterior (página '.($from-1).')"><img src="'.$_base.'/img/icons/20x20/paginator/prevgroup_on.png" alt="" style="margin-right:10px" /></a>';
		for($i=$from; $i<=$to; $i++) {
			if($page==$i)
				$buffer .= '<span style="font-weight:bold;font-size:16px;margin-right:10px">'.$i.'</span> ';
			else
				$buffer .= '<a href="'.$this->options['link'].'/listar/'.$i.$this->options['linkEnd'].'" style="font-weight:bold;font-size:16px;margin-right:10px" title="Ir a la página '.$i.'">'.$i.'</a> ';
		}
		if ($group==ceil($pages/$groupOfPages))
			$buffer .= '<img src="'.$_base.'/img/icons/20x20/paginator/nextgroup_off.png" alt="" style="margin-right:10px" />';
		else
			$buffer .= '<a href="'.$this->options['link'].'/listar/'.($to+1).$this->options['linkEnd'].'" title="Ir al grupo de páginas siguiente (página '.($to+1).')"><img src="'.$_base.'/img/icons/20x20/paginator/nextgroup_on.png" alt="" style="margin-right:10px" /></a>';
		if ($page==$pages)
			$buffer .= '<img src="'.$_base.'/img/icons/20x20/paginator/lastpage_off.png" alt="" />';
		else
			$buffer .= '<a href="'.$this->options['link'].'/listar/'.$pages.$this->options['linkEnd'].'" title="Ir a la última página"><img src="'.$_base.'/img/icons/20x20/paginator/lastpage_on.png" alt="" /></a>';
		$buffer .= '</div>'."\n";
		// retornar enlaces
		return $buffer;
	}

}
