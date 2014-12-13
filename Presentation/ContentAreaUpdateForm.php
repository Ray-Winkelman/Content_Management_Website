<?php

//Guard functionality - Must be logged in as an editor to access this page
require_once('../Business/User.php');
if(!(isset($_SESSION['username']) && User::isEditor($_SESSION['username']))){
    header("Location: ../Presentation/backend.php");
    exit;
}
?>

$divId = 0; // holds variables for form population
$divOrder = 0;
$divAlias = "";
$divName = "";
$divDescription = "";

if(isset($_GET['updateDivID'])){ // populates the fields if there is an update div id

	$divId = $_GET['updateDivID'];
	$contentArea = ContentArea::retrieveOne($divId);
	$divName = $contentArea->getName();
	$divOrder = $contentArea->getDivOrder();
	$divAlias = $contentArea->getAlias();
	$divDescription = $contentArea->getDescription();

} ?>


<form action="./backend.php?content=1&divUpdate=1" method=POST class="form-horizontal" role="form" id="addForm">

  <div class="form-group">
  	<label for="addDivName" class="col-sm-4 control-label">Div Name</label>
  		<div class="col-sm-4">
  			<input type="text" class="form-control" id="updateDivName" name="updateDivName" value="<?php echo $divName;?>" placeholder="Name of Div" required>
  		</div>
  </div>

  <input type="hidden" name="updateDivID" value="<?php echo $divId;?>"/>

    <div class="form-group">
  	<label for="updateDivAlias" class="col-sm-4 control-label">Alias</label>
  		<div class="col-sm-4">
  			<input type="text" class="form-control" id="updateDivAlias" name="updateDivAlias" value="<?php echo $divAlias;?>" placeholder="Alias" required="true" pattern="^[a-zA-Z0-9\-_]{0,40}$"[A-Za-z]{3}">
  		</div>
 	 </div>

 	 <div class="form-group">
  	<label for="updateDivOrder" class="col-sm-4 control-label">Order</label>
  	<div class="col-sm-4">
  	<input type="number" class="form-control" id="updateDivOrder" name="updateDivOrder" value="<?php echo $divOrder;?>" placeholder="1" min="1" required >
  	</div>
 	 </div>

 	<div class="form-group">
   		<label for="updateDivDescription" class="col-sm-4 control-label">Description</label>
  			<div class="col-sm-4">
  				<input type="text" class="form-control" id="updateDivDescription" name="updateDivDescription" value="<?php echo $divDescription;?>" placeholder="Description" >
  			</div>
 	 </div>

    <div class="form-group">
    	<div class="col-sm-offset-4 col-sm-4">
      		<button type="submit" style="float: right;" class="btn btn-default">Update Div</button>
    	</div>
  </div>

  </form>
