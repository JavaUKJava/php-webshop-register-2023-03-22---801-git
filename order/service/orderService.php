<?php

/**
 * Service for all work with order between order and database.
 */
class OrderService extends DatabaseService
{
    public function getOrders()
    {
        $orders = array();

        $userService = new UserService();
        $buyService = new BuyService();

        $sql = "select id, invoice_id, invoice_address_id, delivery_address_id, date, status_id, delivery_option_id, payment_option_id 
                from orders";

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->query($sql);

            while ($row = $statement->fetch()) {
                $invoice = $buyService->getInvoiceById($row['invoice_id']);
                $invoiceAddress = $userService->getAddressById($row['invoice_address_id']);
                $deliveryAddress = $userService->getAddressById($row['delivery_address_id']);
                $orderStatus = $this->getOrderStatusById($row['status_id']);
                $deliveryOption = $this->getDeliveryOptionById($row['delivery_option_id']);
                $paymentOption = $this->getPaymentOptionById($row['payment_option_id']);
                $orderEntrys = $this->getOrderEntrysByOrderId($row['id']);

                $order = new Order($row['id'], $invoice, $invoiceAddress, $deliveryAddress, $row['date'], $orderStatus, $deliveryOption, $paymentOption, $orderEntrys);
                array_push($orders, $order);
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- getOrders() -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $orders;
    }

    public function getOrdersByUserId($id)
    {
        $orders = array();

        $userService = new UserService();
        $buyService = new BuyService();

        $sql = "select orders.id, orders.invoice_id, orders.invoice_address_id, orders.delivery_address_id, orders.date, orders.status_id, orders.delivery_option_id, orders.payment_option_id
        from orders
        left join users_to_orders
        on orders.id = users_to_orders.order_id
        where users_to_orders.user_id=?;";

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $statement->execute(array($id));

            while ($row = $statement->fetch()) {
                $invoice = $buyService->getInvoiceById($row['invoice_id']);
                $invoiceAddress = $userService->getAddressById($row['invoice_address_id']);
                $deliveryAddress = $userService->getAddressById($row['delivery_address_id']);
                $orderStatus = $this->getOrderStatusById($row['status_id']);
                $deliveryOption = $this->getDeliveryOptionById($row['delivery_option_id']);
                $paymentOption = $this->getPaymentOptionById($row['payment_option_id']);
                $orderEntrys = $this->getOrderEntrysByOrderId($row['id']);

                $order = new Order($row['id'], $invoice, $invoiceAddress, $deliveryAddress, $row['date'], $orderStatus, $deliveryOption, $paymentOption, $orderEntrys);
                array_push($orders, $order);
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- getOrdersByUserId($id) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $orders;
    }

    public function getOrderById($id)
    {
        $order = null;

        $userService = new UserService();
        $buyService = new BuyService();

        $sql = "select id, invoice_id, invoice_address_id, delivery_address_id, date, status_id, delivery_option_id, payment_option_id 
                from orders
                where id=?";

        $orderEntrys = $this->getOrderEntrysByOrderId($id);

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $statement->execute(array($id));

            while ($row = $statement->fetch()) {
                $invoice = $buyService->getInvoiceById($row['invoice_id']);
                $invoiceAddress = $userService->getAddressById($row['invoice_address_id']);
                $deliveryAddress = $userService->getAddressById($row['delivery_address_id']);
                $orderStatus = $this->getOrderStatusById($row['status_id']);
                $deliveryOption = $this->getDeliveryOptionById($row['delivery_option_id']);
                $paymentOption = $this->getPaymentOptionById($row['payment_option_id']);

                $order = new Order($row['id'], $invoice, $invoiceAddress, $deliveryAddress, $row['date'], $orderStatus, $deliveryOption, $paymentOption, $orderEntrys);
                break;
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- getOrderById($id) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $order;
    }

    public function getDeliveryOptions()
    {
        $deliveryOptions = array();

        $sql = "select id, name, description 
                from delivery_options";

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->query($sql);

            while ($row = $statement->fetch()) {
                $deliveryOption = new DeliveryOption($row['id'], $row['name'], $row['description']);
                array_push($deliveryOptions, $deliveryOption);
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- getDeliveryOptions() -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $deliveryOptions;
    }

    public function getDeliveryOptionById($id)
    {
        $deliveryOption = null;

        $sql = "select id, name, description 
                from delivery_options
                where id=?";

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $statement->execute(array($id));

            while ($row = $statement->fetch()) {
                $deliveryOption = new DeliveryOption($row['id'], $row['name'], $row['description']);
                break;
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- getDeliveryOptionById($id) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $deliveryOption;
    }

    public function getPaymentOptions()
    {
        $paymentOptions = array();

        $sql = "select id, name, description 
                from payment_options";

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->query($sql);

            while ($row = $statement->fetch()) {
                $paymentOption = new PaymentOption($row['id'], $row['name'], $row['description']);
                array_push($paymentOptions, $paymentOption);
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- getpaymentOptions() -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $paymentOptions;
    }

    public function getPaymentOptionById($id)
    {
        $paymentOption = null;

        $sql = "select id, name, description 
                from payment_options
                where id=?";

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $statement->execute(array($id));

            while ($row = $statement->fetch()) {
                $paymentOption = new PaymentOption($row['id'], $row['name'], $row['description']);
                break;
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- getpaymentOptionById($id) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $paymentOption;
    }

    public function getOrderStatusById($id)
    {
        $orderStatus = null;

        $sql = "select id, name, description 
                from order_status
                where id=?";

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $statement->execute(array($id));

            while ($row = $statement->fetch()) {
                $orderStatus = new OrderStatus($row['id'], $row['name'], $row['description']);
                break;
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- getOrderStatusById($id) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $orderStatus;
    }

    public function getOrderStatusByName($name)
    {
        $orderStatus = null;

        $sql = "select id, name, description 
                from order_status
                where name=?";

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $statement->execute(array($name));

            while ($row = $statement->fetch()) {
                $orderStatus = new OrderStatus($row['id'], $row['name'], $row['description']);
                break;
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- getOrderStatusByName($name) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $orderStatus;
    }

    public function saveOrder($order, $userId)
    {
        $orderId = null;

        $userService = new UserService();

        if ($order->getInvoiceAddress() != null) {
            $invoiceAddressId = $userService->saveAddress($order->getInvoiceAddress());
            $order->getInvoiceAddress()->setId($invoiceAddressId);
        }

        if ($order->getDeliveryAddress() != null) {
            $deliveryAddressId = $userService->saveAddress($order->getDeliveryAddress());
            $order->getDeliveryAddress()->setId($deliveryAddressId);
        }

        if ($order->getOrderEntrys() != null) {
            foreach ($order->getOrderEntrys() as $orderEntry) {
                $savedOrderEntry = $this->saveOrderEntry($orderEntry, $order->getId());

                if (isset($savedOrderEntry)) {
                    $orderEntry->setId($savedOrderEntry->getId());
                }
            }
        }

        if ($order->getId() == null) {
            // insert new order
            $sql = "insert into orders (invoice_id, invoice_address_id, delivery_address_id, date, status_id, delivery_option_id, payment_option_id) values (?, ?, ?, ?, ?, ?, ?)";
            $orderId = $this->insertOrder(
                $sql,
                array(
                    $order->getInvoice() != null ? $order->getInvoice()->getId() : null,
                    $order->getInvoiceAddress() != null ? $order->getInvoiceAddress()->getId() : null,
                    $order->getDeliveryAddress() != null ? $order->getDeliveryAddress()->getId() : null,
                    $order->getDate(),
                    $order->getStatus()->getId(),
                    $order->getDeliveryOption() != null ? $order->getDeliveryOption()->getId() : null,
                    $order->getPaymentOption() != null ? $order->getPaymentOption()->getId() : null
                ),
                $order->getOrderEntrys(),
                $userId
            );
        } else {
            // update existed order
            $sql = "update orders set invoice_id=?, invoice_address_id=?, delivery_address_id=?, date=?, status_id=?, delivery_option_id=?, payment_option_id=? where id=?";
            $orderId = $this->updateOrder(
                $sql,
                array(
                    $order->getInvoice() != null ? $order->getInvoice()->getId() : null,
                    $order->getInvoiceAddress() != null ? $order->getInvoiceAddress()->getId() : null,
                    $order->getDeliveryAddress() != null ? $order->getDeliveryAddress()->getId() : null,
                    $order->getDate(),
                    $order->getStatus()->getId(),
                    $order->getDeliveryOption() != null ? $order->getDeliveryOption()->getId() : null,
                    $order->getPaymentOption() != null ? $order->getPaymentOption()->getId() : null,
                    $order->getId()
                ),
                $order->getOrderEntrys()
            );
        }

        return $orderId;
    }

    private function insertOrder($sql, $parameters, $orderEntrys, $userId)
    {
        $newOrderId = -1;

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $insertSuccess = $statement->execute($parameters);

            if ($insertSuccess == true) {
                $newOrderId = $pdo->lastInsertId();

                // add order to user
                $this->addOrderToUser($newOrderId, $userId);

                foreach ($orderEntrys as $orderEntry) {
                    $this->saveOrderEntry($orderEntry, $newOrderId);
                }
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- insertOrder($sql, $parameters, $orderEntrys, $userId) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $newOrderId;
    }

    private function updateOrder($sql, $parameters, $orderEntrys)
    {
        $updateSuccess = false;

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $updateSuccess = $statement->execute($parameters);

            if ($updateSuccess == true) {
                $orderId = $parameters[5];

                foreach ($orderEntrys as $orderEntry) {
                    $this->saveOrderEntry($orderEntry, $orderId);
                }
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- updateOrder($sql, $parameters, $orderEntrys) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $updateSuccess;
    }

    public function deleteOrder($order)
    {
        $deleteSuccess = false;

        echo '<br>----- !!! orderService.php, deleteOrder: --- is not implemented -----';
        die();

        return $deleteSuccess;
    }

    public function addOrderToUser($orderId, $userId)
    {
        $insertSuccess = false;

        $sql = "insert into users_to_orders (user_id, order_id) values (?, ?)";

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $insertSuccess = $statement->execute(array($userId, $orderId));

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- addOrderToUser($orderId, $userId) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $insertSuccess;
    }

    public function removeOrderFromUser($orderId)
    {
        $deleteSuccess = false;

        echo '<br>----- !!! orderService.php, removeOrderFromUser: --- is not implemented -----';
        die();


        return $deleteSuccess;
    }

    private function addOrderEntryToOrder($orderEntryId, $orderId)
    {
        $insertSuccess = false;

        $sql = "insert into orders_to_order_entrys (order_id, order_entry_id) values (?, ?)";

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $insertSuccess = $statement->execute(array($orderId, $orderEntryId));

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- addOrderEntryToOrder($orderEntryId, $orderId) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $insertSuccess;
    }

    private function removeAllOrderEntrysFromOrder($orderId)
    {
        $deleteSuccess = false;

        echo '<br>----- !!! orderService.php, removeAllOrderEntrysFromOrder: --- is not implemented -----';
        die();

        return $deleteSuccess;
    }

    public function getOrderEntrysByOrderId($id)
    {
        $orderEntrys = array();

        $sql = "select id, order_id, order_entry_id
                from orders_to_order_entrys
                where order_id=?";

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $statement->execute(array($id));

            while ($row = $statement->fetch()) {
                $orderEntry = $this->getOrderEntryById($row['order_entry_id']);
                array_push($orderEntrys, $orderEntry);
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- getOrderEntrysByOrderId($id) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $orderEntrys;
    }

    public function getOrderEntryById($id)
    {
        $orderEntry = null;

        $productService = new ProductService();

        $sql = "select id, product_id, purchase_price, product_count
                from order_entrys
                where id=?";

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $statement->execute(array($id));

            while ($row = $statement->fetch()) {
                $product = $productService->getProductById($row['product_id']);
                $orderEntry = new OrderEntry($row['id'], $product, $row['purchase_price'], $row['product_count']);
                break;
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- getOrderEntryById($id) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $orderEntry;
    }

    public function saveOrderEntry($orderEntry, $orderId)
    {
        $savedOrderEntry = null;

        if ($orderEntry->getId() == null) {
            // insert new orderEntry
            $sql = "insert into order_entrys (product_id, purchase_price, product_count) values (?, ?, ?)";
            return $this->insertOrderEntry($sql, array($orderEntry->getProduct()->getId(), $orderEntry->getPurchasePrice(), $orderEntry->getProductCount()), $orderId);
        } else {
            // update existed orderEntry
            $sql = "update order_entrys set product_id=?, purchase_price=?, product_count=? where id=?";
            return $this->updateOrderEntry($sql, array($orderEntry->getProduct()->getId(), $orderEntry->getPurchasePrice(), $orderEntry->getProductCount(), $orderEntry->getId()), $orderId);
        }

        return $savedOrderEntry;
    }

    private function insertOrderEntry($sql, $parameters, $orderId)
    {
        $savedOrderEntry = false;

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $insertSuccess = $statement->execute($parameters);

            if ($insertSuccess == true) {
                $newOrderEntryId = $pdo->lastInsertId();

                // add inserted orderEntry to order
                $insertSuccess = $this->addOrderEntryToOrder($newOrderEntryId, $orderId);

                $savedOrderEntry = $this->getOrderEntryById($newOrderEntryId);
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- insertOrderEntry($sql, $parameters, $orderId) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $savedOrderEntry;
    }

    private function updateOrderEntry($sql, $parameters, $orderId)
    {
        $updatedOrderEntry = false;

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $updateSuccess = $statement->execute($parameters);

            if ($updateSuccess == true) {
                $updatedOrderEntry = $this->getOrderEntryById($parameters[3]);
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- updateOrderEntry($sql, $parameters, $orderId) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $updatedOrderEntry;
    }

    public function deleteOrderEntry($order)
    {
        $deleteSuccess = false;

        echo '<br>----- !!! orderService.php, deleteOrderEntry: --- is not implemented -----';
        die();

        return $deleteSuccess;
    }

    public function getConfirmOrderDataFromOrder($order)
    {
        $userService = new UserService();

        $confirmOrderEntrysData = array();
        $orderEntrys = $order->getOrderEntrys();

        foreach ($orderEntrys as $orderEntry) {
            $confirmOrderEntryData = $this->getConfirmOrderEntryDataFromOrderEntry($orderEntry);
            array_push($confirmOrderEntrysData, $confirmOrderEntryData);
        }

        $confirmOrderData = new ConfirmOrderData(
            $order->getId(),
            $userService->getConfirmAddressDataFromAddress($order->getInvoiceAddress()),
            $userService->getConfirmAddressDataFromAddress($order->getDeliveryAddress()),
            $order->getPaymentOption()->getName(),
            $confirmOrderEntrysData
        );

        return $confirmOrderData;
    }

    public function getOrderEntryFromCartEntry($cartEntry)
    {
        return new OrderEntry(null, $cartEntry->getProduct(),  $cartEntry->getProduct()->getRetailPrice(), $cartEntry->getProductCount());
    }

    public function getConfirmOrderEntryDataFromOrderEntry($orderEntry)
    {
        return new ConfirmOrderEntryData($orderEntry->getId(), $orderEntry->getProduct(), $orderEntry->getPurchasePrice(), $orderEntry->getProductCount());
    }

    public function getOverviewOrderDataFromOrder($order)
    {
        $userService = new UserService();
        $overviewOrderData = null;

        $user = $userService->getUserByOrderId($order->getId());
        $compactInvoiceAddress = $userService->getCompactInvoiceAddress($order);
        $compactDeliveryAddress = $userService->getCompactDeliveryAddress($order);

        $invoiceStatus = null;

        if ($order->getInvoice() != null) {
            $invoiceStatus = $order->getInvoice()->getStatus();
        }

        $orderEntrysCount = 0;

        if ($order->getOrderEntrys() != null) {
            $orderEntrysCount = count($order->getOrderEntrys());
        }

        $overviewOrderData = new OverviewOrderData($order->getId(), $user->getLoginName(), $compactInvoiceAddress, $compactDeliveryAddress, $order->getDate(), $order->getStatus(), 
                                                    $order->getDeliveryOption(), $order->getPaymentOption(), $invoiceStatus, $orderEntrysCount);

        return $overviewOrderData;
    }
}
