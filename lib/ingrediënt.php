<?php

class ingrediënt {
    private $connection;
    
    public function __construct($connection) {
    $this->$connection = $connection;
    }
    
    public function selecteeringrediënt($gerecht_id) {

        $sql = "select * from ingrediënt where id = $gerecht_id";
        

        $result = mysqli_query($this->$connection, $sql);

        while($) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        }

        return($ingrediënt_id);
    }


}