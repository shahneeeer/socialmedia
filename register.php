<?php
include("connection.php");
function inputfields($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
$name_error = $username_error = $age_error = $gen_error = $mail_error = $pass_error = $mob_error = $conpass_error = $pic_error = $city_error  = $output = '';

if (isset($_POST['reg'])) {
    $name = inputfields($_POST['name']);
    $username = inputfields($_POST['username']);
    $age = inputfields($_POST['age']);
    $gen = @$_POST['gen'];
    $mail = inputfields($_POST['mail']);
    $pass = inputfields($_POST['pass']);
    $mob = inputfields($_POST['mob']);
    $conpass = inputfields($_POST['conpass']);
    $city = @$_POST['city'];
    $tmp = $_FILES['pic']['tmp_name'];
    $pic = $_FILES['pic']['name'];

    if (empty($name)) {
        $name_error = "Please enter name";
    } else {
        if (!preg_match("/^[a-zA-Z ]{2,100}$/", $name)) {
            $name_error = "Enter valid format";
        }
    }

    if (empty($username)) {
        $username_error = "Please enter username";
    } else {
        if (!preg_match("/^[a-zA-Z_.]{2,100}$/", $username)) {
            $username_error = "Enter valid format";
        }
    }

    if (empty($gen)) {
        $gen_error = "Please select gender";
    }

    if (empty($age)) {
        $age_error = "Please enter age";
    } else {
        if (!($age >= 1 && $age <= 100)) {
            $age_error = "Enter valid age";
        }
    }

    if (empty($mail)) {
        $mail_error = "Please enter email";
    } else {
        if (!preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $mail)) {
            $mail_error = "Invalid format (Example - abc@xyz.com)";
        }
    }

    if (empty($pass)) {
        $pass_error = "Please enter password";
    } else {
        if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/", $pass)) {
            $pass_error = "Minimum eight characters, at least one uppercase letter, one lowercase letter and one number";
        }
    }

    if (empty($conpass)) {
        $conpass_error = "Please enter password";
    } else {
        if ($pass!=$conpass) {
            $conpass_error = "Password doesn't match";
        }
    }

    if (empty($city)) {
        $city_error = "Please select city";
    }


    if (empty($tmp)) {
        $pic_error = "Upload a picture";
    } else {
        $ext = pathinfo($pic, PATHINFO_EXTENSION);
       
    }

    if (empty($mob)) {
        $mob_error = "Please enter mobile number";
    } else {
        if (!preg_match("/^[6-9][0-9]{9}+$/", $mob)) {
            $mob_error = "Only 10 digit  allow";
        }
    }


    if ($name_error == "" && $username_error == "" && $age_error == "" && $gen_error == "" && $mail_error == "" && $pass_error == "" && $conpass_error == "" && $city_error == "" && $mob_error == "" && $pic_error == "") {
        $img_path =  "uploads/users/" . $mail . time() . "." . $ext;
        $password = substr(sha1($pass), 0, 12);
        if(mysqli_query($conn, "insert into users(username, email, name, age, gender, city, mobile, picture, password) values ('$username','$mail','$name','$age','$gen','$city','$mob','$img_path','$password')")){
            if (move_uploaded_file($tmp, $img_path)) {
                $pic_error =  "File uploaded";
            } else {
                $pic_error = "Error";
            }
            $output = "User added";
            header("location:index.php");
        }
        else{
            $output =  "User already exists";
        }
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <?php include "head.php"; ?>
    <title>Register New User</title>
    <style>
        .error{
            color: red;
        }
        .mar{
            margin-top: 6%;
            background-color: lavender;
        }
    </style>
</head>

<body>
 
    <div class="container mar">
        <h2 class="text-center">REGISTER</h2>
        <form method="POST" enctype="multipart/form-data">
            <h5 style="color: green;"><?php echo "$output"; ?></h5>
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Name:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control"  name="name" placeholder="Name">
                    <span class="error"><?php echo "$name_error"; ?></span>
                </div>
            </div>
            <div class="form-group row">
                <label for="username" class="col-sm-2 col-form-label">Username:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control"  name="username" placeholder="Username">
                    <span class="error"><?php echo "$username_error"; ?></span>
                </div>
            </div>
            <div class="form-group row">
                <label for="mail" class="col-sm-2 col-form-label">Email:</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" id="mail" name="mail" placeholder="Email">
                    <span class="error"><?php echo "$mail_error"; ?></span>
                </div>
            </div>
            <div class="form-group row">
                <label for="age" class="col-sm-2 col-form-label">Age:</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="age" name="age" placeholder="Age">
                    <span class="error"><?php echo "$age_error"; ?></span>
                </div>
            </div>
            <div class="form-group row">
                <label for="gen" class="col-sm-2 col-form-label">Gender:</label>
                <div class="col-sm-10">
                    <input type="radio" name="gen" value="Male">&nbsp;Male&nbsp;
                    <input type="radio" name="gen" value="Female">&nbsp;Female&nbsp;
                    <input type="radio" name="gen" value="Other">&nbsp;Other&nbsp;
                    <span class="error"><?php echo "$gen_error"; ?></span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">City:</label>
                <div class="col-sm-10">
                    <select name="city" class="form-control">
                        <option value="">Select an Option</option>
                        <option value="mumbai">Mumbai</option>
                        <option value="delhi">Gujarat</option>
                        <option value="chennai">kerala</option>
                        <option value="pune">other</option>
                    </select>
                    <span class="error"><?php echo "$city_error" ?></span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Mobile:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="mob" placeholder="Mobile">
                    <span class="error"><?php echo "$mob_error"; ?></span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Profile Picture:</label>
                <div class="col-sm-10">
                    <input type="file" name="pic">
                    <span class="error"><?php echo "$pic_error"; ?></span>
                </div>
            </div>
            <div class="form-group row">
                <label for="pass_id" class="col-sm-2 col-form-label">Password:</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="pass_id" name="pass" placeholder="Password">
                    <span class="error"><?php echo "$pass_error"; ?></span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Confirm Password:</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" name="conpass" placeholder="Re-enter Password">
                    <span class="error"><?php echo "$conpass_error"; ?></span>
                </div>
            </div>
            <input type="submit" class="btn btn-primary btn-large" name="reg" value="Register">
            <a href="index.php" class="pull-right btn btn-default">Login</a>
        </form>
    </div>

    <?php include "foot.php"; ?>
    <?php mysqli_close($conn) ?>
</body>

</html>