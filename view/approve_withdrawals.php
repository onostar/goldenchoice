<div id="loan_applications">
<?php
session_start();
    include "../classes/dbh.php";
    include "../classes/select.php";
    //pagination

    //get user
    if(isset($_SESSION['user'])){
        $username = $_SESSION['user'];
        //get user role
        $get_role = new selects();
        $roles = $get_role->fetch_details_group('users', 'user_role', 'username', $username);
        $role = $roles->user_role;

?>
<style>
    @media screen and (max-width: 800px){
        table td{
            font-size:.75rem!important;
        }
    }
</style>
    <div class="info"></div>
<div class="displays allResults">
    
    <h2>Pending Withdrawal Requests</h2>
    <hr>
    <div class="search">
        <input type="search" id="searchRoom" placeholder="Enter keyword" onkeyup="searchItems(this.value, 'search_patients.php')">
        <a class="download_excel" href="javascript:void(0)" onclick="convertToExcel('item_list_table', 'Pending Withdrawal Requests')"title="Download to excel"><i class="fas fa-file-excel"></i></a>
    </div>
    <table id="item_list_table" class="searchTable">
        <thead>
            <tr style="background:var(--otherColor)">
                <td>S/N</td>
                <td>Client name</td>
                <td>Phone number</td>
                <td>Amount</td>
                <td>Type</td>
                <td>Posted By</td>
                <td>Date</td>
                <td></td>
            </tr>
        </thead>
        <tbody id="result">
        <?php
                $n = 1;
                $get_items = new selects();
                $details = $get_items->fetch_details_condOrder('withdrawals', 'withdrawal_status', 0, 'post_date');
                if(gettype($details) === 'array'){
                foreach($details as $detail):
                    //get customer details
                    $cus = $get_items->fetch_details_cond('customers', 'customer_id', $detail->customer);
                    foreach($cus as $cu){
                        $customer_name = $cu->customer;
                        $acn = $cu->acn;
                        $phone = $cu->phone_numbers;
                    }
                    
            ?>
            <tr>
                <td style="text-align:center; color:red;"><?php echo $n?></td>
                <td><?php echo $customer_name?></td>
                <td><?php echo $phone?></td>
                
                <td style="color:green">
                    <?php 
                        echo "₦".number_format($detail->amount, 2);
                    ?>
                </td>
                <td>
                    <?php 
                        echo $detail->savings_type;
                    ?>
                </td>
                <td>
                    <?php
                        $pstd = $get_items->fetch_details_group('users', 'full_name', 'user_id', $detail->posted_by);
                        echo $pstd->full_name;
                    ?>
                </td>
                <td><?php echo date("d-m-Y, h:ia", strtotime($detail->post_date))?></td>
                <td>
                    <a style="padding:5px; border-radius:15px;background:var(--tertiaryColor);color:#fff; border:1px solid #fff; box-shadow:1px 1px 1px #222"href="javascript:void(0)" onclick="showPage('approve_withdrawal_request.php?withdrawal=<?php echo $detail->withdrawal_id?>&customer=<?php echo $detail->customer?>')" title="Approve withdrawal">Approve <i class="fas fa-hand-holding-dollar"></i></a>
                    <a style="padding:5px; border-radius:15px;background:brown;color:#fff; border:1px solid #fff; box-shadow:1px 1px 1px #222"href="javascript:void(0)" onclick="declineWithdrawal('<?php echo $detail->withdrawal_id?>')" title="Decline withdrawal">Decline <i class="fas fa-close"></i></a>
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
</div>
<?php }?>
</div>