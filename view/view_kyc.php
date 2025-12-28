<div id="kyc_details">
<?php
    session_start();
    $store = $_SESSION['store_id'];
    include "../classes/dbh.php";
    include "../classes/select.php";
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        // echo $user_id;
        if(isset($_GET['kyc'])){
            $kyc = $_GET['kyc'];
            //get kyc
            $get_kyc = new selects();
            $rows = $get_kyc->fetch_details_cond('kyc', 'kyc_id', $kyc);
            foreach($rows as $row){
                //get client details
                $names = $get_kyc->fetch_details_cond('customers', 'customer_id', $row->customer);
                foreach($names as $name){
                    $customer = $name->customer;
                    $phone = $name->phone_numbers;
                    $ledger = $name->acn;
                    $gender = $name->gender;
                    $dob = $name->dob;
                    $photo = $name->photo;
                    $email = $name->customer_email;
                    $gender = $name->gender;
                    $address = $name->customer_address;
                    $state = $name->state_region;
                    $lga = $name->lga;
                }

?>
<a style="border-radius:15px; background:brown;color:#fff;padding:10px; box-shadow:1px 1px 1px #222"href="javascript:void(0)" onclick="showPage('verify_kyc.php')"><i class="fas fa-close"></i> Close</a>
    <div id="patient_details">
        <h3 style="background:var(--menuColor)">KYC Details for <span><?php echo $customer?></span></h3>
        <!-- <form method="POST" id="addUserForm"> -->
        <section class="nomenclature">
            <div class="profile_foto">
                <img src="<?php echo '../photos/'.$photo?>" alt="Photo">
            </div>
            <div class="inputs">
                
                <div class="data">
                    <label for="prn">Ledger No.:</label>
                    <input type="text" name="prn" id="prn" value="<?php echo $ledger?>" readonly>
                   
                </div>
                <div class="data" >
                    <label for="phone_number">Phone number:</label>
                    <input type="text" name="phone_number" id="phone_number" placeholder="0033421100" required value="<?php echo $phone?>" readonly>
                </div>
                <div class="data">
                    <label for="customer_store">Date of Birth:</label>
                    <?php
                        $date = new DateTime($dob);
                        $now = new DateTime();
                        $interval = $now->diff($date);
                    
                    ?>
                    <input type="text" value="<?php echo date("Y-m-d", strtotime($dob))." (".$interval->y."years)";?>">
                </div>
                <div class="data">
                    <label for="gender">Gender:</label>
                    <input type="text" value="<?php echo $gender?>">
                </div>
                <div class="data" style="width:100%!important">
                    <label for="Address">Address:</label>
                    <input type="text" value="<?php echo $address.", ". $lga.", ".$state?>" readonly style="width:100%!important">
                </div>
                
            </div>
            
        </section>    
       <section id="main_consult">
            <h3>KYC Information</h3>
            <form>
                <div class="inputs" style="align-items:center">
                   
                    <div class="data">
                        <label for="id_type">ID Type</label>
                        <input type="text" value="<?php echo $row->id_type?>" readonly>
                    </div>
                    <div class="data">
                        <label for="id_number">ID Number</label>
                        <input type="text" value="<?php echo $row->id_number?>" readonly>
                    </div>
                    <div class="data">
                        <label for="bvn">BVN</label>
                        <input type="text" value="<?php echo $row->bvn?>" readonly>
                    </div>
                    <div class="data">
                        <a style="border-radius:5px; background:silver;color:#222;padding:10px; box-shadow:1px 1px 1px #222; border:1px solid #fff;" href="../id_cards/<?php echo $row->id_card?>" target="_blank"><i class="fas fa-id-card"></i> View Identity Card</a>
                    </div>
                    <div class="data">
                        <button type="button" style="border-radius:15px; background:var(--tertiaryColor);color:#fff; padding:8px; font-size:.8rem; box-shadow:1px 1px 1px #222; border:1px solid #fff;"href="javascript:void(0)" onclick="approveKYC('<?php echo $kyc?>')">Approve <i class="fas fa-check"></i></button>
                        <button type="button" style="border-radius:15px; background:brown;color:#fff; padding:8px; font-size:.8rem; box-shadow:1px 1px 1px #222; border:1px solid #fff;"href="javascript:void(0)" onclick="declineKYC('<?php echo $kyc?>')">Decline <i class="fas fa-close"></i></button>
                    </div>
                </div>
            </form>
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
