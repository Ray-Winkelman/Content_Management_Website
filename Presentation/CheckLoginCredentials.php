<?php session_start();
require("../Data/aUserDataAccess.php");

$username = $_POST['username'];
$password = $_POST['password'];

$db = aUserDataAccess::getDataAccess();
$db->connectToDB();

$password = hash('sha512',
    $password);
$salt = $db->getSalt($username);

$password = crypt($password,
    sprintf('$45$rounds=%d$%s$',
        10000,
        $salt));

if($db->checkCredentials($username,
    $password)
){
    $_SESSION['username'] = $username;
    $_SESSION['invalid'] = NULL;
    if($db->isType($_SESSION['username'],
        3)
    ){
        header("Location: ./index.php");
        exit;
    }
} else {
    $_SESSION['invalid'] = "Invalid username or password.";
    // TODO FOR DEVELOPMENT ONLY.
    // $_SESSION['username'] = "GHatt";
}
$db->closeDB();
header("Location: ./backend.php");
exit;
