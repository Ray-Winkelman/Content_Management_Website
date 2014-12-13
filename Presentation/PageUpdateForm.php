<?php

//Guard functionality - Must be logged in as an editor to access this page
require_once('../Business/User.php');
if(!(isset($_SESSION['username']) && User::isEditor($_SESSION['username']))){
    header("Location: ../Presentation/backend.php");
    exit;
}

$pageID = "";
$pageName = "";
$pageAlias = "";
$pageDescription = "";


// Fill the prepopulated fields
if(isset($_GET['updatepageid'])){

	$pageID = $_GET['updatepageid'];
	$updatePage = Page::retrievePageById($pageID);
	$pageName = $updatePage->getName();
	$pageAlias = $updatePage->getAlias();
	$pageDescription = $updatePage->getDescription();

} ?>


<form action="./backend.php?pages=1&updatepage=1" method=POST class="form-horizontal" role="form" id="addPage">

  <div class="form-group">
  	<label for="addDivName" class="col-sm-4 control-label">Page Name</label>
  		<div class="col-sm-4">
  			<input type="text" class="form-control" id="addPageName" name="updatePageName" value="<?php echo $pageName;?>" placeholder="Name of Page" required>
  		</div>
  </div>

    <input type="hidden" name="updatePageID" value="<?php echo $pageID?>"/>

    <div class="form-group">
  	<label for="updatePageAlias" class="col-sm-4 control-label">Page Alias</label>
  		<div class="col-sm-4">
  			<input type="text" class="form-control" id="addPageAlias" name="updatePageAlias" value="<?php echo $pageAlias;?>" placeholder="Alias" required pattern="^[a-zA-Z0-9\-_\.]{0,40}$">
  		</div>
 	 </div>

 	 <div class="form-group">
  	<label for="updatePageDescription" class="col-sm-4 control-label">Description</label>
  	<div class="col-sm-4">
  	<input type="text" class="form-control" name="updatePageDescription" id="updatePageDescription" value="<?php echo $pageDescription;?>" placeholder="Description" >
  	</div>
 	 </div>

    <div class="form-group">
    	<div class="col-sm-offset-4 col-sm-4">
      		<button type="submit" style="float: right;" class="btn btn-default">Update Page</button>
    	</div>
  </div>

  </form>


