<?php

ob_start();
session_start();
include 'initUser.php';
if(isset($_SESSION['userEmail'])){

    //check if account user or admin
    if($_SESSION['type']=='1'){
        include '../Admin/include/template/adminnavbar.php';
    }else{
        include 'include/template/usernavbar.php';
    }
    $uName = $_SESSION['userName'];

    $postStmt = $connect->prepare("SELECT posts.*,
    users.name AS names
    FROM posts
    INNER JOIN users
    ON posts.user_id=users.id
    ORDER BY post_date DESC
    ");
    $postStmt->execute();
    $rows = $postStmt->rowCount();
    $allPosts = $postStmt->fetchAll();


?>

<div class="container">
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-12">
        <img src="../images/manshoor.JPG" width="250" height="200" alt="profile">
        </div>
        <div class="col-lg-9 col-md-9 col-sm-12" style="padding:15px">
        <?php
                if($rows>0){
                    foreach($allPosts as $post){
                        ?>
                            <div class="card" style="width: 32rem;padding:10px; margin:10px;background-color: #ECF0F1">
                            <div class="display:flex; justify-content:space-between">
                            <div>
                            <h6 style="font-size: 12px;padding:10px;margin-top:5px;background-color:#000080;color:#ECF0F1"><?php echo $post['names'] ?></h6>
                            </div>
                            </div>
                            <img src="uploads/<?php echo $post['image'] ?>" class="card-img-top" alt="cardPic" width="60px" height="120px">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $post['title'] ?></h5>
                                <p class="card-text"><?php echo $post['body'] ?></p>
                            </div>
                         </div>
                         <?php
                    }
                }else{
                    echo "<div class='alert alert-danger'>Thers is no posts</div>";
                }?>
        </div>
    </div>
</div>

<?php
    include 'include/template/userfooter.php';
    }else{
        echo "<div class='alerrt alert-danger'> you can not browse directly ... it will rediredct after 5 seconds</div>";
        header('Refresh:5, url=../login.php');
        exit();
    }
    ob_flush();
?>





