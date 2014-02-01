<?php

// importar biblioteca para gráficos
App::import('Vendor/libchart/classes/libchart');

class ChartHelper {

	private $defaultOptions = array(
		'width' => 750,
		'height' => 300,
		'ratio' => 0.65,
	);

	private function generate ($title, $series, $type = 'line',
						$options = array(), $exit) {
		// asignar opciones por defecto del gráfico
		$options = array_merge($this->defaultOptions, $options);
		// crear gráfico
		$class = $type.'Chart';
		$chart = new $class($options['width'], $options['height']);
		// asignar colores
		if (isset($options['colors'])) {
			$colors = array();
			foreach ($options['colors'] as &$c)
				$colors[] = new Color($c[0], $c[1], $c[2]);
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
		$dataSet = new XYSeriesDataSet();
		// procesar cada serie
		foreach ($series as $serie => &$data) {
			$s = new XYDataSet();
			foreach ($data as $key => &$value) {
				$s->addPoint(new Point(
					$key,
					$value
				));
			}
			$dataSet->addSerie($serie, $s);
		}
		// renderizar
		$this->render($chart,$title,$dataSet,$options['ratio'],$exit);
	}

	private function render (&$chart, $title, $data, $ratio, $exit = true) {
		// poner título
		$chart->setTitle($title);
		// asignar datos para el gráfico
		$chart->setDataSet($data);
		// porcentaje que ocuparán los datos dentro de la imagen
		$chart->getPlot()->setGraphCaptionRatio($ratio);
		// limpar lo que se haya podido enviar antes
		ob_clean ();
		// enviar cabeceras
		header('Content-type: image/png');
		header('Pragma: no-cache');
		header('Expires: 0');
		// renderizar
		$chart->render();
		// terminar script
		if($exit) exit(0);
	}

	public function line ($title, $series, $options=array(), $exit= true) {
		$this->generate ($title, $series, 'Line', $options, $exit);
	}

	public function vertical_bar ($title, $series,
					$options = array(), $exit = true) {
		$this->generate ($title,$series,'VerticalBar',$options,$exit);
	}

	public function pie ($title, $data, $options = array(), $exit = true) {
		// asignar opciones por defecto del gráfico
		$options = array_merge($this->defaultOptions, $options);
		// crear gráfico
		$chart = new PieChart($options['width'], $options['height']);
		// asignar colores
		if (isset($options['colors'])) {
			$colors = array();
			foreach ($options['colors'] as &$c)
				$colors[] = new Color($c[0], $c[1], $c[2]);
			$chart->getPlot()->getPalette()->setPieColor($colors);
		}
		// asignar datos
		$dataSet = new XYDataSet();
		foreach ($data as $key => $value) {
			$dataSet->addPoint(new Point(
				$key.' ('.$value.')',
				$value
			));
		}
		$chart->setDataSet($dataSet);
		//renderizar
		$this->render($chart,$title,$dataSet,$options['ratio'],$exit);
	}

}
