<?php
    date_default_timezone_set("Africa/Lagos");
    session_start();
    $date = date("Y-m-d H:i:s");
    $user = $_SESSION['user_id'];
    $kyc = $_GET['kyc'];
    $company = $_SESSION['company'];
    $store = $_SESSION['store_id'];;


    // instantiate class
    include "../classes/dbh.php";
    include "../classes/select.php";
    include "../classes/update.php";
    include "../classes/inserts.php";
    include "../classes/delete.php";
    //get store details
    $get_details = new selects();
    $strs = $get_details->fetch_details_cond('stores', 'store_id', $store);
    foreach($strs as $str){
        $phone = $str->phone_number;
    }
    //get customer
    $rows = $get_details->fetch_details_cond('kyc', 'kyc_id', $kyc);
    foreach($rows as $row){
        $customer = $row->customer;
    }
    //get details 
    $results = $get_details->fetch_details_cond('customers', 'customer_id', $customer);
    foreach($results as $result){
        $client = $result->customer;
        $customer_email = $result->customer_email;
    }
    //approve kyc
    /* $update = new Update_table();
    $update->update_tripple('kyc', 'verification', -1, 'verified_by', $user, 'verified_date', $date, 'kyc_id', $kyc); */
    //delete kyc from customer table
    $delete = new deletes();
    $delete->delete_item('kyc', 'kyc_id', $kyc);
    
    $message = "<p>Dear $client, <br><br> Thank you for submitting your KYC (Know Your Customer) documents.. 🎉<br><br> After a thorough review, we regret to inform you that your KYC verification was unsuccessful due to [brief reason – e.g., incomplete/inaccurate documentation, mismatch of information, expired ID, etc.].<br><br>To proceed, please update and resubmit the required documents through your dashboard or contact our support team for assistance. If you have any questions or need clarification, feel free to reach out to us at [$phone]..<br><br>
Best regards,<br>$company</p>";
    if($delete){
        //insert into notifications
        $notif_data = array(
            'client' => $customer,
            'subject' => 'KYC Verification Unsuccessful',
            'message' => 'Dear '.$client.' , Thank you for submitting your KYC (Know Your Customer) documents.. 
            🎉After a thorough review, we regret to inform you that your KYC verification was unsuccessful due to [brief reason – e.g., incomplete/inaccurate documentation, mismatch of information, expired ID, etc.].<br><br>To proceed, please update and resubmit the required documents through your dashboard or contact our support team for assistance. If you have any questions or need clarification, feel free to reach out to us at ['.$phone.']..

            Best regards,'.$company,
            'post_date' => $date,
        );
        $add_data = new add_data('notifications', $notif_data);
        $add_data->create_data();
        /* send mails to customer */
        function smtpmailer($to, $from, $from_name, $subject, $body){
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPAuth = true; 
    
            $mail->SMTPSecure = 'ssl'; 
            $mail->Host = 'www.dorthpro.com';
            $mail->Port = 465; 
            $mail->Username = 'admin@dorthpro.com';
            $mail->Password = 'yMcmb@her0123!';   
    
    
            $mail->IsHTML(true);
            $mail->From="admin@dorthpro.com";
            $mail->FromName=$from_name;
            $mail->Sender=$from;
            $mail->AddReplyTo($from, $from_name);
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->AddAddress($to);
            $mail->AddAddress('onostarmedia@gmail.com');
            
            if(!$mail->Send())
            {
                $error = "Failed to send mail";
                
                return $error; 
            }
            else 
            {
                
                /* success message */
                
                $error = "Message Sent Successfully";
                
                // header("Location: index.html");
                return $error;
            }
        }
        
        $to = $customer_email;
        $from = 'admin@dorthpro.com';
        $from_name = "$company";
        $name = "$company";
        $subj = 'KYC Verification Unsuccessful';
        $msg = "<div>$message</div>";
        
        $error=smtpmailer($to, $from, $name ,$subj, $msg);
        echo "<div class='success'><p><i class='fas fa-thumbs-up'></i> KYC Approved for $client successfully!</p></div>";
    }