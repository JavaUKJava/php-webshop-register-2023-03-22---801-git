<?php

/**
 * CreateAddressData.
 * Used as a box for the Data from the frontend by create a new address.
 * To send the data for test for all inputs and send back to the frontend if any data does not work.
 */
class CreateAddressData {
    private $id = -1;
    private $salutationId = -1;
    private $titleBeforeName = "";
    private $firstName = "";
    private $lastName = "";
    private $titleAfterName = "";
    private $phoneNumber = "";
    private $email = "";
    private $countryId = -1;
    private $postalCode = "";
    private $location = "";
    private $addressLine1 = "";
    private $addressLine2 = "";
    private $vatId = "";         // Steuernummer

    public function __construct($id, $salutationId, $titleBeforeName, $firstName, $lastName, $titleAfterName, $phoneNumber, $email, $countryId, $postalCode, $location, $addressLine1, $addressLine2, $vatId) {
        $this->id = $id;
        $this->salutationId = $salutationId;
        $this->titleBeforeName = $titleBeforeName;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->titleAfterName = $titleAfterName;
        $this->phoneNumber = $phoneNumber;
        $this->email = $email;
        $this->countryId = $countryId;
        $this->postalCode = $postalCode;
        $this->location = $location;
        $this->addressLine1 = $addressLine1;
        $this->addressLine2 = $addressLine2;
        $this->vatId = $vatId;
    }

    /**
     * Get the value of salutationId
     */
    public function getSalutationId()
    {
        return $this->salutationId;
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
     * Get the value of countryId
     */
    public function getCountryId()
    {
        return $this->countryId;
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
}