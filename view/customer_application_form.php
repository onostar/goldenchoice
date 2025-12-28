<div class="displays allResults" style="width:100%;">
        <div class="add_user_form" style="width:50%; margin:20px 0">
            <h3 style="background:var(--primaryColor)">Loan Application for <?php echo $customer_name?></h3>
            <!-- <form method="POST" id="addUserForm"> -->
            <section>
                <div class="inputs">
                    <div class="data" style="width:100%;">
                        <label for="business"> Loan Product</label>
                        <select name="product" id="product" onchange="getLoanProduct(this.value, '<?php echo $customer?>')">
                            <option value="" selected disabled>Select Loan Product</option>
                            <?php
                                $loans = $get_details->fetch_details_condOrder('loan_products', 'product_status', 0, 'product');
                                if(is_array($loans)){
                                    foreach($loans as $loan){
                            ?>
                            <option value="<?php echo $loan->product_id?>"><?php echo $loan->product?></option>
                            <?php } }?>
                        </select>
                    </div>
                </div>
                
            </section>    
        </div>
        <div id="product_info">
            
        </div>
    </div>