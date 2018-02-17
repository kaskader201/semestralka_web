<?php

/**
 * Stará se o přípravu dat pro DAO
 * Class UserService
 */
class UserService
{
    /**
     * Instance User DAO
     * @var UserDAO
     */
    private $userDAO;
    
    /**
     * UserService constructor.
     */
    public function __construct()
    {
        $this->userDAO = new UserDAO();
    }
    
    /**
     * Ukládání uživatele do db (insert|ubdate)
     * @param User $user
     * @return int|mixed
     */
    public function save(User $user)
    {
        return $this->userDAO->save($user);
    }
    
    /**
     * Smaže konrétného uživatele
     * @param $userId
     * @return int
     */
    public function deleteById($userId) :int
    {
        return $this->userDAO->deleteById($userId);
    }
    
    /**
     * Maže uživatele podle celého  objektu
     * @param User $user
     * @return bool|int
     */
    public function delete(User $user)
    {
        return $this->userDAO->delete($user);
    }
    
    /**
     * Vrací konkrétního uživatele podle jeho ID
     * @param int $userId
     * @return bool|User
     */
    public function getById(int $userId)
    {
        $user = $this->userDAO->getById($userId);
        if ($user) {
            return $this->setUserData($user);
        }
        return false;
    }
    
    /**
     * Vrací konkrétního uživatele podle emailu
     * @param string $userEmail
     * @return bool|User
     */
    public function getByEmail(string $userEmail)
    {
        $user = $this->userDAO->getByEmail($userEmail);
        if ($user) {
            return $this->setUserData($user);
        }
        return false;
    }
    
    /**
     * Vrátí všechny uživatele
     * @return array
     */
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
    
    /**
     * Setuje získaná data do objektu User
     * @param array $dbUser
     * @return User
     */
    private function setUserData(array $dbUser)
    {
        return (new User())
            ->setId($dbUser['id'])
            ->setPermission($dbUser['permission'])
            ->setActive((bool) $dbUser['active'])
            ->setPassword($dbUser['password'])
            ->setTel($dbUser['tel'])
            ->setEmail($dbUser['email'])
            ->setToken($dbUser['token'])
            ->setFirstname($dbUser['firstname'])
            ->setVerified((bool) $dbUser['verified'])
            ->setLastname($dbUser['lastname']);
    }
}