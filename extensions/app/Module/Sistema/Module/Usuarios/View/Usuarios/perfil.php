<h1>Perfil del usuario <em><?php echo $Usuario->usuario; ?></em></h1>
<div class="fright">
	<a href="<?php echo $_base; ?>/usuarios/imagen/<?php echo $Usuario->id; ?>">
		<img src="<?php echo $_base; ?>/usuarios/imagen/<?php echo $Usuario->id; ?>/small" alt="" style="border:1px solid black" />
	</a>
</div>

<h2>Datos personales</h2>
<?php
$form = new FormHelper();
echo $form->begin(array(
	'id' => 'datosPersonales',
	'onsubmit' => 'Form.check(\'datosPersonales\')'
));
echo $form->input(array(
	'name' => 'nombres',
	'label' => 'Nombres',
	'value' => $Persona->nombres,
	'help' => 'Nombre o nombres reales del usuario',
	'check' => 'notempty',
));
echo $form->input(array(
	'name' => 'apellido_paterno',
	'label' => 'Apellido paterno',
	'value' => $Persona->apellido_paterno,
	'help' => 'Apellido paterno',
	'check' => 'notempty',
));
echo $form->input(array(
	'name' => 'apellido_materno',
	'label' => 'Apellido materno',
	'value' => $Persona->apellido_materno,
	'help' => 'Apellido materno (si lo tiene)',
));
echo $form->input(array(
	'type' => 'date',
	'name' => 'fecha_de_nacimiento',
	'label' => 'Fecha de nacimiento',
	'value' => $Persona->fecha_de_nacimiento,
	'help' => 'Fecha de nacimiento del usuario',
	'check' => 'notempty',
));
echo $form->input(array(
	'name' => 'email',
	'label' => 'Email',
	'value' => $Persona->email,
	'help' => 'Correo electrónico para uso dentro del sistema',
	'check' => 'notempty email',
));
echo $form->input(array(
	'type' => 'file',
	'name' => 'imagen',
	'label' => 'Imagen',
	'value' => '',
	'help' => 'Imagen que se desee utilizar como foto de perfil',
));
echo $form->end(array(
	'name' => 'datosPersonales',
	'value' => 'Guardar cambios',
));
?>

<h2>Cambiar contraseña</h2>
<?php
echo $form->begin(array(
	'id' => 'cambiarContrasenia',
	'onsubmit' => 'Form.check(\'cambiarContrasenia\')'
));
echo $form->input(array(
	'type' => 'password',
	'name' => 'contrasenia1',
	'label' => 'Contraseña',
	'help' => 'Contraseña que se quiere utilizar',
	'check' => 'notempty',
));
echo $form->input(array(
	'type' => 'password',
	'name' => 'contrasenia2',
	'label' => 'Repetir contraseña',
	'help' => 'Repetir la contraseña que se haya indicado antes',
	'check' => 'notempty',
));
echo $form->end(array(
	'name' => 'cambiarContrasenia',
	'value'=>'Cambiar contraseña',
));
