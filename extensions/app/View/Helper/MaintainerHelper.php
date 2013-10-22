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
		$buffer .= $this->paginator ($pages, $page);
		$buffer .= parent::generate ($data);
		$buffer .= $this->form->end(array('type'=>null));
		$buffer .= '<div style="float:right;margin-bottom:1em;font-size:0.8em">';
		if($page)
			$buffer .= '<a href="'.$this->options['link'].'/listar/0'.$this->options['linkEnd'].'">Mostrar todos los registros (sin paginar)</a>';
		else
			$buffer .= '<a href="'.$this->options['link'].'/listar/1'.$this->options['linkEnd'].'">Paginar registros</a>';
		$buffer .= '</div>';
		return $buffer;
	}

	private function paginator ($pages, $page) {
		$buffer = '<div style="float:left;margin-left:25%;width:50%;text-align:center">';
		for($i=1; $i<=$pages; $i++) {
			if($page==$i)
				$buffer .= $i.' ';
			else
				$buffer .= '<a href="'.$this->options['link'].'/listar/'.$i.$this->options['linkEnd'].'">'.$i.'</a> ';
		}
		$buffer .= '</div>';
		return $buffer;
	}

}
