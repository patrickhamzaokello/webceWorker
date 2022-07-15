<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../../../../admin/config.php';
include_once '../Functions/Referral.php';
 
$database = new Database();
$db = $database->getConnString();
 
$items = new Referral($db);
$data = json_decode(file_get_contents("php://input"));


if(!empty($data->title) && !empty($data->category_id) && !empty($data->reportedby_id)&& !empty($data->description)){
  
    $items->title = $data->title;
    $items->picture = $data->picture;
    $items->description = $data->description;
    $items->category_id = $data->category_id;
    $items->reportedby_id = $data->reportedby_id;
    $items->address = $data->address;
    $items->status = 1;
    $items->datecreated = date('Y-m-d H:i:s');



    if($items->create()){         
        http_response_code(201);  
        $response['error'] = false;
        $response['message'] = 'Referral was created.';
        echo json_encode($response);
      
    } else{         
        http_response_code(503);   
        $response['error'] = true;
        $response['message'] = 'Unable to create Referral.';
        echo json_encode($response);
    }
}else{    
    http_response_code(400);    
    $response['error'] = true;
    $response['message'] = 'Unable to create item. Data is incomplete.';     
    echo json_encode($response);
}
?>