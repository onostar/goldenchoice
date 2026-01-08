<?php
    session_start();
    $store = $_SESSION['store_id'];
    $input= htmlspecialchars(stripslashes($_GET['input']));
    $user = $_SESSION['user_id'];
    $role = $_SESSION['role'];
    // instantiate class
    include "../classes/dbh.php";
    include "../classes/select.php";
    //get store details
   
    $get_customer = new selects();
    if($role == "Admin"){
        $rows = $get_customer->fetch_details_like3('customers', 'customer', 'customer_email','phone_numbers', $input);
     }else{
        $rows = $get_customer->fetch_details_like3cond('customers', 'customer', 'customer_email','phone_numbers', $input, 'cso', $user);
     }
     if(is_array($rows)){
        foreach($rows as $row):
            //check for loan status
            $loans = $get_customer->fetch_active_loan($row->customer_id);
            //check if customer has an outstanding debt
            if($row->debt_balance > 0){
        
    ?>
    <div class="results">
        <a href="javascript:void(0)" onclick="showPage('pay_outstanding.php?customer=<?php echo $row->customer_id?>')"><?php echo $row->customer?></a>
    </div>
    <?php }elseif($loans > 0){?>
    <div class="results">
        <a href="javascript:void(0)" onclick="showPage('customer_repayment.php?customer=<?php echo $row->customer_id?>')"><?php echo $row->customer?></a>
    </div>
    <?php }else{?>
    <div class="results">
        <a href="javascript:void(0)" onclick="showPage('customer_deposit.php?customer=<?php echo $row->customer_id?>')"><?php echo $row->customer?></a>
    </div>
<?php
    }
    endforeach;
     }else{
        echo "No resullt found";
     }
?>