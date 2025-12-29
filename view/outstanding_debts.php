<?php
    session_start();
    $store = $_SESSION['store_id'];
    include "../classes/dbh.php";
    include "../classes/select.php";


?>
<style>
    @media screen and (max-width: 800px){
        table td{
            font-size:.75rem!important;
        }
    }
</style>
<div id="debt_paymentReport" class="displays management" style="width:100%!important">
    
<div class="displays allResults new_data" id="revenue_report">
    <h2>Customers Outstanding debts before go Live</h2>
    <hr>
    <div class="search">
        <input type="search" id="searchCheckout" placeholder="Enter keyword" onkeyup="searchData(this.value)">
        <a class="download_excel" href="javascript:void(0)" onclick="convertToExcel('data_table', 'Outstanding debt postings')"title="Download to excel"><i class="fas fa-file-excel"></i></a>
    </div>
    <table id="data_table" class="searchTable">
        <thead>
            <tr style="background:var(--primaryColor)">
                <td>S/N</td>
                <td>Customer</td>
                <td>Amount</td>
                
            </tr>
        </thead>
        <tbody>
            <?php
                $n = 1;
                $get_users = new selects();
                $details = $get_users->fetch_outstanding();
                if(gettype($details) === 'array'){
                foreach($details as $detail):
            ?>
            <tr>
                <td style="text-align:center; color:red;"><?php echo $n?></td>
                <td>
                    <?php
                        //get customer
                        echo $detail->customer;
                    ?>
                </td>
                <td>
                    <?php echo "₦".number_format($detail->debt_balance, 2);?>
                </td>
                
                
            </tr>
            <?php $n++; endforeach;}?>
        </tbody>
    </table>
    <div class="all_modes">
    
    <?php
        if(gettype($details) == "string"){
            echo "<p class='no_result'>'$details'</p>";
        }
       
        // get sum
        $get_total = new selects();
        $amounts = $get_total->fetch_sum_singleGreat('customers', 'debt_balance', 'debt_balance', 0);
        foreach($amounts as $amount){
            echo "<p class='total_amount' style='color:green'>Total: ₦".number_format($amount->total, 2)."</p>";
        }
    ?>
    </div>
</div>

<script src="../jquery.js"></script>
<script src="../script.js"></script>