<?php 
session_start();
require_once 'includes/auth_validate.php';
require_once './config/config.php';
$del_id = filter_input(INPUT_POST, 'del_id');
if ($del_id && $_SERVER['REQUEST_METHOD'] == 'POST') 
{

	// if($_SESSION['admin_type']!='super'){
	// 	$_SESSION['failure'] = "You don't have permission to perform this action";
    // 	header('location: mobile-video.php');
    //     exit;
	// }
    $video_id = $del_id;

    $db = getDbInstance();
    $db->where('id', $video_id);
    $status = $db->delete('video_tabel');
    
    if ($status) 
    {
        $_SESSION['info'] = "Video deleted successfully!";
        header('location: mobile-video.php');
        exit;
    }
    else
    {
    	$_SESSION['failure'] = "Unable to delete video";
    	header('location: mobile-video.php');
        exit;

    }
    
}