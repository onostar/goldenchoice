<?php

    if(isset($_GET['loan']) && isset($_GET['customer'])){
        $loan = $_GET['loan'];
        $customer = $_GET['customer'];
?>
    <h3 style="background:transparent; text-align:left; color:#222; font-size:.8rem">Request More Information from client</h3>
    <form action="" class="add_user_form" style="width:50%!important; margin:0 10px;padding:15px; box-shadow:1px 1px 1px #c4c4c4;">
        <div class="inputs">
            <input type="hidden" name="customer" id="customer" value="<?php echo $customer?>">
            <input type="hidden" name="loan" id="loan" value="<?php echo $loan?>">
            <div class="data" style="margin:10px 0">
                <label for="">Request Details</label>
                <textarea name="request_text" id="request_text" placeholder="please input request here"></textarea>
            </div>
            <div class="data">
                <button type="button" onclick="sendInfoRequest()"style="font-size:.8rem">Send Request <i class="fas fa-info-circle"></i></button>
                <button type="button" onclick="closeRequestForm()"style="font-size:.8rem; background:var(--secondaryColor)">Close <i class="fas fa-close"></i></button>
                
            </div>
        </div>
    </form>

<?php
    }