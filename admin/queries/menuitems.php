<?php
$menuItemsIds = array();

$menuitems_sql = mysqli_query($con, "SELECT menu_id FROM tblmenu  ORDER BY `tblmenu`.`created` DESC ");

while ($row = mysqli_fetch_array($menuitems_sql)) {

    array_push($menuItemsIds, $row['menu_id']);

}
