<?php

/**
 * CreateUserData.
 * Used as a box for the Data from the frontend by register or create a new User.
 * To send the data for test for all inputs and send back to the frontend if any data does not work.
 */
class CreateUserData {
    private $loginName = "";
    private $salutationId = -1;
    private $titleBeforeName = "";
    private $firstName = "";
    private $lastName = "";
    private $titleAfterName = "";
    private $phoneNumber = "";
    private $email = "";
    private $password = "";
    private $passwordRepeat = "";

    public function __construct($loginName, $salutationId, $titleBeforeName, $firstName, $lastName, $titleAfterName, $phoneNumber, $email, $password, $passwordRepeat)
    {
        $this->loginName = $loginName;
        $this->salutationId = $salutationId;
        $this->titleBeforeName = $titleBeforeName;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->titleAfterName = $titleAfterName;
        $this->phoneNumber = $phoneNumber;
        $this->email = $email;
        $this->password = $password;
        $this->passwordRepeat = $passwordRepeat;
    }

    /**
     * Get the value of loginName
     */
    public function getLoginName()
    {
        return $this->loginName;
    }

    /**
     * Get the value of salutationId
     */
    public function getSalutationId()
    {
        return $this->salutationId;
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
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get the value of passwordRepeat
     */
    public function getPasswordRepeat()
    {
        return $this->passwordRepeat;
    }

    /**
     * Get the value of titleBeforeName
     */
    public function getTitleBeforeName()
    {
        return $this->titleBeforeName;
    }

    /**
     * Get the value of titleAfterName
     */
    public function getTitleAfterName()
    {
        return $this->titleAfterName;
    }
}