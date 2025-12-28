<?php

    if(isset($_GET['deposit_id'])){
        $deposit = $_GET['deposit_id'];
        $customer = $_GET['customer'];
        
        // instantiate class
        include "../classes/dbh.php";
        include "../classes/select.php";
        include "../classes/update.php";
        include "../classes/delete.php";

        //update wallet balance
        //get deposit amount
        $get_deposit = new selects();
        $deps = $get_deposit->fetch_details_cond('deposits', 'deposit_id', $deposit);
        foreach($deps as $dep){
            $amount = $dep->amount;
            $trx_number = $dep->trx_number;
        }   
         //get customer details
         $get_balance = new selects();
         $bals = $get_balance->fetch_details_cond('customers', 'customer_id', $customer);
         foreach($bals as $bal){
             $old_balance = $bal->wallet_balance;
             $old_debt = $bal->amount_due;
             $acn = $bal->acn;
         };
         
        $new_balance = $old_balance - $amount;

        $update_wallet = new Update_table();
        $update_wallet->update('customers', 'wallet_balance', 'customer_id', $new_balance, $customer);
        if($update_wallet){
            //delete deposit
            $delete_deposit = new deletes();
            $delete_deposit->delete_item('deposits', 'deposit_id', $deposit);

            //delete from transactions and cash flow
            $delete_deposit->delete_item('transactions', 'trx_number', $trx_number);
            $delete_deposit->delete_item('cash_flows', 'trx_number', $trx_number);

    ?>
        
<?php
    echo "<div class='success'><p>Deposit reversed successfully! <i class='fas fa-thumbs-up'></i></p></div>";
        }
    
}