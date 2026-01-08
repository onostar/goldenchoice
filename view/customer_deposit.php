<div id="fund_account">
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
        }
        //generate deposit receipt
        //get current date
        $todays_date = date("dmyhi");
        $ran_num ="";
        for($i = 0; $i < 5; $i++){
            $random_num = random_int(0, 3);
            $ran_num .= $random_num;
        }
        $receipt_id = "SAV".$todays_date.$ran_num.$user_id;
        //get balance from transactions
      

?>
<div class="back_invoice">
    <button class="page_navs" id="back" onclick="showPage('loan_repayment.php?customer=<?php echo $customer_id?>')"><i class="fas fa-angle-double-left"></i> Back</button>

    
</div>
<div id="deposit" class="displays">
    <div class="info" style="width:70%; margin:5px 0;"></div>
    <div class="fund_account" style="width:80%; margin:5px 0;">
        <h3 style="background:var(--labColor); text-align:left">Post customer savings</h3>
        <!-- <form method="POST" id="addUserForm"> -->
        <div class="details_forms">
            <section class="addUserForm">
                <div class="inputs" style="flex-wrap:wrap">
                    <input type="hidden" name="invoice" id="invoice" value="<?php echo $receipt_id?>">
                    <input type="hidden" name="posted" id="posted" value="<?php echo $user_id?>">
                    <input type="hidden" name="customer" id="customer" value="<?php echo $customer_id?>">
                    <input type="hidden" name="balance" id="balance" value="<?php echo $balance?>">
                    <input type="hidden" name="store" id="store" value="<?php echo $store?>">
                   
                    
                    <div class="data" style="width:100%; margin:5px 0">
                        <label for="amount"> Transaction Date</label>
                        <input type="date" name="trans_date" id="trans_date" value="<?php echo date('Y-m-d')?>">
                    </div>
                    <div class="data" style="width:50%; margin:5px 0">
                        <label for="amount"> Amount paid</label>
                        <input type="text" name="amount" id="amount" required placeholder="0.00">
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
                            <option value="<?php echo $row->bank_id?>"><?php echo $row->bank?></option>
                            <?php endforeach?>
                        </select>
                    </div>
                    <div class="data" style="width:100%; margin:5px 0">
                        <label for="details"> Description</label>
                        <textarea name="details" id="details" cols="30" rows="5">Customer Savings</textarea>
                    </div>
                    <div class="data" style="width:50%; margin:5px 0">
                        <button type="submit" id="post_exp" name="post_exp" onclick="savings()">Post payment <i class="fas fa-cash-register"></i></button>
                    </div>
                </div>
            </section>
            <section class="customer_details" style="height:100%;">
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
                        <label for="balance">Account Balance:</label>
                        <input type="text" value="<?php echo "₦".number_format($balance, 2)?>" style="color:red;">
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