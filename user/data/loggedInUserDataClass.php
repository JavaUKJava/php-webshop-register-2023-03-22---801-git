<?php


/**
 * The data for a logged in user to show in the session for the frontend.
 */
class LoggedInUserData
{
    private $id;
    private $loginName;
    private	$lastLoginTime;
    private $roles;
    private $cartEntrysCount;

    public function __construct($id, $loginName, $lastLoginTime, $roles, $cartEntrysCount)
    {
        $this->id = $id;
        $this->loginName = $loginName;
        $this->lastLoginTime = $lastLoginTime;
        $this->roles = $roles;
        $this->cartEntrysCount = $cartEntrysCount;
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
     * Get the value of lastLoginTime
     */
    public function getLastLoginTime()
    {
        return $this->lastLoginTime;
    }

    /**
     * Set the value of lastLoginTime
     */
    public function setLastLoginTime($lastLoginTime): self
    {
        $this->lastLoginTime = $lastLoginTime;

        return $this;
    }

    /**
     * Get the value of cartEntrysCount
     */
    public function getCartEntrysCount()
    {
        return $this->cartEntrysCount;
    }

    /**
     * Set the value of cartEntrysCount
     */
    public function setCartEntrysCount($cartEntrysCount): self
    {
        $this->cartEntrysCount = $cartEntrysCount;

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

    /**
     * Get the value of roles
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set the value of roles
     */
    public function setRoles($roles): self
    {
        $this->roles = $roles;

        return $this;
    }
}


