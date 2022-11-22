<?php

class kitchen_type {

    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }
  
    public function selecteerkitchen_type($kitchen_type_id) {

        $sql = "SELECT * FROM kitchen_type WHERE id = $kitchen_type_id";
        
        $result = mysqli_query($this->connection, $sql);
        $kitchen_type = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return($kitchen_type);

    }

}