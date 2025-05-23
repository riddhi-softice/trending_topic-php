<?php
    session_start();
    require_once './config/config.php';
    require_once 'includes/auth_validate.php';

    // Sanitize if you want
    $edit = true; 
    $db = getDbInstance();

    //Handle update request. As the form's action attribute is set to the same script, but 'POST' method, 
    if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
        //Get input data
        $data_to_update = filter_input_array(INPUT_POST);
        // print_r($data_to_update); die;
        
        $data_to_update['updated_at'] = date('Y-m-d H:i:s');
        $db = getDbInstance();
        // $db->where('id',$setting_id);
        $db->where('setting_key',"video_show_status");
        $stat = $db->update('common_setting', $data_to_update);

        if($stat)
        {
            $_SESSION['success'] = "Data updated successfully!";
            //Redirect to the listing page,
            header("Location: " . $_SERVER['REQUEST_URI']);
            //Important! Don't execute the rest put the exit/die. 
            exit();
        }
    }
    //If edit variable is set, we are performing the update operation.
    if($edit)
    {
        $db->where('setting_key',"video_show_status");
        //Get data to pre-populate the form.
        $customer = $db->getOne("common_setting");
        // print_r($customer);die;
    }
?>

<?php include_once 'includes/header.php'; ?>

<div id="page-wrapper">
    <div class="row"> 
        <h2 class="page-header">Video Setting</h2>
    </div>
    <!-- Flash messages -->
    <?php include('./includes/flash_messages.php') ?>
    
    <form class="" action="" method="post" enctype="multipart/form-data" id="contact_form">        
        <?php include_once './forms/video_setting_form.php'; ?>
    </form>
</div>

<?php include_once 'includes/footer.php'; ?>