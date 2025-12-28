<div id="edit_customer">
<?php
    session_start();
    $store = $_SESSION['store_id'];
    include "../classes/dbh.php";
    include "../classes/select.php";
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        // echo $user_id;
        if(isset($_GET['customer']) && isset($_GET['loan'])){
            $customer = $_GET['customer'];
            $loan = $_GET['loan'];
            //get customer name
            $get_customer = new selects();
            $rows = $get_customer->fetch_details_cond('customers', 'customer_id', $customer);
            foreach($rows as $row){

?>
<a style="border-radius:15px; background:brown;color:#fff;padding:10px; box-shadow:1px 1px 1px #222"href="javascript:void(0)" onclick="showPage('view_loan_details.php?loan=<?php echo $loan?>')"><i class="fas fa-close"></i> Close</a>
    <div id="patient_details">
        <h3 style="background:var(--tertiaryColor)">Client Details</h3>
        <!-- <form method="POST" id="addUserForm"> -->
        <section class="nomenclature">
            <div class="profile_foto">
                <img src="<?php echo '../photos/'.$row->photo?>" alt="Photo">
            </div>
            <div class="inputs">
                <div class="data">
                    <label for="customer">Full Name:</label>
                    <input type="text" name="last_name" id="last_name" value="<?php echo $row->customer?>" readonly>
                </div>
                
                <div class="data">
                    <label for="prn">Ledger No.:</label>
                    <input type="text" name="prn" id="prn" value="<?php echo $row->acn?>" readonly>
                   
                </div>
                <div class="data">
                    <label for="phone_number">Phone number:</label>
                    <input type="text" name="phone_number" id="phone_number" placeholder="0033421100" required value="<?php echo $row->phone_numbers?>" readonly>
                </div>
                <div class="data">
                    <label for="email">Email address:</label>
                    <input type="text" name="email" id="email" required value="<?php echo $row->customer_email?>" readonly>
                </div>
                <div class="data">
                    <label for="customer_store">Date of birth:</label>
                    <?php
                        $date = new DateTime($row->dob);
                        $now = new DateTime();
                        $interval = $now->diff($date);
                    
                    ?>
                    <input type="text" value="<?php echo date("Y-m-d", strtotime($row->dob))." (".$interval->y."years)";?>">
                </div>
                <div class="data">
                    <label for="gender">Gender:</label>
                    <input type="text" value="<?php echo $row->gender?>">
                </div>
            </div>
            <div class="inputs" style="width:95%">
                <div class="data" style="width:32%">
                    <label for="Address">Address:</label>
                    <input type="text" value="<?php echo $row->customer_address?>" readonly>
                </div>
                <div class="data" style="width:32%">
                    <label for="category">State:</label>
                    <input type="text" value="<?php echo $row->state_region?>" readonly>
                </div>
                <div class="data" style="width:32%">
                    <label for="category">LGA/City:</label>
                    <input type="text" value="<?php echo $row->lga?>" readonly>
                </div>
                <div class="data" style="width:32%">
                    <label for="category">Landmark:</label>
                    <input type="text" value="<?php echo $row->landmark?>" readonly>
                </div>
                <div class="data" style="width:32%">
                    <label for="category">Marital Status:</label>
                    <input type="text" value="<?php echo $row->marital_status?>" readonly>
                </div>
                <div class="data" style="width:32%">
                    <label for="category">Religion:</label>
                    <input type="text" value="<?php echo $row->religion?>" readonly>
                </div>
                
                
            </div>
        </section>    
        <section id="prescriptions">
            <h3 style="background:var(--menuColor); color:#fff; text-align:left">Employment details</h3>
            <div class="nomenclature" style="box-shadow:none">
                <div class="inputs" style="width:100%; align-items:flex-end">
                    <div class="data" style="width:auto!important">
                        <label style="background:transparent; color:green; text-align:left; width:auto" for="customer">Occupation:</label>
                        <input type="text" name="last_name" id="last_name" value="<?php echo $row->occupation?>" readonly>
                    </div>
                    <div class="data" style="width:auto!important">
                        <label style="background:transparent; color:green; text-align:left; width:auto" for="other_names">Estimated Monthly Income (NGN):</label>
                        <input type="text"  value="<?php echo $row->income?>" readonly>
                    
                    </div>
                    <div class="data"style="width:auto!important">
                        <label style="background:transparent; color:green; text-align:left; width:auto" for="other_names">Business/Company Name:</label>
                        <input type="text"  value="<?php echo $row->business?>" readonly>
                    
                    </div>
                    <div class="data" style="width:auto!important">
                        <label style="background:transparent; color:green; text-align:left;width:auto" for="other_names">Business/Company Address:</label>
                        <input type="text"  value="<?php echo $row->business_address?>" readonly>
                    
                    </div>
                </div>
                
            </div>
        </section>
        <section id="main_consult">
            <h3 style="background:var(--otherColor); text-align:left">Next of Kin Information</h3>
            <div class="nomenclature" style="box-shadow:none">
                <div class="inputs" style="width:100%; align-items:flex-end">
                    <div class="data" style="width:auto!important">
                        <label style="background:transparent; color:green; text-align:left; width:auto" for="customer">Full Name:</label>
                        <input type="text" name="last_name" id="last_name" value="<?php echo $row->nok?>" readonly>
                    </div>
                    <div class="data" style="width:auto!important">
                        <label style="background:transparent; color:green; text-align:left; width:auto" for="other_names">Relationship:</label>
                        <input type="text"  value="<?php echo $row->nok_relation?>" readonly>
                    
                    </div>
                    <div class="data"style="width:auto!important">
                        <label style="background:transparent; color:green; text-align:left; width:auto" for="other_names">Phone Number:</label>
                        <input type="text"  value="<?php echo $row->nok_phone?>" readonly>
                    
                    </div>
                    <div class="data" style="width:auto!important">
                        <label style="background:transparent; color:green; text-align:left;width:auto" for="other_names">Residential Address:</label>
                        <input type="text"  value="<?php echo $row->nok_address?>" readonly>
                    
                    </div>
                    
                </div>
                
            </div>
        </section>
        <section id="last_consult">
            <h3 style="background:var(--primaryColor); text-align:left; color:#fff;">Bank details</h3>
            <div class="nomenclature" style="box-shadow:none">
                <div class="inputs" style="width:100%; align-items:flex-end">
                    <div class="data" style="width:auto!important">
                        <label style=" width:auto" for="customer">Bank:</label>
                        <input type="text" name="last_name" id="last_name" value="<?php echo $row->bank?>" readonly>
                    </div>
                    <div class="data" style="width:auto!important">
                        <label style="width:auto" for="other_names">Account Number:</label>
                        <input type="text"  value="<?php echo $row->account_number?>" readonly>
                    
                    </div>
                    <div class="data"style="width:auto!important">
                        <label style="width:auto" for="other_names">Account Name:</label>
                        <input type="text"  value="<?php echo $row->account_name?>" readonly>
                    
                    </div>
                </div>
                
                 <div class="data" style="border:none">
                    <a style="border-radius:15px; background:brown;color:#fff;padding:10px; box-shadow:1px 1px 1px #222"href="javascript:void(0)" onclick="showPage('customer_list.php')"><i class="fas fa-close"></i> Close</a>
                </div>
            </div>
        </section>
    </div>

<?php
            }
        }
    }else{
        header("Location: ../index.php");
    }
?>
</div>
