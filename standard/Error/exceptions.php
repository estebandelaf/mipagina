<?php

/**
 * @file exceptions.php
 * Archivo con clases para excepciones
 * @todo Documentar clases
 */

class MissingControllerException extends MiException {
	protected $_messageTemplate = 'Controlador %s no fue encontrado';
	public function __construct($message, $code = 404) {
		parent::__construct($message, $code);
	}
}

class MissingActionException extends MiException {
	protected $_messageTemplate = 'Acción %s::%s() no fue encontrada';
	public function __construct($message, $code = 404) {
		parent::__construct($message, $code);
	}
}

class PrivateActionException extends MiException {
	protected $_messageTemplate = 'Acción %s::%s() es privada y no puede ser accedida mediante la URL';
	public function __construct($message, $code = 401) {
		parent::__construct($message, $code);
	}
}

class MissingHelperException extends MiException {
	protected $_messageTemplate = 'Clase del helper %s no fue encontrada';
}

class MissingComponentException extends MiException {
	protected $_messageTemplate = 'Componente %s no fue encontrado';
}

class MissingModuleException extends MiException {
	protected $_messageTemplate = 'Módulo %s no fue encontrado';
}

class MissingDatabaseException extends MiException {
	protected $_messageTemplate = '%s al ejecutar la consulta %s';
}

class MissingViewException extends MiException {
	protected $_messageTemplate = 'Vista %s para acción %s::%s() no ha sido encontrada';
}

class MiErrorException extends MiException {
	protected $_messageTemplate = '%s';
}
