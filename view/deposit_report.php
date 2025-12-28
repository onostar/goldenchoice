<?php
    session_start();
    $store = $_SESSION['store_id'];
    include "../classes/dbh.php";
    include "../classes/select.php";


?>
<div id="debt_paymentReport" class="displays management" style="width:100%!important">
    <div class="select_date">
        <!-- <form method="POST"> -->
        <section>    
            <div class="from_to_date">
                <label>Select From Date</label><br>
                <input type="date" name="from_date" id="from_date"><br>
            </div>
            <div class="from_to_date">
                <label>Select to Date</label><br>
                <input type="date" name="to_date" id="to_date"><br>
            </div>
            <button type="submit" name="search_date" id="search_date" onclick="search('search_deposits.php')">Search <i class="fas fa-search"></i></button>
        </section>
    </div>
<div class="displays allResults new_data" id="revenue_report">
    <h2>Todays payments</h2>
    <hr>
    <div class="search">
        <input type="search" id="searchCheckout" placeholder="Enter keyword" onkeyup="searchData(this.value)">
        <a class="download_excel" href="javascript:void(0)" onclick="convertToExcel('data_table', 'Customer Payments report')"title="Download to excel"><i class="fas fa-file-excel"></i></a>
    </div>
    <table id="data_table" class="searchTable">
        <thead>
            <tr style="background:var(--primaryColor)">
                <td>S/N</td>
                <td>Customer</td>
                <td>Trx. No.</td>
                <td>Amount</td>
                <td>Payment Mode</td>
                <td>Trans. Date</td>
                <td>Post Time</td>
                <td>Posted by</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php
                $n = 1;
                $get_users = new selects();
                $details = $get_users->fetch_details_curdateCon('deposits', 'date(post_date)', 'store', $store);
                if(gettype($details) === 'array'){
                foreach($details as $detail):
            ?>
            <tr>
                <td style="text-align:center; color:red;"><?php echo $n?></td>
                <td>
                    <?php
                        //get customer
                        $get_customer = new selects();
                        $client = $get_customer->fetch_details_group('customers', 'customer', 'customer_id', $detail->customer);
                        echo $client->customer;
                    ?>
                </td>
                <td style="color:green"><?php echo $detail->invoice?></td>
                <td>
                    <?php echo "₦".number_format($detail->amount, 2);?>
                </td>
                <td>
                    <?php echo $detail->payment_mode?>
                </td>
                <td style="color:var(--moreColor)"><?php echo date("d-m-Y", strtotime($detail->trans_date));?></td>
                <td style="color:var(--otherColor)"><?php echo date("H:i:sa", strtotime($detail->post_date));?></td>
                <td>
                    <?php
                        //get posted by
                        $checkedin_by = $get_users->fetch_details_group('users', 'full_name', 'user_id', $detail->posted_by);
                        echo $checkedin_by->full_name;
                    ?>
                </td>
                <td><a style="background:#cdcdcd; color:#222; border-radius:10px; box-shadow:1px 1px 1px #222; border:1px solid #fff; padding:4px;" href="javascript:void(0)" title="print receipt" onclick="printPaymentReceipt('<?php echo $detail->invoice?>')"><i class="fas fa-print"></i></a></td>
            </tr>
            <?php $n++; endforeach;}?>
        </tbody>
    </table>
    <?php
        if(gettype($details) == "string"){
            echo "<p class='no_result'>'$details'</p>";
        }
    ?>
       <div class="all_modes">
    <?php
        //get cash
        $cashs = $get_users->fetch_sum_curdate2Con('deposits', 'amount', 'post_date', 'payment_mode', 'Cash', 'store', $store);
        if(gettype($cashs) === "array"){
            foreach($cashs as $cash){
                ?>
                <a href="javascript:void(0)" class="sum_amount" style="background:var(--otherColor)" onclick="showPage('cash_list.php')"><strong>Cash</strong>: ₦<?php echo number_format($cash->total, 2)?></a>

                <?php
            }
        }
        //get pos
        $poss = $get_users->fetch_sum_curdate2Con('deposits', 'amount', 'post_date', 'payment_mode', 'POS', 'store', $store);
        if(gettype($poss) === "array"){
            foreach($poss as $pos){
                ?>
                <a href="javascript:void(0)" class="sum_amount" style="background:var(--secondaryColor)" onclick="showPage('pos_list.php')"><strong>POS</strong>: ₦<?php echo number_format($pos->total, 2)?></a>
                <?php
            }
        }
        //get transfer
        $trfs = $get_users->fetch_sum_curdate2Con('deposits', 'amount', 'post_date', 'payment_mode', 'Transfer', 'store', $store);
        if(gettype($trfs) === "array"){
            foreach($trfs as $trf){
                ?>
                <a href="javascript:void(0)" class="sum_amount" style="background:var(--primaryColor)" onclick="showPage('transfer_list.php')"><strong>Transfer</strong>: ₦<?php echo number_format($trf->total, 2)?></a>
                <?php
            }
        }
        // get sum
        $amounts = $get_users->fetch_sum_curdateCon('deposits', 'amount', 'post_date', 'store', $store);
        foreach($amounts as $amount){
            $paid_amount = $amount->total;
            
        }
        echo "<p class='sum_amount' style='background:green; margin-left:100px;'><strong>Total</strong>: ₦".number_format($paid_amount, 2)."</p>";
        
    ?>
    </div>
</div>

<script src="../jquery.js"></script>
<script src="../script.js"></script>