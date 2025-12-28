
    <div class="comp_details">
        <div class="comp">
            <div class='receipt_logo'><img src="../images/jevi.png" title="logo"></div>
            <div class="com_name">
                <h2><?php echo $_SESSION['company'];?></h2>
                <p><?php echo $address?></p>
                <p>Tel: <?php echo $phone?></p>
            </div>
            
        </div>
        <div class="inv_val">
            <h2>INVOICE</h2>
            <p><strong><span>DATE: </span></strong><?php echo date("d-M-Y", strtotime($paid_date))?></p>
            <p><strong><span>DUE DATE: </span></strong><?php echo date("d-M-Y", strtotime($due_date))?></p>
            <p><strong><span>REF NO.: </span></strong><?php echo $invoice?></p>
        </div>
    </div>
    <!-- get sales type -->
       

    <div class="receipt_head">
        
        
