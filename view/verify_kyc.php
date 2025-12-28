<?php
session_start();
    include "../classes/dbh.php";
    include "../classes/select.php";
    
    //get user
    if(isset($_SESSION['user'])){
        $username = $_SESSION['user'];
        $user = $_SESSION['user_id'];
        //get user role
        $get_role = new selects();
        $roles = $get_role->fetch_details_group('users', 'user_role', 'username', $username);
        $role = $roles->user_role;

?>
   
    <div class="info"></div>
<div class="displays allResults" id="kyc_details">
    
    <h2 style="text-align:left;color:var(--secondaryColor); margin:0!important; padding:0;font-size:1rem">Pending KYC verifications</h2>
    <hr style="margin-top:0">
    <div class="search">
        <input type="search" id="searchRoom" placeholder="Enter keyword" onkeyup="searchData(this.value)">
        <a class="download_excel" href="javascript:void(0)" onclick="convertToExcel('item_list_table', 'KYC Verifications')"title="Download to excel"><i class="fas fa-file-excel"></i></a>
    </div>
    <table id="item_list_table" class="searchTable">
        <thead>
            <tr style="background:var(--moreColor)">
                <td>S/N</td>
                <td>Date</td>
                <td>Time</td>
                <td>Client</td>
                <td>Ledger No</td>
                <td>Age</td>
                <td>Gender</td>
                <td></td>
            </tr>
        </thead>
        <tbody id="result">
        <?php
                $n = 1;
                $get_items = new selects();
                $details = $get_items->fetch_details_cond('kyc', 'verification', 0);
                if(gettype($details) === 'array'){
                foreach($details as $detail):
                    //get client details
                    $get_name = new selects();
                    $names = $get_name->fetch_details_cond('customers', 'customer_id', $detail->customer);
                    foreach($names as $name){
                        $customer = $name->customer;
                        $phone = $name->phone_numbers;
                        $ledger = $name->acn;
                        $gender = $name->gender;
                        $dob = $name->dob;
                    }
            ?>
            <tr>
                <td style="text-align:center; color:red;"><?php echo $n?></td>
                <td style="color:var(--otherColor)"><?php echo date("d-m-Y", strtotime($detail->kyc_date))?></td>
                <td style="color:var(--moreColor)"><?php echo date("h:i:sa", strtotime($detail->kyc_date))?></td>
                <td>
                    <?php 
                        echo $customer;
                    ?>
                </td>
                <td style="color:var(--moreColor)"><?php echo $ledger?></td>
                
                <td style="color:red">
                    <?php
                        $date = new DateTime($dob);
                        $now = new DateTime();
                        $interval = $now->diff($date);
                        echo $interval->y."year(s)";
                    ?>
                </td>
                <td><?php echo $gender?></td>
                
                <td>
                    <a style="border:1px solid #fff; background:var(--tertiaryColor); color:#fff; padding:5px;border-radius:30px; box-shadow:1px 1px 1px #cdcdcd" href="javascript:void(0)" onclick="showPage('view_kyc.php?kyc=<?php echo $detail->kyc_id?>')" title="View KYC details">View <i class="fas fa-eye"></i></a>
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