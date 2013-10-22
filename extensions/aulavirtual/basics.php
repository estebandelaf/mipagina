<?php

function header_useful_links ($linksName) {
	$useful_links = Configure::read($linksName);
	if (is_array($useful_links) && count($useful_links)) {
		$links = array();
		foreach ($useful_links as $link => &$name) {
			$links[] = '<a href="'.$link.'">'.$name.'</a>';
		}
		return implode(' | ', $links)."\n";
	}
	return "\n";
}
