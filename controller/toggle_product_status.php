<?php
    session_start();
    if(isset($_GET['product'])){
        $id = $_GET['product'];
    }
    //instantiate class
    
    include "../classes/dbh.php";
    include "../classes/select.php";
    include "../classes/update.php";
    //get notification details
    $get_details = new selects();
    $details = $get_details->fetch_details_cond('loan_products', 'product_id', $id);
    if(is_array($details)){
        foreach($details as $detail){
            $status = $detail->product_status;
        }
    }
    //check status and update
    $update = new Update_table();
    if($status == 0){
        //update other notifications to 1
        $update->update('loan_products', 'product_status', 'product_id', 1, $id);
    }else{
        //update current products to 0
        $update->update('loan_products', 'product_status', 'product_id', 0, $id);

    }
   if($update){
        if($status == 0){
           echo "<div class='success'><p>Loan Product deactivated successfully! <i class='fas fa-thumbs-up'></i></p></div>";
            // echo "<p style='background:green; text-align:center;color:#fff; padding:10px; font-size:.9rem'>Notification activated successfully!</p>";
        }else{
            echo "<div class='success'><p>Loan Product activated successfully! <i class='fas fa-thumbs-down'></i></p></div>";
            // echo "<p style='background:green; text-align:center;color:#fff; padding:10px; font-size:.9rem'>Notification deactivated successfully!</p>";
        }
    }