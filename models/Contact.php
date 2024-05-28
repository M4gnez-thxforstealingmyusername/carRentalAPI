<?php
    class Contact{
        public static function handle(){
            switch($_SERVER["REQUEST_METHOD"]){
                case "POST":
                    $_POST = json_decode(file_get_contents('php://input'), true);
                    if(isset($_POST["name"]) && isset($_POST["lastName"]) && isset($_POST["email"]) && isset($_POST["phone"])){
                        $name = $_POST["name"];
                        $lastName = $_POST["lastName"];
                        $email = $_POST["email"];
                        $phone = $_POST["phone"];
    
                        include "./config/conn.php";
    
                        $sql = "INSERT INTO `contact` (`id`, `name`, `lastName`, `email`, `phone`) VALUES (NULL, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("ssss", $name, $lastName, $email, $phone);
                        $stmt->execute();
                    }
                    else
                        echo '{"message": "insufficient form data"}';
                break;
                default:
                    echo '{"message": "invalid request method"}';
                break;
            }
        }
    }
?>