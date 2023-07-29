<?php

$rootPath = __DIR__;
$rootPath = str_replace('product' . DIRECTORY_SEPARATOR . 'controller', '', $rootPath);
require_once $rootPath . 'base/importRequireFileList.php';
importRequireFileList(__FILE__ . '/');

if (isset($_GET)) {
    if (isset($_GET['showAllProductsViewSubmitButton'])) {
        showAllProductsView();
    } elseif (isset($_GET['showCreateProductViewSubmitButton'])) {
        showCreateProductView();
    } elseif (isset($_GET['showEditProductViewSubmitButton'])) {
        showEditProductView();
    } elseif (isset($_GET['deleteProductSubmitButton'])) {
        deleteProduct();
    }
}

if (isset($_POST)) {
    if (isset($_POST['createProductSubmitButton'])) {
        createProduct();
    } else if (isset($_POST['showProductsBySearchDataViewSubmitButton'])) {
        showProductsBySearchDataView();
    } 
}

function showAllProductsView()
{
    $userService = new UserService();
    $productService = new ProductService();

    if (isset($_GET) && isset($_GET['showAllProductsViewSubmitButton'])) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $loggedInUserId = $_SESSION['loggedInUserData']->getId();
        $loggedInUser = $userService->getUserById($loggedInUserId);

        if (!isset($loggedInUser) || !$loggedInUser->isPermission('PRODUCT_SHOW')) {
            unset($_SESSION['productDatas']);
            header("Location: ../view/showAllProductsView.php?error=notAllowed");
            exit();
        } else {
            $productDatas = null;
            $productSearchData = null;
            $productSortOrderData = null;

            if (isset($_SESSION) && isset($_SESSION['productSearchData'])) {
                $productSearchData = $_SESSION['productSearchData'];
            } else {
                $productSearchData = new ProductSearchData();
            }

            if (isset($_SESSION) && isset($_SESSION['productSortOrderData'])) {
                $productSortOrderData = $_SESSION['productSortOrderData'];
            } else {
                $productSortOrderData = new ProductSortOrderData();
            }
            
            if ($loggedInUser->isPermission('PRODUCT_CREATE|PRODUCT_EDIT|PRODUCT_DELETE')) {
                $productDatas = $productService->getProductDatasBySearchData($productSearchData, $productSortOrderData);
            } else {
                $productDatas = $productService->getActiveProductDatasBySearchData($productSearchData, $productSortOrderData);
            }

            $_SESSION['productSearchData'] = $productSearchData;

            if ($productDatas == null) {
                header("Location: ../view/showAllProductsView.php?info=noProductAvailable");
                exit();
            } else {
                if (!session_status() == PHP_SESSION_ACTIVE) {
                    header("Location: ../view/showAllProductsView.php?error=noSessionAvailable");
                    exit();
                } else {
                    $_SESSION['productDatas'] = $productDatas;

                    header("Location: ../view/showAllProductsView.php?");
                    exit();
                }
            }
        }
    }
}

function showProductsBySearchDataView()
{
    $userService = new UserService();
    $productService = new ProductService();

    if (isset($_POST) && isset($_POST['showProductsBySearchDataViewSubmitButton'])) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $loggedInUserId = $_SESSION['loggedInUserData']->getId();
        $loggedInUser = $userService->getUserById($loggedInUserId);

        if (!isset($loggedInUser) || !$loggedInUser->isPermission('PRODUCT_SHOW')) {
            unset($_SESSION['products']);
            header("Location: ../view/showAllProductsView.php?error=notAllowed");
            exit();
        } else {
            // --- get the search data from the post value
            $productSearchData = new ProductSearchData();

            if (isset($_POST['searchId'])) {
                $productSearchData->setId(htmlspecialchars($_POST['searchId']));
            }

            if (isset($_POST['searchIdentifier'])) {
                $productSearchData->setIdentifier(htmlspecialchars($_POST['searchIdentifier']));
            }
            
            if (isset($_POST['searchName'])) {
                $productSearchData->setName(htmlspecialchars($_POST['searchName']));
            }

            if (isset($_POST['searchDescription'])) {
                $productSearchData->setDescription(htmlspecialchars($_POST['searchDescription']));
            }

            if (isset($_POST['searchKeywords'])) {
                $productSearchData->setKeywords(htmlspecialchars($_POST['searchKeywords']));
            }

            if (isset($_POST['searchStockCount'])) {
                $productSearchData->setStockCount(htmlspecialchars($_POST['searchStockCount']));
            }

            if (isset($_POST['searchReservedCount'])) {
                $productSearchData->setReservedCount(htmlspecialchars($_POST['searchReservedCount']));
            }

            if (isset($_POST['searchAccessibleCount'])) {
                $productSearchData->setAccessibleCount(htmlspecialchars($_POST['searchAccessibleCount']));
            }

            if (isset($_POST['searchRetailPrice'])) {
                $productSearchData->setRetailPrice(htmlspecialchars($_POST['searchRetailPrice']));
            }

            if (isset($_POST['searchActive'])) {
                $productSearchData->setActive(htmlspecialchars($_POST['searchActive']));
            }

            // --- get the sort data from the post value
            $productSortOrderData = new ProductSortOrderData();

            if (isset($_POST['sortOrder'])) {
                $sortOrder = htmlspecialchars($_POST['sortOrder']);

                switch ($sortOrder) {
                    case 'sortOrderIdUp':
                        $productSortOrderData->setIdUp(true);
                        break;
                    
                    case 'sortOrderIdDown':
                        $productSortOrderData->setIdDown(true);
                        break;
                    
                    case 'sortOrderIdentifierUp':
                        $productSortOrderData->setIdentifierUp(true);
                        break;
                    
                    case 'sortOrderIdentifierDown':
                        $productSortOrderData->setIdentifierDown(true);
                        break;
                    
                    case 'sortOrderNameUp':
                        $productSortOrderData->setNameUp(true);
                        break;
                    
                    case 'sortOrderNameDown':
                        $productSortOrderData->setNameDown(true);
                        break;
                    
                    case 'sortOrderDescriptionUp':
                        $productSortOrderData->setDescriptionUp(true);
                        break;
                    
                    case 'sortOrderDescriptionDown':
                        $productSortOrderData->setDescriptionDown(true);
                        break;
                    
                    case 'sortOrderKeywordsUp':
                        $productSortOrderData->setKeywordsUp(true);
                        break;
                    
                    case 'sortOrderKeywordsDown':
                        $productSortOrderData->setKeywordsDown(true);
                        break;
                    
                    case 'sortOrderStockCountUp':
                        $productSortOrderData->setStockCountUp(true);
                        break;
                    
                    case 'sortOrderStockCountDown':
                        $productSortOrderData->setStockCountDown(true);
                        break;
                    
                    case 'sortOrderReservedCountUp':
                        $productSortOrderData->setReservedCountUp(true);
                        break;
                    
                    case 'sortOrderReservedCountDown':
                        $productSortOrderData->setReservedCountDown(true);
                        break;
                    
                    case 'sortOrderAccessibleCountUp':
                        $productSortOrderData->setAccessibleCountUp(true);
                        break;
                    
                    case 'sortOrderAccessibleCountDown':
                        $productSortOrderData->setAccessibleCountDown(true);
                        break;
                    
                    case 'sortOrderRetailPriceUp':
                        $productSortOrderData->setRetailPriceUp(true);
                        break;
                    
                    case 'sortOrderRetailPriceDown':
                        $productSortOrderData->setRetailPriceDown(true);
                        break;
                    
                    case 'sortOrderActiveUp':
                        $productSortOrderData->setActiveUp(true);
                        break;
                    
                    case 'sortOrderActiveDown':
                        $productSortOrderData->setActiveDown(true);
                        break;
                    
                    default:
                        # code...
                        break;
                }
            }

            // --- get the products from the database
            $productDatas = null;
 

            if ($loggedInUser->isPermission('PRODUCT_CREATE|PRODUCT_EDIT|PRODUCT_DELETE')) {
                $productDatas = $productService->getProductDatasBySearchData($productSearchData, $productSortOrderData);
            } else {
                $productDatas = $productService->getActiveProductDatasBySearchData($productSearchData, $productSortOrderData);
            }

            $_SESSION['productSearchData'] = $productSearchData;
            $_SESSION['productSortOrderData'] = $productSortOrderData;

            if ($productDatas == null) {
                header("Location: ../view/showAllProductsView.php?info=noProductAvailable");
                exit();
            } else {
                if (!session_status() == PHP_SESSION_ACTIVE) {
                    header("Location: ../view/showAllProductsView.php?error=noSessionAvailable");
                    exit();
                } else {
                    $_SESSION['productDatas'] = $productDatas;
                    header("Location: ../view/showAllProductsView.php?");
                    exit();
                }
            }
        }
    }
}

function showCreateProductView()
{
    if (isset($_GET) && isset($_GET['showCreateProductViewSubmitButton'])) {
        $userService = new UserService();

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $loggedInUserId = $_SESSION['loggedInUserData']->getId();
        $loggedInUser = $userService->getUserById($loggedInUserId);

        if (!isset($loggedInUser) || !$loggedInUser->isPermission('PRODUCT_CREATE')) {
            header("Location: ../view/showAllProductsView.php?error=notAllowed");
            exit();
        } else {
            if (!session_status() == PHP_SESSION_ACTIVE) {
                header("Location: ../view/showAllProductsView.php?error=noSessionAvailable");
                exit();
            } else {
                header("Location: ../view/createEditProductView.php");
                exit();
            }
        }
    }
}

function createProduct()
{
    if (isset($_POST) && isset($_POST['createProductSubmitButton'])) {
        $userService = new UserService();

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $loggedInUserId = $_SESSION['loggedInUserData']->getId();
        $loggedInUser = $userService->getUserById($loggedInUserId);

        if (!isset($loggedInUser) || !$loggedInUser->isPermission('PRODUCT_CREATE')) {
            header("Location: ../view/createEditProductView.php?error=notAllowed");
            exit();
        } else {
            $productService = new ProductService();

            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }

            if (isset($_POST['id']) && htmlspecialchars($_POST['id']) > 0) {
                $id = htmlspecialchars($_POST['id']);
            } else {
                $id = null;
            }

            $identifier = htmlspecialchars($_POST['identifier']);
            $name = htmlspecialchars($_POST['name']);
            $description = htmlspecialchars($_POST['description']);
            $keywords = htmlspecialchars($_POST['keywords']);
            $stockCount = htmlspecialchars($_POST['stockCount']);
            $retailPrice = htmlspecialchars($_POST['retailPrice']);

            if (isset($_POST['active'])) {
                $active = 1;
            } else {
                $active = 0;
            }

            if (strlen($_FILES['image1']['name']) > 0) {            // if product have an image selected
                $image1 = $_FILES['image1']['name'];                    // file name from image
                $image1File = $_FILES['image1']['tmp_name'];            // the file from the image
                move_uploaded_file($image1File, "../image/$image1");    // insert file in directory
            } elseif (isset($_POST['oldImage1'])) {                 // if product was edit and dont get a new image
                $image1 = htmlspecialchars($_POST['oldImage1']);
            } else {                                                // if product was create or edit without an image
                $image1 = null;
            }

            if (strlen($_FILES['image2']['name']) > 0) {
                $image2 = $_FILES['image2']['name'];
                $image2File = $_FILES['image2']['tmp_name'];
                move_uploaded_file($image2File, "../image/$image2");
            } elseif (isset($_POST['oldImage2'])) {
                $image2 = htmlspecialchars($_POST['oldImage2']);
            } else {
                $image2 = null;
            }

            if (strlen($_FILES['image3']['name']) > 0) {
                $image3 = $_FILES['image3']['name'];
                $image3File = $_FILES['image3']['tmp_name'];
                move_uploaded_file($image3File, "../image/$image3");
            } elseif (isset($_POST['oldImage3'])) {
                $image3 = htmlspecialchars($_POST['oldImage3']);
            } else {
                $image3 = null;
            }

            $product = new Product($id, $identifier, $name, $description, $keywords, $stockCount, $retailPrice, $active, $image1, $image2, $image3);
            $savedProduct = $productService->saveProduct($product);

            if (isset($savedProduct)) {
                $_SESSION['product'] = $product;
                header("Location: ../view/createEditProductView.php?info=addedSuccess");
                exit();
            } else {
                $_SESSION['product'] = $product;
                header("Location: ../view/createEditProductView.php?error=faildToSave");
                exit();
            }
        }
    }
}

function showEditProductView()
{
    if (isset($_GET) && isset($_GET['showEditProductViewSubmitButton'])) {
        $userService = new UserService();
        $productService = new ProductService();

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $loggedInUserId = $_SESSION['loggedInUserData']->getId();
        $loggedInUser = $userService->getUserById($loggedInUserId);

        if (!isset($loggedInUser) || !$loggedInUser->isPermission('PRODUCT_EDIT')) {
            header("Location: ../view/showAllProductsView.php?error=notAllowed");
            exit();
        } else {
            if (isset($_GET['id'])) {
                $productId = htmlspecialchars($_GET['id']);
                $product = $productService->getProductById($productId);

                if (isset($product)) {
                    $_SESSION['product'] = $product;
                    header("Location: ../view/createEditProductView.php");
                    exit();
                }
            }
        }
    }
}

function deleteProduct()
{
    if (isset($_GET) && isset($_GET['deleteProductSubmitButton'])) {
        $userService = new UserService();

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $loggedInUserId = $_SESSION['loggedInUserData']->getId();
        $loggedInUser = $userService->getUserById($loggedInUserId);

        if (!isset($loggedInUser) || !$loggedInUser->isPermission('PRODUCT_DELETE')) {
            header("Location: ../view/showAllProductsView.php?error=notAllowed");
            exit();
        } else {
            $productService = new ProductService();

            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }

            if (isset($_GET['id']) && htmlspecialchars($_GET['id']) > 0) {
                $id = htmlspecialchars($_GET['id']);

                if (empty($id) || $id <= 0) {
                    header("Location: ../view/showAllProductsView.php?error=deleteProductNotFound");
                    exit();
                } else {
                    $deleteSuccess = $productService->deleteProduct($id);
                    $products = $productService->getProducts();
                    session_start();
                    $_SESSION['products'] = $products;

                    if ($deleteSuccess == true) {
                        header("Location: ../view/showAllProductsView.php?info=deleteSuccess");
                        exit();
                    } else {
                        header("Location: ../view/showAllProductsView.php?error=deleteProductNotFound");
                        exit();
                    }
                }
            }
        }
    }
}
