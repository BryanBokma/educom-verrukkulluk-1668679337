<?php

class recipeinfo {

    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }
  
    public function selecteerrecipeinfo($recipeinfo_id) {

        $sql = "select * from recipeinfo where id = $recipeinfo_id";
        
        $result = mysqli_query($this->connection, $sql);
        $artikel = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return($recipeinfo);

    }// end function recipeinfo

    public function kitchentype($kitchentype_id) {

        $sql = "select user_name, password
        AND "
    }