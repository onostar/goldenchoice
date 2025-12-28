<?php

    if (isset($_GET['item_id'])){
        $id = $_GET['item_id'];

    // instantiate class
    include "../classes/dbh.php";
    include "../classes/select.php";

    $get_item = new selects();
    $rows = $get_item->fetch_details_cond('loan_products', 'product_id', $id);
     if(gettype($rows) == 'array'){
        foreach($rows as $row):
            
    ?>
    <div class="add_user_form priceForm">
        <h3 style="background:var(--primaryColor)">Update <?php echo strtoupper($row->product)?> details</h3>
        <section style="text-align:left">
            <div class="inputs" style="align-items:flex-end; justify-content:left; gap:.5rem">
                <!-- <div class="data item_head"> -->
                    <input type="hidden" name="item_id" id="item_id" value="<?php echo $id?>" required>
                <div class="data" style="width:32%;">
                    <label for="product"> Product</label>
                    <input type="text" name="product" id="product" value="<?php echo $row->product?>" required>
                </div>
                <div class="data" style="width:32%;">
                    <label for="minimum" style="text-align:left!important;">Minimum Amount (NGN)</label>
                    <input type="text" name="minimum" id="minimum" value="<?php echo $row->minimum?>">
                </div>
                <div class="data" style="width:32%;">
                    <label for="maximum" style="text-align:left!important;">Maximum Amount (NGN)</label>
                    <input type="text" name="maximum" id="maximum" value="<?php echo $row->maximum?>">
                </div>
                <div class="data" style="width:32%;">
                    <label for="repayment"> Repayment Frequency</label>
                    <select name="repayment" id="repayment">
                        <option value="<?php echo $row->repayment?>" selected><?php echo $row->repayment?></option>
                        <option value="Weekly">Weekly</option>
                        <option value="Monthly">Monthly</option>
                        <option value="Yearly">Yearly</option>
                    </select>
                </div>
                <div class="data" style="width:32%;">
                    <label for="interest" style="text-align:left!important;">Interest (%)</label>
                    <input type="text" name="interest" id="interest" value="<?php echo $row->interest?>">
                </div>
                <div class="data" style="width:32%;">
                    <label for="duration" style="text-align:left!important;">Maximum Term (Duration)</label>
                    <select name="duration" id="duration">
                        <option value="<?php echo $row->duration?>">
                            <?php echo $row->duration?> Months
                        </option>
                        <option value="3">3 Months</option>
                        <option value="6">6 Months</option>
                        <option value="12">12 Months</option>
                    </select>
                </div>
                <div class="data" style="width:32%;">
                    <label for="processing"> Processing Fee (%)</label>
                    <input type="number" name="processing" id="processing" value="<?php echo $row->processing?>">
                </div>
                <div class="data" style="width:32%;">
                    <label for="penalty"> Late Payment Penalty (%)</label>
                    <input type="number" name="penalty" id="penalty" value="<?php echo $row->penalty?>">
                </div>
                <div class="data" style="width:32%;">
                    <label for="collateral"> Collateral Required?</label>
                    <select name="collateral" id="collateral">
                        <option value="<?php echo $row->collateral?>"><?php echo $row->collateral?></option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>
                <div class="data" style="width:50%;">
                    <label for="description"> Description</label>
                    <textarea name="description" id="description"><?php echo $row->description?></textarea>
                </div>
                <div class="data">
                    <button type="button" id="modify_package" name="modify_package" onclick="modifyPackages()">Modify <i class="fas fa-save"></i></button>
                    <a href="javascript:void(0)" title="close form" style='background:red; padding:10px; border-radius:5px; color:#fff' onclick="closeForm()">Return <i class='fas fa-angle-double-left'></i></a>
                </div>
            </div>
        </section>   
    </div>
    
<?php
    endforeach;
     }
    }    
?>