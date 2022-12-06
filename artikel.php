<?php

class artikel {

    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function selecteerArtikel($artikel_id) {

        $sql = "SELECT * FROM artikel
        WHERE id = $artikel_id";

        $result = mysqli_query($this->connection, $sql);
        $artikel = mysqli_fetch_array(MYSQLI, ASSOC);

        return($artikel);

    }//end public function selecteerArtikel

}//end class artikel