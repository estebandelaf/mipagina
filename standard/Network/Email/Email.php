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
 * Clase para el envío de correo electrónico
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
 * @version 2010-10-09
 */
class Email {

	protected $_config = null; ///< Arreglo con la configuración para el correo electrónico
	protected $_replyTo = null; ///< A quien se debe responder el correo enviado
	protected $_to = array(); ///< Listado de destinatarios
	protected $_subject = null; ///< Asunto del correo que se enviará
	protected $_attach = array(); ///< Archivos adjuntos

	/**
	 * Constructor de la clase
	 * @param config
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2010-10-09
	 */
	public function __construct($config = 'default') {
		$this->config($config);	
	}

	/**
	 * Define la configuración con los datos para el envío
	 * @param name
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2010-10-09
	 */
	public function config ($name = 'default') {
		// Revisar que no exista la configuración ya cargada
		if($this->_config==null) {
			// Si es un arreglo, se asume es la configuración directamente
			if(is_array($name)) {
				$this->_config = $name;
			}
			// Si no es arreglo, es el nombre de la configuración
			else {
				// permite usar configuración mediante clase
				if(file_exists(DIR_WEBSITE.'/Config/email.php')) {
					include_once DIR_WEBSITE.'/Config/email.php';
					$config = new EmailConfig();
					$this->_config = $config->$name;
				}
				// si no se configura mediante clase se lee desde la configuración
				else {
					$this->_config = Configure::read('email.'.$name);
				}
			}
		}
	}

	/**
	 * Define a quién se debe responder el correo
	 * @param email
	 * @param name
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2010-10-09
	 */
	public function replyTo ($email, $name = null) {
		if($name==null) $name = $email;
		$this->_replyTo = array($name.' <'.$email.'>');
	}

	/**
	 * Asigna la lista de destinatarios
	 * @param email
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2010-10-09
	 */
	public function to ($email) {
		// En caso que se haya pasado un arreglo con los correos
		if(is_array($email)) {
			// Asignar los correos, no se copia directamente el arreglo para
			// Poder eliminar los duplicados
			foreach($email as &$e)
				$this->to($e);
		}
		// En caso que se haya pasado un solo correo
		else {
			if(!in_array($email, $this->_to))
				$this->_to[] = $email;
		}
	}

	/**
	 * Asignar asunto del correo electrónico
	 * @param subject
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2010-10-09
	 */
	public function subject ($subject) {
		$this->_subject = $subject;
	}
	
	/**
	 * Agregar un archivo para enviar en el correo
	 * @param src
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2010-10-09
	 */
	final public function attach ($src) {
		$this->_attach[] = $src;
	}

	/**
	 * Enviar correo electrónico
	 * @param msg
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2010-10-09
	 */
	public function send ($msg) {
		// Si el mensaje no es un arreglo se crea, asumiendo que se paso en formato texto
		if(!is_array($msg)) {
			$msg = array('text'=>$msg);
		}
		// Si no se ha indicado a quién responder usar el usuario que envía
		if(!$this->_replyTo) {
			if(is_array($this->_config['from']))
				$this->_replyTo = array($this->_config['from']['name'].' <'.$this->_config['from']['email'].'>');
			else
				$this->_replyTo = array($this->_config['from'].' <'.$this->_config['from'].'>');
		}
		// Crear header
		$header = array(
			'from'=>$this->_config['from'],
			'replyTo'=>$this->_replyTo,
			'to'=>$this->_to,
			'subject'=>$this->_subject
		);
		unset($this->_config['from']);
		// Crear datos (incluyendo adjuntos)
		$data = array(
			'text'=>$msg['text'],
			'html'=>isset($msg['html'])?$msg['html']:null,
			'attach'=>$this->_attach	
		);
		// Crear correo
		$class = 'Email'.ucfirst($this->_config['type']);
		App::uses($class, 'Network/Email');
		$email = new $class($this->_config, $header, $data);
		// Enviar mensaje a todos los destinatarios
		return $email->send();
	}

}
