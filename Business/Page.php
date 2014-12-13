<?php
require("../Data/aPageDataAccess.php");

class Page{

    private $m_pageId;
    private $m_name;
    private $m_alias;
    private $m_description;
    private $m_created;
    private $m_createdBy;
    private $m_modified;
    private $m_modifiedBy;
    private $divs;

    public function __construct($in_name, $in_alias, $in_description,$in_createdBy)
    {
        $this->m_name = $in_name;
        $this->m_alias = $in_alias;
        $this->m_description = $in_description;
        $this->m_createdBy = $in_createdBy;

    }

    //Setters
    public function setName($in_name)
    {
        $this->m_name=$in_name;
    }

    public function setAlias($in_alias)
    {
        $this->m_alias=$in_alias;
    }

    public function setDescription($in_description)
    {
        $this->m_description = $in_description;
    }

    public function setCreatedBy($in_created_by)
    {
        $this->m_createdBy = $in_created_by;
    }

    public function setModifiedBy($in_modified_by)
    {
        $this->m_modifiedBy = $in_modified_by;
    }

    //Getters
    public function getId()
    {
        return $this->m_pageId;
    }

    public function getName()
    {
        return $this->m_name;
    }

    public function getAlias()
    {
        return $this->m_alias;
    }

    public function getDescription()
    {
        return $this->m_description;
    }

    public function getCreateDate()
    {
        return $this->m_created;
    }

    public function getCreatedBy()
    {
        return $this->m_createdBy;
    }

    public function getModifiedDate()
    {
        return $this->m_modified;
    }

    public function getModifiedBy()
    {
        return $this->m_modifiedBy;
    }

    //Returns an array of Page objects
    public static function retrieveData()
    {
        $myDataAccess = aPageDataAccess::getDataAccess();
        $myDataAccess->connectToDB();

        $myDataAccess->selectPages();

        while($row = $myDataAccess->fetchPages())
        {
            $currentPage = new self($myDataAccess->fetchPageName($row),$myDataAccess->fetchPageAlias($row),
                            $myDataAccess->fetchPageDescription($row), $myDataAccess->fetchPageCreatedBy($row));

            $currentPage->m_pageId = $myDataAccess->fetchPageID($row);
            $currentPage->m_created = $myDataAccess->fetchPageCreated($row);
            $currentPage->m_modified = $myDataAccess->fetchPageLastModified($row);
            $currentPage->m_modifiedBy = $myDataAccess->fetchPageModifiedBy($row);
            $currentPageObjects[] = $currentPage;
        }

        return $currentPageObjects;

        $myDataAccess->closeDB();

    }

    public static function retrievePageById($in_id)
    {
        $myDataAccess = aPageDataAccess::getDataAccess();
        $myDataAccess->connectToDB();
        $myDataAccess->selectPageById($in_id);
        while($row = $myDataAccess->fetchPages())
        {
            $currentPage = new self($myDataAccess->fetchPageName($row),$myDataAccess->fetchPageAlias($row),
                $myDataAccess->fetchPageDescription($row), $myDataAccess->fetchPageCreatedBy($row));
            $currentPage->m_pageId = $myDataAccess->fetchPageID($row);
            $currentPage->m_created = $myDataAccess->fetchPageCreated($row);
            $currentPage->m_modified = $myDataAccess->fetchPageLastModified($row);
            $currentPage->m_modifiedBy = $myDataAccess->fetchPageModifiedBy($row);
        }

        return $currentPage;

        $myDataAccess->closeDB();
    }

    public function save()
    {

        $myDataAccess = aPageDataAccess::getDataAccess();
        $myDataAccess->connectToDB();

        $recordsAffected = $myDataAccess->insertPage($this->m_name,$this->m_alias,$this->m_description,$this->m_createdBy);

        $myDataAccess->closeDB();

        return "$recordsAffected row(s) affected!";

    }

    public function update()
    {

        $myDataAccess = aPageDataAccess::getDataAccess();
        $myDataAccess->connectToDB();

        $recordsAffected = $myDataAccess->updatePage($this->m_name,$this->m_alias,$this->m_description,$this->m_modifiedBy, $this->m_pageId);

        $myDataAccess->closeDB();

        return "$recordsAffected row(s) affected!";

    }

    public function delete()
    {
        $myDataAccess = aPageDataAccess::getDataAccess();
        $myDataAccess->connectToDB();

        $recordsAffected = $myDataAccess->deletePage($this->m_pageId);

        $myDataAccess->closeDB();

        return "$recordsAffected row(s) affected!";
    }
}
