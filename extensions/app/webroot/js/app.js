/**
 * Implementación sincrónica de $.getJSON, esto para poder recuperar
 * el objeto json fuera de la funcion que se ejecuta en success
 * @param url
 * @param data
 * @return json
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
 * @version 2011-05-02
 */
function getJSON (url, data) {
	var json;
	$.ajax({
		type: 'GET',
		url: url,
		dataType: 'json',
		success: function (result) {json = result;},
		data: data,
		async: false
	});
	return json;
} 

function autocomplete (id, url) {
	var field = id+'Field';
	$(function(){ $('#'+field).keyup(function(){
		if($('#'+field).val()!='' && $('#'+field).val().length > 2) {
			$.getJSON(url, { filter: $('#'+field).val() }, function(data) {
				var items = [];
				$.each(data, function(key, val) {
					items.push(val.glosa);
				});
				$('#'+field).autocomplete({
					source: items
					, autoFocus: true
					, minLength: 3
				});
			});
		}
	});});
}

/**
 * Función que formatea un número
 * @author http://joaquinnunez.cl/blog/2010/09/20/formatear-numeros-con-punto-como-separador-de-miles-con-javascript/
 */
function num (n) {
	var number = new String(n);
	var result='';
	var isNegative = false;
	if(number.indexOf('-')>-1) {
		number = number.substr(1);
		isNegative=true;
	}
	while( number.length > 3 ) {
		result = '.' + number.substr (number.length - 3) + result;
		number = number.substring(0, number.length - 3);
	}
	result = number + result;
	if(isNegative) result = '-'+result;
	return result;
}
