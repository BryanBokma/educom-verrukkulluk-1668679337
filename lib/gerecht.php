<?php

class gerecht {

    private $connection;
    private $usr;
    private $info;
    private $kitchen;
    private $ingre;

    public function __construct($connection) {
        $this->connection = $connection;
        $this->user = new user($connection);
        $this->ingre = new ingredient($connection);
        $this->info = new gerecht_info($connection);
        $this->kitchen = new kitchen_type($connection);
    }

    private function selectUser($user_id) {
        $data = $this->user->selecteerUser($user_id);

        return($data);
    }//end private function selectUser

    private function selectIngredienten($gerecht_id) {
        $data = $this->ingre->selecteerIngredienten($gerecht_id);

        return($data);
    }//end private function selectIngredienten

    private function selectGerecht_info($gerecht_id, $record_type) {
        $data = $this->info->selecteerGerecht_info($gerecht_id, $record_type);

        return($data);
    }//end private function selectGerecht_info

    private function selectKitchen_type($kitchen_type_id) {
        $data = $this->kitchen->selecteerKitchen_type($kitchen_type_id);

        return($data);
    }//end private function selectKitchen

    private function berekenCalorieenVoorIngredienten($ingredienten) {

        $totaal = 0;

        echo "<hr>";

        foreach($ingredienten as $ingredient) {
            $calorieen = $ingredient["calorieen"]*
            ($ingredient["aantal"]/
            $ingredient["verpakking"]);
            $data = $ingredient["calorieen"];
            echo ($data);
            echo ( "*");
            $data = $ingredient["aantal"];
            echo ($data);
            echo ( "/");
            $data = $ingredient["verpakking"];
            echo ($data);
            echo ( "=");
            echo ($calorieen);
            echo ( "-");
            

            $totaal = $totaal + $calorieen;
            echo ($totaal);
            echo ( "<br>");
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
            $kitchen = $this->selectKitchen_type($kitchen_id);

            $berekenCalorieen = $this->berekenCalorieenVoorIngredienten($ingredienten);
            $berekenPrijs = $this->berekenPrijsVoorIngredienten($ingredienten);
            

            $gerechten[] = [
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