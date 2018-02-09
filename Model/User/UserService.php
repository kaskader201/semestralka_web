<?php


class UserService implements iUser
{
    private $userDAO;
    
    public function __construct()
    {
        $this->userDAO = new UserDAO();
    }
    
    public function save(User $user)
    {
        return $this->userDAO->save($user);
    }
    
    public function delete(User $user)
    {
    
    }
   
}