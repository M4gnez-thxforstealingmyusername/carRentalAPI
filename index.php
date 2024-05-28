<?php
    header("Access-Control-Allow-Origin: http://localhost:4200");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT");
    header("Access-Control-Allow-Headers: Content-Type, X-Requested-With, Accept");
    header("Content-Type: application/json");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Credentials: true");

    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        header("HTTP/1.1 200 ");
        exit;
    }

    require_once "./config/conn.php";
    require_once "./models/Car.php";
    require_once "./models/User.php";
    require_once "./models/Rent.php";
    require_once "./models/Contact.php";

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
            case "/carRentalAPI/user":
            case "/carRentalAPI/user/":
                User::get();
            break;
            case "/carRentalAPI/car":
            case "/carRentalAPI/car/":
                Car::handle();
            break;
            case "/carRentalAPI/contact":
            case "/carRentalAPI/contact/":
                Contact::handle();
            break;
            case "/carRentalAPI/rent":
            case "/carRentalAPI/rent/":
                Rent::handle();
            break;
            default:
                include("./config/404.php");
        }
    }

    router();
?>