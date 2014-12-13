<?php

//Guard functionality - Must be logged in as an editor to access this page
require_once('../Business/User.php');
if(!(isset($_SESSION['username']) && User::isEditor($_SESSION['username']))){
    header("Location: ../Presentation/backend.php");
    exit;
}
?>

<form name="addForm" action="./backend.php?css=1" method=POST class="form-horizontal" role="form" id="addForm">

    <div class="form-group">
        <label for="addCSSName" class="col-sm-4 control-label">CSS Sheet Name:</label>

        <div class="col-sm-4">
            <input type="text" class="form-control" id="addCSSName" name="addCSSName" required>
        </div>
    </div>

    <div class="form-group">
        <label for="addCSSDescription" class="col-sm-4 control-label">Description:</label>

        <div class="col-sm-4">
            <input type="text" class="form-control" id="addCSSDescription" name="addCSSDescription">
        </div>
    </div>

    <div class="form-group">
        <label for="addCSSContent" class="col-sm-4 control-label">Code:</label>

        <div class="col-sm-4">
            <TEXTAREA class="form-control" id="addCSSContent" required name="addCSSContent" placeholder="<style></style>"
                      rows="16"></TEXTAREA>
        </div>
    </div>

    <div class="form-group">
        <label for="addCSSActive" class="col-sm-4 control-label">Active State</label>

        <div class="col-sm-4">
            <select form="addForm" class="form-control" id="addCSSActive" name="addCSSActive" required>
                <option value="1">True</option>
                <option value="0">False</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-4">
            <button type="submit" style="float: right;" class="btn btn-default">Add Style Sheet</button>
        </div>
    </div>

</form>
