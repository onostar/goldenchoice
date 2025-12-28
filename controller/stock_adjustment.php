<?php
    session_start();
    $trans_type = "adjust";  
    $adjusted_by = $_SESSION['user_id'];
    $store = $_SESSION['store_id'];
    // if(isset($_POST['change_prize'])){
        $item = htmlspecialchars(stripslashes($_POST['item_id']));
        $quantity = htmlspecialchars(stripslashes($_POST['quantity']));

        
        // instantiate classes
        include "../classes/dbh.php";
        include "../classes/update.php";
        include "../classes/select.php";
        include "../classes/inserts.php";
        //get item quantity in inventory;
        $get_inv = new selects();
        $inv_qtys = $get_inv->fetch_details_2cond('inventory', 'item', 'store', $item, $store);
        foreach($inv_qtys as $inv_qty){
            $prev_qty = $inv_qty->quantity;
        }
        //data to insert in stock adjustment
        $data = array(
            'item' => $item,
            'adjusted_by' => $adjusted_by,
            'previous_qty' => $prev_qty,
            'new_qty' => $quantity,
            'store' => $store
        );
        //data to insert in audit trail
        $data2 = array(
            'transaction' => $trans_type,
            'item' => $item,
            'posted_by' => $adjusted_by,
            'previous_qty' => $prev_qty,
            'quantity' => $quantity,
            'store' => $store
        );
        //insert into audit trail
        $add_data2 = new add_data('audit_trail', $data2);
        $add_data2->create_data();
        //get item details
        $get_name = new selects();
        $rows = $get_name->fetch_details_cond('items', 'item_id', $item);
        foreach($rows as $row){
            $item_name = $row->item_name;
        }
        //update quantity in inventory
        $change_qty = new Update_table();
        $change_qty->update2cond('inventory', 'quantity', 'item', 'store', $quantity, $item, $store);
        if($change_qty){
            //insert into stock adjustment table
            $add_data = new add_data('stock_adjustments', $data);
            $add_data->create_data();
            if($add_data){
                echo "<div class='success'><p>$item_name quantity adjusted successfully! <i class='fas fa-thumbs-up'></i></p></div>";
            }
        }
    // }