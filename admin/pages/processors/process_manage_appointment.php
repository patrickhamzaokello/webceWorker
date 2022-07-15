<?php
include("../../config.php");

$db = new Database();
$con = $db->getConnString();

$errors = [];
$data = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // username and password sent from form 
    $childname = mysqli_real_escape_string($con, $_POST['childname']);
    $orderstatus = mysqli_real_escape_string($con, $_POST['orderstatus']);
    $order_action = mysqli_real_escape_string($con, $_POST['order_action']);

    if (empty($_POST['childname'])) {
        $errors['childname'] = 'Referral ID is Required';
    }
    if (empty($_POST['orderstatus'])) {
        $errors['order Status'] = 'Referral status is Required';
    }
    if (empty($_POST['order_action'])) {
        $errors['order Status'] = 'Referral action is Required';
    }

    if (!empty($errors)) {
        $data['success'] = false;
        $data['errors'] = $errors;
    } else {

        if(intval($order_action)  == 1){

            $delete_order_sql = "DELETE FROM `appointments` WHERE  `id` = '$childname'";

            mysqli_query($con,$delete_order_sql);
    
            $affected_rows = mysqli_affected_rows($con);
    
            if ($affected_rows >= 1) {
                $data['success'] = true;
                $data['message'] = $affected_rows .' Appointment Deleted!';
            } else if($affected_rows <= 0) {
                $data['success'] = false;
                $data['message'] = 'Appointment with ID '.$childname.' Not Deleted';
            }

        } elseif (intval($order_action)  == 2){

            if(intval($orderstatus) == 0){
                $update_order_status = "UPDATE `appointments` SET `status`= 1  WHERE `id` = $childname";
    
            } elseif (intval($orderstatus) == 1){
                $update_order_status = "UPDATE `appointments` SET `status`= 2  WHERE `id` = $childname";
    
            } elseif (intval($orderstatus) == 2){
                $update_order_status = "UPDATE `appointments` SET `status`= 3  WHERE `id` = $childname";
            }
    
            mysqli_query($con,$update_order_status);
    
            $affected_rows = mysqli_affected_rows($con);
    
            if ($affected_rows >= 1) {
                $data['success'] = true;
                $data['message'] = $affected_rows .' Referral Approved!';
            } else if($affected_rows <= 0) {
                $data['success'] = false;
                $data['message'] = 'Referral with ID '.$childname.' Not Updated';
            }
        }

    }
}

echo json_encode($data);