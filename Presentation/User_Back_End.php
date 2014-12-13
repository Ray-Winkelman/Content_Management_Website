<?php

//Guard functionality - Must be logged in as an admin to access this page
require_once('../Business/User.php');
if(!(isset($_SESSION['username']) && User::isAdmin($_SESSION['username']))){
    header("Location: ../Presentation/backend.php");
    exit;
}
?>

<html>
<head>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
    <!--  CDN for JQuery Validation plugin -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.js"></script>
    <script src ="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/additional-methods.js"> </script> <!--  NOTE: I need this .js for my regex, so be sure to include it -->

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
		$("#addUser").validate({
			rules: {

				userName:{
					required: true,
					minlength:8
				},

				password: {
					required: true,
					minlength: 8
				},

				firstName: {
					required: true,
				},

				lastName: {
					required: true,
				},


			},
			messages: {

				userName:{
					required: "Please enter a user name.",
					minlength: "User name must be at least eight characters.",
					pattern: "User name must be at least eight characters.",
				},

				password: {
					required: "Password required.",
					minlength: "Must be at least eight characters.",
					pattern: "Must be at least eight characters."
				},

				firstName: {
					required: "First name required.",
				},

				lastName: {
					required: "Last name required."
				},



			}
		});

		$("#updateUser").validate({
			rules: {

				userName:{
					required: true,
					minlength:8
				},

				password: {
					required: true,
					minlength: 8
				},

				firstName: {
					required: true,
				},

				lastName: {
					required: true,
				},


			},
			messages: {

				userName:{
					required: "Please enter a user name.",
					minlength: "User name must be at least eight characters.",
					pattern: "User name must be at least eight characters.",
				},

				password: {
					required: "Password required.",
					minlength: "Must be at least eight characters.",
					pattern: "Must be at least eight characters."
				},

				firstName: {
					required: "First name required.",
				},

				lastName: {
					required: "Last name required."
				},



			}
		});


	});

</script>

</head>
<body>

<?php
if (isset($_GET['deleteid'])) {
    $userToDelete = User::retrieveUserById($_GET['deleteid']);
    $userToDelete->delete();
}
if (isset($_POST['addUser'])) {
    $userToInsert = new User($_POST['userName'],$_POST['password'],$_POST['firstName'],
        $_POST['lastName'], $_SESSION['username'], $_SESSION['username']);
    $userToInsert->save($_POST['admin'], $_POST['editor'], $_POST['author']);
}
if (isset($_POST['updateUser'])) {
    $userToUpdate = User::retrieveUserById($_POST['userID']);
    $userToUpdate->setUserName($_POST['userName']);
    $userToUpdate->setFirstName($_POST['firstName']);
    $userToUpdate->setLastName($_POST['lastName']);
    $userToUpdate->setPassword($_POST['password']);
    $userToUpdate->update($_POST['admin'], $_POST['editor'], $_POST['author']);
}
?>
<table class="table table-bordered table-condensed table-striped table-responsive">
    <thead>
    <tr>
        <td>UserID</td>
        <td>Username</td>
        <td>FirstName</td>
        <td>LastName</td>
         <td>Created</td>
         <td>CreatedBy</td>
         <td>LastModified</td>
         <td>ModifiedBy</td>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach(User::retrieveData() as $user):
        if (isset($_GET['updateid']) && $user->getUserId() == $_GET['updateid']) {
        $update = $user;
        } ?>
        <tr>
            <td><?php echo $user->getUserId()?></td>
            <td><?php echo $user->getUserName()?></td>
            <td><?php echo $user->getFirstName()?></td>
            <td><?php echo $user->getLastName()?></td>

            <td><?php echo $user->getCreated()?></td>
            <td><?php echo $user->getCreatedBy()?></td>
            <td><?php echo $user->getLastModified()?></td>
            <td><?php echo $user->getModifiedBy()?></td>

            <td><a href="./backend.php?users=1&updateid=<?php echo $user->getUserId(); ?>">U</a></td>
            <?php if(User::isAdmin($user->getUserName()) || User::isEditor($user->getUserName()) || User::isAuthor($user->getUserName())){ ?>
                <td><a class="confirmation" href="./backend.php?users=1&deleteid=<?php
                    echo $user->getUserId(); ?>"> <font color="red">X</font> </a></td>
            <?php }else{ ?>
                <td>Deleted</td>
            <?php } ?>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>
<?php
if (!isset($_GET['updateid'])) {
    include("./User_Insert_Form.php");
}
if (isset($_GET['updateid'])) {
    include("./User_Update_Form.php");
}?>
</body>
</html>
