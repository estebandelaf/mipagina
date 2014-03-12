<h1>Probar <em>layouts</em></h1>
<p>A continuación se listan los <em>layouts</em> disponibles para el sitio
web. Puede elegir alguno de los siguientes:</p>
<ul class="list">
<?php
foreach ($layouts as &$layout) {
	echo '<li><a href="',$_base,'/layouts/',$layout,'">',$layout,'</a></li>',"\n";
}
?>
</ul>
