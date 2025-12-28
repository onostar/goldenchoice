<?php
        session_start();
        $store = $_SESSION['store_id'];
        $id = htmlspecialchars(stripslashes($_POST['invoice_id']));
        $amount = htmlspecialchars(stripslashes($_POST['amount_update']));
        $quantity = htmlspecialchars(stripslashes($_POST['qty_update']));
        $details = strtoupper(htmlspecialchars(stripslashes($_POST['details_update'])));
        $invoice = htmlspecialchars(stripslashes($_POST['invoice']));
        $total_amount = $quantity * $amount;
        // instantiate classes
        include "../classes/dbh.php";
        include "../classes/select.php";
        include "../classes/update.php";
       
        //update prescription
        $update = new Update_table();
        $update->update_quadruple('invoices', 'price', $amount, 'details', $details, 'quantity', $quantity, 'total_amount', $total_amount, 'invoice_id', $id);
        // if($update){
?>
<!-- display items with same invoice number -->

<?php
    include "invoice_details.php";
            // }            
        // }
    // }
?>