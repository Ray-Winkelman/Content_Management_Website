<!DOCTYPE html>

<?php if(session_id() == ''){ // guard
    session_start();
}

// required business objects
require_once('../Business/CSS.php');
require_once("../Business/Page.php");
require_once("../Business/Content_Area.php");
require_once('../Business/Article.php');
require_once('../Business/User.php');

// set default page to pageID one
$pageID = 1;

// the page id retrieved from the nav href
if(isset($_GET['pageID'])){
    $pageID = $_GET['pageID'];
}

// handles article updates
if(isset($_POST['updateArticle'])){
    // create a new article object from the incoming id
    $articleToInsert = Article::retrieveSingleArticle($_POST['updateID']);
    // call update function on article
    $articleToInsert->update($_POST['updateArticleName'],
        $_POST['updateArticleTitle'],
        $_POST['updateArticleDescription'],
        $_POST['updateArticlePageID'],
        $_POST['updateArticleDivID'],
        $_POST['updateArticleContent'],
        User::getTheUserID($_SESSION['username']),
        $_POST['updateArticleAllPages']);
}

// handles "deleting" an article
if(isset($_POST['authorDeleteID'])){
    Article::setPageIDZero($_POST['authorDeleteID']);
}

// handles adding a new article
if(isset($_POST['addArticle'])){
    // create a new article from post variables
    $articleToInsert =
        new Article($_POST['addArticleName'], $_POST['addArticleTitle'], $_POST['addArticleDescription'], $_POST['addArticleContent'], $_POST['addArticlePageID'], $_POST['addArticleDivID'], $_POST['addArticleAllPages'], User::getTheUserID($_SESSION['username']), User::getTheUserID($_SESSION['username']));
    // call the save function on the new article
    $articleToInsert->save();
}

// handles the search functionality.
if(isset($_POST['searchArticle']) && $_POST['searchArticle'] != ""){
    $search = $_POST['searchArticle'];
}

?>

<html>

<head>

<!-- Autocomplete Styles -->
<style type="text/css">

    /* http://docs.jquery.com/UI/Autocomplete#theming*/
    .ui-autocomplete {
        position: absolute;
        cursor: default;
        background: #CCC
    }

    /* workarounds */
    html .ui-autocomplete {
        width: 1px;
    }

    /* without this, the menu expands to 100% in IE6 */

    .ui-helper-hidden-accessible {
        display: none;
    }

    .ui-menu {
        list-style: none;
        padding: 2px;
        margin: 0;
        display: block;
        float: left;
    }

    .ui-menu .ui-menu {
        margin-top: -3px;
    }

    .ui-menu .ui-menu-item {
        margin: 0;
        padding: 0;
        zoom: 1;
        float: left;
        clear: left;
        width: 100%;
    }

    .ui-menu .ui-menu-item a {
        text-decoration: none;
        display: block;
        padding: .2em .4em;
        line-height: 1.5;
        zoom: 1;
    }

    .ui-menu .ui-menu-item a.ui-state-hover,
    .ui-menu .ui-menu-item a.ui-state-active {
        font-weight: normal;
        margin: -1px;
    }

</style>

<script type="text/javascript" src="./js/tinymce/tinymce.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/additional-methods.js"></script>
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<!-- apply TinyMCE to Text Area -->
<script type="text/javascript">
    tinymce.init({
        selector: "textarea",
        theme: "modern",
        plugins: [
            "code table"
        ]
    });
</script>

<script>

    // set the default message
    $.validator.setDefaults({
        submitHandler: function () {
            alert("Success!");
            form.submit();

        }
    });

    // on document load
    $().ready(function () {

        // validation rules for the article add form
        $("#addForm").validate({
            rules: {

                addArticleTitle: {
                    required: true,
                    minlength: 2
                },

                addArticleName: {
                    required: true,
                    minlength: 2
                },

                addArticleContent: {
                    required: true,
                    minlength: 2
                },

                addArticlePageID: {
                    required: true,
                    min: 1,
                },
                addArticleDivID: {
                    required: true,
                    min: 1,
                },


            },

            // the messages which show on validation
            messages: {

                addArticleTitle: {
                    required: "Please enter a title for the new article.",
                    minlength: "Title must be at least two characters."
                },

                addArticleName: {
                    required: "Please enter a name for the new article.",
                    minlength: "Name must be at least two characters."
                },

                addArticleContent: {
                    required: "Please enter content for the new article.",
                    minlength: "Alias must be at least two characters.",
                },

                addArticlePageID: {
                    required: "Please specify a page for the article to appear on.",
                    min: "Please specify a page number greater than 0."
                },
                addArticleDivID: {
                    required: "Please specify a div for the article to appear on.",
                    min: "Please specify a div number greater than 0."
                },
            }
        });

        // validation rules on update form
        $("#updateForm").validate({
            rules: {

                updateArticleTitle: {
                    required: true,
                    minlength: 2
                },

                updateArticleName: {
                    required: true,
                    minlength: 2
                },

                updateArticleContent: {
                    required: true,
                    minlength: 2
                },

                updateArticlePageID: {
                    required: true,
                    min: 1,
                },
                updateArticleDivID: {
                    required: true,
                    min: 1,
                },


            },
            messages: {

                updateArticleTitle: {
                    required: "Please enter a title for the new article.",
                    minlength: "Title must be at least two characters."
                },

                updateArticleName: {
                    required: "Please enter a name for the new article.",
                    minlength: "Name must be at least two characters."
                },

                updateArticleContent: {
                    required: "Please enter content for the new article.",
                    minlength: "Content must be at least two characters.",
                },

                updateArticlePageID: {
                    required: "Please specify a page for the article to appear on.",
                    min: "Please specify a page number greater than 0."
                },
                updateArticleDivID: {
                    required: "Please specify a div for the article to appear on.",
                    min: "Please specify a div number greater than 0."
                },


            }
        });
    });
</script>

<script> // the autocomplete javascript function

    $(function () {
        $("#searchArticle").autocomplete({
            source: "./ArticleAutoCompletes.php", // php source file
            messages: {
                noResults: '', // message to display on no results
                results: function () {
                } // message to display on results found
            }
        });
    });

</script>



<?php /* DISPLAY CSS */
$css = new CSS();
echo $css->getAllActiveCSSString(); // echo out all active CSS
?>

<title> Content Management Site </title>

</head>

<body>

<table cellpadding="20" align="center">
    <tr>
        <!-- Nav Creation -->
        <td valign="top">
            <h4>Navigation</h4>
            <ul>
                <?php foreach(Page::retrieveData() as $navItem) : ?>
                    <li><a href=./index.php?pageID=<?php echo $navItem->getId(); ?>><?php echo $navItem->getName(); ?></a></li><br>
                <?php endforeach; ?>
            </ul>
        </td>

        <!-- Search Functionality -->
        <td valign="top">
            <h4>Search Article</h4>

            <form action="index.php?pageID=<?php echo $pageID; ?>" method="post" id="authorInsertForm">
                <input type="text" id="searchArticle" name="searchArticle" value="">
                <input type="submit" name="searchSubmit" id="searchSubmit" value="Search">
            </form>
        </td>

        <!-- Edit Button Functionality -->
        <?php if(isset($_SESSION['username']) && User::isAuthor($_SESSION['username'])){ ?>
            <td valign="top">
                <h4>Edit Article</h4>

                <form action="index.php?pageID=<?php echo $pageID; ?>" method="post" id="authorUpdateForm">

                    <select name="authorUpdateOption" form="authorUpdateForm">

                        <!-- Print Each Non Search Article OR Each Searched Article -->
                        <?php if(!isset($search)){
                            if(Article::getAllArticlesWherePageID($pageID) != NULL){
                                foreach(Article::getAllArticlesWherePageID($pageID) as $selectArticleID) : ?>
                                    <option value="<?php echo $selectArticleID->getArticleID(); ?>">
                                        <?php echo $selectArticleID->getTitle(); ?>
                                    </option>
                                <?php endforeach;
                            }
                        }else // IF the search term is set
                        {
                            if(Article::getAllArticlesWhereTitleLikeSearch($search) != NULL){
                                foreach(Article::getAllArticlesWhereTitleLikeSearch($search) as $searchArticleID) : ?>
                                    <option value="<?php echo $searchArticleID->getArticleID(); ?>">
                                        <?php echo $searchArticleID->getTitle(); ?>
                                    </option>
                                <?php endforeach;
                            }
                        }?>

                    </select>

                    <input type="submit" name="edit" value="Edit">

                    <!-- Hold on to the searched article -->
                    <?php if(isset($_POST['searchArticle'])){ ?>
                        <input type="hidden" id="searchArticle" name="searchArticle" value="<?php echo $_POST['searchArticle']; ?>">
                    <?php } ?>
                </form>

                <form action="index.php?pageID=<?php echo $pageID; ?>" method="post" id="authorInsertForm">
                    <input type="submit" name="authorInsertForm" value="Add New Article">
                </form>
            </td>
        <?php } // end of conditional edit include ?>

        <!-- Handles logout button -->
        <td valign="top">
            <h4>Login/Logout</h4>
            <?php if(!isset($_SESSION['username'])){ ?>
                <a align="right" href="backend.php">Log In.</a>
            <?php }else{ ?>
                <a align="right" href="Logout.php">Log Out.</a>
            <?php } ?>
        </td>
    </tr>

</table>

<?php if(!isset($search)){ // If the user has NOT searched for articles.
    // handles inclusion of insert form
    if(isset($_POST['authorInsertForm'])){
        include("./Article_Insert_Form.php");
    }
    /*          ARTICLE PRINTING LOGIC
      The two for each loops below are seperated out; the first for each loop
      prints out the articles which are included on ALL pages and the second loop
      prints out the articles which appear on only the specific page.

      In both loops if an article is marked for update through the post value then
      the article is added to a form rather than printed out.
    */
    // print articles which appear on all pages (conditionally print it as a form).
    foreach(Article::getAllPagesArticles() as $article) :
        if($article != NULL){
            if(isset($_POST['authorUpdateOption']) && $_POST['authorUpdateOption'] == $article->getArticleID()){
                $update = $article;
                include("./Article_Update_Form.php");
            }else{
                ?>
                <h3><?php echo $article->getTitle(); ?></h3>
                <?php echo $article->getHTML();
            }
        }
    endforeach;
    // print articles which appear on this page (conditionally print it as a form).
    foreach(ContentArea::retrieveAll() as $contentArea) :
        if(count(Article::getArticlesByPageAndDivIDs($pageID,
                $contentArea->getDivID())) > 0
        ){
            ?>
            <div id="<?php echo $contentArea->getDivID(); ?>">
            <?php foreach(Article::getArticlesByPageAndDivIDs($pageID, $contentArea->getDivID()) as $article) :
                if($article != NULL){
                    if(isset($_POST['authorUpdateOption']) && $_POST['authorUpdateOption'] == $article->getArticleID()){
                        $update = $article;
                        include("./Article_Update_Form.php");
                    }else{
                        ?>
                        <h3><?php echo $article->getTitle(); ?></h3>
                        <?php echo $article->getHTML();
                    }
                } endforeach;
        } ?>
        </div>
    <?php endforeach; ?>
<?php
} // End of !issetSearch condition
// Prints all all matchings searched articles, if the article is flagged for update then
// it prints it out in a form.
elseif(isset($search)){
    ?>
    <div id="searchresults">
    <?php if(Article::getAllArticlesWhereTitleLikeSearch($search) != NULL){
        foreach(Article::getAllArticlesWhereTitleLikeSearch($search) as $article) :
            if($article != NULL){
                if(isset($_POST['authorUpdateOption']) && $_POST['authorUpdateOption'] == $article->getArticleID()){
                    $update = $article;
                    include("./Article_Update_Form.php");
                }else{
                    ?>
                    <h3><?php echo $article->getTitle(); ?></h3>
                    <?php echo $article->getHTML();
                }
            }
        endforeach; ?>
        </div>

        <!-- If not match is found -->
    <?php }else{ ?>
        <h3>Sorry, No matching articles found.</h3>
    <?php } ?>

<?php } // End of search. ?>

</body>
</html>