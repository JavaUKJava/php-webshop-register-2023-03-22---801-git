<?php


/**
 * A user with roles and permissions for the system (as customer or als admin).
 */
class User
{
    private $id;
    private $loginName;
    private $salutation;
    private $titleBeforeName;
    private $firstName;
    private $lastName;
    private $titleAfterName;
    private $phoneNumber;
    private $email;
    private $orderInProgress;
    private $password;
    private $registrationTime;
    private $lastLoginTime;
    private $active;
    private $roles;

    public function __construct($id, $loginName, $salutation, $titleBeforeName, $firstName, $lastName, $titleAfterName, $phoneNumber, $email, $orderInProgress, $password, $registrationTime, $lastLoginTime, $active, $roles)
    {
        $this->id = $id;
        $this->loginName = $loginName;
        $this->salutation = $salutation;
        $this->titleBeforeName = $titleBeforeName;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->titleAfterName = $titleAfterName;
        $this->phoneNumber = $phoneNumber;
        $this->email = $email;
        $this->orderInProgress = $orderInProgress;
        $this->password = $password;
        $this->registrationTime = $registrationTime;
        $this->lastLoginTime = $lastLoginTime;
        $this->active = $active;
        $this->roles = $roles;
    }

    public function isPermission(string $permissionName)
    {
        $isPermission = false;

        foreach ($this->roles as $role) {
            foreach ($role->getPermissions() as $permission) {
                if (str_contains($permissionName, $permission->getName())) {
                    $isPermission = true;
                    break;
                }

                if ($isPermission == true) {
                    break;
                }
            }
        }

        return $isPermission;
    }

    public function isRole(string $roleName)
    {
        $isRole = false;

        foreach ($this->roles as $role) {
            if ($role->getName() == $roleName) {
                $isRole = true;
                break;
            }
        }

        return $isRole;
    }

    public function addRole($role)
    {
        if (!in_array($role, $this->roles, true)) {
            array_push($this->roles, $role);
            return true;
        }

        return false;
    }

    public function removeRole($role)
    {
        $key = array_search($role, $this->roles, true);

        if ($key !== false) {
            unset($this->roles[$key]);
            return true;
        }

        return false;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     */
    public function setPassword($password): self
    {
        $this->password = $password;

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
     * Get the value of orderInProgress
     */
    public function getOrderInProgress()
    {
        return $this->orderInProgress;
    }

    /**
     * Set the value of orderInProgress
     */
    public function setOrderInProgress($orderInProgress): self
    {
        $this->orderInProgress = $orderInProgress;

        return $this;
    }
}
