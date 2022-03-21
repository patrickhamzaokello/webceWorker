<?php
$ordersDelievered = array();

$orders_del = mysqli_query($con, "SELECT order_id FROM tblorder WHERE  order_status = 3 ORDER BY `tblorder`.`order_date` DESC ");

while ($row = mysqli_fetch_array($orders_del)) {

    array_push($ordersDelievered, $row['order_id']);

}
