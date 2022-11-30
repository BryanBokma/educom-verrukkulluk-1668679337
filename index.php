<?php
// Importeer de DB en de verschillende taal scripts:
require_once("lib/database.php");
require_once("lib/artikel.php");
require_once("lib/user.php");

/// INIT Link de classes aan variables
$db = new database();
$artikel = new artikel($db->getConnection());
$user = new user($db->getConnection());

// Verwerk De variable + select functie in een nieuwe variable
$artikel = $artikel->selecteerArtikel();
$user = $user->selecteerUser(4);

// Return
echo "artikel..................................<pre>";
var_dump($artikel); echo "</pre";

echo "user.....................................<pre>";
var_dump($user); echo "</pre>";


