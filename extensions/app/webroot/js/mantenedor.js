/**
 * Envía un formulario para filtrar por diferentes parámetros
 * @param formulario Formulario genérico que se utilizará para enviar elementos
 * @author DeLaF, esteban[at]delaf.cl
 * @version 2011-03-29
 */
function buscar (formulario) {
	var total = formulario.elements.length;
	var search = new Array();
	for (i=0; i<total; ++i) {
		campo = formulario.elements[i].name;
		valor = formulario.elements[i].value;
		if(!Form.empty(valor)) search.push(campo+':'+valor);
	}
	search = search.join(",");
	if(Form.empty(search))
		document.location.href = window.location.pathname;
	else
		document.location.href =
			window.location.pathname + '?search=' + search;
	// en teoria nunca se llega aqui, pero esta para que no reclame porque
	// buscar no retorna nada
	return false;
}

function eliminar (registro, tupla) {
	return confirm('¿Eliminar registro '+registro+'('+tupla+')?')
}
