<?php
    session_start();
    $store = $_SESSION['store_id'];
    include "../classes/dbh.php";
    include "../classes/select.php";
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
?>

<div id="sales_order" class="displays">
    <?php
        //get invoice
        if(isset($_GET['invoice'])){
            $invoice = $_GET['invoice'];
            //get customer
            $get_customer = new selects();
            $cust = $get_customer->fetch_details_group('invoices', 'customer', 'invoice', $invoice);
            $customer = $cust->customer;
            //get customer name
            $get_name = new selects();
            $names = $get_name->fetch_details_group('customers', 'customer', 'customer_id', $customer);
            $customer_name = $names->customer;

        }
    ?>
    <button class="page_navs" id="back" onclick="showPage('pending_invoice.php')"><i class="fas fa-angle-double-left"></i> Back</button>
    <div class="add_user_form" style="width:50%; margin:10px 0; box-shadow:none">
        <h3 style="background:var(--primaryColor); color:#ff; text-align:left!important;" >Post Invoice for  <?php echo $customer_name ." (".$invoice.")"?></h3>
        
            <!-- search forms -->
        <!-- <form method="POST" id="addUserForm"> -->
            <section class="addUserForm">
                <div class="inputs">
                    <!-- bar items form -->
                    <input type="hidden" name="customer" id="customer" value="<?php echo $customer?>">
                    <!-- <div class="data" style="width:100%">
                        <label for="">Name of Item</label>
                        <input type="text" name="drug" id="drug">
                    </div> -->
                    <div class="data">
                        <label for="manual_invoice">Invoice No.</label><input type="text" name="manual_invoice" id="manual_invoice">
                    </div>
                    <div class="data">
                        <label for="service_order">Service Order No.</label><input type="text" name="service_order" id="service_order">
                    </div>
                    <div class="data" id="bar_items" style="width:100%; margin:2px 0">
                        <label for="item"> Description</label>
                        <input type="hidden" name="invoice" id="invoice" value="<?php echo $invoice?>">
                        <input type="hidden" name="posted_by" id="posted_by" value="<?php echo $user_id?>">
                        <textarea name="details" id="details" placeholder="Input item description"></textarea>
                    </div>
                    <div class="data">
                        <label for="quantity">Quantity</label><input type="number" name="quantity" id="quantity">
                    </div>
                    <div class="data">
                        <label for="price">Agreed Amount (NGN)</label><input type="text" name="price" id="price">
                    </div>
                    <div class="data">
                        <button stype="submit" onclick="addInvoice()">Add <i class="fas fa-add"></i></button>
                    </div>
                </div>
            </section>
            
        </div>
    </div>
    <div class="show_more" id="showMore"></div>
    <div class="sales_order">
        <?php include "../controller/invoice_details.php"?>
    </div>
</div>
<?php
    }else{
        header("Location: ../index.php");
    }
?>