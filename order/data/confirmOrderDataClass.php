<?php

/**
 * ConfirmOrderData.
 * Data from a order to send to frontend for showing confirm oder data.
 */
class ConfirmOrderData
{
    private $id;
    private $invoiceConfirmAddressData;
    private $deliveryConfirmAddressData;
    private $paymentOptionData;
    private $confirmOrderEntrysData;

    public function __construct($id, $invoiceConfirmAddressData, $deliveryConfirmAddressData, $paymentOptionData, $confirmOrderEntrysData)
    {
        $this->id = $id;
        $this->invoiceConfirmAddressData = $invoiceConfirmAddressData;
        $this->deliveryConfirmAddressData = $deliveryConfirmAddressData;
        $this->paymentOptionData = $paymentOptionData;
        $this->confirmOrderEntrysData = $confirmOrderEntrysData;
    }

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
     * Get the value of paymentOptionData
     */
    public function getPaymentOptionData()
    {
        return $this->paymentOptionData;
    }

    /**
     * Set the value of paymentOptionData
     */
    public function setPaymentOptionData($paymentOptionData): self
    {
        $this->paymentOptionData = $paymentOptionData;

        return $this;
    }

    /**
     * Get the value of invoiceConfirmAddressData
     */
    public function getInvoiceConfirmAddressData()
    {
        return $this->invoiceConfirmAddressData;
    }

    /**
     * Set the value of invoiceConfirmAddressData
     */
    public function setInvoiceConfirmAddressData($invoiceConfirmAddressData): self
    {
        $this->invoiceConfirmAddressData = $invoiceConfirmAddressData;

        return $this;
    }

    /**
     * Get the value of deliveryConfirmAddressData
     */
    public function getDeliveryConfirmAddressData()
    {
        return $this->deliveryConfirmAddressData;
    }

    /**
     * Set the value of deliveryConfirmAddressData
     */
    public function setDeliveryConfirmAddressData($deliveryConfirmAddressData): self
    {
        $this->deliveryConfirmAddressData = $deliveryConfirmAddressData;

        return $this;
    }

    /**
     * Get the value of confirmOrderEntrysData
     */
    public function getConfirmOrderEntrysData()
    {
        return $this->confirmOrderEntrysData;
    }

    /**
     * Set the value of confirmOrderEntrysData
     */
    public function setConfirmOrderEntrysData($confirmOrderEntrysData): self
    {
        $this->confirmOrderEntrysData = $confirmOrderEntrysData;

        return $this;
    }
}