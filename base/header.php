<?php

if (!session_status() == PHP_SESSION_ACTIVE) {
    session_start();
}

?>
<header>
    <div class="loginMessage">
        <?php
        if (isset($_SESSION['loggedInUserData'])) {
            $loggedInUserData = $_SESSION['loggedInUserData'];
            $roles = $loggedInUserData->getRoles();
            $loginNameHeader = "";

            foreach ($roles as $role) {
                if ($role->getName() == 'NOT_REGISTERED_USER') {
                    $loginNameHeader = $loginNameHeader . "Gast - ";
                    break;
                }
            }

            $loginNameHeader = $loginNameHeader . $loggedInUserData->getLoginName();

            echo '<div>Angemeldet ist: ' . $loginNameHeader . ' (zuletzt am: ' . date('d/m/y H:i:s', $loggedInUserData->getLastLoginTime()) . ')</div>';
        } else {
            echo '<div>Angemeldet ist: ---</div>';
        }
        ?>
    </div>
</header>