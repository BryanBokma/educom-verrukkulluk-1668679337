<?php

class gerecht {

    private $connection;
    private $usr;
    private $ingrdnt;
    private $info;

    public function __construct($connection) {
        $this->connection = $connection;
        $this->usr = new user($connection);
        $this->ingrdnt = new ingredient($connection);
        $this->info = new gerecht_info($connection);
    }

    public function selecteerGerecht($gerecht_id) {

        $sql = "SELECT * FROM gerecht WHERE gerecht_id = $gerecht_id";

        $result = mysqli_query($this->connection, $sql);

        $tmp = [];

        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

            $tmp = [
                "id" => $row["id"],
                "kitchen__id" => $row["kitchen_id"],
                "type_id" => $row["type_id"],
                "user_id" => $row["user_id"],
                "datum" => $row["datum"],
                "titel" => $row["titel"],
                "korte_omschrijving" => $row["korte_omschrijving"],
                "lange_omschrijving" => $row["lange_omschrijving"],
                "afbeelding" => $row["afbeelding"],
                "ingredienten" => $this->ingrdnt->selecteerIngredienten($gerecht_id),
                "user" => $this->usr->selecteerUser($row["user_id"]),
                "bereidingswijze" => $this->info->selecteerGerecht_info($gerecht_id, "B"),
                "waardering" => $this->info->selecteerGerecht_info($gerecht_id, "W"),
                "opmerking" => $this->info->selecteerGerecht_info($gerecht_id, "O")
            ];

        }// end while

        return($tmp);

    }//end function gerecht

    public function calcCalories(int $artikel_id) {

        $sql = "SELECT * FROM artikel
                WHERE artikel_id = $artikel_id
                AND verpakking = $verpakking
                AND calorieen = $calorieen";

            mysqli_query($this->connection, $sql);
    }//end calcCalories function

    public function calcPrice(int $artikel_id) {

        $sql = "SELECT * FROM artikel
        WHERE artikel_id = $artikel_id
        AND verpakking = $verpakking
        AND prijs = $prijs";

        mysqli_query($this->connection, $sql);
    }//end calcPrice function

    
}//end class gerecht