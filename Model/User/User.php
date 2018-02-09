<?php

/**
 * Objekt Zboží
 * User: Jelin
 * Date: 22.12.2017
 * Time: 14:09
 */

class User implements iUser
{
    /**
     * @int
     */
    private $id;
    /**
     * @string
     */
    private $email;
    /**
     * @string
     */
    private $password;
    /**
     * @string
     */
    private $salt;
    /**
     * @string
     */
    private $token;
    /**
     * @int
     */
    private $permission;
    /**
     * @string
     */
    private $firstname;
    /**
     * @string
     */
    private $lastname;
    
    
    /**
     * @var UserService
     */
    private $userService;
    
    public function __construct()
    {
        $this->setUserService(new UserService());
    }
    
    /**
     * @param UserService $userService
     */
    private function setUserService(UserService $userService)
    {
        $this->userService = $userService;
    }
    
    /**
     * @param mixed $salt
     * @return User
     */
    public function setSalt(string $salt): User
    {
        $this->salt = $salt;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getSalt(): string
    {
        return $this->salt;
    }
    
    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @param int $id
     * @return User
     */
    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
    
    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
    
    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }
    
    /**
     * @param string $token
     * @return User
     */
    public function setToken(string $token): User
    {
        $this->token = $token;
        return $this;
    }
    
    /**
     * @return int
     */
    public function getPermission(): int
    {
        return $this->permission;
    }
    
    /**
     * @param int $permission
     * @return User
     */
    public function setPermission(int $permission): User
    {
        $this->permission = $permission;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }
    
    /**
     * @param string $firstname
     * @return User
     */
    public function setFirstname(string $firstname): User
    {
        $this->firstname = $firstname;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }
    
    /**
     * @param string $lastname
     * @return User
     */
    public function setLastname(string $lastname): User
    {
        $this->lastname = $lastname;
        return $this;
    }
    
    
    public function delete(User $user)
    {
        $this->userService->delete($user);
    }
    
    public function save(User $user)
    {
        $this->userService->save($user);
    }
    
    
}