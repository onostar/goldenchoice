<?php
    session_start();
    $store = $_SESSION['store_id'];
    include "../classes/dbh.php";
    include "../classes/select.php";
    if(isset($_GET['cashier'])){
        $cashier = $_GET['cashier'];
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
                $details = $get_users->fetch_details_curdateCon('deposits', 'date(post_date)', 'posted_by', $cashier);
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
        $get_cash = new selects();
        $cashs = $get_cash->fetch_sum_curdate2Con('deposits', 'amount', 'post_date', 'payment_mode', 'Cash', 'posted_by', $cashier);
        if(gettype($cashs) === "array"){
            foreach($cashs as $cash){
                ?>
                <a href="javascript:void(0)" class="sum_amount" style="background:var(--otherColor)" onclick="showPage('cash_list.php')"><strong>Cash</strong>: ₦<?php echo number_format($cash->total, 2)?></a>

                <?php
            }
        }
        //get pos
        $get_pos = new selects();
        $poss = $get_pos->fetch_sum_curdate2Con('deposits', 'amount', 'post_date', 'payment_mode', 'POS', 'posted_by', $cashier);
        if(gettype($poss) === "array"){
            foreach($poss as $pos){
                ?>
                <a href="javascript:void(0)" class="sum_amount" style="background:var(--secondaryColor)" onclick="showPage('pos_list.php')"><strong>POS</strong>: ₦<?php echo number_format($pos->total, 2)?></a>
                <?php
            }
        }
        //get transfer
        $get_transfer = new selects();
        $trfs = $get_transfer->fetch_sum_curdate2Con('deposits', 'amount', 'post_date', 'payment_mode', 'Transfer', 'posted_by', $cashier);
        if(gettype($trfs) === "array"){
            foreach($trfs as $trf){
                ?>
                <a href="javascript:void(0)" class="sum_amount" style="background:var(--primaryColor)" onclick="showPage('transfer_list.php')"><strong>Transfer</strong>: ₦<?php echo number_format($trf->total, 2)?></a>
                <?php
            }
        }
        ?>
            <!-- </div> -->
            <!-- <div class="all_total"> -->
        <?php
        // get sum
        $get_total = new selects();
        $amounts = $get_total->fetch_sum_curdateCon('deposits', 'amount', 'post_date', 'posted_by', $cashier);
        foreach($amounts as $amount){
            $paid_amount = $amount->total;
            
        }
        
        echo "<p class='sum_amount' style='background:green; margin-left:100px;'><strong>Total</strong>: ₦".number_format($paid_amount, 2)."</p>";
            
    ?>
            <!-- </div> -->
        </div>
</div>

<?php }?>
<script src="../jquery.js"></script>
<script src="../script.js"></script>