<div id="package">
<?php
    session_start();
    if(isset($_SESSION['user_id'])){
        $user = $_SESSION['user_id'];
    include "../classes/dbh.php";
    include "../classes/select.php";
    if(isset($_GET['customer'])){
        $customer_id = htmlspecialchars(stripslashes($_GET['customer']));
    //get customer details
    $get_customer = new selects();
    $cus = $get_customer->fetch_details_group('customers', 'customer', 'customer_id', $customer_id);
    $client = $cus->customer;
    //check for current loan
    $lns = $get_customer->fetch_details_2cond('loan_applications', 'customer', 'loan_status', $customer_id, 0);
    if(is_array($lns)){
        foreach($lns as $ln){
            $loan = $ln->loan_id;
        }
    

?>
<div class="info" style="margin:0!important; width:90%!important"></div>
    <div class="displays allResults" style="width:100%;">
    <div class="add_user_form" style="width:80%; margin:20px 0">
        <h3 style="background:var(--labColor)">Add New Guarantor</h3>
        <!-- <form method="POST" id="addUserForm"> -->
        <section>
            <div class="inputs" style="gap:.5rem;justify-content:left">
                <input type="hidden" name="loan" id="loan" value="<?php echo $loan?>">
                <input type="hidden" name="customer" id="customer" value="<?php echo $customer_id?>">
                <div class="data" style="width:32%;">
                    <label for="business"> Guarantor's Full Name</label>
                    <input type="text" name="full_name" id="full_name" required>
                </div>
                
                <div class="data" style="width:32%;">
                    <label for="relationship"> Relationship</label>
                    <select name="relationship" id="relationship" required>
                        <option value="" selected disabled>--Select Relationship--</option>
                        <option value="Parent">Parent</option>
                        <option value="Sibling">Sibling</option>
                        <option value="Spouse">Spouse</option>
                        <option value="Friend">Friend</option>
                        <option value="Employer">Employer</option>
                        <option value="Colleague">Colleague</option>
                        <option value="Landlord">Landlord/Landlady</option>
                        <option value="Religious Leader">Religious Leader</option>
                        <option value="Community Leader">Community Leader</option>
                        <option value="Business Partner">Business Partner</option>
                        <option value="Neighbor">Neighbor</option>
                        <option value="Guardian">Legal Guardian</option>
                        <option value="Other">Others (specify)</option>
                    </select>
                </div>
                <div class="data" style="width:32%;">
                    <label for="gender"> Gender</label>
                    <select name="gender" id="gender" required>
                        <option value="" selected disabled>Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="data" style="width:32%;">
                    <label for="phone"> Phone Number</label>
                    <input type="tel" name="phone" id="phone" required>
                </div>
                <div class="data" style="width:32%;">
                    <label for="email"> Email Address</label>
                    <input type="email" name="email_add" id="email_add" required>
                </div>
                <div class="data" style="width:32%;">
                    <label for="address"> Residential Address</label>
                    <input type="text" name="address" id="address" required>
                </div>
                <div class="data" style="width:32%;">
                    <label for="occupation">Occupation <span class="important">*</span></label>
                    <select name="occupation" id="occupation" required>
                        <option value="">--Select Occupation--</option>
                        <option value="Doctor">Doctor</option>
                        <option value="Engineer">Engineer</option>
                        <option value="Student">Student</option>
                        <option value="Nurse">Nurse</option>
                        <option value="Clergy">Clergy</option>
                        <option value="Banker">Banker</option>
                        <option value="Trader">Trader</option>
                        <option value="Teacher/Lecturer">Teacher/Lecturer</option>
                        <option value="Business Person">Business Person</option>
                        <option value="Others">Others</option>
                        <option value="Unemployed">Unemployed</option>
                    </select>
                </div>
                <div class="data" style="width:32%">
                    <label for="business">Business/Company Name<span class="important">*</span></label>
                    <input type="text" name="business" id="business" required>
                </div>
                <div class="data" style="width:32%">
                    <label for="business_address">Business/Company Address<span class="important">*</span></label>
                    <input type="text" name="business_address" id="business_address" required>
                </div>
                <div class="data" style="width:auto">
                    <button type="button" id="add_store" name="add_store" onclick="addGuarantor('customer_guarantor.php?customer=<?php echo $customer_id?>')">Add Guarantor <i class="fas fa-user-shield"></i></button>
                </div>
            </div>
        </section>    
    </div>
        <h2>List Of Guarantors</h2>
        <hr>
        <div class="search">
            <input type="search" id="searchGuestPayment" placeholder="Enter keyword" onkeyup="searchData(this.value)">
        </div>
        <table id="priceTable" class="searchTable">
            <thead>
                <tr style="background:var(--labColor)">
                    <td>S/N</td>
                    <td>Loan Applied</td>
                    <td>Guarantor</td>
                    <td>Address</td>
                    <td>Phone No.</td>
                    <td>Email</td>
                    <td>Occupation</td>
                    <td>Business Name</td>
                    <td>Business Address</td>
                    <td>Relationship</td>
                    <td></td>
                </tr>
            </thead>

            
            <tbody>
            <?php
                $n = 1;
                $select_cat = new selects();
                $rows = $select_cat->fetch_details_condOrder('guarantors', 'client', $customer_id, 'full_name');
                if(gettype($rows) == "array"){
                    foreach($rows as $row):
                   
            ?>
                <tr>
                    <td style="text-align:center;"><?php echo $n?></td>
                    
                    <td>
                        <?php 
                            //get current loan
                            $cur_loan = $select_cat->fetch_details_group('loan_applications', 'product', 'loan_id', $row->loan);
                            $product = $cur_loan->product;
                            $loans = $select_cat->fetch_details_cond('loan_products', 'product_id', $product);
                            foreach($loans as $ln){
                                echo $ln->product;
                            }
                        ?>
                    </td>
                    <td><?php echo $row->full_name?></td>
                    <td>
                        <?php
                            echo $row->address;
                        ?>
                    </td>
                    <td>
                        <?php
                            echo $row->phone_number
                        ?>
                    </td>
                    <td>
                        <?php
                            echo $row->email_address;
                        ?>
                    </td>
                    <td>
                        <?php
                            echo $row->occupation;
                        ?>
                    </td>
                    <td>
                        <?php
                            echo $row->business;
                        ?>
                    </td>
                    <td>
                        <?php
                            echo $row->business_address;
                        ?>
                    </td>
                    <td>
                        <?php
                            echo $row->relationship;
                        ?>
                    </td>
                    <td>
                        <a style="background:var(--tertiaryColor)!important; color:#fff!important; padding:3px 6px; margin:2px;border-radius:50%; border:1px solid #fff; box-shadow:1px 1px 1px #222" title="update details" href="javascript:void(0)" onclick="getForm('<?php echo $row->guarantor_id?>', 'get_guarantor.php');"><i class="fas fa-pen"></i></a>
                        
                        
                        
                    </td>
                </tr>
            <?php $n++; endforeach; }?>

            </tbody>

        </table>
        
        <?php
            if(gettype($rows) == "string"){
                echo "<p class='no_result'>'$rows'</p>";
            }
        ?>
    </div>
    
</div>
<?php
    }else{
         echo "<div class='not_available'><p><strong><i class='fas fa-exclamation-triangle' style='color: #cfb20e;'></i> No Active Loan Application</strong><br>The selected customer have no loan application pending. Please help the customer apply for a loan to enable them add guarantors.</p></div>";
    }
}
    }else{
        header("Location: ../index.php");
    }
?>
</div>