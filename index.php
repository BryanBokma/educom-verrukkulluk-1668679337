<?php

require_once("lib/database.php");
require_once("lib/artikel.php");
require_once("lib/user.php");
require_once("lib/kitchen_type.php");
require_once("lib/ingredient.php");
require_once("lib/gerecht-info.php");
require_once("lib/gerecht.php");
require_once("lib/boodschappen.php");

/// INIT
$db = new database();

$gerecht = new gerecht($db->getConnection());
//$data = $gerecht->selecteerGerecht();
$ingre = new ingredient($db->getConnection());
$boodschappen = new boodschappen($db->getConnection());
$info = new gerecht_info($db->getConnection());


$data = $boodschappen->boodschappenToevoegen(1, 1);


echo "boodschappen.....................................<pre>";
var_dump($data); echo "</pre>";


