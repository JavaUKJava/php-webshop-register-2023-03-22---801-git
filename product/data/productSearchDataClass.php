<?php

/**
 * ProductSearchData.
 * To transport the setting for search in the list of products to shwo in the frontend from backend to frontend.
 */
class ProductSearchData
{
    private $id = "";
    private $identifier = "";
    private $name = "";
    private $description = "";
    private $keywords = "";
    private $stockCount = "";
    private $reservedCount = "";
    private $accessibleCount = "";
    private $retailPrice = "";
    private $active = false;

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of identifier
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Set the value of identifier
     */
    public function setIdentifier($identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     */
    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     */
    public function setDescription($description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of keywords
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Set the value of keywords
     */
    public function setKeywords($keywords): self
    {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * Get the value of stockCount
     */
    public function getStockCount()
    {
        return $this->stockCount;
    }

    /**
     * Set the value of stockCount
     */
    public function setStockCount($stockCount): self
    {
        $this->stockCount = $stockCount;

        return $this;
    }

    /**
     * Get the value of reservedCount
     */
    public function getReservedCount()
    {
        return $this->reservedCount;
    }

    /**
     * Set the value of reservedCount
     */
    public function setReservedCount($reservedCount): self
    {
        $this->reservedCount = $reservedCount;

        return $this;
    }

    /**
     * Get the value of retailPrice
     */
    public function getRetailPrice()
    {
        return $this->retailPrice;
    }

    /**
     * Set the value of retailPrice
     */
    public function setRetailPrice($retailPrice): self
    {
        $this->retailPrice = $retailPrice;

        return $this;
    }

    /**
     * Get the value of active
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set the value of active
     */
    public function setActive($active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get the value of accessibleCount
     */
    public function getAccessibleCount()
    {
        return $this->accessibleCount;
    }

    /**
     * Set the value of accessibleCount
     */
    public function setAccessibleCount($accessibleCount): self
    {
        $this->accessibleCount = $accessibleCount;

        return $this;
    }
}
