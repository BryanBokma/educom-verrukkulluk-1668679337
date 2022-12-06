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
        $this->ingre = new ingredient($connection);
        $this->info = new gerecht_info($connection);
        $this->keuken = new keuken_type($connection);
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
    }//end private function selectGerecht_info

    private function selectKeuken_type($kitchen_type_id) {
        $data = $this->kitchen->selecteerKeuken_type($kitchen_type_id);

        return($data);
    }//end private function selectKeuken_type

    private function berekenCalorieenVoorIngredienten($ingredienten) {

        $totaal = 0;

        foreach($ingredienten as $ingredient) {
            $calorieen = $ingredient["calorieen"]*
            ($ingredient["aantal"]/
            $ingredient["verpakking"]);
        
            $totaal = $totaal + $calorieen;
        }

        return($totaal);

    }//end berekenCalorieenVoorIngredienten function

    private function berekenPrijsVoorIngredienten($ingredienten) {

        $totaal = 0;

        foreach($ingredienten as $ingredient) {
            $prijs = $ingredient["prijs"]*
            ($ingredient["aantal"]/
            $ingredient["verpakking"]);

            $totaal = $totaal + $prijs;

            return($totaal);
        }
    }//end berekenPrijsVoorIngredienten function

    public function selecteerGerecht($gerecht_id = NULL) {

        $sql = "SELECT * FROM gerecht";

        if(!is_null($gerecht_id)) {

        $sql .= " WHERE id = $gerecht_id";

        }//end if

        $gerechten = [];

        $result = mysqli_query($this->connection, $sql);

        while($gerecht = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

            $gerecht_id = $gerecht["id"];

            $user_id = $gerecht["user_id"];
            $user = $this->selectUser($user_id);

            $ingredienten = $this->selectIngredienten($gerecht_id);

            $bereidingswijze = $this->selectGerecht_info($gerecht_id, "B");
            $opmerkingen = $this->selectGerecht_info($gerecht_id, "O");
            $waardering = $this->selectGerecht_info($gerecht_id, "W");
            $favoriet = $this->selectGerecht_info($gerecht_id, "F");

            $kitchen_id = $gerecht["kitchen_id"];
            $type_id = $gerecht["type_id"];
            $kitchen = $this->selectKeuken_type($keuken_id);

            $berekenCalorieen = $this->berekenCalorieenVoorIngredienten($ingredienten);
            $berekenPrijs = $this->berekenPrijsVoorIngredienten($ingredienten);
            

            $gerechten[] = [
                "id" => $row["id"],
                "kitchen_id" => $row["kitchen_id"],
                "type_id" => $row["type_id"],
                "user_id" => $row["user_id"],
                "datum_toegevoegd" => $row["datum_toegevoegd"],
                "titel" => $row["titel"],
                "korte_omschrijving" => $row["korte_omschrijving"],
                "lange_omschrijving" => $row["lange_omschrijving"],
                "afbeelding" => $row["afbeelding"],
                "user" => $user,
                "kitchen" => $kitchen,
                "ingredienten" => $ingredienten,
                "berekenCalorieen" => $berekenCalorieen,
                "berekenPrijs" => $berekenPrijs
            ];

        }// end while

        return($gerechten);

    }//end function gerecht

}//end class gerecht