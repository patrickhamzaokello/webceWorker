<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../../../admin/config.php';
include_once '../Functions/Appointments.php';

$database = new Database();
$db = $database->getConnString();

$items = new Appointments($db);
$data = json_decode(file_get_contents("php://input"));


if(!empty($data->userid)  && !empty($data->purpose)&& !empty($data->appointment_date)){

    $items->userid = $data->userid;
    $items->purpose = $data->purpose;
    $items->appointment_date = $data->appointment_date;
    $items->datecreated = date('Y-m-d H:i:s');


    if($items->create()){
        http_response_code(201);
        $response['error'] = false;
        $response['message'] = 'Appointment was created.';
        echo json_encode($response);

    } else{
        http_response_code(503);
        $response['error'] = true;
        $response['message'] = 'Unable to create Appointment.';
        echo json_encode($response);
    }
}else{
    http_response_code(400);
    $response['error'] = true;
    $response['message'] = 'Unable to create item. Data is incomplete.';
    echo json_encode($response);
}
?>