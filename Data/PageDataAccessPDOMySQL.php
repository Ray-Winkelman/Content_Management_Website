<?php

class PageDataAccessPDOMySQL extends aPageDataAccess{

    private $dbConnection;
    private $stmt;
    private $result;

    // Connect to the DB
    public function connectToDB(){
        try {
            $password = "password";
            $username = "cmscrud";
            $dsn = "mysql:host=localhost;dbname=cms"; // http://php.net/manual/en/pdo.construct.php
            $this->dbConnection = new PDO ( $dsn, $username, $password );
        }

        catch ( PDOException $ex ) {
            die ( 'Could not connect to the cms Database via PDO: ' . $ex->getMessage () );
        }
    }

    // Close the DB Connection
    public function closeDB() {
        $this->dbConnection = null;
    }

    // Select all pages
    public function selectPages(){
        $this->stmt = $this->dbConnection->prepare ( 'SELECT * FROM Page');
        $this->stmt->execute ();
    }

    // Select an individual page
    public function selectPageById($in_id){
        try{
        $this->stmt = $this->dbConnection->prepare ('SELECT * FROM Page where PageID = :in_id');
        $this->stmt->bindParam(':in_id', $in_id, PDO::PARAM_INT);
        $this->stmt->execute ();
        }
        catch(PDOException $ex)
        {
            die('Could not retrieve from cms Database: ' . $ex->getMessage());
        }
    }


    public function fetchPages(){
        try
        {
            $this->result = $this->stmt->fetch(PDO::FETCH_ASSOC);
            return $this->result;
        }
        catch(PDOException $ex)
        {
            die('Could not retrieve from Sakila Database via PDO: ' . $ex->getMessage());
        }
    }

    public function fetchPageID($row)
    {
        return $row['PageID'];
    }

    public function fetchPageName($row)
    {
        return $row['Name'];
    }

    public function fetchPageAlias($row)
    {
        return $row['Alias'];
    }

    public function fetchPageDescription($row)
    {
        return $row['Description'];
    }

    public function fetchPageCreated($row)
    {
        return $row['Created'];
    }

    public function fetchPageCreatedBy($row)
    {
        return $row['CreatedBy'];
    }

    public function fetchPageLastModified($row)
    {
        return $row['LastModified'];
    }

    public function fetchPageModifiedBy($row)
    {
        return $row['ModifiedBy'];
    }

    // Insert an individual page
    public function insertPage($in_name, $in_alias, $in_description, $in_created_by){
        try
        {
            $this->stmt = $this->dbConnection->prepare('INSERT INTO Page(Name, Alias, Description, CreatedBy)
                                                        VALUES(:name, :alias, :description, :createdBy);');
            $this->stmt->bindParam(':name', $in_name, PDO::PARAM_STR);
            $this->stmt->bindParam(':alias', $in_alias, PDO::PARAM_STR);
            $this->stmt->bindParam(':description', $in_description, PDO::PARAM_STR);
            $this->stmt->bindParam(':createdBy', $in_created_by, PDO::PARAM_INT);

            $this->stmt->execute();

            return $this->stmt->rowCount();

        }
        catch(PDOExceptio $ex)
        {
            die('Could not insert record into Page table: ' . $ex->getMessage());
        }

    }

    public  function updatePage($in_name, $in_alias, $in_description, $in_modifiedBy, $in_id)
    {
        try
        {
            $this->stmt = $this->dbConnection->prepare('UPDATE Page SET Name =:name, Alias = :alias, Description = :description,
                                                        ModifiedBy = :modifiedBy WHERE PageId=:id');
            $this->stmt->bindParam(':name', $in_name, PDO::PARAM_STR);
            $this->stmt->bindParam(':alias', $in_alias, PDO::PARAM_STR);
            $this->stmt->bindParam(':description', $in_description, PDO::PARAM_STR);
            $this->stmt->bindParam(':modifiedBy', $in_modifiedBy, PDO::PARAM_INT);
            $this->stmt->bindParam(':id', $in_id, PDO::PARAM_INT);

            $this->stmt->execute();

            return $this->stmt->rowCount();
        }
        catch(PDOException $ex)
        {
            die('Could not update record in Page table: ' . $ex->getMessage());
        }
    }

    public function deletePage($in_id)
    {
        try
        {
            $this->stmt = $this->dbConnection->prepare('UPDATE Article SET PageID=0 WHERE PageId=:id');
            $this->stmt->bindParam(':id',
                $in_id,
                PDO::PARAM_INT);
            $this->stmt->execute();

            $this->stmt = $this->dbConnection->prepare('delete from Page where PageID = :id');
            $this->stmt->bindParam(':id', $in_id, PDO::PARAM_INT);
            $this->stmt->execute();
            return $this->stmt->rowCount();
        }
        catch(PDOException $ex)
        {
            die('Could not delete record in cms Database: '. $ex->getMessage());
        }

    }
}
