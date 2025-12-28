<?php
    session_start();    
    // if(isset($_POST['change_prize'])){
    $package = htmlspecialchars(stripslashes($_POST['item_id']));
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
        'collateral' => $collateral
    );
        // instantiate classes
        include "../classes/dbh.php";
        include "../classes/update.php";

       //update customer
       $update_data = new Update_table();
       $update_data->updateAny('loan_products', $data, 'product_id', $package);
        // echo $package;
        if($update_data){
             echo "<div class='success'><p>Product details updated successfully! <i class='fas fa-thumbs-up'></i></p></div>";
        }else{
            echo "<p style='background:red; color:#fff; padding:5px'>Failed to update package <i class='fas fa-thumbs-down'></i></p>";
        }
    // }