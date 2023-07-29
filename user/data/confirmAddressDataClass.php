<?php

/**
 * ConfirmAddressData.
 * Used as a box for the Data from the backend to show a address.
 */
class ConfirmAddressData {
    private $id = -1;
    private $salutation = "";
    private $titleBeforeName = "";
    private $firstName = "";
    private $lastName = "";
    private $titleAfterName = "";
    private $phoneNumber = "";
    private $email = "";
    private $country = "";
    private $postalCode = "";
    private $location = "";
    private $addressLine1 = "";
    private $addressLine2 = "";
    private $vatId = "";         // Steuernummer

    public function __construct($id, $salutation, $titleBeforeName, $firstName, $lastName, $titleAfterName, $phoneNumber, $email, $country, $postalCode, $location, $addressLine1, $addressLine2, $vatId) {
        $this->id = $id;
        $this->salutation = $salutation;
        $this->titleBeforeName = $titleBeforeName;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->titleAfterName = $titleAfterName;
        $this->phoneNumber = $phoneNumber;
        $this->email = $email;
        $this->country = $country;
        $this->postalCode = $postalCode;
        $this->location = $location;
        $this->addressLine1 = $addressLine1;
        $this->addressLine2 = $addressLine2;
        $this->vatId = $vatId;
    }

    /**
     * Get the value of titleBeforeName
     */
    public function getTitleBeforeName()
    {
        return $this->titleBeforeName;
    }

    /**
     * Get the value of firstName
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Get the value of lastName
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Get the value of titleAfterName
     */
    public function getTitleAfterName()
    {
        return $this->titleAfterName;
    }

    /**
     * Get the value of phoneNumber
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the value of postalCode
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Get the value of location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Get the value of addressLine1
     */
    public function getAddressLine1()
    {
        return $this->addressLine1;
    }

    /**
     * Get the value of addressLine2
     */
    public function getAddressLine2()
    {
        return $this->addressLine2;
    }

    /**
     * Get the value of vatId
     */
    public function getVatId()
    {
        return $this->vatId;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of salutation
     */
    public function getSalutation()
    {
        return $this->salutation;
    }

    /**
     * Get the value of country
     */
    public function getCountry()
    {
        return $this->country;
    }
}