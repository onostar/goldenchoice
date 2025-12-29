
<?php
    include "receipt_style.php";
// session_start();
// instantiate class
include "../classes/dbh.php";
include "../classes/select.php";
    session_start();
    if(isset($_GET['receipt'])){
        $user = $_SESSION['user_id'];
        $invoice = $_GET['receipt'];
        $type = "Payment Receipt";      
        //get customer
        $get_customer_id = new selects();
        $custs = $get_customer_id->fetch_details_cond('deposits', 'invoice', $invoice);
        foreach($custs as $cust){
            $customer = $cust->customer;
            $pay_mode = $cust->payment_mode;
            $paid_date = $cust->post_date;
        }
        //get customer balances
        $get_customer = new selects();
        $rows = $get_customer->fetch_details_cond('customers', 'customer_id', $customer);
        foreach($rows as $row){
            $wallet = $row->wallet_balance;
            $debt = $row->debt_balance;
            $cust_address = $row->customer_address;
            $cust_phone = $row->phone_numbers;
            $full_name = $row->customer;
            $account = $row->acn;

        }
        //get store
        $get_store = new selects();
        $str = $get_store->fetch_details_group('deposits', 'store', 'invoice', $invoice);
        //get store name
        $get_store_name = new selects();
        $strss = $get_store_name->fetch_details_cond('stores', 'store_id', $str->store);
        foreach($strss as $strs){
            $store_name = $strs->store;
            $address = $strs->store_address;
            $phone = $strs->phone_number;

        }
?>
<div class="displays allResults sales_receipt">
    <?php include "receipt_header.php"?>
        
    </div>
        <h3><?php echo $type?></h3>

    <!-- <div class="patient_details">
        <div class="bill_to">
            <h3>CLIENT</h3>
        </div>
        <p><strong><span><?php echo $full_name?></span></strong></p>
        <p><strong><span><?php echo $cust_address?></span></strong></p>
        <p><strong><span><?php echo $cust_phone?></span></strong></p>
        <p><strong>Invoice Date:</strong> <span><?php echo date("d-m-Y", strtotime($paid_date))?></span></p>

    </div> -->
    <table id="postsales_table" class="searchTable" style="width:100%">
        <thead>
            <tr style="background:rgba(11, 99, 134, 0.7); color:#fff">
                <!-- <td>S/N</td> -->
                <td>Details</td>
                <td>Amount</td>
            </tr>
        </thead>
        <tbody>
            <?php
                $n = 1;
                //get payment details
                $get_payment = new selects();
                $payments = $get_payment->fetch_details_cond('deposits', 'invoice', $invoice);
                foreach($payments as $payment){
        
            ?>
            <tr style="font-size:.8rem">
                <!-- <td style="text-align:center; color:red;"><?php echo $n?></td> -->
                <td style="color:var(--moreClor);font-weight:.8rem">
                    Being <?php echo $pay_mode?> deposit for <?php echo $payment->details?>
                </td>
                <td style="font-weight:.8rem">
                    <?php 
                        echo number_format($payment->amount);
                    ?>
                </td>
                
                
            </tr>
            
            <?php $n++; };}?>
        </tbody>
    </table>

    
    <?php
        if(gettype($payments) == "string"){
            echo "<p class='no_result'>'$payments'</p>";
        }
        
        //get loan due
        
        if($debt > 0){
            echo "<p class='total_amount' style='color:red; margin:0'>Debt Balance: ₦".number_format($debt, 2)."</p>";
        }
        /*  echo "<p class='total_amount' style='color:green'>Amount due: ₦".number_format($debt, 2)."</p>"; */
        //sold by
        $get_seller = new selects();
        $row = $get_seller->fetch_details_group('users', 'full_name', 'user_id', $user);
        echo ucwords("<p class='sold_by'>Posted by: <strong>$row->full_name</strong></p>");
    ?>
    <p style="margin-top:20px;text-align:center"><strong>Thanks for your business!</strong></p>
    
</div> 
   
<?php
    echo "<script>window.print();
    window.close();</script>";
                    // }
                
            // }
        
    // }
?>