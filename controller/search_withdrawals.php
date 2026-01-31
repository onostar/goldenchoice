<?php
    session_start();
    $store = $_SESSION['store_id'];
    $from = htmlspecialchars(stripslashes($_POST['from_date']));
    $to = htmlspecialchars(stripslashes($_POST['to_date']));

    // instantiate classes
    include "../classes/dbh.php";
    include "../classes/select.php";

    $get_revenue = new selects();
    $details = $get_revenue->fetch_details_date2Con('withdrawals', 'date(approved_date)', $from, $to, 'withdrawal_status', 1);
    $n = 1;
?>
<h2>Savings Withdrawals between '<?php echo date("jS M, Y", strtotime($from)) . "' and '" . date("jS M, Y", strtotime($to))?>'</h2>
    <hr>
    <div class="search">
        <input type="search" id="searchRevenue" placeholder="Enter keyword" onkeyup="searchData(this.value)">
        <a class="download_excel" href="javascript:void(0)" onclick="convertToExcel('data_table', 'Savings withdrawal report')"title="Download to excel"><i class="fas fa-file-excel"></i></a>
    </div>
    <table id="data_table" class="searchTable">
        <thead>
            <tr style="background:var(--primaryColor)">
                <td>S/N</td>
                <td>Customer</td>
                <td>Trx. No.</td>
                <td>Amount</td>
                <td>Payment Mode</td>
                <td>Bank</td>
                <td>Applied</td>
                <td>Posted By</td>
                <td>Approved</td>
                <td>Approved by</td>
                
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
                <td style="color:green"><?php echo $detail->trx_number?></td>
                <td>
                    <?php echo "₦".number_format($detail->amount, 2);?>
                </td>
                <td>
                    <?php echo $detail->mode?>
                </td>
                <td>
                    <?php
                        if($detail->bank == 0){
                            echo "Cash Account";
                        }else{
                            //get bank name
                            $bnks = $get_revenue->fetch_details_group('banks', 'bank', 'bank_id', $detail->bank);
                            echo $bnks->bank;
                        }
                    ?>
                </td>
                <td style="color:var(--moreColor)"><?php echo date("d-M-Y", strtotime($detail->post_date));?></td>
                <td>
                    <?php
                        //get posted by
                        $checkedin_by = $get_revenue->fetch_details_group('users', 'full_name', 'user_id', $detail->posted_by);
                        echo $checkedin_by->full_name;
                    ?>
                </td>
                <td style="color:var(--otherColor)"><?php echo date("H:i:sa", strtotime($detail->approved_date));?></td>
                <td>
                    <?php
                        //get posted by
                        $checkedin_by = $get_revenue->fetch_details_group('users', 'full_name', 'user_id', $detail->approved_by);
                        echo $checkedin_by->full_name;
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
    
    // get sum
    $amounts = $get_revenue->fetch_sum_2dateCond('withdrawals', 'amount', 'withdrawal_status', 'date(approved_date)', $from, $to, 1);
    foreach($amounts as $amount){
        echo "<p class='sum_amount' style='background:green; margin-left:250px; font-size:.8rem;'><strong>Total Withdrawal</strong>: ₦".number_format($amount->total, 2)."</p>";
    }
?>
    </div>