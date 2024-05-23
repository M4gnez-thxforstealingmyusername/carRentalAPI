<?php
    class User{
        private static function startSession($email){
            $id = User::getOne($email);
            session_start();
            $_SESSION["user"] = $id;
        }

        public static function register(){
            if($_SERVER["REQUEST_METHOD"] == "POST")
            {

                if(isset($_POST["name"]) && isset($_POST["lastName"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["phone"])){
                    $name = $_POST["name"];
                    $lastName = $_POST["lastName"];
                    $email = $_POST["email"];
                    $password = $_POST["password"];
                    $phone = $_POST["phone"];

                    if(User::getOne($email) == 0){
                        $password = password_hash($password, PASSWORD_DEFAULT);
                        include "./config/conn.php";

                        $sql = "INSERT INTO `user` (`id`, `name`, `lastName`, `email`, `password`, `phone`) VALUES (NULL, ?, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("sssss", $name, $lastName, $email, $password, $phone);
                        $stmt->execute();

                        User::startSession($email);

                        echo json_encode('{logged: "logged as '.$email.'"}', JSON_UNESCAPED_UNICODE);
                    }
                    else
                        echo json_encode('{logged: "email already used"}', JSON_UNESCAPED_UNICODE);
                }
                else
                    echo json_encode('{logged: "insufficient form data"}', JSON_UNESCAPED_UNICODE);
            }
            else
                echo json_encode('{logged: "invalid request method"}', JSON_UNESCAPED_UNICODE);
        }

        public static function login(){
            include "./config/conn.php";
            $email = $_POST["email"];
            $password = $_POST["password"];

            $sql = "SELECT * FROM user WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    if(password_verify($password, $row["password"]))
                    {
                        User::startSession($email);

                        echo json_encode('{logged: "logged as '.$email.'"}', JSON_UNESCAPED_UNICODE);
                    }
                    else
                        echo json_encode('{logged: "password incorrect"}', JSON_UNESCAPED_UNICODE);
                    echo $row["email"];
                    echo $password;
                }
            }
            else
                echo json_encode('{logged: "user not found"}', JSON_UNESCAPED_UNICODE);
        }

        public static function logout(){
            session_start();
            unset($_SESSION["user"]);
            session_destroy();
            echo json_encode('{logged: "logged out"');
        }

        private static function getOne($email){
            include "./config/conn.php";

            $sql = "SELECT id FROM user WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();

            $result = $stmt->get_result();

            if($result->num_rows > 0)
            {
                $row = $result->fetch_assoc();
                return $row["id"];
            }
            else return 0;
        }
    }
?>