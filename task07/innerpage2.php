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

<!-- delete script -->
<?php
include("config.php");
if(isset($_GET['delete_id']))
{
    $stmt_select=$db_conn->prepare('SELECT * FROM `files` WHERE `fl_id`=:uid');
    $stmt_select->execute(array(':uid'=>$_GET['delete_id']));
    $imgRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
    unlink("uploads/".$imgRow['picProfile']);
    $stmt_delete=$db_conn->prepare('DELETE FROM `files` WHERE `fl_id =:uid');
    $stmt_delete->bindParam(':uid', $_GET['delete_id']);
    if($stmt_delete->execute())
    {
        ?>
        <script>
            alert("You are deleted one item");
            window.location.href=('index.php');
        </script>
    <?php
    }else

    ?>
        <script>
            alert("Can not delete item");
            window.location.href=('index.php');
        </script>
        <?php

}

?>
<!-- end delete script -->
<?php

if(isset($_POST['btn-add']))
{
    $name=$_POST['user_name'];

    $images=$_FILES['profile']['name'];
    $tmp_dir=$_FILES['profile']['tmp_name'];
    $imageSize=$_FILES['profile']['size'];

    $upload_dir='uploads/';
    $imgExt=strtolower(pathinfo($images,PATHINFO_EXTENSION));
    $valid_extensions=array('jpeg', 'jpg', 'png', 'gif', 'pdf');
    $picProfile=rand(1000, 1000000).".".$imgExt;
    move_uploaded_file($tmp_dir, $upload_dir.$picProfile);
    $stmt=$db_conn->prepare('INSERT INTO `files`(`us_username`, `fl_filename`) VALUES (:uname, :upic)');
    $stmt->bindParam(':uname', $name);
    $stmt->bindParam(':upic', $picProfile);
    if($stmt->execute())
    {
        ?>
        <script>
            alert("new record successul");
            window.location.href=('index.php');
        </script>
    <?php
    }else

    {
    ?>
        <script>
            alert("Error");
            window.location.href=('index.php');
        </script>
        <?php
    }

}
$FileUpload = new File();

if (isset($_FILES['file'])){
    $FileUpload->uploadFile($_FILES['file']);
}
else {
die('File was not submitted!');
?>

<body>
<div id="container">
    <div id="header">
        <p>You have Successfully logged in!. <a  href="logout.php" class="button">Logout</a></p>
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
        <div class="member-dashboard">
            <div class="add-form">
                <h1 class="text-center">Please Insert new Item image</h1>
                <form method="post" enctype="multipart/form-data">
                    <label>User Name</label>
                    <input type="text" name="user_name" class="form-control" required="">
                    <label>Picture Profile</label>
                    <input type="file" name="profile" class="form-control" required="" accept="*/image">
                    <button type="submit" name="btn-add">Add New </button>

                </form>
            </div>
        </div>
        <div>
            <div>
                <div>
                    <?php
                    $stmt=$db_conn->prepare('SELECT * FROM `files` ORDER BY `fl_id` DESC');
                    $stmt->execute();
                    if($stmt->rowCount()>0)
                    {
                        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                        {
                            extract($row);
                            ?>
                            <div>
                                <p><?php echo $username ?></p>
                                <img src="uploads/<?php echo $row['picProfile']?>"><br><br>

                                <a class="" href="edit_form.php?edit_id=<?php echo $row['id']?>" title="click for edit" onlick="return confirm('Sure to edit this record')"><span class="glyphicon glyphicone-edit"></span>Edit</a>
                                <a class="" href="?delete_id=<?php echo $row['id']?>" title="click for delete" onclick="return confirm('Sure to delete this record?')">Delete</a>

                            </div>

                            <?php

                        }
                    }
                    ?>
                </div>

            </div>
        </div>
    </div>
    <div id="footer">
        <p>2014, EPAM RD PHP Training</p>
    </div>
</div>
</body>
</html>