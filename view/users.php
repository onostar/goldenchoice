<?php
date_default_timezone_set("Africa/Lagos");
    session_start();
    include "cache_control.php";
    include "../classes/dbh.php";
    include "../classes/select.php";

    if(isset($_SESSION['user'])){
        $username = $_SESSION['user'];
        // instantiate classes
        $fetch_user = new selects();
        $users = $fetch_user->fetch_details_cond('users', 'username', $username);
        foreach($users as $user){
            $fullname = $user->full_name;
            $role = $user->user_role;
            $user_id = $user->user_id;
            $store_id = $user->store;
        }
        $_SESSION['user_id'] = $user_id;
        $_SESSION['role'] = $role;

        /* get company */
        $fetch_comp = new selects();
        $comps = $fetch_comp->fetch_details('companies');
        foreach($comps as $com){
            $company = $com->company;
            $comp_id = $com->company_id;
            $reg_date = $com->date_created;
            $logo = $com->logo;
        }
        $_SESSION['company_id'] = $comp_id;
        $_SESSION['company'] = $company;
        $_SESSION['company_logo'] = $logo;

    
        /* get store */
        $get_store = new selects();
        $strs = $get_store->fetch_details_cond('stores', 'store_id', $store_id);
        foreach($strs as $str){
            $store = $str->store;
            $store_address = $str->store_address;
            $phone = $str->phone_number;
        }
        $_SESSION['store_id'] = $store_id;
        $_SESSION['store'] = $store;
        $_SESSION['address'] = $store_address;
        $_SESSION['phone'] = $phone;
        function greeting($staff_name){
            $hour = date('H'); // Get the current hour in 24-hour format (00 to 23)
            if ($hour >= 0 && $hour < 12) {
                return "Good morning! <span style='font-weight:bold'>$staff_name</span>";
            } elseif ($hour >= 12 && $hour < 18) {
                return "Good afternoon! <span style='font-weight:bold'>$staff_name</span>";
            } else {
                return "Good evening! <span style='font-weight:bold'>$staff_name</span>";
            }
        }
        //get customer info
        $cus = $fetch_comp->fetch_details_cond('customers', 'user_id', $user_id);
        if(is_array($cus)){
            foreach($cus as $cli){
                $customer_id = $cli->customer_id;
            }
            $_SESSION['client_id'] = $customer_id;
        }
    
        
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="keywords" content="microfinance software, loan management system, microfinance web app, client onboarding platform, wallet management, microloan software, digital lending solution, accounting-based loan system, microfinance dashboard, financial tracking tool, Laravel microfinance system, online loan disbursement software Dorthpro microfinance">
    <meta name="description" content="A powerful microfinance web application designed for seamless loan management, client onboarding, wallet tracking, and real-time financial reporting. Built with an accounting model for transparency and growth.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory & Loan Management System</title>
    <link rel="icon" type="image/png" size="32x32" href="../images/icon.png">
    <link rel="stylesheet" href="../fontawesome-free-6.0.0-web/css/all.css">
    <link rel="stylesheet" href="../fontawesome-free-6.0.0-web/css/all.min.css">
    <link rel="stylesheet" href="../fontawesome-free-5.15.1-web/css/all.min.css">
    <link rel="stylesheet" href="../style.css?v=<?php echo APP_VERSION?>">
    <link rel="stylesheet" href="../select2.min.css">
</head>
<body>
    <!-- show package soon to expire -->
    <?php
            //get date to shut down
            $reg_date = $reg_date;
            $expiration = date("Y-m-d", strtotime("+1 year", strtotime($reg_date)));
            $current_date = date("Y-m-d");
            $interval = abs(strtotime($expiration) - strtotime($current_date));
            $days = $interval/86400;
           
            if($days < 30){
        ?>
    <div class="about_expire">
        
        <marquee behavior="smooth" direction="left">
            <?php echo "This software will expire in $days day(s), kindly contact your service provider to renew your package"?>
        </marquee>
    </div>
    <?php }
        
    ?>
    <main>
        <header>
            <div class="menu_icon" id="menu_icon">
                <a href="javascript:void(0)"><i class="fas fa-bars"></i></a>
            </div>
            <h1 class="logo for_mobile">
                <a href="users.php" title="Home">
                    <img src="../images/logo.png" alt="Logo" class="img-fluid">
                </a>
            </h1>
            <h2 style="margin-left:50px!important"><?php echo $company?></h2>
            <!-- <div class="other_menu">
                <a href="#" title="Our Gallery"><?php echo ucwords($role);?></a>
            </div> -->
            <a href="#" title="current store" class="other_menu"><?php echo ucwords($store);?></a>

            <div class="login">
                
                <button id="loginDiv"><i class="far fa-user"></i> <?php echo ucwords($fullname);?> <i class="fas fa-chevron-down"></i><br><p><?php echo ucwords($role);?></p></button>
                
                <div class="login_option">
                    <div>
                        <a class="password_link page_navs" href="javascript:void(0)" data-page="update_password" onclick="showPage('update_password.php')">Change password <i class="fas fa-key"></i></a>
                        <button id="loginBtn"><a href="../controller/logout.php">Log out <i class="fas fa-power-off"></i></a></button>
                    </div>
                </div>
            </div>
            
        </header>
        <div class="admin_main">
            
            <!-- side menu -->
            <?php include "side_menu.php"?>
            <!-- main contents -->
            <section id="contents">
                <!-- header -->
                
                <!-- quick links -->
                <div id="quickLinks">
                    <div class="quick_links">
                        <?php if($role == "Admin" || $role == "Accountant" || $role == "Loan Officer"){?>
                        <div class="links page_navs" onclick="showPage('wholesale.php')" title="Make a sale">
                            <i class="fas fa-pen-alt"></i>
                            <!-- <p>Direct sales</p> -->
                        </div>
                        <!-- <div class="links page_navs" onclick="showPage('loan_repayment.php')" title="post customer payment">
                            <i class="fas fa-hand-holding-dollar" style="color:var(--otherColor)"></i>
                            <p>Direct sales</p>
                        </div> -->
                        <?php }
                        if($role == "Admin" || $role == "Accountant"){?>
                        <div class="links page_navs" onclick="showPage('pending_applications.php')" title="Pending Applications">
                            <i class="fas fa-download" style="color:green"></i>
                            <p>
                                <?php
                                    $app = $fetch_comp->fetch_count_cond('loan_applications', 'loan_status', 0);
                                    echo $app;
                                ?>
                            </p>
                        </div>
                        <div class="links page_navs" onclick="showPage('pending_disbursement.php')" title="Loans awaiting disbursement">
                            <i class="fas fa-piggy-bank" style="color:brown"></i>
                            <p style="color:brown">
                                <?php
                                    $disburse = $fetch_comp->fetch_count_cond('loan_applications', 'loan_status', 1);
                                    echo $disburse;
                                ?>
                            </p>
                        </div>
                       <!--  <div class="links page_navs" onclick="showPage('active_loans.php')" title="Active Loans">
                            <i class="fas fa-chart-line"></i>
                            <p>
                                <?php
                                    $active = $fetch_comp->fetch_count_cond('loan_applications', 'loan_status', 2);
                                    echo $active;
                                
                                ?>
                            </p>
                        </div> -->
                        <div class="links page_navs" onclick="showPage('reached_reorder.php')" title="Reached reorder level">
                            <i class="fas fa-sort-amount-down"></i>
                            <p>
                                <?php
                                    $get_level = new selects();
                                    $levels = $get_level->fetch_count_reorderlevel( $store_id);
                                    echo $levels;
                                ?>
                            </p>
                        </div>
                        <div class="links page_navs" onclick="showPage('out_of_stock.php')" title="Out of stock">
                            <i class="fas fa-drum" style="color:red"></i>
                            <p style="color:red">
                                <?php
                                    $out_stock = new selects();
                                    $stock = $out_stock->fetch_out_of_stock($store_id);
                                    echo $stock;
                                ?>
                            </p>
                        </div>
                        <?php }else{?>
                        <div class="links page_navs" id="notifs" onclick="showPage('notifications.php')" title="Notifications">
                            <i class="fas fa-bell" style="color:var(--tertiaryColor)"></i>
                            <p style="color:red">
                                <?php
                                    $get_nots = new selects();
                                    $nots = $get_nots->fetch_count_2cond('notifications', 'not_status', 0, 'client', $customer_id);
                                    echo $nots;
                                ?>
                            </p>
                        </div>
                        <div class="greetings">
                            <p>
                                <?php
                                    echo greeting($fullname);
                                ?>
                            </p>
                        </div>
                        <?php }?>
                    </div>
                    <?php
                        if($role == "Admin" || $role == "Accountant"){
                    ?>
                    <div class="change_dashboard" style="display:none">
                        <!-- check other stores dashboard -->
                        <!-- <form method="POST"> -->
                        <section>
                            <label>Change Location</label><br>
                            <select name="store" id="store" required onchange="changeStore(this.value, <?php echo $user_id?>)">
                                <option value="<?php echo $store_id?>"><?php echo $store?></option>
                                <!-- get stores -->
                                <?php
                                    $get_store = new selects();
                                    $strs = $get_store->fetch_details_negCond1('stores', 'store_id', $store_id);
                                    foreach($strs as $str){
                                ?>
                                <option value="<?php echo $str->store_id?>"><?php echo $str->store?></option>
                                <?php }?>
                            </select>
                        </section>
                    </div>
                    <?php }?>
                </div>

                <div class="contents">

                    <?php
                        if(isset($_SESSION['success'])){
                            echo "<div class='success'>".
                                $_SESSION['success'].
                            "</div>";
                            unset($_SESSION['success']);
                        }
                    ?>
                    <?php
                        if(isset($_SESSION['error'])){
                            echo "<div class='error'>".
                                $_SESSION['error'].
                            "</div>";
                            unset($_SESSION['error']);
                        }
                    ?>
                    <!-- dashboard -->
                    <?php include "dashboard.php"?>
                </div>
            </section>
        </div>
    </main>
    
    <script src="../jquery.js"></script>
    <script src="../jquery.table2excel.js"></script>
    <script src="../select2.min.js"></script>
    <script src="../Chart.min.js"></script> 
    <script src="../script.js?v=<?php echo APP_VERSION?>"></script>
    <script src="https://dropin.vpay.africa/dropin/v1/initialise.js"></script>
    <script>
        
            setTimeout(function(){
                $(".success").hide();
            }, 4000);
            setTimeout(function(){
                $(".error").hide();
            }, 4000);

              var ctx = document.getElementById("chartjs_bar2").getContext('2d');
            // Function to generate random colors
            function generateColors(numColors) {
                var colors = [];
                for (var i = 0; i < numColors; i++) {
                    // Generate a random color in RGB format
                    var randomColor = 'rgb(' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ')';
                    colors.push(randomColor);
                }
                return colors;
            }

            // Get the number of months (or data points)
            var numMonths = <?php echo count($month); ?>; // Assuming $month is an array of months

            // Generate an array of colors based on the number of months
            var backgroundColors = generateColors(numMonths);

            var myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: <?php echo json_encode($month); ?>,
                    datasets: [{
                        label: 'Revenue',
                        backgroundColor: backgroundColors, // Use the dynamic color array
                        data: <?php echo json_encode($revenue); ?>,
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                color: 'white', // Font color
                                font: {
                                    family: 'Circular Std Book',
                                    size: 14,
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: 'white' // X-axis label color
                            }
                        },
                        y: {
                            ticks: {
                                color: 'white' // Y-axis label color
                            }
                        }
                    }
                }
            }); 
    </script>
</body>
</html>


<?php
    }else{
        header("Location: ../index.php");
    }

?>