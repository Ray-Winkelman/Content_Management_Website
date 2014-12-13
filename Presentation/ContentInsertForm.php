<?php

//Guard functionality - Must be logged in as an editor to access this page
require_once('../Business/User.php');
if(!(isset($_SESSION['username']) && User::isEditor($_SESSION['username']))){
    header("Location: ../Presentation/backend.php");
    exit;
}
?>

<form action="./backend.php?content=1&divAdd=1" method=POST class="form-horizontal" role="form" id="addForm">

  <div class="form-group">
  	<label for="addDivName" class="col-sm-4 control-label">Div Name</label>
  		<div class="col-sm-4">
  			<input type="text" class="form-control" id="addDivName" name="addDivName" placeholder="Name of Div">
  		</div>
  </div>


    <div class="form-group">
  	<label for="addDivAlias" class="col-sm-4 control-label">Alias</label>
  		<div class="col-sm-4">
  			<input type="text" class="form-control" id="addDivAlias" name="addDivAlias" placeholder="Alias" required pattern="^[a-zA-Z0-9\-_]{0,40}$">
  		</div>
 	 </div>

 	 <div class="form-group">
  	<label for="addDivOrder" class="col-sm-4 control-label">Order</label>
  	<div class="col-sm-4">
  	<input type="number" class="form-control" id="addDivOrder" name="addDivOrder" placeholder="1" min="1" required>
  	</div>
 	 </div>

 	<div class="form-group">
   		<label for="addDivDescription" class="col-sm-4 control-label">Description</label>
  			<div class="col-sm-4">
  				<input type="text" class="form-control" id="addDivDescription" name="addDivDescription" placeholder="Description">
  			</div>
 	 </div>

    <div class="form-group">
    	<div class="col-sm-offset-4 col-sm-4">
      		<button type="submit" style="float: right;" class="btn btn-default">Add Div</button>
    	</div>
  </div>

  </form>
