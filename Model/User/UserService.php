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
        return $this->userDAO->delete($user);
    }
    
    public function getAllUsers()
    {
        $users = [];
        foreach ($this->userDAO->getAllUsers() as $dbUser) {
            $user = (new User())
                ->setId($dbUser['id'])
                ->setPermission($dbUser['permission'])
                ->setPassword($dbUser['password'])
                ->setEmail($dbUser['email'])
                ->setSalt($dbUser['salt'])
                ->setToken($dbUser['token'])
                ->setFirstname($dbUser['firstname'])
                ->setLastname($dbUser['lastname']);
            $users[] = $user;
        }
        return $users;
    }
}