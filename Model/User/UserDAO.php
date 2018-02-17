<?php

/**
 * Class UserDAO
 * Stará se o konkrétní práci s uživatelem na úrovni databáze
 */
class UserDAO
{
    /**
     * Smaž uživatele
     * @param User $user
     * @return bool|int
     */
    public function delete(User $user)
    {
        if ($user->getId() !== null) {
            return Db::query('DELETE FROM USERS WHERE id = ? AND email =?', array($user->getId(), $user->getEmail()));
        }
        return false;
        
    }
    public function deleteById(int $id){
        return Db::query('DELETE FROM USERS WHERE id = ? ', array($id));
    }
    
    public function save(User $user)
    {
        if ($user->getId() === null) {
            return $this->create($user);
        }
        return $this->update($user);
        
    }
    
    protected function update(User $user)
    {
        $arrayUser = [
            'email' => $user->getEmail(),
            'tel' => $user->getTel(),
            'password' => $user->getPassword(),
            'token' => $user->getToken(),
            'permission' => $user->getPermission(),
            'firstname' => $user->getFirstname(),
            'lastname' => $user->getLastname(),
            'verified' => $user->isVerified(),
            'active' => $user->isActive()
        ];
        return Db::update('USERS', $arrayUser, ' WHERE id = ' . $user->getId());
    }
    
    /**
     * Vytvoří uživatele
     * @param User $user
     * @return int
     */
    protected function create(User $user)
    {
        $arrayUser = [
            'email' => $user->getEmail(),
            'tel' => $user->getTel(),
            'password' => $user->getPassword(),
            'token' => $user->getToken(),
            'permission' => $user->getPermission(),
            'firstname' => $user->getFirstname(),
            'lastname' => $user->getLastname(),
            'verified' => $user->isVerified(),
            'active' => $user->isActive()
        ];
        return Db::insert('USERS', $arrayUser);
    }
    
    /**
     * Vrat uživatele dle ID
     * @param int $userId
     * @return mixed
     */
    public function getById(int $userId)
    {
        return Db::queryOne('SELECT * FROM USERS WHERE id = ?', array($userId));
        
    }
    
    public function getByEmail(string $userEmail)
    {
       return Db::queryOne('SELECT * FROM USERS WHERE email = ?', array($userEmail));
       
    }
    
    public function getAllUsers(): array
    {
        $result =  Db::queryAll('SELECT * FROM USERS');
        if($result){
            return $result;
        }
        return [];
    }
}