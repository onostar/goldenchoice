<?php
    session_start();  
    $trans_type = "remove";  
    $removed_by = $_SESSION['user_id'];
    $store = $_SESSION['store_id'];
    // if(isset($_POST['change_prize'])){
        $item = htmlspecialchars(stripslashes($_POST['item_id']));
        $quantity = htmlspecialchars(stripslashes($_POST['quantity']));
        $reason = ucwords(htmlspecialchars(stripslashes($_POST['remove_reason'])));

        // instantiate classes
        include "../classes/dbh.php";
        include "../classes/update.php";
        include "../classes/select.php";
        include "../classes/inserts.php";

    
        //get item details
        $get_name = new selects();
        $rows = $get_name->fetch_details_cond('items', 'item_id', $item);
        foreach($rows as $row){
            $item_name = $row->item_name;
        }
        //get previous quantity from inventory
        $get_qty = new selects();
        $details = $get_qty->fetch_details_2cond('inventory', 'item', 'store', $item, $store);
        foreach($details as $detail){
            $prev_qty = $detail->quantity;
        }
        if($quantity > $prev_qty){
            echo "<script>alert('Error! You cannot remove more than available quantity');
            </script>";
        }else{
            //data to insert into remove item table
            $data = array(
                'item' => $item,
                'quantity' => $quantity,
                'reason' => $reason,
                'removed_by' => $removed_by,
                'previous_qty' => $prev_qty,
                'store' => $store
            );
            //data to insert into audit trail
            $data2 = array(
                'item' => $item,
                'transaction' => $trans_type,
                'quantity' => $quantity,
                'posted_by' => $removed_by,
                'previous_qty' => $prev_qty,
                'store' => $store
            );
            //insert into audit trail
            $add_data2 = new add_data('audit_trail', $data2);
            $add_data2->create_data();
            //update quantity in inventory
            $new_qty = $prev_qty - $quantity;
            $change_qty = new Update_table();
            $change_qty->update2cond('inventory', 'quantity', 'item', 'store', $new_qty, $item, $store);
            if($change_qty){
                $add_data = new add_data('remove_items', $data);
                $add_data->create_data();
                if($add_data){
                    echo "<div class='success'><p>$quantity $item_name removed from inventory successfully! <i class='fas fa-thumbs-up'></i></p></div>";
                }
            }else{
                echo "<p style='background:red; color:#fff; padding:5px'>Failed to remove quantity <i class='fas fa-thumbs-down'></i></p>";
            }
        }