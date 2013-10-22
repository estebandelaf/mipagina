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

// desactivar errores (ya que Mail genera problemas al estar E_STRICT activo)
ini_set('error_reporting', 0);

/**
 * Clase para enviar correo electrónico mediante SMTP
 * Requiere: pear install Mail Mail_mime Net_SMTP
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
 * @version 2010-10-09
 */
class EmailSmtp {

	protected $_config = null; ///< Configuración para SMTP
	protected $_header = null; ///< Datos de la cabecera del mensaje
	protected $_data = null; ///< Datos del mensaje (incluyendo adjuntos)

	/**
	 * Constructor de la clase
	 * @config
	 * @header
	 * @data
	 * @debug
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2010-10-09
	 */
	public function __construct ($config, $header, $data, $debug = false) {
		// clases PEAR
		require 'Mail.php';
		require 'Mail/mime.php';
		// Configuración para la conexión al servidor
		$this->_config = array(
			'host'		=> $config['host'],
			'port'		=> $config['port'],
			'auth'		=> true,
			'username'	=> $config['user'],
			'password'	=> $config['pass'],
			'debug'		=> $debug
		);
		// Cabecera
		$this->_header = $header;
		// Datos
		$this->_data = $data;
	}
	
	/**
	 * Método que envía el correo
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2010-10-09
	 */
	public function send () {
		// Crear correo
		$mailer = Mail::factory('smtp', $this->_config);
		$mail = new Mail_mime();
		// codificacion
		$mail->_build_params['text_encoding'] = '8bit';
		$mail->_build_params['text_charset'] = 'UTF-8';
		$mail->_build_params['html_charset'] = 'UTF-8';
		$mail->_build_params['head_charset'] = 'UTF-8';
		$mail->_build_params['head_encoding'] = '8bit';
		// Asignar mensaje
		$mail->setTXTBody($this->_data['text']);
		$mail->setHTMLBody($this->_data['html']);
		// Si existen archivos adjuntos agregarlos
		if(!empty($this->_data['attach'])) {
			foreach($this->_data['attach'] as $file) {
				$mail->addAttachment($file['tmp_name'], $file['type'], $file['name']);
			}
		}
		// cuerpo y cabecera
		$body = $mail->get(); // debe llamarse antes de headers
		$headers = $mail->headers(array(
			'From' => "{$this->_header['from']['name']} <{$this->_header['from']['email']}>",
			'Reply-To' => $this->_header['replyTo'],
			'Return-Path' => $this->_header['replyTo'],
			'Subject' => $this->_header['subject'],
		));
		// Enviar correo a todos los destinatarios
		$status = array();
		foreach($this->_header['to'] as $to) {
			// Enviar correo al destinatario
			$mailer->send($mail->encodeRecipients($to), $headers, $body);
			// Guardar estado de error en caso de que haya algún problema
			if (PEAR::isError($mailer)) {
				$status[$to] = $mail->getMessage();
			}
		}
		// Retornar estado del envío
		return $status;
	}

}
