<?php
    $customer_id = htmlspecialchars(stripslashes($_POST['customer']));
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
   
    // instantiate class
    include "../classes/dbh.php";
    include "../classes/update.php";
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
        
    );
       //update customer
       $update_data = new Update_table();
       $update_data->updateAny('customers', $data, 'customer_id', $customer_id);
       if($update_data){
           echo "<div class='success'><p>$customer</span> details updated successfully! <i class='fas fa-thumbs-up'></i></p></div>";
       }
   