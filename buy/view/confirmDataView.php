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
$confirmOrderData;
$cartEntrysCount;
$priceTotal;

if (isset($_SESSION['errorMessage'])) {
    $errorMessage = $_SESSION['errorMessage'];
    unset($_SESSION['errorMessage']);
}

if (isset($_SESSION['infoMessage'])) {
    $infoMessage = $_SESSION['infoMessage'];
    unset($_SESSION['infoMessage']);
}

if (isset($_SESSION['confirmOrderData'])) {
    $confirmOrderData = $_SESSION['confirmOrderData'];
    unset($_SESSION['confirmOrderData']);
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
    <link rel="stylesheet" type="text/css" href="../../cart/css/cart.css">
    <title>php-webshop - buy/view/confirmDataView.php</title>
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
                        <th colspan="2">Bestellung prüfen und absenden</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div>
                                <div>Rechnungsadresse</div>
                                <?php
                                $invoiceConfirmAddressData = $confirmOrderData->getInvoiceConfirmAddressData();

                                echo ('<div>' . ($invoiceConfirmAddressData->getSalutation() != "---" ? $invoiceConfirmAddressData->getSalutation() . ' ' : '')
                                    . ($invoiceConfirmAddressData->getTitleBeforeName() != "" ? $invoiceConfirmAddressData->getTitleBeforeName() . ' ' : '')
                                    . ($invoiceConfirmAddressData->getFirstName() != "" ? $invoiceConfirmAddressData->getFirstName() . ' ' : '')
                                    . ($invoiceConfirmAddressData->getLastName() != "" ? $invoiceConfirmAddressData->getLastName() . ', ' : '')
                                    . ($invoiceConfirmAddressData->getTitleAfterName() != "" ? $invoiceConfirmAddressData->getTitleAfterName() : '')
                                    . '</div>');

                                if ($invoiceConfirmAddressData->getAddressLine1() != "") {
                                    echo ('<div>' . $invoiceConfirmAddressData->getAddressLine1() . '</div>');
                                }

                                if ($invoiceConfirmAddressData->getAddressLine2() != "") {
                                    echo ('<div>' . $invoiceConfirmAddressData->getAddressLine2() . '</div>');
                                }

                                echo ('<div>' . ($invoiceConfirmAddressData->getPostalCode() != "---" ? $invoiceConfirmAddressData->getPostalCode() . ' ' : '')
                                    . ($invoiceConfirmAddressData->getLocation() != "" ? $invoiceConfirmAddressData->getLocation() : '')
                                    . '</div>');

                                if ($invoiceConfirmAddressData->getCountry() != "") {
                                    echo ('<div>' . $invoiceConfirmAddressData->getCountry() . '</div>');
                                }

                                if ($invoiceConfirmAddressData->getPhoneNumber() != "") {
                                    echo ('<div>Telefon: ' . $invoiceConfirmAddressData->getPhoneNumber() . '</div>');
                                }

                                if ($invoiceConfirmAddressData->getEmail() != "") {
                                    echo ('<div>E-Mail: ' . $invoiceConfirmAddressData->getEmail() . '</div>');
                                }
                                ?>
                                <button type="submit" name="backwardToCreateEditInvoiceAddressViewSubmitButton">Bearbeiten</button>
                            </div>
                        </td>
                        <td>
                            <div>
                                <div>Lieferadresse</div>
                                <?php
                                $deliveryConfirmAddressData = $confirmOrderData->getDeliveryConfirmAddressData();

                                echo ('<div>' . ($deliveryConfirmAddressData->getSalutation() != "---" ? $deliveryConfirmAddressData->getSalutation() . ' ' : '')
                                    . ($deliveryConfirmAddressData->getTitleBeforeName() != "" ? $deliveryConfirmAddressData->getTitleBeforeName() . ' ' : '')
                                    . ($deliveryConfirmAddressData->getFirstName() != "" ? $deliveryConfirmAddressData->getFirstName() . ' ' : '')
                                    . ($deliveryConfirmAddressData->getLastName() != "" ? $deliveryConfirmAddressData->getLastName() . ', ' : '')
                                    . ($deliveryConfirmAddressData->getTitleAfterName() != "" ? $deliveryConfirmAddressData->getTitleAfterName() : '')
                                    . '</div>');

                                if ($deliveryConfirmAddressData->getAddressLine1() != "") {
                                    echo ('<div>' . $deliveryConfirmAddressData->getAddressLine1() . '</div>');
                                }

                                if ($deliveryConfirmAddressData->getAddressLine2() != "") {
                                    echo ('<div>' . $deliveryConfirmAddressData->getAddressLine2() . '</div>');
                                }

                                echo ('<div>' . ($deliveryConfirmAddressData->getPostalCode() != "---" ? $deliveryConfirmAddressData->getPostalCode() . ' ' : '')
                                    . ($deliveryConfirmAddressData->getLocation() != "" ? $deliveryConfirmAddressData->getLocation() : '')
                                    . '</div>');

                                if ($deliveryConfirmAddressData->getCountry() != "") {
                                    echo ('<div>' . $deliveryConfirmAddressData->getCountry() . '</div>');
                                }

                                if ($deliveryConfirmAddressData->getPhoneNumber() != "") {
                                    echo ('<div>Telefon: ' . $deliveryConfirmAddressData->getPhoneNumber() . '</div>');
                                }

                                if ($deliveryConfirmAddressData->getEmail() != "") {
                                    echo ('<div>E-Mail: ' . $deliveryConfirmAddressData->getEmail() . '</div>');
                                }
                                ?>
                                <button type="submit" name="backwardToCreateEditDeliveryAddressViewSubmitButton">Bearbeiten</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Zahlungsart</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div>
                                <?php
                                if ($confirmOrderData->getPaymentOptionData() != "") {
                                    echo ('<div>' . $confirmOrderData->getPaymentOptionData() . '</div>');
                                }
                                ?>
                                <button type="submit" name="backwardToCreatePaymentSettingsViewSubmitButton">Bearbeiten</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Warenkorb</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php
                            if ($confirmOrderData->getConfirmOrderEntrysData() != null && count($confirmOrderData->getConfirmOrderEntrysData()) > 0) {
                            ?>
                                <table class="tableAll" cellspacing="0" cellpadding="0">
                                    <thead>
                                        <th class="tableHeadline">Bild</th>
                                        <th class="tableHeadline">Name</th>
                                        <th class="tableHeadline">Beschreibung</th>
                                        <th class="tableHeadline">Einzelpreis</th>
                                        <th class="tableHeadline">Anzahl</th>
                                        <th class="tableHeadline">Gesamtpreis</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($confirmOrderData->getConfirmOrderEntrysData() as $confirmOrderEntryData) {
                                            echo '<tr>';
                                            echo '<td class="tableCell"><img src="../../product/image/' . $confirmOrderEntryData->getProduct()->getImage1() . '" class="productImage1" alt="' . $confirmOrderEntryData->getProduct()->getImage1() . '"></td>';
                                            echo '<td class="tableCell">' . $confirmOrderEntryData->getProduct()->getName() . '</td>';
                                            echo '<td class="tableCell">' . $confirmOrderEntryData->getProduct()->getDescription() . '</td>';
                                            echo '<td class="tableCell">' . $confirmOrderEntryData->getPurchasePrice() . '</td>';
                                            echo '<td class="tableCell">' . $confirmOrderEntryData->getProductCount() . '</td>';
                                            echo '<td class="tableCell">' . (float)$confirmOrderEntryData->getPurchasePrice() * (float)$confirmOrderEntryData->getProductCount() . '</td>';
                                            echo '</tr>';
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
                            <?php
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><button type="submit" name="backwardToCreatePaymentSettingsViewSubmitButton">Zurück</button></td>
                        <td><button type="submit" name="registerConfirmDataSubmitButton">Kostenpflichtig bestellen</button></td>
                    </tr>
                </tbody>
            </table>
        </form>
    </main>
</body>

</html>