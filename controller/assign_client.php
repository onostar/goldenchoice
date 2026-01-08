<?php
    session_start();    
    // if(isset($_POST['change_prize'])){
        $customer = htmlspecialchars(stripslashes($_POST['customer_id']));
        $cso = htmlspecialchars(stripslashes($_POST['cso']));

        // instantiate classes
        include "../classes/dbh.php";
        include "../classes/update.php";
        include "../classes/select.php";

        //get customer name
        $get_name = new selects();
        $row = $get_name->fetch_details_group('customers', 'customer', 'customer_id', $customer);
        $item_name = $row->customer;
        //get cso name
        $get_cso = $get_name->fetch_details_group('users', 'full_name', 'user_id', $cso);
        $cso_name = $get_cso->full_name;
        //assign cso
        $change_level = new Update_table();
        $change_level->update('customers', 'cso', 'customer_id', $cso, $customer);
        if($change_level){
             echo "<div class='success'><p style='color:#fff'>$item_name's assigned to $cso_name successfully! <i class='fas fa-thumbs-up'></i></p></div>";
        }else{
            echo "<p style='background:red; color:#fff; padding:5px'>Failed to modify role <i class='fas fa-thumbs-down'></i></p>";
        }
    // }