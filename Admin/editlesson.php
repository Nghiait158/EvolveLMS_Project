<?php
if(!isset($_SESSION)) {
    session_start();
}

include('./admininclude/header.php');
include('./dbConnection.php');

if (isset($_SESSION['is_admin_login'])) {
    $adminEmail = $_SESSION['adminLogEmail'];
} else {
    echo "<script> location.href='../index.php'; </script>";
}

// Update

if(isset($_REQUEST['requpdate'])) {
    if(($_REQUEST['course_id'] == "") || ($_REQUEST['course_name'] == "")
    || ($_REQUEST['course_desc'] == "") || ($_REQUEST['course_author'] == "")
    || ($_REQUEST['course_duration'] == "") || ($_REQUEST['course_price'] == "")
    || ($_REQUEST['course_original_price'] == "")) {
        // msg displayed if required field missing
        $mgs = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role ="alert">Fill All Fields</div>';
    } else {
        // Assigning User Values to Variable
        $cid = $_REQUEST['course_id'];
        $cname = $_REQUEST['course_name'];
        $cdesc = $_REQUEST['course_desc'];
        $cauthor = $_REQUEST['course_author'];
        $cduration = $_REQUEST['course_duration'];
        $cprice = $_REQUEST['course_price'];
        $coriginalprice = $_REQUEST['course_original_price'];
        $cimg = '../image/courseimg/' . $_FILES['course_img']['name'];

        $sql = "UPDATE course SET course_id = '$cid', course_name = '$cname',
        course_desc = '$cdesc', course_author = '$cauthor', course_duration = '$cduration',
        course_price = '$cprice', course_original_price = '$coriginalprice', course_img = '$cimg'
        WHERE course_id = '$cid'";

        if($conn->query($sql) == TRUE) {
            // below msg display on form submit success
            $msg = '<div class ="alert alert-success col-sm-6 ml-5 mt-2"
            role="alert">Updated Successfully</div>';
        } else {
            // below msg display on form submit failed
            $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2"
            role="alert">Unable to Update</div>';
        }
    }
}

?>

<div class="col-sm-6 mt-5 mx-3 jumbotron">
    <h3 class="text-center">Update Lesson Details</h3>

<?php
    if(isset($_REQUEST['view'])) {
        $sql = "SELECT * FROM course WHERE lesson_id = {$_REQUEST['id']}";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
    }

?>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="lesson_id">Lesson ID</label>
            <input type="text" class="form-control" id="lesson_id"
            name="lesson_id" value="<?php if(isset($row['lesson_id']))
            {echo $row['lesson_id']; }?>" readonly>
        </div>
        <div class="form-group">
            <label for="lesson_name">Lesson Name</label>
            <input type="text" class="form-control" id="lesson_name"
            name="lesson_name" value="<?php if(isset($row['lesson_name'])
            ) {echo $row['lesson_name']; }?>">
    </div>
    
    <div class="form-group">
        <label for="lesson_desc">Lesson Description</label>
        <textarea class="form-control" id="lesson_desc"
        name="lesson_desc" rows=2><?php if(isset($row['lesson_desc'])
        ) {echo $row['lesson_desc']; }?></textarea>
    </div>
    <div class="form-group">
        <label for="course_id">Course ID</label>
        <input type="text" class="form-control" id="course_id"
        name="course_id" value="<?php if(isset($row['course_id']))
        {echo $row['course_id']; }?>" readonly>
    </div>
    <div class="form-group">
        <label for="course_name">Course Name</label>
        <input type="text" class="form-control" id="course_name"
        name="course_name" onkeypress="isInputNumber(event)"
        value="<?php if(isset($row['course_name'])) {echo $row
        ['course_name']; }?>" readonly>
        </div>
        <div class="form-group">
        <label for="lesson_link">Lesson Link</label>
        <div class="embed-responsive embed-responsive-16by9">
        <iframe class="embed-responsive-item" src="<?php if(isset ($row['lesson_link'])) {echo $row['lesson_link']; }?>" allowfullscreen></iframe>
        </div>
        <input type="file" class="form-control-file"
        id="lesson_link" name="lesson_link">
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-danger" id="requpdate"
            name="requpdate">Update</button>
            <a href="lessons.php" class="btn btn-secondary">Close</a>
        </div>
        <?php if(isset($msg)) {echo $msg; } ?>
    </form>
</div>
</div>  <!--div Row close from header -->
</div>  <!--div Container-fluid close from header -->

<?php
include('./admininclude/footer.php');
?>
