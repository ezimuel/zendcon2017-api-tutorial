<?php
namespace Book\Entity;

class UserEntity
{
    /**
     * @var string Unique identifier of the user; UUIDv4 value.
     */
    public $id;

    /**
     * @var string Username
     */
    public $username;

    /**
     * @var string Role of the user
     */
    public $role;
}
