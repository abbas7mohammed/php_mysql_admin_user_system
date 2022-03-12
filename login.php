<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>Manshoor</title>
</head>
    <body>
    
    <?php
    // login code
        ob_start();
        session_start();
        if(isset($_SESSION['userId'])){
            header('Location:user/userhome.php');
            exit();
        }

        include 'db.php';

        if($_SERVER['REQUEST_METHOD']=='POST'){
            if(isset($_POST['loginSubmit'])){
                $usrEmail = filter_var($_POST['userEmail'],FILTER_SANITIZE_EMAIL);
                $usrPassword = $_POST['userPassword'];
                $stmt = $connect->prepare(
                    'SELECT * FROM users 
                    WHERE email=? AND `password`=?');
                $stmt->execute(array($usrEmail,$usrPassword));
                $result = $stmt->rowCount();
                if($result>0){
                    $account = $stmt->fetch();
                    $_SESSION['userID'] = $account['id'];
                    $_SESSION['userName'] = $account['name'];
                    $_SESSION['userEmail'] = $account['email']; 
                    $_SESSION['postUserID'] = $account['user_id'];
                    

                    if($account['type']=='1'){
                        $_SESSION['type'] = '1';
                        header('Location:admin/adminhome.php');
                        exit();
                    }else{
                        $_SESSION['type'] = '0';
                        header('Location:user/userhome.php');
                        exit();
                    }


                }

            }
        }
    ?>

        <div class="container">
            <div class="row d-flex justify-content-center ">
                <div class="col m-4 bg-info" style="height: 50;">
                    <h2>Login</h2>
                </div>
                <div class="col p-5">
                    <form class="m-4" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <input type="email" name="userEmail" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            <div id="emailHelp" class="form-text">password should at least 8 chars.</div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" name="userPassword" class="form-control" id="exampleInputPassword1">
                        </div>
                        <button type="submit" name="loginSubmit" class="btn btn-primary">Login</button>
                        <div>
                            <h6 style="font-size: 13px;margin-top:5px">if you don't have account, please <span><a href="register.php">register</a></span></h6>
                        </div>
                    </form>        
                </div>
            </div>
        </div>
    </body>
</html>


    <?php
        ob_flush();
    ?>