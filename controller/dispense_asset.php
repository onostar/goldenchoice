<?php
    session_start();
    date_default_timezone_set("Africa/Lagos");
    $store = $_SESSION['store_id'];
    $date = date("Y-m-d H:i:s");
    $user = $_SESSION['user_id'];
    $loan = htmlspecialchars(stripslashes($_POST['loan']));
    $asset = htmlspecialchars(stripslashes($_POST['asset']));
    //generate receipt invoice
    //get current date
    $todays_date = date("dmyhi");
    $ran_num ="";
    for($i = 0; $i < 3; $i++){
        $random_num = random_int(0, 9);
        $ran_num .= $random_num;
    }
    $invoice = "GC".$store.$todays_date.$user.$ran_num;
    //get current date
    $todays = date("dmyhis");
    $tran_num ="";
    for($i = 0; $i < 3; $i++){
        $random_num = random_int(0, 9);
        $tran_num .= $random_num;
    }
    $trx_num = "TR".$ran_num.$todays;
    include "../classes/dbh.php";
    include "../classes/select.php";
    include "../classes/update.php";
    include "../classes/inserts.php";

    $get_details = new selects();
    //get loan details
    $rows = $get_details->fetch_details_cond('loan_applications', 'loan_id', $loan);
    foreach($rows as $row){
        $amount = $row->amount;
        $payable = $row->total_payable;
        $customer = $row->customer;
        
    }
    //customer details
    $amts = $get_details->fetch_details_cond('customers', 'customer_id', $customer);
    foreach($amts as $amt){
        $customer_ledger = $amt->acn;

    }
    
    //get customer leger type
    $cusl = $get_details->fetch_details_cond('ledgers', 'acn', $customer_ledger);
    foreach($cusl as $cus){
        $customer_type = $cus->account_group;
        $sub_group = $cus->sub_group;
        $class = $cus->class;
    }
    //get asset details
    $details = $get_details->fetch_details_cond('items', 'item_id', $asset);
    foreach($details as $detail){
        $item_name = $detail->item_name;
        $cost = $detail->cost_price;
        $old_price = $detail->sales_price;

    }
    $quantity = 1;
    $discount = $old_price - $payable;
    //check previous quantity;
    //get quantity from inventory
    $qtyss = $get_details->fetch_details_2cond('inventory', 'store', 'item', $store, $asset);
    if(is_array($qtyss)){
        foreach($qtyss as $qtys){
            $qty = $qtys->quantity;
        }
    }else{
        $qty = 0;
    }
    $sales_cost = $quantity * $cost;
    if($qty == 0){
        echo "<div class='success'><p style='background:brown'><span>$item_name</span> has zero quantity! Cannot proceed</p>";
        echo "<script>
            alert('$item_name has zero quantity! Cannot proceed');
        </script>";
        exit();
    }else{
        $update_invoice = new Update_table();
        //insert into sales order
        $data = array(
            'item' => $asset,
            'invoice' => $invoice,
            'quantity' => $quantity,
            'price' => $payable,
            'total_amount' => $payable,
            'posted_by' => $user,
            'cost' => $sales_cost,
            'store' => $store,
            'sales_type' => 'Retail',
            'customer' => $customer,
            'discount' => $discount,
            'post_date' => $date,
            'sales_status' => 2,
            'trx_number' => $trx_num
            // 'markup' => $markup
        );
        $sell_item = new add_data('sales', $data);
        $sell_item->create_data();

        //add to audit trail
        $audit_data = array(
            'item' => $asset,
            'transaction' => 'sales',
            'previous_qty' => $qty,
            'quantity' => $quantity,
            'posted_by' => $user,
            'store' => $store,
            'post_date' => $date
        );
        $insert_trail = new add_data('audit_trail', $audit_data);
        $insert_trail->create_data();
        //update inventory quantity;
        $update_invoice->update_inv_qty($quantity, $asset, $store);

        //insert into payment table
        $pay_data = array(
            'amount_due' => $payable,
            'amount_paid' => $payable,
            'discount' => $discount,
            'bank' => 0,
            'payment_mode' => 'Credit',
            'posted_by' => $user,
            'invoice' => $invoice,
            'store' => $store,
            'sales_type' => 'Retail',
            'customer' => $customer,
            'post_date' => $date,
            'trx_number' => $trx_num
        );
        $add_payment = new add_data('payments', $pay_data);
        $add_payment->create_data();

        //transactions
        //get income legder id
        $incs = $get_details->fetch_details_cond('ledgers', 'ledger', 'GENERAL REVENUE');
        foreach($incs as $inc){
            $income_ledger = $inc->acn;
            $income_type = $inc->account_group;
            $income_group = $inc->sub_group;
            $income_class = $inc->class;
        }
        //credit income ledger
        $income_data = array(
            'account' => $income_ledger,
            'account_type' => $income_type,
            'sub_group' => $income_group,
            'class' => $income_class,
            'details' => 'Sales of product',
            'credit' => $payable,
            'post_date' => $date,
            'posted_by' => $user,
            'trx_number' => $trx_num,
            'trans_date' => $date,
            'store' => $store
        );
        //add income credit
        $add_income_credit = new add_data('transactions', $income_data);
        $add_income_credit->create_data();
        /* cost of sales */
        $coss = $get_details->fetch_sum_single('sales', 'cost', 'invoice', $invoice);
        foreach($coss as $costs){
            $total_cost = $costs->total;
        }
        $cos_data = array(
            'posted_by' => $user,
            'trans_date' => $date,
            'store' => $store,
            'amount' => $total_cost,
            'details' => 'cost of sales',
            'post_date' => $date,
            'trx_number' => $trx_num
        );
        //post to cost of sales table
        $add_data = new add_data('cost_of_sales', $cos_data);
        $add_data->create_data();
        //get ledger account numbers and account type for cost of sales
        $exps = $get_details->fetch_details_cond('ledgers', 'ledger', 'COST OF SALES');
        foreach($exps as $exp){
            $cos_ledger = $exp->acn;
            $cos_type = $exp->account_group;
            $cos_group = $exp->sub_group;
            $cos_class = $exp->class;
        }
        //debit cost of goods sold
        $debit_cog = array(
            'account' => $cos_ledger,
            'account_type' => $cos_type,
            'sub_group' => $cos_group,
            'class' => $cos_class,
            'debit' => $total_cost,
            'details' => 'Cost of sales',
            'post_date' => $date,
            'posted_by' => $user,
            'trx_number' => $trx_num,
            'trans_date' => $date,
            'store' => $store

        );
            //add debit
        $add_cog_debit = new add_data('transactions', $debit_cog);
        $add_cog_debit->create_data();
        //get inventory ledger account number
        $cons = $get_details->fetch_details_cond('ledgers', 'ledger', 'INVENTORIES');
        foreach($cons as $con){
            $inv_ledger = $con->acn;
            $inv_type = $con->account_group;
            $inv_group = $con->sub_group;
            $inv_class = $con->class;
        }
        //credit inventory
        $credit_inv = array(
            'account' => $inv_ledger,
            'account_type' => $inv_type,
            'sub_group' => $inv_group,
            'class' => $inv_class,
            'credit' => $total_cost,
            'details' => 'Cost of sales',
            'post_date' => $date,
            'posted_by' => $user,
            'trx_number' => $trx_num,
            'trans_date' => $date,
            'store' => $store

        );
        //add credit inventory
        $add_credit_inv = new add_data('transactions', $credit_inv);
        $add_credit_inv->create_data();
        //debit customer account
        $customer_debit = array(
            'account' => $customer_ledger,
            'account_type' => $customer_type,
            'sub_group' => $sub_group,
            'class' => $class,
            'details' => 'Goods purchased',
            'debit' => $payable,
            'post_date' => $date,
            'posted_by' => $user,
            'trx_number' => $trx_num,
            'trans_date' => $date,
            'store' => $store
        );
        //add customer debit for credit bought
        $add_customer_debit = new add_data('transactions', $customer_debit);
        $add_customer_debit->create_data();

        //update asset status on loan aplications
        $update_invoice->update('loan_applications', 'asset_status', 'loan_id', 1, $loan);
        echo "<div class='success'><p ><span>$item_name</span> dispensed successfully <i class='fas fa-thumbs-up'></i></p>";
    }