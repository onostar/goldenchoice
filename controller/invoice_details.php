<div class="displays allResults" id="stocked_items">
    <!-- <h2>Items in sales order</h2> -->
    <table id="addsales_table" class="searchTable">
        <thead>
            <tr style="background:var(--moreColor)">
                <td>S/N</td>
                <td>Details</td>
                <td>Quantity</td>
                <td>Unit Price</td>
                <td>Amount</td>
                <td></td>
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
            <tr>
                <td style="text-align:center; color:red;"><?php echo $n?></td>
                
                <td>
                    <?php
                        
                        echo $detail->details;
                    ?>
                </td>
                <td style="text-align:center"><?php echo $detail->quantity?></td>
                <td style="color:var(--moreClor);">
                    <?php
                        
                        echo "₦".number_format($detail->price, 2);
                    ?>
                </td>
                <td style="color:var(--moreClor);">
                    <?php
                        
                        echo "₦".number_format($detail->total_amount, 2);
                    ?>
                </td>
                <td>
                    <a style="color:#fff; background:var(--otherColor);border-radius:15px;padding:5px 8px;" href="javascript:void(0)" title="Update item" onclick="updateDetails('<?php echo $detail->invoice_id?>')"><i class="fas fa-pen"></i></a>
                    <a style="color:red; font-size:1rem" href="javascript:void(0) "title="delete purchase" onclick="deleteDetails('<?php echo $detail->invoice_id?>', '<?php echo $invoice?>')"><i class="fas fa-trash"></i></a>
                </td>
               
            </tr>
            
            <?php $n++; endforeach;}?>
        </tbody>
    </table>
    <?php
        
        if(gettype($details) == "string"){
            echo "<p class='no_result'>'$details'</p>";
        }
        if(gettype($details) == "array"){
            // get sum
            $get_total = new selects();
            $amounts = $get_total->fetch_sum_single('invoices', 'total_amount', 'invoice', $invoice);
            foreach($amounts as $amount){
                $total_amount = $amount->total;
            }
            // $total_worth = $total_amount * $total_qty;
            echo "<p class='total_amount' style='background:red; color:#fff; text-decoration:none; width:auto; float:right; padding:10px;font-size:1.1rem;'>Total Due: ₦".number_format($total_amount, 2)."</p>";
    ?>
    <section class="add_user_form" style="text-align:left; padding:10px; margin:0; width:50%;">
        <div class="inputs" style="display:flex;flex-wrap:wrap; gap:.5rem; align-items:flex-end">    
            <input type="hidden" name="invoice" id="invoice" value="<?php echo $invoice?>" required>
            <div class="data" style="width:45%">
                <label for="trx_date">Transaction Date</label><input type="date" name="trx_date" id="trx_date" value="<?php echo date("Y-m-d")?>">
            </div>
            <div class="data" style="width:45%">
                <label for="amount">PO. Number</label><input type="text" name="po_number" id="po_number">
            </div>
            <div class="data" style="width:45%">
                <label for="amount">Due Days</label><input type="number" name="due_days" id="due_days">
            </div>
            <div class="data">
                <button onclick="postInvoice()" style="background:green; padding:10px; border-radius:15px;font-size:.9rem; box-shadow:1px 1px 1px #222; border:1px solid #fff">Post & Print <i class="fas fa-paper-plane"></i></button>
            </div>
        </div>
        
    </section>
   
    <?php }?>
</div> 