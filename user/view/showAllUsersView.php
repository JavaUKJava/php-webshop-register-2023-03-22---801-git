<?php

$rootPath = __DIR__;
$rootPath = str_replace('user' . DIRECTORY_SEPARATOR . 'view', '', $rootPath);
require_once $rootPath . 'base/importRequireFileList.php';
importRequireFileList(__FILE__ . '/');

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$errorMessage;
$infoMessage;
$users;

if (isset($_GET['error'])) {
    if ($_GET['error'] == "noUserAvailable") {
        $errorMessage = "Keine Benutzer eingetragen!";
    } elseif ($_GET['error'] == "noSessionAvailable") {
        $errorMessage = "Keine Session vorhanden!";
    } elseif ($_GET['error'] == "deleteUserNotFound") {
        $errorMessage = "Benutzer konnte nicht entfernt werden, nicht gefunden!";
    } elseif ($_GET['error'] == "deleteDateOrTimeNotFound") {
        $errorMessage = "Datum oder Uhrzeit für Entfernen wurde nicht gewählt!";
    } elseif ($_GET['error'] == "notAllowed") {
        $errorMessage = "Aktion für aktuellen Benutzer nicht erlaubt!";
    } elseif ($_GET['error'] == "editUserNotFound") {
        $errorMessage = "Benutzer konnte nicht geändert werden, nicht gefunden!";
    }
} else if (isset($_GET['info'])) {
    if ($_GET['info'] == "deleteSuccess") {
        $infoMessage = "Benutzer erfolgreich entfernt!";
    } elseif ($_GET['info'] == "editSuccess") {
        $infoMessage = "Benutzer erfolgreich geändert!";
    }
}

if (isset($_SESSION['users'])) {
    $users = $_SESSION['users'];
    unset($_SESSION['users']);
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../base/base.css">
    <link rel="stylesheet" type="text/css" href="../css/user.css">
    <title>php-webshop - userAdministration/view/showAllUsersView.php</title>
</head>

<body>
    <?php
    require("../../base/header.php");
    ?>
    <nav>
        <a class="mainMenuItem" href="../../index.php">Home</a>
    </nav>
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
    <main>
        <table class="tableAll" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th class="tableHeadline" colspan="6">Alle Benutzer</th>
                </tr>
                <tr>
                    <th class="tableHeadline">Id</th>
                    <th class="tableHeadline">Login Name</th>
                    <th class="tableHeadline">Registriert am</th>
                    <th class="tableHeadline">Letzter Login am</th>
                    <th class="tableHeadline">Aktiv</th>
                    <th class="tableHeadline">Aktion</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($users)) {
                    foreach ($users as $user) {
                        echo '<tr>';
                        echo '<td class="tableCell">' . $user->getId() . '</td>';
                        echo '<td class="tableCell">' . $user->getLoginName() . '</td>';
                        echo '<td class="tableCell">' . date('d/m/y H:i:s', $user->getRegistrationTime()) . '</td>';
                        echo '<td class="tableCell">' . date('d/m/y H:i:s', $user->getLastLoginTime()) . '</td>';

                        $activeString = "";

                        if ($user->getActive() == 1) {
                            $activeString = "Ja";
                        } else {
                            $activeString = "Nein";
                        }

                        echo '<td class="tableCell">' . $activeString . '</td>';

                        if (!$user->isRole('ADMIN')) {
                            echo '<td class="tableCell"><a href="../controller/userController.php?showEditUserViewSubmitButton&id=' . $user->getId() . '" class="tableEntryEditButton">Bearbeiten</a>';
                            echo '<a href="../controller/userController.php?deleteUserSubmitButton&id=' . $user->getId() . '" class="tableEntryDeleteButton">Entfernen</a></td>';
                        } else {
                            echo '<td></td>';
                        }

                        echo '</tr>';
                    }
                }
                ?>
            </tbody>
        </table>
        <br>
        <div>Benutzer löschen mit letztem Login vor:</div>
        <form action="../controller/userController.php" name="lastLoginTimeForm" method="post">
            <input type="date" name="lastLoginDate">
            <input type="time" name="lastLoginTime">
            <button type="submit" class="tableEntryDeleteButton" name="deleteUserLastLoginTimeSubmitButton">Entfernen</button>
        </form>
    </main>
</body>

</html>