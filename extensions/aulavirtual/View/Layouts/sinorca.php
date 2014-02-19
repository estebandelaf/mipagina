<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en-AU">
	<head>
		<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
		<meta name="generator" content="MiPaGiNa" />
		<title><?php echo $_header_title; ?></title>
		<link rel="shortcut icon" href="<?php echo $_base; ?>/img/favicon.png" />
		<link rel="stylesheet" type="text/css" href="<?php echo $_base; ?>/layouts/sinorca/css/screen.css" media="screen" title="Sinorca (screen)" />
		<link rel="stylesheet alternative" type="text/css" href="<?php echo $_base; ?>/layouts/sinorca/css/screen-alt.css" media="screen" title="Sinorca (alternative)" />
		<link rel="stylesheet" type="text/css" href="<?php echo $_base; ?>/layouts/sinorca/css/print.css" media="print" />
		<script type="text/javascript" src="<?php echo $_base; ?>/js/jquery.js"></script>
		<script type="text/javascript" src="<?php echo $_base; ?>/js/form.js"></script>

		<link href="<?php echo $_base; ?>/js/google-code-prettify/prettify.css" type="text/css" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo $_base; ?>/js/jquery-ui/jquery-ui.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo $_base; ?>/js/jquery-ui/css/smoothness/jquery-ui.css" media="screen"/>
		<script type="text/javascript" src="<?php echo $_base; ?>/js/google-code-prettify/prettify.js"></script>
		<script type="text/javascript"> $(function() { prettyPrint(); }); </script>
	</head>
	<body>
		<!-- For non-visual user agents: -->
		<div id="top"><a href="#main-copy" class="doNotDisplay doNotPrint">Skip to main content.</a></div>
		<!-- ##### Header ##### -->
		<div id="header">
			<div class="superHeader">
				<div class="left">
					<span class="doNotDisplay">Links:</span>
					<?php echo header_useful_links('page.header.useful_links.left'); ?>
				</div>
				<div class="right">
					<span class="doNotDisplay">Links:</span>
					<?php echo header_useful_links('page.header.useful_links.right'); ?>
				</div>
			</div>
			<div class="midHeader">
				<h1 class="headerTitle"><?php echo $_body_title; ?></h1>
			</div>
			<div class="subHeader">
				<span class="doNotDisplay">Navigation:</span>
<?php
$links = array();
foreach($_nav_website as $link => &$name) {
	$class = $link == $_page ? ' class="highlight"' : '';
	if($link[0]=='/') $link = $_base.$link;
	if(is_array($name)) $links[] = "\t\t\t\t".'<a href="'.$link.'" title="'.$name['title'].'"'.$class.'>'.$name['name'].'</a>'."\n";
	else $links[] = "\t\t\t\t".'<a href="'.$link.'"'.$class.'>'.$name.'</a>'."\n";
}
echo implode(' | ', $links);
?>
			</div>
		</div>
		<!-- ##### Side Bar ##### -->
		<div id="side-bar">
			<div>
				<p class="sideBarTitle">Cursos</p>
				<ul>
<?php
// determinar curso si es que se está viendo uno
if(substr($_request, 0, 8)=='/cursos/') {
	$tercer_slash = strpos($_request, '/', 8);
	if($tercer_slash!==false) $curso = substr($_request, 7, $tercer_slash - 7);
	else $curso = substr($_request, 7);
} else $curso = null;
// mostrar cursos
foreach($_nav_website['/cursos']['nav'] as $link => &$name) {
	$l = $_base.'/cursos'.$link;
	if($link==$curso) echo "\t\t\t\t\t",'<li><a href="',$l,'" title="',$name['title'],'" style="padding:0"><span class="thisPage">&raquo; ',$name['name'],'</span></a></li>',"\n";
	else echo "\t\t\t\t\t",'<li><a href="',$l,'" title="',$name['title'],'">&rsaquo; ',$name['name'],'</a></li>',"\n";
}
?>
				</ul>
			</div>
<?php if(substr($_request, 0, 8)=='/cursos/') { ?>
			<div>
				<p class="sideBarTitle"><?php echo $_nav_website['/cursos']['nav'][$curso]['name']; ?></p>
				<ul>
<?php
// mostrar menú del curso
$links = $_nav_website['/cursos']['nav'][$curso]['nav'];
if(!array_key_exists('', $links)) {
	$links = array_merge(array(''=>'Archivos'), $links);
}
foreach($links as $link => &$name) {
	$l = $_base.'/cursos'.$curso.$link;
	if($_request=='/cursos'.$curso.$link) echo "\t\t\t\t\t",'<li><a href="',$l,'" style="padding:0"><span class="thisPage">&raquo; ',$name,'</span></a></li>',"\n";
	else echo "\t\t\t\t\t",'<li><a href="',$l,'">&rsaquo; ',$name,'</a></li>',"\n";
}
?>
				</ul>
			</div>
<?php } ?>
			<div class="lighterBackground">
				<p class="sideBarTitle">Sobre mí</p>
				<span class="sideBarText">
					<?php echo Configure::read('page.aboutme'); ?>
				</span>
			</div>
			<div>
				<p class="sideBarTitle">Validación</p>
				<span class="sideBarText">
					Validar el <a href="http://validator.w3.org/check/referer">XHTML</a> y
					<a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a> de esta página.
				</span>
			</div>
		</div>
		<!-- ##### Banners ##### -->
		<div id="banners">
			<div class="center">
<?php
$banners = Configure::read('banners.right');
foreach ($banners as $link => &$image) {
	if($image[0]=='/') $image = $_base.$image;
	echo '<br /><a href="',$link,'"><img src="',$image,'" alt="" /></a><br />';
}
?>
			</div>
<?php
$google_ads = Configure::read('banners.google.ads');
if (!empty($google_ads['client']) && !empty($google_ads['ads']['160x600'])) {
?>
			<div class="adsense">
				<script type="text/javascript">
					google_ad_client = "<?php echo $google_ads['client']; ?>";
					google_ad_slot = "<?php echo $google_ads['ads']['160x600']; ?>";
					google_ad_width = 160;
					google_ad_height = 600;
				</script>
				<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
			</div>
<?php } ?>
		</div>
		<!-- ##### Main Copy ##### -->
		<div id="main-copy">
<?php
$message = Session::message();
if($message) echo '<div class="session_message">',$message,'</div>';
?>
<?php echo $_content; ?>
			<!--<a class="topOfPage" href="#top" title="Go to the top of this page">Ir hasta arriba</a></div>-->
			<div class="timestamp">Última modificación de esta página fue el <?php echo timestamp2string($_timestamp); ?></div>
<?php if (!empty($google_ads['client']) && !empty($google_ads['ads']['468x60'])) { ?>
			<div class="adsense">
				<script type="text/javascript">
					google_ad_client = "<?php echo $google_ads['client']; ?>";
					google_ad_slot = "<?php echo $google_ads['ads']['468x60']; ?>";
					google_ad_width = 468;
					google_ad_height = 60;
				</script>
				<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
			</div>
<?php } ?>
			<div style="clear:both"></div>
		</div>
		<!-- ##### Footer ##### -->
		<div id="footer">
			<div class="left">
<?php
$links = array();
foreach($_nav_website as $link => &$name) {
	if($link[0]=='/') $link = $_base.$link;
	$class = ' class="highlight"';
	if(is_array($name)) $links[] = "\t\t\t\t".'<a href="'.$link.'" title="'.$name['title'].'"'.$class.'>'.$name['name'].'</a>'."\n";
	else $links[] = "\t\t\t\t".'<a href="'.$link.'"'.$class.'>'.$name.'</a>'."\n";
}
echo implode(' | ', $links);
?>
			</div>
			<br class="doNotDisplay doNotPrint" />
			<div class="right">
				Generado por <a href="http://mi.delaf.cl/mipagina" class="doNotPrint">MiPaGiNa</a><br />
				<!--This theme is free for distriubtion, so long as link to openwebdesing.org and www.best10webhosting.net stay on the theme -->
				Diseño cortesía de <a href="http://www.openwebdesign.org">Open Web Design</a> &amp;
				<a href="http://www.dubaiapartments.biz/hotels/">Hotels - Dubai</a>
			</div>
		</div>
	</body>
</html>
