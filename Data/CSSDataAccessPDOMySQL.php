<?php

// TODO Match Actual Implementation
// Note Cleaned

class MySQL{
    private $stmt;
    private $dbConnection;

    // Connect to the DB
    public function connectToDB(){
        try{
            $this->dbConnection = new PDO("mysql:host=localhost;dbname=cms", "cmscrud", "password");
            $this->dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $ex){
            die ('Could not connect to the CMS Database via PDO: '.$ex->getMessage());
        }
    }

    // Gets all active CSS
    public function getAllActiveCSS(){
        $idToSelect = 1;
        $this->stmt = $this->dbConnection->prepare('SELECT * FROM CSS WHERE Active=?');
        $this->stmt->bindParam ( 1, $idToSelect , PDO::PARAM_INT );
        $this->stmt->execute();

        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Returns all CSS
    public function getAllCSS(){
        $this->stmt = $this->dbConnection->prepare('SELECT * FROM CSS');
        $this->stmt->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Saves CSS by ID  TODO Does not require this many parameters, dates are handled by DB.
    public function saveCSS($name, $description, $active, $createdBy, $createdDate, $modifiedBy,
                     $modifiedDate, $content){

        $this->stmt = $this->dbConnection->prepare('UPDATE CSS SET Active=0 WHERE 1=1');
        $this->stmt->execute();

        $this->stmt = $this->dbConnection->prepare(
        'INSERT INTO CSS (Name, Active, Content, Description, CreatedBy, ModifiedBy)
          VALUES (?,?,?,?,?,?)');

        $this->stmt->bindParam ( 1, $name , PDO::PARAM_STR );
        $this->stmt->bindParam ( 2, $active , PDO::PARAM_INT );
        $this->stmt->bindParam ( 3, $content , PDO::PARAM_STR );
        $this->stmt->bindParam ( 4, $description , PDO::PARAM_STR );
        $this->stmt->bindParam ( 5, $createdBy , PDO::PARAM_INT ); // created by and modified by are the same here
        $this->stmt->bindParam ( 6, $createdBy , PDO::PARAM_INT );

        $this->stmt->execute();
    }

    // Updates CSS by ID  TODO Does not require this many parameters, dates are handled by DB.
    public   function updateCSS($id, $name, $description, $active, $modifiedBy, $modifiedDate,
                       $content){

        $this->stmt = $this->dbConnection->prepare('UPDATE CSS SET Active=0 WHERE 1=1');
        $this->stmt->execute();

        $this->stmt = $this->dbConnection->prepare( 'UPDATE CSS SET Name=?, Active=?, Content=?, Description=?, ModifiedBy=? WHERE CSSID=?');

        $this->stmt->bindParam ( 1, $name , PDO::PARAM_STR );
        $this->stmt->bindParam ( 2, $active , PDO::PARAM_INT );
        $this->stmt->bindParam ( 3, $content , PDO::PARAM_STR );
        $this->stmt->bindParam ( 4, $description , PDO::PARAM_STR );
        $this->stmt->bindParam ( 5, $modifiedBy , PDO::PARAM_INT );
        $this->stmt->bindParam ( 6, $id , PDO::PARAM_INT );
        $this->stmt->execute();
    }

    public function deleteCSS($id){
        $this->stmt = $this->dbConnection->prepare('DELETE FROM CSS WHERE CssID=?');
        $this->stmt->bindParam ( 1, $id , PDO::PARAM_INT );
        $this->stmt->execute();
    }


}
