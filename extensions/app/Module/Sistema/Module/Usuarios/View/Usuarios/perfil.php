<h1>Perfil del usuario <em><?php echo $Usuario->usuario; ?></em></h1>

<h2>Datos personales</h2>
<?php
$form = new FormHelper();
echo $form->begin(array(
	'id' => 'datosUsuario',
	'onsubmit' => 'Form.check(\'datosUsuario\')'
));
echo $form->input(array(
	'name' => 'nombre',
	'label' => 'Nombre',
	'value' => $Usuario->nombre,
	'help' => 'Nombre real del usuario',
	'check' => 'notempty',
));
echo $form->input(array(
	'name' => 'usuario',
	'label' => 'Usuario',
	'value' => $Usuario->usuario,
	'help' => 'Nombre de usuario',
	'check' => 'notempty',
));
echo $form->input(array(
	'name' => 'email',
	'label' => 'Email',
	'value' => $Usuario->email,
	'help' => 'Correo electrónico para uso dentro del sistema',
	'check' => 'notempty email',
));
echo $form->input(array(
	'name' => 'hash',
	'label' => 'Hash',
	'value' => $Usuario->hash,
	'help' => 'Hash único para identificar el usuario',
	'check' => 'notempty',
));
echo $form->end(array(
	'name' => 'datosUsuario',
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
