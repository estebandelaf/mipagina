<?php

/**
 * MiPaGiNa (MP)
 * Copyright (C) 2012 Esteban De La Fuente Rubio (esteban[at]delaf.cl)
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

/**
 * Clase para manejar la internacionalización
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
 * @version 2014-03-02
 */
final class I18n {

	public static $locale = array ( ///< Mapeo de idioma a locale
		'es' => 'es_CL.utf8',
		'en' => 'en_US.utf8',
	);

	/**
	 * Función que realiza la traducción de un string a otro idioma.
	 *
	 * Plantilla para archivo master.po (para locale en_US.utf8):
	 * 
	 *	msgid ""
	 *	msgstr ""
	 *	"Project-Id-Version: proyecto en_US master\n"
	 *	"PO-Revision-Date: 2014-03-02 11:37-0300\n"
	 *	"Last-Translator: Nombre del traductor <traductor@example.com>\n"
	 *	"Language-Team: English\n"
	 *	"Language: en_US\n"
	 *	"MIME-Version: 1.0\n"
	 *	"Content-Type: text/plain; charset=UTF-8\n"
	 *	"Content-Transfer-Encoding: 8bit\n"
	 *	"Plural-Forms: nplurals=2; plural=(n != 1);\n"
	 *	
	 *	msgid "Buscar"
	 *	msgstr "Search"
	 *
	 * Guardar la plantilla en DIR_WEBSITE/Locale/en_US.utf8/LC_MESSAGES/master.po
	 * Luego ejecutar:
	 *   $ msgfmt master.po -o master.mo
	 *
	 * En caso que se esté creando desde un archivo pot se debe crear el archivo po con:
	 *   $ msginit --locale=en_US.utf8 --input=master.pot
	 * Lo anterior creará el archivo en_US.po y luego se usa msgfmt con este archivo
	 *
	 * Cuando se crean o modifican los directorios en DIR_WEBSITE/Locale se
	 * debe reiniciar el servicio Apache (¿?)
	 *
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2014-03-02
	 */
	public static function translate ($string, $locale = null, $domain = 'master', $encoding = 'UTF-8') {
		if (!$locale) {
			$locale = Session::read('config.language');
		}
		if (!strpos($locale, '_')) $locale = self::$locale[$locale];
		putenv("LANG=".$locale);
		setlocale( LC_MESSAGES, $locale);
		bindtextdomain($domain, DIR_WEBSITE.'/Locale');
		textdomain($domain);
		bind_textdomain_codeset($domain, $encoding);
		return gettext($string);
	}

}
