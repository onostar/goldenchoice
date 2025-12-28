<?php
    date_default_timezone_set("Africa/Lagos");
    session_start();
    $date = date("Y-m-d H:i:s");
    $user = $_SESSION['user_id'];
    $store = $_SESSION['store_id'];
    $loan = $_GET['loan'];
    $disburse_date = date("jS F, Y", strtotime($date));

    $company = $_SESSION['company'];
    require "../PHPMailer/PHPMailerAutoload.php";
    require "../PHPMailer/class.phpmailer.php";
    require "../PHPMailer/class.smtp.php";

    // instantiate class
    include "../classes/dbh.php";
    include "../classes/select.php";
    include "../classes/update.php";
    include "../classes/inserts.php";

    //get details
    $get_details = new selects();
    $rows = $get_details->fetch_details_cond('loan_applications', 'loan_id', $loan);
    foreach($rows as $row){
        $customer = $row->customer;
        $product = $row->product;
        $interest = $row->interest;
        $processing = $row->processing_fee;
        $installment_payment = $row->installment;
        $total = $row->total_payable;
        $loan_term = $row->loan_term;
        $frequency = $row->frequency;
        $asset = $row->asset;
        $amount = $row->amount;
    }
    //get loan officer dertails
    $officer = $get_details->fetch_details_group('users', 'full_name', 'user_id', $user);
    $loan_officer = $officer->full_name;
    //get customer details 
    $results = $get_details->fetch_details_cond('customers', 'customer_id', $customer);
    foreach($results as $result){
        $client = $result->customer;
        $customer_email = $result->customer_email;
        $ledger = $result->acn;

    }
    //approve loan
    $update = new Update_table();
    if($asset == 0){
        $update->update_tripple('loan_applications', 'loan_status', 1, 'approved_by', $user, 'approve_date', $date, 'loan_id', $loan);
        //email message
        $message = "<p>Dear $client, <br> We’re pleased to inform you that your loan application has been approved ✅.<br><br>Your loan is now awaiting disbursement, and you will receive a notification once the funds have been released to your account.<br><br>Thank you for choosing us. We’re excited to support your financial journey!.<br><br>Best regards,<br>$company</p>";
        //insert into notifications
        $notif_data = array(
            'client' => $customer,
            'subject' => 'Your Loan Has Been Approved',
            'message' => 'Dear '.$client.', 

            We’re pleased to inform you that your loan application has been approved ✅.
            
            Your loan is now awaiting disbursement, and you will receive a notification once the funds have been released to your account.
            
            Thank you for choosing us. We’re excited to support your financial journey!
            
            Best regards,
            '.$company,
            'post_date' => $date,
        );
        $add_data = new add_data('notifications', $notif_data);
        $add_data->create_data();
    }else{
       //get asset name
        $prods = $get_details->fetch_details_cond('items', 'item_id', $asset);
        foreach($prods as $prod){
            $product_name = $prod->item_name;
        }
        $todays_date = date("dmyhis");
        $ran_num ="";
        for($i = 0; $i < 3; $i++){
            $random_num = random_int(0, 9);
            $ran_num .= $random_num;
        }
        $trx_num = "TR".$ran_num.$todays_date;
        //calculate repayment dates
        //first get total installments
        if($frequency == "Weekly"){
            $installments = $loan_term * 4;
        }elseif($frequency === "Monthly") {
            $installments = $loan_term;
        }elseif($frequency === "Yearly") {
            $installments = $loan_term / 12; // convert months to years
        }else{
            $installments = 1; // fallback
        }
        //disbursement data
        $data = array(
            'loan' => $loan,
            'customer' => $customer,
            'amount' => $amount,
            'mode' => '',
            'bank' => 0,
            'trx_date' => $date,
            'disbursed_by' => $user,
            'disbursed_date' => $date,
            'store' => $store,
            'trx_number' => $trx_num
        );
        $add_data = new add_data('disbursal', $data);
        $add_data->create_data();
        if($add_data){
            //now calculate repayment dates base on disbursal date
            $disbursement_date = new DateTime($date);
            $repayment_dates = [];
            for($i = 1; $i <= $installments; $i++){
                $due_date = clone $disbursement_date;
                if($frequency == "Weekly") {
                    $due_date->modify("+" . (7 * $i) . " days");
                }elseif ($frequency == "Monthly") {
                    $due_date->modify("+" . $i . " months");
                }elseif ($frequency == "Yearly") {
                    $due_date->modify("+" . $i . " years");
                }

                // Prepare data for insertion
                $repayment_data = array(
                    'loan' => $loan,
                    'customer' => $customer,
                    'due_date' => $due_date->format('Y-m-d'),
                    'amount_due' => $installment_payment,
                    'store' => $store,
                    'posted_by' => $user,
                    'post_date' => $date
                );
                // Insert into repayment_schedule table
                $insert_repayment = new add_data('repayment_schedule', $repayment_data);
                $insert_repayment->create_data();
            }
            //get first repayment date
            $first_ids = $get_details->fetch_lastInsertedConAsc('repayment_schedule', 'due_date', 'loan', $loan);
            foreach($first_ids as $first_id){
                $first_repayment_date = $first_id->due_date;
            }
            //get last repayment date
            $last_ids = $get_details->fetch_lastInsertedCon('repayment_schedule', 'due_date', 'loan', $loan);
            foreach($last_ids as $last_id){
                $last_repayment_date = $last_id->due_date;
            }
            //update loan status to disbursed
            $update = new Update_table();
            $update->update_multiple('loan_applications', 'loan_status', 2, 'approved_by', $user, 'approve_date', $date, 'disbursed_date', $date, 'due_date', $last_repayment_date, 'loan_id', $loan);
            $amount = number_format($amount, 2);
            $interest = number_format($interest, 2);
            $processing = number_format($processing, 2);
            $total = number_format($total, 2);
            $message = "<p>Dear $client, <br> We are pleased to inform you that your loan of ₦$amount for $product_name has been successfully approved on $disburse_date.
            <h3 style='color:red'>Application Details:</h3>
            <ul>
                <li><strong>Product:</strong> $product_name</li>
                <li><strong>Amount:</strong> NGN$amount</li>
                <li><strong>Interest:</strong> NGN$interest</li>
                <li><strong>Processing Fee:</strong> NGN$processing</li>
                <li><strong>Total Payable:</strong> NGN$total</li>
                <li><strong>Repayment Term:</strong> $loan_term Months</li>
                <li><strong>Repayment Frequency:</strong> $frequency</li>
                <li><strong>First Repayment Date:</strong> $first_repayment_date</li>
            </ul>
            <br><p>Please ensure that your repayments are made as scheduled to maintain a good credit standing.</p>
            <p>You can log in to your account to view your repayment schedule and loan status.</p>
            <p>If you have any questions or need assistance, feel free to reach out to us.</p><br>
            <p>Thank you for choosing $company</p>
            <p>Warm regards,<br>
            **$loan_officer**<br> 
            $company";
            //insert into notifications
            $notif_data = array(
                'client' => $customer,
                'subject' => 'Your Asset Loan Has Been Approved',
                'message' => 'Dear '.$client.',
                We are pleased to inform you that your loan of ₦'.$amount. ' for '.$product_name.' has been successfully approved on '.$disburse_date.'
                LOAN DETAILS:
                * Asset Product: '.$product_name.'
                * Loan Amount: NGN'.$amount.'
                * Interest: NGN'.$interest.'
                * Processing Fee: NGN'.$processing.'
                * Total Payable: NGN'.$total.'
                * Repayment Term: '.$loan_term.' Months
                * Repayment Frequency: '.$frequency.'
                * First Repayment Date: '.$first_repayment_date.'

                Please ensure that your repayments are made as scheduled to maintain a good credit standing.

                You can click on loan status to view your status and repayment schedule.
                If you have any questions or need assistance, feel free to reach out to us.

                Thank you for choosing '.$company.'
                Warm regards,
                **'.$loan_officer.'**'
                .$company,
                'post_date' => $date,
            );
            $add_data = new add_data('notifications', $notif_data);
            $add_data->create_data();
        }
    }
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
            // $mail->AddAddress('onostarmedia@gmail.com');
            
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
        $subj = 'Your Loan Has Been Approved';
        $msg = "<div>$message</div>";
        
        $error=smtpmailer($to, $from, $name ,$subj, $msg);
        ?>
        <div class='not_available'>
        <p><i class='fas fa-check-circle' style='color: #28a745;'></i> Loan Application Approved Successfully</p><br>
        <a href="javascript:void(0)" style="padding:5px;background:var(--tertiaryColor);color:#fff;box-shadow:1px 1px 1px #222; text-align:center;" onclick="showPage('../view/pending_applications.php')"> Continue <i class="fas fa-paper-plane"></i></a></div>
    <?php
    