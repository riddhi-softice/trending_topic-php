<?php
    session_start();
    require_once './config/config.php';
    require_once 'includes/auth_validate.php';

    //Handle update request. As the form's action attribute is set to the same script, but 'POST' method, 
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $id = $_POST['id'];
        $show_status = $_POST['show_status'];

        $data_to_update = [];

        // Fetch current video info to remove old video if needed
        $db = getDbInstance();

        $data_to_update['show_status'] = $show_status;
        $data_to_update['updated_at'] = date('Y-m-d H:i:s');
        $db->where('id', $id);
        $stat = $db->update('video_tabel', $data_to_update);
        
       if ($stat) {
            $_SESSION['success'] = "Video status changed successfully!";
            echo "success"; // Signal success to JS
        } else {
            $_SESSION['failure'] = "Update failed: " . $db->getLastError();
            echo "error"; // Signal error to JS
        }
    }
?>
