<?php
     session_start();
    if(isset($_SESSION['user_id'])){
        $user = $_SESSION['user_id'];
    include "../classes/dbh.php";
    include "../classes/select.php";
    //get customer details
    $get_customer = new selects();
    $rows = $get_customer->fetch_details_cond('customers', 'user_id', $user);
    foreach($rows as $row){
        $customer_id = $row->customer_id;
        $client = $row->customer;
    }


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
            <button type="submit" name="search_date" id="search_date" onclick="search('search_trx.php')">Search <i class="fas fa-search"></i></button>
        </section>
    </div>
<div class="displays allResults new_data" id="revenue_report">
    <h2>My Transaction History</h2>
    <hr>
    <div class="search">
        <input type="search" id="searchCheckout" placeholder="Enter keyword" onkeyup="searchData(this.value)">
        <a class="download_excel" href="javascript:void(0)" onclick="convertToExcel('data_table', 'Transaction History')"title="Download to excel"><i class="fas fa-file-excel"></i></a>
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
        <?php
            $n = 1;
            $trxs = $get_customer->fetch_details_curdateConOrder('deposits', 'post_date', 'customer', $customer_id, 'post_date');
            if(is_array($trxs)){
            foreach($trxs as $trx):

        ?>
        <tbody>
            <tr>
                <td><?php echo $n?></td>
                <td style="color:var(--menuColor)"><?php echo date("d-M-Y, h:i:sa", strtotime($trx->post_date))?></td>
                <td><?php echo $trx->trx_type?></td>
                <td style="color:green"><?php echo "₦".number_format($trx->amount)?></td>
                <td><?php
                    echo $trx->details;
                ?></td>
                <td>
                    <?php
                        if($trx->posted_by == $customer_id){
                            echo "SELF";
                        }else{
                            //get loan officer name
                            $psts = $get_customer->fetch_details_group('users', 'full_name', 'user_id', $trx->posted_by);
                            echo $psts->full_name;
                        }
                    ?>
                </td>
            </tr>
        </tbody>
        <?php $n++; endforeach; }?>

        
    </table>
    <?php
        if(gettype($trxs) == "string"){
            echo "<p class='no_result'>'$trxs'</p>";
        }
    ?>
       <div class="all_modes">
    <?php
        //get savings deposits
        $trfs = $get_customer->fetch_sum_curdate2Con('deposits', 'amount', 'post_date', 'trx_type', 'Deposit', 'customer', $customer_id);
        if(gettype($trfs) === "array"){
            foreach($trfs as $trf){
                ?>
                <a href="javascript:void(0)" class="sum_amount" style="background:var(--otherColor)"><strong><i class="fas fa-piggy-bank"></i> Savings</strong>: ₦<?php echo number_format($trf->total, 2)?></a>
                <?php
            }
        }
        //get loan repayments
        $trfs = $get_customer->fetch_sum_curdate2Con('deposits', 'amount', 'post_date', 'trx_type', 'Loan Repayment', 'customer', $customer_id);
        if(gettype($trfs) === "array"){
            foreach($trfs as $trf){
                ?>
                <a href="javascript:void(0)" class="sum_amount" style="background:brown"><strong><i class="fas fa-hand-holding-dollar"></i> Loan Payments</strong>: ₦<?php echo number_format($trf->total, 2)?></a>
                <?php
            }
        }
        //get total deposits
        $cashs = $get_customer->fetch_sum_curdateCon('deposits', 'amount', 'post_date', 'customer', $customer_id);
        if(gettype($cashs) === "array"){
            foreach($cashs as $cash){
                ?>
                <a href="javascript:void(0)" class="sum_amount" style="background:var(--tertiaryColor)"><strong>Total Deposits</strong>: ₦<?php echo number_format($cash->total, 2)?></a>

                <?php
            }
        }
       
        
        
    ?>
    </div>
</div>

<script src="../jquery.js"></script>
<script src="../script.js"></script>
<?php
    }else{
        header("Location: ../index.php");
    }
?>