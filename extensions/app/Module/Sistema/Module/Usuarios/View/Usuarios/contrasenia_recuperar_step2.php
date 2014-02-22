<h1>Recuperación de contraseña del usuario <em><?php echo $usuario; ?></em></h1>
<p>A continuación ingrese el código que le fue enviado por correo electrónico y su nueva contraseña.</p>
<?php
$f = new FormHelper ();
echo $f->begin(array('focus'=>'codigo', 'onsubmit'=>'Form.check()'));
echo $f->input (array(
	'name'=>'codigo',
	'label'=>'Código',
	'check'=>'notempty'
));
echo $f->input (array(
	'type'=>'password',
	'name'=>'contrasenia1',
	'label'=>'Contraseña',
	'check'=>'notempty'
));
echo $f->input (array(
	'type'=>'password',
	'name'=>'contrasenia2',
	'label'=>'Repetir contraseña',
	'check'=>'notempty'
));
echo $f->end('Cambiar contraseña');
