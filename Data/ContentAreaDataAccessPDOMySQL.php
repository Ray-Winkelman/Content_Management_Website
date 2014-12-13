<?php

// the parent class
require_once 'aContentAreaDataAccess.php';

// NOTE Cleaned

class ContentAreaDataAccessPDOMySql extends aContentAreaDataAccess {

	private $stmt; // holds the statement
	private $dbConnection; // holds the DB Connection
	private $result; // holds the result set

    // Database Connection
	public function connectToDB() {
		try {
            $password = "password";
            $username = "cmscrud";
			$dsn = "mysql:host=localhost;dbname=cms";

			$this->dbConnection = new PDO ( $dsn, $username, $password );      // Start the connection
		} catch ( PDOException $ex ) {
			die ( 'Could not connect to the CMS via PDO: ' . $ex->getMessage () );
		}
	}

    // Close Database Connection
	public function closeDB() {
		$this->dbConnection = null;
	}

	// Select all DIVs in the order they appear
	public function selectDivs(){
        $sql = 'SELECT * FROM Content_Area Order By DivOrder';
        $this->stmt = $this->dbConnection->prepare ($sql);
		$this->stmt->execute ();
	}

    // Return all DIVS in result
	public function fetchDivs() {
		try {
			$this->result = $this->stmt->fetch ( PDO::FETCH_ASSOC );
			return $this->result;
		} catch ( PDOException $ex ) {
			die ( 'Could not retrieve records from CMS database via PDO: ' . $ex->getMessage () );
		}
	}

    // Selects an individual DIV
	public function selectDiv($divID){
        $this->stmt = $this->dbConnection->prepare ('SELECT * FROM Content_Area WHERE DivID=?');
        $this->stmt->bindParam (1, $divID , PDO::PARAM_INT );
        $this->stmt->execute ();
	}

    // Returns an individual div
	public function fetchDiv(){
		try {
			$this->result = $this->stmt->fetch ( PDO::FETCH_ASSOC );
			return $this->result;
		} catch ( PDOException $ex ) {
			die ( 'Could not retrieve records from CMS database via PDO: ' . $ex->getMessage () );
		}
	}

	// Insert a new DIV into the database
	public function insertDiv($alias, $createdBy, $description, $divOrder, $name){
		try {
			$this->stmt = $this->dbConnection->prepare ('INSERT INTO Content_Area (Alias, CreatedBy, ModifiedBy, Description, DivOrder, Name) VALUES (:alias, :createdBy, :modifiedBy, :description, :order, :name)');

			$this->stmt->bindParam ( ':alias', $alias , PDO::PARAM_STR );
			$this->stmt->bindParam ( ':createdBy', $createdBy , PDO::PARAM_INT );
			$this->stmt->bindParam ( ':modifiedBy', $createdBy , PDO::PARAM_INT );
			$this->stmt->bindParam ( ':description', $description , PDO::PARAM_STR );
			$this->stmt->bindParam ( ':order', $divOrder , PDO::PARAM_INT );
			$this->stmt->bindParam ( ':name', $name, PDO::PARAM_STR);
			$this->stmt->execute ();
			return $this->stmt->rowCount (); // affected rows
		} catch ( PDOException $ex ) {
			die ( "Could not insert records into CMS Database via PDO" . $ex->getMessage () );
		}
	}

	// Remove a DIV by ID
	public function removeDiv($divID){
			try {
				$this->stmt = $this->dbConnection->prepare ( 'DELETE FROM Content_Area WHERE DivID=:divID' );
				$this->stmt->bindParam ( ':divID', $divID );
				$this->stmt->execute ();
				return $this->stmt->rowCount ();
			} catch ( PDOException $ex ) {
				die ( "Could not delete record from CMS." );
			}
	}

	// Update a DIV in the database with new values
	public function updateDiv($alias, $modifiedBy, $description, $divOrder, $name, $divID){

			try {
				$this->stmt = $this->dbConnection->prepare('UPDATE Content_Area SET Alias=?, ModifiedBy=?, Description=?, DivOrder=?, Name=?
                     WHERE DivID=?' );

				$this->stmt->bindParam ( 1, $alias , PDO::PARAM_STR );
				$this->stmt->bindParam ( 2, $modifiedBy , PDO::PARAM_INT );
				$this->stmt->bindParam ( 3, $description , PDO::PARAM_STR );
				$this->stmt->bindParam ( 4, $divOrder , PDO::PARAM_INT );
				$this->stmt->bindParam ( 5, $name, PDO::PARAM_STR);
				$this->stmt->bindParam ( 6, $divID);
				$this->stmt->execute ();
				return $this->stmt->rowCount (); // affected rows
			} catch ( PDOException $ex ) {
				die ( "Could not insert records into Sakilla Database" . $ex->getMessage () );
			}
		}

	// Parse Alias
	public function fetchAlias($row) {
		return $row ['Alias'];
	}

    // Parse Created
	public function fetchCreated($row) {
		return $row ['Created'];
	}

	// Parse CreatedBy
	public function fetchCreatedBy($row) {
		return $row ['CreatedBy'];
	}

	// Parse Description
	public function fetchDescription($row) {
		return $row ['Description'];
	}

	// Parse DidID
	public function fetchDivID($row) {
		return $row ['DivID'];
	}

	// Parse Order
	public function fetchDivOrder($row) {
		return $row ['DivOrder'];
	}

	// get the last modified
	public function fetchLastModified($row) {
		return $row ['LastModified'];
	}

	// get the modified by
	public function fetchModifiedBy($row) {
		return $row ['ModifiedBy'];
	}

	// get the name of the div
	public function fetchName($row) {
		return $row ['Name'];
	}

}
