<?php
session_start();
require_once './config/config.php';
require_once './includes/auth_validate.php';


//serve POST method, After successful insert, redirect to list page.
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    // Filter input data
    $data_to_store = array_filter($_POST);
   
    // Handle video upload
    if (isset($_FILES['video_file']) && $_FILES['video_file']['error'] === UPLOAD_ERR_OK) {

        $upload_dir = 'uploads/videos/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $video_tmp_name = $_FILES['video_file']['tmp_name'];
        $video_original_name = basename($_FILES['video_file']['name']);

        // Optional: Prevent filename collision
        $video_new_name = time() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "_", $video_original_name);
        $video_target_path = $upload_dir . $video_new_name;

        // Basic check for video MIME type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $video_tmp_name);
        finfo_close($finfo);

        if (strpos($mime, 'video/') === 0) {
            if (move_uploaded_file($video_tmp_name, $video_target_path)) {
                $data_to_store['video_name'] = $video_new_name;
            } else {
                echo 'Failed to move uploaded video.';
                exit();
            }
        } else {
            echo 'Uploaded file is not a valid video.';
            exit();
        }
    } else {
        echo 'Video file upload failed or no video was selected.';
        exit();
    }

    // Insert timestamp
    $data_to_store['created_at'] = date('Y-m-d H:i:s');
    
    $db = getDbInstance();
    $last_id = $db->insert('video_tabel', $data_to_store);

    if($last_id)
    {
        $_SESSION['success'] = "Video added successfully!";
        header('location: mobile-video.php');
        exit();
    }
    else
    {
        echo 'Insert failed: ' . $db->getLastError();
        exit();
    }
}


//We are using same form for adding and editing. This is a create form so declare $edit = false.
$edit = false;

require_once 'includes/header.php'; 
?>
<div id="page-wrapper">
<div class="row">
    <div class="col-lg-12">
            <h2 class="page-header">Add Video</h2>
    </div>
</div>

    <div class="container mt-4">
        <form class="form" action="" method="post"  id="video_form" enctype="multipart/form-data">
        <?php  include_once('./forms/video_form.php'); ?>
        </form>
    </div>
</div>


<script type="text/javascript">
$(document).ready(function(){
   $("#video_form").validate({
       rules: {
            f_name: {
                required: true,
                minlength: 3
            } 
        }
    });
});
</script>

<?php include_once 'includes/footer.php'; ?>