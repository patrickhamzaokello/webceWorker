<?php
// keep the same order
require("config.php");
$db = new Database();
$con = $db->getConnString();

require('session.php');

require('queries/statsquery.php');
require('queries/order_new_query.php');
require "queries/classes/User.php";
require "queries/classes/Cases.php";



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
  <title>Famlink</title>
</head>

<body>
  <header>
    <nav>

      <div class="currentpage">
        <p>
          <span><a href="index">Admin /</a></span>
          <a href="index"><?= $login_session = "PK";
                          $login_session ?></a>
        </p>
      </div>



      <a href="logout.php">
        <div class="useraccount">Logout</div>
      </a></div>
    </nav>
  </header>
  <main>
    <div class="sidepanel">
      <div class="about">
        <div class="title">
          <h1>Famlink</h1>
        </div>
      </div>
      <div class="sidemenu">
        <a href="index" class="menu active">
          <p>Dashboard</p>
        </a>
        <a href="pages/allorders" class="menu">
          <p>Appointments</p>
        </a>
        <a href="pages/menuitems" class="menu">
          <p>Cases</p>
        </a>
        <a href="pages/categories" class="menu">
          <p>Categories</p>
        </a>
        <a href="pages/banners" class="menu">
          <p>Users</p>
        </a>
      </div>
    </div>
    <div class="mainpanel">
      <div class="sectionheading">
        <h3 class="sectionlable">Statistics</h3>
        <h6 class="sectionlable">All Major statistics</h6>
      </div>
      <div class="statistics">
        <div class="card" style="background:#1845b8">
          <div class="illustration">
            <img src="images/fontisto_shopping-basket.svg" alt="" />
          </div>
          <div class="stats">
            <p class="label" style="color: #fff">New Cases</p>
            <p class="number" style="color: #fff"><?= $total_newCases  ?></p>
          </div>
        </div>

        <div class="card">
          <div class="illustration">
            <img src="images/bxs_food-menu.svg" alt="" />
          </div>
          <div class="stats">
            <p class="label">Appointments</p>
            <p class="number"><?= $total_new_appointment_stat ?></p>
          </div>

        </div>
        <div class="card">
          <div class="illustration">
            <img src="images/bx_category.svg" alt="" />
          </div>
          <div class="stats">
            <p class="label">Managed Cases</p>
            <p class="number"><?= $total_handledCases ?></p>
          </div>

        </div>
        <div class="card">
          <div class="illustration">
            <img src="images/carbon_user-multiple.svg" alt="" />
          </div>
          <div class="stats">
            <p class="label">Users</p>
            <p class="number"><?= $total_user_stat ?></p>
          </div>

        </div>
      </div>


      <div class="elements">

        <div class="activities">

          <div class="sectionheading">
            <h3 class="sectionlable">Cases</h3>
            <h6 class="sectionlable">All New Reported Cases</h6>
          </div>

          <?php if ($caseNew) : ?>

            <div class="childrencontainer">


              <?php
              foreach ($caseNew as $row) :
              ?>


                <?php
                $order = new Cases($con, $row);
                ?>

                <div class="product-card">

                  <div class="imagecontainer">
                    <img src="<?= $order->getPicture() ?>" alt="">
                    <div class="imgtext">
                      <h5 class="casetitle"><?= $order->getReportedbyUser() ?></h5>
                      <p class="case_info"><?= $order->getDatecreated() ?> <span class="categoryid"><?= $order->getCategoryId() ?></span><span class="case_location"> <?= $order->getLocation() ?> </span></p>
                    </div>
                  </div>

                  <div class="casedescription">
                    <h1><?= $order->getTitle() ?></h1>
                    <p><?= $order->getDescription() ?> </p>

                  </div>


                  <input type="hidden" name="artistid" value="<?= $order->getId() ?>">

                  <div class="product-card__actions">
                    <a href="pages/order_detail.php?id=<?= $order->getId() ?>" class="btn btn-primary my-2  sponsorbutton">View Details</a>
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