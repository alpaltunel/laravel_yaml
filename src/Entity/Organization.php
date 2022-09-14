<?php

namespace App\Entity;

class Organization
{
    protected string $name;
    protected string $description;
    protected Users $users;

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
    public function getUsers() : Users
    {
        return $this->users;
    }

    /**
     * @param Users $users
     */
    public function setUsers(Users $users) : void
    {
        $this->users = $users;
    }

}