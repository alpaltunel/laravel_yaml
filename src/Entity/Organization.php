<?php

namespace App\Entity;

class Organization
{
    public string $name;
    public string $description;
    public array $users;

    public function __construct($name = '', $description = '', $users = [])
    {
        $this->setName($name);
        $this->setDescription($description);
        $this->setUsers($users);
    }

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
     * @return string
     */
    public function getDescription() : string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description) : void
    {
        $this->description = $description;
    }

    /**
     * @return Users
     */
    public function getUsers() : array
    {
        return $this->users;
    }

    /**
     * @param Users $users
     */
    public function setUsers(array $users) : void
    {
        $this->users = $users;
    }

}