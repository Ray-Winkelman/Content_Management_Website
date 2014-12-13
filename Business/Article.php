<?php include('../Data/ArticleDataAccessPDOMySQL.php');

class Article
{
    // MEMBERS
    private $articleID;
    private $name;
    private $title;
    private $description;
    private $html;
    private $pageID;
    private $divID;
    private $allPages;
    private $createdBy;
    private $createdDate;
    private $modifiedBy;
    private $modifiedDate;

    // CONSTRUCTOR

    public function __construct($in_name, $in_title, $in_description, $in_html,$in_pageID,$in_divID,
                                $in_allPages, $in_createdBy, $in_modifiedBy)
    {
        $this->name = $in_name;
        $this->title = $in_title;
        $this->description = $in_description;
        $this->html = $in_html;
        $this->pageID = $in_pageID;
        $this->divID = $in_divID;
        $this->allPages = $in_allPages;
        $this->createdBy = $in_createdBy;
        //$this->createdDate = $in_createdDate;
        $this->modifiedBy = $in_modifiedBy;
        //$this->modifiedDate = $in_modifiedDate;

    }

    public static function getAllArticlesWherePageID($pageID){
        $myDataAccess = new articleDataAccess();
        $myDataAccess->connectToDB();
        $myDataAccess->getAllArticlesWherePageID($pageID);
        $count = 0;

        while ($row = $myDataAccess->fetchArticles())
        {

            $currentArticle = new self($myDataAccess->fetchName($row),$myDataAccess->fetchTitle($row),$myDataAccess->fetchDescription($row),
                $myDataAccess->fetchHTML($row),$myDataAccess->fetchPageID($row),$myDataAccess->fetchDivID($row),
                $myDataAccess->fetchAllPages($row),$myDataAccess->fetchCreatedBy($row),
                $myDataAccess->fetchModifiedBy($row));
            $currentArticle->createdDate = $myDataAccess->fetchCreated($row);
            $currentArticle->modifiedDate = $myDataAccess->fetchLastModified($row);
            $currentArticle->articleID = $myDataAccess->fetchArticleID($row);
            $currentArticleObjects[] = $currentArticle;
            $count = $row;
        }

        $myDataAccess->closeDB();
        if($count > 0){
        return $currentArticleObjects;
        }
        return NULL;
    }

    public static function getAllArticlesWhereTitleLikeSearch($search){
        $myDataAccess = new articleDataAccess();
        $myDataAccess->connectToDB();
        $myDataAccess->getAllArticlesWhereTitleLikeSearch($search);
        $count = 0;
        while($row = $myDataAccess->fetchArticles()){
            $currentArticle =
                new self($myDataAccess->fetchName($row), $myDataAccess->fetchTitle($row), $myDataAccess->fetchDescription($row), $myDataAccess->fetchHTML($row), $myDataAccess->fetchPageID($row), $myDataAccess->fetchDivID($row), $myDataAccess->fetchAllPages($row), $myDataAccess->fetchCreatedBy($row), $myDataAccess->fetchModifiedBy($row));
            $currentArticle->createdDate = $myDataAccess->fetchCreated($row);
            $currentArticle->modifiedDate = $myDataAccess->fetchLastModified($row);
            $currentArticle->articleID = $myDataAccess->fetchArticleID($row);
            $currentArticleObjects[] = $currentArticle;
            $count = $row;
        }
        $myDataAccess->closeDB();
        if($count > 0){
            return $currentArticleObjects;
        }
        return NULL;
    }

    public static function retrieveData()
    {
        $myDataAccess = new ArticleDataAccess();
        $myDataAccess->connectToDB();
        $myDataAccess->getAllArticles();

        while ($row = $myDataAccess->fetchArticles())
        {

            $currentArticle = new self($myDataAccess->fetchName($row),$myDataAccess->fetchTitle($row),$myDataAccess->fetchDescription($row),
                                        $myDataAccess->fetchHTML($row),$myDataAccess->fetchPageID($row),$myDataAccess->fetchDivID($row),
                                        $myDataAccess->fetchAllPages($row),$myDataAccess->fetchCreatedBy($row),
                                        $myDataAccess->fetchModifiedBy($row));
            $currentArticle->createdDate = $myDataAccess->fetchCreated($row);
            $currentArticle->modifiedDate = $myDataAccess->fetchLastModified($row);
            $currentArticle->articleID = $myDataAccess->fetchArticleID($row);
            $currentArticleObjects[] = $currentArticle;
        }

        $myDataAccess->closeDB();
        return $currentArticleObjects;

    }

    public static function retrieveSingleArticle($articleID)
    {
        $myDataAccess = new ArticleDataAccess();
        $myDataAccess->connectToDB();

        $myDataAccess->selectArticle($articleID);

        while($row = $myDataAccess->fetchArticle())
        {
            $currentArticle = new self(
                $myDataAccess->fetchName($row),
                $myDataAccess->fetchTitle($row),
                $myDataAccess->fetchDescription($row),
                $myDataAccess->fetchHTML($row),
                $myDataAccess->fetchPageID($row),
                $myDataAccess->fetchDivID($row),
                $myDataAccess->fetchAllPages($row),
                $myDataAccess->fetchCreatedBy($row),
                $myDataAccess->fetchModifiedBy($row)
            );
            $currentArticle->articleID = $myDataAccess->fetchArticleID($row);
        }

        $myDataAccess->closeDB();

        return $currentArticle;

    }

    //Retrieve a Articles by associated page & div IDs
    public static function getArticlesByPageAndDivIDs($pageID, $divID)
    {
        $myDataAccess = new ArticleDataAccess();
        $myDataAccess->connectToDB();
        $myDataAccess->getArticlesByDivAndPageID($pageID, $divID);

        $currentArticleObjects[] = null;

        while ($row = $myDataAccess->fetchArticles())
        {

            $currentArticle = new self($myDataAccess->fetchName($row),$myDataAccess->fetchTitle($row),$myDataAccess->fetchDescription($row),
                $myDataAccess->fetchHTML($row),$myDataAccess->fetchPageID($row),$myDataAccess->fetchDivID($row),
                $myDataAccess->fetchAllPages($row),$myDataAccess->fetchCreatedBy($row),
                $myDataAccess->fetchModifiedBy($row));
            $currentArticle->setCreateDate($myDataAccess->fetchCreated($row));
            $currentArticle->setModifiedDate($myDataAccess->fetchLastModified($row));
            $currentArticle->setID($myDataAccess->fetchArticleID($row));
            $currentArticleObjects[] = $currentArticle;
        }
        return $currentArticleObjects;
        $myDataAccess->closeDB();
    }

    public function setID($id)
    {
        $this->articleID = $id;
    }

    public function setCreateDate($createDate)
    {
        $this->createdDate = $createDate;
    }

    public function setModifiedDate($modifiedDate)
    {
        $this->createdDate = $modifiedDate;
    }


    // SAVE/INSERT
    public function save()
    {
        $DataLayer = new articleDataAccess();
        $DataLayer->connectToDB();
        $DataLayer->saveArticle($this->name, $this->title, $this->description, $this->pageID,
            $this->divID, $this->html, $this->createdBy, $this->modifiedBy, $this->allPages);
        $DataLayer->closeDB();
    }
    // UPDATE
    public function update($in_name,$in_title, $in_description, $in_pageID, $in_divID, $in_content, $in_modifiedBy, $in_allPages)
    {
        $DataLayer = new articledataAccess();
        $DataLayer->connectToDB();
        $DataLayer->updateArticle($this->articleID,$in_name, $in_title, $in_description, $in_pageID, $in_divID, $in_content,$in_modifiedBy, $in_allPages);
        $DataLayer->closeDB();

    }

    public static function setPageIDZero($in_id){
        $DataLayer = new articleDataAccess();
        $DataLayer->connectToDB();
        $DataLayer->setPageZero($in_id);
        $DataLayer->closeDB();
    }
//    // DELETE
//    public static function delete($id)
//    {
//        $DataLayer = new articleDataAccess();
//        $DataLayer->connectToDB();
//        $DataLayer->deleteArticle($id);
//    }
    //REMOVE******************
    public function remove()
    {
        $myDataAccess = new ArticleDataAccess();
        $myDataAccess->connectToDB();
        $affectedRows = $myDataAccess->setPageZero($this->articleID);

        $myDataAccess->closeDB();

        return "$affectedRows row(s) affected!";
    }
    // GETTERS

//    public static function getAllArticles()
//    {
//        $DataLayer = new articleDataAccess();
//        $DataLayer->connectToDB();
//        return $DataLayer->getAllArticles();
//    }
    public static function getAllPagesArticles()
    {
        $myDataAccess = new articleDataAccess();
        $myDataAccess->connectToDB();
        $myDataAccess->getAllPagesArticles();

        while ($row = $myDataAccess->fetchArticles())
        {

            $currentArticle = new self($myDataAccess->fetchName($row),$myDataAccess->fetchTitle($row),$myDataAccess->fetchDescription($row),
                $myDataAccess->fetchHTML($row),$myDataAccess->fetchPageID($row),$myDataAccess->fetchDivID($row),
                $myDataAccess->fetchAllPages($row),$myDataAccess->fetchCreatedBy($row),
                $myDataAccess->fetchModifiedBy($row));
            $currentArticle->createdDate = $myDataAccess->fetchCreated($row);
            $currentArticle->modifiedDate = $myDataAccess->fetchLastModified($row);
            $currentArticle->articleID = $myDataAccess->fetchArticleID($row);
            $currentArticleObjects[] = $currentArticle;
        }

        $myDataAccess->closeDB();
        return $currentArticleObjects;
    }
    public static function getArticleBody($pageID, $divID)
    {
        $DataLayer = new articleDataAccess();
        $DataLayer->connectToDB();
        return $DataLayer->getArticle($pageID, $divID)[0]['HTML'];
    }

    public function getArticleID()
    {
        return $this->articleID;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getPageID()
    {
        return $this->pageID;
    }

    public function getDivID()
    {
        return $this->divID;
    }

    public function getCreated()
    {
        return $this->createdDate;
    }

    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    public function getLastModified()
    {
        return $this->modifiedDate;
    }

    public function getModifiedBy()
    {
        return $this->modifiedBy;
    }

    public function getHTML()
    {
        return $this->html;
    }

    public function getAllPagesCondition()
    {
        return $this->allPages;
    }
}
