<?php

/**
 * userPersonalData.
 * The data for a user who list more then his account data.
 */
class userPersonalData{
    private $id;
    private $salutation;
    private $title;
    private $firstName;
    private $lastName;
    private $phoneNumber;
    private $email;
    private $adresses;

    public function __construct($id, $salutation, $title, $firstName, $lastName, $phoneNumber, $email, $adresses)
    {
        $this->id = $id;
        $this->salutation = $salutation;
        $this->title = $title;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phoneNumber = $phoneNumber;
        $this->email = $email;
        $this->adresses = $adresses;
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
     * Get the value of title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     */
    public function setTitle($title): self
    {
        $this->title = $title;

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
     * Get the value of adresses
     */
    public function getAdresses()
    {
        return $this->adresses;
    }

    /**
     * Set the value of adresses
     */
    public function setAdresses($adresses): self
    {
        $this->adresses = $adresses;

        return $this;
    }
}