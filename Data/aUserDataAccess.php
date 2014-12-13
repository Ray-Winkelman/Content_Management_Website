<?php
require_once '../Data/UserDataAccessPDOMySQL.php';

abstract class aUserDataAccess {

    private static $m_DataAccess;

    public static function getDataAccess()
    {
        if(self::$m_DataAccess == null)
        {
            self::$m_DataAccess = new UserDataAccessPDOMySQL();
        }
        return self::$m_DataAccess;
    }
}
