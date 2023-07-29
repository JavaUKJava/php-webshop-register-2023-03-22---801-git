<?php

use ProductService as GlobalProductService;

/**
 * Service for all work with products.
 */
class ProductService extends DatabaseService
{
    public function getProducts()
    {
        $sql = "select products.id, products.identifier, products.name, products.description, products.keywords, products.stock_count, products.retail_price, products.active, products.image_1, products.image_2, products.image_3
            from products
            where products.id > 0";

        $protucts = array();

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->query($sql);

            while ($row = $statement->fetch()) {
                $product = new Product($row['id'], $row['identifier'], $row['name'], $row['description'],  $row['keywords'], $row['stock_count'], $row['retail_price'], $row['active'], $row['image_1'], $row['image_2'], $row['image_3']);
                array_push($protucts, $product);
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- getProducts() -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $protucts;
    }

    public function getProductsBySearchData($productSearchData, $productSortOrderData)
    {
        $sql = "select products.id, products.identifier, products.name, products.description, products.keywords, products.stock_count, products.retail_price, products.active, products.image_1, products.image_2, products.image_3
            from products
            where";

        $productSearchDataAdded = false;

        if ($productSearchData->getId() != "") {
            $sql .= " products.id like " . $productSearchData->getId();
            $productSearchDataAdded = true;
        }

        if ($productSearchData->getIdentifier() != "") {
            if ($productSearchDataAdded) {
                $sql .= " and";
            }

            $sql .= " products.identifier like '%" . $productSearchData->getIdentifier() . "%'";
            $productSearchDataAdded = true;
        }

        if ($productSearchData->getName() != "") {
            if ($productSearchDataAdded) {
                $sql .= " and";
            }

            $sql .= " products.name like '%" . $productSearchData->getName() . "%'";
            $productSearchDataAdded = true;
        }

        if ($productSearchData->getDescription() != "") {
            if ($productSearchDataAdded) {
                $sql .= " and";
            }

            $sql .= " products.description like '%" . $productSearchData->getDescription() . "%'";
            $productSearchDataAdded = true;
        }

        if ($productSearchData->getKeywords() != "") {
            if ($productSearchDataAdded) {
                $sql .= " and";
            }

            $sql .= " products.keywords like '%" . $productSearchData->getKeywords() . "%'";
            $productSearchDataAdded = true;
        }

        if ($productSearchData->getStockCount() != "") {
            if ($productSearchDataAdded) {
                $sql .= " and";
            }

            $stockCountOrgiginalString = (string)$productSearchData->getStockCount();
            $stockCountString = "";

            if (str_starts_with($stockCountOrgiginalString, "&lt;")) {      // htmlspecialchar generate '&lt;' from '<'
                $stockCountString = str_replace("&lt;", "", $stockCountOrgiginalString);
                $stockCountString = trim($stockCountString);
                $sql .= " products.stock_count < " . $stockCountString;
            } else if (str_starts_with($stockCountOrgiginalString, "&gt;")) {
                $stockCountString = str_replace("&gt;", "", $stockCountOrgiginalString);
                $stockCountString = trim($stockCountString);
                $sql .= " products.stock_count > " . $stockCountString;
            } else if (str_starts_with($stockCountOrgiginalString, "=")) {
                $stockCountString = str_replace("=", "", $stockCountOrgiginalString);
                $stockCountString = trim($stockCountString);
                $sql .= " products.stock_count like " . $stockCountString;
            } else if (str_starts_with($stockCountOrgiginalString, "!=")) {
                $stockCountString = str_replace("!=", "", $stockCountOrgiginalString);
                $stockCountString = trim($stockCountString);
                $sql .= " products.stock_count not like " . $stockCountString;
            }

            $productSearchDataAdded = true;
        }

        if ($productSearchData->getRetailPrice() != "") {
            if ($productSearchDataAdded) {
                $sql .= " and";
            }

            $retailPriceOrgiginalString = (string)$productSearchData->getRetailPrice();
            $retailPriceString = "";

            if (str_starts_with($retailPriceOrgiginalString, "&lt;")) {      // htmlspecialchar generate '&lt;' from '<'
                $retailPriceString = str_replace("&lt;", "", $retailPriceOrgiginalString);
                $retailPriceString = trim($retailPriceString);
                $sql .= " products.retail_price < " . $retailPriceString;
            } else if (str_starts_with($retailPriceOrgiginalString, "&gt;")) {
                $retailPriceString = str_replace("&gt;", "", $retailPriceOrgiginalString);
                $retailPriceString = trim($retailPriceString);
                $sql .= " products.retail_price > " . $retailPriceString;
            } else if (str_starts_with($retailPriceOrgiginalString, "=")) {
                $retailPriceString = str_replace("=", "", $retailPriceOrgiginalString);
                $retailPriceString = trim($retailPriceString);
                $sql .= " products.retail_price like " . $retailPriceString;
            } else if (str_starts_with($retailPriceOrgiginalString, "!=")) {
                $retailPriceString = str_replace("!=", "", $retailPriceOrgiginalString);
                $retailPriceString = trim($retailPriceString);
                $sql .= " products.retail_price not like " . $retailPriceString;
            }

            $productSearchDataAdded = true;
        }

        if ($productSearchData->getActive() != "") {
            if ($productSearchDataAdded) {
                $sql .= " and";
            }

            $activeNumber = 0;      // 0 for false

            if ($productSearchData->getActive() == "true") {
                $activeNumber = 1;
            } else if ($productSearchData->getActive() == "false") {
                $activeNumber = 0;
            }

            $sql .= " products.active like " . $activeNumber;
            $productSearchDataAdded = true;
        }

        if ($productSearchDataAdded) {
            $sql .= " and";
        }

        $sql .= " products.id > 0";

        if ($productSortOrderData->getIdUp()) {
            $sql .= " order by products.id asc";
        } else if ($productSortOrderData->getIdDown()) {
            $sql .= " order by products.id desc";
        } else if ($productSortOrderData->getIdentifierUp()) {
            $sql .= " order by products.identifier asc";
        } else if ($productSortOrderData->getIdentifierDown()) {
            $sql .= " order by products.identifier desc";
        } else if ($productSortOrderData->getNameUp()) {
            $sql .= " order by products.name asc";
        } else if ($productSortOrderData->getNameDown()) {
            $sql .= " order by products.name desc";
        } else if ($productSortOrderData->getDescriptionUp()) {
            $sql .= " order by products.description asc";
        } else if ($productSortOrderData->getDescriptionDown()) {
            $sql .= " order by products.description desc";
        } else if ($productSortOrderData->getKeywordsUp()) {
            $sql .= " order by products.keywords asc";
        } else if ($productSortOrderData->getKeywordsDown()) {
            $sql .= " order by products.keywords desc";
        } else if ($productSortOrderData->getStockCountUp()) {
            $sql .= " order by products.stock_count asc";
        } else if ($productSortOrderData->getStockCountDown()) {
            $sql .= " order by products.stock_count desc";
        } else if ($productSortOrderData->getRetailPriceUp()) {
            $sql .= " order by products.retail_price asc";
        } else if ($productSortOrderData->getRetailPriceDown()) {
            $sql .= " order by products.retail_price desc";
        } else if ($productSortOrderData->getActiveUp()) {
            $sql .= " order by products.active asc";
        } else if ($productSortOrderData->getActiveDown()) {
            $sql .= " order by products.active desc";
        }

        $protucts = array();

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->query($sql);

            while ($row = $statement->fetch()) {
                $product = new Product($row['id'], $row['identifier'], $row['name'], $row['description'],  $row['keywords'], $row['stock_count'], $row['retail_price'], $row['active'], $row['image_1'], $row['image_2'], $row['image_3']);
                array_push($protucts, $product);
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- getProductsBySearchData($productSearchData, $productSortOrderData) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $protucts;
    }

    public function getActiveProductsBySearchData($productSearchData, $productSortOrderData)
    {
        return $this->getProductsBySearchData($productSearchData, $productSortOrderData);
    }

    public function getProductById($id)
    {
        $sql = "select products.id, products.identifier, products.name, products.description, products.keywords, products.stock_count, products.retail_price, products.active, products.image_1, products.image_2, products.image_3
            from products
            where products.id = ?";

        $product = null;

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $statement->execute(array($id));
            $rowProduct = $statement->fetch();

            if (isset($rowProduct['id'])) {
                $product = new Product($rowProduct['id'], $rowProduct['identifier'], $rowProduct['name'], $rowProduct['description'], $rowProduct['keywords'], $rowProduct['stock_count'], $rowProduct['retail_price'], $rowProduct['active'], $rowProduct['image_1'], $rowProduct['image_2'], $rowProduct['image_3']);
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- getProductById($id) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $product;
    }

    public function getProductByName($name)
    {
        $sql = "select products.id, products.identifier, products.name, products.description, products.keywords, products.stock_count, products.retail_price, products.active, products.image_1, products.image_2, products.image_3
            from products
            where products.name = ?";

        $product = null;

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $statement->execute(array($name));
            $rowProduct = $statement->fetch();

            if (isset($rowProduct['id'])) {
                $product = new Product($rowProduct['id'], $rowProduct['identifier'], $rowProduct['name'], $rowProduct['description'], $rowProduct['keywords'], $rowProduct['stock_count'], $rowProduct['retail_price'], $rowProduct['active'], $rowProduct['image_1'], $rowProduct['image_2'], $rowProduct['image_3']);
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- getProductByName($name) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $product;
    }

    public function saveProduct($product)
    {
        $savedProduct = null;

        if ($product->getId() == null) {
            // insert new product
            $sql = "insert into products (identifier, name, description, keywords, stock_count, retail_price, active, image_1, image_2, image_3) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            return $this->insertProduct($sql, array($product->getIdentifier(), $product->getName(), $product->getDescription(), $product->getKeywords(), $product->getStockCount(), $product->getRetailPrice(), $product->getActive(), $product->getImage1(), $product->getImage2(), $product->getImage3()));
        } else {
            // update existed product
            $sql = "update products set identifier = ?, name = ?, description = ?, keywords = ?, stock_count = ?, retail_price = ?, active = ?, image_1 = ?, image_2 = ?, image_3 = ? where id = ? and id > 0";
            return $this->updateProduct($sql, array($product->getIdentifier(), $product->getName(), $product->getDescription(), $product->getKeywords(), $product->getStockCount(), $product->getRetailPrice(), $product->getActive(), $product->getImage1(), $product->getImage2(), $product->getImage3(), $product->getId()));
        }

        return $savedProduct;
    }

    private function insertProduct($sql, $parameters)
    {
        $insertedProduct = null;

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $insertSuccess = $statement->execute($parameters);

            if ($insertSuccess == true) {
                $insertedProduct = $this->getProductByName($parameters[1]);
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- insertProduct($sql, $parameters) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $insertedProduct;
    }

    private function updateProduct($sql, $parameters)
    {
        $updatedProduct = null;

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $updateSuccess = $statement->execute($parameters);

            if ($updateSuccess == true) {
                $updatedProduct = $this->getProductByName($parameters[1]);
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- updateProduct($sql, $parameters) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $updatedProduct;
    }

    public function deleteProduct($id)
    {
        $deleteSuccess = false;

        // delete cartEntrys from the product

        $sql = "DELETE FROM products WHERE id=?";

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $deleteSuccess = $statement->execute(array($id));

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- deleteProduct($id) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $deleteSuccess;
    }

    public function getAvailableCountOfProduct($product)
    {
        $cartService = new CartService();

        $stockCount = $product->getStockCount();
        $productReservedCount = $cartService->getProductCountInCartByProductId($product->getId());

        return $stockCount - $productReservedCount;
    }

    public function getProductDatas()
    {
        $productDatas = array();

        $products = $this->getProducts();

        foreach ($products as $product) {
            array_push($productDatas, $this->getProductDataFromProduct($product));
        }

        return $productDatas;
    }

    public function getProductDatasBySearchData($productSearchData, $productSortOrderData)
    {
        $productDatas = array();

        $products = $this->getProductsBySearchData($productSearchData, $productSortOrderData);

        foreach ($products as $product) {
            array_push($productDatas, $this->getProductDataFromProduct($product));
        }

        return $productDatas;
    }

    public function getProductDatasByKeyword($keyword)
    {
        $productDatas = array();

        $tempProductDatas = $this->getProductDatas();

        foreach ($tempProductDatas as $productData) {
            $keywords = $productData->getKeywords();

            if (str_contains($keywords, $keyword)) {
                array_push($productDatas, $productData);
            }
        }

        return $productDatas;
    }

    public function getActiveProductDatas()
    {
        $productDatas = array();

        $products = $this->getProducts();

        foreach ($products as $product) {
            if ($product->getActive() == true) {
                array_push($productDatas, $this->getProductDataFromProduct($product));
            }
        }

        return $productDatas;
    }

    public function getActiveProductDatasBySearchData($productSearchData, $productSortOrderData)
    {
        $productDatas = array();

        $products = $this->getActiveProductsBySearchData($productSearchData, $productSortOrderData);

        foreach ($products as $product) {
            array_push($productDatas, $this->getProductDataFromProduct($product));
        }

        return $productDatas;
    }
    public function getActiveProductDatasByKeyword($keyword)
    {
        $productDatas = array();

        $tempProductDatas = $this->getActiveProductDatas();

        foreach ($tempProductDatas as $productData) {
            $keywords = $productData->getKeywords();

            if (str_contains($keywords, $keyword)) {
                array_push($productDatas, $productData);
            }
        }

        return $productDatas;
    }

    public function getProductDataFromProduct($product)
    {
        $productData = new ProductData();

        $cartService = new CartService();

        $productData->setId($product->getId());
        $productData->setIdentifier($product->getIdentifier());
        $productData->setName($product->getName());
        $productData->setDescription($product->getDescription());
        $productData->setKeywords($product->getKeywords());
        $productData->setStockCount($product->getStockCount());
        $productData->setReservedCount($cartService->getProductCountInCartByProductId($product->getId()));
        $productData->setRetailPrice($product->getRetailPrice());
        $productData->setActive($product->getActive());
        $productData->setImage1($product->getImage1());
        $productData->setImage2($product->getImage2());
        $productData->setImage3($product->getImage3());

        return $productData;
    }

    public function reduceStockCountFromProduct($orderEntry)
    {
        $product = $this->getProductById($orderEntry->getproduct()->getId());
        $product->setStockCount($product->getStockCount() - $orderEntry->getProductCount());
        $this->saveProduct($product);
    }
}
