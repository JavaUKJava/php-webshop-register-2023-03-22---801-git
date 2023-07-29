<?php
$errorMessage;
$loginName;

if (isset($_GET['error'])) {
    if ($_GET['error'] == "emptyField") {
        $errorMessage = "Bitte alle Felder ausfüllen!";
        $loginName = $_GET['loginName'];
    } elseif ($_GET['error'] == "wrongLoginNameOrPassword") {
        $errorMessage = "Falscher Benutzername oder Passwort!";
    } elseif ($_GET['error'] == "anyUserIsStillLoggedIn") {
        $errorMessage = "Es ist ein Benutzer angemeldet - diesen zuerst abmelden!";
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
    <title>php-webshop - userAdministration/view/loginUserView.php</title>
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
    <main>
        <form action="../controller/userController.php" method="post">
        <table class="tableForInput">
                <thead>
                    <tr>
                        <th colspan="2">Benutzer anmelden</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Benutzername:</td>
                        <td><input type="text" name="loginName"></td>
                    </tr>
                    <tr>
                        <td>Passwort:</td>
                        <td><input type="password" name="password"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><button type="submit" name="loginUserSubmitButton">Anmelden</button></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><button type="reset">Reset</button></td>
                    </tr>
                </tbody>
            </table>
        </form>
        <div class="infoLoginRegisterText">Noch nicht registriert? <a href="../controller/userController.php?showRegisterUserViewSubmitButton" class="infoLoginRegisterLink">Registrierung</a></div>
    </main>
</body>

</html>