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

function Form() {
}

Form.empty = function (obj) {
	if (typeof obj == 'undefined' || obj === null || obj === '') return true;
	if (typeof obj == 'number' && isNaN(obj)) return true;
	if (obj instanceof Date && isNaN(Number(obj))) return true;
	return false;
}

Form.isInt = function (value) {
	if((parseFloat(value) == parseInt(value)) && !isNaN(value)) {
		return true;
	} else {
		return false;
	}
}

Form.checkNotempty = function (field) {
	// en caso que se a vacío
	if(Form.empty(field.value)) {
		var label = $(field).parent().parent().children('.label').text().replace('*', '');
		alert('¡' + label + ' no puede estar en blanco!');
		field.focus();
		return false
	}
	// retornar ok
	return true;
}

Form.checkEmail = function (field) {
	// se asume todo ok
	var status = true;
	// verificar en caso que no sea el formato
	var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if (!filter.test(field.value)) {
		var label = $(field).parent().parent().children('.label').text().replace('*', '');
		alert('¡' + label + ' no es válido!');
		field.focus();
		status = false;
	}
	// retornar
	return status;
}

Form.checkInteger = function (field) {
	// en caso que no sea un número entero
	if(!Form.isInt(field.value)) {
		var label = $(field).parent().parent().children('.label').text().replace('*', '');
		alert('¡' + label + ' debe ser un número entero!');
		field.focus();
		return false
	}
	// retornar ok
	return true;
}

Form.checkDate = function (field) {
	// se asume todo ok
	var status = true;
	// verificar en caso que no sea el formato
	var filter = /^\d{4}[\-](0?[1-9]|1[012])[\-](0?[1-9]|[12][0-9]|3[01])$/;
	if (!filter.test(field.value)) {
		var label = $(field).parent().parent().children('.label').text().replace('*', '');
		alert('¡' + label + ' debe estar en formato AAAA-MM-DD!');
		field.focus();
		status = false;
	}
	// retornar
	return status;
}

Form.check = function (id) {
	// asumir que todo está ok
	var status = true;
	// seleccionar campos que se deben chequear
	if (id) fields = $('#'+id+' .check');
	else fields = $('.check');
	// procesar campos que se deben chequear
	$.each(fields, function(key, field) {
		// cosas que se deben chequear
		var check = $(field).attr('class').split(' ');
		// verificar que el campo no sea vacío
		if($.inArray('notempty', check)>=0) {
			status = Form.checkNotempty(field);
			if(!status) return false;
		}
		// verificar formato email
		if($.inArray('email', check)>=0) {
			status = Form.checkEmail(field);
			if(!status) return false;
		}
		// verificar si es un entero
		if($.inArray('integer', check)>=0) {
			status = Form.checkInteger(field);
			if(!status) return false;
		}
		// verificar si es una fecha
		if($.inArray('date', check)>=0) {
			status = Form.checkDate(field);
			if(!status) return false;
		}
	});
	return status;
}

Form.checkSend = function (msg) {
	// si no se específico un mensaje se usa uno por defecto
	if(Form.empty(msg))
		msg = '¿Estás seguro de enviar el formulario?';
	// consultar al usuario con cuadro de confirmación
	if(confirm(msg)) {
		return true;
	} else {
		return false;
	}
}
