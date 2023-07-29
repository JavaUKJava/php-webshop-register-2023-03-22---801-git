<?php

/**
 * ProductSortOrderData.
 * To transport the setting for sort order in the list of products to show in the frontend from backend to frontend.
 */
class ProductSortOrderData
{
    private $idUp = false;
    private $idDown = false;
    private $identifierUp = false;
    private $identifierDown = false;
    private $nameUp = false;
    private $nameDown = false;
    private $descriptionUp = false;
    private $descriptionDown = false;
    private $keywordsUp = false;
    private $keywordsDown = false;
    private $stockCountUp = false;
    private $stockCountDown = false;
    private $reservedCountUp = false;
    private $reservedCountDown = false;
    private $accessibleCountUp = false;
    private $accessibleCountDown = false;
    private $retailPriceUp = false;
    private $retailPriceDown = false;
    private $activeUp = false;
    private $activeDown = false;

    /**
     * Get the value of idUp
     */
    public function getIdUp()
    {
        return $this->idUp;
    }

    /**
     * Set the value of idUp
     */
    public function setIdUp($idUp): self
    {
        $this->idUp = $idUp;

        return $this;
    }

    /**
     * Get the value of idDown
     */
    public function getIdDown()
    {
        return $this->idDown;
    }

    /**
     * Set the value of idDown
     */
    public function setIdDown($idDown): self
    {
        $this->idDown = $idDown;

        return $this;
    }

    /**
     * Get the value of identifierUp
     */
    public function getIdentifierUp()
    {
        return $this->identifierUp;
    }

    /**
     * Set the value of identifierUp
     */
    public function setIdentifierUp($identifierUp): self
    {
        $this->identifierUp = $identifierUp;

        return $this;
    }

    /**
     * Get the value of identifierDown
     */
    public function getIdentifierDown()
    {
        return $this->identifierDown;
    }

    /**
     * Set the value of identifierDown
     */
    public function setIdentifierDown($identifierDown): self
    {
        $this->identifierDown = $identifierDown;

        return $this;
    }

    /**
     * Get the value of nameUp
     */
    public function getNameUp()
    {
        return $this->nameUp;
    }

    /**
     * Set the value of nameUp
     */
    public function setNameUp($nameUp): self
    {
        $this->nameUp = $nameUp;

        return $this;
    }

    /**
     * Get the value of nameDown
     */
    public function getNameDown()
    {
        return $this->nameDown;
    }

    /**
     * Set the value of nameDown
     */
    public function setNameDown($nameDown): self
    {
        $this->nameDown = $nameDown;

        return $this;
    }

    /**
     * Get the value of descriptionUp
     */
    public function getDescriptionUp()
    {
        return $this->descriptionUp;
    }

    /**
     * Set the value of descriptionUp
     */
    public function setDescriptionUp($descriptionUp): self
    {
        $this->descriptionUp = $descriptionUp;

        return $this;
    }

    /**
     * Get the value of descriptionDown
     */
    public function getDescriptionDown()
    {
        return $this->descriptionDown;
    }

    /**
     * Set the value of descriptionDown
     */
    public function setDescriptionDown($descriptionDown): self
    {
        $this->descriptionDown = $descriptionDown;

        return $this;
    }

    /**
     * Get the value of keywordsUp
     */
    public function getKeywordsUp()
    {
        return $this->keywordsUp;
    }

    /**
     * Set the value of keywordsUp
     */
    public function setKeywordsUp($keywordsUp): self
    {
        $this->keywordsUp = $keywordsUp;

        return $this;
    }

    /**
     * Get the value of keywordsDown
     */
    public function getKeywordsDown()
    {
        return $this->keywordsDown;
    }

    /**
     * Set the value of keywordsDown
     */
    public function setKeywordsDown($keywordsDown): self
    {
        $this->keywordsDown = $keywordsDown;

        return $this;
    }

    /**
     * Get the value of stockCountUp
     */
    public function getStockCountUp()
    {
        return $this->stockCountUp;
    }

    /**
     * Set the value of stockCountUp
     */
    public function setStockCountUp($stockCountUp): self
    {
        $this->stockCountUp = $stockCountUp;

        return $this;
    }

    /**
     * Get the value of stockCountDown
     */
    public function getStockCountDown()
    {
        return $this->stockCountDown;
    }

    /**
     * Set the value of stockCountDown
     */
    public function setStockCountDown($stockCountDown): self
    {
        $this->stockCountDown = $stockCountDown;

        return $this;
    }

    /**
     * Get the value of reservedCountUp
     */
    public function getReservedCountUp()
    {
        return $this->reservedCountUp;
    }

    /**
     * Set the value of reservedCountUp
     */
    public function setReservedCountUp($reservedCountUp): self
    {
        $this->reservedCountUp = $reservedCountUp;

        return $this;
    }

    /**
     * Get the value of reservedCountDown
     */
    public function getReservedCountDown()
    {
        return $this->reservedCountDown;
    }

    /**
     * Set the value of reservedCountDown
     */
    public function setReservedCountDown($reservedCountDown): self
    {
        $this->reservedCountDown = $reservedCountDown;

        return $this;
    }

    /**
     * Get the value of accessibleCountUp
     */
    public function getAccessibleCountUp()
    {
        return $this->accessibleCountUp;
    }

    /**
     * Set the value of accessibleCountUp
     */
    public function setAccessibleCountUp($accessibleCountUp): self
    {
        $this->accessibleCountUp = $accessibleCountUp;

        return $this;
    }

    /**
     * Get the value of accessibleCountDown
     */
    public function getAccessibleCountDown()
    {
        return $this->accessibleCountDown;
    }

    /**
     * Set the value of accessibleCountDown
     */
    public function setAccessibleCountDown($accessibleCountDown): self
    {
        $this->accessibleCountDown = $accessibleCountDown;

        return $this;
    }

    /**
     * Get the value of retailPriceUp
     */
    public function getRetailPriceUp()
    {
        return $this->retailPriceUp;
    }

    /**
     * Set the value of retailPriceUp
     */
    public function setRetailPriceUp($retailPriceUp): self
    {
        $this->retailPriceUp = $retailPriceUp;

        return $this;
    }

    /**
     * Get the value of retailPriceDown
     */
    public function getRetailPriceDown()
    {
        return $this->retailPriceDown;
    }

    /**
     * Set the value of retailPriceDown
     */
    public function setRetailPriceDown($retailPriceDown): self
    {
        $this->retailPriceDown = $retailPriceDown;

        return $this;
    }

    /**
     * Get the value of activeUp
     */
    public function getActiveUp()
    {
        return $this->activeUp;
    }

    /**
     * Set the value of activeUp
     */
    public function setActiveUp($activeUp): self
    {
        $this->activeUp = $activeUp;

        return $this;
    }

    /**
     * Get the value of activeDown
     */
    public function getActiveDown()
    {
        return $this->activeDown;
    }

    /**
     * Set the value of activeDown
     */
    public function setActiveDown($activeDown): self
    {
        $this->activeDown = $activeDown;

        return $this;
    }
}
