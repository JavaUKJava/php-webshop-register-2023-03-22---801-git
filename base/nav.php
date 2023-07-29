<nav class="horizontalMenu">
    <div class="mainMenuLeftArea">
        <?php
        if (!str_ends_with($_SERVER['REQUEST_URI'], "index.php")) {     // only index.php should not show home button
            echo '<a class="mainMenuItem" href="index.php">Home</a>';
        }
        ?>
    </div>
    <div class="mainMenuRightArea">
        <?php
        if (isset($_SESSION['loggedInUserData'])) {
            if ($userService->isRoleByUserId($_SESSION['loggedInUserData']->getId(), 'NOT_REGISTERED_USER')) {
                if ($userService->isPermissionByUserId($_SESSION['loggedInUserData']->getId(), 'PRODUCT_SHOW')) {
                    echo '<a href="cart/controller/cartController.php?showAllCartEntrysByUserIdViewSubmitButton&id=' . $_SESSION['loggedInUserData']->getId() . '" class="mainMenuItem">Warenkorb (' . $_SESSION['loggedInUserData']->getCartEntrysCount() . ')</a>';
                    echo '<a href="product/controller/productController.php?showAllProductsViewSubmitButton" class="mainMenuItem">Alle Produkte anzeigen</a>';
                }

                echo '<a href="user/controller/userController.php?showRegisterUserViewSubmitButton" class="mainMenuItem">Registrieren</a>';
                echo '<a href="user/controller/userController.php?showLoginUserViewSubmitButton" class="mainMenuItem">Anmelden</a>';
            } else {
                if ($userService->isRoleByUserId($_SESSION['loggedInUserData']->getId(), 'ADMIN')) {
                    // Button for Admin
                    echo '<a href="cart/controller/cartController.php?showAllCartEntrysViewSubmitButton" class="mainMenuItem">Warenkorb gesamt anzeigen</a>';
                    echo '<a href="product/controller/productController.php?showAllProductsViewSubmitButton" class="mainMenuItem">Alle Produkte anzeigen</a>';
                    echo '<a href="order/controller/orderController.php?showAllOrdersViewSubmitButton" class="mainMenuItem">Alle Bestellungen anzeigen</a>';
                    echo '<a href="user/controller/userController.php?showAllUsersViewSubmitButton" class="mainMenuItem">Alle Benutzer anzeigen</a>';
                } else if ($userService->isPermissionByUserId($_SESSION['loggedInUserData']->getId(), 'PRODUCT_SHOW')) {
                    // Button for normaly users
                    echo '<a href="cart/controller/cartController.php?showAllCartEntrysByUserIdViewSubmitButton&id=' . $_SESSION['loggedInUserData']->getId() . '" class="mainMenuItem">Warenkorb (' . $_SESSION['loggedInUserData']->getCartEntrysCount() . ')</a>';
                    echo '<a href="product/controller/productController.php?showAllProductsViewSubmitButton" class="mainMenuItem">Alle Produkte anzeigen</a>';

                    if ($userService->isPermissionByUserId($_SESSION['loggedInUserData']->getId(), 'USER_EDIT_OWN')) {
                        // Button for edit own user account
                        echo '<a href="user/controller/userController.php?showEditOwnUserViewSubmitButton" class="mainMenuItem">Bearbeiten</a>';
                    }
                }

                echo '<a href="user/controller/userController.php?logoutUserSubmitButton" class="mainMenuItem">Abmelden</a>';
            }
        }
        ?>
    </div>
</nav>