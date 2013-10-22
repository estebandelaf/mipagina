<!-- Design by https://www.dokuwiki.org/dokuwiki modified by http://delaf.cl -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es" dir="ltr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="generator" content="MiPaGiNa" />
		<title><?php echo $_header_title; ?></title>
		<link rel="shortcut icon" href="<?php echo $_base; ?>/layouts/<?php echo $_layout; ?>/img/wiki.png" />
		<link rel="stylesheet" media="screen" type="text/css" href="<?php echo $_base; ?>/layouts/<?php echo $_layout; ?>/css/screen.css" />
	</head>
	<body>
		<div>
			<div id="sidebar">
				<a href="<?php echo $_base; ?>" id="top" accesskey="h" title="Ir a la página de inicio [H]">
					<img class="logo" src="<?php echo $_base; ?>/layouts/<?php echo $_layout; ?>/img/logo.png" alt="OpenNESS" />
				</a>
				<span class="label">menú</span>
				<div id="navigation" class="box">
					<ul>
<?php
	foreach($_nav_website as $link => &$name) {
		if($link[0]=='/') $link = $_base.$link;
		if(is_array($name)) echo "\t\t\t\t\t\t",'<li class="level1"><a href="',$link,'" title="',$name['title'],'" class="wikilink1">',$name['name'],'</a></li>',"\n";
		else echo "\t\t\t\t\t\t",'<li class="level1"><a href="',$link,'" class="wikilink1">',$name,'</a></li>',"\n";
	}
?>
					</ul>
				</div>
			</div>
			<div id="container">
				<div>
					<div class="header">
						<div class="logo"><a href="<?php echo $_base; ?>"><?php echo $_body_title; ?></a></div>
					</div>
				</div>
				<div class="page">
					<div class="breadcrumbs">
						<span class="bchead">Traza:</span>
						<span class="bcsep">&bull;</span>
						<span class="curid"><a href="<?php echo $_base; ?>" class="breadcrumbs">inicio</a></span>
					</div>
<?php
$message = Session::message();
if($message) echo '<div class="session_message">',$message,'</div>';
echo $_content;
?>
				<div class="meta">
					<div class="doc">Última modificación: <?php echo $_timestamp; ?></div>
				</div>
				<a href="#top" class="top" accesskey="x" title="Ir hasta arriba [X]">Ir hasta arriba</a>
			</div>
			<div id="footer"><?php echo $_footer; ?></div>
		</div>
	</body>
</html>
