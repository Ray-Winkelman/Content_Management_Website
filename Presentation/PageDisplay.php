<?php

//Guard functionality - Must be logged in as an editor to access this page
require_once('../Business/User.php');
if(!(isset($_SESSION['username']) && User::isEditor($_SESSION['username']))){
    header("Location: ../Presentation/backend.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Page Management</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- BOOTSTRAP IE Handler -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

    <!--  CDN for JQuery Validation plugin -->
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.js"></script>
    <script src ="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/additional-methods.js"> </script>

    <!-- A LIST OF ALL RULES FOR THE VALIDATION CAN BE FOUND HERE http://www.javascript-coder.com/form-validation/jquery-form-validation-guide.phtml#rules_reference -->
    <!-- This script could potentially be moved into another file though I'm not sure how that would work with all our validation routines. -->
    <script>

    	$.validator.setDefaults({
		submitHandler: function() {
			alert("Success!");
			form.submit();

		}
	});

	$().ready(function() {

		// validate the comment form when it is submitted
		// validate signup form on keyup and submit
		$("#addPage").validate({
			rules: {

				addPageName: {
					required: true,
					minlength: 2
				},

				addPageAlias: {
					required: true,
					minlength: 2,
                    pattern: /^[a-zA-Z0-9\-_\.]{0,40}$/

				},

				updatePageName:{
					required: true,
					minlength:2
				},

				updatePageAlias: {
					required: true,
					minlength: 2,
                    pattern: /^[a-zA-Z0-9\-_\.]{0,40}$/
				},

			},

			messages: {

				addPageName:{
					required: "Please enter a name for the new page.",
					minlength: "Name must be at least two characters."
				},

				addPageAlias:{
					required: "Please enter an alias for the new page.",
					minlength: "Alias must be at least two characters.",
					pattern: "Invalid page alias."
				},

				updatePageName:{
					required: "Please enter a name for the new page.",
					minlength: "Name must be at least two characters."
				},

				updatePageAlias:{
					required: "Please enter an alias for the new page.",
					minlength: "Alias must be at least two characters.",
					pattern: "Invalid page alias."
				},

			}
		});
	});
  </script>

 </head>

 <body>

<?php  // If a delete is incoming
 if (isset($_GET['deletePageID'])) {

 	$page= Page::retrievePageById($_GET['deletePageID']);
 	$page->delete();
}


 // If a update is incoming
 if (isset($_GET['updatepage'])) {

	$updatePage = Page::retrievePageById($_POST['updatePageID']);
	$updatePage->setAlias($_POST['updatePageAlias']);
	$updatePage->setName($_POST['updatePageName']);
	$updatePage->setDescription($_POST['updatePageDescription']);
	$updatePage->setModifiedBy(1);
	$updatePage->update();

}


// If a update is incoming
if (isset($_GET['addpage'])) {

	$addPage = new Page($_POST['addPageName'],$_POST['addPageAlias'], $_POST['addPageDescription'], 1); // TODO This needs to be retrieved from session
	$addPage->save();
}

?>

    <table class="table table-bordered table-condensed table-striped table-responsive">
    <thead>
    <tr>
        <td>Page id</td>
        <td>Page Name</td>
        <td>Alias</td>
        <td colspan="3">Description</td>
    </tr>
    </thead>
    <tbody>
    <?php

    $currentPage = Page::retrieveData();

    foreach($currentPage as $page):
        ?>
        <tr>
            <td><?php echo $page->getId()?></td>
            <td><?php echo $page->getName()?></td>
            <td><?php echo $page->getAlias()?></td>
            <td><?php echo $page->getDescription()?></td>
            <!-- Update and delete functionality -->
			<td> <a href="./backend.php?pages=1&updatepageid=<?php echo $page->getId();?>">U</a></td>
		    <!-- This is the portion that needs to be hidden if the user does not have delete priviledges -->
           <td> <a class="confirmation" href="./backend.php?pages=1&deletePageID=<?php echo $page->getId();?>">  <font color="red">X</font> </a></td>

    <?php endforeach ?>

    </tbody>

</table>

<?php
if (1 == 1 && !isset($_GET['updatepageid'])) {
    include("./PageInsertForm.php");
}
if (1 == 1 && isset($_GET['updatepageid'])) {
     include("./PageUpdateForm.php");
}?>
</body>
</html>
