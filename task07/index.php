<?php

session_start();

require_once "class/Auth.class.php";
require_once "class/Util.class.php";

$auth = new Auth();
$db_handle = new DBController();
$util = new Util();

require_once "authCookieSessionValidate.php";

if ($isLoggedIn) {
    $util->redirect("innerpage.php");
}

if (! empty($_POST["login"])) {
    $isAuthenticated = false;

    $username = $_POST["member_name"];
    $password = $_POST["member_password"];

    $user = $auth->getMemberByUsername($username);
    if (password_verify($password, $user[0]["member_password"])) {
        $isAuthenticated = true;
    }

    if ($isAuthenticated) {
        $_SESSION["member_id"] = $user[0]["member_id"];

        // Set Auth Cookies if 'Remember Me' checked
        if (! empty($_POST["remember"])) {
            setcookie("member_login", $username, $cookie_expiration_time);

            $random_password = $util->getToken(16);
            setcookie("random_password", $random_password, $cookie_expiration_time);

            $random_selector = $util->getToken(32);
            setcookie("random_selector", $random_selector, $cookie_expiration_time);

            $random_password_hash = password_hash($random_password, PASSWORD_DEFAULT);
            $random_selector_hash = password_hash($random_selector, PASSWORD_DEFAULT);

            $expiry_date = date("Y-m-d H:i:s", $cookie_expiration_time);

            // mark existing token as expired
            $userToken = $auth->getTokenByUsername($username, 0);
            if (! empty($userToken[0]["id"])) {
                $auth->markAsExpired($userToken[0]["id"]);
            }
            // Insert new token
            $auth->insertToken($username, $random_password_hash, $random_selector_hash, $expiry_date);
        } else {
            $util->clearAuthCookie();
        }
        $util->redirect("innerpage.php");
    } else {
        $message = "Invalid Login";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link href="./css/style.css" rel="stylesheet" type="text/css" />
    <title>Private File Manager</title>
</head>
<body>
<div id="container">
    <div id="header">
        <div class="header-bg">
            <img src="css/Folders.png" alt="Private File Manager" ">
        </div>
    </div>
    <div id="string">
        <p>Necessary to login required</p>
    </div>
    <div id="left">
        <div>
            <p>It is a item for future menu</p>
        </div>
    </div>

    <div id="right">
        <div>
            <p>You can see in this item the statistics of our Private File Manager.</p>
        </div>
    </div>

    <div id="center">
        <form action="" method="post" id="frmLogin">
            <div class="error-message"><?php if (isset($message)) {
                    echo $message;} ?></div>
            <div class="field-group">
                <div>
                    <label for="login">Username</label>
                </div>
                <div>
                    <input name="member_name" type="text"
                           value="<?php if(isset($_COOKIE["member_login"])) { echo $_COOKIE["member_login"]; } ?>"
                           class="input-field">

                </div>
            </div>
            <div class="field-group">
                <div>
                    <label for="password">Password</label>
                </div>
                <div>
                    <input name="member_password" type="password"
                           value="<?php if(isset($_COOKIE["member_password"])) { echo $_COOKIE["member_password"]; } ?>"
                           class="input-field">
                </div>
            </div>
            <div class="field-group">
                <div>
                    <input type="checkbox" name="remember" id="remember"
                        <?php if(isset($_COOKIE["member_login"])) { ?> checked
                        <?php } ?> /> <label for="remember-me">Remember me</label>
                </div>
            </div>
            <div class="field-group">
                <div>
                    <input type="submit" name="login" value="Login"
                           class="form-submit-button"></span>
                </div>
            </div>
        </form>
    </div>
    <div id="footer">
        <p>2019, EPAM RD PHP Training</p>
    </div>
</div>


</body>
</html>