<?php
    session_start();
    date_default_timezone_set("Africa/Lagos");
    $store = $_SESSION['store_id'];
    $customer = htmlspecialchars(stripslashes($_POST['customer']));
    $posted_by = htmlspecialchars(stripslashes($_POST['posted_by']));
    $invoice = htmlspecialchars(stripslashes($_POST['invoice']));
    $amount = htmlspecialchars(stripslashes($_POST['price']));
    $quantity = htmlspecialchars(stripslashes($_POST['quantity']));
    $service_order = htmlspecialchars(stripslashes($_POST['service_order']));
    $manual_invoice = htmlspecialchars(stripslashes($_POST['manual_invoice']));
    $total_amount = $amount * $quantity;
    $details = strtoupper(htmlspecialchars(stripslashes($_POST['details'])));
    $date = date("Y-m-d H:i:s");
    $data = array(
        'customer' => $customer,
        'posted_by' => $posted_by,
        'invoice' => $invoice,
        'manual_invoice' => $manual_invoice,
        'service_order' => $service_order,
        'details' => $details,
        'price' => $amount,
        'quantity' => $quantity,
        'total_amount' => $total_amount,
        'post_date' => $date,
        'store' => $store
    );
    // instantiate class
    include "../classes/dbh.php";
    include "../classes/select.php";
    include "../classes/inserts.php";

    //get customer details
    $get_customer = new selects();
    $rowss = $get_customer->fetch_details_cond('customers', 'customer_id', $customer);
    foreach($rowss as $rows){
        $customer_name = $rows->customer;
    }
   //check if details exists
   $check = new selects();
   $results = $check->fetch_count_2cond('invoices', 'details', $details, 'invoice', $invoice);
   if($results > 0){
       echo "<p class='exist'>This item already exists for this invoice!</p>";
    include "invoice_details.php";
   }else{
       //create customer
       $add_data = new add_data('invoices', $data);
       $add_data->create_data();
       if($add_data){
?>
<div class="notify"><p>Item added to Invoice order</p></div>   

<?php
    include "invoice_details.php";
       }
   }