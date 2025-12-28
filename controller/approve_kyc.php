<?php
    date_default_timezone_set("Africa/Lagos");
    session_start();
    $date = date("Y-m-d H:i:s");
    $user = $_SESSION['user_id'];
    $kyc = $_GET['kyc'];
    $company = $_SESSION['company'];
    require "../PHPMailer/PHPMailerAutoload.php";
    require "../PHPMailer/class.phpmailer.php";
    require "../PHPMailer/class.smtp.php";

    // instantiate class
    include "../classes/dbh.php";
    include "../classes/select.php";
    include "../classes/update.php";
    include "../classes/inserts.php";

    //get customer
    $get_details = new selects();
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
    $update = new Update_table();
    $update->update_tripple('kyc', 'verification', 1, 'verified_by', $user, 'verified_date', $date, 'kyc_id', $kyc);
    //update reg status in customer table
    $update->update('customers', 'reg_status', 'customer_id', 1, $customer);
    $message = "<p>Dear $client, <br> We’re happy to inform you that your KYC verification has been successfully completed. 🎉<br><br> Your account is now fully verified, and you can enjoy uninterrupted access to all features and services.<br><br>Thank you for completing the verification process. If you have any questions or need assistance, feel free to reach out to our support team.<br><br>
Best regards,<br>$company</p>";
    if($update){
        //insert into notifications
        $notif_data = array(
            'client' => $customer,
            'subject' => 'KYC Verification Approved',
            'message' => 'Dear '.$client.', 

            We’re happy to inform you that your KYC verification has been successfully completed. 🎉
            
            Your account is now fully verified, and you can enjoy uninterrupted access to all features and services.

            Thank you for completing the verification process. If you have any questions or need assistance, feel free to reach out to our support team.
            
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
            $mail->Host = 'www.dorthprosuite.com';
            $mail->Port = 465; 
            $mail->Username = 'admin@dorthprosuite.com';
            $mail->Password = 'yMcmb@her0123!';   
    
    
            $mail->IsHTML(true);
            $mail->From="admin@dorthprosuite.com";
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
        $from = 'admin@dorthprosuite.com';
        $from_name = "$company";
        $name = "$company";
        $subj = 'KYC Verification Approved';
        $msg = "<div>$message</div>";
        
        $error=smtpmailer($to, $from, $name ,$subj, $msg);
        echo "<div class='success'><p><i class='fas fa-thumbs-up'></i> KYC Approved for $client successfully!</p></div>";
    }