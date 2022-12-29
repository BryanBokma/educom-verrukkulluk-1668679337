<?php

class boodschappen {

    private $connection;
    private $ingre;
    private $artikel;

    public function __construct($connection) {
        $this->connection = $connection;
        $this->ingre = new ingredient($connection);
        $this->artikel = new artikel($connection);
    }

    private function selectIngredienten($gerecht_id) {
        $data = $this->ingre->selecteerIngredienten($gerecht_id);

        return($data);
    }

    private function selectArtikel($artikel_id) {
        $data = $this->artikel->selecteerArtikel($artikel_id);

        return($data);
    }

    private function toevoegenArtikel($ingredient, $user_id) {
        $artikel_id = $ingredient["artikel_id"];

        $sql = "INSERT INTO boodschappen (artikel_id, user_id, aantal)
        VALUES ($artikel_id, $user_id, 1)";
        $result = mysqli_query($this->connection, $sql);
    }//end private function toevoegenArtikel

    private function artikelBijwerken($boodschap, $ingredient) {
        $id = $boodschap["id"];
        $aantal = $this->berekenAantal($boodschap, $ingredient);

        $sql = "UPDATE boodschappen
        SET aantal = $aantal
        WHERE id = $id";
      
        $result = mysqli_query($this->connection, $sql);
    }//end private function artikelBijwerken

    private function berekenAantal($boodschap, $ingredient) {
        $aantal = 0;
        $aantalboodschap = $boodschap["aantal"];
        $aantalingredient = $ingredient["aantal"];
        $verpakkingingredient = $ingredient["verpakking"];

        $berekenaantal = ceil($aantalboodschap + ($aantalingredient / $verpakkingingredient));

        return($berekenaantal);
    }

    public function totaalPrijsBoodschappen($user_id) {
        
        $sql = "SELECT * FROM boodschappen
        WHERE user_id = $user_id";

        $totaalprijsboodschappen = 0;

        $result = mysqli_query($this->connection, $sql);

        while($boodschappen = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $artikel_id = $boodschappen["artikel_id"];
            $artikel = $this->selectArtikel($artikel_id);

            $totaalprijsartikelen = $artikel["prijs"] * $boodschappen["aantal"];

            $totaalprijsboodschappen = $totaalprijsboodschappen + $totaalprijsartikelen;
        }

        return ($totaalprijsboodschappen);
        
    }

    public function ophalenBoodschappen($user_id) {
        $return = [];

        $sql = "SELECT * FROM boodschappen
        WHERE user_id = $user_id";

        $result = mysqli_query($this->connection, $sql);
        while($boodschappen = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $artikel_id = $boodschappen["artikel_id"];
            $artikel = $this->selectArtikel($artikel_id);
            
            $return[] = [
                "boodschappen" => $boodschappen,
                "artikel" => $artikel
            ];
        }//end while

        return($return);

    }//end public function ophalenBoodschappen

    public function ArtikelOpLijst($artikel_id, $user_id) {
        $boodschappen = $this->ophalenBoodschappen($user_id);
        foreach($boodschappen as $boodschap) {
            if($boodschap["artikel_id"] == $artikel_id) {
                return($boodschap);
            }//end if
        
        }//end foreach

        return false;

    }//end public function ArtikelOpLijst

    public function boodschappenToevoegen($gerecht_id, $user_id) {
        $ingredienten = $this->selectIngredienten($gerecht_id);
        foreach($ingredienten as $ingredient) {
            $opgehaald = $this->ArtikelOpLijst($ingredient["artikel_id"], $user_id);
            if(!$opgehaald) {
                $this->toevoegenArtikel($ingredient, $user_id);
            }//end if
            else {
                $this->artikelBijwerken($opgehaald, $ingredient);
            }//end else

        }//end foreach

    }//end public function boodschappenToevoegen

}//end class boodschappen

?>