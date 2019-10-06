<?php
session_start();

require_once "authCookieSessionValidate.php";

if(!$isLoggedIn) {
    header("Location: ./");
}
?>
<!DOCTYPE html>

<html>
<head>
    <link href="./css/style.css" rel="stylesheet" type="text/css" />
    <title>Insert Update Delete View Images</title>
</head>

<body>
<div id="container">

    <div id="header">
        <div class="header-bg">
            <img src="css/Folders.png" alt="Private File Manager" ">
        </div>
    </div>

    <div id="string">
        <div>
        <p>You have Successfully logged in!. <a  href="logout.php" class="button">Logout</a></p>
        </div>
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
        <div>
                    <table>
                        <thead>
                        <tr>
                            <th onclick="sort_table('name')"><span id="sort_by_name">=</span> {LABEL="th_file"}</th>
                            <th onclick="sort_table('size')"><span id="sort_by_size">=</span> {LABEL="th_size"} ({LABEL="kb"})</th>
                            <th onclick="sort_table('dt')"><span id="sort_by_dt">=</span> {LABEL="th_dt"}</th>
                            <th>{LABEL="th_delete"}</th>
                        </tr>
                        </thead>
                        <tbody>
                        {DV="stored_files"}
                        </tbody>
                    </table>
        </div>

        <div>
            <div id="#frmLogin">
                <p class="text-center">Please Insert new Item File</p>
                <form method="post" action="" enctype="multipart/form-data">
                    <input type="text" name="user_name" class="form-control" required="">
                    <input type="file" name="profile" class="form-control" required="">
                    <button type="submit" name="btn-add">Add New </button>
                </form>
            </div>
        </div>
        <div>
        <form action="index.php" method="post">

            <input type="text" name="url" maxlength="3000"/>
            <input type="submit" value="download"/>

        </form>
            </div>

    </div>

    <div id="footer">
        <p>2019, EPAM PHP Training</p>
    </div>

</div>

