<div id="loan_application">

<?php
    session_start();    
    include "../classes/dbh.php";
    include "../classes/select.php";
    if(!isset($_SESSION['user_id'])) {
        header("Location: ../index.php");
        exit();
    }else{
        if(isset($_GET['customer'])){
            $customer = $_GET['customer'];
            $get_details = new selects();
            //get customer details
            $customer_details = $get_details->fetch_details_cond('customers', 'customer_id', $customer);
            if(is_array($customer_details)){
                foreach($customer_details as $detail){
                    $customer_name = $detail->customer;
                }
            }
        //check if kyc has been submitted
        $details = $get_details->fetch_details_cond('kyc', 'customer', $customer);
        if(is_array($details)){
            foreach($details as $detail){
                $kyc_status = $detail->verification;
            }
            //check if kyc has been verified
            if($kyc_status == "0"){
?>
            <div class="not_available">
                <p><strong>KYC Pending Approval <i class="fas fa-spinner" style="color:var(--tertiaryColor)"></i></strong><br>Customer have submitted KYC details, but verification is still pending.<br>Please wait for approval before proceeding with your loan application.</p>

            </div>
<?php
            }else{
                $can_apply = true;
                //check for current loan applications
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
                            <p><strong>Existing Loan Application <i class='fas fa-exclamation-triangle' style='color:#cfb20e'></i></strong><br>The customer currently has a pending loan application for $product_name awaiting approval. Please process or resolve the existing application before initiating a new one.</p>
                            </div>";
                            exit();
                        }elseif($exist->loan_status == 1){
                            $can_apply = false;
                            echo "<div class='not_available'>
                            <p><strong><i class='fas fa-exclamation-triangle' style='color: #cfb20e;'></i> Loan Application Pending Disbursement</strong><br>The customer currently has an active $product_name loan awaiting disbursement. Please note: A new loan application cannot be submitted until the current loan is fully disbursed and repaid</p></div>";
                            exit();
                        }elseif($exist->loan_status == 2){
                            $can_apply = false;
                            echo "<div class='not_available'>
                            <p><strong><i class='fas fa-exclamation-triangle' style='color: #cfb20e;'></i> Existing Live Loan Detected</strong><br>The customer is still repaying an active $product_name loan. A new application can only be submitted once the current loan is fully settled.</p></div>";
                            exit();
                        }else{
                            $can_apply = true;
                        }
                    }
                }
                if($can_apply){
                    include "customer_application_form.php";
                }
            }
        }else{
    ?>
        <div class="not_available">
            <p><strong>KYC Not Submitted <i class="fas fa-exclamation-triangle" style="color:#cfb20e"></i></strong><br>Selected Customer needs to complete KYC verification before applying for a loan.<br><br>:</p>
        </div>
    <?php
        }
        }else{
        echo "<div class='not_available'><p><strong>Error: Customer ID not provided.</strong></p></div>";
    }
    }
    
    
    ?>
</div>