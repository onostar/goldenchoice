<?php
    session_start();
    $store = $_SESSION['store_id'];
    $from = htmlspecialchars(stripslashes($_POST['from_date']));
    $to = htmlspecialchars(stripslashes($_POST['to_date']));

    // instantiate classes
    include "../classes/dbh.php";
    include "../classes/select.php";

    $get_revenue = new selects();
    $details = $get_revenue->fetch_details_date2Con('loan_applications', 'date(application_date)', $from, $to, 'store', $store);
    $n = 1;
?>
<h2>Loan Summary from '<?php echo date("jS M, Y", strtotime($from)) . "' to '" . date("jS M, Y", strtotime($to))?>'</h2>
    <hr>
    <div class="search">
        <input type="search" id="searchRevenue" placeholder="Enter keyword" onkeyup="searchData(this.value)">
        <a class="download_excel" href="javascript:void(0)" onclick="convertToExcel('data_table', 'Loan Summary report')"title="Download to excel"><i class="fas fa-file-excel"></i></a>
    </div>
    <table id="data_table" class="searchTable">
        <thead>
            <tr style="background:var(--moreColor)">
                <td>S/N</td>
                <td>Customer</td>
                <td>Product</td>
                <td>Requested Amount</td>
                <td>Total Payable</td>
                <td>Total Paid</td>
                <td>Application Date</td>
                <td>Status</td>
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
                <td>
                    <?php
                        //get product
                        $prod = $get_revenue->fetch_details_group('loan_products', 'product', 'product_id', $detail->product);
                        echo $prod->product;
                    ?>
                </td>
                <td style="color:green">
                    <?php echo "₦".number_format($detail->amount, 2);?>
                </td>
                <td style="color:red">
                    <?php echo "₦".number_format($detail->total_payable, 2);?>
                </td>
                <td>
                    <?php 
                        //get total paid
                        $paid = $get_revenue->fetch_sum_single('repayment_schedule', 'amount_paid', 'loan', $detail->loan_id);
                        if(is_array($paid)){
                            foreach($paid as $p){
                                $total_paid = $p->total;
                            }
                        }else{
                            $total_paid = 0;
                        }
                        echo "₦".number_format($total_paid, 2);
                        
                    ?>
                </td>
                <td style="color:var(--otherColor)"><?php echo date("H:i:sa", strtotime($detail->application_date));?></td>
                <td>
                    <?php
                        if($detail->loan_status == "0"){
                            echo "<span style='color:var(--primaryColor)'><i class='fas fa-spinner'></i> Under Review</span>";
                        }elseif($detail->loan_status == "-1"){
                            echo "<span style='color:red'><i class='fas fa-cancel'></i> Declined</span>";
                        }elseif($detail->loan_status == "1"){
                            echo "<span style='color:var(--otherColor)'><i class='fas fa-chart-line'></i> Approved</span>";
                        }elseif($detail->loan_status == "2"){
                            echo "<span style='color:var(--tertiaryColor)'><i class='fas fa-hand-holding-dollar'></i> Active</span>";
                        }else{
                            echo "<span style='color:var(--tertiaryColor)'><i class='fas fa-check-circle'></i> Completed</span>";

                        }
                    ?>
                </td>
                <td>
                    <a style="padding:5px; border-radius:15px;background:var(--tertiaryColor);color:#fff;"href="javascript:void(0)" onclick="showPage('view_loan_summary.php?loan=<?php echo $detail->loan_id?>')" title="view Loan details">View <i class="fas fa-eye"></i></a>
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
    //get total disbursed
    $cashs = $get_revenue->fetch_sum_2date2Cond('loan_applications', 'amount', 'date(disbursed_date)', 'loan_status', 'store', $from, $to, '2', $store);
    if(gettype($cashs) === "array"){
        foreach($cashs as $cash){
            echo "<p class='sum_amount' style='background:var(--otherColor)'><strong>Total Disbursed</strong>: ₦".number_format($cash->total, 2)."</p>";
        }
    }
    
    //get total paid
    $trfs = $get_revenue->fetch_sum_2dateCond('repayment_schedule', 'amount_paid', 'store','date(post_date)', $from, $to, $store);
    if(gettype($trfs) === "array"){
        foreach($trfs as $trf){
            echo "<p class='sum_amount' style='background:green'><strong>Total Paid</strong>: ₦".number_format($trf->total, 2)."</p>";
        }
    }
    //get total due
    $dues = $get_revenue->fetch_sum_2date2Cond('repayment_schedule', 'amount_due', 'date(post_date)', 'store', 'payment_status',$from, $to, $store, 0);
    if(is_array($dues)){
        foreach($dues as $due){
            $total_due = $due->total;
        }
    }else{
        $total_due = 0;
    }
    //get sum paid
    $pays = $get_revenue->fetch_sum_2date2Cond('repayment_schedule', 'amount_paid', 'date(post_date)', 'store', 'payment_status',$from, $to, $store, 0);
    if(is_array($pays)){
        foreach($pays as $pay){
            $paids = $pay->total;
            
        }
    }else{
        $paids = 0;
    }
    $balance = $total_due - $paids;
    echo "<p class='sum_amount' style='background:brown'><strong>Total Due</strong>: ₦".number_format($balance, 2)."</p>";

    //get total interest
    $ints = $get_revenue->fetch_sum_2dateCond('repayments', 'interest', 'store','date(post_date)', $from, $to, $store);
    if(gettype($ints) === "array"){
        foreach($ints as $int){
            echo "<p class='sum_amount' style='background:var(--primaryColor)'><strong>Total Interest</strong>: ₦".number_format($int->total, 2)."</p>";
        }
    }
    //get total processing fees
    $proc = $get_revenue->fetch_sum_2dateCond('repayments', 'processing_fee', 'store','date(post_date)', $from, $to, $store);
    if(gettype($proc) === "array"){
        foreach($proc as $pro){
            echo "<p class='sum_amount' style='background:var(--menuColor)'><strong>Processing Fees</strong>: ₦".number_format($pro->total, 2)."</p>";
        }
    }
?>
    </div>