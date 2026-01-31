
<?php
session_start();
    include "../classes/dbh.php";
    include "../classes/select.php";
    
    //get user
    if(isset($_SESSION['user'])){
        $username = $_SESSION['user'];
        $cso = $_SESSION['user_id'];
        //get user role
        $get_role = new selects();
        $roles = $get_role->fetch_details_group('users', 'user_role', 'username', $username);
        $role = $roles->user_role;

?>
   
    <div class="info"></div>
<div class="displays allResults" id="bar_items">
    <h2>Post Savings For Customer</h2>
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
                <td>Ledger No.</td>
                <td>Phone number</td>
                <td>Address</td>
                <td>Account Balance</td>
                 <?php if($role == "Admin"){?>
                <td>CSO</td>
                <?php }?>
                <td>Date reg</td>
                <td></td>
            </tr>
        </thead>
        <tbody id="result">
        <?php
                $n = 1;
                $get_items = new selects();
                if($role == "Admin"){
                    $details = $get_items->fetch_details_Order('customers', 'customer');
                }else{
                $details = $get_items->fetch_details_condOrder('customers', 'cso', $cso, 'customer');
                }
                if(gettype($details) === 'array'){
                foreach($details as $detail):
            ?>
            <tr>
                <td style="text-align:center; color:red;"><?php echo $n?></td>
                <td><?php echo $detail->customer?></td>
                <td><?php echo $detail->acn?></td>
                <td><?php echo $detail->phone_numbers?></td>
                <td><?php echo $detail->customer_address?></td>

                <td style="color:green"><?php echo number_format($detail->wallet_balance, 2)?></td>
               <?php if($role == "Admin"){?>
                <td>
                    <?php
                        //get cso name
                        $get_cso = new selects();
                        $csos = $get_cso->fetch_details_cond('users', 'user_id', $detail->cso);
                        if(is_array($csos)){
                            foreach($csos as $cso){
                                $full_name = $cso->full_name;
                            }
                        }else{
                            $full_name = "N/A";
                        }
                        echo $full_name;
                    ?>
                </td>
                <?php }?>
                <td><?php echo date("d-M-Y", strtotime($detail->reg_date))?></td>
                <td>
                    
                    <a style="padding:5px; border-radius:15px;background:var(--otherColor);color:#fff;"href="javascript:void(0)" onclick="showPage('customer_deposit.php?customer=<?php echo $detail->customer_id?>')" title="Pay outstanding debt">Post <i class="fas fa-hand-holding-dollar"></i></a>
                   <!-- <a style="padding:5px; border-radius:15px;background:var(--tertiaryColor);color:#fff;"href="javascript:void(0)" onclick="showPage('view_customer_details.php?customer=<?php echo $detail->customer_id?>')" title="view customer details">view <i class="fas fa-eye"></i></a> -->
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