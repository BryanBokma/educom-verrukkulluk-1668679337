<?php

class gerecht {

    private $connection;
    private $keuken_type;
    private $ingredient;
    private $user;
    private $info;

    public function __construct($connection) {
        $this->connection = $connection;
        $this->keuken_type = new keuken_type($connection);
        $this->ingredient = new ingredient($connection);
        $this->user = new user($connection);
        $this->info = new info($connection);
    }

    private function selectKeuken_type($keuken_type_id) {
        $data = $this->keuken_type->selecteerKeuken_type($keuken_type_id);

        return($data);
    }

    private function selectIngredienten($gerecht_id) {
        $data = $this->ingredient->selecteerIngredienten($gerecht_id);

        return($data);
    }
    private function selectUser($user_id) {
        $data = $this->user->selecteerUser($user_id);

        return($data);
    }

    private function selectGerecht_info($gerecht_id, $record_type) {
        $data = $this->info->selecteerGerecht_info($gerecht_id, $record_type);

        return($data);
    }

    private function berekenCalorieenVoorIngredienten($ingredienten) {
        
    }

    private function berekenPrijsVoorIngredienten($ingredienten) {

    }

    public function selecteerGerecht($gerecht_id) {

        $sql = "SELECT * FROM gerecht
        WHERE id = $gerecht_id";

        $gerechten = [];

        $result = mysqli_query($this->connection, $sql);

        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

            

            $gerechten[] = [
                "id" => $row["id"],
                "keuken_id" => $row["keuken_id"],
                "type_id" => $row["type_id"],
                "user_id" => $row["user_id"],
                "datum_toegevoegd" => $row["datum toegevoegd"],
                "titel" => $row["titel"],
                "korte_omschrijving" => $row["korte_omschrijving"],
                "lange_omschrijving" => $row["lange_omschrijving"],
                "afbeelding" => $row["afbeelding"]
            ];

        }//end while
        
        return($gerechten);

    }//end public function selecteerGerecht

}//end class gerecht