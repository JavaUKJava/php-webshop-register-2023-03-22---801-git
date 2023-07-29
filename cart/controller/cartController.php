<?php

$rootPath = __DIR__;
$rootPath = str_replace('cart' . DIRECTORY_SEPARATOR . 'controller', '', $rootPath);
require_once $rootPath . 'base/importRequireFileList.php';
importRequireFileList(__FILE__ . '/');

if (isset($_GET)) {
    if (isset($_GET['showAllCartEntrysViewSubmitButton'])) {
        showAllCartEntrysView();
    } else if (isset($_GET['showAllCartEntrysByUserIdViewSubmitButton'])) {
        showAllCartEntrysByUserIdView();
    } else if (isset($_GET['showAllCartEntrysByGetParameterIdViewSubmitButton'])) {
        showAllCartEntrysByGetParameterIdView();
    } else if (isset($_GET['addProductToCartSubmitButton'])) {
        addProductToCart();
    } else if (isset($_GET['removeProductFromCartSubmitButton'])) {
        removeProductFromCart();
    }
}

if (isset($_POST)) {
    if (isset($_POST['editProductCountSubmit'])) {
        editProductCount();
    }
}

function showAllCartEntrysView()
{
    $userService = new UserService();
    $cartService = new CartService();

    if (isset($_GET) && isset($_GET['showAllCartEntrysViewSubmitButton'])) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $loggedInUserId = $_SESSION['loggedInUserData']->getId();
        $loggedInUser = $userService->getUserById($loggedInUserId);

        if (!isset($loggedInUser) || !$loggedInUser->isRole('ADMIN')) {
            unset($_SESSION['cartEntrys']);
            header("Location: ../view/showAllCartEntrysView.php?error=notAllowed");
            exit();
        } else {
            $cartEntrys = $cartService->getCartEntrys();
            $cartEntrysCount = $cartService->getCartEntrysCount();
            $priceTotal = $cartService->getCartEntrysPriceTotal();

            $_SESSION['cartEntrys'] = $cartEntrys;
            $_SESSION['cartEntrysCount'] = $cartEntrysCount;
            $_SESSION['priceTotal'] = $priceTotal;

            if ($cartEntrys == null) {
                header("Location: ../view/showAllCartEntrysView.php?info=noCartEntryAvailable");
                exit();
            } else {
                if (!session_status() == PHP_SESSION_ACTIVE) {
                    header("Location: ../view/showAllCartEntrysView.php?error=noSessionAvailable");
                    exit();
                } else {
                    header("Location: ../view/showAllCartEntrysView.php?");
                    exit();
                }
            }
        }
    }
}

function showAllCartEntrysByUserIdView()
{
    $userService = new UserService();
    $cartService = new CartService();

    if (isset($_GET) && isset($_GET['showAllCartEntrysByUserIdViewSubmitButton'])) {
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
            $cartEntrys = $cartService->getCartEntrysByUserId($loggedInUserId);
            $cartEntrysCount = $cartService->getCartEntrysCountByUserId($loggedInUserId);
            $priceTotal = $cartService->getCartEntrysPriceTotalByUserId($loggedInUserId);

            $_SESSION['cartEntrys'] = $cartEntrys;
            $_SESSION['cartEntrysCount'] = $cartEntrysCount;
            $_SESSION['priceTotal'] = $priceTotal;

            if ($cartEntrys == null) {
                header("Location: ../view/showAllCartEntrysView.php?info=noCartEntryAvailable");
                exit();
            } else {
                if (!session_status() == PHP_SESSION_ACTIVE) {
                    header("Location: ../view/showAllCartEntrysView.php?error=noSessionAvailable");
                    exit();
                } else {
                    header("Location: ../view/showAllCartEntrysView.php?");
                    exit();
                }
            }
        }
    }
}

function showAllCartEntrysByGetParameterIdView()
{
    $userService = new UserService();
    $cartService = new CartService();

    if (isset($_GET) && isset($_GET['showAllCartEntrysByGetParameterIdViewSubmitButton'])) {
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
            $id = htmlspecialchars($_GET['id']);

            $cartEntrys = $cartService->getCartEntrysByUserId($id);
            $cartEntrysCount = $cartService->getCartEntrysCountByUserId($id);
            $priceTotal = $cartService->getCartEntrysPriceTotalByUserId($id);
            $parameterUserData = $userService->getUserDataFromUser($userService->getUserById($id));

            $_SESSION['cartEntrys'] = $cartEntrys;
            $_SESSION['cartEntrysCount'] = $cartEntrysCount;
            $_SESSION['priceTotal'] = $priceTotal;
            $_SESSION['parameterUserData'] = $parameterUserData;

            if ($cartEntrys == null) {
                header("Location: ../view/showAllCartEntrysView.php?info=noCartEntryAvailable");
                exit();
            } else {
                if (!session_status() == PHP_SESSION_ACTIVE) {
                    header("Location: ../view/showAllCartEntrysView.php?error=noSessionAvailable");
                    exit();
                } else {
                    header("Location: ../view/showAllCartEntrysView.php?");
                    exit();
                }
            }
        }
    }
}

function addProductToCart()
{
    $userService = new UserService();
    $productService = new ProductService();
    $cartService = new CartService();

    if (isset($_GET) && isset($_GET['addProductToCartSubmitButton'])) {
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
            $productId = htmlspecialchars($_GET['productId']);
            $productCount = htmlspecialchars($_GET['productCount']);

            $product = $productService->getProductById($productId);

            if (isset($product)) {
                if ($productService->getAvailableCountOfProduct($product) - $productCount < 0) {
                    $productDatas = $productService->getProductDatas();
                    $user = $userService->getUserById($loggedInUserId);
                    $loggedInUserData = $userService->getLoggedInUserDataFromUser($user);

                    $_SESSION['loggedInUserData'] = $loggedInUserData;
                    $_SESSION['productDatas'] = $productDatas;
                    header("Location: ../../product/view/showAllProductsView.php?error=productCountToHight");
                    exit();
                } else {
                    $addedSuccess = $cartService->addProductToCart($loggedInUserId, $productId, $productCount);

                    $productDatas = $productService->getProductDatas();
                    $user = $userService->getUserById($loggedInUserId);
                    $loggedInUserData = $userService->getLoggedInUserDataFromUser($user);

                    $_SESSION['loggedInUserData'] = $loggedInUserData;
                    $_SESSION['productDatas'] = $productDatas;

                    if ($addedSuccess) {
                        header("Location: ../../product/view/showAllProductsView.php?info=addedSuccess");
                        exit();
                    } else {
                        header("Location: ../../product/view/showAllProductsView.php?error=notAdded");
                        exit();
                    }
                }
            } else {
                $productDatas = $productService->getProductDatas();
                $user = $userService->getUserById($loggedInUserId);
                $loggedInUserData = $userService->getLoggedInUserDataFromUser($user);

                $_SESSION['loggedInUserData'] = $loggedInUserData;
                $_SESSION['productDatas'] = $productDatas;
                header("Location: ../../product/view/showAllProductsView.php?error=notAdded");
                exit();
            }
        }
    }
}

function removeProductFromCart()
{
    $userService = new UserService();
    $cartService = new CartService();

    if (isset($_GET) && isset($_GET['removeProductFromCartSubmitButton'])) {
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
            $cartEntryId = htmlspecialchars($_GET['id']);
            $cartEntry = $cartService->getCartEntryById($cartEntryId);
            $deleteSuccess = $cartService->removeProductFromCart($cartEntry);

            $newUser = $userService->getUserById($loggedInUserId);
            $newLoggedInUserData = $userService->getLoggedInUserDataFromUser($newUser);
            $_SESSION['loggedInUserData'] = $newLoggedInUserData;

            $newCartEntrys = $cartService->getCartEntrysByUserId($loggedInUserId);
            $_SESSION['cartEntrys'] = $newCartEntrys;

            $cartEntrysCount = $cartService->getCartEntrysCountByUserId($loggedInUserId);
            $priceTotal = $cartService->getCartEntrysPriceTotalByUserId($loggedInUserId);
            $_SESSION['cartEntrysCount'] = $cartEntrysCount;
            $_SESSION['priceTotal'] = $priceTotal;

            if ($deleteSuccess == false) {
                header("Location: ../view/showAllCartEntrysView.php?error=removeNotSuccess");
                exit();
            } else {
                header("Location: ../view/showAllCartEntrysView.php?info=removeSuccess");
                exit();
            }
        }
    }
}

function editProductCount()
{
    $userService = new UserService();
    $productService = new ProductService();
    $cartService = new CartService();

    if (isset($_POST) && isset($_POST['editProductCountSubmit'])) {
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
            $cartEntryId = htmlspecialchars($_POST['id']);
            $newProductCount = htmlspecialchars($_POST['productCount']);

            $cartEntry = $cartService->getCartEntryById($cartEntryId);
            $product = $cartEntry->getProduct();
            $oldProductCount = $cartEntry->getProductCount();
            $differentProductCount = $newProductCount - $oldProductCount;

            $editUser = $userService->getUserById($loggedInUserId);
            $editInUserData = $userService->getLoggedInUserDataFromUser($editUser);
            $_SESSION['loggedInUserData'] = $editInUserData;

            if ($productService->getAvailableCountOfProduct($product) >= $differentProductCount) {
                $cartEntry->setProductCount($cartEntry->getProductCount() + $differentProductCount);
                $cartService->saveCartEntry($cartEntry);

                $cartEntrysCount = $cartService->getCartEntrysCountByUserId($loggedInUserId);
                $priceTotal = $cartService->getCartEntrysPriceTotalByUserId($loggedInUserId);

                $cartEntrys = $cartService->getCartEntrysByUserId($editUser->getId());
                $_SESSION['cartEntrys'] = $cartEntrys;
                $_SESSION['cartEntrysCount'] = $cartEntrysCount;
                $_SESSION['priceTotal'] = $priceTotal;

                header("Location: ../view/showAllCartEntrysView.php?info=editSuccess");
                exit();
            } else {
                $cartEntrysCount = $cartService->getCartEntrysCountByUserId($loggedInUserId);
                $priceTotal = $cartService->getCartEntrysPriceTotalByUserId($loggedInUserId);

                $cartEntrys = $cartService->getCartEntrysByUserId($editUser->getId());
                $_SESSION['cartEntrys'] = $cartEntrys;
                $_SESSION['cartEntrysCount'] = $cartEntrysCount;
                $_SESSION['priceTotal'] = $priceTotal;

                header("Location: ../view/showAllCartEntrysView.php?error=productCountToHight");
                exit();
            }
        }
    }
}
