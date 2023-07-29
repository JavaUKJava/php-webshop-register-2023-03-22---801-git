<?php

/**
 * EditOwnUserData.
 * The data for a user to edit his own account.
 */
class EditOwnUserData
{
    private $id;
    private $loginName;

    public function __construct($id, $loginName)
    {
        $this->id = $id;
        $this->loginName = $loginName;
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
     * Get the value of loginName
     */
    public function getLoginName()
    {
        return $this->loginName;
    }

    /**
     * Set the value of loginName
     */
    public function setLoginName($loginName): self
    {
        $this->loginName = $loginName;

        return $this;
    }

}