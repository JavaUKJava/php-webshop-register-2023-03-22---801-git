<?php

/**
 * Order with entrys for all buyed objects.
 */
class Order
{
    private $id;
    private $invoice;
    private $invoiceAddress;
    private $deliveryAddress;
    private $date;
    private $status;
    private $deliveryOption;
    private $paymentOption;
    private $orderEntrys;

    public function __construct($id, $invoice, $invoiceAddress, $deliveryAddress, $date, $status, $deliveryOption, $paymentOption, $orderEntrys)
    {
        $this->id = $id;
        $this->invoice = $invoice;
        $this->invoiceAddress = $invoiceAddress;
        $this->deliveryAddress = $deliveryAddress;
        $this->date = $date;
        $this->status = $status;
        $this->deliveryOption = $deliveryOption;
        $this->paymentOption = $paymentOption;
        $this->orderEntrys = $orderEntrys;
    }

    public function getPriceTotal() {
        $priceTotal = 0.0;

        if ($this->orderEntrys != null) {
            foreach ($this->orderEntrys as $orderEntry) {
                $priceTotal += (float)((float)$orderEntry->getPurchasePrice() * (float)$orderEntry->getProductCount());
            }
        }

        return $priceTotal;
    }

    public function getProductCount() {
        $productCount = 0;

        if ($this->orderEntrys != null) {
            $productCount = count($this->orderEntrys);
        }

        return $productCount;
    }
    
    public function addOrderEntry($orderEntry) {
        if (!in_array($orderEntry, $this->orderEntrys, true)) {
            array_push($this->orderEntrys, $orderEntry);
            return true;
        }

        return false;
    }

    public function removeOrderEntry($orderEntry) {
        if (in_array($orderEntry, $this->orderEntrys, true)) {
            $key = array_search($orderEntry, $this->orderEntrys, true);

            if ($key !== false) {
                unset($this->orderEntrys[$key]);
            }
            
            return true;
        }

        return false;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     */
    public function setStatus($status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of orderEntrys
     */
    public function getOrderEntrys()
    {
        return $this->orderEntrys;
    }

    /**
     * Set the value of orderEntrys
     */
    public function setOrderEntrys($orderEntrys): self
    {
        $this->orderEntrys = $orderEntrys;

        return $this;
    }

    /**
     * Get the value of invoiceAddress
     */
    public function getInvoiceAddress()
    {
        return $this->invoiceAddress;
    }

    /**
     * Set the value of invoiceAddress
     */
    public function setInvoiceAddress($invoiceAddress): self
    {
        $this->invoiceAddress = $invoiceAddress;

        return $this;
    }

    /**
     * Get the value of deliveryAddress
     */
    public function getDeliveryAddress()
    {
        return $this->deliveryAddress;
    }

    /**
     * Set the value of deliveryAddress
     */
    public function setDeliveryAddress($deliveryAddress): self
    {
        $this->deliveryAddress = $deliveryAddress;

        return $this;
    }

    /**
     * Get the value of invoice
     */
    public function getInvoice()
    {
        return $this->invoice;
    }

    /**
     * Set the value of invoice
     */
    public function setInvoice($invoice): self
    {
        $this->invoice = $invoice;

        return $this;
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
     * Get the value of deliveryOption
     */
    public function getDeliveryOption()
    {
        return $this->deliveryOption;
    }

    /**
     * Get the value of paymentOption
     */
    public function getPaymentOption()
    {
        return $this->paymentOption;
    }

    /**
     * Set the value of paymentOption
     */
    public function setPaymentOption($paymentOption): self
    {
        $this->paymentOption = $paymentOption;

        return $this;
    }


    /**
     * Set the value of deliveryOption
     */
    public function setDeliveryOption($deliveryOption): self
    {
        $this->deliveryOption = $deliveryOption;

        return $this;
    }
}
