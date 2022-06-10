<?php
$appointmentNew = array();

$appointment_query_sql = mysqli_query($con, "SELECT id FROM  appointments WHERE status = 0 ORDER BY `appointments`.`date-created` DESC ");

while ($row = mysqli_fetch_array($appointment_query_sql)) {

    array_push($appointmentNew, $row['id']);

}
