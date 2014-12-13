<?php
require("../Data/aUserDataAccess.php");

class User{

    private $m_UserID;
    private $m_UserName;
    private $m_Password;
    private $m_FirstName;
    private $m_LastName;
    private $m_Salt;
    private $m_Created;
    private $m_CreatedBy;
    private $m_LastModified;
    private $m_ModifiedBy;

    public function __construct($in_userName, $in_password, $in_firstName, $in_lastName, $in_createdBy, $in_modifiedBy){
        $this->m_UserName = $in_userName;
        $this->m_Password = $in_password;
        $this->m_FirstName = $in_firstName;
        $this->m_LastName = $in_lastName;
        $this->m_CreatedBy = $in_createdBy;
        $this->m_ModifiedBy = $in_modifiedBy;
    }

    //Setters
    public function setUserName($in_userName){
        $this->m_UserName = $in_userName;
    }

    public function setPassword($in_password){
        $this->m_Password = $in_password;
    }

    public function setFirstName($in_firstName){
        $this->m_FirstName = $in_firstName;
    }

    public function setLastName($in_lastName){
        $this->m_LastName = $in_lastName;
    }

    public function setSalt($in_salt){
        $this->m_Salt = $in_salt;
    }

    public function setCreatedBy($in_createdBy){
        $this->m_CreatedBy = $in_createdBy;
    }

    public function setModifiedBy($in_modifiedBy){
        $this->m_ModifiedBy = $in_modifiedBy;
    }

    //Getters
    public function getUserID(){
        return $this->m_UserID;
    }

    public function getUserName(){
        return $this->m_UserName;
    }

    public function getPassword(){
        return $this->m_Password;
    }

    public function getFirstName(){
        return $this->m_FirstName;
    }

    public function getLastName(){
        return $this->m_LastName;
    }

    public function getSalt(){
        return $this->m_Salt;
    }

    public function getCreated(){
        return $this->m_Created;
    }

    public function getCreatedBy(){
        return $this->m_CreatedBy;
    }

    public function getLastModified(){
        return $this->m_LastModified;
    }

    public function getModifiedBy(){
        return $this->m_ModifiedBy;
    }

    public static function isAdmin($username){

        $myDataAccess = aUserDataAccess::getDataAccess();
        $myDataAccess->connectToDB();
        $bool = $myDataAccess->isType($username,
            1);
        $myDataAccess->closeDB();
        RETURN $bool;
    }

    public static function isEditor($username){
        $myDataAccess = aUserDataAccess::getDataAccess();
        $myDataAccess->connectToDB();
        $bool = $myDataAccess->isType($username,
            2);
        $myDataAccess->closeDB();
        RETURN $bool;
    }

    public static function isAuthor($username){
        $myDataAccess = aUserDataAccess::getDataAccess();
        $myDataAccess->connectToDB();
        $bool = $myDataAccess->isType($username,
            3);
        $myDataAccess->closeDB();
        RETURN $bool;
    }

    //Returns an array of Page objects
    public static function retrieveData(){
        $myDataAccess = aUserDataAccess::getDataAccess();
        $myDataAccess->connectToDB();
        $myDataAccess->selectUsers();
        while($row = $myDataAccess->fetchUsers()){
            // Username, Password, FirstName, LastName, Salt, CreatedBy,ModifiedBy
            $currentUser =
                new self($myDataAccess->fetchUsername($row), $myDataAccess->fetchPassword($row), $myDataAccess->fetchFirstName($row), $myDataAccess->fetchLastName($row), $myDataAccess->fetchCreatedBy($row), $myDataAccess->fetchModifiedBy($row));
            //FETCH USER RELATED DATA
            $currentUser->m_UserID = $myDataAccess->fetchUserID($row);
            $currentUser->m_Created = $myDataAccess->fetchCreated($row);
            $currentUser->m_LastModified = $myDataAccess->fetchLastModified($row);
            $currentUserObjects[] = $currentUser;
        }
        $myDataAccess->closeDB();
        return $currentUserObjects;
    }

    public static function getTheUserID($username){
        $myDataAccess = aUserDataAccess::getDataAccess();
        $myDataAccess->connectToDB();
        return $myDataAccess->getID($username);
    }

    public static function retrieveUserById($in_id){
        $myDataAccess = aUserDataAccess::getDataAccess();
        $myDataAccess->connectToDB();
        $myDataAccess->selectUserById($in_id);
        while($row = $myDataAccess->fetchUsers()){
            // Username, Password, FirstName, LastName, Salt, CreatedBy,ModifiedBy
            $currentUser =
                new self($myDataAccess->fetchUsername($row), $myDataAccess->fetchPassword($row), $myDataAccess->fetchFirstName($row), $myDataAccess->fetchLastName($row), $myDataAccess->fetchSalt($row), $myDataAccess->fetchCreatedBy($row), $myDataAccess->fetchModifiedBy($row));
            //FETCH USER RELATED DATA
            $currentUser->m_UserID = $myDataAccess->fetchUserID($row);
            $currentUser->m_Created = $myDataAccess->fetchCreated($row);
            $currentUser->m_LastModified = $myDataAccess->fetchLastModified($row);
        }
        $myDataAccess->closeDB();
        return $currentUser;
    }

    public function save($admin, $editor, $author){
        $myDataAccess = aUserDataAccess::getDataAccess();
        $myDataAccess->connectToDB();

        $password = hash('sha512',
            $this->m_Password);

        $salt = $myDataAccess->insertUser($this->m_UserName,
            $password,
            $this->m_FirstName,
            $this->m_LastName,
            $this->m_CreatedBy,
            $admin,
            $editor,
            $author);

        $password = crypt($password,
            sprintf('$45$rounds=%d$%s$',
                10000,
                $salt));

        $myDataAccess->updatePassword($password,
            $this->m_UserName);

        $myDataAccess->closeDB();
    }

    public function update($admin, $editor, $author){
        $myDataAccess = aUserDataAccess::getDataAccess();
        $myDataAccess->connectToDB();
        $myDataAccess->updateUser($this->m_UserName,
            $this->m_Password,
            $this->m_FirstName,
            $this->m_LastName,
            $this->m_ModifiedBy,
            $this->m_UserID,
            $admin,
            $editor,
            $author);
        $myDataAccess->closeDB();
    }

    public function delete(){
        $myDataAccess = aUserDataAccess::getDataAccess();
        $myDataAccess->connectToDB();
        $myDataAccess->selectUserById($this->m_UserID);
        $user = $myDataAccess->fetchUsers();
        $myDataAccess->deletePermission($user["Username"],
            1);
        $myDataAccess->deletePermission($user["Username"],
            2);
        $myDataAccess->deletePermission($user["Username"],
            3);
        $myDataAccess->closeDB();
    }
}
