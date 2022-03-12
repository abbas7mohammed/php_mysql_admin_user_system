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
    // Register code
        ob_start();
        session_start();
        if(isset($_SESSION['userId'])){
            header('Location:user/userhome.php');
            exit();
        }

        include 'db.php';

        if($_SERVER['REQUEST_METHOD']=='POST'){
            if(isset($_POST['registerSubmit'])){
                $usrName = htmlspecialchars($_POST['userName']);
                $usrEmail = filter_var($_POST['userEmail'],FILTER_SANITIZE_EMAIL);
                $usrPassword = $_POST['userPassword'];
                $typeAccount = $_POST['account'];

                $stmt = $connect->prepare(
                    'INSERT INTO users(name,email,`password`,type) 
                    VALUES (?,?,?,?)');
                $stmt->execute(array($usrName,$usrEmail,$usrPassword,$typeAccount));
                $result = $stmt->rowCount();
                if($result>0){
                    $usrAccount = $stmt->fetch();
                    header('Location: login.php');
                    exit(); 
                }

            }
        }
    ?>


<div class="container">
    <div class="row d-flex justify-content-center ">
        <div class="col m-4 bg-info" style="height: 50;">
            <h2>Register</h2>
        </div>
        <div class="col p-5">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                <div class="mb-3">
                    <label for="exampleInputName1" class="form-label">Name</label>
                    <input type="text" name="userName" class="form-control" id="exampleInputName1" aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text">type user name.</div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" name="userEmail" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text">password should at least 8 chars.</div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" name="userPassword" class="form-control" id="exampleInputPassword1">
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="account" value="1" id="flexRadioDefault1">
                    <label class="form-check-label" for="flexRadioDefault1">
                        admin
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="account" value="0" id="flexRadioDefault1">
                    <label class="form-check-label" for="flexRadioDefault1">
                        user
                    </label>
                </div>
                <button type="submit" name="registerSubmit" class="btn btn-primary">Submit</button>
            </form>        
        </div>
    </div>
</div>



</body>
</html>