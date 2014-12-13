<?php

//Guard functionality - Must be logged in as an editor to access this page
require_once('../Business/User.php');
if(!(isset($_SESSION['username']) && User::isEditor($_SESSION['username']))){
    header("Location: ../Presentation/backend.php");
    exit;
}
?>

<html>
<head>
    <title>CSS Back End Page</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
        <!--  CDN for JQuery Validation plugin -->

     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.js"></script>
    <script src ="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/additional-methods.js"> </script>


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

			addCSSName: {
				required: true,
			},

			addCSSContent:{
				required: true,
			},

		},

		messages: {

			addCSSName:{
				required: "Please enter a name for the new CSS.",
				minlength: "Name must be at least two characters."
			},

			addCSSContent:{
				required: "Please enter some content for the CSS.",
				minlength: "Please enter at least eight characters",
			},

		}
	});

	$("#updateForm").validate({
		rules: {

			updateCSSName: {
				required: true,
			},

			updateCSSContent:{
				required: true,
			},

		},

		messages: {

			addCSSName:{
				required: "Please enter a name for the new CSS.",
				minlength: "Name must be at least two characters."
			},

			addCSSContent:{
				required: "Please enter some content for the CSS.",
				minlength: "Please enter at least eight characters",
			},
			updateCSSName:{
				required: "Please enter a name for the new CSS.",
			},
			updateCSSContent:{
				required: "Please enter some content for the CSS.",
			},

		}
	});
});
</script>




</head>
<body>

<?php
if (isset($_GET['deleteid'])) {
    CSS::delete($_GET['deleteid']);
}
if (isset($_POST['addCSSName'])) {
    $insertCSS = new CSS();
    $timestamp = date('Y-m-d G:i:s');

    $insertCSS->create($_POST['addCSSName'],
        $_POST['addCSSDescription'],
        $_POST['addCSSActive'],
        1,
        $timestamp,
        1,
        $timestamp,
        $_POST['addCSSContent']);

    $insertCSS->save();

} else if (isset($_POST['updateCSSName'])) {
    $updateCSS = new CSS();
    $timestamp = date('Y-m-d G:i:s');

    $updateCSS->create($_POST['updateCSSName'],
        $_POST['updateCSSDescription'],
        $_POST['updateCSSActive'],
        1,
        $timestamp,
        1,
        $timestamp,
        $_POST['updateCSSContent']);

    $updateCSS->update($_POST['updateID']);
} ?>
<table class="table table-bordered table-condensed table-striped table-responsive">
    <thead>
    <tr>
        <td>Name</td>
        <td>Description</td>
        <td>Active</td>
        <td>Created</td>
        <td>Created By</td>
        <td>Modified</td>
        <td>Modified By</td>
    </tr>
    </thead>
    <tbody>
    <?php $cssList = CSS::getAllCSS();
    if ($cssList != NULL) {
        foreach ($cssList as $cssItem) :
            if (isset($_GET['updateid']) && $cssItem["CSSID"] == $_GET['updateid']) {
                $update = $cssItem;
            } ?>
            <tr>
                <td><?php echo $cssItem["Name"]; ?></td>
                <td><?php echo $cssItem["Description"]; ?></td>
                <td><?php echo $cssItem["Active"]; ?></td>
                <td><?php echo $cssItem["Created"]; ?></td>
                <td><?php echo $cssItem["CreatedBy"]; ?></td>
                <td><?php echo $cssItem["LastModified"]; ?></td>
                <td><?php echo $cssItem["ModifiedBy"]; ?></td>

                <td><a href="./backend.php?css=1&updateid=<?php echo $cssItem["CSSID"]; ?>">U</a></td>

                <td><a class="confirmation" href="./backend.php?css=1&deleteid=<?php
                    echo $cssItem["CSSID"]; ?>"> <font color="red">X</font> </a></td>
            </tr>
        <?php endforeach;
    } ?>
    </tbody>
</table>
<?php
if (1 == 1 && !isset($_GET['updateid'])) {
    include("./CSS_Insert_Form.php");
}
if (1 == 1 && isset($_GET['updateid'])) {
    include("./CSS_Update_Form.php");
}?>
</body>
</html>
