<?php
// Importeer de DB en de verschillende taal scripts:
require_once("lib/database.php");
require_once("lib/artikel.php");
require_once("lib/user.php");
require_once("lib/keuken_type.php");
require_once("lib/ingredient.php");
require_once("lib/gerecht-info.php");
require_once("lib/gerecht.php");
require_once("lib/boodschappen.php");
require_once("lib/zoekfunctie.php");

/// INIT Link de classes aan variables
$db = new database();
$boodschappen = new boodschappen($db->getConnection());
$zoekfunctie = new zoekfunctie($db->getConnection());
$info = new gerecht_info($db->getConnection());
$gerecht = new gerecht($db->getConnection());

// Verwerk De variable + select functie in een nieuwe variable
// $zoekfunctie = $zoekfunctie->zoekFunctie("Pizza");
// $data = $info->selecteerGerecht_info(2, 'W');
// $data = $boodschappen->boodschappenToevoegen(1, 1);
$data = $boodschappen->totaalPrijsBoodschappen("");

// Return
echo "zoekfunctie.....................................<pre>";
var_dump($data); echo "</pre>";