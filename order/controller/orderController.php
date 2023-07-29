<?php

$rootPath = __DIR__;
$rootPath = str_replace('order' . DIRECTORY_SEPARATOR . 'controller', '', $rootPath);
require_once $rootPath . 'base/importRequireFileList.php';

importRequireFileList(__FILE__ . '/');

if (isset($_GET)) {
}
if (isset($_GET['showAllOrdersViewSubmitButton'])) {
    showAllOrdersView();
}

if (isset($_POST)) {
}

function showAllOrdersView()
{
    if (isset($_GET) && isset($_GET['showAllOrdersViewSubmitButton'])) {
        $userService = new UserService();
        $orderService = new OrderService();

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $loggedInUserId = $_SESSION['loggedInUserData']->getId();
        $loggedInUser = $userService->getUserById($loggedInUserId);

        if (!isset($loggedInUser) || !$loggedInUser->isPermission('ORDER_SHOW')) {
            unset($_SESSION['users']);
            header("Location: ../../index.php?error=notAllowed");
            exit();
        } else {
            $orders = $orderService->getOrders();

            if ($orders == null) {
                header("Location: ../view/showAllOrdersView.php?info=noOrderAvailable");
                exit();
            } else {
                if (!session_status() == PHP_SESSION_ACTIVE) {
                    header("Location: ../view/showAllOrdersView.php?error=noSessionAvailable");
                    exit();
                } else {
                    $overviewOrdersData = array();

                    foreach ($orders as $order) {
                        $overriewOrderData = $orderService->getOverviewOrderDataFromOrder($order);
                        array_push($overviewOrdersData, $overriewOrderData);
                    }

                    $_SESSION['overviewOrdersData'] = $overviewOrdersData;

                    header("Location: ../view/showAllOrdersView.php?");
                    exit();
                }
            }
        }
    }
}
