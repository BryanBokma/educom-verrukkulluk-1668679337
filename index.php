<?php

require_once("lib/database.php");
require_once("lib/artikel.php");
require_once("lib/user.php");
require_once("lib/kitchen_type.php");
require_once("lib/ingredient.php");
require_once("lib/gerecht_info.php");

/// INIT
$db = new database();
$art = new artikel($db->getConnection());
$user = new user($db->getConnection());
$kitchen_type = new kitchen_type($db->getConnection());
$ingredient = new ingredient($db->getConnection());
$gerecht_info = new gerecht_info($db->getConnection());


/// VERWERK 
//$data_art = $art->selecteerArtikel(2);
//$data_user = $user->selecteerUser(4);
//$data_kitchen_type = $kitchen_type->selecteerkitchen_type(2);
//$data_ingredient = $ingredient->selecteerIngredienten(3);
$data_gerecht_info = $gerecht_info->selecteerGerecht_info(2,"O");

/// RETURN
echo "artikel....................................<pre>"; 
// var_dump($data_art); echo "</pre>";

echo "user.......................................<pre>"; 
// var_dump($data_user); echo "</pre>";

echo "ingredient.................................<pre>"; 
// var_dump($data_ingredient); echo "</pre>";

//var_dump($data_kitchen_type);

echo "gerecht info................................<pre>"; 
var_dump($data_gerecht_info); echo "</pre>";