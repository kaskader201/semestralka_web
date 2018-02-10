<?php


class UserService implements iUser
{
    /**
     * @var UserDAO
     */
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
    
    public function getById(int $userId)
    {
        $user = $this->userDAO->getById($userId);
        if($user){
            return $this->setUserData($user);
        }
        return false;
    }
    
    public function getByEmail(string $userEmail)
    {
        $user = $this->userDAO->getByEmail($userEmail);
        if($user){
            return $this->setUserData($user);
        }
        return false;
    }
    
    public function getAllUsers()
    {
        $users = [];
        $resultUsers = $this->userDAO->getAllUsers();
        foreach ($resultUsers as $dbUser) {
            $user = $this->setUserData($dbUser);
            $users[] = $user;
            
        }
        
        return $users;
    }
    
    private function setUserData(array $dbUser)
    {
        return (new User())
            ->setId($dbUser['id'])
            ->setPermission((bool) $dbUser['permission'])
            ->setActive((bool) $dbUser['active'])
            ->setPassword($dbUser['password'])
            ->setTel($dbUser['tel'])
            ->setEmail($dbUser['email'])
            ->setToken($dbUser['token'])
            ->setFirstname($dbUser['firstname'])
            ->setLastname($dbUser['lastname']);
    }
}