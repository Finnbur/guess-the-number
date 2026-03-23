<?php
session_start();
require_once 'inc/classes.inc.php';

require_once 'templates/partials/head.php';

// dump($_SESSION);
// dump($_POST);

$Controller->router();

require_once 'templates/partials/foot.php';