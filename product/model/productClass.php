<?php

/**
 * A product in the shop.
 */
class Product
{
    private $id;
    private $identifier;
    private $name;
    private $description;
    private $keywords;
    private $stockCount;
    private $retailPrice;
    private $active;
    private $image1;
    private $image2;
    private $image3;

    public function __construct($id, $identifier, $name, $description, $keywords, $stockCount, $retailPrice, $active, $image1, $image2, $image3)
    {
        $this->id = $id;
        $this->identifier = $identifier;
        $this->name = $name;
        $this->description = $description;
        $this->keywords = $keywords;
        $this->stockCount = $stockCount;
        $this->retailPrice = $retailPrice;
        $this->active = $active;
        $this->image1 = $image1;
        $this->image2 = $image2;
        $this->image3 = $image3;
    }
    
    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
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
     * Get the value of image1
     */
    public function getImage1()
    {
        return $this->image1;
    }

    /**
     * Set the value of image1
     */
    public function setImage1($image1): self
    {
        $this->image1 = $image1;

        return $this;
    }

    /**
     * Get the value of image2
     */
    public function getImage2()
    {
        return $this->image2;
    }

    /**
     * Set the value of image2
     */
    public function setImage2($image2): self
    {
        $this->image2 = $image2;

        return $this;
    }

    /**
     * Get the value of image3
     */
    public function getImage3()
    {
        return $this->image3;
    }

    /**
     * Set the value of image3
     */
    public function setImage3($image3): self
    {
        $this->image3 = $image3;

        return $this;
    }
}
