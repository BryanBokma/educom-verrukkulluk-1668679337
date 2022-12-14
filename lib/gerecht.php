<?php

class gerecht {

    private $connection;
    // private $ingre;
    // private $user;
    // private $info;

    public function __construct($connection) {
        $this->connection = $connection;
        $this->user = new user($connection);
        $this->ingre = new ingredient($connection);
        $this->info = new gerecht_info($connection);
        $this->keuken = new keuken_type($connection);
    }

    private function selectIngredienten($gerecht_id) {
        $data = $this->ingre->selecteerIngredienten($gerecht_id);

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

    private function selectKeuken_type($keuken_type_id) {
        $data = $this->keuken->selecteerKeuken_type($keuken_type_id);

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

    private function selectGemiddeldeVanWaarderingen($gerecht_id) {
        $data = $this->info->berekenGemiddelde($gerecht_id);

        return($data);
    }

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

            $keuken_id = $gerecht["keuken_id"];
            $type_id = $gerecht["type_id"];
            $keuken = $this->selectKeuken_type($keuken_id);
            $type = $this->selectKeuken_type($type_id);

            $berekenCalorieen = $this->berekenCalorieenVoorIngredienten($ingredienten);
            $berekenPrijs = $this->berekenPrijsVoorIngredienten($ingredienten);
            $berekenGemiddelde = $this->selectGemiddeldeVanWaarderingen($gerecht_id);
            

            $gerechten[] = [
                "gerecht" => $gerecht,
                "user" => $user,
                "keuken" => $keuken,
                "ingredienten" => $ingredienten,
                "bereidingswijze" => $bereidingswijze,
                "opmerkingen" => $opmerkingen,
                "waardering" => $waardering,
                "favoriet" => $favoriet,
                "type" => $type,
                "berekenCalorieen" => $berekenCalorieen,
                "berekenPrijs" => $berekenPrijs,
                "gemiddeldeWaardering" => $berekenGemiddelde
            ];

        }// end while

        return($gerechten);

    }//end function gerecht

}//end class gerecht