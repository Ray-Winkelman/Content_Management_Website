<?php

//Guard functionality - Must be logged in as an editor to access this page
require_once('../Business/User.php');
if(!(isset($_SESSION['username']) && (User::isEditor($_SESSION['username']) || User::isAuthor($_SESSION['username'])))){
header("Location: ./backend.php");
exit;
}
?>

<form name="updateForm" action="<?php if(User::isAuthor($_SESSION['username'])){ echo "index.php?pageID=$pageID";
} else { echo "./backend.php?articles=1"; } ?>" method=POST class="form-horizontal" role="form"
id="updateForm">

    <?php if(User::isAuthor($_SESSION['username'])){ ?>
        <h3>Editing "<?php echo $update->getTitle(); ?>"</h3>
    <?php } ?>

    <?php if (!User::isAuthor($_SESSION['username'])){ ?>
    <div class="form-group">
        <label for="updateArticleName" class="col-sm-4 control-label">Article Name:</label>

        <div class="col-sm-4">
            <input type="text" class="form-control" id="updateArticleName" name="updateArticleName"
                   value="<?php if (isset($update)) {echo $update->getName();} ?>">
        </div>
    </div>
    <?php }ELSE{ ?>
        <input type="hidden" name="updateArticleName" value="<?php if(isset($update)){
            echo $update->getName();
        } ?>">
    <?PHP } ?>

    <div class="form-group">
        <label for="updateArticleTitle" class="col-sm-4 control-label">Title:</label>

        <div class="col-sm-4">
            <input type="text" class="form-control" id="updateArticleTitle" name="updateArticleTitle"
                   value="<?php if (isset($update)) { echo $update->getTitle();} ?>">
        </div>
    </div>

    <?php if (!User::isAuthor($_SESSION['username'])){ ?>
    <div class="form-group">
        <label for="updateArticleDescription" class="col-sm-4 control-label">Description:</label>

        <div class="col-sm-4">
            <input type="text" class="form-control" id="updateArticleDescription" name="updateArticleDescription"
                   value="<?php if (isset($update)) {echo $update->getDescription();} ?>">
        </div>
    </div>
    <?php }ELSE{ ?>
        <input type="hidden" name="updateArticleDescription" value="<?php if(isset($update)){
            echo $update->getDescription(); } ?>">
    <?PHP } ?>

    <div class="form-group">
        <label for="updateArticleContent" class="col-sm-4 control-label">Code:</label>

        <div class="col-sm-4">
            <TEXTAREA class="form-control" id="updateArticleContent" name="updateArticleContent" placeholder="<p></p>"
                      rows="16"><?php if (isset($update)) {
                    $string = str_replace("<", "&lt;", $update->getHTML());
                    $string = str_replace(">", "&gt;", $string);
                    echo $string;
                } ?></TEXTAREA>
        </div>
    </div>

    <div class="form-group">
        <label for="updateArticlePageID" class="col-sm-4 control-label">Page ID:</label>

        <div class="col-sm-4">
            <input type="number" class="form-control" id="updateArticlePageID" name="updateArticlePageID"
                   value="<?php if (isset($update)) {echo $update->getPageID(); } ?>">
        </div>
    </div>

    <div class="form-group">
        <label for="updateArticleDivID" class="col-sm-4 control-label">Div ID:</label>

        <div class="col-sm-4">
            <input type="number" class="form-control" id="updateArticleDivID" name="updateArticleDivID"
                   value="<?php if (isset($update)) {echo $update->getDivID(); } ?>">
        </div>
    </div>

    <?php if (!User::isAuthor($_SESSION['username'])){ ?>
    <div class="form-group">
        <label for="updateArticleAllPages" class="col-sm-4 control-label">All Pages</label>

        <div class="col-sm-4">
            <select form="updateForm" class="form-control" id="updateArticleAllPages" name="updateArticleAllPages">
                <option value="0" <?php if($update->getAllPagesCondition() == 0){echo "selected=\"true\"";}?>>False</option>
                <option value="1"<?php if($update->getAllPagesCondition() == 1){echo "selected=\"true\"";}?>>True</option>
            </select>
        </div>
    </div>
    <?php } ELSE { ?>
        <input type = "hidden" name = "updateArticleAllPages" value = "<?php if($update->getAllPagesCondition() == 0){
            echo "0"; } else { echo "1"; } ?>" >
   <?PHP }?>

    <input type="hidden" name="updateID" value="<?php if(isset($update)){
        echo $update->getArticleID();
    } ?>">

    <?php if (User::isAuthor($_SESSION['username'])){ ?>
    <br>
    <div class="form-group">
        <div class="col-sm-4">
            <button type="submit" name="updateArticle" id="updateArticle" style="float: left;" class="btn btn-default">Update Article</button>
        </div>
    </div>

    <?php } else { ?>
    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-4">
            <button type="submit" name="updateArticle" id="updateArticle" style="float: right;" class="btn btn-default">Update Article</button>
        </div>
    </div>
    <?php } ?>
</form>
<?php if (User::isAuthor($_SESSION['username'])){ ?>
    <div class="form-group">
        <div class="col-sm-4">
            <form action="<?php echo "index.php?pageID=$pageID"; ?>" method="post" id="authorDelete">
                <input type="hidden" name="authorDeleteID" value="<?php if(isset($update)){
                    echo $update->getArticleID();
                } ?>">
                <input type="submit" name="delete" value="Delete">
            </form>
        </div>
    </div>
<br>
<?php } ?>
