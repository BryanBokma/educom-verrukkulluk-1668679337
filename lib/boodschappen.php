<?php

class boodschappen {

    private $connection;
    private $ingre;

    public function __construct($connection) {
        $this->connection = $connection;
        $this->ingre = new ingredient($connection);
    }

    private function selectUser($user_id) {
        $data = $this->user->selecteerUser($user_id);

        return($data);
    }

    private function selectIngredienten($gerecht_id) {
        $data = $this->ingre->selecteerIngredienten($gerecht_id);

        return($data);
    }

    private function toevoegenArtikel($ingredient, $user_id) {
        $artikel_id = $ingredient["artikel_id"];

        $sql = "INSERT INTO boodschappen (artikel_id, user_id, aantal)
        VALUES ('artikel_id', 'user_id', 'aantal')";
        $result = mysqli_query($this->connection, $sql);
    }

    private function artikelBijwerken($user_id, $artikel_id, $aantal) {// Waarom boodschap en ingredient als variable?
        $artikel_id = $ingredient["artikel_id"];

        $sql = "UPDATE boodschappen
        SET aantal = '$aantal'
        WHERE artikel_id = '$artikel_id'
        AND user_id = '$user_id'";
        $result = mysqli_query($this->connection, $sql);
    }

    public function ophalenBoodschappen($user_id) {
        $return = [];

        $sql = "SELECT * FROM boodschappen
        WHERE user_id = $user_id";

        $result = mysqli_query($this->connection, $sql);
        while($boodschappen = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $return[] = $boodschappen;
        }

        return($return);

    }

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

    public function ArtikelOpLijst($artikel_id, $user_id) {
        $boodschappen = $this->ophalenBoodschappen($user_id);
        foreach($boodschappen as $boodschap) {
            if($boodschap["artikel_id"] == $artikel_id) {
                return($boodschap);
            }//end if
        
        }//end foreach

        return False;

    }//end public function ArtikelOpLijst

}//end class boodschappen

?>