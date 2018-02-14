<?php

/**
 * Class Permissions
 *
 */
class Permissions
{
    /**
     * Vraci jestli daný uživatel má práva na danou akci
     * @param int $user
     * @param int $permission
     * @return bool
     */
    public static function checkPermission(int $permission, int $user): bool
    {
        return $user >= $permission;
    }
    
    public static function getAllPermision(): array
    {
        $result = Db::queryAll('SELECT * FROM PERMISSION');
        // foreach ($result as $)
        return $result;
    }
    public static function getPermission($userPermission){
        return Db::queryOne('SELECT value FROM PERMISSION WHERE id = ?', array($userPermission))[0];
    }
    public static function translatePermission(int $permission): string
    {
        return Db::queryOne('SELECT name FROM PERMISSION WHERE id = ?', array($permission))[0];
    }
    
    public static function getPermissionForCategory(string $name): int {
        $name = strtolower($name);
        return Db::queryOne('SELECT min_permisssion FROM MENU WHERE url = ?',array($name))[0];
    }
}