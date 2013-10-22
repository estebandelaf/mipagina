<script type="text/javascript" src="<?php echo $_base; ?>/js/mantenedor.js"></script>
<h1>Listado de Personas</h1>
<p>Listado de personas (sean o no usuarios del sistema).</p>

<?php

// url del módulo en caso que la vista pertenezca a uno
$module_url = '/sistema/usuarios/';

// columnas que se utilizarán en la tabla que se desplegará
$columns = array(
	'run' => 'Run',
//	'dv' => 'Dv',
	'nombres' => 'Nombres',
	'apellido_paterno' => 'Apellido Paterno',
	'apellido_materno' => 'Apellido Materno',
//	'sexo' => 'Sexo',
//	'fecha_de_nacimiento' => 'Fecha De Nacimiento',
//	'email' => 'Email',
	'imagen' => array('type' => 'file', 'name' => 'Imagen')
);

// preparar títulos de columnas (con link para ordenar por dicho campo)
$titles = array();
foreach($columns as $column => &$name) {
	// si es un arreglo se extrae el nombre
	if(is_array($name)) {
		$titles[] = $name['name'];
	}
	// si es un campo normal
	else {
		$titles[] = $name.'<br>'.
			'<a href="'.$_base.$module_url.$controller.'/listar/'.$page.'/'.$column.'/D'.$searchUrl.'" title="Ordenar descendentemente por '.$name.'"><img src="'.$_base.'/img/icons/16x16/actions/down.png" alt="" /></a>'.
			'<a href="'.$_base.$module_url.$controller.'/listar/'.$page.'/'.$column.'/A'.$searchUrl.'" title="Ordenar ascendentemente por '.$name.'"><img src="'.$_base.'/img/icons/16x16/actions/up.png" alt="" /></a>'
		;
	}
}
$titles[] = 'Acciones';

// crear arreglo para la tabla y agregar títulos de columnas
$data = array($titles);

// agregar fila para búsqueda mediante formulario
$row = array();
$form = new FormHelper('normal');
$optionsBoolean = array(array('', 'Seleccione una opción'), array('t', 'Si'), array('f', 'No'));
foreach($columns as $column => &$name) {
	// si es un archivo
	if(is_array($name) && $name['type']=='file') {
		$row[] = '';
	}
	// si es de tipo boolean se muestra lista desplegable
	else if($columnsInfo[$column]['type']=='boolean') {
		$row[] = $form->input(array('type'=>'select', 'name'=>$column, 'options' => $optionsBoolean, 'selected' => (isset($search[$column])?$search[$column]:'')));
	}
	// si es llave foránea
	else if($columnsInfo[$column]['fk']) {
		$class = Inflector::camelize($columnsInfo[$column]['fk']['table']);
		$classs = Inflector::camelize(Inflector::pluralize($columnsInfo[$column]['fk']['table']));
		App::uses($class, 'Sistema.Usuarios.Model');
		$objs = new $classs();
		$options = $objs->getList();
		array_unshift($options, array('', 'Seleccione una opción'));
		$row[] = $form->input(array('type'=>'select', 'name'=>$column, 'options' => $options, 'selected' => (isset($search[$column])?$search[$column]:'')));
	}
	// si es cualquier otro tipo de datos
	else {
		$row[] = $form->input(array('name'=>$column, 'value'=>(isset($search[$column])?$search[$column]:'')));
	}
}
$row[] = '<input type="image" src="'.$_base.'/img/icons/16x16/actions/search.png" alt="Buscar" title="Buscar" />';
$data[] = $row;

// crear filas de la tabla
foreach($Personas as &$obj) {
	$row = array();
	foreach($columns as $column => &$name) {
		// si es un archivo
		if(is_array($name) && $name['type']=='file') {
			if($obj->{$column.'_size'})
				$row[] = '<a href="'.$_base.$module_url.$controller.'/d/'.$column.'/'.urlencode($obj->run).'"><img src="'.$_base.'/img/icons/16x16/actions/download.png" alt="" /></a>';
			else
				$row[] = '';
		}
		// si es boolean se usa Si o No según corresponda
		else if($columnsInfo[$column]['type']=='boolean') {
			$row[] = $obj->{$column}=='t' ? 'Si' : 'No';
		}
		// si es llave foránea
		else if($columnsInfo[$column]['fk']) {
			// si no es vacía la columna
			if(!empty($obj->{$column})) {
				$method = 'get'.Inflector::camelize($column);
				$row[] = $obj->$method()->{$columnsInfo[$column]['fk']['table']};
			} else {
				$row[] = '';
			}
		}
		// si es cualquier otro tipo de datos
		else {
			$row[] = $obj->{$column};
		}
	}
	$row[] =
		'<a href="'.$_base.$module_url.$controller.'/editar/'.urlencode($obj->run).'" title="Editar"><img src="'.$_base.'/img/icons/16x16/actions/edit.png" alt="" /></a> '.
		'<a href="'.$_base.$module_url.$controller.'/eliminar/'.urlencode($obj->run).'" title="Eliminar" onclick="return eliminar(\'Persona\', \''.$obj->run.'\')"><img src="'.$_base.'/img/icons/16x16/actions/delete.png" alt="" /></a>';
	$data[] = $row;
}

// renderizar el mantenedor
App::uses('MaintainerHelper', 'View/Helper');
$maintainer = new MaintainerHelper (array(
	'link' => $_base.$module_url.$controller,
	'linkEnd' => $linkEnd,
));
$maintainer->setId('Personas');
echo $maintainer->listar ($data, $pages, $page);
