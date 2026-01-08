<?php

    if (isset($_GET['item_id'])){
        $id = $_GET['item_id'];
    

    // instantiate class
    include "../classes/dbh.php";
    include "../classes/select.php";

    $get_item = new selects();
    $rows = $get_item->fetch_details_cond('customers', 'customer_id', $id);
     if(gettype($rows) == 'array'){
        foreach($rows as $row):
            //get cso details
            $staffs = $get_item->fetch_details_cond('users', 'user_id', $row->cso);
            if(is_array($staffs)){
                foreach($staffs as $staff){
                    $cso = $staff->full_name;
                    $cso_id = $staff->user_id;
                }
            }else{
                $cso = "Not assigned";
                $cso_id = 0;
            }
        
    ?>
    <div class="add_user_form priceForm" style="width:70%; margin:5px 0;">
        <h3 style="background:var(--primaryColor); text-align:left">Assign <?php echo strtoupper($row->customer)?> to CSO</h3>
        <section class="addUserForm" style="text-align:left;">
            <div class="inputs">
                <!-- <div class="data item_head"> -->
                    <input type="hidden" name="customer_id" id="customer_id" value="<?php echo $row->customer_id?>" required>
                <div class="data" style="width:auto">
                    <label for="rol">Select CSO</label>
                    <select name="cso" id="cso">
                        <option value="<?php echo $cso_id?>"><?php echo $cso?></option>
                        <?php
                            $get_staff = new selects();
                            $staff_details = $get_staff->fetch_details_cond('users', 'user_role', 'Loan Officer');
                            if(is_array($staff_details)){
                                foreach($staff_details as $staff_detail){
                        ?>
                        <option value="<?php echo $staff_detail->user_id?>"><?php echo $staff_detail->full_name?></option>
                        <?php }}?>
                    </select>
                </div>
                <div class="data adjust_btn" style="width:auto; display:flex;">
                    <button type="submit" id="adjust_rol" name="adjust_rol" onclick="assignClient()"> Assign</button>
                    <a href="javascript:void(0)" title="close form" style='background:red; padding:10px; border-radius:5px; color:#fff' onclick="closeForm()">Return </a>
                </div>
            </div>
        </section>   
    </div>
    
<?php
    endforeach;
     }
    }    
?>