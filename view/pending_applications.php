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
    
    <h2>Pending Loan Applications</h2>
    <hr>
    <div class="search">
        <input type="search" id="searchRoom" placeholder="Enter keyword" onkeyup="searchItems(this.value, 'search_patients.php')">
        <a class="download_excel" href="javascript:void(0)" onclick="convertToExcel('item_list_table', 'Pending Loan Applications')"title="Download to excel"><i class="fas fa-file-excel"></i></a>
    </div>
    <table id="item_list_table" class="searchTable">
        <thead>
            <tr style="background:var(--moreColor)">
                <td>S/N</td>
                <td>Client name</td>
                <td>Ledger No.</td>
                <td>Phone number</td>
                <td>Loan Product</td>
                <td>Amount</td>
                <td>Loan Term</td>
                <td>Date</td>
                <td></td>
            </tr>
        </thead>
        <tbody id="result">
        <?php
                $n = 1;
                $get_items = new selects();
                $details = $get_items->fetch_details_condOrder('loan_applications', 'loan_status', 0, 'application_date');
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
                <td><?php echo $acn?></td>
                <td><?php echo $phone?></td>
                <?php if($detail->asset == 0){?>
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
                <?php }else{?>
                <td>
                    <?php 
                        //get product details
                        $itms = $get_items->fetch_details_cond('items', 'item_id', $detail->asset);
                        foreach($itms as $itm){
                            $asset_name = $itm->item_name;
                        }
                        echo $asset_name;
                        ?>
                </td>
                <?php }?>
                <td style="color:red">
                    <?php 
                        echo "₦".number_format($detail->amount, 2);
                    ?>
                </td>
                <td><?php echo $detail->loan_term;?> Months</td>
                <td><?php echo date("d-m-Y, h:ia", strtotime($detail->application_date))?></td>
                <td>
                    <a style="padding:5px; border-radius:15px;background:var(--tertiaryColor);color:#fff;"href="javascript:void(0)" onclick="showPage('view_loan_details.php?loan=<?php echo $detail->loan_id?>')" title="view Loan details">view <i class="fas fa-eye"></i></a>
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