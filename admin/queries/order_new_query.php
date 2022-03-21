<?php
$orderNew = array();

$order_new = mysqli_query($con, "SELECT order_id FROM tblorder WHERE  order_status = 1 ORDER BY `tblorder`.`order_date` DESC ");

while ($row = mysqli_fetch_array($order_new)) {

    array_push($orderNew, $row['order_id']);

}
