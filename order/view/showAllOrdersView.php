<?php

$rootPath = __DIR__;
$rootPath = str_replace('order' . DIRECTORY_SEPARATOR . 'view', '', $rootPath);
require_once $rootPath . 'base/importRequireFileList.php';
importRequireFileList(__FILE__ . '/');

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$errorMessage;
$infoMessage;
$overviewOrdersData;

if (isset($_GET['error'])) {
    if ($_GET['error'] == "noOrderAvailable") {
        $errorMessage = "Keine Bestellungen eingetragen!";
    } elseif ($_GET['error'] == "noSessionAvailable") {
        $errorMessage = "Keine Session vorhanden!";
    } elseif ($_GET['error'] == "deleteOrderNotFound") {
        $errorMessage = "Bestellung konnte nicht entfernt werden, nicht gefunden!";
    } elseif ($_GET['error'] == "notAllowed") {
        $errorMessage = "Aktion für aktuellen Benutzer nicht erlaubt!";
    } elseif ($_GET['error'] == "editOrderNotFound") {
        $errorMessage = "Bestellung konnte nicht geändert werden, nicht gefunden!";
    }
} else if (isset($_GET['info'])) {
    if ($_GET['info'] == "deleteSuccess") {
        $infoMessage = "Bestellung erfolgreich entfernt!";
    } elseif ($_GET['info'] == "editSuccess") {
        $infoMessage = "Bestellung erfolgreich geändert!";
    }
}

if (isset($_SESSION['overviewOrdersData'])) {
    $overviewOrdersData = $_SESSION['overviewOrdersData'];
    unset($_SESSION['overviewOrdersData']);
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../base/base.css">
    <link rel="stylesheet" type="text/css" href="../../user/css/user.css">
    <title>php-webshop - showAllOrdersView.php</title>
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
                    <th class="tableHeadline" colspan="6">Alle Bestellungen</th>
                </tr>
                <tr>
                    <th class="tableHeadline">Id</th>
                </tr>
            </thead>
            <tbody>
                <!-- begin if orders are available -->
                <?php if (isset($overviewOrdersData) && count($overviewOrdersData) > 0) {
                    foreach ($overviewOrdersData as $overviewOrderData) {
                        echo '<tr>';
                        echo '<td class="tableCell">' . $overviewOrderData->getId() . '</td>';
                    }
                } else { ?> <!-- begin else overviewOrdersData are available -->
                    <div class="noEntrysAccessible">Keine Einträge vorhanden.</div>
                <?php } ?> <!-- end if overviewOrdersData are available -->
            </tbody>
        </table>
    </main>
</body>

</html>