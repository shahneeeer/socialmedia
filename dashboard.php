<?php
error_reporting(0);
session_start();
$arr = $_SESSION['user'];
$id = $arr['id'];
$name = $arr['name'];
$uname = $arr['username'];
$mail = $arr['email'];
$pic = $arr['picture'];
$age = $arr['age'];
$gen = $arr['gender'];
$city = $arr['city'];
$mob = $arr['mobile'];
$pass = $arr['password'];
?>
<!DOCTYPE html>
<html>

<head>
    <?php include "head.php"; ?>
    <title>Dashboard</title>
    <style>
        .error{
            color: red;
        }
    </style>
</head>

<body>
    <?php include "nav.php"; ?>
    <div class="row">
        <aside class="col-sm-3">
            <table class="table  text-center ">
                <thead >
                    <tr>
                        <th colspan="2">INFORMATION</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2"><?php echo "<img class='user_pic' src='$pic' height='100px' width='100px'><br/>"; ?>
                           
                        </td>
                    </tr>
                    <tr>
                        <td><b>Name:</b></td>
                        <td><?php echo "$name"; ?></td>
                    </tr>
                    <tr>
                        <td><b>Username:</b></td>
                        <td><?php echo "$uname"; ?></td>
                    </tr>
                    <tr>
                        <td><b>Email:</b></td>
                        <td><?php echo "$mail"; ?></td>
                    </tr>
                    <tr>
                        <td><b>Age:</b></td>
                        <td><?php echo "$age"; ?></td>
                    </tr>
                    <tr>
                        <td><b>Gender:</b></td>
                        <td><?php echo "$gen"; ?></td>
                    </tr>
                    <tr>
                        <td><b>City:</b></td>
                        <td><?php echo "$city"; ?></td>
                    </tr>
                    <tr>
                        <td><b>Mobile:</b></td>
                        <td><?php echo "$mob"; ?></td>
                    </tr>
                </tbody>
            </table>
        </aside>
        <aside class="col-sm-6 py-4">
            <?php
            switch (@$_GET['page']) {

                case 'home':
                    include("home.php");
                    break;

                case 'changepass':
                    include("changepass.php");
                    break;

               

                case 'post':
                    include("post.php");
                    break;

                    case 'comment':
                        include("comment.php");
                        break;

                default:
                    include("home.php");
                    break;
            }
            ?>
        </aside>
    </div>


    <?php include "foot.php"; ?>
</body>

</html>
