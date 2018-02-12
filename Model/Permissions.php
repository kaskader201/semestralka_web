<?php


class Permissions
{
 
 
    /**
     * Vraci jestli daný uživatel má práva na danou akci
     * @param int $user
     * @param int $permission
     * @return bool
     */
    public function checkPermission(int $user, int $permission): bool
    {
        return $user & $permission;
    }
    
    public static function getAllPermision(): array
    {
        $result = Db::queryAll('SELECT * FROM PERMISSION');
       // foreach ($result as $)
        return $result;
    }
    
    public static function translatePermission(int $permission): string
    {
        return Db::queryOne('SELECT name FROM PERMISSION WHERE id = ?', array($permission))[0];
    }
}