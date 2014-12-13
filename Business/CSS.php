<?php include('../Data/CSSDataAccessPDOMySQL.php');

class CSS
{
    // MEMBERS
    protected $name;
    protected $description;
    protected $active_state;
    protected $createdBy;
    protected $createdDate;
    protected $modifiedBy;
    protected $modifiedDate;
    protected $cssBody = "";

    // CONSTRUCTOR
    public function __construct()
    {

    }

    // CREATE (CUSTOM CONSTRUCTOR)
    public function create($name, $description, $active_state,
                           $createdBy, $createdDate, $modifiedBy,
                           $modifiedDate, $cssBody)
    {
        $this->name = $name;
        $this->description = $description;
        $this->active_state = $active_state;
        $this->createdBy = $createdBy;
        $this->createdDate = $createdDate;
        $this->modifiedBy = $modifiedBy;
        $this->modifiedDate = $modifiedDate;
        $this->cssBody = $cssBody;
    }

    // SAVE/INSERT
    public function save()
    {
        $DataLayer = new MySQL();
        $DataLayer->connectToDB();
        $DataLayer->saveCSS($this->name, $this->description,
            $this->active_state, $this->createdBy, $this->createdDate,
            $this->modifiedBy, $this->modifiedDate, $this->cssBody);
    }

    // UPDATE
    public function update($id)
    {
        $DataLayer = new MySQL();
        $DataLayer->connectToDB();
        $DataLayer->updateCSS($id, $this->name, $this->description,
            $this->active_state, $this->modifiedBy, $this->modifiedDate,
            $this->cssBody);
    }

    // DELETE
    public static function delete($id)
    {
        $DataLayer = new MySQL();
        $DataLayer->connectToDB();
        $DataLayer->deleteCSS($id);
    }

    // GETTERS
    public function getAllActiveCSS()
    {
        $DataLayer = new MySQL();
        $DataLayer->connectToDB();
        return $DataLayer->getAllActiveCSS();
    }

    public static function getAllCSS()
    {
        $DataLayer = new MySQL();
        $DataLayer->connectToDB();
        return $DataLayer->getAllCSS();
    }

    public function getAllActiveCSSString()
    {
        $cssString = "";
        foreach ($this->getAllActiveCSS() as $cssItem) :
            $cssString .= $cssItem['Content'];
        endforeach;
        return $cssString;
    }
}
