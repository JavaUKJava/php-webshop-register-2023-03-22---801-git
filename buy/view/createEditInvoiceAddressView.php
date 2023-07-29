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
$salutations;
$countries;
$defaultValuesCreateAddressData;

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

if (isset($_SESSION['salutations'])) {
    $salutations = $_SESSION['salutations'];
    unset($_SESSION['salutations']);
}

if (isset($_SESSION['countries'])) {
    $countries = $_SESSION['countries'];
    unset($_SESSION['countries']);
}

if (isset($_SESSION['createAddressData'])) {
    $defaultValuesCreateAddressData = $_SESSION['createAddressData'];
    unset($_SESSION['createAddressData']);
}

if (isset($errorMessage)) {
    if ($errorMessage == "emptyField") {
        $errorMessage = "Bitte alle mit * gekennzeichneten Felder ausfüllen!";
    } elseif ($errorMessage == "invalidEmail") {
        $errorMessage = "E-Mail nicht verwendbar!";
    }
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
    <title>php-webshop - buy/view/createEditInvoiceAddressView.php</title>
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
                        <th colspan="2">Rechnungsadresse</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Id:</td>
                        <td><input type="text" name="id" value="<?php echo isset($defaultValuesCreateAddressData) ? $defaultValuesCreateAddressData->getId() : ''; ?>"></td>
                    </tr>
                    <tr>
                        <td>Anrede:</td>
                        <td>
                            <select name="salutationId" id="">
                                <?php
                                foreach ($salutations as $salutation) {
                                    if (isset($defaultValuesCreateAddressData) && $salutation->getId() == $defaultValuesCreateAddressData->getSalutationId()) {
                                        echo '<option value="' . $salutation->getId() . '" selected>' . $salutation->getName() . '</option>';
                                    } else {
                                        echo '<option value="' . $salutation->getId() . '">' . $salutation->getName() . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Titel (vor Name):</td>
                        <td><input type="text" name="titleBeforeName" value="<?php echo isset($defaultValuesCreateAddressData) ? $defaultValuesCreateAddressData->getTitleBeforeName() : ''; ?>"></td>
                    </tr>
                    <tr>
                        <td>* Vorname:</td>
                        <td><input type="text" name="firstName" value="<?php echo isset($defaultValuesCreateAddressData) ? $defaultValuesCreateAddressData->getFirstName() : ''; ?>"></td>
                    </tr>
                    <tr>
                        <td>* Nachname:</td>
                        <td><input type="text" name="lastName" value="<?php echo isset($defaultValuesCreateAddressData) ? $defaultValuesCreateAddressData->getLastName() : ''; ?>"></td>
                    </tr>
                    <tr>
                        <td>Titel (nach Name):</td>
                        <td><input type="text" name="titleAfterName" value="<?php echo isset($defaultValuesCreateAddressData) ? $defaultValuesCreateAddressData->getTitleAfterName() : ''; ?>"></td>
                    </tr>
                    <tr>
                        <td>* Telefon:</td>
                        <td><input type="text" name="phoneNumber" value="<?php echo isset($defaultValuesCreateAddressData) ? $defaultValuesCreateAddressData->getPhoneNumber() : ''; ?>"></td>
                    </tr>
                    <tr>
                        <td>* E-Mail:</td>
                        <td><input type="text" name="email" value="<?php echo isset($defaultValuesCreateAddressData) ? $defaultValuesCreateAddressData->getEmail() : ''; ?>"></td>
                    </tr>
                    <tr>
                        <td>* Land:</td>
                        <td>
                            <select name="countryId">
                                <?php
                                foreach ($countries as $country) {
                                    if (isset($defaultValuesCreateAddressData) && $defaultValuesCreateAddressData->getCountryId() != null && $country->getId() == $defaultValuesCreateAddressData->getCountryId()) {
                                        echo '<option value="' . $country->getId() . '" selected>' . $country->getName() . '</option>';
                                    } else {
                                        echo '<option value="' . $country->getId() . '">' . $country->getName() . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>* Postleitzahl:</td>
                        <td><input type="text" name="postalCode" value="<?php echo isset($defaultValuesCreateAddressData) ? $defaultValuesCreateAddressData->getPostalCode() : ''; ?>"></td>
                    </tr>
                    <tr>
                        <td>* Ort:</td>
                        <td><input type="text" name="location" value="<?php echo isset($defaultValuesCreateAddressData) ? $defaultValuesCreateAddressData->getLocation() : ''; ?>"></td>
                    </tr>
                    <tr>
                        <td>* Adress-Zeile 1:</td>
                        <td><input type="text" name="addressLine1" value="<?php echo isset($defaultValuesCreateAddressData) ? $defaultValuesCreateAddressData->getAddressLine1() : ''; ?>"></td>
                    </tr>
                    <tr>
                        <td>Adress-Zeile 2:</td>
                        <td><input type="text" name="addressLine2" value="<?php echo isset($defaultValuesCreateAddressData) ? $defaultValuesCreateAddressData->getAddressLine2() : ''; ?>"></td>
                    </tr>
                    <tr>
                        <td>* Steuernummer:</td>
                        <td><input type="text" name="vatId" value="<?php echo isset($defaultValuesCreateAddressData) ? $defaultValuesCreateAddressData->getVatId() : ''; ?>"></td>
                    </tr>
                    <tr>
                        <td><a class="mainMenuItem" href="<?php echo '../../cart/controller/cartController.php?showAllCartEntrysByUserIdViewSubmitButton&id=' . $loggedInUser->getId(); ?>">Zurück</a></td>
                        <td><button type="submit" name="registerInvoiceAddressSubmitButton">Weiter</button></td>
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