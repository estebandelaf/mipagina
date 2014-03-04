<?php

/**
 * MiPaGiNa (MP)
 * Copyright (C) 2014 Esteban De La Fuente Rubio (esteban[at]delaf.cl)
 *
 * Este programa es software libre: usted puede redistribuirlo y/o
 * modificarlo bajo los términos de la Licencia Pública General GNU
 * publicada por la Fundación para el Software Libre, ya sea la versión
 * 3 de la Licencia, o (a su elección) cualquier versión posterior de la
 * misma.
 *
 * Este programa se distribuye con la esperanza de que sea útil, pero
 * SIN GARANTÍA ALGUNA; ni siquiera la garantía implícita
 * MERCANTIL o de APTITUD PARA UN PROPÓSITO DETERMINADO.
 * Consulte los detalles de la Licencia Pública General GNU para obtener
 * una información más detallada.
 *
 * Debería haber recibido una copia de la Licencia Pública General GNU
 * junto a este programa.
 * En caso contrario, consulte <http://www.gnu.org/licenses/gpl.html>.
 */

// importar biblioteca para gráficos
App::import('Vendor/libchart/libchart/vendor/autoload');

/**
 * Clase para generar gráficos
 * Hace uso de libchart, presentando métodos más simples y evitando que el
 * programador deba escribir tando código
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
 * @version 2014-03-03
 */
class ChartHelper {

	private $defaultOptions = array( ///< Opciones por defecto de los gráficos
		'width' => 750,
		'height' => 300,
		'ratio' => 0.65,
	);

	/**
	 * Método que genera un gráfico
	 * @param title Título del gráfico
	 * @param series Datos del gráfico
	 * @param type Tipo de gráfico que se desea generar
	 * @param options Opciones para el gráfico
	 * @param exit =true si se debe terminar el script, =false si no se debe terminar
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2014-03-03
	 */
	private function generate ($title, $series, $type = 'line',
						$options = array(), $exit) {
		// asignar opciones por defecto del gráfico
		$options = array_merge($this->defaultOptions, $options);
		// crear gráfico
		$class = '\\Libchart\\View\\Chart\\'.$type.'Chart';
		$chart = new $class($options['width'], $options['height']);
		// asignar colores
		if (isset($options['colors'])) {
			$colors = array();
			foreach ($options['colors'] as &$c)
				$colors[] = new \Libchart\View\Color\Color($c[0], $c[1], $c[2]);
			if($type=='Line') {
				$chart->getPlot()->getPalette()
					->setLineColor($colors);
			}
			else if($type=='VerticalBar') {
				$chart->getPlot()->getPalette()
					->setBarColor($colors);
			}
		}
		// conjunto de series
		$dataSet = new \Libchart\Model\XYSeriesDataSet();
		// procesar cada serie
		foreach ($series as $serie => &$data) {
			$s = new \Libchart\Model\XYDataSet();
			foreach ($data as $key => &$value) {
				$s->addPoint(new \Libchart\Model\Point(
					$key,
					$value
				));
			}
			$dataSet->addSerie($serie, $s);
		}
		// renderizar
		$this->render($chart,$title,$dataSet,$options['ratio'],$exit);
	}

	/**
	 * Función que renderiza el gráfico que se está generando
	 * @param chart Gráfico a renderizar
	 * @param title Título del gráfico
	 * @param data Datos del gráfico
	 * @param ratio Porcentaje que ocuparán los datos dentro de la imagen
	 * @param exit =true si se debe terminar el script, =false si no se debe terminar
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2014-03-03
	 */
	private function render (&$chart, $title, $data, $ratio, $exit = true) {
		// asignar opciones al gráfico
		$chart->setTitle($title);
		$chart->setDataSet($data);
		$chart->getPlot()->setGraphCaptionRatio($ratio);
		// enviar cabeceras
		ob_clean ();
		header('Content-type: image/png');
		header('Pragma: no-cache');
		header('Expires: 0');
		// renderizar y terminar script
		$chart->render();
		if($exit) exit(0);
	}

	/**
	 * Método para generar un gráfico de lineas
	 * @param title Título del gráfico
	 * @param series Datos del gráfico
	 * @param options Opciones para el gráfico
	 * @param exit =true si se debe terminar el script, =false si no se debe terminar
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2014-03-03
	 */
	public function line ($title, $series, $options=array(), $exit= true) {
		$this->generate ($title, $series, 'Line', $options, $exit);
	}

	/**
	 * Método para generar un gráfico de barras verticales
	 * @param title Título del gráfico
	 * @param series Datos del gráfico
	 * @param options Opciones para el gráfico
	 * @param exit =true si se debe terminar el script, =false si no se debe terminar
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2014-03-03
	 */
	public function vertical_bar ($title, $series,
					$options = array(), $exit = true) {
		$this->generate ($title,$series,'VerticalBar',$options,$exit);
	}

	/**
	 * Método para generar un gráfico de barras horizontales
	 * @param title Título del gráfico
	 * @param series Datos del gráfico
	 * @param options Opciones para el gráfico
	 * @param exit =true si se debe terminar el script, =false si no se debe terminar
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2014-03-03
	 */
	public function horizontal_bar ($title, $series,
					$options = array(), $exit = true) {
		$this->generate ($title,$series,'HorizontalBar',$options,$exit);
	}

	/**
	 * Método para generar un gráfico de torta
	 * @param title Título del gráfico
	 * @param data Datos del gráfico
	 * @param options Opciones para el gráfico
	 * @param exit =true si se debe terminar el script, =false si no se debe terminar
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2014-03-03
	 */
	public function pie ($title, $data, $options = array(), $exit = true) {
		// asignar opciones por defecto del gráfico
		$options = array_merge($this->defaultOptions, $options);
		// crear gráfico
		$chart = new \Libchart\View\Chart\PieChart($options['width'], $options['height']);
		// asignar colores
		if (isset($options['colors'])) {
			$colors = array();
			foreach ($options['colors'] as &$c)
				$colors[] = new Color($c[0], $c[1], $c[2]);
			$chart->getPlot()->getPalette()->setPieColor($colors);
		}
		// asignar datos
		$dataSet = new \Libchart\Model\XYDataSet();
		foreach ($data as $key => $value) {
			$dataSet->addPoint(new \Libchart\Model\Point(
				$key.' ('.$value.')',
				$value
			));
		}
		$chart->setDataSet($dataSet);
		//renderizar
		$this->render($chart,$title,$dataSet,$options['ratio'],$exit);
	}

}
