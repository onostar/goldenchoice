<?php
date_default_timezone_set("Africa/Lagos");
// session_start();
// instantiate class
include "../classes/dbh.php";
include "../classes/select.php";
include "../classes/update.php";
include "../classes/inserts.php";
    session_start();
    if(isset($_SESSION['user_id'])){
        $invoice = htmlspecialchars(stripslashes($_POST['invoice']));
        $trx_date = htmlspecialchars(stripslashes($_POST['trx_date']));
        $po_number = htmlspecialchars(stripslashes($_POST['po_number']));
        $due_days = htmlspecialchars(stripslashes($_POST['due_days']));
        $details = "New Customer invoice";
        $user = $_SESSION['user_id'];
        $date = date("Y-m-d H:i:s");
        $due_date = date("Y-m-d", strtotime("+$due_days day", strtotime($trx_date)));
        //get invoice amount
        $get_amount = new selects();
        $amounts = $get_amount->fetch_sum_single('invoices', 'total_amount', 'invoice', $invoice);
        foreach($amounts as $amount){
            $total_amount = $amount->total;

        }
        //generate transaction number
        //get current date
        $todays_date = date("dmyhis");
        $ran_num ="";
        for($i = 0; $i < 3; $i++){
            $random_num = random_int(0, 9);
            $ran_num .= $random_num;
        }
        $trx_num = "TR".$ran_num.$todays_date;
        //get customer from invoice
        $get_cust = new selects();
        $cust = $get_cust->fetch_details_group('invoices', 'customer', 'invoice', $invoice);
        $customer = $cust->customer;
        //get customer  wallet balance
        $get_wallet = new selects();
        $rows = $get_wallet->fetch_details_cond('customers', 'customer_id', $customer);
        foreach($rows as $row){
            $wallet = $row->wallet_balance;
            $customer_ledger = $row->acn;
        }
        //get customer leger type
        $get_cl = new selects();
        $cusl = $get_cl->fetch_details_cond('ledgers', 'acn', $customer_ledger);
        foreach($cusl as $cus){
            $customer_type = $cus->account_group;
            $sub_group = $cus->sub_group;
            $class = $cus->class;
        }

    //update all items with this invoice
    $update_invoice = new Update_table();
    $update_invoice->update_six('invoices', 'invoice_status', 1, 'trx_date', $trx_date, 'po_number', $po_number, 'trx_number', $trx_num, 'due_days', $due_days, 'due_date', $due_date, 'invoice', $invoice);
    /* //add funds to debt
    $new_debt = $wallet + intval(-($total_amount));
    $update_debt = new Update_table();
    $update_debt->update('customers', 'wallet_balance', 'customer_id', $new_debt, $customer); */

    //insert into transaction table
    //get income legder id
    $get_income = new selects();
    $incs = $get_income->fetch_details_cond('ledgers', 'ledger', 'GENERAL REVENUE');
    foreach($incs as $inc){
        $income_ledger = $inc->acn;
        $income_type = $inc->account_group;
        $income_group = $inc->sub_group;
        $income_class = $inc->class;
    }
    $debit_data = array(
        'account' => $customer_ledger,
        'account_type' => $customer_type,
        'sub_group' => $sub_group,
        'class' => $class,
        'details' => $details,
        'debit' => $total_amount,
        'post_date' => $date,
        'posted_by' => $user,
        'trx_number' => $trx_num,
        'trans_date' => $trx_date

    );
    $credit_data = array(
        'account' => $income_ledger,
        'account_type' => $income_type,
        'sub_group' => $income_group,
        'class' => $income_class,
        'details' => $details,
        'credit' => $total_amount,
        'post_date' => $date,
        'posted_by' => $user,
        'trx_number' => $trx_num,
        'trans_date' => $trx_date

    );
    //add debit
    $add_debit = new add_data('transactions', $debit_data);
    $add_debit->create_data();      
    //add credit
    $add_credit = new add_data('transactions', $credit_data);
    $add_credit->create_data();      
?>
<div id="printBtn">
    <button onclick="printInvoice('<?php echo $invoice?>')">Print Invoice <i class="fas fa-print"></i></button>
</div>
<!--  -->
   
<?php
    // echo "<script>window.print();</script>";
                    // }
                
    }else{
        header("Location: ../index.php");
    } 
?>