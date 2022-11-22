<?php

class ingredient {
    private $connection;
    private $art;
    
    public function __construct($connection) {
    $this->connection = $connection;
    $this->art = new artikel($connection);
    }

    private function selectArtikel($art_id) {
        $data = $this->art->selecteerArtikel($art_id);
        return($data);
    }
    
    public function selecteeringredient($gerecht_id) {

        $sql = "select * from ingredient where id = $gerecht_id";
        $return = [];

        $result = mysqli_query($this->connection, $sql);

        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

            $art_id = $row["artikel_id"];
            $artikel = $this->selectArtikel($art_id);

            $return[] = [

                "id" => $row["id"],
                "gerechtd_id" => $row["gerecht_id"],
                "artikel_id" => $row["artikel_id"],
                "aantal" => $row["aantal"],
                "naam" => $artikel["naam"],
                "omschrijving" => $artikel["omschrijving"],
            ];
            
        }// end while function

        return($return);

    }// end public function selecteeringredient

}// end class ingredient

?>