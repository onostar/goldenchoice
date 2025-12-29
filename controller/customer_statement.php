<?php
    session_start();
    $store = $_SESSION['store_id'];
    if(isset($_GET['customer'])){
        $customer = $_GET['customer'];
        $_SESSION['customer'] = $customer;
    }
    $from = $_SESSION['fromDate'];
    $to = $_SESSION['toDate'];
    // instantiate classes
    include "../classes/dbh.php";
    include "../classes/select.php";
    //get customer details
    $get_customer = new selects();
    $rows = $get_customer->fetch_details_cond('customers', 'customer_id', $customer);
    foreach($rows as $row){
        $name = $row->customer;
        $phone = $row->phone_numbers;
        $address = $row->customer_address;
        $email = $row->customer_email;
        $joined = $row->reg_date;
        $wallet = $row->wallet_balance;
        $debt = $row->debt_balance;
        $account = $row->acn;
    }
    //get customer accouunt balance from transactions
    $bals = $get_customer->fetch_account_balance($account);
    if(gettype($bals) == 'array'){
        foreach($bals as $bal){
            $balance = $bal->balance;
        }
    }
    
    
?>
<!-- customer info -->
<div class="close_btn">
    <a href="javascript:void(0)" title="Close form" onclick="showPage('../view/customer_statement.php');" class="close_form">Close <i class="fas fa-close"></i></a>
</div>
<div class="customer_info" class="allResults">
    <h3 style="background:var(--tertiaryColor)">Statement between <?php echo $name?> and '<?php echo date("jS M, Y", strtotime($from)) . "' to '" . date("jS M, Y", strtotime($to))?>'</h3>
    <div class="demography">
        <div class="demo_block">
            <h4><i class="fas fa-id-card"></i> Name:</h4>
            <p><?php echo $name?></p>
        </div>
        <div class="demo_block">
            <h4><i class="fas fa-map"></i> Address:</h4>
            <p><?php echo $address?></p>
        </div>
        <div class="demo_block">
            <h4><i class="fas fa-phone-square"></i> Phone numbers:</h4>
            <p><?php echo $phone?></p>
        </div>
        <div class="demo_block">
            <h4><i class="fas fa-envelope"></i> Email:</h4>
            <p><?php echo $email?></p>
        </div>
        <div class="demo_block">
            <h4><i class="fas fa-calendar"></i> Registered:</h4>
            <p><?php echo date("jS M, Y", strtotime($joined))?></p>
        </div>
        <?php /* if($wallet >= 0){ */?>
        <!-- <div class="demo_block" style="color:green">
            <h4 style="color:green"><i class="fas fa-piggy-bank"></i> Account balance:</h4>
            <p><?php echo "₦".number_format($wallet, 2)?></p>
        </div> -->
        <?php /* }else{ */?>
        <div class="demo_block" style="color:red">
        <h4><i class="fas fa-piggy-bank"></i> Account balance:</h4>
        <p><?php echo "₦".number_format($wallet, 2)?></p>
        </div>
        <!-- <div class="demo_block" style="color:red">
        <h4><i class="fas fa-piggy-bank"></i> Account balance:</h4>
        <p><?php echo "₦".number_format($balance, 2)?></p>
        </div> -->
        <?php /* } */?>
    </div>
    <h3 style="background:var(--labColor); text-align:center; color:#fff; padding:10px;margin:0;">Transactions</h3>
    <div class="transactions">
        <div class="all_credit allResults">
            <h3 style="background:var(--otherColor); color:#fff">Loan Applications</h3>
            <table id="data_table" class="searchTable">
                <thead>
                <tr style="background:var(--moreColor)">
                        <td>S/N</td>
                        <td>Date</td>
                        <td>Product</td>
                        <td>Amount</td>
                        <td>Status</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        //get transaction history
                        $details = $get_customer->fetch_details_2dateCon('loan_applications', 'customer', 'date(application_date)', $from, $to, $customer);
                        $n = 1;
                        if(gettype($details) === 'array'){
                        foreach($details as $detail){

                    ?>
                    <tr>
                        <td style="text-align:center; color:red;"><?php echo $n?></td>
                        <td style="color:var(--moreColor)"><?php echo date("d-m-Y", strtotime($detail->application_date));?></td>
                        <td>
                            <?php
                                if($detail->asset == 0){
                                //get product name
                                $prds = $get_customer->fetch_details_group('loan_products', 'product', 'product_id', $detail->product);
                                $product = $prds->product;
                                }else{
                                $prds = $get_customer->fetch_details_group('items', 'item_name', 'item_id', $detail->asset);
                                $product = $prds->item_name;
                                }
                            ?>
                            <a style="color:green" href="javascript:void(0)" title="View loan details" onclick="viewLoanDetails('<?php echo $detail->loan_id?>')"><?php echo $product?></a>
                        </td>
                        <td>
                            <?php 
                                echo "₦".number_format($detail->amount, 2);
                            ?>
                        </td>
                        <td>
                            <?php
                                if($detail->loan_status == 0){
                                    echo "<span style='color:var(--moreColor)'>Under Review</span>";
                                }elseif($detail->loan_status == -1){
                                    echo "<span style='color:red'>Declined</span>";
                                }elseif($detail->loan_status == 1){
                                    echo "<span style='color:var(--primaryColor)'>Approved</span>";
                                }elseif($detail->loan_status == 2){
                                    echo "<span style='color:var(--otherColor)'>Active</span>";

                                }else{
                                    echo "<span style='color:var(--tertiaryColor)'>Completed</span>";

                                }
                            ?>
                        </td>
                    </tr>
                    <?php $n++; }}?>
                </tbody>
            </table>
            <?php
                if(gettype($details) == "string"){
                    echo "<p class='no_result'>'$details'</p>";
                }
                // get sum
                $get_total = new selects();
                $amounts = $get_total->fetch_sum_2date2CondEither('loan_applications', 'amount', 'date(application_date)', 'customer', 'loan_status',$from, $to, $customer, 2, 3);
                foreach($amounts as $amount){
                    $paid_amount = $amount->total;
                }
               
                    echo "<p class='total_amount' style='color:green'>Total Disbursed: ₦".number_format($paid_amount, 2)."</p>";
                    
                
            ?>
        </div>
        <div class="all_credit allResults">
            <div class="deposit_log" style="background:var(--otherColor); border-left:1px solid #cdcdcd">
                <h3 style="background:var(--otherColor)">Deposits transactions</h3>
                <!-- <a href="javascript:void" title="post customer payments" onclick="showPage('../controller/fund_account.php?customer=<?php echo $customer?>')"><i class="fas fa-cash-register"></i> Deposit <i class="fas fa-plus"></i></a> -->
            </div>
            <table id="data_table" class="searchTable">
                <thead>
                <tr style="background:var(--moreColor)">
                        <td>S/N</td>
                        <td>Date</td>
                        <td>Trx. Type</td>
                        <td>Mode</td>
                        <td>Amount</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        //get deposit history
                        $get_transactions = new selects();
                        $details = $get_transactions->fetch_details_2dateCon('deposits', 'customer', 'date(post_date)', $from, $to, $customer );
                        $n = 1;
                        if(gettype($details) === 'array'){
                        foreach($details as $detail){
                    ?>
                    <tr>
                        <td style="text-align:center; color:red;"><?php echo $n?></td>
                        <td style="color:var(--moreColor)"><?php echo date("d-m-Y", strtotime($detail->post_date));?></td>
                        <td><?php echo $detail->trx_type?></td>  
                        <td><?php echo $detail->payment_mode?></td>  
                        <td>
                            <?php echo "₦".number_format($detail->amount, 2);

                            ?>
                        </td>
                        
                    </tr>
                    <?php $n++; }}?>
                </tbody>
            </table>
            <?php
                if(gettype($details) == "string"){
                    echo "<p class='no_result'>'$details'</p>";
                }
                // get sum of deposits
                $credits = $get_customer->fetch_sum_2dateCond('deposits', 'amount', 'customer', 'date(post_date)', $from, $to, $customer);
                foreach($credits as $credit){
                    $deposits = $credit->total;
                }
                echo "<p class='total_amount' style='color:green;font-size:.9rem;'>Total Deposits: ₦".number_format($deposits, 2)."</p>";
                
            ?>
        </div>
    </div>
    <div id="customer_invoices">
        
    </div>
</div>