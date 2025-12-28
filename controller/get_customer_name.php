<?php
    session_start();
    $input= htmlspecialchars(stripslashes($_POST['customer']));
    $invoice= htmlspecialchars(stripslashes($_POST['invoice']));
    // instantiate class
    include "../classes/dbh.php";
    include "../classes/select.php";
    //first check invoice in sales
    $get_invoice = new selects();
    $invs = $get_invoice->fetch_details_cond('sales', 'invoice', $invoice);
    if(is_array($invs)){
        echo "<script>
            alert('Invoice already in use.Cannot proceed!');
        </script>";
    }else{
        $get_customer = new selects();
        $rows = $get_customer->fetch_details_like2Cond('customers', 'customer', 'phone_numbers', $input);
        if(is_array($rows)){
            foreach($rows as $row){
            
        ?>
        <div class="results">
            <a href="javascript:void(0)" onclick="showPage('wholesale_order.php?customer=<?php echo $row->customer_id?>&invoice=<?php echo $invoice?>')"><?php echo $row->customer?></a>
        </div>
        <?php
            }

        }else{
            echo "No resullt found";
        }
    }
?>