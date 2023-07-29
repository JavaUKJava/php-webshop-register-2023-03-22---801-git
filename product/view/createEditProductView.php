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
$product;

$userService = new UserService();

$loggedInUser = $userService->getUserById($_SESSION['loggedInUserData']->getId());

if (isset($_GET['error'])) {
    if ($_GET['error'] == "faildToSave") {
        $infoMessage = "Produkt konnte NICHT erstellt werden!";
    }
} else if (isset($_GET['info'])) {
    if ($_GET['info'] == "addedSuccess") {
        $infoMessage = "Produkt erfolgreich erstellt!";
    }
}

$id = '---';
$identifier = '';
$name = '';
$description = '';
$keywords = '';
$stockCount = '';
$retailPrice = '';
$active = '';
$image1 = '';
$image2 = '';
$image3 = '';


if (isset($_SESSION['product'])) {
    $product = $_SESSION['product'];

    $id = $product->getId();
    $identifier = $product->getIdentifier();
    $name = $product->getName();
    $description = $product->getDescription();
    $keywords = $product->getKeywords();
    $stockCount = $product->getStockCount();
    $retailPrice = $product->getRetailPrice();
    $active = $product->getActive();
    $image1 = $product->getImage1();
    $image2 = $product->getImage2();
    $image3 = $product->getImage3();

    unset($_SESSION['product']);
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
    <title>php-webshop - product/view/createEditProductView.php</title>
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
        <form action="../controller/productController.php" method="post" enctype="multipart/form-data">
            <table class="tableForInput">
                <thead>
                    <tr>
                        <?php
                        if (isset($product)) {
                            echo "<th class='tableHeadline' colspan='2'>Produkt bearbeiten</th>";
                        } else {
                            echo "<th class='tableHeadline' colspan='2'>Neues Produkt erstellen</th>";
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
                        <td>Bild 1:<input type="text" name="oldImage1" value="<?php echo $image1 ?>" hidden></td>
                        <td>
                            <div><span>
                            <input type="file" name="image1">
                            <img src="../image/<?php echo $image1 ?>" alt="" class="productImage1">
                            </span></div>
                        </td>
                    </tr>
                    <tr>
                        <td>Bild 2:<input type="text" name="oldImage2" value="<?php echo $image2 ?>" hidden></td>
                        <td>
                            <div><span>
                            <input type="file" name="image2">
                            <img src="../image/<?php echo $image2 ?>" alt="" class="productImage1">
                            </span></div>
                        </td>
                    </tr>
                    <tr>
                        <td>Bild 3:<input type="text" name="oldImage3" value="<?php echo $image3 ?>" hidden></td>
                        <td>
                            <div><span>
                            <input type="file" name="image3">
                            <img src="../image/<?php echo $image3 ?>" alt="" class="productImage1">
                            </span></div>
                        </td>
                    </tr>
                    <tr>
                        <td>Kennung:</td>
                        <td><input type="text" name="identifier" value="<?php echo $identifier ?>"></td>
                    </tr>
                    <tr>
                        <td>Name:</td>
                        <td><input type="text" name="name" value="<?php echo $name ?>"></td>
                    </tr>
                    <tr>
                        <td>Beschreibung:</td>
                        <td><input type="text" name="description" value="<?php echo $description ?>"></td>
                    </tr>
                    <tr>
                        <td>Stichwort:</td>
                        <td><input type="text" name="keywords" value="<?php echo $keywords ?>"></td>
                    </tr>
                    <tr>
                        <td>Lagerbestand:</td>
                        <td><input type="number" name="stockCount" step="1" min="0" value="<?php echo $stockCount ?>"></td>
                    </tr>
                    <tr>
                        <td>Preis:</td>
                        <td><input type="number" name="retailPrice" step="0.01" min="0" value="<?php echo $retailPrice ?>"></td>
                    </tr>
                    <tr>
                        <td>Aktiv:</td>
                        <?php
                        if ($active == 1) {
                            echo '<td><input type="checkbox" name="active" step="0.01" min="0" checked></td>';
                        } else {
                            echo '<td><input type="checkbox" name="active" step="0.01" min="0"></td>';
                        }
                        ?>
                    </tr>
                    <tr>
                        <td></td>
                        <td><button type="submit" name="createProductSubmitButton">Erstellen</button></td>
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