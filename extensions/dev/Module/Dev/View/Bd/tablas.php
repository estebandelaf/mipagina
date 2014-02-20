<h1>Información de tablas de la Base de Datos</h1>
<?php
$f = new FormHelper ();
echo $f->begin(array('onsubmit'=>'Form.check()'));
echo $f->input (array(
	'type'=>'select',
	'name'=>'database',
	'label'=>'Base de datos',
	'options'=>$databases,
	'check'=>'notempty',
	'help'=>'Nombre de la base de datos definida dentro de la configuración en Config/core.php',
));
echo $f->end('Ver tablas');

if (isset($data)) {
	array_unshift ($data, array('Tabla', 'Descripción', 'Columnas', 'PK'));
	new TableHelper ($data, 'tablas_'.$database, true);
}
