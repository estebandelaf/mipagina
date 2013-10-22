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
