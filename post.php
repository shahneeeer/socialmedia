<?php
error_reporting(0);
include "connection.php";
session_start();
$arr = $_SESSION['user'];
$id = $arr['id'];


if (isset($_POST['btnComm'])) {
    $comment = $_POST['comment'];
    
    $post_id=$_POST['post_id'];
    echo $comment;
    echo $post_id;

    if (!empty($post_id) && !empty($comment)) {
        mysqli_query($conn, "insert into comments (comment, post_id, user_id) values ('$comment',$post_id,$id)");
    }
}



?>
<!DOCTYPE html>
<html>

<head>
    <?php include "head.php"; ?>
    <title>Posts</title>
</head>

<body>
    <a href="dashboard.php" class="btn btn-success">Back </a>
    <div class="container my-2">
        
        <?php
        $sel = mysqli_query($conn, 'select * from posts');
        if (mysqli_num_rows($sel) > 0) {
            while ($arr = mysqli_fetch_assoc($sel)) {
                $uid = $arr['user_id'];
                $user = mysqli_query($conn, "select * from users where id = $uid");
                $u = mysqli_fetch_assoc($user);
        ?>
                <div class="card my-4">
                  <?php echo $u['name']?>
                    <div class="card-body" style="background-color: lightblue" >
                        <h6 class="card-title"><?php echo $arr['title']; ?></h6>
                        <p class="card-text"><?php echo $arr['description']; ?></p>
                    </div>

                    <img class="mx-auto border my-2" src="<?php echo $arr['post_path']; ?>" alt=" not available" width="200px" height="200px">
                    <div class="container mx-auto mt-1">
                        <form method="POST">
                            <div class="row px-1">
                                <input class="bg-light form-control col-sm-10" type="text" name="comment" placeholder="Add comment">
                                <input type="submit" class="btn btn-info col-sm-2" name="btnComm" value="Comment">
                                <input type="hidden" name="post_id" value=<?php echo $arr['id']  ?>>
                            </div>
                        </form>
                        <section>
                            <?php
                            $pid = $arr['id'];
                            $csel = mysqli_query($conn, "select * from comments where post_id = $pid");
                            if (mysqli_num_rows($csel) > 0) {
                                while ($c = mysqli_fetch_assoc($csel)) {
                                    $uid = $c['user_id'];
                                    $usel = mysqli_query($conn, "select * from users where id = $uid");
                                    $u = mysqli_fetch_assoc($usel);
                            ?>
                                    <div class="p-1 my-2" >
                                        <h5 class="mt-2 text-primary">
                                            <?php echo $u['name']; ?>
                                        </h5>
                                        <p class=""><?php echo $c['comment']; ?></p>
                                    </div>

                                <?php
                                }
                            } else {
                                ?>
                                <p >No comments found</p>
                            <?php
                            }
                            ?>
                        </section>
                    </div>

                </div>
            <?php
            }
        } else {
            ?>
            <h4>No posts available</h4>
        <?php
        }

        ?>

    </div>

    <?php include "head.php"; ?>
    <?php mysqli_close($conn) ?>
</body>

</html>