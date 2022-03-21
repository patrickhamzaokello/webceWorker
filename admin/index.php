<?php
// keep the same order
require("config.php");
$db = new Database();
$con = $db->getConnString();

require('session.php');

require('queries/statsquery.php');
require('queries/order_new_query.php');
require "queries/classes/Order.php";


?>

<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0" /> -->
  <link rel="icon" type="image/x-icon" href="pages/assets/z_favicon.png">

  <link rel="stylesheet" href="css/main.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <title>Zodongo Foods</title>
</head>

<body>
  <header>
    <nav>

      <div class="currentpage">
        <p>
          <span><a href="index">Admin /</a></span>
          <a href="index"><?= $login_session ?></a>
        </p>
      </div>

      <div class="menu">
        <div class="menuitem">
          <a href="index">Zodongo Foods Admin Panel</a>
        </div>
      </div>

      <a href="logout.php">
        <div class="useraccount">Exit</div>
      </a></div>
    </nav>
  </header>
  <main>
    <div class="sidepanel">
      <div class="about">
        <div class="title">
          <img src="pages/assets/zodongologo.png" alt="">
        </div>
      </div>
      <div class="sidemenu">
        <a href="index" class="menu active">
          <p>Dashboard</p>
        </a>
        <a href="pages/allorders" class="menu">
          <p>All Orders</p>
        </a>
        <a href="pages/menuitems" class="menu">
          <p>Menu</p>
        </a>
        <a href="pages/categories" class="menu">
          <p>Categories</p>
        </a>
        <a href="pages/banners" class="menu">
          <p>Banners</p>
        </a>
      </div>
    </div>
    <div class="mainpanel">
      <div class="sectionheading">
        <h3 class="sectionlable">Statistics</h3>
        <h6 class="sectionlable">All Major statistics</h6>
      </div>
      <div class="statistics">
        <div class="card" style="background:#62ff8b">
          <div class="illustration">
            <img src="images/fontisto_shopping-basket.svg" alt="" />
          </div>
          <div class="stats">
            <p class="label">New Orders</p>
            <p class="number"><?= $totalActiveOrders_stat  ?></p>
          </div>
        </div>

        <div class="card">
          <div class="illustration">
            <img src="images/bxs_food-menu.svg" alt="" />
          </div>
          <div class="stats">
            <p class="label">Menu</p>
            <p class="number"><?= $totalMenuActivestat ?></p>
          </div>

        </div>
        <div class="card">
          <div class="illustration">
            <img src="images/bx_category.svg" alt="" />
          </div>
          <div class="stats">
            <p class="label">Categories</p>
            <p class="number"><?= $totalMenuType_stat ?></p>
          </div>

        </div>
        <div class="card">
          <div class="illustration">
            <img src="images/carbon_user-multiple.svg" alt="" />
          </div>
          <div class="stats">
            <p class="label">Users</p>
            <p class="number"><?= $total_customers_stat ?></p>
          </div>

        </div>
      </div>
      <div class="sectionheading">
        <h3 class="sectionlable">New Orders</h3>
        <h6 class="sectionlable">All New Orders</h6>
      </div>

      <div class="elements">

        <div class="activities">

          <?php if ($orderNew) : ?>

            <div class="childrencontainer">


              <?php
              foreach ($orderNew as $row) :
              ?>

                <?php
                $order = new Order($con, $row);
                ?>

                <div class="product-card">
                  <h4 class="orderID" style="display: none;"><?= $order->getOrder_id() ?></h4>

                  <p class="artistlable">Order No <span class="ordervalue"> ZD416F<?= $order->getOrder_id()  ?> </span></p>
                  <p class="artistlable">Date Added <span class="ordervalue"><?= $order->getOrder_date()  ?> </span></p>
                  <div class="addresslayout">
                    <p class="artistlable">Address <span class="ordervalue"><?= $order->getOrder_address()[0]  ?> </span></p>
                    <p class="artistlable">Contact <span class="ordervalue"><?= $order->getOrder_address()[1]  ?> </span></p>

                  </div>
                  <p class="artistlable">Tag <span class="ordervalue"><?= $order->getProcessed_by()  ?> </span> <span class="artistlable">Status <span class="ordervalue smalltag"><?= $order->getOrder_status()  ?></span> </span></p>
                  <p class="artistlable">Total Amount (UGX) <span class="ordervalue"><?= number_format($order->getTotal_amount())  ?> </span></p>


                  <input type="hidden" name="artistid" value="<?= $order->getOrder_id() ?>">

                  <div class="product-card__actions">
                    <a href="pages/order_detail.php?id=<?= $order->getOrder_id() ?>" class="btn btn-primary my-2  sponsorbutton">View Details</a>
                  </div>
                </div>

              <?php endforeach ?>

            </div>


          <?php else :  ?>
            No Orders Left
          <?php endif ?>



        </div>

      </div>
    </div>
  </main>





</body>


</html>