<?php

require_once("lib/database.php");
require_once("lib/artikel.php");
require_once("lib/user.php");
require_once("lib/kitchen_type.php");
require_once("lib/ingredient.php");
require_once("lib/gerecht_info.php");
require_once("lib/gerecht.php");

/// INIT
$db = new database();

$gerecht = new gerecht($db->getConnection());
$data = $gerecht->selecteerGerecht();



echo "gerecht.....................................<pre>";
var_dump($data); echo "</pre>";


