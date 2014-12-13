<?php
require_once '../Data/aUserDataAccess.php';

class UserDataAccessPDOMySQL extends aUserDataAccess{

    private $dbConnection;
    private $stmt;
    private $result;

    // Connect to the DB
    public function connectToDB(){
        try{
            $password = "password";
            $username = "cmscrud";
            $dsn = "mysql:host=localhost;dbname=cms"; // http://php.net/manual/en/pdo.construct.php
            $this->dbConnection = new PDO ($dsn, $username, $password);
        }catch(PDOException $ex){
            die ('Could not connect to the cms Database: '.$ex->getMessage());
        }
    }

    // Close the DB connection
    public function closeDB(){
        $this->dbConnection = NULL;
    }


    // Checks to see if a user password matches that stored in DB
    public function checkCredentials($username, $password){

        $this->stmt = $this->dbConnection->prepare('SELECT * FROM User WHERE Username=? AND Password=?');
        $this->stmt->bindParam(1, $username, PDO::PARAM_STR);
        $this->stmt->bindParam(2, $password, PDO::PARAM_STR);
        $this->stmt->execute();

        if($this->stmt->rowCount() == 1){
            return TRUE;
        }

        return FALSE;
    }

    // Checks if a user is of a particular type
    public function isType($username, $typeVal){

       $id = $this->getUserIDByName($username);
        $this->stmt = null;
       $this->stmt = $this->dbConnection->prepare('SELECT * FROM User_Role WHERE User_UserID =? AND Role_RoleID=?');

       $this->stmt->bindParam(1, $id, PDO::PARAM_INT);
       $this->stmt->bindParam(2, $typeVal,PDO::PARAM_INT);
       $this->stmt->execute();
       $result = $this->stmt->fetch(PDO::FETCH_ASSOC);

        if($this->stmt->rowCount() >= 1){ // TODO This should be determined in the business object
            return TRUE;
        }

        return FALSE;
    }

    // Select all users
    public function selectUsers(){
        $this->stmt = $this->dbConnection->prepare('SELECT * FROM User');
        $this->stmt->execute();
    }

    // Select a single user
    public function selectUserById($in_id){
        try{
            $this->stmt = $this->dbConnection->prepare('SELECT * FROM User where UserID = ?');
            $this->stmt->bindParam(1, $in_id,  PDO::PARAM_INT);
            $this->stmt->execute();
        }catch(PDOException $ex){
            die('Could not retrieve from cms Database: '.$ex->getMessage());
        }
    }

    // Fetch All Users
    public function fetchUsers(){
        try{
            $this->result = $this->stmt->fetch(PDO::FETCH_ASSOC);
            return $this->result;
        }catch(PDOException $ex){
            die('Could not retrieve from cms Database: '.$ex->getMessage());
        }
    }













    // Parsing methods

    public function fetchUserID($row){
        return $row['UserID'];
    }

    public function fetchUsername($row){
        return $row['Username'];
    }

    public function fetchPassword($row){
        return $row['Password'];
    }

    public function fetchFirstName($row){
        return $row['FirstName'];
    }

    public function fetchLastName($row){
        return $row['LastName'];
    }

    public function fetchSalt($row){
        return $row['Salt'];
    }

    public function fetchCreated($row){
        return $row['Created'];
    }

    public function fetchCreatedBy($row){
        return $row['CreatedBy'];
    }

    public function fetchModifiedBy($row){
        return $row['ModifiedBy'];
    }

    public function fetchLastModified($row){
        return $row['LastModified'];
    }


    // Return the ID of a user given the name
    public function getUserIDByName($userName){
        $this->stmt = $this->dbConnection->prepare('SELECT UserID from User WHERE Username = ?');
        $this->stmt->bindParam(1, $userName, PDO::PARAM_STR);
        $this->stmt->execute();
        $result = $this->stmt->fetch(PDO::FETCH_ASSOC);
        return ($this->fetchUserID($result));
    }


    // gets salt by id
    public function getSaltByID($userID){
        $this->stmt = $this->dbConnection->prepare('SELECT Salt from User WHERE UserID = ?');
        $this->stmt->bindParam(1, $userID, PDO::PARAM_INT);
        $this->stmt->execute();
        $result = $this->stmt->fetch(PDO::FETCH_ASSOC);
        return ($this->fetchSalt($result));
    }

    // gets salt by user name
    public function getSalt($username){

     return $this->getSaltByID($this->getUserIDByName($username));

    }

    // Insert a new User
    public function insertUser($in_userName, $in_password, $in_firstName, $in_lastName, $in_createdBy, $admin, $editor, $author){

        $in_createdBy = $this->getID($in_createdBy);

        $this->stmt = $this->dbConnection->prepare(
            'INSERT INTO User (Username,Password,FirstName,LastName,CreatedBy,ModifiedBy) VALUES(?,?,?,?,?,?)');

        // Sanitize the values
        $this->stmt->bindParam(1, $in_userName,  PDO::PARAM_STR);
        $this->stmt->bindParam(2, $in_password, PDO::PARAM_STR);
        $this->stmt->bindParam(3, $in_firstName, PDO::PARAM_STR);
        $this->stmt->bindParam(4, $in_lastName, PDO::PARAM_STR);
        $this->stmt->bindParam(5, $in_createdBy, PDO::PARAM_INT);
        $this->stmt->bindParam(6, $in_createdBy, PDO::PARAM_INT);
        $this->stmt->execute();

        $id = $this->dbConnection->lastInsertId(); // get last inserted ID

        $userPrivs = array( $admin, $editor, $author); // list of specified privileges
        $privKeys = array(1,2,3); // the matching keys for privileges

        for ($i = 0; $i < count($userPrivs); $i++) {  // Iterate through each listed privilege and add the relevant privilege ID

            if($userPrivs[$i] != 0){
                $this->stmt = $this->dbConnection->prepare('INSERT INTO User_Role (User_UserID, Role_RoleID) VALUES (?,?)');
                $this->stmt->bindParam(1, $id, PDO::PARAM_INT);
                $this->stmt->bindParam(2, $privKeys[$i], PDO::PARAM_INT);
                $this->stmt->execute();
            }
        }

        return $this->getSaltByID($id);
    }


    // Update password
    public function updatePassword($in_password, $in_un){
        $this->stmt = $this->dbConnection->prepare('UPDATE User SET Password=? WHERE Username=?');
        $this->stmt->bindParam(1, $in_password,PDO::PARAM_STR);
        $this->stmt->bindParam(2,
            $in_un, PDO::PARAM_STR);
        $this->stmt->execute();
    }


    // Returns the ID given the username
    public function getID($username){
        $this->stmt = $this->dbConnection->prepare("SELECT UserID FROM User WHERE Username='".$username."';");
        $this->stmt->execute();
        $salt = $this->stmt->fetch(PDO::FETCH_ASSOC);
        return $salt['UserID'];
    }

    // Updates the values of a user
    public function updateUser($in_userName, $in_password, $in_firstName, $in_lastName, $in_modifiedBy, $in_id, $admin, $editor, $author){

        $in_createdBy = $this->getID($in_modifiedBy);

        $this->stmt = $this->dbConnection->prepare(
            'UPDATE User SET Username=?,Password=?,FirstName=?,LastName=?,ModifiedBy=? WHERE UserID=?');

        // Sanitize the values
        $this->stmt->bindParam(1, $in_userName,  PDO::PARAM_STR);
        $this->stmt->bindParam(2, $in_password, PDO::PARAM_STR);
        $this->stmt->bindParam(3, $in_firstName, PDO::PARAM_STR);
        $this->stmt->bindParam(4, $in_lastName, PDO::PARAM_STR);
        $this->stmt->bindParam(5, $in_modifiedBy, PDO::PARAM_INT);
        $this->stmt->bindParam(6, $in_id, PDO::PARAM_INT);
        $this->stmt->execute();

        $id = $in_id; // get last inserted ID

        $userPrivs = array( $admin, $editor, $author); // list of specified privileges
        $privKeys = array(1,2,3); // the matching keys for privileges


        $this->stmt = $this->dbConnection->prepare('DELETE User_Role WHERE User_UserID=?');
        $this->stmt->bindParam(1, $id,  PDO::PARAM_INT);
        $this->stmt->execute();

            for ($i = 0; $i < count($userPrivs); $i++) {  // Iterate through each listed privilege and add the relevant privilege ID

                if($userPrivs[$i] != 0){
                    $this->stmt = $this->dbConnection->prepare('INSERT INTO User_Role (User_UserID, Role_RoleID) VALUES (?,?)');
                    $this->stmt->bindParam(1, $id, PDO::PARAM_INT);
                    $this->stmt->bindParam(2, $privKeys[$i], PDO::PARAM_INT);
                    $this->stmt->execute();
                }
            }

    }

    // Removes a Permission from a User
    public function deletePermission($username, $role){
        $id = $this->getID($username);
        $this->stmt = $this->dbConnection->prepare('DELETE FROM User_Role WHERE User_UserID=? AND Role_RoleID=?');
        $this->stmt->bindParam(1,$id, PDO::PARAM_INT);
        $this->stmt->bindParam(2, $role, PDO::PARAM_INT);
        $this->stmt->execute();
    }
}
