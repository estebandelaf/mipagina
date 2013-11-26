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
 * Helper para la creación de formularios en HTML
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
 * @version 2013-11-25
 */
class FormHelper {

	private $_id; ///< Identificador para el formulario
	private $_formato; ///< Formato del formulario que se renderizará (mantenedor u false)
	
	/**
	 * Método que inicia el código del formulario
	 * @param formato Formato del formulario que se renderizará
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-09-21
	 */
	public function __construct ($formato = 'mantenedor') {
		$this->_formato = $formato;
	}

	/**
	 * Método que inicia el código del formulario
	 * @param config Arreglo con la configuración para el formulario
	 * @return String Código HTML de lo solicitado
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2013-06-15
	 */
	public function begin ($config = array()) {
		// transformar a arreglo en caso que no lo sea
		if(!is_array($config)) {
			$config = array('action'=>$config);
		}
		// asignar configuración
		$config = array_merge(
			array(
				'id' => 'id',
				'action' => $_SERVER['REQUEST_URI'],
				'method'=> 'post',
				'onsubmit' => null,
				'focus' => null,
			), $config
		);
		// crear onsubmit
		if($config['onsubmit']) {
			$config['onsubmit'] = ' onsubmit="return '.$config['onsubmit'].'"';
		}
		// crear buffer
		$buffer = '';
		// si hay focus se usa
		if($config['focus']) {
			$buffer .= '<script type="text/javascript"> $(function() { $("#'.$config['focus'].'Field").focus(); }); </script>'."\n";
		}
		// agregar formulario 
		$buffer .= '<form action="'.$config['action'].'" method="'.$config['method'].'" enctype="multipart/form-data"'.$config['onsubmit'].' id="'.$config['id'].'">'."\n";
		// retornar
		return $buffer;
	}
	
	/**
	 * Método que termina el código del formulario
	 * @param config Arreglo con la configuración para el botón submit
	 * @return String Código HTML de lo solicitado
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2013-03-25
	 */
	public function end ($config = array()) {
		// solo se procesa la configuración si no es falsa
		if($config!==false) {
			// transformar a arreglo en caso que no lo sea
			if(!is_array($config))
				$config = array('value'=>$config);
			// asignar configuración
			$config = array_merge(
				array(
					'type' => 'submit',
					'name' => 'submit',
					'value' => 'Enviar',
					'label' => '',
				), $config
			);
			// generar buffer
			$buffer = '';
			if($config['type']) $buffer .= $this->input($config);
			$buffer .= '</form>'."\n";
			// retornar buffer
			return $buffer;
		} else {
			return '</form>'."\n";
		}
	}

	/**
	 * Método que aplica o no un diseño al campo
	 * @param field Campo que se desea formatear
	 * @param config Arreglo con la configuración para el elemento
	 * @return String Código HTML de lo solicitado
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-11-08
	 */
	private function _formatear ($field, $config) {
		// si se debe aplicar estilo de mantenedor
		if(!in_array($config['type'], array('hidden', 'js')) && $this->_formato=='mantenedor') {
			$buffer = '';
			// generar ayuda
			if($config['help']!='') {				
				$actions = 'onmouseover="$(\'#'.$config['name'].'FieldHelp\').dialog()" onmouseout="$(\'#'.$config['name'].'FieldHelp\').dialog(\'close\')"';
				;
				$config['help'] =
					' <a href="#" onclick="return false" '.$actions.'>'.
					'<img src="'.Request::getBase().'/img/icons/16x16/actions/help.png" alt="" /></a>'.
					'<div id="'.$config['name'].'FieldHelp" title="'.$config['label'].'" style="display:none" '.$actions.'>'.$config['help'].'</div>'
				;
			}
			// generar campo
			$buffer .= '<div class="input">'."\n";
			if(!empty($config['label']))
				$buffer .= '	<div class="label"><label for="'.$config['name'].'Field">'.$config['label'].'</label></div>'."\n";
			else
				$buffer .= '	<div class="label">&nbsp;</div>'."\n";
			$buffer .= '	<div class="field">'.$field.$config['help'].'</div>'."\n";
			$buffer .= '</div>'."\n";
		}
		// si no se debe aplicar ningún formato solo agregar EOL
		else {
			$buffer = $field."\n";
		}
		// retornar código formateado
		return $buffer;
	}
	
	/**
	 * Método para crear una nuevo campo para que un usuario ingrese
	 * datos a través del formulario, ya sea un tag: input, select, etc
	 * @param config Arreglo con la configuración para el elemento
	 * @return String Código HTML de lo solicitado
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2013-11-25
	 */
	public function input ($config) {
		// transformar a arreglo en caso que no lo sea
		if(!is_array($config))
			$config = array('name'=>$config, 'label'=>$config);
		// asignar configuración
		$config = array_merge(
			array(
				'type'=>'text',
				'value'=>'',
				'autoValue'=>false,
				'class' => '',
				'attr' => '',
				'check' => null,
				'help' => '',
			), $config
		);
		// si no se indico un valor y existe uno por POST se usa
		if (!isset($config['value'][0]) && isset($_POST[$config['name']])) {
			$config['value'] = $_POST[$config['name']];
		}
		// si label no existe se usa el nombre de la variable
		if(!isset($config['label'])) $config['label'] = $config['name'];
		// si se paso check se usa
		if($config['check']) {
			// si no es arreglo se convierte
			if(!is_array($config['check'])) $config['check'] = array($config['check']);
			// hacer implode, agregar check y meter al class
			$config['class'] = $config['class'].' check '.implode(' ', $config['check']);
		}
		// si se paso class se usa
		if($config['class']!='') $config['class'] = ' class="'.$config['class'].'"';
		// generar buffer
		$buffer = $this->_formatear($this->{'_'.$config['type']}($config), $config);
		// retornar buffer
		return $buffer;
	}

	private function _submit ($config) {
		return '<input type="'.$config['type'].'" name="'.$config['name'].'" value="'.$config['value'].'" />';
	}

	private function _hidden ($config) {
		return '<input type="hidden" name="'.$config['name'].'" value="'.$config['value'].'" />';
	}

	private function _text ($config) {
		return '<input type="text" name="'.$config['name'].'" value="'.$config['value'].'" id="'.$config['name'].'Field"'.$config['class'].' '.$config['attr'].' />';
	}
	
	private function _password($config) {
		return '<input type="password" name="'.$config['name'].'" id="'.$config['name'].'Field"'.$config['class'].' '.$config['attr'].' />';
	}

	private function _textarea ($config) {
		$config = array_merge(
			array(
				'rows'=>5,
				'cols'=>10
			), $config
		);
		return '<textarea name="'.$config['name'].'" rows="'.$config['rows'].'" cols="'.$config['cols'].'" id="'.$config['name'].'Field"'.$config['class'].' '.$config['attr'].'>'.$config['value'].'</textarea>';	
	}

	private function _checkbox ($config) {
		$checked = isset($config['checked']) && $config['checked'] ? 'checked="checked"' : '';
		return '<input type="checkbox" name="'.$config['name'].'" value="'.$config['value'].'" id="'.$config['name'].'Field" '.$checked.''.$config['class'].' '.$config['attr'].'/>';
	}

	/**
	 * @todo No se está utilizando checked
	 * @warning icono para ayuda queda abajo (por los <br/>)
	 */
	private function _checkboxes ($config) {
		$buffer = '';
		foreach($config['options'] as $option) {
			$key = array_shift($option);
			$value = array_shift($option);
			$buffer .= '<input type="checkbox" name="'.$config['name'].'[]" value="'.$key.'" '.$config['class'].' '.$config['attr'].'/> '.$value.'<br />';
		}
		return $buffer;
	}

	private function _date ($config) {
		$options = 'dateFormat: "yy-mm-dd", changeYear: true, yearRange: "1900:'.date('Y').'"';
		$buffer = '<script type="text/javascript">$(function() { $("#'.$config['name'].'Field").datepicker({ '.$options.' }); }); </script>';
		$buffer .= '<input type="text" name="'.$config['name'].'" value="'.$config['value'].'" id="'.$config['name'].'Field"'.$config['class'].' '.$config['attr'].' />';
		return $buffer;
	}

	private function _file ($config) {
		return '<input type="file" name="'.$config['name'].'" id="'.$config['name'].'Field"'.$config['class'].' '.$config['attr'].' />';
	}
	
	private function _select ($config) {
		$config = array_merge(array(
			'selected'=>''
			), $config);
		$buffer = '';
		$buffer .= '<select name="'.$config['name'].'" id="'.$config['name'].'Field"'.$config['class'].' '.$config['attr'].'>';
		foreach($config['options'] as $option) {
			$key = array_shift($option);
			$value = array_shift($option);
			$buffer .= '<option value="'.$key.'"'.($config['selected']==$key?' selected="selected"':'').'>'.$value.'</option>';
		}
		$buffer .= '</select>';
		return $buffer;
	}

	private function _js ($config) {
		$buffer = '';
		$buffer .= '<div>'."\n";
		$buffer .= '	<div class="label">'.$config['label'].' <a href="javascript:'.$config['js'].'()" title="Agregar"><img src="'.Request::getBase().'/img/icons/16x16/actions/add.png" alt="add" /></a></div>'."\n";
		$buffer .= '	<div class="field"><div id="'.$config['id'].'">'.$config['value'].'</div></div>'."\n";
		$buffer .= '	<div class="clear"></div>'."\n";
		$buffer .= '</div>'."\n";
		return $buffer;
	}
	
	private function _radios ($config) {
		$buffer = '';
		foreach($config['options'] as &$option) {
			$key = array_shift($option);
			$value = array_shift($option);
			$checked = isset($config['checked']) && $config['checked']==$key ? 'checked="checked"' : '';
			$buffer .= ' <input type="radio" name="'.$config['name'].'" value="'.$key.'" '.$checked.'> '.$value.' ';
		}
		return $buffer;
	}

}
