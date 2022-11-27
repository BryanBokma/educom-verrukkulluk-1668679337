<?php
class gerecht_twee {

    private $connection;
    private $grcht;

    public function __construct($connection) {
        $this->connection = $connection;
        $this->grcht = new gerecht($connection);
    }

    public function selecteerGerecht(int $gerecht_id) {

        mysqli_query($this->connection, $sql);
    }//end function selecteerGerecht

    public function meerdereGerechten(int $gerecht_id) {

        $sql = "SELECT * FROM  gerecht
        WHERE gerecht_id = $gerecht_id
        AND titel = $titel";

        mysqli_query($this->connection, $sql);

        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

            $tmp = [
                "id" => $row["id"],
                "titel" => $row["titel"]
            ];

            if($id >= 2) {
                $tmp["id"] = $row["id"];
                $tmp["titel"] = $row["titel"];
            }
            elseif($id == 1) {
                $tmp["id"] = [1];
                $tmp["titel"] = ["Eggs en Veggies"];
            }

        }//end while 

    }//end function meerdereGerechten

}//end class gerecht_twee