<?php

namespace App\Entity;

class Users
{
    public string $name;
    public array $role;
    public string $password;

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name) : void
    {
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function getRole() : array
    {
        return $this->role;
    }

    /**
     * @param array $role
     */
    public function setRole(array $role) : void
    {
        $this->role = $role;
    }

    /**
     * @return string
     */
    public function getPassword() : string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password) : void
    {
        $this->password = $password;
    }
}