<?php


class Permissions
{
    const WritePost = 1;
    const ReadPosts = 2;
    const DeletePosts = 4;
    const AddUser = 8;
    const DeleteUser = 16;
    
    public $administrator;
    public $moderator;
    public $writer;
    public $guest;
    
    public function __construct()
    {
        $this->setGroups();
    }
    
    /**
     * Setuje práva
     */
    public function setGroups(){
        // User groups:
        $this->administrator = self::WritePost | self::ReadPosts |  self::DeletePosts |  self::AddUser |  self::DeleteUser;
        $this->moderator = self::ReadPosts | self::DeletePosts |  self::DeleteUser;
        $this->writer = self::WritePost | self::ReadPosts;
        $this->guest =  self::ReadPosts;
    
    }
    
    /**
     * Vraci jestli daný uživatel má práva na danou akci
     * @param int $user
     * @param int $permission
     * @return bool
     */
    public function checkPermission(int $user, int $permission) : bool
    {
        return $user & $permission;
    }

}