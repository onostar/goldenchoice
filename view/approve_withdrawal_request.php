<div id="fund_account">
    <style>
        @media screen and (max-width: 800px){
            .fund_account{
                width:100%!important;
            }
            .details_forms{
                flex-direction: column-reverse!important;
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
    
    if(isset($_GET['withdrawal']) && isset($_GET['customer'])){
        $withdraw_id = $_GET['withdrawal'];
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
        //withdrawal details
        $results = $get_details->fetch_details_cond('withdrawals', 'withdrawal_id', $withdraw_id);
        foreach($results as $result){
            $amount = $result->amount;
            $type = $result->savings_type;
            $invoice = $result->invoice;
        }
       
      

?>
<div class="back_invoice">
    <button class="page_navs" id="back" onclick="showPage('approve_withdrawals.php')"><i class="fas fa-angle-double-left"></i> Back</button>

    
</div>
<div id="deposit" class="displays">
    <div class="info" style="width:70%; margin:5px 0;"></div>
    <div class="fund_account" style="width:80%; margin:5px 0;">
        <h3 style="background:var(--labColor); text-align:left">Post customer Withdrawal</h3>
        <!-- <form method="POST" id="addUserForm"> -->
        <div class="details_forms">
            <section class="addUserForm">
                <div class="inputs" style="flex-wrap:wrap">
                    <input type="hidden" name="withdrawal" id="withdrawal" value="<?php echo $withdraw_id?>">
                    <input type="hidden" name="posted" id="posted" value="<?php echo $user_id?>">
                    <input type="hidden" name="customer" id="customer" value="<?php echo $customer_id?>">
                    <!-- <input type="hidden" name="balance" id="balance" value="<?php echo $balance?>"> -->
                   
                    <div class="data" style="width:50%; margin:5px 0">
                        <label for="amount"> Amount</label>
                        <input type="text" name="amount" id="amount" required value="<?php echo number_format($amount, 2)?>" readonly>
                    </div>
                    <div class="data" style="width:45%">
                        <label for="Payment_mode"><span class="ledger">Dr. Ledger</span> (Cash/Bank)</label>
                        <select name="payment_mode" id="payment_mode" onchange="checkMode(this.value)">
                            <option value=""selected>Select payment option</option>
                            <option value="Cash">Cash</option>
                            <option value="POS">POS</option>
                            <option value="Transfer">Transfer</option>
                        </select>
                    </div>
                    <div class="data" id="selectBank"  style="width:100%!important">
                        <select name="bank" id="bank">
                            <option value=""selected>Select Bank</option>
                            <?php
                                $get_bank = new selects();
                                $rows = $get_bank->fetch_details('banks', 10, 10);
                                foreach($rows as $row):
                            ?>
                            <option value="<?php echo $row->bank_id?>"><?php echo $row->bank?>(<?php echo $row->account_number?>)</option>
                            <?php endforeach?>
                        </select>
                    </div>
                    <div class="data" style="width:50%; margin:5px 0">
                        <button type="submit" id="post_exp" name="post_exp" onclick="approveWithdrawal()">Post payment <i class="fas fa-cash-register"></i></button>
                    </div>
                </div>
            </section>
            <section class="customer_details">
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
                        <label for="balance">Normal Savings:</label>
                        <input type="text" value="<?php echo "₦".number_format($balance, 2)?>" style="color:green;">
                    </div>
                    <div class="data">
                        <label for="balance">Thrift Balance:</label>
                        <input type="text" value="<?php echo "₦".number_format($thrift, 2)?>" style="color:var(--tertiaryColor);">
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