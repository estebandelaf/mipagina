<h1>Clientes</h1>
<?php
if (file_exists(DIR_WEBSITE.'/Model/Data/clientes.php')) {
	include DIR_WEBSITE.'/Model/Data/clientes.php';
	boxAnimated ($clientes, $_base.'/img/pages/clientes',
							'Servicios prestados:');
} else {
	echo '<p>No existen datos de clientes disponibles.</p>';
}
