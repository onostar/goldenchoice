<div id="loan_application">

<?php
    session_start();    
    include "../classes/dbh.php";
    include "../classes/select.php";
    if(!isset($_SESSION['user_id'])) {
        header("Location: ../index.php");
        exit();
    }else{
       
        $customer = $_SESSION['client_id'];
        
        //check if kyc has been submitted
        $get_details = new selects();
        $details = $get_details->fetch_details_cond('kyc', 'customer', $customer);
        if(is_array($details)){
            foreach($details as $detail){
                $kyc_status = $detail->verification;
            }
            //check if kyc has been verified
            if($kyc_status == "0"){
?>
            <div class="not_available">
                <p><strong>KYC Pending Approval <i class="fas fa-spinner" style="color:var(--tertiaryColor)"></i></strong><br>You have submitted your KYC details, but verification is still pending.<br>Please wait for approval before proceeding with your loan application.</p>

            </div>
<?php
            }else{
                //check for current loan applications
                $can_apply = true;
                $existing = $get_details->fetch_details_cond('loan_applications', 'customer', $customer);
                if(is_array($existing)){
                    foreach($existing as $exist){
                        //get loan product details
                        $product_details = $get_details->fetch_details_cond('loan_products', 'product_id', $exist->product);
                        if(is_array($product_details)){
                            foreach($product_details as $detail){
                                $product_name = $detail->product;
                            }
                        }
                        if($exist->loan_status == 0){
                            $can_apply = false;
                            echo "<div class='not_available'>
                            <p><strong>Existing Loan Application <i class='fas fa-exclamation-triangle' style='color:#cfb20e'></i></strong><br>You have an existing $product_name loan application pending approval. Please wait for it to be processed.</p>
                            </div>";
                            exit();
                        }elseif($exist->loan_status == 1){
                            $can_apply = false;
                            echo "<div class='not_available'>
                            <p><strong><i class='fas fa-exclamation-triangle' style='color: #cfb20e;'></i> Loan Application Pending Disbursement</strong><br>You currently have an active $product_name loan awaiting disbursement. Please note that you are not eligible to apply for a new loan until your current loan application is fully disbursed and repaid.</p></div>";
                            exit();
                        }elseif($exist->loan_status == 2){
                            $can_apply = false;
                            echo "<div class='not_available'>
                            <p><strong><i class='fas fa-exclamation-triangle' style='color: #cfb20e;'></i> Existing Live Loan Detected</strong><br>You currently have an active $product_name loan. Please note that you are not eligible to apply for a new loan until your current loan is fully repaid.</p></div>";
                            exit();
                        
                        }else{
                            $can_apply = true;
                        }
                    }
                }
                if($can_apply){
                    include "application_form.php";
                }
            }
        }else{
    ?>
        <div class="not_available">
            <p><strong>KYC Not Submitted <i class="fas fa-exclamation-triangle" style="color:#cfb20e"></i></strong><br>You need to complete your KYC verification before applying for a loan.<br><br>

            Click the button below to submit your KYC details and wait for approval:</p>

                <a href="javascript:void(0)" title="submit KYC" onclick="showPage('upload_kyc.php')">Submit KYC <i class="fa fa-id-badge"></i></a>
        </div>
    <?php
        }
        }
    
    ?>
</div>