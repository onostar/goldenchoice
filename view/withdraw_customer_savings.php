<div id="fund_account">
    <style>
        @media screen and (max-width: 800px){
            .fund_account{
                width:100%!important;
            }
            .inputs{
                gap: .3rem!important;
            }
            .data{
                padding:10px!important;
                width:100%!important;
                margin:0!important;
            }
            .data input, .data select{
                width:100%!important;
                padding:5px!important;
            }

        }
    </style>
<?php
    session_start();
    include "../classes/dbh.php";
    include "../classes/select.php";
    include "../classes/update.php";
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        $store = $_SESSION['store_id'];
        // echo $user_id;
    
    if(isset($_GET['customer'])){
        $customer_id = $_GET['customer'];
        // $schedule = $_GET['schedule'];
        //get customer details;
        $get_details = new selects();
        $rows = $get_details->fetch_details_cond('customers', 'customer_id', $customer_id);
        foreach($rows as $row){
            $customer = $row->customer;
            $acn = $row->acn;
            $balance = $row->wallet_balance;
            $thrift = $row->thrift;
        }

        //generate deposit receipt
        //get current date
        $todays_date = date("dmyhi");
        $ran_num ="";
        for($i = 0; $i < 5; $i++){
            $random_num = random_int(0, 3);
            $ran_num .= $random_num;
        }
        $receipt_id = "WT".$todays_date.$ran_num.$user_id;
        //get balance from transactions
      

?>
<div class="back_invoice">
    <button class="page_navs" id="back" onclick="showPage('withdraw_savings.php?customer=<?php echo $customer_id?>')"><i class="fas fa-angle-double-left"></i> Back</button>

    
</div>
<div id="deposit" class="displays">
    <div class="info" style="width:70%; margin:5px 0;"></div>
    <div class="fund_account" style="width:60%; margin:5px 0;">
        <h3 style="background:var(--labColor); text-align:left">Savings Withdrawal Form</h3>
        <!-- <form method="POST" id="addUserForm"> -->
        <div class="details_forms">
            
            <section class="customer_details" style="width:100%;">
                <div class="inputs">
                    <div class="data">
                        <label for="customer_id">Customer ID:</label>
                        <input type="text" value="<?php echo $acn?>">
                    </div>
                    <div class="data">
                        <label for="customer_name"><span class="ledger" style="color:#fff">Cr. Ledger</span> (Client):</label>
                        <input type="text" value="<?php echo $customer?>">
                    </div>
                    
                    <div class="data">
                        <label for="balance">Savings:</label>
                        <input type="text" value="<?php echo "₦".number_format($balance, 2)?>" style="color:green;">
                    </div>
                    <div class="data">
                        <label for="balance">Thrift Balance:</label>
                        <input type="text" value="<?php echo "₦".number_format($thrift, 2)?>" style="color:var(--tertiaryColor);">
                    </div>
                </div>
            </section> 
            <section class="addUserForm" style="width:100%">
                <div class="inputs" style="flex-wrap:wrap">
                    <input type="hidden" name="invoice" id="invoice" value="<?php echo $receipt_id?>">
                    <input type="hidden" name="posted" id="posted" value="<?php echo $user_id?>">
                    <input type="hidden" name="customer" id="customer" value="<?php echo $customer_id?>">
                    <input type="hidden" id="normal_savings" name="normal_savings" value="<?php echo $balance?>">
                    <input type="hidden" id="thrift" name="thrift" value="<?php echo $thrift?>">
                    <input type="hidden" name="store" id="store" value="<?php echo $store?>">
                    <div class="data" style="width:45%">
                        <label for="savings_type">Savings Type</label>
                        <select name="savings_type" id="savings_type">
                            <option value=""selected disabled>Select Withdrawal Type</option>
                            <option value="Normal Savings">Normal Savings</option>
                            <option value="Thrift Savings">Thrift Savings</option>
                            
                        </select>
                    </div>
                    <div class="data" style="width:50%; margin:5px 0">
                        <label for="amount"> Amount</label>
                        <input type="text" name="amount" id="amount" required placeholder="0.00">
                    </div>
                    
                    <div class="data" style="width:50%; margin:5px 0">
                        <button type="submit" id="post_exp" name="post_exp" onclick="withdrawSavings()">Apply <i class="fas fa-save"></i></button>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<?php
            }
        
    }else{
        header("Location: ../index.php");
    }
?>
</div>