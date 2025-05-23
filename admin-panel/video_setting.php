<?php
    session_start();
    require_once './config/config.php';
    require_once 'includes/auth_validate.php';

    // Sanitize if you want
    $edit = true; 
    $db = getDbInstance();

    //Handle update request. As the form's action attribute is set to the same script, but 'POST' method, 
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $ids = $_POST['ids'] ?? [];
        $values = $_POST['values'] ?? [];

        $db = getDbInstance();
        $updated_at = date('Y-m-d H:i:s');
        $success = true;

        foreach ($ids as $id) {
            if (!isset($values[$id])) continue;

            $data = [
                'setting_value' => $values[$id],
                'updated_at' => $updated_at
            ];

            $db->where('id', $id);
            $stat = $db->update('common_setting', $data);

            if (!$stat) {
                $success = false;
                break;
            }
        }

        if ($success) {
            $_SESSION['success'] = "All settings updated successfully!";
        } else {
            $_SESSION['failure'] = "Something went wrong while updating.";
        }

        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    }

    //If edit variable is set, we are performing the update operation.
    if($edit)
    {
        //Get data to pre-populate the form.
        $settings = $db->getAll("common_setting");
        // print_r($customer);die;
    }
?>

<?php include_once 'includes/header.php'; ?>

<div id="page-wrapper">
    <div class="row"> 
        <h2 class="page-header">Common Setting</h2>
    </div>
    <!-- Flash messages -->
    <?php include('./includes/flash_messages.php') ?>
   
    <!-- Form  -->
    <?php include_once './forms/video_setting_form.php'; ?>
                

<?php include_once 'includes/footer.php'; ?>