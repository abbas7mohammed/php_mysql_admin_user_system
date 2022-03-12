<?php
    // Register code
        ob_start();
        session_start();
        include 'initUser.php';
        include 'include/template/usernavbar.php';

        if($_SERVER['REQUEST_METHOD']=='POST'){
            if(isset($_POST['addPost'])){
                $postTitle = $_POST['title'];
                $postBody = $_POST['body'];
                $uId = $_SESSION['userID'];

                //$id = intval($_GET['id']);

                // image uploaf

                $imageName=$_FILES['myimage']['name'];
                $imageSize=$_FILES['myimage']['size']; 
                $imageTmp=$_FILES['myimage']['tmp_name']; 
                $imageType=$_FILES['myimage']['type']; 
                $imgExtension1= explode('.', $imageName); 
                $imgExtension2 = strtolower (end ($imgExtension1)); 
                $allowedExtensions=array ("jpeg","jpg"."png", "gif", "svg"); 
                $finalImage = rand (0,10000). "_" . $imageName; 
                move_uploaded_file($imageTmp, "uploads/". $finalImage);

                $stmt = $connect->prepare(
                    'INSERT INTO posts(title,body,`user_id`,`image`) 
                    VALUES (?,?,?,?)');
                $stmt->execute(array($postTitle,$postBody, $uId,$finalImage));
                $result = $stmt->rowCount();
                    $allPosts = $stmt->fetch();
                    header('Location: userhome.php');


            }
        }
    ?>


<div class="container">
    <div class="row d-flex justify-content-center ">
        <div class="col m-4 bg-info" style="height: 50;">
            <h2>Add Post</h2>
        </div>
        <div class="col p-5">
            <form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                <div class="mb-3">
                    <label for="exampleInputName1" class="form-label">title</label>
                    <input type="text" name="title" class="form-control" id="exampleInputName1" aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text">type post title.</div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">body</label>
                    <input type="text" name="body" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text">type post detail</div>
                    <div class="mb-3">
                    <label for="formFileSm" class="form-label">upload image</label>
                    <input class="form-control form-control-sm" name="myimage" id="formFileSm" type="file" value="image">
                    </div>
                </div>
                <button type="submit" name="addPost" class="btn btn-primary">Submit</button>
            </form>        
        </div>
    </div>
</div>


<?php
    include 'include/template/userfooter.php';
    ob_flush();
?>