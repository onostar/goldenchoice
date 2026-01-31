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
            <button type="submit" name="search_date" id="search_date" onclick="search('search_withdrawals.php')">Search <i class="fas fa-search"></i></button>
        </section>
    </div>
<div class="displays allResults new_data" id="revenue_report">
    <h2>Today's Savings Withdrawal</h2>
    <hr>
    <div class="search">
        <input type="search" id="searchCheckout" placeholder="Enter keyword" onkeyup="searchData(this.value)">
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
                $n = 1;
                $get_users = new selects();
                $details = $get_users->fetch_details_curdateCon('withdrawals', 'date(approved_date)', 'withdrawal_status', 1);
                if(gettype($details) === 'array'){
                foreach($details as $detail):
            ?>
            <tr>
                <td style="text-align:center; color:red;"><?php echo $n?></td>
                <td>
                    <?php
                        //get customer
                        $client = $get_users->fetch_details_group('customers', 'customer', 'customer_id', $detail->customer);
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
                            $bnks = $get_users->fetch_details_group('banks', 'bank', 'bank_id', $detail->bank);
                            echo $bnks->bank;
                        }
                    ?>
                </td>
                <td style="color:var(--moreColor)"><?php echo date("d-M-Y", strtotime($detail->post_date));?></td>
                <td>
                    <?php
                        //get posted by
                        $checkedin_by = $get_users->fetch_details_group('users', 'full_name', 'user_id', $detail->posted_by);
                        echo $checkedin_by->full_name;
                    ?>
                </td>
                <td style="color:var(--otherColor)"><?php echo date("H:i:sa", strtotime($detail->approved_date));?></td>
                <td>
                    <?php
                        //get posted by
                        $checkedin_by = $get_users->fetch_details_group('users', 'full_name', 'user_id', $detail->approved_by);
                        echo $checkedin_by->full_name;
                    ?>
                </td>
                
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
       
        // get sum
        $amounts = $get_users->fetch_sum_curdateCon('withdrawals', 'amount', 'approved_date', 'withdrawal_status', 1);
        foreach($amounts as $amount){
            $paid_amount = $amount->total;
            
        }
        echo "<p class='sum_amount' style='background:green; margin-left:100px;'><strong>Total Wihdrawal</strong>: ₦".number_format($paid_amount, 2)."</p>";
        
    ?>
    </div>
</div>

<script src="../jquery.js"></script>
<script src="../script.js"></script>