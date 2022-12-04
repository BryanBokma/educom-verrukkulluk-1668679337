<?php
// Importeer de DB en de verschillende taal scripts:
require_once("lib/database.php");
require_once("lib/artikel.php");
require_once("lib/user.php");
require_once("lib/keuken_type.php");
require_once("lib/ingredient.php");

/// INIT Link de classes aan variables
$db = new database();
$art = new artikel($db->getConnection());
$user = new user($db->getConnection());
$keuken_type = new keuken_type($db->getConnection());
$ingredient = new ingredient($db->getConnection());

// Verwerk De variable + select functie in een nieuwe variable
$artikel = $art->selecteerArtikel(2);
$user = $user->selecteerUser(4);
$keuken_type = $keuken_type->selecteerKeuken_type(3);
$ingredient = $ingredient->selecteerIngredienten(2);

// Return
echo "artikel..................................<pre>";
var_dump($artikel); echo "</pre";

echo "user.....................................<pre>";
var_dump($user); echo "</pre>";

echo "keuken_type..............................<pre>";
var_dump($keuken_type); echo "</pre>";

echo "ingredient...............................<pre>";
var_dump($ingredient); echo "</pre>";





