<?php

    if (isset($_GET['item_id'])){
        $id = $_GET['item_id'];

    // instantiate class
    include "../classes/dbh.php";
    include "../classes/select.php";

    $get_item = new selects();
    $rows = $get_item->fetch_details_cond('guarantors', 'guarantor_id', $id);
     if(gettype($rows) == 'array'){
        foreach($rows as $row):
            
    ?>
    <div class="add_user_form priceForm">
        <h3 style="background:var(--primaryColor)">Update <?php echo strtoupper($row->full_name)?> details</h3>
        <section style="text-align:left">
            <div class="inputs" style="align-items:flex-end; justify-content:left; gap:.5rem">
                <!-- <div class="data item_head"> -->
                    <input type="hidden" name="item_id" id="item_id" value="<?php echo $id?>" required>
                <div class="data" style="width:32%;">
                    <label for="full_name"> Full Name</label>
                    <input type="text" name="full_name" id="full_name" value="<?php echo $row->full_name?>" required>
                </div>
                <div class="data" style="width:32%;">
                    <label for="relationship"> Relationship</label>
                    <select name="relationship" id="relationship">
                        <option value="<?php echo $row->relationship?>" selected><?php echo $row->relationship?></option>
                        <option value="Parent">Parent</option>
                        <option value="Sibling">Sibling</option>
                        <option value="Spouse">Spouse</option>
                        <option value="Friend">Friend</option>
                        <option value="Employer">Employer</option>
                        <option value="Colleague">Colleague</option>
                        <option value="Landlord">Landlord/Landlady</option>
                        <option value="Religious Leader">Religious Leader</option>
                        <option value="Community Leader">Community Leader</option>
                        <option value="Business Partner">Business Partner</option>
                        <option value="Neighbor">Neighbor</option>
                        <option value="Guardian">Legal Guardian</option>
                        <option value="Other">Others (specify)</option>
                    </select>
                </div>
                <div class="data" style="width:32%;">
                    <label for="gender"> Gender</label>
                    <select name="gender" id="gender" required>
                        <option value="<?php echo $row->gender?>" selected><?php echo $row->gender?></option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="data" style="width:32%;">
                    <label for="phone" style="text-align:left!important;">Phone Number</label>
                    <input type="text" name="phone" id="phone" value="<?php echo $row->phone_number?>">
                </div>
                <div class="data" style="width:32%;">
                    <label for="email_add"> Email Address</label>
                    <input type="email" name="email_add" id="email_add" value="<?php echo $row->email_address?>">
                </div>
                <div class="data" style="width:32%;">
                    <label for="address"> Residential Address</label>
                    <input type="address" name="address" id="address" value="<?php echo $row->address?>">
                </div>
                <div class="data" style="width:32%;">
                    <label for="occupation"> Occupation</label>
                    <select name="occupation" id="occupation">
                        <option value="<?php echo $row->occupation?>"><?php echo $row->occupation?></option>
                        <option value="Doctor">Doctor</option>
                        <option value="Engineer">Engineer</option>
                        <option value="Student">Student</option>
                        <option value="Nurse">Nurse</option>
                        <option value="Clergy">Clergy</option>
                        <option value="Banker">Banker</option>
                        <option value="Trader">Trader</option>
                        <option value="Teacher/Lecturer">Teacher/Lecturer</option>
                        <option value="Business Person">Business Person</option>
                        <option value="Others">Others</option>
                        <option value="Unemployed">Unemployed</option>
                    </select>
                </div>
                <div class="data" style="width:32%;">
                    <label for="description"> Business/Company Name</label>
                    <input type="business" id="business" value="<?php echo $row->business?>">
                </div>
                <div class="data" style="width:32%;">
                    <label for="description"> Business/Company Address</label>
                    <input type="business_address" id="business_address" value="<?php echo $row->business_address?>">
                </div>
                <div class="data">
                    <button type="button" id="modify_package" name="modify_package" onclick="updateGuarantor()">Update <i class="fas fa-save"></i></button>
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