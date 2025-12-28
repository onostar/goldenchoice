<?php
    session_start();
    $store = $_SESSION['store_id'];
    include "../classes/dbh.php";
    include "../classes/select.php";
    if(isset($_GET['cashier']) && isset($_GET['from']) && isset($_GET['to'])){
        $cashier = $_GET['cashier'];
        $from = $_GET['from'];
        $to = $_GET['to'];
        //get cahsier
        $get_cashier = new selects();
        $users = $get_cashier->fetch_details_cond('users', 'user_id', $cashier);
        foreach($users as $user){
            $cashier_name = $user->full_name;
        }
?>
<div id="revenueReport" class="displays management" style="margin:0!Important">
<div class="displays allResults new_data" id="revenue_report">
    <h2>Payments Posted by <?php echo $cashier_name?></h2>
    <hr>
    <div class="search">
        <input type="search" id="searchCheckout" placeholder="Enter keyword" onkeyup="searchData(this.value)">
        <a class="download_excel" href="javascript:void(0)" onclick="convertToExcel('data_table', 'Payment report for <?php echo $cashier_name?>')"title="Download to excel"><i class="fas fa-file-excel"></i></a>
        <a href="javascript:void(0)" style="background:brown;padding:5px;border-radius:10px;color:#fff;box-shadow:1px 1px 1px #222" title="return to cashier report" onclick="showPage('cashier_report.php')"><i class="fas fa-close"></i> Close</a>
    </div>
    <table id="data_table" class="searchTable">
        <thead>
            <tr style="background:var(--primaryColor)">
                <td>S/N</td>
                <td>Invoice</td>
                <td>Customer</td>
		        <td>Trx. Type</td>
                <td>Amount</td>
                <td>Payment Mode</td>
                <td>Post Time</td>
                
            </tr>
        </thead>
        <tbody>
            <?php
                $n = 1;
                $get_users = new selects();
                $details = $get_users->fetch_details_2dateCon('deposits', 'posted_by', 'date(post_date)', $from, $to, $cashier);
                if(gettype($details) === 'array'){
                foreach($details as $detail):
            ?>
            <tr>
                <td style="text-align:center; color:red;"><?php echo $n?></td>
                <td><a style="color:green" href="javascript:void(0)"><?php echo $detail->invoice?></a></td>
                <td>
		            <?php
                        //get item name
                        $names = $get_users->fetch_details_group('customers', 'customer', 'customer_id', $detail->customer);
                        echo $names->customer;
                    ?>
                </td>
                <td><?php echo $detail->trx_type?></td>
                <td style="color:var(--secondaryColor)">
                    <?php 
                        echo "₦".number_format($detail->amount, 2)
                    ?>
                </td>
                <td>
                    <?php
                        echo $detail->payment_mode;
                    ?>
                </td>
                <td style="color:var(--moreColor)"><?php echo date("H:i:sa", strtotime($detail->post_date));?></td>
                
            </tr>
            <?php $n++; endforeach;}?>
        </tbody>
    </table>
    
    <?php
        if(gettype($details) == "string"){
            echo "<p class='no_result'>'$details'</p>";
        }
    ?>
        <!-- <div class="all_amounts"> -->
            <div class="all_modes">
    <?php
       //get cash
        $cashs = $get_cashier->fetch_sum_2date2Cond('deposits', 'amount', 'date(post_date)', 'payment_mode', 'Posted_by', $from, $to, 'Cash', $cashier);
        if(gettype($cashs) === "array"){
            foreach($cashs as $cash){
                echo "<p class='sum_amount' style='background:var(--otherColor)' onclick='showPage('cash_list.php')'><strong>Cash</strong>: ₦".number_format($cash->total, 2)."</p>";
            }
        }
        //get POS
        $poss = $get_cashier->fetch_sum_2date2Cond('deposits', 'amount', 'date(post_date)', 'payment_mode', 'posted_by', $from, $to, 'POS', $cashier);
        if(gettype($poss) === "array"){
            foreach($poss as $pos){
                echo "<p class='sum_amount' style='background:var(--secondaryColor)' onclick='showPage('pos_list.php')'><strong>POS</strong>: ₦".number_format($pos->total, 2)."</p>";
            }
        }
        //get transfer
        $trfs = $get_cashier->fetch_sum_2date2Cond('deposits', 'amount', 'date(post_date)', 'payment_mode', 'posted_by', $from, $to, 'Transfer', $cashier);
        if(gettype($trfs) === "array"){
            foreach($trfs as $trf){
                echo "<p class='sum_amount' style='background:var(--primaryColor)' onclick='showPage('transfer_list.php')'><strong>Transfer</strong>: ₦".number_format($trf->total, 2)."</p>";
            }
        }
        // get sum
        $amounts = $get_cashier->fetch_sum_2dateCond('deposits', 'amount', 'posted_by', 'date(post_date)', $from, $to, $cashier);
        foreach($amounts as $amount){
            echo "<p class='sum_amount' style='background:green; margin-left:250px; font-size:.8rem;'><strong>Total</strong>: ₦".number_format($amount->total, 2)."</p>";
        }
        ?>
            <!-- </div> -->
            <!-- <div class="all_total"> -->
        <?php
            
    ?>
            <!-- </div> -->
        </div>
</div>

<?php }?>
<script src="../jquery.js"></script>
<script src="../script.js"></script>