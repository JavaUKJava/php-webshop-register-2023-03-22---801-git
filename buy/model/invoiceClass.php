<?php

/**
 * The invoice for a order.
 */
class Invoice{
    private $id;
    private $number;
    private $date;
    private $status;

    public function __construct($id, $number, $date, $status) {
        $this->id = $id;
        $this->number = $number;
        $this->date = $date;
        $this->status = $status;
    }


    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of number
     */
    public function getNumber()
    {
        return $this->number;
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
}