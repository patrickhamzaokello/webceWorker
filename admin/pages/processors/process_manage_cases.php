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
    $feedbackmessage = mysqli_real_escape_string($con, $_POST['feedbackmessage']);
    $userID = mysqli_real_escape_string($con, $_POST['userID']);

    if (empty($_POST['childname'])) {
        $errors['childname'] = 'Case ID is Required';
    }
    if (empty($_POST['orderstatus'])) {
        $errors['order Status'] = 'Case status is Required';
    }
    if (empty($_POST['order_action'])) {
        $errors['order Status'] = 'Case action is Required';
    }   if (empty($_POST['feedbackmessage'])) {
        $errors['feedbackmessage'] = 'Feed back Message is Required';
    }
    if (empty($_POST['userID'])) {
        $errors['userID'] = 'User Id is Required';
    }

    if (!empty($errors)) {
        $data['success'] = false;
        $data['errors'] = $errors;
    } else {

        $sendfeedback_sql = "INSERT INTO `messages`(`userid`, `message`,`refertype`,`referid`) VALUES ($userID, '$feedbackmessage', 'case','$childname')";

        if(intval($order_action)  == 1){

            $delete_order_sql = "DELETE FROM `cases` WHERE  `id` = '$childname'";

            mysqli_query($con,$delete_order_sql);
    
            $affected_rows = mysqli_affected_rows($con);
    
            if ($affected_rows >= 1) {
                mysqli_query($con,$sendfeedback_sql);

                $data['success'] = true;
                $data['message'] = $affected_rows .' Case Deleted!';
            } else if($affected_rows <= 0) {
                $data['success'] = false;
                $data['message'] = 'Case with ID '.$childname.' Not Deleted';
            }

        } elseif (intval($order_action)  == 2){

            if(intval($orderstatus) == 1){
                $update_order_status = "UPDATE `cases` SET `status`= 2  WHERE `id` = $childname";

            } elseif (intval($orderstatus) == 2){
                $update_order_status = "UPDATE `cases` SET `status`= 3  WHERE `id` = $childname";


            } elseif (intval($orderstatus) == 3){
                $update_order_status = "UPDATE `cases` SET `status`= 3  WHERE `id` = $childname";

            }
    
            mysqli_query($con,$update_order_status);
    
            $affected_rows = mysqli_affected_rows($con);
    
            if ($affected_rows >= 1) {
                mysqli_query($con,$sendfeedback_sql);
                $data['success'] = true;
                $data['message'] = $affected_rows .' Case Approved!';
            } else if($affected_rows <= 0) {
                $data['success'] = false;
                $data['message'] = 'Case with ID '.$childname.' Not Updated';
            }
        }

    }
}

echo json_encode($data);