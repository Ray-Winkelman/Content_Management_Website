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
    <title>Testing Content Area</title>

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
    <script src ="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/additional-methods.js"> </script> <!--  NOTE: I need this .js for my regex, so be sure to include it -->

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
		$("#addForm").validate({
			rules: {

				addDivOrder:{
					required: true,
					min:1
				},

				addDivName: {
					required: true,
					minlength: 2
				},

				addDivAlias: {
					required: true,
					minlength: 2,
					pattern: /^[a-zA-Z0-9\-_]{0,40}$/

				},

				updateDivOrder:{
					required: true,
					min:1
				},

				updateDivName: {
					required: true,
					minlength: 2
				},

				updateDivAlias: {
					required: true,
					minlength: 2,
					pattern: /^[a-zA-Z0-9\-_]{0,40}$/

				},

			},
			messages: {

				addDivName:{
					required: "Please enter a name for the new div.",
					minlength: "Name must be at least two characters."
				},

				addDivAlias:{
					required: "Please enter an alias for the new div.",
					minlength: "Alias must be at least two characters.",
					pattern: "Invalid format."
				},

				addDivOrder:{
					required: "Please specify an order for the div to appear."
				},


				updateDivName:{
					required: "Please enter a name for the new div.",
					minlength: "Name must be at least two characters."
				},

				updateDivAlias:{
					required: "Please enter an alias for the new div.",
					minlength: "Alias must be at least two characters.",
					pattern: "Invalid format."
				},

				updateDivOrder:{
					required: "Please specify an order for the div to appear."
				},


			}
		});
	});

</script>
 </head>

<body>

 <!-- Handles deleting  -->
<?php  if (isset($_GET['deleteDivID'])) {
 	$contentArea = ContentArea::retrieveOne($_GET['deleteDivID']);
 	$contentArea->remove();

} ?>


<!-- Handles updating -->
<?php  if (isset($_GET['divUpdate'])) {

 	$contentArea = ContentArea::retrieveOne($_POST['updateDivID']);
 	$contentArea->update($_POST['updateDivAlias'],
        User::getTheUserID($_SESSION['username']), $_POST['updateDivDescription'],$_POST['updateDivOrder'],$_POST['updateDivName']);

} ?>

<!-- Handles inserting -->
<?php if (isset($_GET['divAdd'])) {

	$newContentArea = new ContentArea($_POST['addDivAlias'],$_POST['addDivDescription'], "" , $_POST['addDivOrder'], $_POST['addDivName']);
	$newContentArea->setModifiedBy(User::getTheUserID($_SESSION['username']));
	$result = $newContentArea->save();

} ?>

    <table class="table table-bordered table-condensed table-striped table-responsive">
		<thead>
			<tr>
                <td>Div ID</td>
				<td>Name</td>
				<td>Alias</td>
				<td>Description</td>
				<td colspan=3>Order</td>
			</tr>
		</thead>
		<tbody>

 <!--  Get all content areas from the database -->
<?php $contentAreas = ContentArea::retrieveAll ();

			if ($contentAreas != NULL) {

			foreach ( $contentAreas as $contentArea ) :

				?>
		             <tr>
                        <td><?php echo $contentArea->getDivID() ?></td>
						<td><?php echo 	$contentArea->getName() 	    ?></td>
						<td><?php echo 	$contentArea->getAlias()	    ?></td>
						<td><?php echo  $contentArea->getDescription()  ?></td>
						<td><?php echo  $contentArea->getDivOrder()  	?></td>

						<!-- Update and delete functionality -->
						<td> <a href="./backend.php?content=1&updateDivID=<?php echo $contentArea->getDivID();?>">U</a></td>
						<!-- This is the portion that needs to be hidden if the user does not have delete priviledges -->
		                <td> <a class="confirmation" href="./backend.php?content=1&deleteDivID=<?php echo $contentArea->getDivID();?>">  <font color="red">X</font> </a></td>

					</tr>

	       <?php endforeach;} ?>

	       </tbody>
	</table>

<!-- Insert Guard -->

<?php if (1 == 1 && !isset($_GET['updateDivID'])) {
    include("./ContentInsertForm.php");
}

if (1 == 1 && isset($_GET['updateDivID'])) {
     include("./ContentAreaUpdateForm.php");
}?>

<!-- Script to prevent accidental deletes -->
<script type="text/javascript">
		$('.confirmation').on('click', function () {
		    return confirm('Are you sure?');
		});
</script>

</body>
</html>
