<?php

class ingredient {

    private $connection;
    private $art;//hierin definieeer je variable artikel

    public function __construct($connection) {
        $this->connection = $connection;
        $this->art = new artikel($connection); //de connectie in de database wordt aangelegd naar de artikel class/tabel
    }

    private function selectArtikel($art_id){
        $data = $this->art->selecteerArtikel($art_id);// hiermee haal je de public function selecteerArtikel op en bijbehorende data die zich binnen de functie bevinden. Die je binnen je public function weer kan gebruiken. 

        return($data);// return data is bovenstaande functie selecteerArtikel
    }

    public function selecteerIngredienten(int $gerecht_id) {// je pakt gerecht_id

        $sql = "SELECT * FROM ingredient
        WHERE gerecht_id = $gerecht_id";// alles selecteren van de ingredient tabel, waarom gerecht_id en niet id?

        $ingredienten = [];// $ingredienten lege array, omdat anders de variable niet bestaat. 

        $result = mysqli_query($this->connection, $sql); // de query wordt uitgevoerd en hierdoor kun je de data uit de database ophalen, hiervoor wordt connection gebruikt om toegang te krijgen.

        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {//Als je een array hebt, heb je altijd een loop!!

            $art_id = $row["artikel_id"];// hierbij definieer je de bovenstaande variable $row aan artikel_id, hierbij haalt hij alle gegevens op die horen bij artikel_id en die krijgen de variable art_id
            $artikel = $this->selectArtikel($art_id);// hierbij roep je de private function aan die je hierboven hebt beschreven in de class

            $ingredienten[] = [//array aan gegevens die je wilt hebben
                "id" => $row["id"],
                "gerecht_id" => $row["gerecht_id"],
                "artikel_id" => $row["artikel_id"],
                "aantal" => $row["aantal"],
                "naam" => $artikel["naam"],
                "omschrijving" => $artikel["omschrijving"],
                "prijs" => $artikel["prijs"],
                "eenheid" => $artikel["eenheid"],
                "verpakking" => $artikel["verpakking"],
                "calorieen" => $artikel["calorieen"],
                "afbeelding" => $artikel["afbeelding"]
            ];

        }//end while

        return($ingredienten);//return bovenstaande loop/array

    }// end public function selecteerIngredienten

}//end class ingredient

?>