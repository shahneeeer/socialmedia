<?php
include("connection.php");
function inputfields($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$userinput_error = $pass_error = '';

if (isset($_POST['log'])) {
    $userinput = inputfields($_POST['userinput']);
    $pass = inputfields($_POST['pass']);

    if (empty($userinput)) {
        $userinput_error = "Please enter email/username";
    } else {
        if (!preg_match("/(^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$)|(^[a-zA-Z_.]{2,100}$)/", $userinput)) {
            $userinput_error = "Invalid format";
        }
    }

    if (empty($pass)) {
        $pass_error = "Please enter password";
    } else {
        if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/", $pass)) {
            $pass_error = "Minimum eight characters, at least one uppercase letter, one lowercase letter and one number";
        }
    }

    if ($userinput_error == "" && $pass_error == "") {
        $password = substr(sha1($pass), 0, 12);
        $sel = mysqli_query($conn, "select * from users where (email = '$userinput') OR (username = '$userinput');");
            $arr = mysqli_fetch_assoc($sel);
            $checkpass = $arr['password'];
            if ($checkpass == $password) {
                if (isset($_POST['rem'])) {
                  
                }
                session_start();
                $_SESSION['user'] = $arr;
                header("location:dashboard.php");
            } else {
                $userinput_error = "Incorrect data entered";
            }

    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <?php include "head.php"; ?>
    <title> Login</title>
    <style>
        .error {
            color: red;
        }
        .mar{
            background-color: lightblue;
        }
    </style>
    <script>
        
    </script>
</head>

<body>
   >
    <div class="container mar">
        <h2> Login</h2>
      
        <form method="POST">
            <div class="form-group row">
                <label for="userinput" class="col-sm-2 col-form-label">Email/Username:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="userinput" placeholder="Email/Username">
                    <span class="error"><?php echo "$userinput_error"; ?></span>
                </div>
            </div>
            <div class="form-group row">
                <label for="pass" class="col-sm-2 col-form-label">Password:</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" name="pass" placeholder="Password">
                    <span class="error"><?php echo "$pass_error"; ?></span>
                </div>
            </div>
            <br />
            <input type="submit" class="btn btn-primary btn-large" name="log" value="Login">
            <a href="register.php" class="pull-right btn btn-default">New User</a>
        </form>
    </div>

    <?php include "foot.php"; ?>
    <?php mysqli_close($conn) ?>
</body>

</html>