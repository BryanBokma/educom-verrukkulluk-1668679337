<?php

class gerecht_info {

    private $connection;
    private $usr;

    public function __construct($connection) {
        $this->connection = $connection;
        $this->usr = new user($connection);
    }
  
    public function selecteerGerecht_info(int $gerecht_id, string $record_type) {

        $sql = "SELECT * FROM gerecht_info 
        WHERE gerecht_id = $gerecht_id 
        AND record_type = '$record_type'";

        $return = [];
        
        $result = mysqli_query($this->connection, $sql);

        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

            $info = [];
            $user = [];
            
            $info = [
                "id" => $row["id"],
                "gerecht_id" => $row["gerecht_id"],
                "record_type" => $row["record_type"],
                "datum" => $row["datum"]
                "nummeriekveld" => $row["nummeriekveld"],
                "tekstveld" => $row["tekstveld"]
            ];

            if($record_type == "O" || $record_type == "F")  {
                $usr_id = $row["user_id"];
                $user = $this->selectUser($usr_id);

            $return[] = $info + $user;
            
        }//end if statement

        return($return);

    }// end while function

}//end public function selecteerGerecht_info

public function addFavorite(int $gerechtt_id, int $user_id) {

    $sql = "INSERT INTO gerecht_info (`record_type`, `gerecht_id`, `user_id`)
            VALUES ('F', $gerecht_id, $user_id)";

            $result = mysqli_query($this->connection, $sql);
}//end addFavorite function

public function deleteFavorite(int $gerecht_id, int $user_id) {

    $sql = "DELETE FROM gerecht_info
            WHERE record_type = 'F'
            AND gerecht_id = $gerecht_id
            AND user_id = $user_id";

            $result = mysqli_query($this->connection, $sql);               
}//end deleteFavorite function

}// end class gerecht_info