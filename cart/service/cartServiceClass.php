<?php

/**
 * Service for all work with cart.
 */
class CartService extends DatabaseService
{

    public function getCartEntryByUserIdAndByProductId($userId, $productId)
    {
        $userService = new UserService();
        $productService = new ProductService();

        $sql = "select id, user_id, product_id, product_count
                    from cart_entrys
                    where user_id = ? and product_id = ?";

        $cartEntry = null;

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $statement->execute(array($userId, $productId));

            if ($statement->rowCount()) {
                $row = $statement->fetch();
                $user = $userService->getUserById($row['user_id']);
                $product = $productService->getProductById($row['product_id']);
                $cartEntry = new CartEntry($row['id'], $user, $product, $row['product_count']);
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- getCartEntryByUserIdAndByProductId($userId, $productId) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $cartEntry;
    }

    public function getCartEntryById($id)
    {
        $userService = new UserService();
        $productService = new ProductService();

        $sql = "select id, user_id, product_id, product_count
            from cart_entrys
            where id = " . $id;

        $cartEntry = null;

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->query($sql);

            $row = $statement->fetch();
            $user = $userService->getUserById($row['user_id']);
            $product = $productService->getProductById($row['product_id']);

            $cartEntry = new CartEntry($row['id'], $user, $product, $row['product_count']);

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- getCartEntryById($id) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $cartEntry;
    }

    public function getCartEntrys()
    {
        $userService = new UserService();
        $productService = new ProductService();

        $sql = "select id, user_id, product_id, product_count
            from cart_entrys
            order by user_id asc";

        $cartEntrys = array();

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->query($sql);

            while ($row = $statement->fetch()) {
                $user = $userService->getUserById($row['user_id']);
                $product = $productService->getProductById($row['product_id']);

                $cartEntry = new CartEntry($row['id'], $user, $product, $row['product_count']);
                array_push($cartEntrys, $cartEntry);
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- getCartEntrys() -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $cartEntrys;
    }

    public function getCartEntrysByUserId($id)
    {
        $userService = new UserService();
        $productService = new ProductService();

        $sql = "select id, user_id, product_id, product_count
            from cart_entrys
            where user_id = " . $id;

        $cartEntrys = array();

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->query($sql);

            while ($row = $statement->fetch()) {
                $user = $userService->getUserById($row['user_id']);
                $product = $productService->getProductById($row['product_id']);

                $cartEntry = new CartEntry($row['id'], $user, $product, $row['product_count']);
                array_push($cartEntrys, $cartEntry);
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- getCartEntrysByUserId($id) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $cartEntrys;
    }

    public function getCartEntrysCount()
    {
        $sql = "SELECT COUNT(id) as count
        FROM cart_entrys";

        $cartEntryCount = 0;

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->query($sql);

            $row = $statement->fetch();
            $cartEntryCount = $row['count'];

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- getCartEntrysCount() -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $cartEntryCount;
    }

    public function getCartEntrysCountByUserId($id)
    {
        $sql = "SELECT COUNT(id) as count
                    FROM cart_entrys
                    where user_id = " . $id;

        $cartEntryCount = 0;

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->query($sql);

            $row = $statement->fetch();
            $cartEntryCount = $row['count'];

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- getCartEntrysCountByUserId($id) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $cartEntryCount;
    }

    public function getCartEntrysPriceTotal() {
        $priceTotal = 0.0;

        $cartEntrys = $this->getCartEntrys();

        foreach ($cartEntrys as $cartEntry) {
            $priceTotal += (float)$cartEntry->getProduct()->getRetailPrice() * (float)$cartEntry->getProductCount();
        }

        return $priceTotal;
    }

    public function getCartEntrysPriceTotalByUserId($id)
    {
        $priceTotal = 0.0;

        $cartEntrys = $this->getCartEntrysByUserId($id);

        foreach ($cartEntrys as $cartEntry) {
            $priceTotal += (float)$cartEntry->getProduct()->getRetailPrice() * (float)$cartEntry->getProductCount();
        }

        return $priceTotal;
    }

    public function getProductCountInCartByProductId($id)
    {
        $sql = "SELECT SUM(product_count) as count
                    FROM cart_entrys
                    WHERE product_id = " . $id;

        $productCount = 0;

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->query($sql);

            $row = $statement->fetch();

            if ($row['count'] > 0) {
                $productCount = $row['count'];
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- getProductCountInCartByProductId($id) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $productCount;
    }

    public function addProductToCart($userId, $productId, $productCount)
    {
        $addedSuccess = false;
        $foundProductIdInCart = false;

        $sql = "select id, user_id, product_id, product_count
                    from cart_entrys
                    where user_id = ? and product_id = ?";

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $statement->execute(array($userId, $productId));

            if ($statement->rowCount() > 0) {
                $foundProductIdInCart = true;
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- addProductToCart($userId, $productId, $productCount) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        if ($foundProductIdInCart == false) {
            // add product to cart
            $addedSuccess = $this->addProductToCartWithNewCartEntry($userId, $productId, $productCount);
        } else {
            // edit product count (in the cart) to new value
            $addedSuccess = $this->addProductToCartWithEditProductCountInCartEntry($userId, $productId, $productCount);
        }

        return $addedSuccess;
    }

    private function addProductToCartWithNewCartEntry($userId, $productId, $productCount)
    {
        $addedSuccess = false;

        $userService = new UserService();
        $productService = new ProductService();

        $user = $userService->getUserById($userId);
        $product = $productService->getProductById($productId);
        $cartEntry = new CartEntry(null, $user, $product, $productCount);
        $addedSuccess = $this->saveCartEntry($cartEntry);

        return $addedSuccess;
    }

    private function addProductToCartWithEditProductCountInCartEntry($userId, $productId, $productCount)
    {
        $addedSuccess = false;

        $cartEntry = $this->getCartEntryByUserIdAndByProductId($userId, $productId);
        $cartEntry->setProductCount($cartEntry->getProductCount() + $productCount);
        $addedSuccess = $this->saveCartEntry($cartEntry);

        return $addedSuccess;
    }

    public function saveCartEntry($cartEntry)
    {
        if ($cartEntry->getId() == null) {
            // insert new cartEntry
            $sql = "insert into cart_entrys (user_id, product_id, product_count) values (?, ?, ?)";
            return $this->insertCartEntry($sql, array($cartEntry->getUser()->getId(), $cartEntry->getProduct()->getId(), $cartEntry->getProductCount()));
        } else {
            // update existed cartEntry
            $sql = "update cart_entrys set user_id = ?, product_id = ?, product_count = ? where id = ? and id > 0";
            return $this->updateCartEntry($sql, array($cartEntry->getUser()->getId(), $cartEntry->getProduct()->getId(), $cartEntry->getProductCount(), $cartEntry->getId()));
        }
    }

    private function insertCartEntry($sql, $parameters)
    {
        $insertSuccess = false;

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $insertSuccess = $statement->execute($parameters);

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- insertCartEntry($sql, $parameters) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $insertSuccess;
    }

    private function updateCartEntry($sql, $parameters)
    {
        $updateSuccess = false;

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $updateSuccess = $statement->execute($parameters);

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- updateCartEntry($sql, $parameters) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $updateSuccess;
    }

    public function removeProductFromCart($cartEntry)
    {
        $deleteSuccess = false;

        $sql = "delete from cart_entrys where id = ? and id > 0";

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $deleteSuccess = $statement->execute(array($cartEntry->getId()));

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- removeProductFromCart($cartEntry) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
        return $deleteSuccess;
    }
}
