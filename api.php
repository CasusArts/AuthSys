<?php
function __autoload($class_name){ include str_replace("\\", "/", $class_name) . '.php';}

use Controller\UserManager;


$response = array();

switch ($_GET["act"]) {

    case "registration":
        $userManager      = new UserManager();
        $user             = $userManager->registration($_GET["user"], $_GET["pass"]);
        $response["user"] = $userManager->export($user);
        break;

    case "login":
        $userManager = new UserManager();
        $response["user"] = $userManager->login($_GET["user"], $_GET["pass"]);
//        $response["data"] = $userManager->showData();
        break;


    case "getAll":
        $userManager      = new UserManager();
        $response["users"] = $userManager->getAll();
        break;

    case "hash":
        $userManager      = new UserManager();
        $response["hash"] = md5($_GET["text"]);
        break;



    default:
        $response["errorMessage"] = "Command is not defined";
        break;
}

echo json_encode($response);
