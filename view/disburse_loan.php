<div id="disburse" class="displays">

<?php
    session_start();
    $store = $_SESSION['store_id'];
    include "../classes/dbh.php";
    include "../classes/select.php";
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
    }
    $get_details = new selects();
    if(isset($_GET['loan'])){
        $loan = $_GET['loan'];
        $rows = $get_details->fetch_details_cond('loan_applications', 'loan_id', $loan);
        foreach($rows as $row){
            $customer = $row->customer;
            $product = $row->product;
            $amount = $row->amount;
        }
        //get product name
        $product_details = $get_details->fetch_details_cond('loan_products', 'product_id', $product);
        if(is_array($product_details)){
            foreach($product_details as $detail){
                $product_name = $detail->product;
            }
        }
        //get customer details
        $custs = $get_details->fetch_details_cond('customers', 'customer_id', $customer);
        foreach($custs as $cust){
            $customer_name = $cust->customer;
            $acn = $cust->acn;
            $phone = $cust->phone_numbers;
            $account_number = $cust->account_number;
            $bank = $cust->bank;
            $account_name = $cust->account_name;
        }
?>
    <div class="info" style="width:50%; margin:5px 0;"></div>
    <div class="more_buttons" style="width:70%">
        <button class="page_navs" id="back" onclick="showPage('pending_disbursement.php')"><i class="fas fa-angle-double-left"></i> Back</button>
        <a href="javascript:void(0)" title="Add a ledger" onclick="showPage('account_ledger.php')"><i class="fas fa-receipt"></i> Add Ledger</a>
    </div>
    <div class="add_user_form" style="width:70%; margin:5px 0;">
        <h3 style="background:var(--tertiaryColor); text-align:left">Disburse <?php echo $product_name?> to <?php echo $customer_name?></h3>
        <!-- <form method="POST" id="addUserForm"> -->
        <section class="addUserForm" style="padding:10px 0">
            <div class="inputs" style="gap:.7rem; align-items:flex-start">
                <input type="hidden" name="customer" id="customer" value="<?php echo $customer?>">
                <input type="hidden" name="loan" id="loan" value="<?php echo $loan?>">
                <div class="data" style="width:30%;">
                    <label for="exp_date">Transaction Date</label>
                    <input type="date" name="trx_date" id="trx_date" required value="<?php echo date("Y-m-d")?>">
                </div>
                <div class="data" style="width:30%;">
                    <label for="amount">Requested Amount (NGN)</label>
                    <input type="hidden" name="amount" id="amount" value="<?php echo $amount?>">
                    <input type="text" required value="<?php echo number_format($amount, 2)?>" readonly style="color:var(--tertoaryColor)">
                </div>
                
                <div class="data" style="width:30%;">
                    <label for="contra"><span class="ledger">Cr. </span>Contra Ledger</label>
                    <select name="contra" id="contra">
                        <option value="" selected>Select Contra ledger</option>
                        <?php
                            $get_heads = new selects();
                            $heads = $get_heads->fetch_details_eitherCon('ledgers', 'class', 1, 2);
                            foreach($heads as $head){
                        ?>
                        <option value="<?php echo $head->ledger_id?>"><?php echo $head->ledger?></option>
                        <?php }?>
                    </select>
                </div>
                
                <div class="data" style="width:30%;">
                    <label for="details"> Customer Bank Name</label>
                    <select>
                        <option value="<?php echo $bank?>"><?php echo $bank?></option>
                        <option>Access Bank</option>
                        <option>Citibank Nigeria</option>
                        <option>Ecobank Nigeria</option>
                        <option>Fidelity Bank</option>
                        <option>First Bank of Nigeria</option>
                        <option>First City Monument Bank (FCMB)</option>
                        <option>Globus Bank</option>
                        <option>Guaranty Trust Bank (GTBank)</option>
                        <option>Heritage Bank</option>
                        <option>Jaiz Bank</option>
                        <option>Keystone Bank</option>
                        <option>Parallex Bank</option>
                        <option>Polaris Bank</option>
                        <option>PremiumTrust Bank</option>
                        <option>Providus Bank</option>
                        <option>Stanbic IBTC Bank</option>
                        <option>Standard Chartered Bank Nigeria</option>
                        <option>Sterling Bank</option>
                        <option>SunTrust Bank</option>
                        <option>Titan Trust Bank</option>
                        <option>Union Bank of Nigeria</option>
                        <option>United Bank for Africa (UBA)</option>
                        <option>Unity Bank</option>
                        <option>Wema Bank</option>
                        <option>Zenith Bank</option>
                    </select>
                </div>
                <div class="data" style="width:30%;">
                    <label for="details"> Account Number</label>
                    <input type="text"  value="<?php echo $account_number?>">
                </div>
                <div class="data" style="width:30%;">
                    <label for="details"> Account Name</label>
                    <input type="text"  value="<?php echo $account_name?>">
                </div>
                <div class="data" style="width:30%; margin:5px 0">
                    <button type="button" id="post_exp" name="post_exp" onclick="disburseLoan()">Send Funds  <i class="fas fa-money-check-dollar"></i></button>
                </div>
            </div>
        </section>    
    </div>
<?php }?>
</div>
