<?php

    if(isset($_GET['trx_number'])){
        $trx_number = $_GET['trx_number'];
        // $account = $_GET['account'];
       
        // instantiate class
        include "../classes/dbh.php";
        include "../classes/delete.php";
        include "../classes/select.php";
        include "../classes/update.php";
        
        //get accounts
        /* $get_accounts = new selects();
        $details = $get_accounts->fetch_details_cond('transactions', 'trx_number', $trx_number);
        if(gettype($details) == 'array'){
            foreach($details as $detail){
                $account = $detail->account;
                
                //get account details from ledger
                $get_ledger = new selects();
                $rows = $get_ledger->fetch_details_cond('ledgers', 'acn', $account);
                foreach($rows as $row){
                    $group = $row->account_group;
                    $sub_group = $row->sub_group;
                    $class = $row->class;
                }
                //check if its a vendor
                if($class == 7){
                    //get vendor details
                    $get_vendor = new selects();
                    $vens = $get_vendor->fetch_details_cond('vendors', 'account_no', $account);
                    foreach($vens as $ven){
                        $balance = $ven->balance;
                        $vendor = $ven->vendor_id;
                    }
                    //get details from purchase payment
                    $get_amount = new selects();
                    $amts = $get_amount->fetch_details_cond('purchase_payments', 'trx_number', $trx_number);
                    foreach($amts as $amt){
                        $amount_paid = $amt->amount_paid;
                        $amount_due = $amt->amount_due;
                        $mode = $amt->payment_mode;
                        $invoice = $amt->invoice;
                    }
                    if($mode == "Credit"){
                        $new_balance = $balance - $amount_due;
                        //update purchase status
                        $update_purchase = new Update_table();
                        $update_purchase->update2cond('purchases', 'purchase_status', 'vendor', 'invoice', 0, $vendor, $invoice);
                        //update balance
                        
                    }else{
                        
                        $new_balance = $balance + $amount_due;
                        

                    }
                        $update_balance = new Update_table();
                        $update_balance->update('vendors', 'balance', 'vendor_id', $new_balance, $vendor);
                }
            }
        } */
        //get all tables
        $get_tables = new selects();
        $tables = $get_tables->fetch_tables('jevi');
        foreach($tables as $table){
            //check for transaction number column exist in each table and delete it when thenumber is seen
            $check_column = new selects();
            $cols = $check_column->fetch_column($table->table_name, 'trx_number');
            if($cols){
                $delete_tx = new deletes();
                $delete_tx->delete_item($table->table_name, 'trx_number', $trx_number);
            }
            
        }
        
        
        echo "<div class='success'><p>Transaction reversed successfully! <i class='fas fa-thumbs-up'></i></p></div>";
    }
    ?>

    
    
