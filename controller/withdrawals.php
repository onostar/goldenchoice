<?php
    date_default_timezone_set("Africa/Lagos");
    $user = htmlspecialchars(stripslashes($_POST['posted']));
    $receipt = htmlspecialchars(stripslashes($_POST['invoice']));
    $customer = htmlspecialchars(stripslashes($_POST['customer']));
    $store = htmlspecialchars(stripslashes($_POST['store']));
    $type = htmlspecialchars(stripslashes($_POST['savings_type']));
    $amount = htmlspecialchars(stripslashes(($_POST['amount'])));
    if($type == "Normal Savings"){
        $trans_type = "Savings Withdrawal";
    }else{
        $trans_type = "Thrift Withdrawal";
    }
    
    $date = date("Y-m-d H:i:s");
     //generate transaction number
    //get current date
    $todays_date = date("dmyhis");
    $ran_num ="";
    for($i = 0; $i < 3; $i++){
        $random_num = random_int(0, 9);
        $ran_num .= $random_num;
    }
    $trx_num = "TR".$ran_num.$todays_date;
    $data = array(
        'posted_by' => $user,
        'customer' => $customer,
        'savings_type' => $type,
        'amount' => $amount,
        'invoice' => $receipt,
        'store' => $store,
        'post_date' => $date,
        'trx_number' => $trx_num
    );
    
    // instantiate class
    include "../classes/dbh.php";
    include "../classes/select.php";
    include "../classes/inserts.php";
    include "../classes/update.php";
    
    //check if there was a withdrawal request not done
    $get_details = new selects();
    $check = $get_details->fetch_count_2cond('withdrawals', 'customer', $customer, 'withdrawal_status', 0);
    if($check > 0){
        echo "<script>alert('Customer currently has a pending withdrawal request. Kindly waitfor appoal before requesting again!')</script>";
        return;
    }else{
    
    //post withdrawals
    $add_data = new add_data('withdrawals', $data);
    $add_data->create_data();
    if($add_data){
       
       
?>
    <!-- <div id="printBtn">
        <button onclick="printDepositReceipt('<?php echo $receipt?>')">Print Receipt <i class="fas fa-print"></i></button>
    </div> -->
<?php

        echo "<div class='success'><p>Withdrawal request posted successfully!</p></div>";
    }
}