<?php

require_once("lib/database.php");
require_once("lib/artikel.php");
require_once("lib/user.php");
require_once("kitchen_type");
require_once("lib/ingredient.php");

/// INIT
$db = new database();
$art = new artikel($db->getConnection());
$user = new user($db->getConnection());
$kitchen_type = new kitchen_type(db->getConnection());
$ingredient = new ingredient($db->getConnection());


/// VERWERK 
$data = $art->selecteerArtikel(8);
$data = $user->selecteerUser();
$data = $kitchen_type->selecteerkitchen_type();
$data = $ingredient->selecteeringredient();

/// RETURN
var_dump($data);