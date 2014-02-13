<h1>Contacto</h1>
<p>Por favor enviar su mensaje a través del siguiente formulario, será
contactado a la brevedad.</p>

<?php
App::uses('FormHelper', 'View/Helper');
$form = new FormHelper();
echo $form->begin(array('focus'=>'nombre', 'onsubmit'=>'Form.check()'));
echo $form->input(array(
	'name'=>'nombre',
	'label'=>'Nombre',
	'check'=>'notempty'
));
echo $form->input(array(
	'name'=>'correo',
	'label'=>'Correo electrónico',
	'check'=>array('notempty', 'email')));
echo $form->input(array(
	'type'=>'textarea',
	'name'=>'mensaje',
	'label'=>'Mensaje',
	'rows'=>5,
	'check'=>'notempty'
));
echo $form->end('Enviar mensaje');
