<?php
    session_start();
    $store = $_SESSION['store_id'];
    $from = htmlspecialchars(stripslashes($_POST['from_date']));
    $to = htmlspecialchars(stripslashes($_POST['to_date']));

    // instantiate classes
    include "../classes/dbh.php";
    include "../classes/select.php";

    $get_revenue = new selects();
    $details = $get_revenue->fetch_details_date2Con('deposits', 'date(post_date)', $from, $to, 'store', $store);
    $n = 1;
?>
<h2>Customer payments between '<?php echo date("jS M, Y", strtotime($from)) . "' and '" . date("jS M, Y", strtotime($to))?>'</h2>
    <hr>
    <div class="search">
        <input type="search" id="searchRevenue" placeholder="Enter keyword" onkeyup="searchData(this.value)">
        <a class="download_excel" href="javascript:void(0)" onclick="convertToExcel('data_table', 'Customer Payment report')"title="Download to excel"><i class="fas fa-file-excel"></i></a>
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
                <td>Date Posted</td>
                <td>Posted by</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
<?php
    if(gettype($details) === 'array'){
    foreach($details as $detail){

?>
            <tr>
                <td style="text-align:center; color:red;"><?php echo $n?></td>
                <td>
                    <?php
                        //get customer
                        $client = $get_revenue->fetch_details_group('customers', 'customer', 'customer_id', $detail->customer);
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
                <td style="color:var(--otherColor)"><?php echo date("d-m-Y", strtotime($detail->trans_date));?></td>
                <td style="color:var(--primaryColor)"><?php echo date("d-m-y, h:ia", strtotime($detail->post_date));?></td>
                <!-- <td style="color:var(--moreColor)"><?php echo date("H:i:sa", strtotime($detail->post_date));?></td> -->
                <td>
                    <?php
                        //get posted by
                        $checkedin_by = $get_revenue->fetch_details_group('users', 'full_name', 'user_id', $detail->posted_by);
                        echo $checkedin_by->full_name;
                    ?>
                </td>
                <td><a style="background:#cdcdcd; color:#222; border-radius:10px; box-shadow:1px 1px 1px #222; border:1px solid #fff; padding:4px;" href="javascript:void(0)" title="print receipt" onclick="printPaymentReceipt('<?php echo $detail->invoice?>')"><i class="fas fa-print"></i></a></td>
            </tr>
            <?php $n++; }}?>
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
    $cashs = $get_revenue->fetch_sum_2date2Cond('deposits', 'amount', 'date(post_date)', 'payment_mode', 'store', $from, $to, 'Cash', $store);
    if(gettype($cashs) === "array"){
        foreach($cashs as $cash){
            echo "<p class='sum_amount' style='background:var(--otherColor)' onclick='showPage('cash_list.php')'><strong>Cash</strong>: ₦".number_format($cash->total, 2)."</p>";
        }
    }
    //get POS
    $poss = $get_revenue->fetch_sum_2date2Cond('deposits', 'amount', 'date(post_date)', 'payment_mode', 'store', $from, $to, 'POS', $store);
    if(gettype($poss) === "array"){
        foreach($poss as $pos){
            echo "<p class='sum_amount' style='background:var(--secondaryColor)' onclick='showPage('pos_list.php')'><strong>POS</strong>: ₦".number_format($pos->total, 2)."</p>";
        }
    }
    //get transfer
    $trfs = $get_revenue->fetch_sum_2date2Cond('deposits', 'amount', 'date(post_date)', 'payment_mode', 'store', $from, $to, 'Transfer', $store);
    if(gettype($trfs) === "array"){
        foreach($trfs as $trf){
            echo "<p class='sum_amount' style='background:var(--primaryColor)' onclick='showPage('transfer_list.php')'><strong>Transfer</strong>: ₦".number_format($trf->total, 2)."</p>";
        }
    }
    // get sum
    $amounts = $get_revenue->fetch_sum_2dateCond('deposits', 'amount', 'store', 'date(post_date)', $from, $to, $store);
    foreach($amounts as $amount){
        echo "<p class='sum_amount' style='background:green; margin-left:250px; font-size:.8rem;'><strong>Total</strong>: ₦".number_format($amount->total, 2)."</p>";
    }
?>
    </div>