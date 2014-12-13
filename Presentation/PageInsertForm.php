<?php

//Guard functionality - Must be logged in as an editor to access this page
require_once('../Business/User.php');
if(!(isset($_SESSION['username']) && User::isEditor($_SESSION['username']))){
    header("Location: ../Presentation/backend.php");
    exit;
}
?>

<form action="./backend.php?pages=1&addpage=1" method=POST class="form-horizontal" role="form" id="addPage" name="addPage">

  <div class="form-group">
  	<label for="addPageName" class="col-sm-4 control-label">Page Name</label>
  		<div class="col-sm-4">
  			<input type="text" class="form-control" id="addPageName" name="addPageName" placeholder="Name of Page" required>
  		</div>
  </div>

    <div class="form-group">
  	<label for="addPage Alias" class="col-sm-4 control-label">Page Alias</label>
  		<div class="col-sm-4">
  			<input type="text" class="form-control" id="addPageAlias" name="addPageAlias" placeholder="Alias" required pattern="^[a-zA-Z0-9\-_\.]{0,40}$">
  		</div>
 	 </div>

 	<div class="form-group">
  	<label for="addPageDescription" class="col-sm-4 control-label">Description</label>
  	<div class="col-sm-4">
  	<input type="text" class="form-control" id="addPageDescription" name="addPageDescription" placeholder="Description">
  	</div>
 	 </div>

    <div class="form-group">
    	<div class="col-sm-offset-4 col-sm-4">
      		<button type="submit" style="float: right;" class="btn btn-default">Add Page</button>
    	</div>
  </div>

  </form>
