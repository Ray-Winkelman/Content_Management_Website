<?php

//Guard functionality - Must be logged in as an editor to access this page
require_once('../Business/User.php');
if(!(isset($_SESSION['username']) && User::isEditor($_SESSION['username']))){
    header("Location: ../Presentation/backend.php");
    exit;
}
?>

<form name="updateForm" action="./backend.php?css=1" method=POST class="form-horizontal"
      role="form" id="updateForm">
    <div class="form-group">
        <label for="updateCSSName" class="col-sm-4 control-label">CSS Sheet Name: </label>

        <div class="col-sm-4">
            <input type="text" class="form-control" id="updateCSSName" name="updateCSSName"
                   value="<?php if (isset($update)) {
                       echo $update["Name"];
                   } ?>" required>
        </div>
    </div>

    <div class="form-group">
        <label for="updateCSSDescription" class="col-sm-4 control-label">Description:</label>

        <div class="col-sm-4">
            <input type="text" class="form-control" id="updateCSSDescription" name="updateCSSDescription"
                   value="<?php if (isset($update)) {
                       echo $update["Description"];
                   } ?>" >
        </div>
    </div>

    <div class="form-group">
        <label for="updateCSSContent" class="col-sm-4 control-label">Code:</label>

        <div class="col-sm-4">
            <TEXTAREA class="form-control" id="updateCSSContent" name="updateCSSContent" required placeholder="<style></style>"
                      rows="16"><?php if (isset($update)) {
                    $string = str_replace("<", "&lt;", $update["Content"]);
                    $string = str_replace(">", "&gt;", $string);
                    echo $string;
                } ?></TEXTAREA>
        </div>
    </div>

    <div class="form-group">
        <label for="updateCSSActive" class="col-sm-4 control-label">Active State</label>

        <div class="col-sm-4">
            <select form="updateForm" class="form-control" id="updateCSSActive" name="updateCSSActive">
                <option value="1">True</option>
                <option value="0">False</option>
            </select>
        </div>
    </div>

    <input type="hidden" name="updateID" value="<?php if (isset($update)) {
        echo $update["CSSID"];
    } ?>">

    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-4">
            <button type="submit" style="float: right;" class="btn btn-default">Update Style Sheet</button>
        </div>
    </div>

</form>
