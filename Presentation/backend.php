<?php
if(session_id() == ''){ // guard
    session_start();
}
require_once '../Business/User.php';
require_once '../Business/Article.php';
require_once '../Business/Content_Area.php';
require_once '../Business/Page.php';
require_once '../Business/CSS.php';
require_once '../Business/User.php';?>
<html>
<title>Back End</title>
<head>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
<?php
// Conditionally creating links to back-end content.
if(isset($_SESSION['username'])){ ?>
    <ul class="nav nav-tabs">
        <?php if(User::isAdmin($_SESSION['username'])){ ?>
        <li role="presentation"><a href="backend.php?users=1">Users</a></li><?php } ?>
        <?php if (User::isEditor($_SESSION['username'])){ ?>
        <li role="presentation"><a href="backend.php?articles=1">Articles</a></li><?php } ?>
        <?php if (User::isEditor($_SESSION['username'])){ ?>
        <li role="presentation"><a href="backend.php?content=1">Content Areas</a></li><?php } ?>
        <?php if (User::isEditor($_SESSION['username'])){ ?>
        <li role="presentation"><a href="backend.php?pages=1">Pages</a></li><?php } ?>
        <?php if (User::isEditor($_SESSION['username'])){ ?>
        <li role="presentation"><a href="backend.php?css=1">CSS</a></li><?php } ?>
        <li role="presentation"><a href="Logout.php">Log Out</a></li>
    </ul>
<?php } // If not logged in, echo a login fail, or login prompt.
if(!isset($_SESSION['username'])){ ?>
    <h2 class="col-xs-offset-4 col-xs-12"><strong>Welcome.</strong></h2>
    <p class="col-xs-offset-4 col-xs-12"><font color="red">
            <?php
            if(isset($_SESSION['invalid'])){
                echo $_SESSION['invalid'];
            }else{
                echo "Please Log In.";
            } ?>
        </font></p>
    <?php
    include("./loginform.php");
}else{
// If logged-in, and a request has been sent VIA nav bar, include a form.
    if(User::isAdmin($_SESSION['username']) && isset($_GET['users'])){
        include("./User_Back_End.php");
    }else if(User::isEditor($_SESSION['username']) && isset($_GET['articles'])){
        include("./Article_Back_End.php");
    }else if(User::isEditor($_SESSION['username']) && isset($_GET['content'])){
        include("./ContentAreaDisplay.php");
    }else if(User::isEditor($_SESSION['username']) && isset($_GET['pages'])){
        include("./PageDisplay.php");
    }else if((User::isEditor($_SESSION['username']) || User::isEditor($_SESSION['username'])) && isset($_GET['css'])){
        include("./CSS_Back_End.php");
    }else{ ?>
<center><h1>Click a <strong>tab</strong> to get started.
    </h1>
    <canvas id="chart" width="390" height="200"></canvas>
    <br>
    <table> <!-- A summary of all content (including users) and bar chart -->
    <tr>
        <td align="center" width="60px"><i>Articles</i></td>
        <td align="center" width="60px"><i>Divs</i></td>
        <td align="center" width="60px"><i>Pages</i></td>
        <td align="center" width="60px"><i>Styles</i></td>
        <td align="center" width="60px"><i>Users</i></td>
    </tr>
        <tr>
            <td align="center" valign="bottom">
                <b><div id="Articles"><?php echo count(Article::retrieveData()); ?></div></b></td>
            <td align="center" valign="bottom">
                <b><div id="Divs"><?php echo count(ContentArea::retrieveAll()); ?></div></b></td>
            <td align="center" valign="bottom">
                <b><div id="Pages"><?php echo count(Page::retrieveData()); ?></div></b></td>
            <td align="center" valign="bottom">
                <b><div id="Styles"><?php echo count(CSS::getAllCSS()); ?></div></b></td>
            <td align="center" valign="bottom">
                <b><div id="Users" valign="bottom"><?php echo count(User::retrieveData()); ?></div></b></td>
        </tr>
    </table>
    <?php
    }
} ?>
</body>
<script>
    window.onload = function () {
        setInterval(function () {
            Chart();
        }, 500); // Checks for altered data every half second.
    }
</script>
<script>
    function Chart(){
        var canvas = document.getElementById('chart');
        var ctx = canvas.getContext('2d');
        var scores = [document.getElementById('Articles').innerHTML * 10,
            document.getElementById('Divs').innerHTML * 10,
            document.getElementById('Pages').innerHTML * 10,
            document.getElementById('Styles').innerHTML * 10,
            document.getElementById('Users').innerHTML * 10];
        var width = 50;
        var currX = 50;

        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.fillStyle = 'red';
        for (var i = 0; i < scores.length; i++) {
            var h = scores[i];
            ctx.fillRect(currX, canvas.height - h, width, h);
            currX += width + 10;
        }
    }
</script>
</html>
