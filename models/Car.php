<?php

class Car{
    public static function handle(){
        include "./config/conn.php";

        switch($_SERVER["REQUEST_METHOD"]){
            case "GET":
                $sql = "SELECT * FROM car";
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                $result = $stmt->get_result();

                if($result->num_rows > 0)
                {
                    $rows = mysqli_fetch_all($result);

                    echo json_encode($rows, JSON_UNESCAPED_UNICODE);
                }
            break;
            default: 
                echo '{"message": "invalid request method"}';
            break;
        }
    }
}
?>