<?php
    date_default_timezone_set("Africa/Lagos");
    session_start();
    // $company = $_SESSION['company_id'];
    $product = strtoupper(htmlspecialchars(stripslashes($_POST['product'])));
    $minimum = ucwords(htmlspecialchars(stripslashes($_POST['minimum'])));
    $maximum = htmlspecialchars(stripslashes($_POST['maximum']));
    $interest = htmlspecialchars(stripslashes($_POST['interest']));
    $duration = htmlspecialchars(stripslashes($_POST['duration']));
    $description = ucwords(htmlspecialchars(stripslashes($_POST['description'])));
    $repayment = htmlspecialchars(stripslashes($_POST['repayment']));
    $processing = htmlspecialchars(stripslashes($_POST['processing']));
    $penalty = htmlspecialchars(stripslashes($_POST['penalty']));
    $collateral = htmlspecialchars(stripslashes($_POST['collateral']));
    $date = date("Y-m-d H:i:s");

    $data = array(
        'product' => $product,
        'minimum' => $minimum,
        'maximum' => $maximum,
        'interest' => $interest,
        'duration' => $duration,
        'description' => $description,
        'repayment' => $repayment,
        'processing' => $processing,
        'penalty' => $penalty,
        'collateral' => $collateral,
        'posted_by' => $_SESSION['user_id'],
        'post_date' => $date
    );
    // instantiate class
    include "../classes/dbh.php";
    include "../classes/select.php";
    include "../classes/inserts.php";

    //check if package have amount
    $check = new selects();
    $results = $check->fetch_count_cond('loan_products', 'product', $product);
    if($results > 0){
        echo "<p class='exist'Product already exists</p>";
    }else{
        //add new store
        $add_data = new add_data('loan_products', $data);
        $add_data->create_data();
        if($add_data){
            echo "<div class='success'><p>Product added successfully! <i class='fas fa-thumbs-up'></i></p></div>";
        }
    }