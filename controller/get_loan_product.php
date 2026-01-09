<?php
    session_start();
     $store = $_SESSION['store_id'];
     $user_id = $_SESSION['user_id'];
    if (isset($_GET['product']) && isset($_GET['customer'])) {
        $id = $_GET['product'];
        $customer = $_GET['customer'];

    // instantiate class
    include "../classes/dbh.php";
    include "../classes/select.php";

    $get_item = new selects();
    $rows = $get_item->fetch_details_cond('loan_products', 'product_id', $id);
     if(gettype($rows) == 'array'){
        foreach($rows as $row):
            //get packagename
           
            /* if($row->duration == 3){
                $duration = "3 Months";
            }else if($row->duration == 6){
                $duration = "6 Months";
            }else if($row->duration == 365){
                $duration = "1 Year";
            }else{
                $duration = "";
            } */
    ?>
    <style>
        @media screen and (max-width: 800px){
            .add_user_form .inputs .data label{
                margin:0!important;
                padding:0!important;
            }
            .add_user_form .inputs .data input{
                margin:0!important;
            }
            .add_user_form .inputs .data{
                width: 48%!important;
            }
        }
    </style>
    <div class="add_user_form" style="margin:0!important">
        <h3 style="background:var(--menuColor);text-align:left"><?php echo $row->product?> Details</h3>
        <section style="text-align:left">
            <div class="inputs" style="align-items:flex-end; justify-content:left; gap:.5rem">
                <?php if($row->product == "ASSET LOAN"){?>
                <?php
                    //generate receipt invoice
                    //get current date
                    $todays_date = date("dmyh");
                    $ran_num ="";
                    for($i = 0; $i < 5; $i++){
                        $random_num = random_int(0, 9);
                        $ran_num .= $random_num;
                    }
                    $invoice = "RT".$store.$todays_date.$ran_num.$user_id;
                    // $_SESSION['invoice'] = $invoice;
                ?>
                <div class="data" style="width:100%!important;">
                    <input type="hidden" name="invoice" id="invoice" value="<?php echo $invoice?>">
                    <input type="hidden" name="customer" id="customer" value="<?php echo $customer?>">
                    <input type="hidden" name="loan" id="loan" value="<?php echo $id?>">
                    <label for="asset"> Select Product</label>
                    <input type="text" name="item" id="item" required placeholder="Input item name" onkeyup="getItems(this.value)">
                    <div id="sales_item">
                        
                    </div>

                </div>
                <div class="show_more"></div>
                <div class="sales_order" style="width:100%"></div>
                <?php }else{?>
                <div class="data" style="width:100%!important;">
                    <label for="description"> Description</label>
                    <textarea readonly><?php echo $row->description?></textarea>
                </div>
                <div class="data" style="width:32%;">
                    <label for="minimum" style="text-align:left!important;">Amount Range</label>
                    <input type="text" style="color:green" value="<?php echo "₦".number_format($row->minimum)." - ₦".number_format($row->maximum)?>" readonly>
                </div>
                <div class="data" style="width:32%;">
                    <label for="repayment"> Repayment Frequency</label>
                    <input type="text" value="<?php echo $row->repayment?>" readonly>
                </div>
                <div class="data" style="width:32%;">
                    <label for="interest" style="text-align:left!important;">Interest Rate</label>
                    <input type="text" value="<?php echo $row->interest?>%" readonly>
                </div>
                <div class="data" style="width:32%;">
                    <label for="duration" style="text-align:left!important;">Maximum Term (Duration)</label>
                     <input type="text" value="<?php echo $row->duration?> Months" readonly>
                </div>
                <div class="data" style="width:32%;">
                    <label for="processing"> Processing Fee</label>
                    <input type="text" value="<?php echo $row->processing?>%" readonly>
                </div>
                <div class="data" style="width:32%;">
                    <label for="penalty"> Late Payment Penalty</label>
                    <input type="text" style="color:red" value="<?php echo $row->penalty?>%" readonly>
                </div>
                <div class="data" style="width:32%;">
                    <label for="collateral"> Collateral Required?</label>
                     <input type="text" value="<?php echo $row->collateral?>" readonly>
                </div>
                
                <div class="data">
                    <button type="button" onclick="showPage('continue_application.php?product=<?php echo $id?>&customer=<?php echo $customer?>')">Apply <i class="fas fa-arrow-right-arrow-left"></i></button>
                </div>
                <?php }?>
            </div>
        </section>   
    </div>
    
<?php
    endforeach;
     }
    }    
?>