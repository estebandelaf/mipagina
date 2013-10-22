<h1>Cursos</h1> 
<ul>
<?php
foreach ($cursos as $link => &$info) {
	$url = $_base.'/cursos'.$link;
	echo '<li><a href="',$url,'">',$info['name'],'</a></li>';
}
?>
</ul>
