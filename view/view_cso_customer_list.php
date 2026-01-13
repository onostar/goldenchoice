
<?php
session_start();
    include "../classes/dbh.php";
    include "../classes/select.php";
    
    //get user
    if(isset($_SESSION['user'])){
        $username = $_SESSION['user'];
        if(isset($_GET['cso'])){
            $cso = $_GET['cso'];
        //get cso name
        $get_cso = new selects();
        $cso_details = $get_cso->fetch_details_cond('users', 'user_id', $cso);
        foreach($cso_details as $csod){
            $cso_name = $csod->full_name;
        }


?>
   
    <div class="info"></div>
<div class="displays allResults" id="bar_items">
    
    <h2>Customer List for <?php echo $cso_name?> <a href="javascript:void(0)" onclick="showPage('cso_customer_list.php')" style="background:brown;color:#fff; padding:5px; border-radius:15px; box-shadow:1px 1px 1px #222; border:1px solid #fff; font-size:.8rem" title="Back to cso lists"><i class="fas fa-angle-double-left"></i> Back to CSO List</a></h2>
    <hr>
    <div class="search">
        <input type="search" id="searchRoom" placeholder="Enter keyword" onkeyup="searchData(this.value)">
        <a class="download_excel" href="javascript:void(0)" onclick="convertToExcel('item_list_table', 'List of Clients')"title="Download to excel"><i class="fas fa-file-excel"></i></a>
    </div>
    <table id="item_list_table" class="searchTable">
        <thead>
            <tr style="background:var(--moreColor)">
                <td>S/N</td>
                <td>Client name</td>
                <!-- <td>Ledger No.</td> -->
                <td>Phone number</td>
                <td>Address</td>
                <td>Savings</td>
                <td>Loan</td>
                <td>Prev. Debt</td>
                <td>Date reg</td>
                <!-- <td></td> -->
            </tr>
        </thead>
        <tbody id="result">
        <?php
                $n = 1;
                $get_items = new selects();
                $details = $get_items->fetch_details_condOrder('customers', 'cso', $cso, 'customer');
                if(gettype($details) === 'array'){
                foreach($details as $detail):
            ?>
            <tr>
                <td style="text-align:center; color:red;"><?php echo $n?></td>
                <td><?php echo $detail->customer?></td>
                <!-- <td><?php echo $detail->acn?></td> -->
                <td><?php echo $detail->phone_numbers?></td>
                <td><?php echo $detail->customer_address?></td>
                <!-- <td><?php echo $detail->customer_email?></td> -->
                <td style="color:green"><?php echo number_format($detail->wallet_balance, 2)?></td>
                <td>
                    <?php
                        //get total loan due
                       //get total due
                    $tls = $get_items->fetch_sum_single('repayment_schedule', 'amount_due', 'customer', $detail->customer);
                    foreach($tls as $tl){
                        $total_due = $tl->total;
                    }
                    //get total paid
                    $paids = $get_items->fetch_sum_single('repayment_schedule', 'amount_paid', 'customer', $detail->customer);
                    foreach($paids as $paid){
                        $total_paid = $paid->total;
                    }
                    $balance = $total_due - $total_paid;
                    echo number_format($balance, 2);
                    ?>
                    
                </td>
                <td style="color:red"><?php echo number_format($detail->debt_balance, 2)?></td>

                <td><?php echo date("d-M-Y", strtotime($detail->reg_date))?></td>
                <!-- <td>
                    <a style="padding:5px; border-radius:15px;background:var(--otherColor);color:#fff;"href="javascript:void(0)" onclick="showPage('pay_outstanding.php?customer=<?php echo $detail->customer_id?>')" title="Post Savings">Savings <i class="fas fa-hand-holding-dollar"></i></a>
                    <?php if($detail->debt_balance > 0){?>
                    <a style="padding:5px; border-radius:15px;background:var(--otherColor);color:#fff;"href="javascript:void(0)" onclick="showPage('pay_outstanding.php?customer=<?php echo $detail->customer_id?>')" title="Pay outstanding debt">Pay loan <i class="fas fa-hand-holding-dollar"></i></a>
                    <?php }else{?>
                    <a style="padding:5px; border-radius:15px;background:var(--otherColor);color:#fff;"href="javascript:void(0)" onclick="showPage('customer_repayment.php?customer=<?php echo $detail->customer_id?>')"title="post loan payment">Pay loan <i class="fas fa-hand-holding-dollar"></i></a>
                    <?php } ?>
                    <a style="padding:5px; border-radius:15px;background:var(--tertiaryColor);color:#fff;"href="javascript:void(0)" onclick="showPage('view_customer_details.php?customer=<?php echo $detail->customer_id?>')" title="view patient details">view <i class="fas fa-eye"></i></a>
                </td> -->
            </tr>
            
            <?php $n++; endforeach;}?>
        </tbody>
    </table>
    
    <?php
        
        if(gettype($details) == "string"){
            echo "<p class='no_result'>'$details'</p>";
        }
    
    ?>
</div>
<?php }}?>