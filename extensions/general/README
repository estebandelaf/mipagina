Extensión: general
==================

Extensión de propósito general, ya que el framework base (directorio
*standard*) solo provee un conjunto muy pequeño de funcionalidades, por lo
general será interesante y útil para el programador incluir esta extensión. A
menos claro que desee implementar sus propias funcionalidades o no quiera
depender de librerías que aquí existan.

Se adjuntan algunos ejemplos de uso del código, en general se recomienda
revisar la documentación de las clases y sus métodos públicos para mayor
información.

MVC (modelos, vistas y controladores)
-------------------------------------

-	**Contacto**: provee un formulario de contacto que se envía por correo
	electrónico. Es requisito que esté configurado el correo en
	*Config/core.php*, por ejemplo (para Gmail):

		// Configuración para el correo electrónico
		Configure::write('email.default', array(
			'type' => 'smtp',
			'host' => 'ssl://smtp.gmail.com',
			'port' => 465,
			'user' => 'de@gmail.com',
			'pass' => 'secretpassword',
			'from' => array(
				'email'=>'de@gmail.com',
				'name'=>'Mi nombre'
			),
			'to' => 'para@gmail.com',
		));

-	**Module**: permite desplegar los enlaces (iconos) del módulo que se
	está consultando o bien su página View/index.php en caso de que exista.

Helpers
-------

-	**ChartHelper**: para la generación de gráficos utilizando *libchart*.

-	**FormHelper**: para la generación de formularios HTML.

-	**PDFHelper**: para la generación de archivos PDF utilizando *TCPDF*.

-	**TableHelper**: para la generación de tablas HTML.

Utilidades
----------

-	**Automata**: provee clase AFD para correr autómata finito
	determinístico.

-	**Spreadsheet**: provee clases para leer y escribir tablas en
	diferentes formatos, por ejemplo CSV, ODS y XLS. Se recomienda utilizar
	la clase Spreadsheet para acceder a las otras clases. Por ejemplo para
	generar una tabla se puede utilizar:

		App::uses('Spreadsheet', 'Utility/Spreadsheet');
		Spreadsheet::generate(array(
			array('f1c1', 'f1c2'),
			array('f2c1', 'f2c2'),
			array('f3c1', 'f3c2'),
		));

	Lo anterior creará un archivo ODS (que es el formato por defecto) con
	los contenidos del arreglo.

Módulos
-------

-	**Exportar**: este módulo hace uso de helpers y utilidades para
	exportar datos a diferentes formatos, como pueden ser: tablas HTML,
	archivos PDF, códigos de barras, gráficos u hojas de cálculo ODS. Si
	los datos a exportar provienen de una tabla generada con TableHelper
	solo es necesario indicar a través del constructor que se desea
	exportar o bien usando el método TableHelper::setExport(true). En el
	caso de querer exportar códigos de barra (QR, 1D o PDF417) se debe
	pasar el string a codificar en base64 a través de la URL, ejemplo:

		http://example.com/exportar/qrcode/aG9sYSBtdW5kbyEK

-	**Multimedia**: provee utilidades, actualmente provee la clase Imagenes
	para la creación de una galería de imágenes. Requiere *prettyPhoto*. Se
	puede crear una galería con imagenes de cierto directorio de la
	siguiente forma:

		App::uses('Imagenes', 'Multimedia.Utility');
		new Imagenes('/archivos/multimedia/imagenes');

Otros directorios (como *Vendor* o *webroot*) contienen archivos que son
necesarios para que la extensión funcione correctamente.
