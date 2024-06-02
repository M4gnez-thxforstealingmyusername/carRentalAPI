<?php
    class Rent{
        public static function handle(){
            switch($_SERVER["REQUEST_METHOD"]){
                case "POST":
                    $_POST = json_decode(file_get_contents('php://input'), true);
                    if(isset($_POST["carId"]) && isset($_POST["startDate"]) && isset($_POST["endDate"])){
                        session_start();
                        if(isset($_SESSION["user"])){
                            $userId = $_SESSION["user"];
                            $carId = $_POST["carId"];
                            $startDate = $_POST["startDate"];
                            $endDate = $_POST["endDate"];

                            include "./config/conn.php";

                            $sql = "INSERT INTO `rent` (`id`, `userId`, `carId`, `startDate`, `endDate`) VALUES (NULL, ?, ?, ?, ?)";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("ssss", $userId, $carId, $startDate, $endDate);
                            $stmt->execute();
                        }
                        else
                            echo '{"message": "no user logged in"}';
                    }
                    else
                        echo '{"message": "insufficient form data"}';
                break;
                case "GET":
                    session_start();
                    if(isset($_SESSION["user"])){
                        include "./config/conn.php";

                        $sql = "SELECT * FROM rent";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();

                        $result = $stmt->get_result();

                        if($result->num_rows > 0)
                        {
                            $rows = $result->fetch_all(MYSQLI_ASSOC);

                            echo json_encode($rows, JSON_UNESCAPED_UNICODE);
                        }
                    }
                    else{
                        echo '{"message": "no user logged in"}';
                }
                break;
                case "PUT":
                    $_POST = json_decode(file_get_contents('php://input'), true);
                    session_start();
                    if(isset($_SESSION["user"])){
                        include "./config/conn.php";

                        $startDate = $_POST["startDate"];
                        $endDate = $_POST["endDate"];
                        $rentId = $_POST["rentId"];

                        $sql = "UPDATE `rent` SET `startDate` = ?, `endDate` = ? WHERE `rent`.`id` = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("ssi", $startDate, $endDate, $rentId);
                        $stmt->execute();

                    }
                    else
                        echo '{"message": "no user logged in"}';
                break;
                case "DELETE":
                    $_POST = json_decode(file_get_contents('php://input'), true);
                    session_start();
                    if(isset($_SESSION["user"])){
                        include "./config/conn.php";

                        $rentId = $_POST["rentId"];

                        $sql = "DELETE FROM `rent` WHERE `rent`.`id` = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $rentId);
                        $stmt->execute();

                    }
                    else
                        echo '{"message": "no user logged in"}';
                break;
                default:
                    echo '{"message": "invalid request method"}';
                break;
            }
        }
    }
?>