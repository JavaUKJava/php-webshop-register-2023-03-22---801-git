<?php

require_once 'base/importRequireFileList.php';
importRequireFileList(__FILE__ . '/');

$userService = new UserService();

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$errorMessage;
$infoMessage;

if (isset($_GET['error'])) {
    if ($_GET['error'] == "faildToSave") {
        $errorMessage = "User konnte NICHT erstellt werden!";
    } elseif ($_GET['error'] == "emptyField") {
        $errorMessage = "Bitte alle Felder ausfüllen!";
    } elseif ($_GET['error'] == "invalidLoginName") {
        $errorMessage = "Benutzername nicht verwendbar!";
    } elseif ($_GET['error'] == "invalidPasswordCheck") {
        $errorMessage = "Passwörter unterschiedlich!";
    } elseif ($_GET['error'] == "sqlerror") {
        $errorMessage = "Fehler bei Datenbankabfrage!";
    } elseif ($_GET['error'] == "userExist") {
        $errorMessage = "Benutzer mit diesem Namen bereits vorhanden!";
    } elseif ($_GET['error'] == "wrongLoginNameOrPassword") {
        $errorMessage = "Falscher Benutzername oder Passwort!";
    }
} else if (isset($_GET['info'])) {
    if ($_GET['info'] == "editOwnUserSuccess") {
        $infoMessage = "User erfolgreich bearbeitet!";
    }
}

if (isset($_SESSION)) {
    $availableLoggedInUserData = false;

    if (isset($_SESSION['loggedInUserData'])) {
        $loggedInUserDataId = $_SESSION['loggedInUserData']->getId();

        $availableLoggedInUserData = $userService->isUserAvailable($loggedInUserDataId);
    }

    if ($availableLoggedInUserData == false) {
       createNotRegisteredUser();
    }
}
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="base/base.css">
    <title>php-webshop - index.php</title>
</head>

<body>
    <?php
    require("base/header.php");
    require("base/nav.php");
    ?>
    <div class="errorMessage">
        <?php
        echo isset($errorMessage) ? $errorMessage : '';
        ?>
    </div>
    <div class="infoMessage">
        <?php
        echo isset($infoMessage) ? $infoMessage : '';
        ?>
    </div>

</body>

</html>