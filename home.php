<?php
include("connection.php");
function inputfields($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
$title_error = $des_error = $pic_error = $output = "";

if (isset($_POST['postpic'])) {
    $title = inputfields($_POST['title']);
    $des = inputfields($_POST['des']);
    $tmp = $_FILES['post']['tmp_name'];
    $pic = $_FILES['post']['name'];

    if (empty($title)) {
        $title_error = "Please enter heading";
    } else {
        if (!preg_match("/^[a-zA-Z ]{2,100}$/", $title)) {
            $title_error = "Enter valid format (2-100 characters)";
        }
    }

    if (empty($des)) {
        $des_error = "Please enter details";
    } else {
        if (!preg_match("/^[a-zA-Z. ]{5,255}$/", $des)) {
            $des_error = "Enter valid format (5-255 characters)";
        }
    }

    if (empty($tmp)) {
        $pic_error = "Upload a picture";
    } else {
        $ext = pathinfo($pic, PATHINFO_EXTENSION);
        
    }

    if ($title_error == "" && $des_error == "" && $pic_error == "") {
        $img_path =  "uploads/posts/" . $id . $mail . time() . "." . $ext;
        if (mysqli_query($conn, "insert into posts(title, description, post_path, user_id) values ('$title','$des','$img_path','$id')")) {
            if (move_uploaded_file($tmp, $img_path)) {
                $pic_error =  "File uploaded";
            } else {
                $pic_error = "Error";
            }
            $output = "Post uploaded successfully";
            //header("location:dashboard.php");
        } else {
            $output =  "Error uploading post";
        }
    }
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

</script>
<div class="container">
    <h3>Post</h3>
    <form method="POST" enctype="multipart/form-data" id="postForm">
        <h5 style="color: green;"><?php echo "$output"; ?></h5>
        <div class="form-group">
            <label for="title">Heading</label>
            <input type="text" class="form-control" id="title" name="title" >
            <span class="error"><?php echo "$title_error"; ?></span>
        </div>
        <div class="form-group">
            <label for="desc">Details</label>
            <textarea class="form-control" id="des" name="des" ></textarea>
            <span class="error"><?php echo "$des_error"; ?></span>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Upload </label>
            <div class="col-sm-10">
                <input type="file" name="post">
                <span class="error"><?php echo "$pic_error"; ?></span>
            </div>
        </div>
        <button type="submit" name="postpic" id="postpic" class="btn btn-primary">upload</button>
  
    </form>
</div>