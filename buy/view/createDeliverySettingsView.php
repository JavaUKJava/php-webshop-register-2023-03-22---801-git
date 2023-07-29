<?php

$rootPath = __DIR__;
$rootPath = str_replace('buy' . DIRECTORY_SEPARATOR . 'view', '', $rootPath);
require_once $rootPath . 'base/importRequireFileList.php';
importRequireFileList(__FILE__ . '/');

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$errorMessage;
$infoMessage;
$deliveryOptions;
$defaultValueDeliveryOption;

$userService = new UserService();
$loggedInUser = $userService->getUserById($_SESSION['loggedInUserData']->getId());

if (isset($_SESSION['errorMessage'])) {
    $errorMessage = $_SESSION['errorMessage'];
    unset($_SESSION['errorMessage']);
}

if (isset($_SESSION['infoMessage'])) {
    $infoMessage = $_SESSION['infoMessage'];
    unset($_SESSION['infoMessage']);
}

if (isset($_SESSION['deliveryOptions'])) {
    $deliveryOptions = $_SESSION['deliveryOptions'];
    unset($_SESSION['deliveryOptions']);
}

if (isset($_SESSION['defaultValueDeliveryOption'])) {
    $defaultValueDeliveryOption = $_SESSION['defaultValueDeliveryOption'];
    unset($_SESSION['defaultValueDeliveryOption']);
}

if (isset($errorMessage)) {
} else if (isset($infoMessage)) {
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../base/base.css">
    <link rel="stylesheet" type="text/css" href="../../product/css/product.css">
    <title>php-webshop - buy/view/createDeliverySettingsView.php</title>
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
        <form action="../controller/buyController.php" method="post">
            <table class="tableForInput">
                <thead>
                    <tr>
                        <th colspan="2">Lieferoptionen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($deliveryOptions as $deliveryOption) {
                        echo '<tr>';
                        echo '<td></td>';

                        if (isset($defaultValueDeliveryOption) && $deliveryOption->getId() == $defaultValueDeliveryOption->getId()) {
                            echo '<td><input type="radio" name="deliveryOptionId" value="' . $deliveryOption->getId() . '" checked>' . $deliveryOption->getName() . '</td>';
                        } else {
                            echo '<td><input type="radio" name="deliveryOptionId" value="' . $deliveryOption->getId() . '">' . $deliveryOption->getName() . '</td>';
                        }

                        echo '</tr>';
                    }
                    ?>
                    <tr>
                        <td><button type="submit" name="backwardToCreateEditInvoiceAddressViewSubmitButton">Zurück</button></td>
                        <td><button type="submit" name="registerDeliverySettingsSubmitButton">Weiter</button></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><button type="reset">Reset</button></td>
                    </tr>
                </tbody>
            </table>
        </form>
    </main>
</body>

</html>