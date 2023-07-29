<?php

$rootPath = __DIR__;
$rootPath = str_replace('cart' . DIRECTORY_SEPARATOR . 'view', '', $rootPath);
require_once $rootPath . 'base/importRequireFileList.php';
importRequireFileList(__FILE__ . '/');

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$errorMessage;
$infoMessage;
$cartEntrys;
$cartEntrysCount;
$priceTotal;

$userService = new UserService();

$loggedInUser = $userService->getUserById($_SESSION['loggedInUserData']->getId());

if (isset($_GET['error'])) {
    if ($_GET['error'] == "noCartEntryAvailable") {
        $errorMessage = "Keine Warenkorb-Einträge eingetragen!";
    } elseif ($_GET['error'] == "noSessionAvailable") {
        $errorMessage = "Keine Session vorhanden!";
    } elseif ($_GET['error'] == "deleteCartEntryNotFound") {
        $errorMessage = "Warenkorb-Eintrag konnte nicht gelöscht werden, nicht gefunden!";
    } elseif ($_GET['error'] == "notAllowed") {
        $errorMessage = "Aktion für aktuellen Benutzer nicht erlaubt!";
    } elseif ($_GET['error'] == "removeNotSuccess") {
        $errorMessage = "Eintrag konnte nicht entfernt werden!";
    } elseif ($_GET['error'] == "productCountToHight") {
        $errorMessage = "Anzahl nicht verfügbar!";
    }
} else if (isset($_GET['info'])) {
    if ($_GET['info'] == "removeSuccess") {
        $infoMessage = "Warenkorb-Eintrag erfolgreich gelöscht!";
    } elseif ($_GET['info'] == "editSuccess") {
        $infoMessage = "Warenkorb-Eintrag erfolgreich aktualisiert!";
    }
}

if (isset($_SESSION['cartEntrys'])) {
    $cartEntrys = $_SESSION['cartEntrys'];
    unset($_SESSION['cartEntrys']);
}

if (isset($_SESSION['cartEntrysCount'])) {
    $cartEntrysCount = $_SESSION['cartEntrysCount'];
    unset($_SESSION['cartEntrysCount']);
}

if (isset($_SESSION['priceTotal'])) {
    $priceTotal = $_SESSION['priceTotal'];
    unset($_SESSION['priceTotal']);
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
    <link rel="stylesheet" type="text/css" href="../css/cart.css">
    <title>php-webshop - cart/view/showAllCartEntrysView.php</title>
</head>

<body>
    <?php
    require("../../base/header.php");
    ?>
    <nav>
        <a class="mainMenuItem" href="../../index.php">Home</a>
        <?php
        if ($loggedInUser->isRole('ADMIN')) {
            if (isset($_SESSION['parameterUserData'])) {
                echo '<a href="../controller/cartController.php?showAllCartEntrysViewSubmitButton" class="mainMenuItem">Warenkorb gesamt anzeigen</a>';
            }
        }
        ?>
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
        <?php if (isset($cartEntrys) && count($cartEntrys) > 0) { ?> <!-- begin if cartEntrys are available -->
            <table class="tableAll" cellspacing="0" cellpadding="0">
                <thead>
                    <tr>
                        <?php
                        if ($loggedInUser->isRole('ADMIN')) {
                            if (isset($_SESSION['parameterUserData'])) {
                                $parameterUserData = $_SESSION['parameterUserData'];
                                echo '<th class="tableHeadline" colspan="10">Alle Warenkorb-Einträge von: ' . $parameterUserData->getLoginName() . '</th>';
                                unset($_SESSION['parameterUserData']);
                            } else {
                                echo '<th class="tableHeadline" colspan="10">Alle Warenkorb-Einträge</th>';
                            }
                        } else {
                            echo '<th class="tableHeadline" colspan="9">Warenkorb-Einträge von: ' . $loggedInUser->getLoginName() . '</th>';
                        }
                        ?>
                    </tr>
                    <tr>
                        <th class="tableHeadline">Id (Warenkorb-Eintrag)</th>
                        <th class="tableHeadline">Id (Produkt)</th>
                        <?php
                        if ($loggedInUser->isRole('ADMIN')) {
                            echo '<th class="tableHeadline">Id (Benutzer)</th>';
                        }
                        ?>
                        <th class="tableHeadline">Bild</th>
                        <th class="tableHeadline">Name</th>
                        <th class="tableHeadline">Beschreibung</th>
                        <th class="tableHeadline">Einzelpreis</th>
                        <th class="tableHeadline">Anzahl</th>
                        <th class="tableHeadline">Gesamtpreis</th>
                        <th class="tableHeadline">Aktion</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($cartEntrys)) {
                        foreach ($cartEntrys as $cartEntry) {
                            echo '<tr>';
                            echo '<td class="tableCell">' . $cartEntry->getId() . '</td>';
                            $product = $cartEntry->getProduct();
                            echo '<td class="tableCell">' . $product->getId() . '</td>';
                            $productBuyUser = $cartEntry->getUser();

                            if ($loggedInUser->isRole('ADMIN')) {
                                echo '<td class="tableCell"><a href="../controller/cartController.php?showAllCartEntrysByGetParameterIdViewSubmitButton&id=' . $productBuyUser->getId() . '">' . $productBuyUser->getId() . '</a></td>';
                            }

                            echo '<td class="tableCell"><img src="../../product/image/' . $product->getImage1() . '" class="productImage1" alt="' . $product->getImage1() . '"></td>';
                            echo '<td class="tableCell">' . $product->getName() . '</td>';
                            echo '<td class="tableCell">' . $product->getDescription() . '</td>';
                            echo '<td class="tableCell">' . $product->getRetailPrice() . '</td>';
                            echo '<td class="tableCell">
                            <form action="" method="post">
                                <input type="text" value="' . $cartEntry->getId() . '" name="id" hidden>
                                <label for="productCount">Stk.</label>
                                <input type="number" min="1" value="' . $cartEntry->getProductCount() . '" name="productCount" id="productCount">
                                <button type="submit" name="editProductCountSubmit">Aktualisieren</button>
                            </form>
                            </td>';
                            echo '<td class="tableCell">' . (float)$product->getRetailPrice() * (float)$cartEntry->getProductCount() . '</td>';
                            echo '<td class="tableCell"><a href="../controller/cartController.php?removeProductFromCartSubmitButton&id=' . $cartEntry->getId() . '" class="tableDeleteButton">Entfernen</a></td>';

                            echo '<tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
            <div>
                <div class="countCartEntrysText">Anzahl Produkte: </div>
                <div class="countCartEntrysValue"><?php echo $cartEntrysCount ?></div>
                <div class="priceAllCartEntrysText"> --- Gesamtsumme: </div>
                <div class="priceAllCartEntrysValue"><?php echo $priceTotal ?></div>
            </div>

        <?php } else { ?> <!-- begin else cartEntrys are available -->
            <div class="noEntrysAccessible">Keine Einträge vorhanden.</div>
        <?php } ?> <!-- end if cartEntrys are available -->


        <?php
        if (!$loggedInUser->isRole('ADMIN')) {
            echo '<div><a class="mainMenuItem" href="../../product/controller/productController.php?showAllProductsViewSubmitButton">Weiter einkaufen</a>';

            if (isset($cartEntrys) && count($cartEntrys) > 0) {
                echo '<a class="mainMenuItem" href="../../buy/controller/buyController.php?createEditInvoiceAddressViewSubmitButton">Zur Kasse</a></div>';
            }
        }
        ?>
    </main>
</body>

</html>