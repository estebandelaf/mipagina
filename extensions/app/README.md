Extensión: app
==============

Extensión con funcionalidades básicas para una aplicación web, no implementa
nada específico, solo código general que pueda servir para generar una
aplicación web.

La extensión requiere que previamente se haya cargado la extensión general, ya
que es utilizada por esta. Por lo cual verificar que el archivo
*webroot/index.php* al menos contenga en la definición de extensiones:

	$_EXTENSIONS = array('app', 'general');

La extensión usará los módulos:

-	Exportar
-	Sistema
-	Sistema.Usuarios (este será autocargado)

AuthComponent
-------------

Esta extensión por defecto cargará el componente *AuthComponent* por lo cual los
controladores estarán obligados a revisar si el usuario que accede dispone de
permisos para acceder a los recursos (o sea se ha autenticado y dispone de
permisos). En caso que se requiera hacer métodos de controladores públicos se
debe sobreescribir el método *beforeFilter* del correspondiente controlador
autorizando el método, ejemplo:

	public function beforeFilter () {
		$this->Auth->allow('ingresar', 'salir', 'imagen');
		parent::beforeFilter();
	}

En caso que se requiera que solo se pida estar autenticado (y para evitar estar
agregando recursos a la tabla auth en la base de datos) utilizar en el método
*beforeFilter* el método *allowWithLogin* de *AuthComponent*, ejemplo:

	$this->Auth->allowWithLogin('perfil');

En resumen el ejemplo completo queda como:

	public function beforeFilter () {
		$this->Auth->allow('ingresar', 'salir', 'imagen');
		$this->Auth->allowWithLogin('perfil');
		parent::beforeFilter();
	}

Si se quiere permitir todos los métodos de un controlador se puede utilizar:

	public function beforeFilter () {
	}
	
Módulos
-------

-	**Sistema.Usuarios**: provee las funcionalidades básicas para
	administrar: usuarios, grupos y permisos sobre recursos. Se debe cargar
	el modelo de datos disponible en el módulo en:

		Model/Sql/PostgreSQL/usuarios.sql
