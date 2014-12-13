<?php

//Guard functionality - Must be logged in as an editor to access this page
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
    <title>Article End Page</title>
    <!-- Bootstrap -->
    <script type="text/javascript" src="./js/tinymce/tinymce.min.js"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: "textarea",
            theme: "modern",
            plugins: [
                "code table"
            ]
        });
    </script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!--[if lt IE 9]>

    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>


    <!--  CDN for JQuery Validation plugin -->
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/additional-methods.js"></script>
    <!--  NOTE: I need this .js for my regex, so be sure to include it -->


    <!--  Client-side validation will ensure that no blank
    fields can be added except for the description, which is optional. -->

    <script>

        $.validator.setDefaults({
            submitHandler: function () {
                alert("Success!");
                form.submit();

            }
        });

        $().ready(function () {

            // validate the comment form when it is submitted
            // validate signup form on keyup and submit
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

</head>
<body>


<?php
if(isset($_GET['deleteid'])){
    $selectedArticle = Article::retrieveSingleArticle($_GET['deleteid']);
    $selectedArticle->remove();
}
if(isset($_POST['addArticle'])){
    $articleToInsert =
        new Article($_POST['addArticleName'], $_POST['addArticleTitle'], $_POST['addArticleDescription'], $_POST['addArticleContent'], $_POST['addArticlePageID'], $_POST['addArticleDivID'], $_POST['addArticleAllPages'], User::getTheUserID($_SESSION['username']), User::getTheUserID($_SESSION['username']));
    $articleToInsert->save();
}else if(isset($_POST['updateArticle'])){
    $articleToInsert = Article::retrieveSingleArticle($_POST['updateID']);
    $articleToInsert->update($_POST['updateArticleName'],
        $_POST['updateArticleTitle'],
        $_POST['updateArticleDescription'],
        $_POST['updateArticlePageID'],
        $_POST['updateArticleDivID'],
        $_POST['updateArticleContent'],
        User::getTheUserID($_SESSION['username']),
        $_POST['updateArticleAllPages']);
} ?>
<table class="table table-bordered table-condensed table-striped table-responsive">
    <thead>
    <tr>
        <td>Name</td>
        <td>Title</td>
        <td>Description</td>
        <td>Page ID</td>
        <td>Div ID</td>
        <td>Created</td>
        <td>Created By</td>
        <td>Modified</td>
        <td>Modified By</td>
    </tr>
    </thead>
    <tbody>
    <?php

    foreach(Article::retrieveData() as $article):

        if(isset($_GET['updateid']) && $article->getArticleID() == $_GET['updateid']){
            $update = $article;
        } ?>
        <tr>
            <td><?php echo $article->getName(); ?></td>
            <td><?php echo $article->getTitle(); ?></td>
            <td><?php echo $article->getDescription(); ?></td>
            <td><?php echo $article->getPageID(); ?></td>
            <td><?php echo $article->getDivID(); ?></td>
            <td><?php echo $article->getCreated(); ?></td>
            <td><?php echo $article->getCreatedBy(); ?></td>
            <td><?php echo $article->getLastModified(); ?></td>
            <td><?php echo $article->getModifiedBy(); ?></td>

            <td><a href="./backend.php?articles=1&updateid=<?php echo $article->getArticleID(); ?>">U</a></td>
            <?php if($article->getPageID() == 0){ ?>
                <td>Deleted</td>
            <?php }else{ ?>
                <td><a class="confirmation" href="./backend.php?articles=1&deleteid=<?php
                    echo $article->getArticleID(); ?>"> <font color="red">X</font> </a></td>
            <?php } ?>
        </tr>

    <?php endforeach ?>

    </tbody>
</table>
<?php
if(1 == 1 && !isset($_GET['updateid'])){
    include("./Article_Insert_Form.php");
}
if(1 == 1 && isset($_GET['updateid'])){
    include("./Article_Update_Form.php");
}?>
</body>
</html>
