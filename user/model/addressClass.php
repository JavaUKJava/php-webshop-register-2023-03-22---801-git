<?php

/**
 * The address for a user or for the destination of a delivery.
 */
class Address
{
    private $id;
    private $salutation;
    private $titleBeforeName;
    private $firstName;
    private $lastName;
    private $titleAfterName;
    private $phoneNumber;
    private $email;
    private $country;
    private $postalCode;
    private $location;
    private $addressLine1;
    private $addressLine2;
    private $vatId;         // Steuernummer

    public function __construct($id, $salutation, $titleBeforeName, $firstName, $lastName, $titleAfterName, $phoneNumber, $email, $country, $postalCode, $location, $addressLine1, $addressLine2, $vatId)
    {
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
     * Set the value of salutation
     */
    public function setSalutation($salutation): self
    {
        $this->salutation = $salutation;

        return $this;
    }

    /**
     * Get the value of titleBeforeName
     */
    public function getTitleBeforeName()
    {
        return $this->titleBeforeName;
    }

    /**
     * Set the value of titleBeforeName
     */
    public function setTitleBeforeName($titleBeforeName): self
    {
        $this->titleBeforeName = $titleBeforeName;

        return $this;
    }

    /**
     * Get the value of firstName
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set the value of firstName
     */
    public function setFirstName($firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get the value of lastName
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set the value of lastName
     */
    public function setLastName($lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get the value of titleAfterName
     */
    public function getTitleAfterName()
    {
        return $this->titleAfterName;
    }

    /**
     * Set the value of titleAfterName
     */
    public function setTitleAfterName($titleAfterName): self
    {
        $this->titleAfterName = $titleAfterName;

        return $this;
    }

    /**
     * Get the value of phoneNumber
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set the value of phoneNumber
     */
    public function setPhoneNumber($phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set the value of country
     */
    public function setCountry($country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get the value of postalCode
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Set the value of postalCode
     */
    public function setPostalCode($postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Get the value of location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set the value of location
     */
    public function setLocation($location): self
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get the value of addressLine1
     */
    public function getAddressLine1()
    {
        return $this->addressLine1;
    }

    /**
     * Set the value of addressLine1
     */
    public function setAddressLine1($addressLine1): self
    {
        $this->addressLine1 = $addressLine1;

        return $this;
    }

    /**
     * Get the value of addressLine2
     */
    public function getAddressLine2()
    {
        return $this->addressLine2;
    }

    /**
     * Set the value of addressLine2
     */
    public function setAddressLine2($addressLine2): self
    {
        $this->addressLine2 = $addressLine2;

        return $this;
    }

    /**
     * Get the value of vatId
     */
    public function getVatId()
    {
        return $this->vatId;
    }

    /**
     * Set the value of vatId
     */
    public function setVatId($vatId): self
    {
        $this->vatId = $vatId;

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
}
