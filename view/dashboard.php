<div id="general_dashboard">
<div class="dashboard_all">
    <h3><i class="fas fa-home"></i> Dashboard for <span style="color:var(--secondaryColor);font-size:1rem"><?php echo $store?></span></h3>
    <?php
        $get_dashboard = new selects();
    ?>
    <?php 
        if($role === "Admin" || $role === "Accountant"){
    ?>
    
    <div id="dashboard">
        <div class="cards" id="card4">
            
            <a href="javascript:void(0)" onclick="showPage('sales_report.php')">
                <div class="infos">
                    <p><i class="fas fa-coins"></i> Daily Sales</p>
                    <p>
                    <?php
                        $get_sales = new selects();
                        $rows = $get_sales->fetch_sum_curdatecon('payments', 'amount_paid', 'post_date', 'store', $store_id);
                        foreach($rows as $row){
                            $amount = $row->total;
                        }
                        //if credit was sold
                        $get_credit = new selects();
                        $credits = $get_credit->fetch_sum_curdate2Con('payments', 'amount_due', 'post_date', 'payment_mode', 'Credit', 'store', $store_id);
                        if(gettype($credits) === "array"){
                            foreach($credits as $credit){
                                $owed_amount = $credit->total;
                            }
                            $total_revenue = $owed_amount + $amount;
                            echo "₦".number_format($total_revenue, 2);

                        }
                        //if no credit sales
                        if(gettype($credits) == "string"){
                            echo "₦".number_format($amount, 2);
                            
                        }
                    ?>
                    </p>
                </div>
            </a>
        </div> 
        <div class="cards" id="card1">
            <!-- <a href="javascript:void(0)">
                <div class="infos">
                    <p><i class="fas fa-piggy-bank"></i> Monthly Receipts</p>
                    <p>
                    <?php
                        $rows = $get_dashboard->fetch_sum_curMonth('deposits', 'amount', 'post_date');
                        if(is_array($rows)){
                            foreach($rows as $row){
                                $amount = $row->total;
                            }
                        }else{
                            $amount = 0;
                        }
                        echo "₦".number_format($amount, 2);
                       
                    ?>
                    </p>
                </div>
            </a> -->
            <a href="javascript:void(0)" onclick="showPage('deposit_report.php')">
                <div class="infos">
                    <p><i class="fas fa-calendar-day"></i> Today's Payments</p>
                    <p>
                    <?php
                        $rows = $get_dashboard->fetch_sum_curdate('deposits', 'amount', 'post_date');
                        if(is_array($rows)){
                            foreach($rows as $row){
                                $amount = $row->total;
                            }
                        }else{
                            $amount = 0;
                        }
                        echo "₦".number_format($amount, 2);
                       
                    ?>
                    </p>
                </div>
            </a>
        </div> 
        <div class="cards" id="card5" style="background:var(--moreColor)">
            <a href="javascript:void(0)"onclick="showPage('disbursement_report.php')"class="page_navs">
                <div class="infos">
                    <p><i class="fas fa-people-arrows-left-right"></i> Monthly Disbursements</p>
                    <p>
                    <?php
                        $rows = $get_dashboard->fetch_sum_curMonth('disbursal', 'amount', 'disbursed_date');
                        if(is_array($rows)){
                            foreach($rows as $row){
                                $amount = $row->total;
                            }
                        }else{
                            $amount = 0;
                        }
                        echo "₦".number_format($amount, 2);
                    ?>
                    </p>
                </div>
            </a>
        </div> 
        <!-- <div class="cards" id="card5">
            <a href="javascript:void(0)" class="page_navs" onclick="showPage('expense_report.php')">
                <div class="infos">
                    <p><i class="fas fa-hand-holding-dollar"></i> Monthly Expense</p>
                    <p>
                    <?php
                       /*  $get_exp = new selects();
                        $exps = $get_exp->fetch_sum_curMonth('expenses', 'amount', 'expense_date');
                        foreach($exps as $exp){
                            echo "₦".number_format($exp->total, 2);
                        } */
                    ?>
                    </p>
                </div>
            </a>
        </div>  -->
        <div class="cards" id="card0">
            <a href="javascript:void(0)" onclick="showPage('active_loans.php')"class="page_navs">
                <div class="infos">
                    <p><i class="fas fa-hand-holding-dollar"></i> Receiveables</p>
                    <p>
                    <?php
                        //get total due amount
                        $dues = $get_dashboard->fetch_sum_single('repayment_schedule', 'amount_due', 'payment_status', 0);
                        if(is_array($dues)){
                            foreach($dues as $due){
                                $amount_due = $due->total;
                            }
                        }else{
                            $amount_due = 0;
                        }
                        //get total paid amount
                        $paid = $get_dashboard->fetch_sum_single('repayment_schedule', 'amount_paid', 'payment_status', 0);
                        if(is_array($paid)){
                            foreach($paid as $pay){
                                $amount_paid = $pay->total;
                            }
                        }else{
                            $amount_paid = 0;
                        }

                        //get total outstanding debts
                        $outs = $get_dashboard->fetch_sum_singleGreat('customers', 'debt_balance', 'debt_balance', 0);
                        if(is_array($outs)){
                            foreach($outs as $out){
                                $outstanding = $out->total;
                            }
                        }else{
                            $outstanding = 0;
                        }
                        $debt = ($amount_due - $amount_paid) + $outstanding;
                        echo "₦".number_format($debt, 2);
                        
                    ?>
                    </p>
                </div>
            </a>
            
        </div> 
        
        
    </div>
    <?php
        }elseif($role == "Loan Officer"){
    ?>
    <div id="dashboard">
        <div class="cards" id="card4">
            <a href="javascript:void(0)" class="page_navs">
                <div class="infos">
                    <p><i class="fas fa-users"></i> Daily Visits</p>
                    <p>
                    <?php
                        //get total customers
                       $customers =  $get_dashboard->fetch_count_condDateGro('repayments',  'posted_by', $user_id, 'post_date', 'customer');
                       echo $customers;

                    ?>
                    </p>
                </div>
            </a>
        </div> 
    <div class="cards" id="card1">
            <a href="javascript:void(0)" class="page_navs">
                <div class="infos">
                    <p><i class="fas fa-hand-holding-dollar"></i> Daily Collections</p>
                    <p>
                    <?php
                       
                       $collections = $get_dashboard->fetch_sum_curdateCon('repayments', 'amount', 'post_date', 'posted_by', $user_id);
                        if(is_array($collections)){
                            foreach($collections as $collect){
                                $collected = $collect->total;
                            }
                        }else{
                            $collected = 0;
                        }
                        echo "₦".number_format($collected, 2);

                    ?>
                    </p>
                </div>
            </a>
        </div> 
        
        <div class="cards" id="card2" style="background: var(--moreColor)">
        <a href="javascript:void(0)" class="page_navs">
                <div class="infos">
                <p><i class="fas fa-coins"></i> Monthly Collections</p>
                    <p>
                        <?php
                            $month_cols = $get_dashboard->fetch_sum_curMonthCon('repayments', 'amount', 'post_date', 'posted_by', $user_id);
                            if(is_array($month_cols)){
                                foreach($month_cols as $month_col){
                                    $monthly_col = $month_col->total;
                                }
                            }else{
                                $monthly_col = 0;
                            }
                            echo "₦".number_format($monthly_col, 2);
                        ?>
                    </p>
                </div>
            </a>
        </div> 
            <div class="cards" id="card5" style="background: brown">
            <a href="javascript:void(0)" onclick="showPage('invoices_due.php')">
                <div class="infos">
                    <p><i class="fas fa-clock"></i> Payments Due</p>
                    <p>
                    <?php
                        $dues = $get_dashboard->fetch_count_curdategreater2con('repayment_schedule', 'due_date', 'store', $store_id, 'payment_status', 0);
                        echo $dues;
                    ?>
                    </p>
                </div>
            </a>
        </div> 
    </div>
    <?php
        }else if($role == "Sales Officer"){
    ?>
    <div id="dashboard">
    <div class="cards" id="card0">
            <a href="javascript:void(0)" class="page_navs">
                <div class="infos">
                    <p><i class="fas fa-users"></i> Customers</p>
                    <p>
                    <?php
                        //get total customers
                       $get_cus = new selects();
                       $customers =  $get_cus->fetch_count_2condDateGro('sales', 'sales_status', 2, 'posted_by', $user_id, 'post_date', 'invoice');
                       echo $customers;
                    ?>
                    </p>
                </div>
            </a>
        </div> 
        <div class="cards" id="card4">
            <a href="javascript:void(0)" onclick="showPage('expire_soon.php')">
                <div class="infos">
                    <p><i class="fas fa-coins"></i> Soon to expire</p>
                    <p>
                        <?php
                            $get_soon_expired = new selects();
                            $soon_expired = $get_soon_expired->fetch_expire_soon('inventory', 'expiration_date', 'quantity', 'store', $store_id);
                            echo $soon_expired;
                        ?>
                    </p>
                </div>
            </a>
        </div> 
        <div class="cards" id="card3">
            <a href="javascript:void(0)" onclick="showPage('expired_items.php')" class="page_navs">
                <div class="infos">
                    <p><i class="fas fa-money-check"></i> Expired items</p>
                    <p>
                        <?php
                            $get_expired = new selects();
                            $expired = $get_expired->fetch_expired('inventory', 'expiration_date', 'quantity', 'store', $store_id);
                            echo $expired;
                        ?>
                    </p>
                </div>
            </a>
        </div> 
        <div class="cards" id="card2" style="background: var(--moreColor)">
            <a href="javascript:void(0)" class="page_navs" onclick="showPage('reached_reorder.php')">
                <div class="infos">
                    <p><i class="fas fa-hand-holding-dollar"></i> Out of stock</p>
                    <p>
                        <?php
                            $out_stock = new selects();
                            $stock = $out_stock->fetch_count_2cond('inventory', 'quantity', 0, 'store', $store_id);
                            echo $stock;
                        ?>
                    </p>
                </div>
            </a>
        </div> 
            
    </div>
    <?php
        }else{
    ?>
    <div id="dashboard">
        <div class="cards" id="card1">
            <a href="javascript:void(0)" class="page_navs">
                <div class="infos">
                    <p><i class="fas fa-wallet"></i> Available Balance</p>
                    <p>
                    <?php
                        //get total customers
                        //get customer balance
                        $bals = $get_dashboard->fetch_details_group('customers', 'wallet_balance', 'customer_id', $customer_id);
                        echo "₦".number_format($bals->wallet_balance, 2);
                    ?>
                    </p>
                </div>
            </a>
        </div> 
        <div class="cards" id="card4">
            <a href="javascript:void(0)" class="page_navs">
                <div class="infos">
                    <p><i class="fas fa-briefcase"></i> Loan Satus</p>
                    <p>
                    <?php
                        $active_loan = false;
                        $status = $get_dashboard->fetch_details_cond('loan_applications', 'customer', $customer_id);
                       if(is_array($status)) {
                        foreach ($status as $stat) {
                            $date_due = new DateTime($stat->due_date);
                            $today = new DateTime();

                            if ($stat->loan_status == 0) {
                                $active_loan = true;
                                echo "Under Review";
                                break;
                            } elseif ($stat->loan_status == 1) {
                                $active_loan = true;
                                echo "Approved";
                                break;
                            } elseif ($stat->loan_status == 2) {
                                $active_loan = true;
                                if ($date_due >= $today) {
                                    echo "Disbursed";
                                } else {
                                    echo "Overdue";
                                }
                                break;
                            }
                        }
                    }

                    if (!$active_loan) {
                        echo "No Active Loan";
                    }
                    ?>
                    </p>
                </div>
            </a>
        </div> 
        <div class="cards" id="card5" style="background: var(--moreColor)">
            <a href="javascript:void(0)" onclick="showPage('loan_status.php')">
                <div class="infos">
                    <p><i class="fas fa-piggy-bank"></i> Loan Balance</p>
                    <p>
                    <?php
                       //balance
                       $oweds = $get_dashboard->fetch_sum_double('repayment_schedule', 'amount_due', 'payment_status', 0, 'customer', $customer_id);
                       if(is_array($oweds)){
                           foreach($oweds as $owed){
                               $balance_due = $owed->total;
                           }
                        }else{
                            $balance_due = 0;
                        }
                        //get total paid amount
                        $paid = $get_dashboard->fetch_sum_double('repayment_schedule', 'amount_paid', 'payment_status', 0, 'customer', $customer_id);
                        if(is_array($paid)){
                            foreach($paid as $pay){
                                $amount_paid = $pay->total;
                            }
                        }else{
                            $amount_paid = 0;
                        }
                        $debt = $balance_due - $amount_paid;
                        echo "₦".number_format($debt, 2);
                    ?>
                    </p>
                </div>
            </a>
        </div> 
        <div class="cards" id="card5" style="background: brown">
            <a href="javascript:void(0)" onclick="showPage('loan_status.php')"class="page_navs">
                <div class="infos">
                <p><i class="fas fa-hand-holding-dollar"></i> Total Paid</p>
                    <p>
                    <?php
                        //first checkloan status
                        $stats = $get_dashboard->fetch_details_2cond('loan_applications', 'customer', 'loan_status', $customer_id, 2);
                        if(is_array($stats)){
                            foreach($stats as $stat){
                                //get total paid
                                $paid = $get_dashboard->fetch_sum_single('repayment_schedule', 'amount_paid', 'loan', $stat->loan_id);
                                foreach($paid as $pay){
                                    echo "₦".number_format($pay->total, 2);
                                }
                            }
                        }else{
                            echo "No Active Loan";
                        }
                    ?>
                    </p>
                </div>
            </a>
        </div> 
            
    </div>
    <?php }?>
</div>
<?php 
    if($role === "Admin" || $role == "Accountant"){
?>
<!-- management summary -->
<div id="paid_receipt" class="management">
    <hr>
    <div class="daily_monthly">
        <!-- daily revenue summary -->
        <div class="daily_report allResults">
            <h3 style="background:brown">Daily Collections</h3>
            <table style="box-shadow:none">
                <thead>
                    <tr>
                        <td>S/N</td>
                        <td>Date</td>
                        <td>Clients</td>
                        <td>Payments</td>
                    </tr>
                </thead>
                <?php
                    $n = 1;
                    $get_daily = new selects();
                    $dailys = $get_daily->fetch_daily_invoice($store_id);
                    if(gettype($dailys) == "array"){
                    foreach($dailys as $daily):

                ?>
                <tbody>
                    <tr>
                        <td><?php echo $n?></td>
                        <td><?php echo date("jS M, Y",strtotime($daily->post_date))?></td>  
                        <td style="text-align:center; color:var(--otherColor)"><?php echo $daily->customers?></td>
                        <td style="color:green;"><?php echo "₦".number_format($daily->revenue, 2)?></td>
                    </tr>
                </tbody>
                <?php $n++; endforeach; }?>

                
            </table>
            <?php
                if(gettype($dailys) == "string"){
                    echo "<p class='no_result'>'$dailys'</p>";
                }
            ?>
        </div>
        <div class="daily_report allResults">
            <h3 style="background:var(--otherColor)">Daily Sales Record</h3>
            <table>
                <thead>
                    <tr>
                        <td>S/N</td>
                        <td>Date</td>
                        <td>Customers</td>
                        <td>Revenue</td>
                    </tr>
                </thead>
                <?php
                    $n = 1;
                    $get_daily = new selects();
                    $dailys = $get_daily->fetch_daily_sales($store_id);
                    if(gettype($dailys) == "array"){
                    foreach($dailys as $daily):

                ?>
                <tbody>
                    <tr>
                        <td><?php echo $n?></td>
                        <td><?php echo date("jS M, Y",strtotime($daily->post_date))?></td>  
                        <td style="text-align:center; color:var(--otherColor)"><?php echo $daily->customers?></td>
                        <td style="color:green;"><?php echo "₦".number_format($daily->revenue)?></td>
                    </tr>
                </tbody>
                <?php $n++; endforeach; }?>

                
            </table>
            <?php
                if(gettype($dailys) == "string"){
                    echo "<p class='no_result'>'$dailys'</p>";
                }
            ?>
        </div>
        <!-- monthly revenue summary -->
        <!-- <div class="monthly_report allResults">
            <div class="chart">
                <?php
               /*  $get_monthly = new selects();
                $monthlys = $get_monthly->fetch_monthly_invoice($store_id);
                if(gettype($monthlys) == "array"){
                    foreach($monthlys as $monthly){
                        $disbursed[] = $monthly->disbursed;
                        $months[] = date("M, Y", strtotime($monthly->disbursed_date));
                    }
                } */
                ?>
                <h3 style="background:var(--moreColor)">Monthly statistics (Loan Disbursed)</h3>
                <canvas id="chartjs_bar2"></canvas>
            </div>
            <div class="monthly_encounter">
                <h3 style="background:rgb(117, 32, 12)">Monthly Payments</h3>
                <table>
                    <thead>
                        <tr>
                            <td>S/N</td>
                            <td>Month</td>
                            <td>Customers</td>
                            <td>Amount</td>
                            <td>Daily Average</td>
                        </tr>
                    </thead>
                    <?php
                        /* $n =1;
                        $get_monthly = new selects();
                        $monthlys = $get_monthly->fetch_monthly_revenue($store_id);
                        if(gettype($monthlys) == "array"){
                        foreach($monthlys as $monthly): */

                    ?>
                    <tbody>
                        <tr>
                            <td><?php echo $n?></td>
                            <td><?php echo date("M, Y", strtotime($monthly->post_date))?></td>
                            <td style="text-align:center; color:var(--otherColor"><?php echo $monthly->customers?></td>
                            <td style="text-align:center; color:green"><?php echo "₦".number_format($monthly->revenue)?></td>
                            <td style="text-align:center; color:red"><?php
                               /*  $average = $monthly->revenue/$monthly->daily_average;
                                echo "₦".number_format($average, 2); */
                            ?></td>
                        </tr>
                    </tbody>
                    <?php /* $n++; endforeach; } */?>

                    
                </table>
                <?php 
                    /* if(gettype($monthlys) == "string"){
                        echo "<p class='no_result'>'$monthlys'</p>";
                    } */
                ?>
            </div>
        </div> -->
        <div class="daily_report allResults">
            <div class="chart">
                <!-- chart for technical group -->
                <?php
                $get_monthly = new selects();
                $monthlys = $get_monthly->fetch_monthly_sales($store_id);
                if(gettype($monthlys) == "array"){
                    foreach($monthlys as $monthly){
                        $revenue[] = $monthly->revenue;
                        $month[] = date("M, Y", strtotime($monthly->post_date));
                    }
                }
                ?>
                <h3 style="background:var(--moreColor)">Monthly statistics</h3>
                <canvas id="chartjs_bar2"></canvas>
            </div>
        </div>
        <div class="daily_report allResults">
            <h3>Monthly Sales Record</h3>
            <table>
                <thead>
                    <tr>
                        <td>S/N</td>
                        <td>Month</td>
                        <td>Customers</td>
                        <td>Amount</td>
                        <td>Daily Average</td>
                    </tr>
                </thead>
                <?php
                    $n =1;
                    $get_monthly = new selects();
                    $monthlys = $get_monthly->fetch_monthly_sales($store_id);
                    if(gettype($monthlys) == "array"){
                    foreach($monthlys as $monthly):

                ?>
                <tbody>
                    <tr>
                        <td><?php echo $n?></td>
                        <td><?php echo date("M, Y", strtotime($monthly->post_date))?></td>
                        <td style="text-align:center; color:var(--otherColor"><?php echo $monthly->customers?></td>
                        <td style="text-align:center; color:green"><?php echo "₦".number_format($monthly->revenue)?></td>
                        <td style="text-align:center; color:red"><?php
                            $average = $monthly->revenue/$monthly->daily_average;
                            echo "₦".number_format($average, 2);
                        ?></td>
                    </tr>
                </tbody>
                <?php $n++; endforeach; }?>

                
            </table>
            <?php 
                if(gettype($monthlys) == "string"){
                    echo "<p class='no_result'>'$monthlys'</p>";
                }
            ?>
        </div>
        
    </div>
</div>

<?php 
    }elseif($role == "Loan Officer"){
?>
<div class="check_out_due">
    <hr>
    <div class="displays allResults" id="check_out_guest" style="width:100%!important; margin:0 auto!important">
       
        <h3 style="background:var(--otherColor)">My Daily transactions</h3>
        <table id="check_out_table" class="searchTable" style="width:100%;">
            <thead>
                <tr style="background:var(--moreColor)">
                    <td>S/N</td>
                    <td>Invoice No.</td>
                    <td>Customer</td>
                    <td>Amount</td>
                    <td>Payment Mode</td>
                    <!-- <td>Trans. Date</td> -->
                    <td>Post Time</td>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                    $n = 1;
                    $details = $get_dashboard->fetch_details_curdateCon('deposits', 'post_date',  'posted_by', $user_id);
                    if(gettype($details) === 'array'){
                    foreach($details as $detail):
                ?>
                <tr>
                    <td style="text-align:center; color:red;"><?php echo $n?></td>
                    <td style="color:green"><?php echo $detail->invoice?></td>
                    <td>
                        <?php
                            $name = $get_dashboard->fetch_details_group('customers', 'customer', 'customer_id', $detail->customer);
                            echo $name->customer;
                        ?>
                    </td>
                    
                    <td><?php echo "₦".number_format($detail->amount)?></td>
                    <td>
                        <?php
                            //get payment mode
                            echo $detail->payment_mode;
                            ?>
                    </td>
                    <td><?php echo date("h:i:sa", strtotime($detail->post_date))?></td>
                </tr>
                <?php $n++; endforeach;}?>
            </tbody>
        </table>
        
        <?php
            if(gettype($details) == "string"){
                echo "<p class='no_result'>'$details'</p>";
            }
        ?>
    </div>
</div>
<?php }else if($role == "Sales Officer"){?>
    <div class="check_out_due">
    <hr>
    <div class="displays allResults" id="check_out_guest">
       
        <h3 style="background:var(--otherColor)">My Daily transactions</h3>
        <table id="check_out_table" class="searchTable" style="width:100%;">
            <thead>
                <tr style="background:var(--moreColor)">
                    <td>S/N</td>
                    <td>Customer</td>
                    <td>Invoice</td>
                    <td>Item</td>
                    <td>Qty</td>
                    <!-- <td>Unit sales</td>
                    <td>Amount</td> -->
                    <td>Payment mode</td>
                    <td>Time</td>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                    $n = 1;
                    $get_users = new selects();
                    $details = $get_users->fetch_details_date2Cond('sales', 'date(post_date)', 'sales_status', 2, 'posted_by', $user_id);
                    if(gettype($details) === 'array'){
                    foreach($details as $detail):
                ?>
                <tr>
                    <td style="text-align:center; color:red;"><?php echo $n?></td>
                    <td>
                        <?php
                            $cus = $get_daily->fetch_details_group('customers', 'customer', 'customer_id', $detail->customer);
                            echo $cus->customer;
                        ?>
                    </td>
                    <td style="color:green"><?php echo $detail->invoice?></td>
                    <td>
                        <?php
                            $get_name = new selects();
                            $name = $get_name->fetch_details_group('items', 'item_name', 'item_id', $detail->item);
                            echo $name->item_name;
                        ?>
                    </td>
                    <td style="text-align:center; color:var(--otherColor)"><?php echo $detail->quantity?></td>
                    <!-- <td><?php echo "₦".number_format($detail->price)?></td>
                    <td><?php echo "₦".number_format($detail->total_amount)?></td> -->
                    <td>
                        <?php
                            //get payment mode
                            $get_mode = new selects();
                            $mode = $get_mode->fetch_details_group('payments', 'payment_mode', 'invoice', $detail->invoice);
                            //check if invoice is more than 1
                            $get_mode_count = new selects();
                            $rows = $get_mode_count->fetch_count_cond('payments', 'invoice', $detail->invoice);
                                if($rows >= 2){
                                    echo "Multiple payment";
                                }else{
                                    echo $mode->payment_mode;

                                }
                            ?>
                    </td>
                    <td><?php echo date("h:i:sa", strtotime($detail->post_date))?></td>
                </tr>
                <?php $n++; endforeach;}?>
            </tbody>
        </table>
        
        <?php
            if(gettype($details) == "string"){
                echo "<p class='no_result'>'$details'</p>";
            }
        ?>
    </div>
</div>
<?php 
    }else{
?>
<div class="check_out_due">
    <hr>
    <div class="daily_monthly" style="margin:0!important;padding:0!important">
        <!-- daily revenue summary -->
        <div class="daily_report allResults" style="margin:0!important;padding:0!important">
            <h3 style="background:var(--otherColor); font-family:Poppins">Scheduled Payments</h3>
            <table id="item_list_table" class="searchTable">
                <thead>
                    <tr>
                        <td>S/N</td>
                        <td>Due Date</td>
                        <td>Amount Due</td>
                        <td>Status</td>
                    </tr>
                </thead>
                <tbody id="result">
                    <?php
                        $n = 1;
                        $loans = $get_dashboard->fetch_details_2cond('loan_applications', 'customer', 'loan_status', $customer_id, 2);
                        if(is_array($loans)){
                            foreach($loans as $loan){
                                $repays = $get_dashboard->fetch_details_2cond('repayment_schedule', 'loan', 'payment_status', $loan->loan_id, 0);
                                $allow_next = true; // True until first unpaid schedule is found
                                foreach($repays as $repay){
                        
                    ?>
                    <tr>
                        <td style="text-align:center; color:red;"><?php echo $n?></td>
                        <td><?php echo date("d-M-Y", strtotime($repay->due_date))?></td>
                        <td style="color:var(--secondaryColor)"><?php  echo "₦".number_format(($repay->amount_due - $repay->amount_paid), 2)?></td>
                        <td>
                            <?php
                                $date_due = new DateTime($repay->due_date);
                                $today = new DateTime();

                                $button = "<a style='border-radius:15px; background:var(--tertiaryColor);color:#fff; padding:3px 6px; box-shadow:1px 1px 1px #222; border:1px solid #fff' href='javascript:void(0)' onclick=\"showPage('client_payment.php?schedule={$repay->repayment_id}&customer={$customer_id}')\" title='Post payment'>Pay <i class='fas fa-hand-holding-dollar'></i></a>";

                                if($repay->payment_status == "1"){
                                    echo "<span style='color:var(--tertiaryColor);'>Paid <i class='fas fa-check-circle'></i></span>";
                                } else {
                                    // First unpaid schedule (or any overdue) is allowed to pay only if previous schedules are paid
                                    if($allow_next || $date_due < $today){
                                        if($date_due > $today){
                                            echo "<span style='color:var(--primaryColor);'><i class='fas fa-spinner'></i> Pending </span> {$button}";
                                        } else {
                                            echo "<span style='color:red;'><i class='fas fa-clock'></i> Overdue </span> {$button}";
                                        }
                                        $allow_next = false; // After showing Add Payment for one, others must wait
                                    } else {
                                        echo "<span style='color:#999;'>Waiting for previous payment <i class='fas fa-lock'></i></span>";
                                    }
                                }
                            ?>
                        </td>
                    </tr>
                    
                    <?php $n++; };}}?>
                </tbody>
            </table>
            <?php
                if(gettype($loans) == "string"){
                    echo "<p class='no_result'>'$loans'</p>";
                }
            ?>
        </div>
        <!-- monthly revenue summary -->
        <div class="monthly_report allResults" style="margin:0!important;padding:0!important">
            
            <div class="monthly_encounter" style="margin:0 0 20px; width:100%!important">
                <h3 style="background:rgb(117, 32, 12)!important; font-family:Poppins">Daily Transactions</h3>
                <table>
                    <thead>
                        <tr>
                            <td>S/N</td>
                            <td>Date</td>
                            <td>Amount</td>
                            <td>Details</td>
                        </tr>
                    </thead>
                    <?php
                        $n = 1;
                        $trxs = $get_dashboard->fetch_details_condLimitDesc('deposits', 'customer', $customer_id, 10, 'post_date');
                        if(is_array($trxs)){
                        foreach($trxs as $trx):

                    ?>
                    <tbody>
                        <tr>
                            <td><?php echo $n?></td>
                            <td style="color:var(--primaryColor)"><?php echo date("d-M-Y, h:ia", strtotime($trx->post_date))?></td>
                            <td style="text-align:center; color:green"><?php echo "₦".number_format($trx->amount)?></td>
                            <td><?php
                                echo $trx->trx_type;
                            ?></td>
                        </tr>
                    </tbody>
                    <?php $n++; endforeach; }?>

                    
                </table>
                <?php 
                    if(gettype($trxs) == "string"){
                        echo "<p class='no_result'>'$trxs'</p>";
                    }
                ?>
            </div>
           
        </div>
        
    </div>
</div>
<?php
    }
?>
</div>