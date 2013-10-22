<?php

// Conectar páginas de cursos
Router::connect('/cursos/*', array('controller' => 'cursos', 'action' => 'mostrar'));
