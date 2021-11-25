<?php
include("connection.php");
function inputfields($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$oldpass_error = $pass_error = $conpass_error = $output = '';

if (isset($_POST['cpass'])) {

    $opass = inputfields($_POST['oldpass']);
    $npass = inputfields($_POST['pass']);
    $conpass = inputfields($_POST['conpass']);


    if (empty($opass)) {
        $oldpass_error = "Please enter password";
    } else {
        $password = substr(sha1($opass), 0, 12);
        if ($password != $pass) {
            $oldpass_error = "Incorrect password";
        }
    }

    if (empty($npass)) {
        $pass_error = "Please enter password";
    } else {
        if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/", $npass)) {
            $pass_error = "Minimum eight characters, at least one uppercase letter, one lowercase letter and one number";
        }
    }

    if (empty($conpass)) {
        $conpass_error = "Please enter password";
    } else {
        if ($conpass != $npass) {
            $conpass_error = "Password doesn't match";
        }
    }

    if ($conpass_error == "" && $oldpass_error == "" && $pass_error == "") {
        $npassword = substr(sha1($npass), 0, 12);
        if (mysqli_query($conn, "update users set password = '$npassword' where email = '$mail'")) {
            $output = "Password changed successfully!!!";
        } else {
            $output =  "Updating Error";
        }
    }
}

?>
<div class="container">
    <h4>Change Password</h4>
    <hr />
    <form method="POST">
        <h5 class="my-2" style="color: green;"><?php echo "$output"; ?></h5>
        <div class="form-group row">
            <label for="opass_id" class="col-sm-2 col-form-label">Old Password:</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="opass_id" name="oldpass" placeholder="Old Password">
                <span class="error"><?php echo "$oldpass_error"; ?></span>
            </div>
        </div>
        <div class="form-group row">
            <label for="pass_id" class="col-sm-2 col-form-label">Password:</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="pass_id" name="pass" placeholder="New Password">
                <span class="error"><?php echo "$pass_error"; ?></span>
            </div>
        </div>
        <div class="form-group row">
            <label for="conpass_id" class="col-sm-2 col-form-label">Password:</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="conpass_id" name="conpass" placeholder="Re-Enter New Password">
                <span class="error"><?php echo "$conpass_error"; ?></span>
            </div>
        </div>
        <br />
        <input type="submit" class="btn btn-primary btn-large" name="cpass" value="Change Password">

    </form>
</div>
<?php mysqli_close($conn) ?>