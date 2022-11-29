<?php

class gerecht_info {

    private $connection;
    private $usr;

    public function __construct($connection) {
        $this->connection = $connection;
        $this->usr = new user($connection);
    }
  
    public function selecteerGerecht_info(int $gerecht_id, string $record_type) {

        $sql = "SELECT * FROM gerecht_info WHERE gerecht_id = $gerecht_id AND record_type = '$record_type'";

        $return = [];
        
        $result = mysqli_query($this->connection, $sql);

        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            
            $tmp = [
                "id" => $row["id"],
                "datum" => $row["datum"]
            ];

            if($record_type == "O") {
                $tmp["user"] = $this->usr->selecteerUser($row["user_id"]);
                $tmp["opmerking"] = $row["tekstveld"];
            } 
            elseif($record_type == "F") {
                $tmp["user"] = $this->usr->selecteerUser($row["user_id"]);
            }
            elseif($record_type == "B") {
                $tmp["bereiding"] = $row["tekstveld"];
                $tmp["stap"] = $row["nummeriekveld"];
            } 
            elseif($record_type == "W") {
                $tmp["aantal"] = $row["nummeriekveld"];
            }

            $return[] = $tmp;
            
        }//end while function

        return($return);

    }// end function gerecht_info

public function addFavorite(int $gerechtt_id, int $user_id) {

    $sql = "INSERT INTO gerecht_info (`record_type`, `gerecht_id`, `user_id`)
            VALUES ('F', $gerecht_id, $user_id)";

            $result = mysqli_query($this->connection, $sql);
}

public function deleteFavorite(int $gerecht_id, int $user_id) {

    $sql = "DELETE FROM gerecht_info
            WHERE record_type = 'F'
            AND gerecht_id = $gerecht_id
            AND user_id = $user_id";

            $result = mysqli_query($this->connection, $sql);               
}

}// end class gerecht_info