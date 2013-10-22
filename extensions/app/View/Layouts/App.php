<!-- Design by http://www.oswd.org/design/preview/id/3459 modified by http://delaf.cl -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title><?php echo $_header_title; ?></title>
		<link rel="shortcut icon" href="<?php echo $_base; ?>/img/favicon.png" />
		<link type="text/css" href="<?php echo $_base; ?>/layouts/<?php echo $_layout; ?>/css/screen.css" media="screen" title="screen" rel="stylesheet" />
		<link type="text/css" href="<?php echo $_base; ?>/layouts/<?php echo $_layout; ?>/css/print.css" media="print" title="print" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo $_base; ?>/js/jquery.js"></script>
		<script type="text/javascript" src="<?php echo $_base; ?>/js/js.js"></script>
		<script type="text/javascript" src="<?php echo $_base; ?>/js/form.js"></script>
		<script type="text/javascript" src="<?php echo $_base; ?>/js/jquery-ui/jquery-ui.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo $_base; ?>/js/jquery-ui/css/smoothness/jquery-ui.css" media="screen"/>
<?php echo $_header_extra; ?>
	</head>
	<body>
		<div id="wrapper">
			<div id="header">
				<a href="<?php echo $_base; ?>/inicio">
					<div class="img"><img src="<?php echo $_base; ?>/img/logo.png" alt="" /></div>
					<div class="txt"><?php echo $_body_title; ?></div>
				</a>
			</div>
			<div id="navsite">
				<ul>
<?php foreach($_nav_website as $link=>&$name) echo "\t\t\t\t\t",'<li><a href="',$_base,$link,'">',$name,'</a></li>',"\n"; ?>
				</ul>
			</div>
			<div id="sidebar">
				<div id="sidebar-title">
					<div class="txt">Aplicación</div>
				</div>
				<ul id="navapp">
<?php if(!AuthComponent::logged()) { ?>
					<li><a href="<?php echo $_base; ?>/usuarios/ingresar" title="Iniciar sesión en la Intranet">Iniciar sesión</a></li>
				</ul>
<?php
} else {
	foreach($_nav_app as $link=>&$info) {
		if(AuthComponent::check($link)) {
			if(!is_array($info)) $info = array('name'=>$info);
			echo "\t\t\t\t\t",'<li><a href="',$_base,$link,'">',$info['name'],'</a></li>',"\n";
		}
	}
?>
				</ul>
				<div id="navapp-icons">
					<a href="<?php echo $_base; ?>/usuarios/perfil" title="Perfil del usuario <?php echo Session::read('auth.usuario'); ?>">
						<img src="<?php echo $_base; ?>/img/icons/16x16/navapp/profile.png" alt="" />
					</a>
					<a href="<?php echo $_base; ?>/usuarios/salir" title="Cerrar sesión del usuario <?php echo Session::read('auth.usuario'); ?>">
						<img src="<?php echo $_base; ?>/img/icons/16x16/navapp/logout.png" alt="" />
					</a>
				</div>
<?php }?>
				<div id="sidebar-bottom">
					&nbsp;
				</div>
			</div>
			<div id="content">
<?php
$message = Session::message();
if($message) echo '<div class="session_message">',$message,'</div>';
?>
<a href="javascript:print()" title="Imprimir página" class="fright">
	<img src="<?php echo $_base; ?>/img/icons/16x16/actions/print.png"
		alt="Imprimir página" />
</a>
<?php echo $_content; ?>
			</div>
			<div id="footer">
				<div>
					<div class="fleft">
						Desarrollado por:
						<a href="http://sasco.cl"
title="Sitio web y aplicación desarrollada por SASCO">SASCO </a>
					</div>
					<div class="fright">
						Con tecnología:
						<a href="http://www.apache.org" title="Servidor web Apache">Apache</a>
						<a href="http://www.php.net" title="Lenguaje de programación PHP">PHP</a>
						<a href="http://www.postgresql.org" title="Base de datos PostgreSQL">PostgreSQL</a>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
