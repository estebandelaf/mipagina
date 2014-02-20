<?php

App::uses('FormHelper', 'View/Helper');

class MaintainerHelper extends TableHelper {

	private $options;
	private $form;

	public function __construct ($options) {
		$this->options = $options;
		$this->form = new FormHelper('normal');
		$this->setClass('mantenedor');
		$this->setExport(true);
		$this->setExportRemove(array('rows'=>array(2), 'cols'=>array(-1)));
	}

	public function listar ($data, $pages, $page) {
		$_base = Request::getBase();
		$buffer = '<script type="text/javascript" src="'.$_base.'/js/mantenedor.js"></script>'."\n";
		$buffer .= $this->form->begin(array('onsubmit'=>'buscar(this)'));
		$buffer .= '<div style="float:left"><a href="'.$this->options['link'].'/crear" title="Crear nuevo registro"><img src="'.$_base.'/img/icons/16x16/actions/new.png" alt="" /></a></div>';
		if ($page)
			$buffer .= $this->paginator ($pages, $page);
		$buffer .= parent::generate ($data, 2);
		$buffer .= $this->form->end(array('type'=>null));
		$buffer .= '<div style="text-align:right;margin-bottom:1em;font-size:0.8em">';
		if($page)
			$buffer .= '<a href="'.$this->options['link'].'/listar/0'.$this->options['linkEnd'].'">Mostrar todos los registros (sin paginar)</a>';
		else
			$buffer .= '<a href="'.$this->options['link'].'/listar/1'.$this->options['linkEnd'].'">Paginar registros</a>';
		$buffer .= '</div>';
		return $buffer;
	}

	private function paginator ($pages, $page, $groupOfPages = 10) {
		$_base = Request::getBase();
		// cálculoss necesarios para crear enlaces
		$group = ceil($page/$groupOfPages);
		$from = ($group-1)*$groupOfPages + 1;
		$to = min($from+$groupOfPages-1, $pages);
		// crear enlaces para paginador
		$buffer = '<div style="float:left;margin-left:25%;width:50%;text-align:center">';
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
		$buffer .= '</div>';
		// retornar enlaces
		return $buffer;
	}

}
