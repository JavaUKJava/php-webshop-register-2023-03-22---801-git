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
$product;

$userService = new UserService();

$loggedInUser = $userService->getUserById($_SESSION['loggedInUserData']->getId());

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
    if ($_GET['info'] == "addedSuccess") {
        $infoMessage = "User erfolgreich erstellt!";
    }
}

$id = null;
$loginName = '';
$active = '';
$userRoles = '';
$userRolesNameArray = array();

if (isset($_SESSION['user']) && isset($_SESSION['roles'])) {
    $user = $_SESSION['user'];

    $id = $user->getId();
    $loginName = $user->getLoginName();
    $active = $user->getActive();
    $userRoles = $user->getRoles();

    foreach ($userRoles as $userRole) {
        array_push($userRolesNameArray, $userRole->getName());
    }

    unset($_SESSION['user']);

    $roles = $_SESSION['roles'];
    unset($_SESSION['roles']);
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
    <title>php-webshop - user/view/createEditUserView.php</title>
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
            <table>
                <thead>
                    <tr>
                        <?php
                        if (isset($user)) {
                            echo "<th class='tableHeadline' colspan='2'>Benutzer bearbeiten</th>";
                        } else {
                            echo "<th class='tableHeadline' colspan='2'>Neuen Benutzer erstellen</th>";
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <tr hidden>
                        <td>Id</td>
                        <td><input type="text" name="id" value="<?php echo $id ?>"></td>
                    </tr>
                    <tr>
                        <td>Benutzername</td>
                        <td><input type="text" name="loginName" value="<?php echo $loginName ?>"></td>
                    </tr>
                    <?php
                    if ($id == null) {
                        echo '
                        <tr>
                            <td>Passwort</td>
                            <td><input type="password" name="newPassword"></td>
                        </tr>
                        <tr>
                            <td>Passwort wiederholen</td>
                            <td><input type="password" name="newPasswordRepeat"></td>
                        </tr>';
                    } else {
                        echo '
                        <tr>
                            <td>Altes Passwort</td>
                            <td><input type="password" name="oldPassword"></td>
                        </tr>
                        <tr>
                            <td>Neues Passwort</td>
                            <td><input type="password" name="newPassword"></td>
                        </tr>
                        <tr>
                            <td>Neues Passwort wiederholen</td>
                            <td><input type="password" name="newPasswordRepeat"></td>
                        </tr>';
                    }
                    ?>
                    <tr>
                        <td>Rollen</td>
                        <td>
                            <select name="newRoles[]" multiple>
                                <?php
                                foreach ($roles as $role) {
                                    if ($role->getName() == "NOT_REGISTERED_USER") {
                                        continue;
                                    }

                                    if (in_array($role->getName(), $userRolesNameArray)) {
                                        echo '<option value="' . $role->getName() . '" selected>' . $role->getName() . '</option>';
                                    } else {
                                        echo '<option value="' . $role->getName() . '">' . $role->getName() . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Aktiv</td>
                        <?php
                        if ($active == 1) {
                            echo '<td><input type="checkbox" name="active" checked></td>';
                        } else {
                            echo '<td><input type="checkbox" name="active"></td>';
                        }
                        ?>
                    </tr>
                    <tr>
                        <td></td>
                        <td><button type="submit" name="createUserSubmitButton">OK</button></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><button type="reset">Zurücksetzen</button></td>
                    </tr>
                </tbody>
            </table>
        </form>
    </main>
</body>

</html>