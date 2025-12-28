<?php
    include "../classes/dbh.php";
    include "../classes/select.php";
?>
<style>
    .add_user_form hr{
        background: rgba(230, 228, 228, .3);
        color:rgba(230, 228, 228, .3);
    }
    @media screen and (max-width:800px){
        label{
            margin:0;

        }
        input, select{
            margin:0!important;
            
        }
        .data{
            width:30%!important;
        }
    }
</style>
<div id="new_reg" style="width:90%;margin:auto">
    <div class="info"></div>
    <div class="add_user_form" style="width:100%">
        <h3 style="background:var(--tertiaryColor);text-transform:uppercase">Client Onboarding Form</h3>
        <!-- <form method="POST" id="addUserForm"> -->
        <section>
            <h4>Personal Information</h4>
            <div class="inputs" style="gap:.9rem;justify-content:left">
                
                <!-- <div class="data" style="width:23%">
                    <label for="title">Title <span class="important">*</span></label>
                    <select name="title" id="title">
                        <option value="">Select Title</option>
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
                
                <div class="data" style="width:23%">
                    <label for="customer">Full Name <span class="important">*</span></label>
                    <input type="text" name="full_name" id="full_name" required>
                </div>
                <!-- <div class="data" style="width:23%">
                    <label for="other_names">Other Names <span class="important">*</span></label>
                    <input type="text" name="other_names" id="other_names" placeholder="Patient's other names" required>
                </div> -->
                <div class="data" style="width:23%">
                    <label for="customer">Gender <span class="important">*</span></label>
                    <select name="gender" id="gender" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="data" style="width:23%">
                    <label for="dob">Date of Birth <span class="important">*</span></label>
                    <input type="date" name="dob" id="dob" oninput="getAge(this.value)" required>
                </div>
                <div class="data" style="width:23%" class="age_data">
                    <label for="age">Age</label>
                    <input type="age" name="age" id="age" style="background:#eae6e6; color:red">
                </div>
                <div class="data" style="width:23%">
                    <label for="marital_status">Marital Status <span class="important">*</span></label>
                    <select name="marital_status" id="marital_status" required>
                        <option value="">Select marital Status</option>
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                        <option value="Divorced">Divorced</option>
                        <option value="Widowed">Widowed</option>
                    </select>
                </div>
                <div class="data" style="width:23%">
                    <label for="religion">Religion</label>
                    <select name="religion" id="religion">
                        <option value="">Select Religion</option>
                        <option value="Christian">Christian</option>
                        <option value="Muslim">Muslim</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
                
                <div class="data" style="width:23%">
                    <label for="phone_number">Phone number <span class="important">*</span></label>
                    <input type="text" name="phone_number" id="phone_number" required>
                </div>
                
                <div class="data" style="width:23%">
                    <label for="email">Email address <span class="important">*</span></label>
                    <input type="text" name="email" id="email" placeholder="example@mail.com" required>
                </div>
            </div>
            <hr>
            <h4>Contact & Address</h4>
            <div class="inputs" style="gap:.9rem;justify-content:left">
                <div class="data" style="width:23%">
                    <label for="Address">Residential Address <span class="important">*</span></label>
                    <input type="text" name="address" id="address" required>
                </div>
                <div class="data" style="width:23%">
                    <label for="state">State/Region <span class="important">*</span></label>
                    <select name="state_region" id="state_region" required>
                        <option value="" selected disabled>Select State/Region</option>
                        <option value="Abia">Abia</option>
                        <option value="Adamawa">Adamawa</option>
                        <option value="Akwa-Ibom">Akwa-Ibom</option>
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
                <div class="data" style="width:23%">
                    <label for="LGA">LGA / City <span class="important">*</span></label>
                    <input type="text" name="lga" id="lga" required>
                </div>
                <div class="data" style="width:23%">
                    <label for="landmark">Nearest Landmark</label>
                    <input type="text" name="landmark" id="landmark">
                </div>
            </div>
            <hr>
            <h4>Employment/Business Details</h4>
            <div class="inputs" style="gap:.9rem;justify-content:left">
                <div class="data" style="width:23%">
                    <label for="occupation">Occupation <span class="important">*</span></label>
                    <select name="occupation" id="occupation" required>
                        <option value="">--Select Occupation--</option>
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
                <div class="data" style="width:23%">
                    <label for="income">Monthly Income Estimate<span class="important">*</span></label>
                    <input type="text" name="income" id="income" required>
                </div>
                <div class="data" style="width:23%">
                    <label for="business">Business/Company Name<span class="important">*</span></label>
                    <input type="text" name="business" id="business" required>
                </div>
                <div class="data" style="width:23%">
                    <label for="business_address">Business/Company Address<span class="important">*</span></label>
                    <input type="text" name="business_address" id="business_address" required>
                </div>
            </div>
            <hr>
            <h4>Next of Kin Details</h4>
            <div class="inputs" style="gap:.9rem;justify-content:left">
                <div class="data" style="width:23%">
                    <label for="nok">Next of Kin <span class="important">*</span></label>
                    <input type="text" name="nok" id="nok" required>
                </div>
                <div class="data" style="width:23%">
                    <label for="nok">Next of Kin Relationship <span class="important">*</span></label>
                    <input type="text" name="nok_relation" id="nok_relation" required>
                </div>
                <div class="data" style="width:23%">
                    <label for="nok">Next of Kin Address <span class="important">*</span></label>
                    <input type="text" name="nok_address" id="nok_address" required>
                </div>
                <div class="data" style="width:23%">
                    <label for="nok">Next of Kin Phone Number <span class="important">*</span></label>
                    <input type="tel" name="nok_phone" id="nok_phone" required>
                </div>
            </div>
            <hr>
            <h4>Account Details</h4>
            <div class="inputs" style="gap:.9rem;justify-content:left">
                <div class="data" style="width:23%">
                    <label for="bank">Bank <span class="important">*</span></label>
                    <select name="bank" id="bank">
                        <option value="" selected disabled>Select Bank</option>
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
                <div class="data" style="width:23%">
                    <label for="account_number">Account Number <span class="important">*</span></label>
                    <input type="text" name="account_number" id="account_number" required>
                </div>
                <div class="data" style="width:23%">
                    <label for="account_name">Account Name <span class="important">*</span></label>
                    <input type="text" name="account_name" id="account_name" required>
                </div>
            </div>
            <div class="inputs" style="gap:.9rem;justify-content:left">
                <div class="data" style="width:auto">
                    <button type="button" id="add_customer" name="add_customer" onclick="NewRegistration()">Register <i class="fas fa-plus"></i></button>
                </div>
            </div>
</section>    
    </div>
</div>
