Extensión: layouts
==================

Extensión cuyo único propósito es proporcionar diferentes *layouts* que
funcionan con el framework *out of the box*.

Al cargar la extensión se dispondrá de la página:

	example.com/layouts

que permitirá probar los diferentes *layouts* con la página web.

Uso del *layout* seleccionado
-----------------------------

Una vez elegido el o los layouts que se quieren tener disponibles en el sitio
copiarlos al directorio principal y dejar de utilizar la extensión. Evitando con
esto tenerla cargada, ya que no proveerá ninguna otra funcionalidad más que ser
un repositorio de layouts.

Suponiendo que el *layout* se llame **milayout** se debe copiar al directorio
principal los archivos:

	View/Layouts/milayout.php
	webroot/layouts/milayout/

Nuevos *layouts*
----------------

Si quieres enviar un diseño, ya sea tuyo o adaptado al framework de uno que
tenga una licencia libre, por favor contáctame.

Para conocer como crear un *layout* y los directorios y archivos involucrados
se recomienda revisar el enlace: [creación y uso de
layouts]({_base}/mipagina/mvc/vista/layouts).


### Variables y textos en los *layouts*


Es muy importante, al diseñar el *layout*, considerar las [variables disponibles
en el *layout*]({_base}/mipagina/mvc/vista/variables). En caso de querer
utilizar otras opciones de configuración se recomienda hacerlo directamente con
la configuración del sitio en el archivo *Config/core.php* y luego en el
*layout* utilizar:

	Configure::read('page.VARIABLE');

De esta forma si dicha configuración no existe, el método retornará *null*.
