<?php
    require_once "./config/conn.php";
    require_once "./models/Car.php";
    require_once "./models/User.php";

    function router(){
        $uri = $_SERVER['REQUEST_URI'];
        switch($uri){
            case "/carRentalAPI/register":
            case "/carRentalAPI/register/":
                User::register();
            break;
            case "/carRentalAPI/login":
            case "/carRentalAPI/login/":
                User::login();
            break;
            case "/carRentalAPI/logout":
            case "/carRentalAPI/logout/":
                User::logout();
            break;
            case "/carRentalAPI/car":
            case "/carRentalAPI/car/":
                Car::handle();
            break;
            case "/carRentalAPI/contact":
            case "/carRentalAPI/contact/":
            break;
            case "/carRentalAPI/rent":
            case "/carRentalAPI/rent/":
            break;
            case "/carRentalAPI/user":
            case "/carRentalAPI/user/":
            break;
        }
    }

    router();
?>