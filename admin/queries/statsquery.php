<?php
//get number of $total_newCases_sql
$total_newCases_sql = mysqli_query($con, "SELECT COUNT(*) as newCases from cases where status = 0");
$row = mysqli_fetch_array($total_newCases_sql);
$total_newCases = $row['newCases'];

//get number of $approvedCases_sql
$approvedCases_sql = mysqli_query($con, "SELECT COUNT(*) as approvedCases from cases where status = 1");
$row = mysqli_fetch_array($approvedCases_sql);
$total_approvedCases = $row['approvedCases'];

//get number of $handledCases_sql
$handledCases_sql = mysqli_query($con, "SELECT COUNT(*) as handledCases from cases where status = 2");
$row = mysqli_fetch_array($handledCases_sql);
$total_handledCases = $row['handledCases'];

//get number of $total_users_sql
$total_users_sql = mysqli_query($con, "SELECT COUNT(*) as total_users FROM tblcustomer WHERE userRole = 1 ");
$row = mysqli_fetch_array($total_users_sql);
$total_user_stat = $row['total_users'];

//get number of $total_new_appointment_sql
$total_new_appointment_sql = mysqli_query($con, "SELECT COUNT(*) as total_new_appointment FROM  appointments WHERE status = 0");
$row = mysqli_fetch_array($total_new_appointment_sql);
$total_new_appointment_stat = $row['total_new_appointment'];

//get number of $total_approved_appointment_sql
$total_approved_appointment_sql = mysqli_query($con, "SELECT COUNT(*) as total_approved_appointment FROM appointments WHERE status = 1");
$row = mysqli_fetch_array($total_approved_appointment_sql);
$total_approved_appointment_stat = $row['total_approved_appointment'];


