<?php

/**
 * Transforma un rut a un formato con solo los numeros
 * @param rut Rut que se quiere transformar (puede venir con puntos, comas, si tiene digito verificador DEBE tener guion)
 * @param quitarDV Si es true el digito verificador se quita, sino se mantiene
 * @return Rut formateado
 * @author DeLaF, esteban[at]delaf.cl
 * @version 2010-07-17
 */
function rut ($rut, $quitarDV = true) {
	$rutNew = '';
	if(strpos($rut, '-')) {
		$aux = explode('-', $rut); // aux porque estamos con Strict Mode
		if($quitarDV) $rutNew = array_shift($aux);
		else $rutNew = str_replace('-', '', $rut);
		$rutNew = str_replace('.', '', $rutNew);
		$rutNew = str_replace(',', '', $rutNew);
	} else {
		$flag = false; // para controlar ceros iniciales
		$j=0;
		$largoRut = strlen($rut)-1;
		for($i=0; $i<$largoRut; ++$i) {
			if($flag || $rut[$i]) {
				$flag = true;
				$rutNew .= $rut[$i];
				++$j;
			}
		}
		$rutNew = number_format($rutNew, 0, '', '.');
		$rutNew .= '-'.$rut[$largoRut];
		unset($flag, $j, $largoRut, $i);
	}
	unset($rut, $quitarDV);
	return $rutNew;
}

/**
 * Calcula el dígito verificador de un rut
 * @param r Rut al que se calculará el dígito verificador
 * @return Dígito verificar
 * @author Desconocido
 * @version 2010-05-23
 */
function rutDV ($r) {
	$r = str_replace('.', '', $r);
	$r = str_replace(',', '', $r);
	$s=1;
	for($m=0;$r!=0;$r/=10)
		$s=($s+$r%10*(9-$m++%6))%11;
	return strtoupper(chr($s?$s+47:75));
}
