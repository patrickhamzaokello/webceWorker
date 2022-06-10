<?php
$orderPreparing = array();

$order_prep = mysqli_query($con, "SELECT id FROM  appointments WHERE status = 0 ORDER BY `appointments`.`date-created` DESC ");

while ($row = mysqli_fetch_array($order_prep)) {

    array_push($orderPreparing, $row['id']);

}
