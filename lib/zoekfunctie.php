<?php

private $connection;
private $gerecht;

public function __construct($connection) {
    $this->connection = $connection;
    $this->gerecht = new gerecht($connection);
}

public function zoekFunctie($titel) {

    $sql = "SELECT * FROM gerecht
    WHERE titel = $titel";

    
}