<?php


/**
 * The data for a user to show in the session for the frontend.
 */
class UserData
{
    private $id;
    private $loginName;
    private $registrationTime;
    private $lastLoginTime;
    private $active;
    private $roles;

    public function __construct($id, $loginName, $registrationTime, $lastLoginTime, $active, $roles)
    {
        $this->id = $id;
        $this->loginName = $loginName;
        $this->registrationTime = $registrationTime;
        $this->lastLoginTime = $lastLoginTime;
        $this->active = $active;
        $this->roles = $roles;
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

    /**
     * Get the value of registrationTime
     */
    public function getRegistrationTime()
    {
        return $this->registrationTime;
    }

    /**
     * Set the value of registrationTime
     */
    public function setRegistrationTime($registrationTime): self
    {
        $this->registrationTime = $registrationTime;

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
     * Get the value of active
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set the value of active
     */
    public function setActive($active): self
    {
        $this->active = $active;

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
