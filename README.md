MiPaGiNa
========

<span style="color:red">**DEPRECATED**: se hizo fork del proyecto y ahora
se está desarrollando bajo el nombre de
[SowerPHP](https://github.com/SowerPHP). No utilizar este proyecto!! Se
deja solo como referencia del origen de SowerPHP.</span>

MiPaGiNa es un ambiente de desarrollo para páginas web. Está diseñado para
sitios web o pequeñas aplicaciones.

Características:

- Entrega una estructura estándar para el orden del código.
- Permite compartir una base entre varias páginas, por lo cual mejoras
  al sistema base serán mejoras a todas las páginas.
- Posee interfaz de línea de comando mediante una Shell a la que se
  pueden añadir comandos.
- Posee la capacidad de utilizar módulos (y submódulos).

MiPaGiNa esta compuesto por defecto de tres directorios:

- ***standard***: directorio con funcionalidades entregadas por MiPaGiNa, estas
  serán comunes a todas las aplicaciones.
- ***website***: directorio con el sitio web final (se debe copiar por cada
  sitio que se quiera crear a una nueva ubicación).
- ***extensions***: directorio las extensiones de MiPaGiNa, por defecto se
  incluyen diferentes extensiones que podrían ser útiles. Cada desarrollador
  puede decidir si desea o no utilizarlas. La idea de las extensiones es que se
  puede mantener un conjunto de código común para varios sitios sin tener que
  alterar el directorio standard.

Este framework esta basado en CakePHP, tomando la estructura de directorios, los
conceptos de las clases, incluso en algunos casos reutilizando el mismo código
y/o clases completas de CakePHP.
