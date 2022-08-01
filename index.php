<?php

session_start();
require_once 'config/parametros.php';
require_once 'classes/session.php';
require_once 'classes/utils.php';
require_once 'autoload.php';
require_once 'core/database.php';
require_once 'core/view.php';
require_once 'core/controller.php';
require_once 'core/model.php';
require_once 'core/app.php';

// carga el controlador frontal
$app = new App();

?>