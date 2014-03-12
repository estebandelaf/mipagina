Extensión: empresa
==================

Extensión con funcionalidades para empresas.

La extensión requiere que previamente se haya cargado la extensión app y
general, ya eue son utilizadas por esta. Por lo cual verificar que el archivo
*webroot/index.php* al menos contenga en la definición de extensiones:

	$_EXTENSIONS = array('empresa', 'app', 'general');
