<?php
require_once '../Data/PageDataAccessPDOMySQL.php';

// TODO Match Actual Implementation
// NOTE Cleaned

abstract class aPageDataAccess {

    private static $m_DataAccess;

    public static function getDataAccess()
    {
        if(self::$m_DataAccess == null)
        {
            self::$m_DataAccess = new PageDataAccessPDOMySQL();
        }
        return self::$m_DataAccess;
    }

    public abstract function connectToDB(); // Connect to the DB
    public abstract function closeDB(); // Close the connection

    public abstract function selectPages(); // Select All Pages
    public abstract function fetchPages();
    public abstract function selectPageById($in_id); // Select Page by ID
    public abstract function fetchPageID($row);

    public abstract function insertPage($in_name, $in_alias, $in_description, $in_created_by); // Insert Pages
    public abstract function deletePage($in_id); // Delete Pages

    public abstract function fetchPageName($row); // For parsing DB Results
    public abstract function fetchPageAlias($row);
    public abstract function fetchPageDescription($row);
    public abstract function fetchPageCreated($row);
    public abstract function fetchPageCreatedBy($row);
    public abstract function fetchPageLastModified($row);
    public abstract function fetchPageModifiedBy($row);

}
