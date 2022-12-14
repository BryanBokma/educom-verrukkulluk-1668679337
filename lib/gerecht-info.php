<?php

class gerecht_info {

    private $connection;
    private $user;//hierin wordt de variable user gedefinieerd

    public function __construct($connection) {
        $this->connection = $connection;
        $this->user = new user($connection);//de connectie naar de database om de user class op te halen, word aangelegd.
    }

    private function selectUser($user_id) {
        $data = $this->user->selecteerUser($user_id);// Haalt de public function op in user.php

        return($data);//Uitkomst van de functie
    }

    public function selecteerGerecht_info($gerecht_id, $record_type) {// je wilt de info van een gerecht ophalen, record_type heb je nodig voor opmerking en favoriet. 

        $sql = "SELECT * FROM gerecht_info
        WHERE gerecht_id = $gerecht_id 
        AND record_type = '$record_type'";//je selecteert alles van de tabel gerecht_info en hierbij wil je gerecht_id en record_type_id hebben. 
        //linkerkant van het = teken is wat ik in mijn database heb gedefinieerd en aan de rechterkant van het = teken 

        $return = [];

        $result = mysqli_query($this->connection, $sql);

        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

        $info = [];//hierbij maak je een lege array omdat de variable anders niet buiten de loop bestaat. 
        $user = [];//hierbij maak je een lege array omdat de variable anders niet buiten de loop bestaat.
            
        $info = [//gegevens van de array, deze zijn van gerecht_info
            "id" => $row["id"],
            "record_type" => $row["record_type"],
            "gerecht_id" => $row["gerecht_id"],
            "user_id" => $row["user_id"],
            "datum" => $row["datum"],
            "nummeriekveld" => $row["nummeriekveld"],
            "tekstveld" => $row["tekstveld"]
        ];

        if($record_type == "O" || $record_type == "F") {
            $user_id = $row["user_id"];
            $user = $this->selectUser($user_id);

            //als record_type O en/of F is. Dan haalt hij hierbij ook de user op. 

        }//end if

        $return[] = $info + $user;

    }//end while   

    return($return);

}//end public function selecteerGerecht_info

    public function addFavorite($gerecht_id, $user_id) {// gerecht_id en user_id omdat een user het gerecht als Favoriet aangeeft. 

        $sql = "INSERT INTO gerecht_info (record_type, gerecht_id, user_id)
                VALUES(F, $gerecht_id, $user_id";// Om favorieten te bepalen op de site. Geef je de waarde F aan. Een favoriet word gegeven aan het gerecht en dit word door een user gedaan, vandaar de user. 

                $result = mysqli_query($this->connection, $sql);//de query word uitgevoerd om de data uit de databse te halen. 
    }//end addFavorite function

    public function deleteFavorite($gerecht_id, $user_id) {// Hierbij wordt door de user Favoriet verwijderd aan een gerecht. Zoals ook hieronder staat beschreven. 

        $sql = "DELETE FROM gerecht_info
                WHERE record_type = 'F'
                AND gerecht_id = $gerecht_id
                AND user_id = $user_id";

        $result = mysqli_query($this->connection, $sql);// query wordt uitgevoerd om de data op te halen uit de database. 
    }//end deleteFavorite function

    public function addWaardering($gerecht_id, $rating) { 
        
        $sql = "INSERT INTO gerecht_info (gerecht_id, record_type, nummeriekveld)
        VALUES ($gerecht_id, 'W', $rating)";

        return($this->connection->query($sql));
    }//end addWaardering

    public function berekenGemiddelde($gerecht_id) {
        
        $sql = "SELECT nummeriekveld FROM gerecht_info
                WHERE record_type = 'W' 
                AND gerecht_id = $gerecht_id";
                
        $result = mysqli_query($this->connection, $sql);
        
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $waarderingen[] = $row["nummeriekveld"];
        }

        // bereken gemiddelde
        $count= count($waarderingen);
        $sum = array_sum($waarderingen);
        $berekening = $sum/$count;
        $berekeningRounded = round($berekening);
    
        return $berekeningRounded;
        
    }//end public function berekenGemiddelde

}//end class gerecht_info