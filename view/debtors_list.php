<?php
    session_start();
    $store = $_SESSION['store_id'];
    include "../classes/dbh.php";
    include "../classes/select.php";


?>
<div id="debtorsList" class="displays management" >
    
<div class="displays allResults new_data" id="revenue_report" style="width:60%!important; margin:0 20px!important;">
    <h2>Debtors List</h2>
    <hr>
    <div class="search">
        <input type="search" id="searchDebtors" placeholder="Enter keyword" onkeyup="searchData(this.value)">
        <a class="download_excel" href="javascript:void(0)" onclick="convertToExcel('data_table', 'Sales report')"title="Download to excel"><i class="fas fa-file-excel"></i></a>
    </div>
    <!-- <table id="data_table" class="searchTable">
        <thead>
            <tr style="background:var(--otherColor)">
                <td>S/N</td>
                <td>Customer</td>
                <td>Amount Due</td>
                <td></td>
                
            </tr>
        </thead>
        <tbody>
            <?php
                /* $n = 1;
                $get_users = new selects();
                $details = $get_users->fetch_details_lessthan('customers', 'wallet_balance', 0);
                if(gettype($details) === 'array'){
                foreach($details as $detail): */
            ?>
            <tr>
                <td style="text-align:center; color:red;"><?php echo $n?></td>
                <td>
                    <?php
                        
                        echo $detail->customer;
                    ?>
                </td>
                <td style="color:red">
                    <?php 
                       
                            echo "₦".number_format($detail->wallet_balance * -1, 2);
                        
                    ?>
                </td>
            
                <td>
                    <a style="color:#fff;background:var(--primaryColor); padding:5px; border-radius:5px" href="javascript:void(0)" title="View invoice details" onclick="showPage('debt_details.php?customer=<?php echo $detail->customer_id?>')">View <i class="fas fa-eye"></i></a>
                </td>
                
            </tr>
            <?php /* $n++; endforeach;} */?>
        </tbody>
    </table>
    
    <?php
        /* if(gettype($details) == "string"){
            echo "<p class='no_result'>'$details'</p>";
        } */

        // get sum
        /* $get_total = new selects();
        $amounts = $get_total->fetch_sum_singleless('customers', 'wallet_balance', 'wallet_balance', 0);
        foreach($amounts as $amount){
            echo "<p class='total_amount' style='color:green'>Total Due: ₦".number_format($amount->total * -1, 2)."</p>";
        } */
    ?> -->
    <table id="data_table" class="searchTable">
        <thead>
            <tr style="background:var(--otherColor)">
                <td>S/N</td>
                <td>Customer</td>
                <td>Amount Due</td>
                <td></td>
                
            </tr>
        </thead>
        <tbody>
            <?php
                $n = 1;
                $get_users = new selects();
                $details = $get_users->fetch_debtors();
                if(gettype($details) === 'array'){
                foreach($details as $detail):
            ?>
            <tr>
                <td style="text-align:center; color:red;"><?php echo $n?></td>
                <td>
                    <?php
                        //get account
                        $get_account = new selects();
                        $acs = $get_account->fetch_details_group('customers', 'customer', 'acn', $detail->account);
                        echo $acs->customer;
                    ?>
                </td>
                <td style="color:red">
                    <?php 
                       
                            echo "₦".number_format($detail->total_due, 2);
                        
                    ?>
                </td>
            
                <td>
                    <?php
                        //get customer details
                        $get_id = new selects();
                        $ids = $get_id->fetch_details_group('customers', 'customer_id', 'acn', $detail->account);
                        $customer_id = $ids->customer_id;
                    ?>
                    <a style="color:#fff;background:var(--primaryColor); padding:5px; border-radius:5px" href="javascript:void(0)" title="View invoice details" onclick="showPage('debt_details.php?customer=<?php echo $customer_id?>')">View <i class="fas fa-eye"></i></a>
                </td>
                
            </tr>
            <?php $n++; endforeach;}?>
        </tbody>
    </table>
    
    <?php
        if(gettype($details) == "string"){
            echo "<p class='no_result'>'$details'</p>";
        }

        // get sum
        /* get_total = new selects();
        $amounts = $get_total->fetch_sum_singleless('customers', 'wallet_balance', 'wallet_balance', 0); */
        //get total debits from customers
        $get_debit = new selects();
        $debs = $get_debit->fetch_sum_single('transactions', 'debit', 'class', 4);
        if(gettype($debs) == 'array'){
            foreach($debs as $deb){
                $debit = $deb->total;
            }
        }
        if(gettype($debs) == 'string'){
            $debit = 0;
        }
        //get total credits from customers
        $get_credit = new selects();
        $creds = $get_credit->fetch_sum_single('transactions', 'credit', 'class', 4);
        if(gettype($creds) == 'array'){
            foreach($creds as $cred){
                $credit = $cred->total;
            }
        }
        if(gettype($creds) == 'string'){
            $credit = 0;
        }
        $balance = $debit - $credit;
        echo "<p class='total_amount' style='color:green'>Total Due: ₦".number_format($balance, 2)."</p>";
        /* foreach($amounts as $amount){
            echo "<p class='total_amount' style='color:green'>Total Due: ₦".number_format($amount->total * -1, 2)."</p>";
        } */
    ?>

</div>

<script src="../jquery.js"></script>
<script src="../script.js"></script>