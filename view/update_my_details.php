<div id="edit_customer">
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
<?php
    session_start();
    $store = $_SESSION['store_id'];
    include "../classes/dbh.php";
    include "../classes/select.php";
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        // echo $user_id;
        // if(isset($_GET['customer'])){
            //get customer details
            $get_customer = new selects();
            $rows = $get_customer->fetch_details_cond('customers', 'user_id', $user_id);
            foreach($rows as $row){

?>
    <div class="add_user_form" style="width:90%">
        <h3 style="background:var(--menuColor)">Edit <?php echo $row->customer?>'s details</h3>
        <!-- <form method="POST" id="addUserForm"> -->
        <section>
            <div class="inputs" style="gap:.5rem;">
                <div class="data" style="width:24%">
                    <label for="customer">Full Name <span class="important">*</span></label>
                    <input type="text" name="full_name" id="full_name" value="<?php echo $row->customer?>" required>
                    <input type="hidden" name="customer" id="customer" value="<?php echo $row->customer_id?>" required>
                </div>
                <div class="data" style="width:24%">
                    <label for="gender">Gender</label>
                    <select name="gender" id="gender">
                        <option value="<?php echo $row->gender?>" selected><?php echo $row->gender?></option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="data" style="width:24%">
                    <label for="phone_number">Phone number <span class="important">*</span></label>
                    <input type="text" name="phone_number" id="phone_number" required value="<?php echo $row->phone_numbers?>">
                </div>
                <div class="data" style="width:24%">
                    <label for="email">Email address <span class="important">*</span></label>
                    <input type="text" name="email" id="email" placeholder="example@mail.com" required value="<?php echo $row->customer_email?>">
                </div>
                <div class="data" style="width:24%">
                    <label for="customer_store">Date of birth <span class="important">*</span></label>
                    <input type="date" name="dob" id="dob" value="<?php echo date("Y-m-d", strtotime($row->dob))?>">
                </div>
                <div class="data" style="width:24%">
                    <label for="Address">Residential Address <span class="important">*</span></label>
                    <input type="text" name="address" id="address" required value="<?php echo $row->customer_address?>">
                </div>
                <div class="data" style="width:24%">
                    <label for="Address">State/Region <span class="important">*</span></label>
                    <select name="state_region" id="state_region" required>
                        <option value="<?php echo $row->state_region?>" selected><?php echo $row->state_region?></option>
                        <option value="Abia">Abia</option>
                        <option value="Adamawa">Adamawa</option>
                        <option value="Akwa-Ibom">Ibom</option>
                        <option value="Anambra">Anambra</option>
                        <option value="Bauchi">Bauchi</option>
                        <option value="Bayelsa">Bayelsa</option>
                        <option value="Benue">Benue</option>
                        <option value="Borno">Borno</option>
                        <option value="Cross River">Cross River</option>
                        <option value="Delta">Delta</option>
                        <option value="Ebonyi">Ebonyi</option>
                        <option value="Edo">Edo</option>
                        <option value="Ekiti">Ekiti</option>
                        <option value="Enugu">Enugu</option>
                        <option value="FCT (Abuja)">FCT (Abuja)</option>
                        <option value="Gombe">Gombe</option>
                        <option value="Imo">Imo</option>
                        <option value="Jigawa">Jigawa</option>
                        <option value="Kaduna">Kaduna</option>
                        <option value="Kano">Kano</option>
                        <option value="Katsina">Katsina</option>
                        <option value="Kebbi">Kebbi</option>
                        <option value="Kogi">Kogi</option>
                        <option value="Kwara">Kwara</option>
                        <option value="Lagos">Lagos</option>
                        <option value="Nasarawa">Nasarawa</option>
                        <option value="Niger">Niger</option>
                        <option value="Ogun">Ogun</option>
                        <option value="Ondo">Ondo</option>
                        <option value="Osun">Osun</option>
                        <option value="Oyo">Oyo</option>
                        <option value="Plateau">Plateau</option>
                        <option value="Rivers">Rivers</option>
                        <option value="Sokoto">Sokoto</option>
                        <option value="Taraba">Taraba</option>
                        <option value="Yobe">Yobe</option>
                        <option value="Zamfara">Zamfara</option>
                    </select>
                </div>
                <div class="data" style="width:24%">
                    <label for="LGA">LGA / City <span class="important">*</span></label>
                    <input type="text" name="lga" id="lga" required value="<?php echo $row->lga?>">
                </div>
                <div class="data" style="width:24%">
                    <label for="landmark">Nearest Landmark</label>
                    <input type="text" name="landmark" id="landmark" value="<?php echo $row->landmark?>">
                </div>
                <!-- 
                <div class="data" style="width:24%">
                    <label for="title">Title</label>
                    <select name="title" id="title">
                        <option value="<?php echo $row->title?>" selected><?php echo $row->title?></option>
                        <option value="Mr.">Mr.</option>
                        <option value="Mrs">Mrs</option>
                        <option value="Master">Master</option>
                        <option value="Miss">Miss</option>
                        <option value="Dr.">Dr.</option>
                        <option value="Chief">Chief</option>
                        <option value="Prof">Prof</option>
                        <option value="Hon">Hon</option>
                        <option value="Pastor">Pastor</option>
                        <option value="Eng.">Eng.</option>
                    </select>
                </div> -->
                
                <div class="data" style="width:24%">
                    <label for="marital_status">Marital Status <span class="important">*</span></label>
                    <select name="marital_status" id="marital_status">
                        <option value="<?php echo $row->marital_status?>" selected><?php echo $row->marital_status?></option>
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                        <option value="Divorced">Divorced</option>
                        <option value="Widowed">Widowed</option>
                    </select>
                </div>
                <div class="data" style="width:24%">
                    <label for="religion">Religion <span class="important">*</span></label>
                    <select name="religion" id="religion">
                        <option value="<?php echo $row->religion?>" selected><?php echo $row->religion?></option>
                        <option value="Christian">Christian</option>
                        <option value="Muslim">Muslim</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
                <div class="data" style="width:24%">
                    <label for="occupation">Occupation <span class="important">*</span></label>
                    <select name="occupation" id="occupation">
                        <option value="<?php echo $row->occupation?>" selected><?php echo $row->occupation?></option>
                        <option value="Doctor">Doctor</option>
                        <option value="Engineer">Engineer</option>
                        <option value="Student">Student</option>
                        <option value="Nurse">Nurse</option>
                        <option value="Clergy">Clergy</option>
                        <option value="Banker">Banker</option>
                        <option value="Teacher/Lecturer">Teacher/Lecturer</option>
                        <option value="Trader">Trader</option>
                        <option value="Business Person">Business Person</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
                <div class="data" style="width:24%">
                    <label for="nok">Estimated Monthly Income <span class="important">*</span></label>
                    <input type="text" name="income" id="income" required value="<?php echo $row->income?>">
                </div>
                <div class="data" style="width:24%">
                    <label for="nok">Business/Company Name <span class="important">*</span></label>
                    <input type="text" name="business" id="business" required value="<?php echo $row->business?>">
                </div>
                <div class="data" style="width:24%">
                    <label for="nok">Business/Company Address <span class="important">*</span></label>
                    <input type="text" name="business_address" id="business_address" required value="<?php echo $row->business_address?>">
                </div>
                <div class="data" style="width:23%">
                    <label for="bank">Bank <span class="important">*</span></label>
                    <select name="bank" id="bank">
                        <option value="<?php echo $row->bank?>" selected ><?php echo $row->bank?></option>
                        <option>Access Bank</option>
                        <option>Citibank Nigeria</option>
                        <option>Ecobank Nigeria</option>
                        <option>Fidelity Bank</option>
                        <option>First Bank of Nigeria</option>
                        <option>First City Monument Bank (FCMB)</option>
                        <option>Globus Bank</option>
                        <option>Guaranty Trust Bank (GTBank)</option>
                        <option>Heritage Bank</option>
                        <option>Jaiz Bank</option>
                        <option>Keystone Bank</option>
                        <option>Parallex Bank</option>
                        <option>Polaris Bank</option>
                        <option>PremiumTrust Bank</option>
                        <option>Providus Bank</option>
                        <option>Stanbic IBTC Bank</option>
                        <option>Standard Chartered Bank Nigeria</option>
                        <option>Sterling Bank</option>
                        <option>SunTrust Bank</option>
                        <option>Titan Trust Bank</option>
                        <option>Union Bank of Nigeria</option>
                        <option>United Bank for Africa (UBA)</option>
                        <option>Unity Bank</option>
                        <option>Wema Bank</option>
                        <option>Zenith Bank</option>
                    </select>
                </div>
                <div class="data" style="width:24%">
                    <label for="account_number">Account Number <span class="important">*</span></label>
                    <input type="text" name="account_number" id="account_number" required value="<?php echo $row->account_number?>">
                </div>
                <div class="data" style="width:24%">
                    <label for="account_name">Account Name <span class="important">*</span></label>
                    <input type="text" name="account_name" id="account_name" required value="<?php echo $row->account_name?>">
                </div>
                
                <div class="data" style="width:24%">
                    <label for="nok">Next of Kin <span class="important">*</span></label>
                    <input type="text" name="nok" id="nok" required value="<?php echo $row->nok?>">
                </div>
                <div class="data" style="width:24%">
                    <label for="nok">Next of Kin Relationship <span class="important">*</span></label>
                    <input type="text" name="nok_relation" id="nok_relation" required value="<?php echo $row->nok_relation?>">
                </div>
                <div class="data" style="width:24%">
                    <label for="nok">Next of Kin Address <span class="important">*</span></label>
                    <input type="text" name="nok_address" id="nok_address" required value="<?php echo $row->nok_address?>">
                </div>
                <div class="data" style="width:24%">
                    <label for="nok">Next of Kin Phone Number <span class="important">*</span></label>
                    <input type="tel" name="nok_phone" id="nok_phone" required value="<?php echo $row->nok_phone?>">
                </div>
                <div class="data" style="width:50%">
                    <button type="submit" id="update_customer" name="update_customer" onclick="updateCustomer('update_my_details.php')">Update details <i class="fas fa-save"></i></button>
                    <!-- <a style="border-radius:15px; background:brown;color:#fff;padding:10px; box-shadow:1px 1px 1px #222"href="javascript:void(0)" onclick="showPage('edit_customer_info.php')"><i class="fas fa-angle-double-left"></i> Return</a> -->
                </div>
            </div>
        </section>    
    </div>

<?php
            // }
        }
    }else{
        header("Location: ../index.php");
    }
?>
</div>
