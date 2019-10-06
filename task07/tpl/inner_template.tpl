<!DOCTYPE html>
<html>
<head>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <title>{LABEL="inner_title"}</title><!--Insert Update Delete View Images-->
</head>
<body>
<div id="container">
    <div id="header">
        <p>{LABEL="success_login"} <a  href="logout.php" class="button">{LABEL="button_logout"}</a></p> <!--You have Successfully logged in!.--> <!--Logout-->
    </div>

    <div id="left">
        <div>
            <p>It is a item for future menu</p>
        </div>
    </div>

    <div id="right">
        <div>
            <p>{FILE="statistics.tpl"} </p><!--You can see in this item the statistics of our Private File Manager.-->
        </div>
    </div>

    <div id="center">
        <div class="member-dashboard">
            {LABEL="success_login"}<a href="logout.php">{LABEL="button_logout"}</a><!--You have Successfully logged in!.--> <!--Logout-->
        </div>
        <div>
            <form action="example/file-handler.php" method="post" enctype="multipart/form-data">
                <input type="file" name="upload">
                <button>{LABEL="button_dowload"}</button><!--Download-->
            </form>
            <!--<form action="" enctype="multipart/form-data" method="POST" name="frm_user_file">
                <input type="file" name="myfile" />
                <input type="submit" name="submit" value="Upload" />
            </form>-->
        </div>
        <div><br />
            <div>
                <form action="example/file-handler.php" method="post">
                    <div>
                        <label>{LABEL="enter_url"}</label><!--Enter URL-->
                        <input type="text" name="url" />
                        <?php echo $error; ?>
                    </div>
                    <br />
                    <input type="submit" name="download" value="Download" />
                    <br />

                </form>
                <br />

            </div>
        </div>


    </div>

</div>
<div id="footer">
    <p><label>{LABEL="copyright"}</label><--!2019, EPAM RD PHP Training.--></p>
</div>
</div>
<script src="./js/ajax-form.js"></script>
</body>
</html>