<?php
    session_start();
    if(isset($_SESSION['user_id'])){
        $user = $_SESSION['user_id'];
    include "../classes/dbh.php";
    include "../classes/select.php";
    //get customer details
    $get_customer = new selects();
    $rows = $get_customer->fetch_details_cond('customers', 'user_id', $user);
    foreach($rows as $row){
        $customer_id = $row->customer_id;
    }
    $add_kyc = true;
    //check if customer already added kyc
    $check = new selects();
    $results = $check->fetch_details_cond('kyc', 'customer', $customer_id);
    if(is_array($results) && count($results) > 0){
        //get current kyc status
        foreach($results as $result){
            $kyc_status = $result->verification;
        }
        if($kyc_status == 0){
            $add_kyc = false;
            echo "<div class='not_available'><p><strong><i class='fas fa-exclamation-triangle' style='color: #cfb20e;'></i> KYC awaiting Verification</strong><br>Your KYC is currently undergoing verification. Please wait for the process to complete.</p></div>";
            exit();
        }else{
            echo "<div class='not_available'><p><strong><i class='fas fa-check-circle' style='color: green;'></i> KYC Verified</strong><br>KYC verification is complete. You're all set.</p></div>";
            exit();
        }
    }else{
        
?>

<div id="add_room" class="displays">
     <div class="info" style="width:60%; margin:10px;"></div>
    <div class="add_user_form" style="width:60%; margin:10px; box-shadow:none;background:transparent">
        <h3 style="background:var(--tertiaryColor)!important">KYC / Identity Verification</h3>
        <div class="inputs" style="margin-top:10px; gap:.5rem; display:flex; flex-wrap:wrap; justify-content:space-between">
            <input type="hidden" name="customer_id" id="customer_id" value="<?php echo $customer_id?>">
            <div class="data" style="width:48%">
                <label for="identity_type">Government Issued ID Type</label>
                <select name="id_type" id="id_type" required>
                    <option value="" selected disabled>Select ID type</option>
                    <option value="NIN">NIN</option>
                    <option value="Voter's Card">Voter's Card</option>
                    <option value="Driver's License">Driver's License</option>
                    <option value="International Passport">International Passport</option>
                </select>
            </div>
            <div class="data" style="width:48%">
                <label for="id_number">ID Number</label>
                <input type="text" name="id_number" id="id_number" placeholder="Enter ID number" required>
            </div>
            <div class="data" style="width:48%">
                <label for="id_card">Upload ID photo</label>
                <input type="file" name="id_card" id="id_card" required>
            </div>
            <div class="data" style="width:48%">
                <label for="bvn">BVN</label>
                <input type="text" name="bvn" id="bvn" required>
            </div>
            <div class="data">
                <button type="button" style="border-radius:10px; padding:8px; border:1px solid #fff; box-shadow:1px 1px 1px #222;background:green;color:#fff" onclick="updateKYC()">Update KYC<i class="fas fa-photo"></i></button>
            </div>
        </div>
    </form>
    </div>
</div>
<?php
    }
    }else{
        header("Location: ../index.php");
    }
?>