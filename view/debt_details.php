
<?php
    include "../classes/dbh.php";
    include "../classes/select.php";
    include "../classes/update.php";
    
    if(isset($_GET['customer'])){
        $customer = $_GET['customer'];
       
        //get customer details
        $get_customer = new selects();
        $clients = $get_customer->fetch_details_group('customers', 'customer', 'customer_id', $customer);
        $client = $clients->customer;

?>

<button class="page_navs" id="back" onclick="showPage('debtors_list.php')"><i class="fas fa-angle-double-left"></i> Back</button>
<div class="displays all_details" style="width:60%!important;margin:0 20px!important">
    <!-- <div class="info"></div> -->
        <div class="displays allResults" id="payment_det">
        
            <div class="payment_details">
                <h3 style="width:100%; background:var(--otherColor); color:#fff;padding:5px;font-size:1rem">Showing all <?php echo $client?> invoices </h3>
                <table id="data_table" class="searchTable">
                <thead>
                <tr style="background:var(--primaryColor)">
                        <td>S/N</td>
                        <td>Invoice</td>
                        <td>Items</td>
                        <td>Amount</td>
                        <td>Date</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        //get transaction history
                        $get_transactions = new selects();
                        $details = $get_transactions->fetch_details_condGroup('invoices', 'customer', $customer, 'invoice');
                        $n = 1;
                        if(gettype($details) === 'array'){
                        foreach($details as $detail){

                    ?>
                    <tr>
                        <td style="text-align:center; color:red;"><?php echo $n?></td>
                        <td><a style="color:green" href="javascript:void(0)" title="View invoice details" onclick="viewCustomerInvoice('<?php echo $detail->invoice?>')"><?php echo $detail->invoice?></a></td>  
                        <td style="text-align:center">
                            <?php
                                //get items in invoice;
                                $get_items = new selects();
                                $items = $get_items->fetch_count_cond('invoices', 'invoice', $detail->invoice);
                                echo $items;
                            ?>
                        </td>   
                        <td>
                            <?php 
                                //get sum of invoice
                                $get_sum = new selects();
                                $sums = $get_sum->fetch_sum_single('invoices', 'total_amount', 'invoice', $detail->invoice);
                                foreach($sums as $sum){
                                    $invoice_total = $sum->total;
                                }
                                   
                                echo "₦".number_format($invoice_total, 2);
                            ?>
                        </td>
                        <td style="color:var(--moreColor)"><?php echo date("d-m-Y", strtotime($detail->trx_date));?></td>
                        
                    </tr>
                    <?php $n++; }}?>
                </tbody>
            </table>
            <?php
                if(gettype($details) == "string"){
                    echo "<p class='no_result'>'$details'</p>";
                }
                // get sum
                /* $get_total = new selects();
                $amounts = $get_total->fetch_sum_single('customers', 'wallet_balance', 'customer_id', $customer);
                foreach($amounts as $amount){
                    echo "<p class='total_amount' style='color:red; font-size:1rem;'>Total Due: ₦".number_format($amount->total * -1, 2)."</p>";
                } */
            ?>
            </div>
            
    <div id="customer_invoices">

    </div>
</div>
<?php
            }
        
   
?>