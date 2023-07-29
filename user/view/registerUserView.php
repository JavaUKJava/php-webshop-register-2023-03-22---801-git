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
$defaultValuesUserData;
$salutations = $_SESSION['salutations'];
unset($_SESSION['salutations']);

if (isset($_SESSION['errorMessage'])) {
    $errorMessage = $_SESSION['errorMessage'];
    unset($_SESSION['errorMessage']);
}

if (isset($_SESSION['createUserData'])) {
    $defaultValuesUserData = $_SESSION['createUserData'];
    unset($_SESSION['createUserData']);
}

if (isset($errorMessage)) {
    if ($errorMessage == "emptyField") {
        $errorMessage = "Bitte alle mit * gekennzeichneten Felder ausfüllen!";
    } elseif ($errorMessage == "invalidLoginName") {
        $errorMessage = "Benutzername nicht verwendbar!";
    } elseif ($errorMessage == "invalidEmail") {
        $errorMessage = "E-Mail nicht verwendbar!";
    } elseif ($errorMessage == "invalidPassword") {
        $errorMessage = "Passwort nicht verwendbar!";
    } elseif ($errorMessage == "invalidPasswordCheck") {
        $errorMessage = "Passwörter unterschiedlich!";
    } elseif ($errorMessage == "sqlerror") {
        $errorMessage = "Fehler bei Datenbankabfrage!";
    } elseif ($errorMessage == "loginNameExist") {
        $errorMessage = "Benutzer mit diesem Namen bereits vorhanden!";
    } elseif ($errorMessage == "emailExist") {
        $errorMessage = "Benutzer mit dieser E-Mail bereits vorhanden!";
    }
} elseif (isset($_GET['info'])) {
    if ($_GET['info'] == "registerSuccess") {
        $infoMessage = "Registrierung erfolgreich!";
    }
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
    <title>php-webshop - userAdministration/view/registerUserView.php</title>
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
        <form action="../controller/userController.php" method="post">
            <table class="tableForInput">
                <thead>
                    <tr>
                        <th colspan="2">Benutzer registrieren</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>* Benutzername:</td>
                        <td><input type="text" name="loginName" value="<?php echo isset($defaultValuesUserData) ? $defaultValuesUserData->getLoginName() : ''; ?>"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <div class="tableInfoText">Min. 3 Zeichen (erlaubt ist Großbuchstabe, Kleinbuchstabe, Ziffer)</div>
                        </td>
                    </tr>
                    <tr>
                        <td>Anrede:</td>
                        <td>
                            <select name="salutationId" id="">
                                <?php
                                foreach ($salutations as $salutation) {
                                    if (isset($defaultValuesUserData) && $salutation->getId() == $defaultValuesUserData->getSalutationID()) {
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
                        <td><input type="text" name="titleBeforeName" value="<?php echo isset($defaultValuesUserData) ? $defaultValuesUserData->getTitleBeforeName() : ''; ?>"></td>
                    </tr>
                    <tr>
                        <td>* Vorname:</td>
                        <td><input type="text" name="firstName" value="<?php echo isset($defaultValuesUserData) ? $defaultValuesUserData->getFirstName() : ''; ?>"></td>
                    </tr>
                    <tr>
                        <td>* Nachname:</td>
                        <td><input type="text" name="lastName" value="<?php echo isset($defaultValuesUserData) ? $defaultValuesUserData->getLastName() : ''; ?>"></td>
                    </tr>
                    <tr>
                        <td>Titel (nach Name):</td>
                        <td><input type="text" name="titleAfterName" value="<?php echo isset($defaultValuesUserData) ? $defaultValuesUserData->getTitleAfterName() : ''; ?>"></td>
                    </tr>
                    <tr>
                        <td>Telefon:</td>
                        <td><input type="text" name="phoneNumber" value="<?php echo isset($defaultValuesUserData) ? $defaultValuesUserData->getPhoneNumber() : ''; ?>"></td>
                    </tr>
                    <tr>
                        <td>* E-Mail:</td>
                        <td><input type="text" name="email" value="<?php echo isset($defaultValuesUserData) ? $defaultValuesUserData->getEmail() : ''; ?>"></td>
                    </tr>
                    <tr>
                        <td>* Passwort:</td>
                        <td><input type="password" name="password"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <div class="tableInfoText">Min. 8 Zeichen (erlaubt ist Großbuchstabe, Kleinbuchstabe, Ziffer, !§%, aber NICHT äöüÄÖÜß)</div>
                        </td>
                    </tr>
                    <tr>
                        <td>* Passwort wiederholen:</td>
                        <td><input type="password" name="passwordRepeat"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><button type="submit" name="registerUserSubmitButton">Registrieren</button></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><button type="reset">Zurücksetzen</button></td>
                    </tr>
                </tbody>
            </table>
        </form>
        <div class="infoLoginRegisterText">Bereits registriert? <a href="../controller/userController.php?showLoginUserViewSubmitButton" class="infoLoginRegisterLink">Anmeldung</a></div>
    </main>
</body>

</html>