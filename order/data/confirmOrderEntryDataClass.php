<?php

/**
 * A Entry for a Order for a user to send to frontend for show.
 */
class ConfirmOrderEntryData
{
    private $id;
	private $product;
    private $purchasePrice;
    private $productCount;

    public function __construct($id, $product, $purchasePrice, $productCount)
    {
        $this->id = $id;
        $this->product = $product;
        $this->purchasePrice = $purchasePrice;
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
     * Get the value of purchasePrice
     */
    public function getPurchasePrice()
    {
        return $this->purchasePrice;
    }

    /**
     * Get the value of productCount
     */
    public function getProductCount()
    {
        return $this->productCount;
    }

	/**
	 * Get the value of product
	 */
	public function getProduct()
	{
		return $this->product;
	}
}