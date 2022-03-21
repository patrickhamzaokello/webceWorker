<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../../../../admin/config.php';
include_once '../Classes/MenuTypeClass.php';
include_once '../Functions/MenuType.php';

$database = new Database();
$db = $database->getConnString();
 
$items = new MenuType($db);

$items->id = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : '0';

$result = $items->read();

if($result){    
    http_response_code(200);     
    echo json_encode($result);
}else{     
    http_response_code(404);     
    echo json_encode(
        array("message" => "No item found.")
    );
} 
?>