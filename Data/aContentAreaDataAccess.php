<?php

require_once 'ContentAreaDataAccessPDOMySQL.php';

// TODO Match Actual Implementation
// NOTE Cleaned

abstract class aContentAreaDataAccess
{
	private static $m_DataAccess;
	
	// Get an instance of the connection
	public static function getInstance()
	{
		if(self::$m_DataAccess == null){
			static::$m_DataAccess = new ContentAreaDataAccessPDOMySQL();
		}
		
		return static::$m_DataAccess;
	}

	public abstract function connectToDB(); 	// Connect to the DB
	public abstract function closeDB(); // Close the connection

	public abstract function selectDivs(); // Selects all Divs
	public abstract function insertDiv($alias, $createdBy, $description, $divOrder, $name);   // Insert Divs

	public abstract function fetchDivs(); // For Parsing DB Result Sets
	public abstract function fetchAlias($row);
	public abstract function fetchCreated($row);
	public abstract function fetchCreatedBy($row);
	public abstract function fetchDescription($row);
	public abstract function fetchDivID($row);
	public abstract function fetchDivOrder($row);
	public abstract function fetchLastModified($row);
	public abstract function fetchModifiedBy($row);
	public abstract function fetchName($row);
	
}

