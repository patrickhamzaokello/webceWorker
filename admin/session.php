<?php

if (!isset($_SESSION['login_user'])) {
    header("Location: login");
    exit;
} else {
    $user_check = $_SESSION['login_user'];

    $ses_sql = mysqli_query($con, "select customer_username from tblcustomer where customer_email = '$user_check' ");

    $row = mysqli_fetch_array($ses_sql, MYSQLI_ASSOC);

    if ($row) {
        $login_session = $row['customer_username'];
    } else {
        $login_session = "Null User";
    }
}
