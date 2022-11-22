<?php

class gerecht_info {

    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }
  
    public function selecteergerecht_info($gerecht_info_id) {

        $sql = "SELECT * FROM recipeinfo WHERE id = $gerecht_info_id";
        
        $result = mysqli_query($this->connection, $sql);
        $gerecht_info = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return($gerecht_info);

    }// end function recipeinfo

}