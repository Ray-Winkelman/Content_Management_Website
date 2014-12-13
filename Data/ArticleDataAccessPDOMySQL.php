<?php

class ArticleDataAccess{
    private $stmt;
    private $dbConnection;
    private $result;

    // Connect to DB
    public function connectToDB(){
        try{
            $this->dbConnection = new PDO("mysql:host=localhost;dbname=cms", "cmscrud", "password");
            $this->dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $ex){
            die ('Could not connect to the CMS Database via PDO: '.$ex->getMessage());
        }
    }

    public function closeDB()
    {
        $this->dbConnection = NULL;
    }

    public function getAllArticlesWherePageID($pageID){
        $this->stmt = $this->dbConnection->prepare('SELECT * FROM Article WHERE PageID=? OR AllPages=1');
        $this->stmt->bindParam(1,
            $pageID,
            PDO::PARAM_INT);
        $this->stmt->execute();
        //return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllArticlesWhereTitleLikeSearch($search){

        $search = "%".$search."%";
        $this->stmt = $this->dbConnection->prepare('SELECT * FROM Article WHERE Title LIKE ?');
        $this->stmt->bindParam(1,
            $search,
            PDO::PARAM_STR);
        $this->stmt->execute();
    }

    // Get articles from page and div
    public  function getArticlesByDivAndPageID($pageID, $divID){

        $this->stmt = $this->dbConnection->prepare('SELECT * FROM Article WHERE PageID=? AND Div_DivID=? AND AllPages=? ORDER BY Created DESC');

        $allPages = 0;
        $this->stmt->bindParam(1, $pageID,  PDO::PARAM_INT);
        $this->stmt->bindParam(2, $divID, PDO::PARAM_INT);
        $this->stmt->bindParam(3, $allPages, PDO::PARAM_INT);
        $this->stmt->execute();

//        $this->stmt = $this->dbConnection->prepare('SELECT * FROM Article WHERE PageID=? AND Div_DivID=? AND AllPages=?');
//
//        $allPages = 0;
//        $this->stmt->bindParam(1, $pageID,  PDO::PARAM_INT);
//        $this->stmt->bindParam(2, $divID, PDO::PARAM_INT);
//        $this->stmt->bindParam(3, $allPages, PDO::PARAM_INT);
//        $this->stmt->execute();

        //return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllPagesArticles(){

        $this->stmt = $this->dbConnection->prepare('SELECT * FROM Article WHERE AllPages=1');
        //$this->stmt->bindParam(1, 1,  PDO::PARAM_INT);
        $this->stmt->execute();
        //return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllArticles(){
        $this->stmt = $this->dbConnection->prepare('SELECT * FROM Article ORDER BY Created DESC');
        $this->stmt->execute();
    }

    public function fetchArticles()
    {
        try{
            $this->result = $this->stmt->fetch(PDO::FETCH_ASSOC);
            return $this->result;
        }catch(PDOException $ex){
            die('Could not retrieve from cms Database: '.$ex->getMessage());
        }
    }

    public function fetchArticleID($row)
    {
        return $row['ArticleID'];
    }

    public function fetchName($row)
    {
        return $row['Name'];
    }

    public function fetchTitle($row)
    {
        return $row['Title'];
    }

    public function fetchDescription($row)
    {
        return $row['Description'];
    }

    public function fetchHTML($row)
    {
        return $row['HTML'];
    }

    public function fetchAllPages($row)
    {
        return $row['AllPages'];
    }

    public function fetchPageID($row)
    {
        return $row['PageID'];
    }

    public function fetchDivID($row)
    {
        return $row['Div_DivID'];
    }

    public function fetchCreated($row)
    {
        return $row['Created'];
    }

    public function fetchCreatedBy($row)
    {
        return $row['CreatedBy'];
    }

    public function fetchLastModified($row)
    {
        return $row['LastModified'];
    }

    public function fetchModifiedBy($row)
    {
        return $row['ModifiedBy'];
    }

    // TODO This does not need this many params, the DB handles times.
    // TODO Also, for an insert the created by will be the same as the modified by
    public function saveArticle($name, $title, $description, $pageID, $divID, $content, $createdBy,$modifiedBy, $allPages){

        $this->stmt = $this->dbConnection->prepare('INSERT INTO Article (Name, Title, Description, HTML, PageID, Div_DivID, CreatedBy, ModifiedBy, AllPages)
                             VALUES (?,?,?,?,?,?,?,?,?)');



        $this->stmt->bindParam(1, $name,  PDO::PARAM_STR);
        $this->stmt->bindParam(2, $title, PDO::PARAM_STR);
        $this->stmt->bindParam(3, $description, PDO::PARAM_STR);
        $this->stmt->bindParam(4, $content,  PDO::PARAM_STR);
        $this->stmt->bindParam(5, $pageID, PDO::PARAM_INT);
        $this->stmt->bindParam(6, $divID, PDO::PARAM_INT);
        $this->stmt->bindParam(7, $createdBy, PDO::PARAM_INT);
        $this->stmt->bindParam(8, $createdBy, PDO::PARAM_INT);
        $this->stmt->bindParam(9, $allPages, PDO::PARAM_INT);
        $this->stmt->execute();

    }

    // Returns the ID given the username
    public function getID($username){
        $this->stmt = $this->dbConnection->prepare("SELECT UserID FROM User WHERE Username='".$username."';");
        $this->stmt->execute();
        $salt = $this->stmt->fetch(PDO::FETCH_ASSOC);
        return $salt['UserID'];
    }

    // TODO Note, we do not need the modified date as a parameter since it is handled by DB
    public function updateArticle($id, $name, $title, $description, $pageID, $divID, $content,
                           $modifiedBy, $allPages){

        $this->stmt = $this->dbConnection->prepare('UPDATE Article SET Name=?, Title=?, Description=?, HTML=?, PageID=?,Div_DivID=?, ModifiedBy=?,
         AllPages=?  WHERE ArticleID=?');

        $this->stmt->bindParam(1, $name,  PDO::PARAM_STR);
        $this->stmt->bindParam(2, $title, PDO::PARAM_STR);
        $this->stmt->bindParam(3, $description, PDO::PARAM_STR);
        $this->stmt->bindParam(4, $content,  PDO::PARAM_STR);
        $this->stmt->bindParam(5, $pageID, PDO::PARAM_INT);
        $this->stmt->bindParam(6, $divID, PDO::PARAM_INT);
        $this->stmt->bindParam(7, $modifiedBy, PDO::PARAM_INT);
        $this->stmt->bindParam(8, $allPages, PDO::PARAM_INT);
        $this->stmt->bindParam(9, $id);
        $this->stmt->execute();
    }

    public function setPageZero($id){
        $this->stmt = $this->dbConnection->prepare('UPDATE Article SET PageID=0 WHERE ArticleID=?');
        $this->stmt->bindParam(1,
            $id,
            PDO::PARAM_STR);
        $this->stmt->execute();
    }
    public function selectArticle($id)
    {
        try
        {
            $this->stmt = $this->dbConnection->prepare('SELECT * FROM Article WHERE ArticleID = :articleID');
            $this->stmt->bindParam ( ':articleID', $id );
            $this->stmt->execute();
        }
        catch ( PDOException $ex ) {
            die ( "Could not retrieve record from CMS." );
        }


    }

    public function fetchArticle()
    {
        try {
            $this->result = $this->stmt->fetch ( PDO::FETCH_ASSOC );
            return $this->result;
        } catch ( PDOException $ex ) {
            die ( 'Could not retrieve records from CMS database via PDO: ' . $ex->getMessage () );
        }
    }

    public
    function deleteArticle($id){

        try {
            $this->stmt = $this->dbConnection->prepare ( 'DELETE FROM Article WHERE ArticleID=:articleID');
            $this->stmt->bindParam ( ':articleID', $id );
            $this->stmt->execute ();
            return $this->stmt->rowCount ();
        } catch ( PDOException $ex ) {
            die ( "Could not delete record from CMS." );
        }
    }
}

