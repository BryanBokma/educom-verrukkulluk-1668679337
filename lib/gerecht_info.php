<?php

class gerecht_info {

    private $connection;
    private $usr;

    public function __construct($connection) {
        $this->connection = $connection;
        $this->usr = new user($connection);
    }

    private function selecteerUser($usr_id) {
        $data = $this->usr->selecteerUser($usr_id);

        return($data);
    }
  
    public function selecteerGerecht_info($gerecht_id, $record_type) {

        $sql = "SELECT * FROM gerecht_info WHERE gerecht_id = $gerecht_id and record_type = '$record_type'";
        $return = [];
        
        $result = mysqli_query($this->connection, $sql);

        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

            $usr = [];
            
            $tmp = [
                "id" => $row["id"],
                "record_type" => $row["record_type"],
                "gerecht_id" => $row["gerecht_id"],
                "datum" => $row["datum"],
                "nummeriekveld" => $row["nummeriekveld"],
                "tekstveld" => $row["tekstveld"],
                "user_id" => $row["user_id"],
            ];

            if($record_type == "O" || $record_type == "F") {
                $usr_id = $row["user_id"];
                $usr = $this->selecteerUser($usr_id);
            }

            $return[] = $tmp + $usr;
            
        }//end while function

        return($return);

    }// end function gerecht_info

}// end class gerecht_info