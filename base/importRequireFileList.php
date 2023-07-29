<?php

function importRequireFileList($pathWithFilename)
{
    // var_dump($pathWithFilename);
    // echo '<br>';

    $documentRoot = $_SERVER['DOCUMENT_ROOT'];
    // var_dump($documentRoot);
    // echo '<br>';

    $path = "";
    $path = str_replace($documentRoot . DIRECTORY_SEPARATOR, "", $pathWithFilename);
    // var_dump($path);
    // echo '<br>';

    $firstBackslashIndex = strpos($path, DIRECTORY_SEPARATOR);
    $path = substr($path, 0, $firstBackslashIndex + 1);
    $path = str_replace(DIRECTORY_SEPARATOR, "", $path);
    // var_dump($path);
    // echo '<br>';

    $path = DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR;
    // var_dump($path);
    // echo '<br>';

    $path = $_SERVER['DOCUMENT_ROOT'] . $path;
    // var_dump($path);
    // echo '<br>';

    // die();

    require_once $path . 'database/databaseServiceClass.php';

    require_once $path . 'order/controller/orderController.php';
    require_once $path . 'order/model/orderClass.php';
    require_once $path . 'order/model/orderEntryClass.php';
    require_once $path . 'order/model/orderStatusClass.php';
    require_once $path . 'order/model/deliveryOptionClass.php';
    require_once $path . 'order/model/paymentOptionClass.php';
    require_once $path . 'order/data/confirmOrderDataClass.php';
    require_once $path . 'order/data/confirmOrderEntryDataClass.php';
    require_once $path . 'order/data/overviewOrderDataClass.php';
    require_once $path . 'order/service/orderService.php';

    require_once $path . 'buy/controller/buyController.php';
    require_once $path . 'buy/service/buyService.php';
    require_once $path . 'buy/model/invoiceClass.php';

    require_once $path . 'cart/controller/cartController.php';
    require_once $path . 'cart/model/cartEntryClass.php';
    require_once $path . 'cart/service/cartServiceClass.php';

    require_once $path . 'product/controller/productController.php';
    require_once $path . 'product/model/productClass.php';
    require_once $path . 'product/data/productDataClass.php';
    require_once $path . 'product/data/productSearchDataClass.php';
    require_once $path . 'product/data/productSortOrderDataClass.php';
    require_once $path . 'product/service/productServiceClass.php';

    require_once $path . 'user/controller/userController.php';
    require_once $path . 'user/data/loggedInUserDataClass.php';
    require_once $path . 'user/data/userDataClass.php';
    require_once $path . 'user/data/editOwnUserDataClass.php';
    require_once $path . 'user/data/createUserDataClass.php';
    require_once $path . 'user/data/createAddressDataClass.php';
    require_once $path . 'user/data/confirmAddressDataClass.php';
    require_once $path . 'user/model/permissionClass.php';
    require_once $path . 'user/model/roleClass.php';
    require_once $path . 'user/model/salutationClass.php';
    require_once $path . 'user/model/addressClass.php';
    require_once $path . 'user/model/userPersonalDataClass.php';
    require_once $path . 'user/model/userClass.php';
    require_once $path . 'user/model/countryClass.php';
    require_once $path . 'user/service/userServiceClass.php';
}
