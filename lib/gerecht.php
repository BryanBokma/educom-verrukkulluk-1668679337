<?php

class gerecht {

    private $connection;
    private $usr;
    private $kitchen;

    public function __construct($connection) {
        $this->connection = $connection;
        $this->usr = new user($connection);
        $this->kitchen = new kitchen_type($connection);
    }

    private function selectUser($usr_id) {
        $data = $this->usr->selecteerUser($usr_id);

        return($data);
    }

    private function selectkitchen_type($kitchen_id) {
        $data = $this->kitchen->selecteerKitchen_type($kitchen_id);

        return($data);
    }

    public function selecteerGerecht($kitchen_id, $type_id) {

        $sql = "SELECT * FROM gerecht WHERE kitchen_id = $kitchen_id AND type_id = '$type_id'";

        $result = mysqli_query($this->connection, $sql);

        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

            $usr = [];
            $kitchen = [];

            $tmp = [
                "id" => $row["id"],
                "kitchen__id" => $row["kitchen_id"],
                "type_id" => $row["type_id"],
                "user_id" => $row["user_id"],
                "datum" => $row["datum"],
                "titel" => $row["titel"],
                "korte_omschrijving" => $row["korte_omschrijving"],
                "lange_omschrijving" => $row["lange_omschrijving"],
                "afbeelding" => $row["afbeelding"],
            ];

            $return[] = $tmp + $usr + $kitchen;

        }

        return($return);

    }
    
}