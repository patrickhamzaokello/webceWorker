<?php
require("../config.php");
$db = new Database();
$con = $db->getConnString();

$orderid = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : '0';

require('../session.php');
require('../queries/statsquery.php');
require("../queries/classes/User.php");
require("../queries/classes/Cases.php");


?>


<!DOCTYPE html>
<!-- Coding by CodingLab | www.codinglabweb.com -->
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="assets/z_favicon.png">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="../css/main.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>


    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    <title>Order Detail</title>

</head>

<body>
    <nav class="sidebar">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="assets/famlink.png" alt="">
                </span>

                <div class="text logo-text">
                    <span class="name">Famlink</span>
                    <span class="profession">CEWOCHR ADMIN</span>
                </div>
            </div>

            <i class='bx bx-chevron-right toggle'></i>
        </header>

        <div class="menu-bar">
            <div class="menu">

                <!-- <li class="search-box">
                    <i class='bx bx-search icon'></i>
                    <input type="text" placeholder="Search...">
                </li> -->

                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="../index">
                            <i class='bx bx-home-alt icon'></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="#">
                            <i class='bx bx-bar-chart-alt-2 icon'></i>
                            <span class="text nav-text">Revenue</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="#">
                            <i class='bx bx-bell icon'></i>
                            <span class="text nav-text">Notifications</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="#">
                            <i class='bx bx-pie-chart-alt icon'></i>
                            <span class="text nav-text">Analytics</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="#">
                            <i class='bx bx-heart icon'></i>
                            <span class="text nav-text">Likes</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="#">
                            <i class='bx bx-wallet icon'></i>
                            <span class="text nav-text">Wallets</span>
                        </a>
                    </li>

                </ul>
            </div>

            <div class="bottom-content">
                <li class="">
                    <a href="../logout.php">
                        <i class='bx bx-log-out icon'></i>
                        <span class="text nav-text">Logout</span>
                    </a>
                </li>

                <li class="mode">
                    <div class="sun-moon">
                        <i class='bx bx-moon icon moon'></i>
                        <i class='bx bx-sun icon sun'></i>
                    </div>
                    <span class="mode-text text">Dark mode</span>

                    <div class="toggle-switch">
                        <span class="switch"></span>
                    </div>
                </li>

            </div>
        </div>

    </nav>

    <section class="home">
        <div class="mainpanel">
            <div class="elements">
                <div class="activities">


                    <?php
                    $order = new Cases($con, $orderid);

                    if ($order->getId() != null) :
                    ?>






                        <div class="elements">


                            <div class="activities">

                                <div class="cartitemcontainer">


                                    <div class="cartItem">


                                        <div class="sectionheading">
                                            <h3 class="sectionlable">Case Report Details</h3>

                                        </div>


                                        <div class="orderheading">

                                            <div class="ordertimediv">
                                                <h6>Case ID</h6>
                                                <h5>FLCW-<?= $order->getId() ?></h5>
                                            </div>
                                            <div class="ordertimediv">
                                                <h6>Reported Time</h6>
                                                <h5><?= $order->getDatecreated() ?></h5>
                                            </div>

                                            <div class="ordertimediv">
                                                <h6>Case Status</h6>
                                                <h5><?= $order->getStatus() ?></h5>
                                            </div>
                                            <div class="ordertimediv">
                                                <h6>Case category</h6>
                                                <h5><?= $order->getCategoryId() ?></h5>
                                            </div>
                                            <div class="ordertimediv">
                                                <h6>Reporter</h6>
                                                <h5><?= $order->getReportedbyUser() ?></h5>
                                            </div>

                                        </div>



                                        <img src="<?= $order->getPicture() ?>" alt="">

                                        <div class="cartItemdetail">
                                            <div class="menutitle">Boy looking for mother and Father
                                            </div>
                                            <div class="menu_desc"><?= $order->getDescription() ?>
                                            </div>
                                        </div>

                                        <div class="cartdetailbutton">
                                            <div class="cancebutton_parent">
                                                <input class="order_id_input" type="hidden" name="orderID" value="<?= $order->getId() ?>">
                                                <input class="order_status_id" type="hidden" name="order_status_id" value="<?= $order->getStatusID() ?>">
                                                <button class="cancelbutton">Delete Case</button>
                                            </div>
                                            <div class="approvebutton_parent">
                                                <input class="order_id_input" type="hidden" name="orderID" value="<?= $order->getId() ?>">
                                                <input class="order_status_id" type="hidden" name="order_status_id" value="<?= $order->getStatusID() ?>">
                                                <button class="approvebutton">Approve Case</button>
                                            </div>

                                        </div>
                                    </div>

                                </div>

                            </div>


                        </div>


                        <div class="sponserdiv">
                            <div class="sponsorshipform">
                                <div class="sponsormessagediv">

                                </div>
                                <form id="approveform" action="" method="POST">

                                    <div class="form-group">
                                        <input id="childnameinput" type="hidden" name="childname" class="form-control" placeholder="order_id" disabled>
                                        <input id="order_status_id" type="hidden" name="order_status" class="form-control" placeholder="order_status" disabled>
                                    </div>

                                    <div class="approveorderform">
                                        <h1>Approve Order</h1>
                                        <p>All approved orders are accessed through the Order Page </p>
                                    </div>

                                    <div class="deleteorder" style="display: none;">
                                        <h1>Delete Order</h1>
                                        <p>This action can not be reversed when done! </p>
                                    </div>

                                    <div class="form-group">
                                        <input type="submit" value="Approve" style="width: 100% !important;" class="sponsorchildnowbtn">
                                    </div>
                                    <div class="form-group">
                                        <button type="reset" id="cancelbtn" style="background: #fff;border: 1px solid #000;padding: 10px 20px;width: 100%;color: #000; border-radius: 5px;" onclick="cancelsponsohip()">Cancel
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>

                        <!--        loader-->
                        <div class="loaderdiv">
                            <div class="loader-container">
                                <div class="dot dot-1"></div>
                                <div class="dot dot-2"></div>
                                <div class="dot dot-3"></div>
                                <div class="dot dot-4"></div>
                            </div>
                        </div>


                    <?php else : ?>
                        Order Detail Failed
                    <?php endif ?>

                </div>

            </div>
        </div>

    </section>

    <script>
        const body = document.querySelector('body'),
            sidebar = body.querySelector('nav'),
            toggle = body.querySelector(".toggle"),
            searchBtn = body.querySelector(".search-box"),
            modeSwitch = body.querySelector(".toggle-switch"),
            modeText = body.querySelector(".mode-text");


        toggle.addEventListener("click", () => {
            sidebar.classList.toggle("close");
        })

        searchBtn.addEventListener("click", () => {
            sidebar.classList.remove("close");
        })

        modeSwitch.addEventListener("click", () => {
            body.classList.toggle("dark");

            if (body.classList.contains("dark")) {
                modeText.innerText = "Light mode";
            } else {
                modeText.innerText = "Dark mode";

            }
        });
    </script>

    <script src="../js/process_order_detail.js"></script>

</body>

</html>