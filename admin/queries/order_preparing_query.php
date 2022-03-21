<?php
$orderPreparing = array();

$order_prep = mysqli_query($con, "SELECT order_id FROM tblorder WHERE  order_status = 2 ORDER BY `tblorder`.`order_date` DESC ");

while ($row = mysqli_fetch_array($order_prep)) {

    array_push($orderPreparing, $row['order_id']);

}
