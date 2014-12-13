<?php

//Guard functionality - Must be logged in as an editor to access this page
require_once('../Business/User.php');
if(!(isset($_SESSION['username']) && (User::isEditor($_SESSION['username']) || User::isAuthor($_SESSION['username'])))){
header("Location: ./backend.php");
exit;
}
?>

<?php if(User::isAuthor($_SESSION['username'])){ ?>
    <h3>Adding A New Article</h3>
<?php } ?>
<form name="addForm" action="<?php if (User::isAuthor($_SESSION['username'])){ echo "index.php?pageID=$pageID";
} else { echo "./backend.php?articles=1"; } ?>" method=POST class="form-horizontal"
      role="form" id="addForm">

    <div class="form-group">
        <label for="addArticleName" class="col-sm-4 control-label">Article Name:</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" id="addArticleName" name="addArticleName" required>
        </div>
    </div>

    <div class="form-group">
        <label for="addArticleTitle" class="col-sm-4 control-label">Title:</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" id="addArticleTitle" name="addArticleTitle" required>
        </div>
    </div>

    <div class="form-group">
        <label for="addArticleDescription" class="col-sm-4 control-label">Description:</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" id="addArticleDescription" name="addArticleDescription">
        </div>
    </div>

    <div class="form-group">
        <label for="addArticleContent" class="col-sm-4 control-label">Code:</label>
        <div class="col-sm-4">
            <TEXTAREA class="form-control" id="addArticleContent" name="addArticleContent" required placeholder="<p></p>"
                      rows="16"></TEXTAREA>
        </div>
    </div>



    <?php if(!User::isAuthor($_SESSION['username'])){ ?>
        <div class="form-group">
            <label for="addArticlePageID" class="col-sm-4 control-label">Page ID:</label>

            <div class="col-sm-4">
                <input type="number" class="form-control" id="addArticlePageID" name="addArticlePageID" required min="1">
            </div>
        </div>
    <?php }ELSE{ ?>
        <input type="hidden" name="addArticlePageID" value="<?php echo $pageID; ?>">
    <?PHP } ?>


    <div class="form-group">
        <label for="addArticleDivID" class="col-sm-4 control-label">Div ID:</label>
        <div class="col-sm-4">
            <input type="number" class="form-control" id="addArticleDivID" name="addArticleDivID" required min="1">
        </div>
    </div>

    <div class="form-group">
        <label for="addArticleAllPages" class="col-sm-4 control-label">All Pages:</label>
        <div class="col-sm-4">
            <select form="addForm" class="form-control" id="addArticleAllPages" name="addArticleAllPages">
                <option value="0">False</option>
                <option value="1">True</option>
            </select>
        </div>
    </div>

    <?php if(User::isAuthor($_SESSION['username'])){ ?>
        <br>
        <div class="form-group">
            <div class="col-sm-4">
                <button type="submit" name="addArticle" id="addArticle" style="float: left;" class="btn btn-default">Add Article</button>
            </div>
        </div>

    <?php } else { ?>
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-4">
                <button type="submit" name="addArticle" id="addArticle" style="float: right;" class="btn btn-default">Add Article</button>
            </div>
        </div>
    <?php } ?>
</form>
