<?php

/**
 * Función para cargar todos los archivos de un directorio como código,
 * y "pintarlo" mediante http://google-code-prettify.googlecode.com
 * @param src Archivo o directorio (fullpath)
 * @param recursive Procesar (o no) de forma recursiva el directorio src
 * @param ext Procesar solo extensiones indicadas
 * @param header Header desde el cual se desea utilizar (ej: 2, que es <h2>)
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
 * @version 2013-06-27
 */
function codeFrom ($src, $recursive = false, $ext = array(), $header = 2) {
	// reemplazar "/" en src
	$src = str_replace('/', DS, $src);
	// en caso que sea un directorio se recorre recursivamente
	if(is_dir($src)) {
		// si se limitan extensiones
		if(count($ext)) $restrictExtensions = true;
		else $restrictExtensions = false;
		// buscar archivos
		$files = scandir($src);
		foreach($files as &$file) {
			// si es archivo oculto se omite
			if($file[0]=='.') continue;
			// si se limitan extensiones y no esta en las permitidas saltar
			if($restrictExtensions && !in_array(substr($file, strrpos($file, '.')+1), $ext)) {
				continue;
			}
			// si es un directorio, verificar que se deba procesar
			// recursivamente, sino se veran solo archivos
			if(is_dir($src.DS.$file) && !$recursive) continue;
			// si es un directorio colocar el nombre del directorio
			if (is_dir ($src.DS.$file)) {
				$permlink = string2url($file);
				echo "<h$header id=\"$permlink\">$file
				<a href=\"#$permlink\">&lt;&gt;</a>
				</h$header>";
				$h = $header + 1;
			}
			// llamar a la función por cada archivo
			codeFrom($src.DS.$file, $recursive, $ext, $header);
		}
	}
	// si no es directorio entonces es un archivo, se muestra
	else {
		echo '<div><strong>',basename($src),'</strong></div>';
		echo '<pre class="prettyprint"><code>';
		echo htmlspecialchars(file_get_contents($src));
		echo '</code></pre>',"\n\n";
	}
}

/**
 * Función para crear enlaces hacia archivos que se encuentran en un
 * directorio visible desde el DocummentRoot, la ruta que se debe
 * indicar en dir debe ser la ruta completa que se vería desde
 * dominio.com/full/path, o sea (en este caso) dir = /full/path
 * @param dir Directorio donde están los archivos que se desean enlazar
 * @param recursive Procesar (o no) de forma recursiva el directorio dir
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
 * @version 2013-07-30
 */
function linksFrom ($dir, $recursive = false) {
	$base = Request::getBase();
	$realdir = DIR_WEBSITE.DS.'webroot'.str_replace('/', DS, $dir);
	if(!is_dir($realdir)) {
		echo '<p>No es posible leer el directorio de archivos.</p>';
		return;
	}
	$files = scandir($realdir);
	echo '<ul>',"\n";
	// procesar cada archivo
	foreach($files as &$file) {
		// si es archivo oculto se omite
		if($file[0]=='.') continue;
		// si es un directorio
		if(is_dir($realdir.'/'.$file)) {
			// verificar que se deba procesar recursivamente, sino se veran solo archivos
			if(!$recursive) continue;
			// mostrar directorio y llamar función de forma recursiva
			echo '<li style="list-style-image: url(\'',$base,'/img/icons/16x16/files/directory.png\')">',str_replace(array('_', '-'), ' ', $file),'</li>',"\n";
			linksFrom($dir.DS.$file, $recursive);
		}
		// si es un archivo
		else {
			// definir nombre y extensión
			if(strrchr($file, '.')!==FALSE) {
				$ext = substr(strrchr($file, '.'), 1);
				$name = str_replace(array('_', '-'), ' ', preg_replace("/.$ext$/", '', $file));
			} else {
				$ext = '';
				$name = str_replace(array('_', '-'), ' ', $file);
			}
			// buscar icono a partir de la extension
			$icon = App::location('webroot/img/icons/16x16/files/'.$ext.'.png');
			if($icon) $icon = 'img/icons/16x16/files/'.$ext.'.png';
			else $icon = 'img/icons/16x16/files/generic.png';
			// mostrar enlace
			echo '<li style="list-style-image: url(\'',$base,'/',$icon,'\')"><a href="',$base.$dir,'/',$file,'">',$name,'</a></li>',"\n";
		}
	}
	echo '</ul>',"\n";
}

/**
 * Función que retorna los archivos de un directorio (excepto ocultos)
 * @param dir Directorio que se desea escanear
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
 * @version 2012-10-19
 */
function filesFromDir ($dir) {
	$filesAux = scandir($dir);
	foreach($filesAux as &$file) {
		if($file[0]!='.') $files[] = $file;
	}
	return $files;
}

function timestamp2string ($timestamp) {
	$timestamp = substr($timestamp, 0, strpos($timestamp, '.'));
	$date = DateTime::createFromFormat('Y-m-d H:i:s', $timestamp);
	return $date->format('d \d\e M \d\e Y \a \l\a\s H:i');
}

/**
 * @author http://stackoverflow.com/questions/1960461/convert-plain-text-urls-into-html-hyperlinks-in-php
 */
function makeClickableLinks($s) {
	return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1">$1</a>', $s);
}

/**
 * Muestra logos e información sobre ellos de una forma "linda", para un
 * ejemplo revisar: http://sasco.cl/clientes
 *
 * El arreglo que se recibe tiene la forma:
 * $logos = array (
 *	'Empresa' => array (
 *		'desc' => 'Descripción empresa',
 *		'info' => array ('Info 1', 'Info 2', 'etc'),
 *		'imag' => 'Imagen dentro de $dir'
 *	),
 * );
 *
 * @param logos Arreglo con la información de los logos
 * @param dir Ruta completa de la URL donde se encuentran los logos
 * @param infoTitle Título para la información que se mostrará por logo
 */
function boxAnimated ($logos, $dir, $infoTitle = '') {
	$_base = Request::getBase();
	// si es la primera vez que se llama la función se agrega código css y js
	if (!defined('LOGO_INFO_CALLED')) {
		echo '<link type="text/css" href="',$_base,'/css/boxAnimated.css" media="screen" title="screen" rel="stylesheet" />',"\n";
		echo '<script type="text/javascript" src="',$_base,'/js/boxAnimated.js"></script>',"\n";
		define ('LOGO_INFO_CALLED', true);
	}
	// mostrar logos
	foreach($logos as $name => &$info) {
	echo '
<div class="boxAnimated">
	<div class="image">
		<div class="inner">
			<img src="',$dir,'/',$info['imag'],'">
			<div class="longdescription">
				<div class="title">',$infoTitle,'</div>
				<div class="description">
					<ul>
						<li>',implode('</li><li>', $info['info']),'</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="shortdescription">
		<div class="title">',$name,'</div>
		<div class="description">',$info['desc'],'</div>
	</div>
</div>
	';
	}
}

/**
 * http://phpes.wordpress.com/2007/06/12/generador-de-una-cadena-aleatoria/
 */
function str_random ($length=8, $uc=true, $n=true, $sc=false) {
	$source = 'abcdefghijklmnopqrstuvwxyz';
	if($uc) $source .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	if($n) $source .= '0123456789';
	if($sc) $source .= '|@#~$%()=^*+[]{}-_';
	if($length>0){
		$rstr = "";
		$source = str_split($source,1);
		for($i=1; $i<=$length; $i++){
			mt_srand((double)microtime() * 1000000);
			$num = mt_rand(1,count($source));
			$rstr .= $source[$num-1];
		}

	}
	return $rstr;
}

/**
 * http://stackoverflow.com/users/847142/frans-van-asselt
 */
function array2xml ($array, $root = 'root'){
	$xml = new SimpleXMLElement('<'.$root.'/>');
	foreach($array as $key => $value){
		if(is_array($value)){
			if(is_numeric($key)) $key = 'item'; // by DeLaF
			array2xml($value, $xml->addChild($key));
		} else {
			$xml->addChild($key, $value);
		}
	}
	return $xml->asXML();
}

/**
 * Función para mostrar una fecha con hora con un formato "agradable"
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
 * @version 2014-02-17
 */
function date_nice ($timestamp, $hora = true, $letrasFormato = '') {
	$dias = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
	$meses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
	$unixtime = strtotime($timestamp);
	$fecha = date('\D\I\A j \d\e \M\E\S \d\e\l Y', $unixtime);
	if ($hora) $fecha .= ', a las '.date ('H:i', $unixtime);
	$dia = $dias[date('w', $unixtime)];
	$mes = $meses[date('n', $unixtime)-1];
	if ($letrasFormato == 'l') {
		$dia = strtolower ($dia);
		$mes = strtolower ($mes);
	} else if ($letrasFormato == 'u') {
		$dia = strtoupper ($dia);
		$mes = strtoupper ($mes);
	}
	return str_replace(array('DIA', 'MES'), array($dia, $mes), $fecha);
}

/**
 * Función que extra de un arreglo en formato:
 * array(
 *   'key1' => array(1,2,3),
 *   'key2' => array(4,5,6),
 *   'key3' => array(7,8,9),
 * )
 * Y lo entrega como una "tabla":
 * array (
 *   array (
 *     'key1' => 1,
 *     'key2' => 4,
 *     'key3' => 7,
 *   ),
 *   array (
 *     'key1' => 2,
 *     'key2' => 5,
 *     'key3' => 8,
 *   ),
 *   array (
 *     'key1' => 3,
 *     'key2' => 6,
 *     'key3' => 9,
 *   ),
 * )
 * @param array Arreglo de donde extraer
 * @param keys Llaves que se extraeran
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
 * @version 2014-02-18
 */
function groupOfArraysToTable ($array, $keys) {
	$n_keys = count($keys);
	$n_elementos = count($array[$keys[0]]);
	$data = array();
	for ($i=0; $i<$n_elementos; ++$i) {
		$d = array();
		for ($j=0; $j<$n_keys; ++$j) {
			$d[$keys[$j]] = $array[$keys[$j]][$i];
		}
		$data[] = $d;
	}
	return $data;
}
