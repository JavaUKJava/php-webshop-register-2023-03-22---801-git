<?php

/**
 * OverviewOrderDataClass.
 * Transport box for order data to send to frontend and show in a list of orders.
 */
class OverviewOrderData
{
    private $id;
    private $loginName;
    private $compactInvoiceAddress;
    private $compactDeliveryAddress;
    private $date;
    private $status;
    private $deliveryOption;
    private $paymentOption;
    private $invoiceStatus;
    private $orderEntrysCount;

    public function __construct($id, $loginName, $compactInvoiceAddress, $compactDeliveryAddress, $date, $status, $deliveryOption, $paymentOption, $invoiceStatus, $orderEntrysCount)
    {
        $this->id = $id;
        $this->loginName = $loginName;
        $this->compactInvoiceAddress = $compactInvoiceAddress;
        $this->compactDeliveryAddress = $compactDeliveryAddress;
        $this->date = $date;
        $this->status = $status;
        $this->deliveryOption = $deliveryOption;
        $this->paymentOption = $paymentOption;
        $this->invoiceStatus = $invoiceStatus;
        $this->orderEntrysCount = $orderEntrysCount;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of loginName
     */
    public function getLoginName()
    {
        return $this->loginName;
    }

    /**
     * Get the value of compactInvoiceAddress
     */
    public function getCompactInvoiceAddress()
    {
        return $this->compactInvoiceAddress;
    }

    /**
     * Get the value of compactDeliveryAddress
     */
    public function getCompactDeliveryAddress()
    {
        return $this->compactDeliveryAddress;
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
     * Get the value of invoiceStatus
     */
    public function getInvoiceStatus()
    {
        return $this->invoiceStatus;
    }

    /**
     * Get the value of orderEntrysCount
     */
    public function getOrderEntrysCount()
    {
        return $this->orderEntrysCount;
    }
}