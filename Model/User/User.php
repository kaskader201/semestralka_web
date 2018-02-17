<?php

/**
 * Class User
 * Objekt uživatel
 */
class User implements iUser
{
    /**
     * @int
     */
    public $id;
    /**
     * @string
     */
    public $email;
    /**
     * @string
     */
    public $tel;
    /**
     * @string
     */
    private $password;
    /**
     * @string
     */
    private $token;
    /**
     * @int
     */
    public $permission;
    /**
     * @bool
     */
    public $active;
    /**
     * @string
     */
    public $firstname;
    /**
     * @string
     */
    public $lastname;
    /**
     * @bool
     */
    public $verified;
    /**
     * @var UserService
     */
    private $userService;
    
    public function __construct()
    {
        $this->setUserService(new UserService());
        //nastavime zakladní práva
        $this->setPermission(1);
    }
    
    /**
     * @param UserService $userService
     */
    private function setUserService(UserService $userService)
    {
        $this->userService = $userService;
    }
    
    /**
     * @param string $tel
     * @return User
     */
    public function setTel(string $tel): User
    {
        $this->tel = $tel;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getTel(): string
    {
        return $this->tel;
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
    public function setFirstPassword($password){
    
    }
    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password) : User
    {
        if($this->getId() === null){
            $this->password = password_hash($password,PASSWORD_BCRYPT);
        } else{
            $this->password = $password;
        }
        
        return $this;
    }
    
    public function verifyPassword(string $password) :bool
    {
        return password_verify($password,$this->getPassword());
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
    
    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return (bool) $this->active;
    }
    
    /**
     * @return bool
     */
    public function isVerified(): bool
    {
        return (bool) $this->verified;
    }
    
    /**
     * @param bool $active
     * @return User
     */
    public function setActive(bool $active): User
    {
        $this->active = $active;
        return $this;
    }
    
    /**
     * @param bool $verified
     * @return User
     */
    public function setVerified(bool $verified): User
    {
        $this->verified = $verified;
        return $this;
    }
    
    
    public function delete()
    {
        $user = $this;
        $this->userService->delete($user);
    }
    
    public function save()
    {
        $user = $this;
        return $this->userService->save($user);
    }
    
    /**
     * Vrací jmeno a příjmení uživatele
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s %s', $this->getFirstname(), $this->getLastname());
    }
    
}