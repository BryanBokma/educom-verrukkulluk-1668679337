<?php

class zoekfunctie {

    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function zoekFunctie($titel) {

        $sql = "SELECT * FROM gerecht
        WHERE titel LIKE '%$titel%'";

        $alleinfo = [];

        $result = mysqli_query($this->connection, $sql);

        while ($ophaleninfo = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $alleinfo[] = $ophaleninfo;
        } //end while

        return ($alleinfo);
    }//end public function zoekFunctie

}//end class zoekfunctie

?>