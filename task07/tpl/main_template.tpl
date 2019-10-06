<html>
<head>
    <title>{LABEL ="page_title"}</title><!--Private File Manager-->
    <link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container">
    <div id="header">
        <p>{LABEL="access_user"}</p> <--!Necessary to login required.-->
    </div>

    <div id="left">
        <div>
            <p>{LABEL="future_menu"}</p><--!This will be the future menu.-->
        </div>
    </div>

    <div id="right">
        <div>
            <p>{FILE="statistics.tpl"}</p> <--You can see in this item the statistics of our Private File Manager.-->
        </div>
    </div>

    <div id="center">
        <form action="" method="post" id="frmLogin">
            <div class="error-message">{DV = "error_mesaqe"}</div>
            <div class="field-group">
                <div>
                    <label for="login">{LABEL="login"}</label><--!Username.-->
                </div>
                <div>
                    <input name="member_name" type="text"
                           value="{DV ="cookie_member_login"}"
                    class="input-field">
                </div>
            </div>
            <div class="field-group">
                <div>
                    <label for="password">{LABEL="password"}</label><--!Password.-->
                </div>
                <div>
                    <input name="member_password" type="password"
                           value="{DV = "cookie_member_password"}"
                    class="input-field">
                </div>
            </div>
            <div class="field-group">
                <div>
                    <input type="checkbox" name="remember" id="remember"
                    {DV = "lf_checked"}checked
                    <?php } ?> /> <label for="remember-me">{LABEL="remember_me"}</label><--!Remember me.-->
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
        <p>{LABEL="copyright"}</label><--!2019, EPAM RD PHP Training.--></p>
    </div>
</div>
<script src="./js/ajax-form.js"></script>

</body>
</html>