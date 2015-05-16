<?php
function __autoload($class_name){ include str_replace("\\", "/", $class_name) . '.php';}
session_start();

use Controller\UserManager;

$userManager      = new UserManager();


switch ($_GET["act"]) {

    case "registration":
        $user             = $userManager->registration($_GET["user"], $_GET["pass"], $_GET["email"]);
        $response["user"] = $userManager->export($user);
        break;

    case "login":
        if(!$userManager->isUserLoggedIn()){
            $response["user"] = $userManager->login($_GET["user"], $_GET["pass"]);
        }
//        $response["data"] = $userManager->showData();
        break;

    case "logout":
        $userManager->logout();
        break;

    case "getAll":
        $response["users"] = $userManager->getAll();
        break;

    case "getLoggedUser":
        $response["user"] = $userManager->getLoggedUser();
        break;

    case "hash":
        $response["hash"] = md5($_GET["text"]);
        break;


    default:
        $response["errorMessage"] = "Command is not defined";
        break;
}

echo json_encode($response);
