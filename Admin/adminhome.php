<?php
ob_start();
session_start();
include 'initAdmin.php';
if(isset($_SESSION['userEmail'])){
    include 'include/template/adminnavbar.php';
    $userStmt = $connect->prepare("SELECT users.id,users.name,users.email,
    posts.id AS pt
    FROM users
    INNER JOIN posts
    ON users.id=posts.user_id
    ");
    $userStmt->execute();
    $rows = $userStmt->rowCount();
    $allusers = $userStmt->fetchAll();

}

?>


<div class="container">
    <div class="container m-4 ">
        <ul class="nav nav-pills d-flex justify-content-between bg-info">
            <div>
                <li class="nav-item">
                    <h4>Users<h4>
                </li>
            </div>
            <div>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Add user</a>
                </li>
            </div>
        </ul>
    </div>
    <div class="container m-4">
        <table class="table">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">No. of Post</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($allusers as $user){
                    echo    '<tr>';
                    echo    '<th scope="row">' . $user['id'] . '</th>';
                    echo    '<td>' . $user['name'] . '</td>';
                    echo    '<td>' . $user['email'] . '</td>';
                    echo    '<td>' . $user['id']. '</td>';
                    echo    '</tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>












<?php

include 'include/template/adminfooter.php';
?>