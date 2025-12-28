<?php
    session_start();
    $store = $_SESSION['store_id'];
    $item = htmlspecialchars(stripslashes($_POST['item']));
    // instantiate class
    include "../classes/dbh.php";
    include "../classes/select.php";
    //get user
    if(isset($_SESSION['user'])){
        $username = $_SESSION['user'];
        //get user role
        $get_role = new selects();
        $roles = $get_role->fetch_details_group('users', 'user_role', 'username', $username);
        $role = $roles->user_role;
    }
    $n = 1;
    $get_item = new selects();
    $details = $get_item->fetch_details_like2Cond('customers', 'customer', 'phone_numbers', $item);
     if(gettype($details) == 'array'){
        foreach($details as $detail):
           
    ?>
    <tr>
        <td style="text-align:center; color:red;"><?php echo $n?></td>
        <td><?php echo $detail->customer?></td>
        <td><?php echo $detail->acn?></td>
        <td><?php echo $detail->phone_numbers?></td>
        <!-- <td><?php echo $detail->customer_address?></td> -->
        <td><?php echo $detail->customer_email?></td>
        
        <td style="color:red">
            <?php 
                $fetch_bal = new selects();
                $bals = $fetch_bal->fetch_account_balance($detail->acn);
                foreach($bals as $bal){
                    $wallet_balance = $bal->balance;
                }
                echo "₦".number_format($wallet_balance, 2);
            ?>
        <?php /* } */?>
        </td>
        <td><?php echo date("d-m-Y", strtotime($detail->reg_date))?></td>
        
        <td>
            <a style="padding:5px; border-radius:15px;background:var(--tertiaryColor);color:#fff;"href="javascript:void(0)" onclick="showPage('view_customer_details.php?customer=<?php echo $detail->customer_id?>')" title="view patient details">view <i class="fas fa-eye"></i></a>
        </td>
    </tr>
    
<?php
        $n++; endforeach;
            
     }else{
        echo "No resullt found";
     }
?>