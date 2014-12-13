<?php

//Guard functionality - Must be logged in as an admin to access this page
require_once('../Business/User.php');
if(!(isset($_SESSION['username']) && User::isAdmin($_SESSION['username']))){
    header("Location: ../Presentation/backend.php");
    exit;
}
?>

<form name="addUser" action="./backend.php?users=1" method=POST class="form-horizontal"
      role="form" id="addUser">

    <div class="form-group">
        <label for="userName" class="col-sm-4 control-label">User Name (8 Characters):</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" id="userName" name="userName" required pattern=".{8,20}">
        </div>
    </div>

    <div class="form-group">
        <label for="password" class="col-sm-4 control-label">Password:</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" id="password" name="password" required pattern=".{8,20}">
        </div>
    </div>

    <div class="form-group">
        <label for="firstName" class="col-sm-4 control-label">First Name:</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" id="firstName" name="firstName" required>
        </div>
    </div>

    <div class="form-group">
        <label for="lastName" class="col-sm-4 control-label">Last Name:</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" id="lastName" name="lastName" required>
        </div>
    </div>

    <div class="form-group">
        <label for="admin" class="col-sm-4 control-label">Administrator:</label>
        <div class="col-sm-4">
            <select form="addUser" class="form-control" id="admin" name="admin">
                <option value="0">False</option>
                <option value="1">True</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="editor" class="col-sm-4 control-label">Editor</label>
        <div class="col-sm-4">
            <select form="addUser" class="form-control" id="editor" name="editor">
                <option value="0">False</option>
                <option value="1">True</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="author" class="col-sm-4 control-label">Author:</label>

        <div class="col-sm-4">
            <select form="addUser" class="form-control" id="author" name="author">
                <option value="1">True</option>
                <option value="0">False</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-4">
            <button type="submit" value="1" name="addUser" id="addUser" style="float: right;" class="btn btn-default">Add User</button>
        </div>
    </div>
</form>
