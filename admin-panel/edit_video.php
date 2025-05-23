<?php
    session_start();
    require_once './config/config.php';
    require_once 'includes/auth_validate.php';


    // Sanitize if you want
    $video_id = filter_input(INPUT_GET, 'video_id', FILTER_VALIDATE_INT);
    $operation_raw = $_GET['operation'] ?? '';
    $operation = preg_replace('/[^a-zA-Z_]/', '', $operation_raw); // only allow valid characters
 
    ($operation == 'edit') ? $edit = true : $edit = false;
    $db = getDbInstance();

    //Handle update request. As the form's action attribute is set to the same script, but 'POST' method, 
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $video_id = filter_input(INPUT_GET, 'video_id', FILTER_VALIDATE_INT);
        if (!$video_id) {
            die('Invalid video ID.');
        }

        $data_to_update = [];

        // Fetch current video info to remove old video if needed
        $db = getDbInstance();
        $db->where('id', $video_id);
        $existing_video = $db->getOne('video_tabel');

        // Handle file upload (optional in edit mode)
        if (isset($_FILES['video_file']) && $_FILES['video_file']['error'] == UPLOAD_ERR_OK) {
            $file_tmp = $_FILES['video_file']['tmp_name'];
            $file_ext = pathinfo($_FILES['video_file']['name'], PATHINFO_EXTENSION);
            $video_new_name = time() . '_' . rand(1, 1000) . '.' . $file_ext;

            // Ensure upload directory exists
            $upload_dir = 'uploads/videos/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            $dest_path = $upload_dir . $video_new_name;

            if (move_uploaded_file($file_tmp, $dest_path)) {
                // Remove old video if it exists
                if (!empty($existing_video['video_name'])) {
                    $old_path = $upload_dir . $existing_video['video_name'];
                    if (file_exists($old_path)) {
                        unlink($old_path); // Delete old file
                    }
                }

                $data_to_update['video_name'] = $video_new_name;
            } else {
                die('Failed to upload video.');
            }
        }

        $data_to_update['updated_at'] = date('Y-m-d H:i:s');

        $db->where('id', $video_id);
        $stat = $db->update('video_tabel', $data_to_update);

        if ($stat) {
            $_SESSION['success'] = "Video updated successfully!";
            header('location: mobile-video.php');
            exit();
        } else {
            echo 'Update failed: ' . $db->getLastError();
            exit();
        }
    }


    //If edit variable is set, we are performing the update operation.
    if($edit)
    {
        $db->where('id', $video_id);
        //Get data to pre-populate the form.
        $customer = $db->getOne("video_tabel");
    }
?>

<?php include_once 'includes/header.php'; ?>

<div id="page-wrapper">
    <div class="row">
        <h2 class="page-header">Update Video</h2>
    </div>
    <!-- Flash messages -->
    <?php include('./includes/flash_messages.php') ?>

    <div class="container mt-4">
        <form class="" action="" method="post" enctype="multipart/form-data" id="contact_form">
            <?php
                //Include the common form for add and edit  
                require_once('./forms/video_form.php'); 
            ?>
        </form>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?>