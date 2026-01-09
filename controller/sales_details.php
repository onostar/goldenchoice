<?php
    // $store = $_SESSION['store_id'];
    // $customer = $_SESSION['customer'];
?>
<div class="displays allResults" id="stocked_items" style="width:100%!important">
    <!-- <h2>Items in sales order</h2> -->
    <table id="addsales_table" class="searchTable">
        <thead>
            <tr style="background:var(--moreColor)">
                <td>S/N</td>
                <td>Item name</td>
                <td>Quantity</td>
                <td>Unit sales</td>
                <td>Amount</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php
                $n = 1;
                $get_items = new selects();
                $details = $get_items->fetch_details_cond('sales','invoice', $invoice);
                if(gettype($details) === 'array'){
                foreach($details as $detail):
                    //get category name
                        $item_name = $get_items->fetch_details_group('items', 'item_name', 'item_id', $detail->item);
                        $item_name = $item_name->item_name;
            ?>
            <tr>
                <td style="text-align:center; color:red;"><?php echo $n?></td>
                <td style="color:var(--moreClor);">
                    <?php
                        echo $item_name;
                    ?>
                </td>
                <td style="text-align:center; color:red;font-size:.8rem">
                    <span style="font-size:1.1rem; margin:0 2px"><?php echo $detail->quantity?></span>
                    <!-- <a style="color:#fff; background:green;border-radius:5px;padding:4px 8px;" href="javascript:void(0)" title="increase quantity" onclick="increaseQtyWholesale('<?php echo $detail->sales_id?>', '<?php echo $detail->item?>')"><i class="fas fa-arrow-up"></i></a>
                    <a style="color:#fff; background:var(--primaryColor);border-radius:5px;padding:4px 8px;" href="javascript:void(0)" title="decrease quantity" onclick="reduceQtyWholesale('<?php echo $detail->sales_id?>')"><i class="fas fa-arrow-down"></i></a> -->
                    <a style="color:#fff; background:var(--otherColor);border-radius:5px;padding:4px 8px;" href="javascript:void(0)" title="show more options" onclick="showMore('<?php echo $detail->sales_id?>')"><i class="fas fa-pen"></i></a>
                    <!-- <a style="color:#fff; background:var(--secondaryColor);border-radius:4px;padding:5px 8px;" href="javascript:void(0)" title="sell item in pack" onclick="getWholesalePack('<?php echo $detail->sales_id?>')"><i class="fas fa-box"></i> pack</a> -->
                </td>
                <td>
                    <?php 
                        echo "₦".number_format($detail->price, 2);
                    ?>
                </td>
                <td>
                    <?php 
                        echo "₦".number_format($detail->total_amount, 2);
                    ?>
                </td>
                <td>
                    <a style="color:red; font-size:1rem" href="javascript:void(0) "title="delete item" onclick="deleteSales('<?php echo $detail->sales_id?>', '<?php echo $detail->item?>')"><i class="fas fa-trash"></i></a>
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
        $amounts = $get_items->fetch_sum_con('sales', 'price', 'quantity', 'invoice', $invoice);
        foreach($amounts as $amount){
            $total_amount = $amount->total;
        }
        // $total_worth = $total_amount * $total_qty;
        echo "<p class='total_amount' style='background:red; color:#fff; text-decoration:none; width:auto; float:right; padding:10px;font-size:1.1rem;'>Total Due: ₦".number_format($total_amount, 2)."</p>";
    ?>
    <!-- discount -->
    <section style="float:right;margin:5px;">
        <!-- <label for="discount" style="color:red;">Discount</label><br> -->
        <input type="hidden" name="discount" id="discount" style="padding:5px;border-radius:5px;" value="0">
    </section>
    <?php
        if(gettype($details) == "array"){
    ?>
    <div class="close_stockin add_user_form" style="width:50%; margin:0;">
        <section class="addUserForm">
            <div class="inputs" style="display:flex;flex-wrap:wrap">
                
                <div class="data" style="width:auto">
                    <button type="button" onclick="showPage('asset_loan_application.php?invoice=<?php echo $invoice?>&product=<?php echo $loan?>&customer=<?php echo $customer?>')">Continue Application</button>
                </div>
            </div>
        </section>
    </div>
    <?php }?>
</div>    
