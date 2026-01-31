<?php
    session_start();
    date_default_timezone_set("Africa/Lagos");
    $user = htmlspecialchars(stripslashes($_POST['posted']));
    $withdrawal = htmlspecialchars(stripslashes($_POST['withdrawal']));
    $customer = htmlspecialchars(stripslashes($_POST['customer']));
    $mode = htmlspecialchars(stripslashes($_POST['payment_mode']));
    $bank = htmlspecialchars(stripslashes($_POST['bank']));
    $store = $_SESSION['store_id'];
    // instantiate class
    include "../classes/dbh.php";
    include "../classes/select.php";
    include "../classes/inserts.php";
    include "../classes/update.php";

    $get_details = new selects();
    $rows = $get_details->fetch_details_cond('withdrawals', 'withdrawal_id', $withdrawal);
    foreach($rows as $row){
        $amount = $row->amount;
        $type = $row->savings_type;
        $invoice = $row->invoice;
        $trx_num = $row->trx_number;
    }
    if($type == "Normal Savings"){
        $trans_type = "Savings Withdrawal";
    }else{
        $trans_type = "Thrift Withdrawal";
    }
    
    $date = date("Y-m-d H:i:s");
    $data = array(
        'approved_by' => $user,
        'mode' => $mode,
        'bank' => $bank,
        'approved_date' => $date,
        'withdrawal_status' => 1
    );
    //post withdrawals
    $add_data = new Update_table();
    $add_data->updateAny('withdrawals', $data, 'withdrawal_id', $withdrawal);
    if($add_data){
       //insert into customer trails
        $trail_data = array(
            'customer' => $customer,
            'store' => $store,
            'description' => $trans_type,
            'amount' => $amount,
            'posted_by' => $user,
            'trx_number' => $trx_num,
            'post_date' => $date
        );
        $add_trail = new add_data('customer_trail', $trail_data);
        $add_trail->create_data();
        //get customer details
        $bals = $get_details->fetch_details_cond('customers', 'customer_id', $customer);
        foreach($bals as $bal){
            $old_savings = $bal->wallet_balance;
            $old_thrift = $bal->thrift;
            $ledger = $bal->acn;
            // $old_debt = $bal->amount_due;
        };
        //get customer account type
        $typs = $get_details->fetch_details_cond('ledgers', 'acn', $ledger);
        foreach($typs as $typ){
            $ledger_type = $typ->account_group;
            $ledger_group = $typ->sub_group;
            $ledger_class = $typ->class;

        }
        //update all balances
        $update = new Update_table();
        if($type == "Normal Savings"){
            $new_savings = $old_savings - $amount;
            $update->update('customers', 'wallet_balance', 'customer_id', $new_savings, $customer);

        }else{
            $new_thrift = $old_thrift - $amount;
            $update->update('customers', 'thrift', 'customer_id', $new_thrift, $customer);
        }
       
?>
    <!-- <div id="printBtn">
        <button onclick="printDepositReceipt('<?php echo $receipt?>')">Print Receipt <i class="fas fa-print"></i></button>
    </div> -->
<?php

        echo "<div class='success'><p>Withdrawal request approved successfully! Customer Account updated <i class='fas fa-thumbs-up'></i></p></div>";
    }
