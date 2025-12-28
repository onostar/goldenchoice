
<?php
    include "receipt_style.php";
// session_start();
// instantiate class
include "../classes/dbh.php";
include "../classes/select.php";
    session_start();
    $store = $_SESSION['store_id'];
    if(isset($_GET['receipt'])){
        $user = $_SESSION['user_id'];
        $invoice = $_GET['receipt'];
        //get store
        
        //get store name
        $get_store_name = new selects();
        $strss = $get_store_name->fetch_details_cond('stores', 'store_id', $store);
        foreach($strss as $strs){
            $store_name = $strs->store;
            $address = $strs->store_address;
            $phone = $strs->phone_number;

        }
        //get details
        $get_payment = new selects();
        $payments = $get_payment->fetch_details_cond('invoices', 'invoice', $invoice);
        foreach($payments as $payment){
            // $pay_mode = $payment->payment_mode;
            $customer = $payment->customer;
            $posted_by = $payment->posted_by;
            $paid_date = $payment->trx_date;
            $due_date = $payment->due_date;
            $service_order = $payment->service_order;
            $po_number = $payment->po_number;
            $manual_invoice = $payment->manual_invoice;
        }
    //get customer details
    $get_customer = new selects();
    $custs = $get_customer->fetch_details_cond('customers', 'customer_id', $customer);
    foreach($custs as $cust){
        $full_name = $cust->customer;
        /* $date = new DateTime($cust->dob);
        $now = new DateTime();
        $interval = $now->diff($date);
        $age = $interval->y; */
        $cust_address = $cust->customer_address;
        $cust_phone = $cust->phone_numbers;
    }   
?>
<div class="displays allResults sales_receipt">
    <?php include "invoice_header.php"?>
        
        
    </div>
    <div class="patient_details">
        <p><strong><span>Invoice: </span></strong><?php echo $manual_invoice?></p>
        <p><strong><span>Service Order: </span></strong><?php echo $service_order?></p>
        <p><strong><span>PO Number: </span></strong><?php echo $po_number?></p>

    </div>
    <div class="patient_details">
        <div class="bill_to">
            <h3>Bill To</h3>
        </div>
        <p><strong><span><?php echo $full_name?></span></strong></p>
        <p><strong><span><?php echo $cust_address?></span></strong></p>
        <p><strong><span><?php echo $cust_phone?></span></strong></p>
        <!-- <p><strong>Invoice Date:</strong> <span><?php echo date("d-m-Y", strtotime($paid_date))?></span></p> -->

    </div>
    <table id="postsales_table" class="searchTable">
        <thead>
            <tr style="background:rgba(11, 99, 134, 0.7); color:#fff">
                <td style="font-size:.8rem; text-align:center">S/N</td>
                <td style="font-size:.8rem; text-align:center">DESCRIPTION</td>
                <td style="font-size:.8rem; text-align:center">QTY</td>
                <td style="font-size:.8rem; text-align:center">UNIT PRICE</td>
                <td style="font-size:.8rem; text-align:center">TOTAL</td>
                
            </tr>
        </thead>
        <tbody>
            <?php
                $n = 1;
                $get_items = new selects();
                $details = $get_items->fetch_details_cond('invoices','invoice', $invoice);
                if(gettype($details) === 'array'){
                foreach($details as $detail):
            ?>
            <tr style="font-size:.8rem">
                <td style="text-align:center; color:red; font-size:.8rem"><?php echo $n?></td>
                
                <td style="font-size:.8rem"><?php echo $detail->details?>
                <td style="font-size:.8rem;text-align:center"><?php echo $detail->quantity?>
                <td style="color:var(--moreClor); font-size:.8rem">
                    <?php
                        
                        echo number_format($detail->price, 2);
                    ?>
                </td>
                <td style="color:var(--otherClor); font-size:.8rem">
                    <?php
                        
                        echo number_format($detail->total_amount, 2);
                    ?>
                </td>
                
                
            </tr>
            
            <?php $n++; endforeach;}?>
        </tbody>
    </table>

    
    <?php
        if(gettype($details) == "string"){
            echo "<p class='no_result'>'$details'</p>";
        }
        // get sum
        $get_amount = new selects();
        $rows = $get_amount->fetch_sum_single('invoices', 'total_amount', 'invoice', $invoice);
        foreach($rows as $row){
            $total_amount = $row->total;
            $discount = 0;
            //amount paid
            echo "<p class='total_amount'>SUB TOTAL: ₦".number_format($total_amount, 2)."</p>";
            //discount
            echo "<p class='total_amount'>DISCOUNT: ₦".number_format($discount, 2)."</p>"; 
            //balance
            /* echo "<p class='total_amount' style='color:green'>Debit Balance: ₦".number_format($balance, 2)."</p>"; */
            echo "<p class='total_amount'>TOTAL DUE: ₦".number_format($total_amount - $discount, 2)."</p>";
        }
        //sold by
        $get_seller = new selects();
        $row = $get_seller->fetch_details_group('users', 'full_name', 'user_id', $posted_by);
        echo ucwords("<p class='sold_by'>Prepared by: <strong>$row->full_name</strong></p>");
    ?>
    <p style="margin-top:20px;text-align:center">If you may have any questions or inquiries about this invoice, pls contac the phone number above!</p>
    <p style="margin-top:20px;text-align:center"><strong>Thanks for your patronage!</strong></p>
    <p><strong>Terms and Conditions:</strong></p>

</div> 
   
<?php
    echo "<script>window.print();
    window.close();</script>";
                    // }
                }
            // }
        
    // }
?>