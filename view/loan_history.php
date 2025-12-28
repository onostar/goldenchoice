<div id="disburse">
<?php
session_start();
    include "../classes/dbh.php";
    include "../classes/select.php";
    //pagination

    //get user
    if(isset($_SESSION['user'])){
        $username = $_SESSION['user'];
        $user = $_SESSION['user_id'];
        //get user role
        $get_role = new selects();
        $roles = $get_role->fetch_details_group('users', 'user_role', 'username', $username);
        $role = $roles->user_role;
        //get customer details
        $get_customer = new selects();
        $rows = $get_customer->fetch_details_cond('customers', 'user_id', $user);
        foreach($rows as $row){
            $customer_id = $row->customer_id;
            $client = $row->customer;
        }

?>
    <div class="info"></div>
<div class="displays allResults">
    
    <h2>Loan Records</h2>
    <hr>
    <div class="search">
        <input type="search" id="searchRoom" placeholder="Enter keyword" onkeyup="searchItems(this.value, 'search_patients.php')">
        <a class="download_excel" href="javascript:void(0)" onclick="convertToExcel('item_list_table', 'Loan History')"title="Download to excel"><i class="fas fa-file-excel"></i></a>
    </div>
    <table id="item_list_table" class="searchTable">
        <thead>
            <tr style="background:var(--tertiaryColor)">
                <td>S/N</td>
                <td>Loan Product</td>
                <td>Amount Requested</td>
                <td>Total Repayable</td>
                <td>Application Date</td>
                <td>Status</td>
                <td></td>
            </tr>
        </thead>
        <tbody id="result">
        <?php
                $n = 1;
                $get_items = new selects();
                $details = $get_items->fetch_details_condOrder('loan_applications', 'customer', $customer_id, 'application_date');
                if(gettype($details) === 'array'){
                foreach($details as $detail):
                    
                    
            ?>
            <tr>
                <td style="text-align:center; color:red;"><?php echo $n?></td>
                <td>
                    <?php 
                        //get product details
                        $prods = $get_items->fetch_details_cond('loan_products', 'product_id', $detail->product);
                        foreach($prods as $prod){
                            $product_name = $prod->product;
                        }
                        echo $product_name;
                        ?>
                </td>
                
                <td>
                    <?php 
                        echo "₦".number_format($detail->amount, 2);
                    ?>
                </td>
                <td>
                    <?php 
                        echo "₦".number_format($detail->total_payable, 2);
                    ?>
                </td>
                
                <td style="color:var(--primaryColor)"><?php echo date("d-M-Y", strtotime($detail->application_date))?></td>
                <td>
                    <?php
                        if($detail->loan_status == "0"){
                            echo "<span style='color:var(--primaryColor)'><i class='fas fa-spinner'></i> Under Review</span>";
                        }elseif($detail->loan_status == "-1"){
                            echo "<span style='color:red'><i class='fas fa-cancel'></i> Declined</span>";
                        }elseif($detail->loan_status == "1"){
                            echo "<span style='color:var(--otherColor)'><i class='fas fa-hand-holding-dollar'></i> Approved</span>";
                        }elseif($detail->loan_status == "2"){
                            echo "<span style='color:var(--tertiaryColor)'><i class='fas fa-chart-line'></i> Active</span>";
                        }else{
                            echo "<span style='color:var(--tertiaryColor)'><i class='fas fa-check-circle'></i> Completed</span>";

                        }
                    ?>
                </td>
                <td>
                    <a style="padding:5px; border-radius:15px;background:var(--tertiaryColor);color:#fff;"href="javascript:void(0)" onclick="showPage('view_customer_loan.php?loan=<?php echo $detail->loan_id?>')" title="view Loan details">View <i class="fas fa-eye"></i></a>
                </td>
            </tr>
            
            <?php $n++; endforeach;}?>
        </tbody>
    </table>
                        
    <?php
        
        if(gettype($details) == "string"){
            echo "<p class='no_result'>'$details'</p>";
        }
        //get total due
        if($role == "Admin" || $role == "Accountant"){
            $tls = $get_items->fetch_sum_single('repayment_schedule', 'amount_due', 'payment_status', 0);
            foreach($tls as $tl){
                $total_due = $tl->total;
            }
            //get total paid
            $paids = $get_items->fetch_sum_single('repayment_schedule', 'amount_paid', 'payment_status', 0);
            foreach($paids as $paid){
                $total_paid = $paid->total;
            }
            $balance = $total_due - $total_paid;
            echo "<p class='total_amount' style='background:red; color:#fff; text-decoration:none; width:auto; float:right; padding:10px;font-size:1rem;'>Total Due: ₦".number_format($balance, 2)."</p>";
        }
    ?>
</div>
<?php }?>
</div>