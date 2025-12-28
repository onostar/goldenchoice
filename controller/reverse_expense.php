<?php

    if(isset($_GET['expense_id'])){
        $expense = $_GET['expense_id'];
        // $customer = $_GET['customer'];
        
        // instantiate class
        include "../classes/dbh.php";
        include "../classes/delete.php";
        include "../classes/select.php";
        //get expense transaction number
        $get_exp = new selects();
        $exps = $get_exp->fetch_details_group('expenses', 'trx_number', 'expense_id', $expense);
        $trx_number = $exps->trx_number;

        //update wallet balance
        
        
            //delete reversal
            $delete_deposit = new deletes();
            $delete_deposit->delete_item('expenses', 'expense_id', $expense);

            //delete from transactions and cash flow
            $delete_deposit->delete_item('transactions', 'trx_number', $trx_number);
            $delete_deposit->delete_item('cash_flows', 'trx_number', $trx_number);
    ?>
        
<?php
    echo "<div class='success'><p>Expense reversed successfully! <i class='fas fa-thumbs-up'></i></p></div>";
        }
    
