<?php
$ordersDelievered = array();

$orders_del = mysqli_query($con, "SELECT id FROM  appointments WHERE status = 0 ORDER BY `appointments`.`date-created` DESC ");

while ($row = mysqli_fetch_array($orders_del)) {

    array_push($ordersDelievered, $row['id']);

}
