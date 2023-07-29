<?php

$rootPath = __DIR__;
$rootPath = str_replace('buy' . DIRECTORY_SEPARATOR . 'controller', '', $rootPath);
require_once $rootPath . 'base/importRequireFileList.php';
importRequireFileList(__FILE__ . '/');

if (isset($_GET)) {
    if (isset($_GET['createEditInvoiceAddressViewSubmitButton'])) {   // come from "showAllCartEntrysView.php (forward to form for invoice address)"
        createEditInvoiceAddressView();
    }
}

if (isset($_POST)) {
    if (isset($_POST['backwardToCreateEditInvoiceAddressViewSubmitButton'])) {
        backwardToCreateEditInvoiceAddressView();
    } else if (isset($_POST['registerInvoiceAddressSubmitButton'])) {
        registerInvoiceAddress();
    } else if (isset($_POST['backwardToCreateDeliverySettingsViewSubmitButton'])) {
        backwardToCreateDeliverySettingsView();
    } else if (isset($_POST['registerDeliverySettingsSubmitButton'])) {
        registerDeliverySettings();
    } else if (isset($_POST['backwardToCreateEditDeliveryAddressViewSubmitButton'])) {
        backwardToCreateEditDeliveryAddressView();
    } else if (isset($_POST['registerDeliveryAddressSubmitButton'])) {
        registerDeliveryAddress();
    } else if (isset($_POST['backwardToCreatePaymentSettingsViewSubmitButton'])) {
        backwardToCreatePaymentSettingsView();
    } else if (isset($_POST['registerPaymentSettingsSubmitButton'])) {
        registerPaymentSettings();
    } else if (isset($_POST['registerConfirmDataSubmitButton'])) {
        registerConfirmData();
    }
}

// -----------------------------------------------------------------------

function createEditInvoiceAddressView()
{
    $userService = new UserService();
    $orderService = new OrderService();

    // come from "showAllCartEntrysView"
    if (isset($_GET) && isset($_GET['createEditInvoiceAddressViewSubmitButton'])) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $loggedInUserId = $_SESSION['loggedInUserData']->getId();
        $loggedInUser = $userService->getUserById($loggedInUserId);

        if (!isset($loggedInUser) || !$loggedInUser->isPermission('PRODUCT_BUY')) {
            unset($_SESSION['cartEntrys']);
            header("Location: ../view/showAllCartEntrysView.php?error=notAllowed");
            exit();
        } else {
            // user must be logged in to checkout
            if ($loggedInUser->isRole('NOT_REGISTERED_USER')) {
                header("Location: ../../user/view/loginUserView.php?");
                exit();
            } else {
                // get the exist order from the user or create a new one
                // set order status "CREATE_BEGIN" by get a exist order from the user too
                $order = null;
                $orderStatus = $orderService->getOrderStatusByName("CREATE_BEGIN");

                if ($loggedInUser->getOrderInProgress() == null) {
                    $order = new Order(null, null, null, null, time(), $orderStatus, null, null, array());
                    $loggedInUser->setOrderInProgress($order);
                } else {
                    $order = $loggedInUser->getOrderInProgress();
                    $order->setStatus($orderStatus);
                }

                $userService->saveUser($loggedInUser);
                createEditInvoiceAddressViewDetail($loggedInUser);
            }
        }
    }
}

function backwardToCreateEditInvoiceAddressView()
{
    $userService = new UserService();
    $orderService = new OrderService();

    if (isset($_POST) && isset($_POST['backwardToCreateEditInvoiceAddressViewSubmitButton'])) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $loggedInUserId = $_SESSION['loggedInUserData']->getId();
        $loggedInUser = $userService->getUserById($loggedInUserId);

        if (!isset($loggedInUser) || !$loggedInUser->isPermission('PRODUCT_BUY')) {
            unset($_SESSION['cartEntrys']);
            header("Location: ../view/showAllCartEntrysView.php?error=notAllowed");
            exit();
        } else {
            $orderStatus = $orderService->getOrderStatusByName("CREATE_BEGIN");
            $order = $loggedInUser->getOrderInProgress();
            $order->setStatus($orderStatus);
            $userService->saveUser($loggedInUser);

            createEditInvoiceAddressViewDetail($loggedInUser);
        }
    }
}

function createEditInvoiceAddressViewDetail($loggedInUser)
{
    $userService = new UserService();
    $createAddressData = null;

    if ($loggedInUser->getOrderInProgress()->getInvoiceAddress() != null) {
        $invoiceAddress = $loggedInUser->getOrderInProgress()->getInvoiceAddress();

        $createAddressData = $userService->getCreateAddressDataFromAddress($invoiceAddress);
    } else {
        $createAddressData = new CreateAddressData(
            null,
            $loggedInUser->getSalutation()->getId(),
            $loggedInUser->getTitleBeforeName(),
            $loggedInUser->getFirstName(),
            $loggedInUser->getLastName(),
            $loggedInUser->getTitleAfterName(),
            $loggedInUser->getPhoneNumber(),
            $loggedInUser->getEmail(),
            null,
            "",
            "",
            "",
            "",
            ""
        );
    }

    $salutations = $userService->getSalutations();
    $_SESSION['salutations'] = $salutations;
    $countries = $userService->getCountries();
    $_SESSION['countries'] = $countries;
    $_SESSION['createAddressData'] = $createAddressData;

    header("Location: ../view/createEditInvoiceAddressView.php");
    exit();
}

function registerInvoiceAddress()
{
    $userService = new UserService();
    $orderService = new OrderService();

    if (isset($_POST) && isset($_POST['registerInvoiceAddressSubmitButton'])) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $loggedInUserId = $_SESSION['loggedInUserData']->getId();
        $loggedInUser = $userService->getUserById($loggedInUserId);

        if (!isset($loggedInUser) || !$loggedInUser->isPermission('PRODUCT_BUY')) {
            unset($_SESSION['cartEntrys']);
            header("Location: ../view/showAllCartEntrysView.php?error=notAllowed");
            exit();
        } else {
            // register Invoice address data
            $id = htmlspecialchars($_POST['id']);
            $salutationId = htmlspecialchars($_POST['salutationId']);
            $titleBeforeName = htmlspecialchars($_POST['titleBeforeName']);
            $firstName = htmlspecialchars($_POST['firstName']);
            $lastName = htmlspecialchars($_POST['lastName']);
            $titleAfterName = htmlspecialchars($_POST['titleAfterName']);
            $phoneNumber = htmlspecialchars($_POST['phoneNumber']);
            $email = htmlspecialchars($_POST['email']);
            $countryId = htmlspecialchars($_POST['countryId']);
            $postalCode = htmlspecialchars($_POST['postalCode']);
            $location = htmlspecialchars($_POST['location']);
            $addressLine1 = htmlspecialchars($_POST['addressLine1']);
            $addressLine2 = htmlspecialchars($_POST['addressLine2']);
            $vatId = htmlspecialchars($_POST['vatId']);

            // create transport data box
            $createAddressData = new CreateAddressData(
                $id,
                $salutationId,
                $titleBeforeName,
                $firstName,
                $lastName,
                $titleAfterName,
                $phoneNumber,
                $email,
                $countryId,
                $postalCode,
                $location,
                $addressLine1,
                $addressLine2,
                $vatId
            );

            $errorMessage = $userService->testInputsForCreateAddress($createAddressData);

            if ($errorMessage != null) {
                $salutations = $userService->getSalutations();
                $_SESSION['salutations'] = $salutations;
                $countries = $userService->getCountries();
                $_SESSION['countries'] = $countries;

                $_SESSION['errorMessage'] = $errorMessage;
                $_SESSION['createAddressData'] = $createAddressData;

                header("Location: ../view/createEditInvoiceAddressView.php");
                exit();
            } else {
                $salutation = $userService->getSalutationById($createAddressData->getSalutationId());
                $country = $userService->getCountryById($createAddressData->getCountryId());
                $invoiceAddress = new Address(
                    $createAddressData->getId(),
                    $salutation,
                    $createAddressData->getTitleBeforeName(),
                    $createAddressData->getFirstName(),
                    $createAddressData->getLastName(),
                    $createAddressData->getTitleAfterName(),
                    $createAddressData->getPhoneNumber(),
                    $createAddressData->getEmail(),
                    $country,
                    $createAddressData->getPostalCode(),
                    $createAddressData->getLocation(),
                    $createAddressData->getAddressLine1(),
                    $createAddressData->getAddressLine2(),
                    $createAddressData->getVatId()
                );

                $order = $loggedInUser->getOrderInProgress();
                $newOrderStatus = $orderService->getOrderStatusByName("CREATE_AFTER_REGISTER_INVOICE_ADDRESS");

                $order->setInvoiceAddress($invoiceAddress);
                $order->setStatus($newOrderStatus);
                $userService->saveUser($loggedInUser);

                $deliveryOptions = $orderService->getDeliveryOptions();
                $_SESSION['deliveryOptions'] = $deliveryOptions;

                $defaultValueDeliveryOption = $order->getDeliveryOption();

                if ($defaultValueDeliveryOption == null) {
                    $defaultValueDeliveryOption = $orderService->getDeliveryOptionById(1);
                }

                $_SESSION['defaultValueDeliveryOption'] = $defaultValueDeliveryOption;

                header("Location: ../view/createDeliverySettingsView.php");
                exit();
            }
        }
    }
}

// -----------------------------------------------------------------------

function createDeliverySettingsView()
{
    $userService = new UserService();

    // come to this method as a part of register invoice address from "createEditInvoiceAddressView"
    if (isset($_POST) && isset($_POST['registerInvoiceAddressSubmitButton'])) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $loggedInUserId = $_SESSION['loggedInUserData']->getId();
        $loggedInUser = $userService->getUserById($loggedInUserId);

        if (!isset($loggedInUser) || !$loggedInUser->isPermission('PRODUCT_BUY')) {
            unset($_SESSION['cartEntrys']);
            header("Location: ../view/showAllCartEntrysView.php?error=notAllowed");
            exit();
        } else {
            createDeliverySettingsViewDetail($loggedInUser);
        }
    }
}

function backwardToCreateDeliverySettingsView()
{
    $userService = new UserService();
    $orderService = new OrderService();

    if (isset($_POST) && isset($_POST['backwardToCreateDeliverySettingsViewSubmitButton'])) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $loggedInUserId = $_SESSION['loggedInUserData']->getId();
        $loggedInUser = $userService->getUserById($loggedInUserId);

        if (!isset($loggedInUser) || !$loggedInUser->isPermission('PRODUCT_BUY')) {
            unset($_SESSION['cartEntrys']);
            header("Location: ../view/showAllCartEntrysView.php?error=notAllowed");
            exit();
        } else {
            $newOrderStatus = $orderService->getOrderStatusByName("CREATE_AFTER_REGISTER_INVOICE_ADDRESS");
            $loggedInUser->getOrderInProgress()->setStatus($newOrderStatus);
            $userService->saveUser($loggedInUser);

            createDeliverySettingsViewDetail($loggedInUser);
        }
    }
}

function createDeliverySettingsViewDetail($loggedInUser)
{
    $orderService = new OrderService();

    $deliveryOptions = $orderService->getDeliveryOptions();
    $_SESSION['deliveryOptions'] = $deliveryOptions;

    $defaultValueDeliveryOption = null;

    if ($loggedInUser->getOrderInProgress() != null && $loggedInUser->getOrderInProgress()->getDeliveryOption() != null) {
        $defaultValueDeliveryOption = $loggedInUser->getOrderInProgress()->getDeliveryOption();
    } else {
        $defaultValueDeliveryOption = $orderService->getDeliveryOptionById(1);
    }

    $_SESSION['defaultValueDeliveryOption'] = $defaultValueDeliveryOption;

    header("Location: ../view/createDeliverySettingsView.php");
    exit();
}

function registerDeliverySettings()
{
    $userService = new UserService();
    $orderService = new OrderService();

    if (isset($_POST) && isset($_POST['registerDeliverySettingsSubmitButton'])) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $loggedInUserId = $_SESSION['loggedInUserData']->getId();
        $loggedInUser = $userService->getUserById($loggedInUserId);

        if (!isset($loggedInUser) || !$loggedInUser->isPermission('PRODUCT_BUY')) {
            unset($_SESSION['cartEntrys']);
            header("Location: ../view/showAllCartEntrysView.php?error=notAllowed");
            exit();
        } else {
            $deliveryOptionId = htmlspecialchars($_POST['deliveryOptionId']);

            $deliveryOption = $orderService->getDeliveryOptionById($deliveryOptionId);
            $order = $loggedInUser->getOrderInProgress();
            $order->setDeliveryOption($deliveryOption);

            $newOrderStatus = $orderService->getOrderStatusByName("CREATE_AFTER_REGISTER_DELIVERY_ADDRESS");
            $order->setStatus($newOrderStatus);

            switch ($deliveryOptionId) {
                case 1:                             // Lieferung an Rechnungsadresse
                    $invoiceAddress = $order->getInvoiceAddress();
                    $order->setDeliveryAddress($invoiceAddress);
                    $userService->saveUser($loggedInUser);

                    createPaymentSettingsView();

                    break;

                case 2:                             // Abweichende Lieferadresse
                    $userService->saveUser($loggedInUser);

                    createEditDeliveryAddressView();
                    break;

                default:
                    # code...
                    break;
            }
        }
    }
}

// -------------------------------------------------------------------

function createEditDeliveryAddressView()
{
    $userService = new UserService();

    // come to this method as a part of register delivery settings from "createDeliverySettingsView"
    if (isset($_POST) && isset($_POST['registerDeliverySettingsSubmitButton'])) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $loggedInUserId = $_SESSION['loggedInUserData']->getId();
        $loggedInUser = $userService->getUserById($loggedInUserId);

        if (!isset($loggedInUser) || !$loggedInUser->isPermission('PRODUCT_BUY')) {
            unset($_SESSION['cartEntrys']);
            header("Location: ../view/showAllCartEntrysView.php?error=notAllowed");
            exit();
        } else {
            createEditDeliveryAddressViewDetail($loggedInUser);
        }
    }
}

function backwardToCreateEditDeliveryAddressView()
{
    $userService = new UserService();
    $orderService = new OrderService();

    if (isset($_POST) && isset($_POST['backwardToCreateEditDeliveryAddressViewSubmitButton'])) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $loggedInUserId = $_SESSION['loggedInUserData']->getId();
        $loggedInUser = $userService->getUserById($loggedInUserId);

        if (!isset($loggedInUser) || !$loggedInUser->isPermission('PRODUCT_BUY')) {
            unset($_SESSION['cartEntrys']);
            header("Location: ../view/showAllCartEntrysView.php?error=notAllowed");
            exit();
        } else {
            $orderStatus = $orderService->getOrderStatusByName("CREATE_AFTER_REGISTER_DELIVERY_SETTINGS");
            $order = $loggedInUser->getOrderInProgress();
            $order->setStatus($orderStatus);
            $userService->saveUser($loggedInUser);

            createEditDeliveryAddressViewDetail($loggedInUser);
        }
    }
}

function createEditDeliveryAddressViewDetail($loggedInUser)
{
    $userService = new UserService();
    $createAddressData = null;

    if ($loggedInUser->getOrderInProgress() != null && $loggedInUser->getOrderInProgress()->getDeliveryAddress() != null) {
        if ($loggedInUser->getOrderInProgress()->getInvoiceAddress()->getId() != $loggedInUser->getOrderInProgress()->getDeliveryAddress()->getId()) {
            $deliveryAddress = $loggedInUser->getOrderInProgress()->getDeliveryAddress();
            $createAddressData = $userService->getCreateAddressDataFromAddress($deliveryAddress);
        }

        $_SESSION['createAddressData'] = $createAddressData;
    }

    $salutations = $userService->getSalutations();
    $_SESSION['salutations'] = $salutations;
    $countries = $userService->getCountries();
    $_SESSION['countries'] = $countries;

    header("Location: ../view/createEditDeliveryAddressView.php");
    exit();
}

function registerDeliveryAddress()
{
    $userService = new UserService();
    $orderService = new OrderService();

    if (isset($_POST) && isset($_POST['registerDeliveryAddressSubmitButton'])) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $loggedInUserId = $_SESSION['loggedInUserData']->getId();
        $loggedInUser = $userService->getUserById($loggedInUserId);

        if (!isset($loggedInUser) || !$loggedInUser->isPermission('PRODUCT_BUY')) {
            unset($_SESSION['cartEntrys']);
            header("Location: ../view/showAllCartEntrysView.php?error=notAllowed");
            exit();
        } else {
            // register Invoice address data
            $id = htmlspecialchars($_POST['id']);
            $salutationId = htmlspecialchars($_POST['salutationId']);
            $titleBeforeName = htmlspecialchars($_POST['titleBeforeName']);
            $firstName = htmlspecialchars($_POST['firstName']);
            $lastName = htmlspecialchars($_POST['lastName']);
            $titleAfterName = htmlspecialchars($_POST['titleAfterName']);
            $phoneNumber = htmlspecialchars($_POST['phoneNumber']);
            $email = htmlspecialchars($_POST['email']);
            $countryId = htmlspecialchars($_POST['countryId']);
            $postalCode = htmlspecialchars($_POST['postalCode']);
            $location = htmlspecialchars($_POST['location']);
            $addressLine1 = htmlspecialchars($_POST['addressLine1']);
            $addressLine2 = htmlspecialchars($_POST['addressLine2']);
            $vatId = htmlspecialchars($_POST['vatId']);

            // create transport data box
            $createAddressData = new CreateAddressData(
                $id,
                $salutationId,
                $titleBeforeName,
                $firstName,
                $lastName,
                $titleAfterName,
                $phoneNumber,
                $email,
                $countryId,
                $postalCode,
                $location,
                $addressLine1,
                $addressLine2,
                $vatId
            );

            $errorMessage = $userService->testInputsForCreateAddress($createAddressData);

            if ($errorMessage != null) {
                $salutations = $userService->getSalutations();
                $_SESSION['salutations'] = $salutations;
                $countries = $userService->getCountries();
                $_SESSION['countries'] = $countries;

                $_SESSION['errorMessage'] = $errorMessage;
                $_SESSION['createAddressData'] = $createAddressData;

                header("Location: ../view/createEditDeliveryAddressView.php");
                exit();
            } else {
                $salutation = $userService->getSalutationById($createAddressData->getSalutationId());
                $country = $userService->getCountryById($createAddressData->getCountryId());
                $deliveryAddress = new Address(
                    $createAddressData->getId(),
                    $salutation,
                    $createAddressData->getTitleBeforeName(),
                    $createAddressData->getFirstName(),
                    $createAddressData->getLastName(),
                    $createAddressData->getTitleAfterName(),
                    $createAddressData->getPhoneNumber(),
                    $createAddressData->getEmail(),
                    $country,
                    $createAddressData->getPostalCode(),
                    $createAddressData->getLocation(),
                    $createAddressData->getAddressLine1(),
                    $createAddressData->getAddressLine2(),
                    $createAddressData->getVatId()
                );

                $newOrderStatus = $orderService->getOrderStatusByName("CREATE_AFTER_REGISTER_DELIVERY_ADDRESS");

                $loggedInUser->getOrderInProgress()->setDeliveryAddress($deliveryAddress);
                $loggedInUser->getOrderInProgress()->setStatus($newOrderStatus);
                $userService->saveUser($loggedInUser);

                createPaymentSettingsView();
            }
        }
    }
}

// -------------------------------------------------------------------

function createPaymentSettingsView()
{
    $userService = new UserService();

    // come to this method as a part of register delivery settings from "createDeliverySettingsView"
    // or as a part of register delivery address from "createEditDeliveryAddressView"
    if (isset($_POST) && (isset($_POST['registerDeliverySettingsSubmitButton']) || isset($_POST['registerDeliveryAddressSubmitButton']))) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $loggedInUserId = $_SESSION['loggedInUserData']->getId();
        $loggedInUser = $userService->getUserById($loggedInUserId);

        if (!isset($loggedInUser) || !$loggedInUser->isPermission('PRODUCT_BUY')) {
            unset($_SESSION['cartEntrys']);
            header("Location: ../view/showAllCartEntrysView.php?error=notAllowed");
            exit();
        } else {
            createPaymentSettingsViewDetail($loggedInUser);
        }
    }
}

function backwardToCreatePaymentSettingsView()
{
    $userService = new UserService();
    $orderService = new OrderService();

    if (isset($_POST) && isset($_POST['backwardToCreatePaymentSettingsViewSubmitButton'])) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $loggedInUserId = $_SESSION['loggedInUserData']->getId();
        $loggedInUser = $userService->getUserById($loggedInUserId);

        if (!isset($loggedInUser) || !$loggedInUser->isPermission('PRODUCT_BUY')) {
            unset($_SESSION['cartEntrys']);
            header("Location: ../view/showAllCartEntrysView.php?error=notAllowed");
            exit();
        } else {
            $orderStatus = $orderService->getOrderStatusByName("CREATE_AFTER_REGISTER_DELIVERY_SETTINGS");
            $order = $loggedInUser->getOrderInProgress();
            $order->setStatus($orderStatus);
            $userService->saveUser($loggedInUser);

            createPaymentSettingsViewDetail($loggedInUser);
        }
    }
}

function createPaymentSettingsViewDetail($loggedInUser)
{
    $orderService = new OrderService();

    $paymentOptions = $orderService->getPaymentOptions();
    $_SESSION['paymentOptions'] = $paymentOptions;

    $defaultValuePaymentOption = null;

    if ($loggedInUser->getOrderInProgress() != null && $loggedInUser->getOrderInProgress()->getPaymentOption() != null) {
        $defaultValuePaymentOption = $loggedInUser->getOrderInProgress()->getPaymentOption();
    } else {
        $defaultValuePaymentOption = $orderService->getPaymentOptionById(1);
    }

    $_SESSION['defaultValuePaymentOption'] = $defaultValuePaymentOption;

    header("Location: ../view/createPaymentSettingsView.php");
    exit();
}

function registerPaymentSettings()
{
    $userService = new UserService();
    $orderService = new OrderService();

    if (isset($_POST) && isset($_POST['registerPaymentSettingsSubmitButton'])) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $loggedInUserId = $_SESSION['loggedInUserData']->getId();
        $loggedInUser = $userService->getUserById($loggedInUserId);

        if (!isset($loggedInUser) || !$loggedInUser->isPermission('PRODUCT_BUY')) {
            unset($_SESSION['cartEntrys']);
            header("Location: ../view/showAllCartEntrysView.php?error=notAllowed");
            exit();
        } else {
            $paymentOptionId = htmlspecialchars($_POST['paymentOptionId']);

            $paymentOption = $orderService->getPaymentOptionById($paymentOptionId);
            $order = $loggedInUser->getOrderInProgress();
            $order->setPaymentOption($paymentOption);

            $newOrderStatus = $orderService->getOrderStatusByName("CREATE_AFTER_REGISTER_PAYMENT_SETTINGS");
            $order->setStatus($newOrderStatus);
            $userService->saveUser($loggedInUser);

            createConfirmDataView();
        }
    }
}

// -------------------------------------------------------------------

function createConfirmDataView()
{
    $userService = new UserService();

    // come to this method as a part of register payment settings from "createPaymentSettingsView"
    if (isset($_POST) && (isset($_POST['registerPaymentSettingsSubmitButton']))) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $loggedInUserId = $_SESSION['loggedInUserData']->getId();
        $loggedInUser = $userService->getUserById($loggedInUserId);

        if (!isset($loggedInUser) || !$loggedInUser->isPermission('PRODUCT_BUY')) {
            unset($_SESSION['cartEntrys']);
            header("Location: ../view/showAllCartEntrysView.php?error=notAllowed");
            exit();
        } else {
            createConfirmDataViewDetail($loggedInUser);
        }
    }
}

function createConfirmDataViewDetail($loggedInUser)
{
    $orderService = new OrderService();
    $cartService = new CartService();

    // order does not have orderEntrys in it, create confirmOrderEntrysData only for the view
    $cartEntrys = $cartService->getCartEntrysByUserId($loggedInUser->getId());
    $confirmOrderEntrysData = array();

    foreach ($cartEntrys as $cartEntry) {
        $orderEntry = $orderService->getOrderEntryFromCartEntry($cartEntry);
        $confirmOrderEntryData = $orderService->getConfirmOrderEntryDataFromOrderEntry($orderEntry);
        array_push($confirmOrderEntrysData, $confirmOrderEntryData);
    }

    $confirmOrderData = $orderService->getConfirmOrderDataFromOrder($loggedInUser->getOrderInProgress());
    $confirmOrderData->setConfirmOrderEntrysData($confirmOrderEntrysData);

    $_SESSION['confirmOrderData'] = $confirmOrderData;

    $cartEntrysCount = $cartService->getCartEntrysCountByUserId($loggedInUser->getId());
    $priceTotal = $cartService->getCartEntrysPriceTotalByUserId($loggedInUser->getId());

    $_SESSION['cartEntrysCount'] = $cartEntrysCount;
    $_SESSION['priceTotal'] = $priceTotal;
    
    header("Location: ../view/confirmDataView.php");
    exit();
}

function registerConfirmData()
{
    $userService = new UserService();
    $orderService = new OrderService();
    $cartService = new CartService();
    $productService = new ProductService();

    if (isset($_POST) && isset($_POST['registerConfirmDataSubmitButton'])) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $loggedInUserId = $_SESSION['loggedInUserData']->getId();
        $loggedInUser = $userService->getUserById($loggedInUserId);

        if (!isset($loggedInUser) || !$loggedInUser->isPermission('PRODUCT_BUY')) {
            unset($_SESSION['cartEntrys']);
            header("Location: ../view/showAllCartEntrysView.php?error=notAllowed");
            exit();
        } else {
            $order = $loggedInUser->getOrderInProgress();
            $cartEntrys = $cartService->getCartEntrysByUserId($loggedInUser->getId());

            foreach ($cartEntrys as $cartEntry) {
                $orderEntry = $orderService->getOrderEntryFromCartEntry($cartEntry);
                $order->addOrderEntry($orderEntry);
                $cartService->removeProductFromCart($cartEntry);                        // remove product (cartEntry) from cart

                $productService->reduceStockCountFromProduct($orderEntry);
            }

            $newOrderStatus = $orderService->getOrderStatusByName("CREATE_END");
            $order->setStatus($newOrderStatus);
            $loggedInUser->setOrderInProgress(null);                                    // remove order from user
            $userService->saveUser($loggedInUser);

            $orderService->saveOrder($order, $loggedInUser->getId());                   // save the order

            header("Location: ../view/showAfterBuyMessageView.php");
            exit();
        }
    }
}
