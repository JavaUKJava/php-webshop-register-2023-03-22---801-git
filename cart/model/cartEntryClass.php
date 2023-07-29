<?php

/**
 * A cartEntry in the shop.
 */
class CartEntry
{
    private $id;
    private $user;
    private $product;
    private $productCount;

    public function __construct($id, $user, $product, $productCount)
    {
        $this->id = $id;
        $this->user = $user;
        $this->product = $product;
        $this->productCount = $productCount;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Get the value of product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Get the value of productCount
     */
    public function getProductCount()
    {
        return $this->productCount;
    }

    /**
     * Set the value of productCount
     */
    public function setProductCount($productCount): self
    {
        $this->productCount = $productCount;

        return $this;
    }

}