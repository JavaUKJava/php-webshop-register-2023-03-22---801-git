<?php

/**
 * Service for all work with buy the products.
 */
class BuyService extends DatabaseService
{
    public function editStockCountAfterBuyProduct($cartEntry) {
        $productService = new ProductService();

        $product = $cartEntry->getProduct();
        $stockCount = $product->getStockCount();
        $productCount = $cartEntry->getProductCount();

        $product->setStockCount($stockCount - $productCount);
        $productService->saveProduct($product);
    }

    public function getInvoiceById($id) {
        return null;
    }
}