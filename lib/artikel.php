<?php

class artikel {

    private $connection; //Door het woordje private kun je de variable alleen binnen de class aanroepen, verder definieer je dus 1 private variable.

    public function __construct($connection) {//__construct gaat automatisch af. Op het moment dat je zegt new gaat de constrcutor automatisch af.
        $this->connection = $connection;//Hiermee leg je verbinding naar de database, zodat je de gegevens vanuit de databse kunt ophalen binnen je class/functie.
    }

    public function selecteerArtikel($artikel_id) {

        $sql = "SELECT * FROM artikel
        WHERE id = $artikel_id"; //d.m.v. sql selecteer je alles van tabel artikel en gebruik je hiervoor het artkel_id

        $result = mysqli_query($this->connection, $sql);// de query wordt uitgevoerd en hierdoor kun je de data uit de database ophalen, hiervoor wordt connection gebruikt om toegang te krijgen.
        $artikel = mysqli_fetch_array($result, MYSQLI_ASSOC);// hierbij worden de gegevens uit de tabel opgehaald, die zijn opgegeven, dit word weergegeven in een array.

        return($artikel);// return variable artikel, dit word weergegeven in een array.

    }//end public function selecteerArtikel

}//end class artikel