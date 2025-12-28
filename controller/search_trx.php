<?php
    session_start();
    $store = $_SESSION['store_id'];
    $from = htmlspecialchars(stripslashes($_POST['from_date']));
    $to = htmlspecialchars(stripslashes($_POST['to_date']));
    $customer = $_SESSION['client_id'];
    // instantiate classes
    include "../classes/dbh.php";
    include "../classes/select.php";

    $get_revenue = new selects();
    $details = $get_revenue->fetch_details_date2ConOrder('deposits', 'date(post_date)', $from, $to, 'customer', $customer, 'post_date');
    $n = 1;
?>
<h2>Transaction History from '<?php echo date("jS M, Y", strtotime($from)) . "' to '" . date("jS M, Y", strtotime($to))?>'</h2>
    <hr>
    <div class="search">
        <input type="search" id="searchRevenue" placeholder="Enter keyword" onkeyup="searchData(this.value)">
        <a class="download_excel" href="javascript:void(0)" onclick="convertToExcel('data_table', 'Transaction history')"title="Download to excel"><i class="fas fa-file-excel"></i></a>
    </div>
    <table id="data_table" class="searchTable">
        <thead>
        <tr style="background:var(--moreColor)">
                <td>S/N</td>
                <td>Date</td>
                <td>Trx. Type</td>
                <td>Amount</td>
                <td>Details</td>
                <td>Posted By</td>
                
            </tr>
        </thead>
        <tbody>
<?php
    if(gettype($details) === 'array'){
    foreach($details as $detail){

?>
            <tr>
                <td><?php echo $n?></td>
                <td style="color:var(--menuColor)"><?php echo date("d-M-Y, h:i:sa", strtotime($detail->post_date))?></td>
                <td><?php echo $detail->trx_type?></td>
                <td style="color:green"><?php echo "₦".number_format($detail->amount)?></td>
                <td><?php
                    echo $detail->details;
                ?></td>
                <td>
                    <?php
                        if($detail->posted_by == $customer){
                            echo "SELF";
                        }else{
                            //get loan officer name
                            $psts = $get_revenue->fetch_details_group('users', 'full_name', 'user_id', $detail->posted_by);
                            echo $psts->full_name;
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
    ?>
    <div class="all_modes">

<?php
 //get savings deposits
    $cashs = $get_revenue->fetch_sum_2date2Cond('deposits', 'amount', 'date(post_date)', 'trx_type', 'customer', $from, $to, 'Deposit', $customer);
    if(gettype($cashs) === "array"){
        foreach($cashs as $cash){
            echo "<p class='sum_amount' style='background:var(--otherColor)'><strong><i class='fas fa-piggy-bank'></i> Savings</strong>: ₦".number_format($cash->total, 2)."</p>";
        }
    }
 //get savings deposits
    $lns = $get_revenue->fetch_sum_2date2Cond('deposits', 'amount', 'date(post_date)', 'trx_type', 'customer', $from, $to, 'Loan Repayment', $customer);
    if(gettype($lns) === "array"){
        foreach($lns as $ln){
            echo "<p class='sum_amount' style='background:brown'><strong><i class='fas fa-hand-holding-dollar'></i> Loan Payments</strong>: ₦".number_format($ln->total, 2)."</p>";
        }
    }
    //get total deposits
    $cashs = $get_revenue->fetch_sum_2dateCond('deposits', 'amount', 'customer', 'date(post_date)', $from, $to, $customer);
    if(gettype($cashs) === "array"){
        foreach($cashs as $cash){
            echo "<p class='sum_amount' style='background:var(--tertiaryColor)'><strong>Total Deposits</strong>: ₦".number_format($cash->total, 2)."</p>";
        }
    }
    
?>
    </div>