<?php
include "loan_receipt_style.php";
include "../classes/dbh.php";
include "../classes/select.php";
session_start();

if(isset($_GET['receipt'])){

    $user = $_SESSION['user_id'];
    $invoice = $_GET['receipt'];
    $type = "Customer Deposit Receipt";
    
    $get_details = new selects();

    /* -------------------------------------------------
        Fetch payment details
    ------------------------------------------------- */
    $payment_rows = $get_details->fetch_details_cond('repayments', 'invoice', $invoice);
    foreach($payment_rows as $pay){
        $customer = $pay->customer;
        $pay_mode = $pay->payment_mode;
        $paid_date = $pay->trx_date;
        $post_date = $pay->post_date;
        // $amount = $pay->amount;
        $loan = $pay->loan;
        $store = $pay->store;
    }
    //get total amount paid
    $amts = $get_details->fetch_details_cond('deposits', 'invoice', $invoice);
    foreach($amts as $amt){
        $amount = $amt->amount;
    }
   
    /* -------------------------------------------------
        Fetch customer details
    ------------------------------------------------- */
    $customers = $get_details->fetch_details_cond('customers', 'customer_id', $customer);
    foreach($customers as $cust){
        $account = $cust->acn;
        $customer_name = $cust->customer;
        $customer_phone = $cust->phone_numbers;
    }

    /* -------------------------------------------------
        Fetch store details
    ------------------------------------------------- */
    $stores = $get_details->fetch_details_cond('stores', 'store_id', $store);
    foreach($stores as $str){
        $store_name = $str->store;
        $address = $str->store_address;
        $phone = $str->phone_number;
    }

    /* -------------------------------------------------
        Fetch loan details
    ------------------------------------------------- */
    $lns = $get_details->fetch_details_cond('loan_applications', 'loan_id', $loan);
    foreach($lns as $asf){
        $product = $asf->product;
        $asset = $asf->asset;
        $frequency = $asf->frequency;
        $total_payable = $asf->total_payable;
        $amount_requested = $asf->amount;
        $frequency = $asf->frequency;
        $duration = $asf->loan_term;
    }
    if($asset == 0){
        //get product name
        $prds = $get_details->fetch_details_cond('loan_products', 'product_id', $product);
        foreach($prds as $prd){
            $product_name = $prd->product;
        }
    }else{
        //get product name
        $prds = $get_details->fetch_details_cond('items', 'item_id', $asset);
        foreach($prds as $prd){
            $product_name = $prd->item_name;
        }
    }

    /* -------------------------------------------------
        Get total paid so far
    ------------------------------------------------- */
    /* $tp = $get_details->fetch_sum_single('field_payments', 'amount', 'loan', $assigned_id);
    $total_paid = (is_array($tp)) ? $tp[0]->total : 0; */
    $total_paid_query = $get_details->fetch_sum_date_range('repayments', 'amount', 'loan', $loan, 'post_date', $post_date);

    $total_paid = (is_array($total_paid_query)) ? $total_paid_query[0]->total : 0;

    /* -------------------------------------------------
        Calculate field balance
    ------------------------------------------------- */
    $balance = $total_payable - $total_paid;
    if($balance > 0){
        $balance = $balance;
    }else{
        $balance = 0;
    }
?>

<div class="sales_receipt">
    <div class='receipt_logo'>
        <img src="../images/<?php echo $_SESSION['company_logo'];?>" title="logo">
    </div>
    <div class="logo_details">
        <h2><?php echo $_SESSION['company'];?></h2>
        <p><?php echo $address?></p>
        <p>Tel: <?php echo $phone?></p>
    </div>
</div>
    <div class="receipt_title">
        <h2 style="text-align:center;margin-top:10px;"><?php echo $type; ?></h2>
    </div>

    <div class="receipt_section">
        <h4>Transaction Information</h4>
        <p><strong>Invoice No:</strong> <?php echo $invoice; ?></p>
        <p><strong>Payment Date:</strong> <?php echo date("j M Y, g:ia", strtotime($paid_date)); ?></p>
        <p><strong>Posted Date:</strong> <?php echo date("j M Y, g:ia", strtotime($post_date)); ?></p>
        <p><strong>Payment Mode:</strong> <?php echo strtoupper($pay_mode); ?></p>
    </div>

    <div class="receipt_section">
        <h4>Customer Information</h4>
        <p><strong>Name:</strong> <?php echo $customer_name; ?></p>
        <p><strong>Account No:</strong> <?php echo $account; ?></p>
        <p><strong>Phone No:</strong> <?php echo $customer_phone; ?></p>
    </div>

    <div class="receipt_section">
        <h4>Loan Details</h4>
        <p><strong>Loan Product:</strong> <?php echo $product_name; ?></p>
        <p><strong>Amount:</strong> ₦<?php echo number_format($amount_requested, 2); ?></p>
        <p><strong>Duration:</strong> <?php echo $duration; ?> Months</p>
        <p><strong>Total Payable:</strong> ₦<?php echo number_format($total_payable); ?></p>
    </div>

    <table id="postsales_table" class="searchTable">
        <thead>
            <tr style="background:var(--moreColor)">
                <td>Description</td>
                <td>Amount (₦)</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Being <?php echo $pay_mode; ?> deposit for loan on <?php echo $product_name; ?> </td>
                <td><?php echo number_format($amount); ?></td>
            </tr>
        </tbody>
    </table>

    <div class="receipt_section">
        <h4>Payment Summary</h4>
        <p><strong>Amount Paid Now:</strong> ₦<?php echo number_format($amount); ?></p>
        <p><strong>Total Paid So Far:</strong> ₦<?php echo number_format($total_paid); ?></p>
        <p><strong>Outstanding Balance:</strong> ₦<?php echo number_format($balance); ?></p>
    </div>

    <div class="receipt_section">
        <?php
            $get_seller = new selects();
            $seller = $get_seller->fetch_details_group('users', 'full_name', 'user_id', $user);
            echo "<p><strong>Posted by:</strong> $seller->full_name</p>";
        ?>
       
    </div>

    <p style="text-align:center;margin-top:20px;"><strong>Thank you for your patronage!</strong></p>

</div>

<?php
    echo "<script>window.print();
    window.close();</script>";
}
?>
