<?php

/**
 * A role for a user with a array of permissions in it.
 */
class Role
{
    private $id;
    private $name;
    private $permissions;

    public function __construct($id, $name, $permissions)
    {

        $this->id = $id;
        $this->name = $name;
        $this->permissions = $permissions;
    }

    public function addPermission($permission)
    {
        if (!in_array($permission, $this->permissions, true)) {
            array_push($this->permissions, $permission);
            return true;
        }

        return false;
    }

    public function removePermission($permission)
    {
        $key = array_search($permission, $this->permissions, true);
        if ($key !== false) {
            unset($this->permissions[$key]);
            return true;
        }

        return false;
    }

    /**
     * Get the value of id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the value of permissions
     *
     * @return array
     */
    public function getPermissions()
    {
        return $this->permissions;
    }
}
