<?php

class UserDAO implements iUser
{
    public function delete(User $user)
    {
        // TODO: Implement delete() method.
    }
    
    public function save(User $user)
    {
        if ($user->getId() === null) {
            $this->create($user);
        } else {
            $this->update($user);
        }
    }
    
    protected function update(User $user)
    {
        $arrayUser = [
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'salt' => $user->getSalt(),
            'token' => $user->getToken(),
            'permission' => $user->getPermission(),
            'firstname' => $user->getFirstname(),
            'lastname' => $user->getLastname(),
        ];
        return Db::update('users', $arrayUser, ' WHERE id = ' . $user->getId());
    }
    
    protected function create(User $user)
    {
        $arrayUser = [
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'salt' => $user->getSalt(),
            'token' => $user->getToken(),
            'permission' => $user->getPermission(),
            'firstname' => $user->getFirstname(),
            'lastname' => $user->getLastname(),
        ];
        return Db::insert('users', $arrayUser);
    }
    
    public function getById(int $userId)
    {
        return Db::queryOne('SELECT * FROM users WHERE id = ?', array($userId));
        
    }
    
    public function getByEmail(string $userEmail)
    {
        return Db::queryOne('SELECT * FROM users WHERE email = ?', array($userEmail));
        
    }
}