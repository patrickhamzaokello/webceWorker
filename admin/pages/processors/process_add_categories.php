<?php
require "../../config.php";

$db = new Database();
$con = $db->getConnString();

$errors = [];
$data = [];

$target_dir  = '../assets/categories/';
$db_target_dir  = 'assets/categories/';

if (isset($_POST['order_action'])) {

  $order_action = $_POST['order_action'];

  if ($order_action == 1) {
    if (isset($_POST['banner_name']) && isset($_POST['banner_number'])) {

      $name = $_POST['banner_name'];
      $banner_number = $_POST['banner_number'];


      // generating image name
      $formatedname = strip_tags($name);
      $formatedname = str_replace(" ", "_", $formatedname);

      $temp = explode(".", $_FILES["inputfile"]["name"]);

      // setting image new file name
      $postfix = '_' . date('YmdHis') . '_' . str_pad(rand(1, 10000), 5, '0', STR_PAD_LEFT);
      $newfilename = stripslashes($formatedname . '_category') . $postfix . '.' . end($temp);

      $targetPath = $target_dir . basename($newfilename);
      $db_targetPath = $db_target_dir . basename($newfilename);

      if (move_uploaded_file($_FILES['inputfile']['tmp_name'], $targetPath)) {
        $query = mysqli_query($con, "INSERT INTO `tblmenutype` (`name`, `description`, `imageCover`) VALUES('$name','$banner_number','$db_targetPath')");

        $data['success'] = true;
        $data['message'] = 'Category Added!';
      } else {
        $data['success'] = false;
        $data['message'] = 'Category not Added';
      }
    } else {
      $data['success'] = false;
      $data['message'] = 'Category not Added';
    }
  } elseif ($order_action == 2) {

    // if update btn is click
    if (isset($_POST['banner_id']) && isset($_POST['banner_name']) && isset($_POST['banner_number'])) {

      $name = $_POST['banner_name'];
      $banner_number = $_POST['banner_number'];
      $banner_id = $_POST['banner_id'];

      $banneritems_sql = mysqli_query($con, "SELECT imageCover FROM tblmenutype WHERE  `id` = $banner_id LIMIT 1");
      $row = mysqli_fetch_array($banneritems_sql);
      $b_image_path = $row['imageCover'];
      $whole_image_path = "../" . $b_image_path;

      // Use unlink() function to delete a file 
      if (!unlink($whole_image_path)) {
        $data['success'] = false;
        $data['message'] = 'Image can not be deleted due to an error';
      } else {

        // generating image name
        $formatedname = strip_tags($name);
        $formatedname = str_replace(" ", "_", $formatedname);

        $temp = explode(".", $_FILES["inputfile"]["name"]);
        $date = date('YmdHis');


        // setting image new file name
        $postfix = '_' . $date . '_' . str_pad(rand(1, 10000), 5, '0', STR_PAD_LEFT);
        $newfilename = stripslashes($formatedname . '_banner') . $postfix . '.' . end($temp);

        $targetPath = $target_dir . basename($newfilename);
        $db_targetPath = $db_target_dir . basename($newfilename);


        if (move_uploaded_file($_FILES['inputfile']['tmp_name'], $targetPath)) {
          $query = mysqli_query($con,"UPDATE `tblmenutype` SET `name`='$name', `description`='$banner_number',`imageCover`='$db_targetPath', `modified`='$date' WHERE  `id` = $banner_id ");

          $data['success'] = true;
          $data['message'] = 'Category Updated!';
        } else {
          $data['success'] = false;
          $data['message'] = 'Category not Updated';
        }
      }
    } else {
      $data['success'] = false;
      $data['message'] = 'Category not Updated';
    }
  } elseif ($order_action == 3) {

    //delete btn clicked

    if (isset($_POST['banner_id'])) {

      $banner_id = $_POST['banner_id'];

      $banneritems_sql = mysqli_query($con, "SELECT imageCover FROM tblmenutype  WHERE  `id` = $banner_id LIMIT 1");
      $row = mysqli_fetch_array($banneritems_sql);
      $b_image_path = $row['imageCover'];
      $whole_image_path = "../" . $b_image_path;

      // Use unlink() function to delete a file 
      if (!unlink($whole_image_path)) {
        $data['success'] = false;
        $data['message'] = 'Image can not be deleted due to an error';
      } else {
        $delete_order_sql = "DELETE FROM `tblmenutype` WHERE  `id` = $banner_id";

        mysqli_query($con, $delete_order_sql);

        $affected_rows = mysqli_affected_rows($con);

        if ($affected_rows >= 1) {
          $data['success'] = true;
          $data['message'] = $affected_rows . ' Category Deleted! ';
        } else if ($affected_rows <= 0) {
          $data['success'] = false;
          $data['message'] = 'Category with ID ' . $childname . ' Not Deleted';
        }
      }
    } else {
      $data['success'] = false;
      $data['message'] = 'Category ID not Passed';
    }
  }
} else {
  $data['success'] = false;
  $data['message'] = 'Undetermined Function';
}


echo json_encode($data);


//getting current page url
function pathUrl($dir = __DIR__)
{

  $root = "";
  $dir = str_replace('\\', '/', realpath($dir));

  //HTTPS or HTTP
  $root .= !empty($_SERVER['HTTPS']) ? 'https' : 'http';

  //HOST
  $root .= '://' . $_SERVER['HTTP_HOST'];

  //ALIAS
  if (!empty($_SERVER['CONTEXT_PREFIX'])) {
    $root .= $_SERVER['CONTEXT_PREFIX'];
    $root .= substr($dir, strlen($_SERVER['CONTEXT_DOCUMENT_ROOT']));
  } else {
    $root .= substr($dir, strlen($_SERVER['DOCUMENT_ROOT']));
  }

  $root .= '/';

  return $root;
}
