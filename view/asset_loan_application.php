<div id="loan_application">
<?php
    session_start();
    $role = $_SESSION['role'];
    if (isset($_GET['product']) && isset($_GET['customer'])) {
        $id = $_GET['product'];
        $customer = $_GET['customer'];
        $asset = $_GET['asset'];

    // instantiate class
    include "../classes/dbh.php";
    include "../classes/select.php";

    $get_item = new selects();
    //get asset details
    $details = $get_item->fetch_details_cond('items','item_id', $asset);
    foreach($details as $detail){
        $item_name = $detail->item_name;
        $price = $detail->sales_price;
    }
    $rows = $get_item->fetch_details_cond('loan_products', 'product_id', $id);
     if(gettype($rows) == 'array'){
        foreach($rows as $row):
            
    ?>
    <style>
        @media screen and (max-width: 800px){
            .add_user_form .inputs .data label{
                margin:0!important;
                padding:0!important;
            }
            .add_user_form .inputs .data input, .add_user_form .inputs .data select{
                margin:0!important;
            }
            .add_user_form .inputs .data{
                width: 100%!important;
            }
        }
    </style>

    <div class="displays allResults" style="width:100%;">
        <?php if($role == "Client"){?>
        <a style="border-radius:15px; background:brown;color:#fff;padding:8px; margin:10px 0!important; box-shadow:1px 1px 1px #222"href="javascript:void(0)" onclick="showPage('apply_loan.php')"><i class="fas fa-angle-double-left"></i> Return</a>
        <?php }else{?>
        <a style="border-radius:15px; background:brown;color:#fff;padding:8px; margin:10px 0!important; box-shadow:1px 1px 1px #222"href="javascript:void(0)" onclick="showPage('new_loan_application.php?customer=<?php echo $customer?>')"><i class="fas fa-angle-double-left"></i> Return</a>
        <?php }?>
        <div class="add_user_form" style="margin:0!important">
            <h3 style="background:var(--tertiaryColor);text-align:left">Complete Application for <?php echo $item_name?> (<?php echo $row->product?>)</h3>
            <section style="text-align:left">
                <div class="inputs" style="align-items:flex-end; justify-content:left; gap:.5rem">
                    <input type="hidden" name="minimum" id="minimum" value="<?php echo $row->minimum?>">
                    <input type="hidden" name="maximum" id="maximum" value="<?php echo $row->maximum?>">
                    <input type="hidden" name="product" id="product" value="<?php echo $id?>">
                    <input type="hidden" name="frequency" id="frequency" value="<?php echo $row->repayment?>">
                    <input type="hidden" name="customer" id="customer" value="<?php echo $customer?>">
                    <input type="hidden" id="asset" name="asset" value="<?php echo $asset?>">
                    <div class="data" style="width:32%;">
                        <label for="amount" style="text-align:left!important;">Asset Value (₦)</label>
                        <input type="text" name="amount" id="amount" value="<?php echo $price?>"onkeyup="calculateInterest()" onblur="calculateInterest()" required>
                    </div>
                    <!-- <div class="data" style="width:32%;">
                        <label for="purpose" style="text-align:left!important;">Loan Purpose</label>
                        <select name="purpose" id="purpose">
                            <option value="" selected disabled>-- Select Purpose --</option>
                            <option value="business">Business Capital</option>
                            <option value="school fees">School Fees / Education</option>
                            <option value="house rent">House Rent</option>
                            <option value="medical expenses">Medical Expenses</option>
                            <option value="asset purchase">Purchase of Equipment/Asset</option>
                            <option value="salary advance">Salary Advance</option>
                            <option value="agricultural support">Agricultural Support</option>
                            <option value="emergency">Emergency Needs</option>
                            <option value="travel">Travel / Visa</option>
                            <option value="others">Other</option>
                        </select>
                    </div> -->
                    <input type="hidden" name="purpose" id="purpose" value="Asset Purchase">
                    <div class="data" style="width:32%;">
                        <label for="duration" style="text-align:left!important;">Loan Term / Duration (Months)</label>
                        <input type="hidden" name="duration" id="duration" value="<?php echo $row->duration?>" readonly>
                        <select name="loan_term" id="loan_term" onchange="calculateInterest()">
                            <option value="" selected disabled>Select Loan Term</option>
                            <option value="3">3 Months</option>
                            <option value="6">6 Months</option>
                            <option value="12">1 Year</option>
                        </select>
                    </div>
                    <div class="data" style="width:32%;">
                        <label for="interest" style="text-align:left!important;">Interest:</label>
                        <input type="hidden" name="interest_rate" id="interest_rate" value="<?php echo $row->interest?>">
                        <input type="text" style="color:red; background:#ebeaea" name="interest_amount" id="interest_amount" readonly>
                        <input type="hidden" name="interest" id="interest" readonly>
                    </div>
                    <div class="data" style="width:32%;">
                        <label for="processing"> Processing Fee:</label>
                        <input type="hidden" name="processing" id="processing" value="<?php echo $row->processing?>">
                        <input type="hidden"  name="processing_fee" id="processing_fee" readonly>
                        <input type="text" style="color:var(--primaryColor); background:#ebeaea" name="processing_amount" id="processing_amount" readonly>
                    </div>
                    <div class="data" style="width:32%;">
                        <label for="">Total Repayable Amount:</label>
                        <input type="hidden" name="total_payable" id="total_payable" readonly>
                        <input type="text" style="color:green; background:#ebeaea" name="total_fee" id="total_fee" readonly>
                    </div>
                    <div class="data" style="width:32%;">
                        <label for=""><?php echo $row->repayment?> Installment:</label>
                        <input type="hidden" name="installment" id="installment" readonly>
                        <input type="text" style="color:green; background:#ebeaea" name="installmental" id="installmental" readonly>
                    </div>
                    <input type="hidden" name="collateral_type" id="collateral_type" value="<?php echo $row->collateral?>">
                    <?php if($row->collateral == "Yes"){?>
                    <div class="data" style="width:64%;">
                        <label for="collateral"> Input Collateral details</label>
                        <textarea name="collateral" id="collateral" placeholder="Enter Collateral details"></textarea>
                    </div>
                    <?php }?>
                    <div class="data">
                        <button type="button" onclick="completeApplication()">Submit Application <i class="fas fa-arrow-right-arrow-left"></i></button>
                        
                    </div>
                </div>
            </section>   
        </div>
    </div>
    
<?php
    endforeach;
     }
    }    
?>
</div>