<?php
    date_default_timezone_set("Africa/Lagos");

    session_start();
    $user = $_SESSION['user_id'];
    $store = $_SESSION['store_id'];
    $customer = strtoupper(htmlspecialchars(stripslashes($_POST['full_name'])));
    // $other_names = strtoupper(htmlspecialchars(stripslashes($_POST['other_names'])));
    $phone = htmlspecialchars(stripslashes($_POST['phone_number']));
    $address = ucwords(htmlspecialchars(stripslashes($_POST['address'])));
    $email = htmlspecialchars(stripslashes($_POST['email']));
    $dob = htmlspecialchars(stripslashes($_POST['dob']));
    $gender = htmlspecialchars(stripslashes($_POST['gender']));
    $marital_status = htmlspecialchars(stripslashes($_POST['marital_status']));
    $religion = htmlspecialchars(stripslashes(($_POST['religion'])));
    $occupation = htmlspecialchars(stripslashes($_POST['occupation']));
    $income = htmlspecialchars(stripslashes($_POST['income']));
    $business = htmlspecialchars(stripslashes($_POST['business']));
    $biz_address = htmlspecialchars(stripslashes($_POST['business_address']));
    $bank = htmlspecialchars(stripslashes($_POST['bank']));
    $account_number = htmlspecialchars(stripslashes($_POST['account_number']));
    $account_name = strtoupper(htmlspecialchars(stripslashes($_POST['account_name'])));
    $state = strtoupper(htmlspecialchars(stripslashes($_POST['state_region'])));
    $lga = strtoupper(htmlspecialchars(stripslashes($_POST['lga'])));
    $landmark = ucwords(htmlspecialchars(stripslashes($_POST['landmark'])));
    $nok = strtoupper(htmlspecialchars(stripslashes($_POST['nok'])));
    $nok_address = ucwords(htmlspecialchars(stripslashes($_POST['nok_address'])));
    $nok_phone = htmlspecialchars(stripslashes($_POST['nok_phone']));
    $relation = strtoupper(htmlspecialchars(stripslashes($_POST['nok_relation'])));
    $date = date("Y-m-d H:i:s");
    $todays_date = date("dmyh");
   
    $data = array(
        'customer' => $customer,
        'phone_numbers' => $phone,
        'customer_email' => $email,
        'customer_address' => $address,
        'state_region' => $state,
        'lga' => $lga,
        'landmark' => $landmark,
        'gender' => $gender,
        'dob' => $dob,
        'occupation' => $occupation,
        'religion' => $religion,
        'marital_status' => $marital_status,
        'nok' => $nok,
        'nok_address' => $nok_address,
        'nok_phone' => $nok_phone,
        'nok_relation' => $relation,
        'business' => $business,
        'business_address' => $biz_address,
        'income' => $income,
        'bank' => $bank,
        'account_number' => $account_number,
        'account_name' => $account_name,
        'photo' => 'user.png',
        'reg_status' => 0, // 0 for not verified
        'reg_date' => $date,
        'created_by' => $user,
        'cso' => $user,
    );
    $ledger_data = array(
        'account_group' => 1,
        'sub_group' => 1,
        'class' => 4,
        'ledger' => $customer
    );
    // instantiate class
    include "../classes/dbh.php";
    include "../classes/select.php";
    include "../classes/inserts.php";
    include "../classes/update.php";

   //check if customer exists
   
   $check = new selects();
   $results = $check->fetch_count_cond('customers', 'customer', $customer);
   $results2 = $check->fetch_count_cond('customers', 'phone_numbers', $phone);
   if($results > 0 || $results2 > 0){
       echo "<p class='exist' style='background:red;color:#fff;'><span>$customer</span> already exists!</p>";
   }else{
        //check if customer is in ledger
        $get_ledger = new selects();
        $ledg = $get_ledger->fetch_count_cond('ledgers', 'ledger', $customer);
        if($ledg > 0){
            echo "<p class='exist'  style='background:red;color:#fff;><span>$customer</span> already exists in ledger</p>";
        }else{
            //create customer
            $add_data = new add_data('customers', $data);
            $add_data->create_data();
            if($add_data){
                //get customer id first
                $get_id = new selects();
                $ids = $get_id->fetch_lastInserted('customers', 'customer_id');
                $customer_id = $ids->customer_id;
                //add to users  table
                $user_data = array(
                    'full_name' => $customer,
                    'username' => $phone, //use phone number as username
                    'user_password' => 123, //default password
                    'user_role' => 'Client', //default role
                    'store' => $store,
                    'status' => 0, //0 for  active
                    'reg_date' => $date,
                );
                $add_user = new add_data('users', $user_data);
                $add_user->create_data();
                if($add_user){
                    //get user id
                    $user_ids = $get_id->fetch_lastInserted('users', 'user_id');
                    $user_id = $user_ids->user_id;
                    //now update customer with user id
                    $update = new Update_table();
                    $update->update('customers', 'user_id', 'customer_id', $user_id, $customer_id);
                    //add account ledger
                    $add_ledger = new add_data('ledgers', $ledger_data);
                    $add_ledger->create_data();
                    //update customer ledger no
                    //first get ledger id from ledger table
                    $get_last = new selects();
                    $legd = $get_last->fetch_lastInserted('ledgers', 'ledger_id');
                    $ledger_id = $legd->ledger_id;
                    //update account number
                    $acn = "10104".$ledger_id;
                    $update_acn = new Update_table();
                    $update_acn->update('ledgers', 'acn', 'ledger_id', $acn, $ledger_id);
                    //now update
                    $update = new Update_table();
                    $update->update_double('customers', 'ledger_id', $ledger_id, 'acn', $acn, 'customer_id', $customer_id);
                    echo "<div class='success'><p><span>$customer </span> registered successfully!</p></div>";
?>
<style>
    .add_user_form .data{
        width:48%;
    }
    @media screen and (max-width: 800px) {
        .add_user_form .data{
            width:100%;
        }
        .add_user_form .inputs{
            flex-direction: column;
        }
    }
</style>
    <!-- display update photoform -->
     <div class="info"></div>
    <div class="add_user_form" style="width:60%; margin:10px auto; box-shadow:none;background:transparent">
        <h3 style="background:var(--tertiaryColor)!important">KYC / Identity Verification</h3>
        <div class="inputs" style="margin-top:10px; gap:1rem; display:flex; flex-wrap:wrap;">
             <div class="data">
                <figure>
                    <img src="../photos/user.png" alt="user photo" id="photo" style="width:100%; height:150px; object-fit:cover; border-radius:10px; box-shadow:1px 1px 1px #222">
                </figure>
             </div>
             <div class="data">
                <button type="button" style="border-radius:10px; padding:8px; border:1px solid #fff; box-shadow:1px 1px 1px #222;background:silver;color:#222" id="upload_photo" name="upload_photo" onclick="updatePhoto('<?php echo $customer_id?>')">Update Photo<i class="fas fa-photo"></i></button>
            </div>
        </div>
        <div class="inputs" style="margin-top:10px; gap:.5rem; display:flex; flex-wrap:wrap; justify-content:space-between">
            <input type="hidden" name="customer_id" id="customer_id" value="<?php echo $customer_id?>">
            <div class="data">
                <label for="identity_type">Government Issued ID Type</label>
                <select name="id_type" id="id_type" required>
                    <option value="" selected disabled>Select ID type</option>
                    <option value="NIN">NIN</option>
                    <option value="Voter's Card">Voter's Card</option>
                    <option value="Driver's License">Driver's License</option>
                    <option value="International Passport">International Passport</option>
                </select>
            </div>
            <div class="data">
                <label for="id_number">ID Number</label>
                <input type="text" name="id_number" id="id_number" placeholder="Enter ID number" required>
            </div>
            <div class="data">
                <label for="id_card">Upload ID photo</label>
                <input type="file" name="id_card" id="id_card" required>
            </div>
            <div class="data">
                <label for="bvn">BVN</label>
                <input type="text" name="bvn" id="bvn" required>
            </div>
            <div class="data">
                <button type="button" style="border-radius:10px; padding:8px; border:1px solid #fff; box-shadow:1px 1px 1px #222;background:green;color:#fff" onclick="updateKYC()">Update KYC<i class="fas fa-photo"></i></button>
            </div>
        </div>
    </form>
    </div>
<?php
                }
            }
        }
   }