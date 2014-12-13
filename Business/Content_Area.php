<?php

require_once '../Data/aContentAreaDataAccess.php';

class ContentArea {

    private $m_alias;
    private $m_created;
    private $m_createdBy;
    private $m_description;
    private $m_divID;
    private $m_divOrder;
    private $m_lastModified;
    private $m_modifiedBy;
    private $m_name;


    // constructor
    public function __construct($in_alias, $in_description, $in_divID, $in_divOrder, $in_name)
    {
        $this->m_alias = $in_alias;
        //$this->m_created = $in_created;
        //$this->m_createdBy = $in_createdBy;
        $this->m_description = $in_description;
        $this->m_divID = $in_divID;
        $this->m_divOrder = $in_divOrder;
        //$this->m_lastModified = $in_lastModified;
        //$this->m_modifiedBy = $in_modifiedBy;
        $this->m_name = $in_name;
    }



    // inserts the current object from the database
    public function save(){

        $myDataAccess = aContentAreaDataAccess::getInstance();
        $myDataAccess->connectToDB();
        $affectedRows = $myDataAccess->insertDiv($this->m_alias, $this->m_createdBy, $this->m_description, $this->m_divOrder, $this->m_name);
        $myDataAccess->closeDB();

        return "$affectedRows row(s) affected!";
    }

    // removes the current object from the database
    public function remove(){

        $myDataAccess = aContentAreaDataAccess::getInstance();
        $myDataAccess->connectToDB();
        $affectedRows = $myDataAccess->removeDiv($this->m_divID);
        $myDataAccess->closeDB();

        return "$affectedRows row(s) affected!";
    }

    // update the record with the new values
    public function update($alias, $modifiedBy, $description, $divOrder, $name){
        $myDataAccess = aContentAreaDataAccess::getInstance();
        $myDataAccess->connectToDB();
        $affectedRows = $myDataAccess->updateDiv($alias, $modifiedBy, $description, $divOrder, $name, $this->m_divID);
        $myDataAccess->closeDB();

        return "$affectedRows row(s) affected!";
    }


    public static function retrieveOne($divID){

        $myDataAccess = aContentAreaDataAccess::getInstance();

        $myDataAccess->connectToDB();

        $myDataAccess->selectDiv($divID);


        while($row = $myDataAccess->fetchDiv())
        {
            $currentDiv = new self(
                $myDataAccess->fetchAlias($row),
                //$myDataAccess->fetchCreated($row),
                //$myDataAccess->fetchCreatedBy($row),
                $myDataAccess->fetchDescription($row),
                $myDataAccess->fetchDivId($row),
                $myDataAccess->fetchDivOrder($row),
                //$myDataAccess->fetchLastModified($row),
                //$myDataAccess->fetchModifiedBy($row),
                $myDataAccess->fetchName($row)
            );
        }

        $myDataAccess->closeDB();

        return $currentDiv;

    }


    // retrieves all the divs in the database
    public static function retrieveAll(){

        $myDataAccess = aContentAreaDataAccess::getInstance();

        $myDataAccess->connectToDB();

        $myDataAccess->selectDivs();

        $numberOfRecords = 0;

        while($row = $myDataAccess->fetchDivs())
        {
            $currentDiv = new self(
                $myDataAccess->fetchAlias($row),
                //$myDataAccess->fetchCreated($row),
                //$myDataAccess->fetchCreatedBy($row),
                $myDataAccess->fetchDescription($row),
                $myDataAccess->fetchDivId($row),
                $myDataAccess->fetchDivOrder($row),
                //$myDataAccess->fetchLastModified($row),
                //$myDataAccess->fetchModifiedBy($row),
                $myDataAccess->fetchName($row)
            );

            $arrayOfDivs[] = $currentDiv;

        }

        $myDataAccess->closeDB();

        return $arrayOfDivs;
    }



    public function setModifiedBy($userID){
        $this->m_modifiedBy = $userID;

        if($this->m_createdBy == NULL || $this->m_createdBy == ""){
            $this->m_createdBy = $userID;
        }


    }

    // Some getters for proof of concept we can add more as we need them
    public function getName(){
        return $this->m_name;
    }
    
    
    
    public function getAlias(){
        return $this->m_alias;
    }

    /*
    public function getCreatedDate(){
        return $this->m_created;
    } */

    public function getDescription(){
        return $this->m_description;
    }

    public function getDivOrder(){
        return $this->m_divOrder;
    }

    public function getDivID(){
        return $this->m_divID;
    }


}
