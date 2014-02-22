<h1>Iniciar sesión</h1>
<?php
$form = new FormHelper();
echo $form->begin(array('focus'=>'usuario', 'onsubmit'=>'Form.check()'));
echo $form->input(array(
	'name'=>'usuario',
	'label'=>'Usuario',
	'check'=>'notempty',
));
echo $form->input(array(
	'type'=>'password',
	'name'=>'contrasenia',
	'label'=>'Contraseña',
	'check'=>'notempty'
));
echo $form->end('Ingresar');
?>
<p>¿No recuerda su usuario o contraseña?, <a href="<?php echo $_base;
?>/usuarios/contrasenia/recuperar">click aquí para recuperar</a>.</p>
