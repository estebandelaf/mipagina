<h1>Recuperación de contraseña</h1>
<p>Las instrucciones para recuperar su contraseña serán envíadas a su correo
electrónico, por favor ingrese su usuario o email a continuación:</p>
<?php
$f = new FormHelper ();
echo $f->begin(array('focus'=>'id', 'onsubmit'=>'Form.check()'));
echo $f->input (array(
	'name'=>'id',
	'label'=>'Usuario o email',
	'check'=>'notempty'
));
echo $f->end('Solicitar email');
