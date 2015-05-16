<?php
function __autoload($class_name){ include str_replace("\\", "/", $class_name) . '.php';}

use Controller\UserManager;

$response = array();

switch ($_GET["act"]) {
    case "registration":
        $userManager      = new UserManager();
        $user             = $userManager->registration($_GET["user"], $_GET["password"]);
        $response["user"] = $userManager->export($user);
        break;

    default:
        $response["errorMessage"] = "Command is not defined";
        break;
}

echo json_encode($response);
