<?php

$rootPath = __DIR__;
$rootPath = str_replace('product' . DIRECTORY_SEPARATOR . 'view', '', $rootPath);
require_once $rootPath . 'base/importRequireFileList.php';
importRequireFileList(__FILE__ . '/');

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$errorMessage;
$infoMessage;
$productDatas;

$userService = new UserService();

$loggedInUser = $userService->getUserById($_SESSION['loggedInUserData']->getId());

if (isset($_GET['error'])) {
    if ($_GET['error'] == "noProductAvailable") {
        $errorMessage = "Keine Produkte eingetragen!";
    } elseif ($_GET['error'] == "noSessionAvailable") {
        $errorMessage = "Keine Session vorhanden!";
    } elseif ($_GET['error'] == "deleteProductNotFound") {
        $errorMessage = "Produkt konnte nicht gelöscht werden, nicht gefunden!";
    } elseif ($_GET['error'] == "notAllowed") {
        $errorMessage = "Aktion für aktuellen Benutzer nicht erlaubt!";
    } elseif ($_GET['error'] == "productCountToHight") {
        $errorMessage = "Gewünschte Stückzahl nicht vorhanden!";
    }
} else if (isset($_GET['info'])) {
    if ($_GET['info'] == "deleteSuccess") {
        $infoMessage = "Produkt erfolgreich gelöscht!";
    } elseif ($_GET['info'] == "addedSuccess") {
        $infoMessage = "Produkt erfolgreich dem Warenkorb hinzugefügt!";
    }
}

if (isset($_SESSION['productDatas'])) {
    $productDatas = $_SESSION['productDatas'];
    unset($_SESSION['productDatas']);
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../base/base.css">
    <link rel="stylesheet" type="text/css" href="../css/product.css">
    <title>php-webshop - product/view/showAllProductsView.php</title>
</head>

<body>
    <?php
    require("../../base/header.php");
    ?>
    <nav>
        <a class="mainMenuItem" href="../../index.php">Home</a>

        <?php
        if ($loggedInUser->isPermission('PRODUCT_CREATE')) {
            echo '<a href="../controller/productController.php?showCreateProductViewSubmitButton" class="mainMenuItem">Neues Produkt</a>';
        }

        $searchData = "";

        if (isset($_SESSION['searchData'])) {
            $searchData = $_SESSION['searchData'];
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
        <?php
        $isAllowedPermission = $loggedInUser->isPermission('PRODUCT_CREATE|PRODUCT_EDIT|PRODUCT_DELETE');
        $isAllowedRole = $loggedInUser->isRole('ADMIN');

        $productSearchData = null;

        if (isset($_SESSION['productSearchData'])) {
            $productSearchData = $_SESSION['productSearchData'];
        } else {
            $productSearchData = new ProductSearchData();   // empty object with empty strings for all searchData
        }

        $productSortOrderData = null;

        if (isset($_SESSION['productSortOrderData'])) {
            $productSortOrderData = $_SESSION['productSortOrderData'];
        } else {
            $productSortOrderData = new productSortOrderData();   // empty object with false setting for all sortData
            $productSortOrderData->setIdUp(true);            // for standard the sort order is up bei Id
        }
        ?>
        <table class="tableAll" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <?php if ($isAllowedPermission) { ?>
                        <th class="tableHeadline" colspan="13">Alle Produkte</th>
                    <?php } else { ?>
                        <th class="tableHeadline" colspan="7">Alle Produkte</th>
                    <?php } ?>
                </tr>
                <!-- begin: input for search and sort in one form -->
                <form action="../controller/productController.php" method="post">
                    <!-- begin: input for search -->
                    <tr>
                        <th><input type="search" class="tableCellInputSearch" name="searchId" placeholder="Id" value="<?php echo $productSearchData->getId(); ?>"></th>
                        <th></th>
                        <th><input type="search" class="tableCellInputSearch" name="searchIdentifier" placeholder="Kennung" value="<?php echo $productSearchData->getIdentifier(); ?>"></th>
                        <th><input type="search" class="tableCellInputSearch" name="searchName" placeholder="Name" value="<?php echo $productSearchData->getName(); ?>"></th>
                        <th><input type="search" class="tableCellInputSearch" name="searchDescription" placeholder="Beschreibung" value="<?php echo $productSearchData->getDescription(); ?>"></th>
                        <?php if ($isAllowedPermission) { ?>
                            <th><input type="search" class="tableCellInputSearch" name="searchKeywords" placeholder="Stichwort" value="<?php echo $productSearchData->getKeywords(); ?>"></th>
                            <th><input type="search" class="tableCellInputSearch" name="searchStockCount" placeholder="Lagerbestand" value="<?php echo $productSearchData->getStockCount(); ?>"></th>
                            <th><input type="search" class="tableCellInputSearch" name="searchReservedCount" placeholder="Reserviert" value="<?php echo $productSearchData->getReservedCount(); ?>"></th>
                            <th><input type="search" class="tableCellInputSearch" name="searchAccessibleCount" placeholder="Verfügbar" value="<?php echo $productSearchData->getAccessibleCount(); ?>"></th>
                        <?php } ?>
                        <th><input type="search" class="tableCellInputSearch" name="searchRetailPrice" placeholder="Preis" value="<?php echo $productSearchData->getRetailPrice(); ?>"></th>
                        <?php if ($isAllowedPermission) { ?>
                            <th><input type="search" class="tableCellInputSearch" name="searchActive" placeholder="Aktiv" value="<?php echo $productSearchData->getActive(); ?>"></th>
                        <?php } ?>
                        <?php if (!$isAllowedRole && $isAllowedPermission) { ?>
                            <th></th>
                        <?php } ?>
                        <th><input type="submit" class="tableCellInputSearch tableSearchButton" name="showProductsBySearchDataViewSubmitButton" value="Suchen/Sortieren"></th> <!-- the same methode for search and sort where used -->
                    </tr>
                    <!-- ende: input for search -->
                    <!-- begin: input for sort -->
                    <tr>
                        <th><input type="radio" id="sortOrderIdUp" name="sortOrder" value="sortOrderIdUp" <?php if ($productSortOrderData->getIdUp()) {echo 'checked';} ?>><label for="sortOrderIdUp">&uarr;</label><br><input type="radio" id="sortOrderIdDown" name="sortOrder" value="sortOrderIdDown" <?php if ($productSortOrderData->getIdDown()) {echo 'checked';} ?>><label for="sortOrderIdDown">&darr;</label></th>
                        <th></th>
                        <th><input type="radio" id="sortOrderIdentifierUp" name="sortOrder" value="sortOrderIdentifierUp" <?php if ($productSortOrderData->getIdentifierUp()) {echo 'checked';} ?>><label for="sortOrderIdentifierUp">&uarr;</label><br><input type="radio" id="sortOrderIdentifierDown" name="sortOrder" value="sortOrderIdentifierDown" <?php if ($productSortOrderData->getIdentifierDown()) {echo 'checked';} ?>><label for="sortOrderIdentifierDown">&darr;</label></th>
                        <th><input type="radio" id="sortOrderNameUp" name="sortOrder" value="sortOrderNameUp" <?php if ($productSortOrderData->getNameUp()) {echo 'checked';} ?>><label for="sortOrderNameUp">&uarr;</label><br><input type="radio" id="sortOrderNameDown" name="sortOrder" value="sortOrderNameDown" <?php if ($productSortOrderData->getNameDown()) {echo 'checked';} ?>><label for="sortOrderNameDown">&darr;</label></th>
                        <th><input type="radio" id="sortOrderDescriptionUp" name="sortOrder" value="sortOrderDescriptionUp" <?php if ($productSortOrderData->getDescriptionUp()) {echo 'checked';} ?>><label for="sortOrderDescriptionUp">&uarr;</label><br><input type="radio" id="sortOrderDescriptionDown" name="sortOrder" value="sortOrderDescriptionDown" <?php if ($productSortOrderData->getDescriptionDown()) {echo 'checked';} ?>><label for="sortOrderDescriptionDown">&darr;</label></th>
                        <?php if ($isAllowedPermission) { ?>
                            <th><input type="radio" id="sortOrderKeywordsUp" name="sortOrder" value="sortOrderKeywordsUp" <?php if ($productSortOrderData->getKeywordsUp()) {echo 'checked';} ?>><label for="sortOrderKeywordsUp">&uarr;</label><br><input type="radio" id="sortOrderKeywordsDown" name="sortOrder" value="sortOrderKeywordsDown" <?php if ($productSortOrderData->getKeywordsDown()) {echo 'checked';} ?>><label for="sortOrderKeywordsDown">&darr;</label></th>
                            <th><input type="radio" id="sortOrderStockCountUp" name="sortOrder" value="sortOrderStockCountUp" <?php if ($productSortOrderData->getStockCountUp()) {echo 'checked';} ?>><label for="sortOrderStockCountUp">&uarr;</label><br><input type="radio" id="sortOrderStockCountDown" name="sortOrder" value="sortOrderStockCountDown" <?php if ($productSortOrderData->getStockCountDown()) {echo 'checked';} ?>><label for="sortOrderStockCountDown">&darr;</label></th>
                            <th></th>
                            <th></th>
                        <?php } ?>
                        <th><input type="radio" id="sortOrderRetailPriceUp" name="sortOrder" value="sortOrderRetailPriceUp" <?php if ($productSortOrderData->getRetailPriceUp()) {echo 'checked';} ?>><label for="sortOrderRetailPriceUp">&uarr;</label><br><input type="radio" id="sortOrderRetailPriceDown" name="sortOrder" value="sortOrderRetailPriceDown" <?php if ($productSortOrderData->getRetailPriceDown()) {echo 'checked';} ?>><label for="sortOrderRetailPriceDown">&darr;</label></th>
                        <?php if ($isAllowedPermission) { ?>
                            <th><input type="radio" id="sortOrderActiveUp" name="sortOrder" value="sortOrderActiveUp" <?php if ($productSortOrderData->getActiveUp()) {echo 'checked';} ?>><label for="sortOrderActiveUp">&uarr;</label><br><input type="radio" id="sortOrderActiveDown" name="sortOrder" value="sortOrderActiveDown" <?php if ($productSortOrderData->getActiveDown()) {echo 'checked';} ?>><label for="sortOrderActiveDown">&darr;</label></th>
                        <?php } ?>
                        <?php if (!$isAllowedRole && $isAllowedPermission) { ?>
                            <th></th>
                        <?php } ?>
                    </tr>
                    <!-- end: input for sort -->
                </form>
                <!-- end: input for search and sort in one form  -->
                <tr>
                    <!-- begin: headlines for colum -->
                    <th class="tableHeadline">Id</th>
                    <th class="tableHeadline">Bild</th>
                    <th class="tableHeadline">Kennung</th>
                    <th class="tableHeadline">Name</th>
                    <th class="tableHeadline">Beschreibung</th>
                    <?php if ($isAllowedPermission) { ?>
                        <th class="tableHeadline">Stichwort</th>
                        <th class="tableHeadline">Lagerbestand</th>
                        <th class="tableHeadline">Reserviert</th>
                        <th class="tableHeadline">Verfügbar</th>
                    <?php } ?>
                    <th class="tableHeadline">Preis</th>
                    <?php if ($isAllowedPermission) { ?>
                        <th class="tableHeadline">Aktiv</th>
                    <?php } ?>
                    <?php if (!$isAllowedRole) { ?>
                        <th class="tableHeadline">Kaufen</th>
                    <?php } ?>
                    <?php if ($isAllowedPermission) { ?>
                        <th class="tableHeadline">Aktion</th>
                    <?php } ?>
                    <!-- end: headlines for colum -->
                </tr>
            </thead>
            <tbody>
                <!-- begin: fields for colum -->
                <?php
                if (isset($productDatas) && count($productDatas) > 0) { // begin if productDatas are available -->

                    foreach ($productDatas as $productData) {   // begin foreach productData
                        $activeString = "";

                        if ($productData->getActive() == 1) {
                            $activeString = "Ja";
                        } else {
                            $activeString = "Nein";
                        }
                ?>
                        <tr>
                            <td class="tableCell"><?php echo $productData->getId(); ?></td>
                            <td class="tableCell"><img src="../image/<?php echo $productData->getImage1(); ?>" class="productImage1" alt="<?php echo $productData->getImage1(); ?>"></td>
                            <td class="tableCell"><?php echo $productData->getIdentifier(); ?></td>
                            <td class="tableCell"><?php echo $productData->getName(); ?></td>
                            <td class="tableCell"><?php echo $productData->getDescription(); ?></td>
                            <?php if ($isAllowedPermission) { ?>
                                <td class="tableCell"><?php echo $productData->getKeywords(); ?></td>
                                <td class="tableCell"><?php echo $productData->getStockCount(); ?></td>
                                <td class="tableCell"><?php echo $productData->getReservedCount(); ?></td>
                                <td class="tableCell"><?php echo $productData->getStockCount() - $productData->getReservedCount(); ?></td>
                            <?php } ?>
                            <td class="tableCell"><?php echo $productData->getRetailPrice(); ?></td>
                            <?php if ($isAllowedPermission) { ?>
                                <td class="tableCell"><?php echo $activeString; ?></td>
                            <?php } ?>
                            <?php if (!$isAllowedRole) { ?>
                                <td class="tableCell noWrapArea">
                                    <form action="../../cart/controller/cartController.php" method="get">
                                        <input type="text" name="productId" value="<?php echo $productData->getId(); ?>" hidden>
                                        <label for="productCount">Stk.</label>
                                        <input type="number" min="1" max="500" value="1" name="productCount" id="productCount">
                                        <button type="submit" name="addProductToCartSubmitButton">In Warenkorb</button>
                                    </form>
                                </td>
                            <?php } ?>
                            <?php if ($isAllowedPermission) { ?>
                                <td class="tableCell noWrapArea">
                                    <a href="../controller/productController.php?showEditProductViewSubmitButton&id=<?php echo $productData->getId(); ?>" class="tableEditButton">Bearbeiten</a>
                                    <a href="../controller/productController.php?deleteProductSubmitButton&id=<?php echo $productData->getId(); ?>" class="tableDeleteButton">Entfernen</a>
                                </td>
                            <?php } ?>
                        </tr>
                        <!-- end: fields for colum -->
                <?php
                    }   // end foreach productData
                } ?> <!-- end if productDatas are available -->
            </tbody>
        </table>
        <?php if (!isset($productDatas) || count($productDatas) <= 0) { ?>
            <div class="noEntrysAccessible">Keine Einträge vorhanden.</div>
        <?php } ?>
    </main>
</body>

</html>