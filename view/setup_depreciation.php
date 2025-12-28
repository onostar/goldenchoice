<?php
    include "../classes/dbh.php";
    include "../classes/select.php";
?>
<div id="depreciation" class="displays">
    <div class="info" style="width:40%;margin:0"></div>
    <div class="add_user_form" style="width:30%; margin:0">
        <h3>Setup Depreciation</h3>
        <!-- <form method="POST" id="addUserForm"> -->
        <section class="addUserForm">
            <div class="inputs" style="gap:1rem">
                <div class="data" style="width:100%">
                    <label for="group">Select Asset</label>
                    <select name="asset" id="asset">
                        <option value=""selected required>Select asset</option>
                        <?php
                            $get_dep = new selects();
                            $rows = $get_dep->fetch_details('assets');
                            foreach($rows as $row){
                        ?>
                        <option value="<?php echo $row->asset_id?>"><?php echo $row->asset?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="data" style="width:100%">
                    <label for="sub_group">Useful Life</label>
                    <select name="useful_life" id="useful_life">
                        <option value="">Select useful life</option>
                        <option value="1">1 Year</option>
                        <option value="2">2 Years</option>
                        <option value="3">3 Years</option>
                        <option value="4">4 Years</option>
                        <option value="5">5 Years</option>
                        <option value="6">6 Years</option>
                        <option value="7">7 Years</option>
                        <option value="8">8 Years</option>
                        <option value="9">9 Years</option>
                        <option value="10">10 Years</option>
                        <option value="11">11 Years</option>
                        <option value="12">12 Years</option>
                        <option value="50">50 Years</option>
                    </select>
                </div>
                <div class="data" style="width:100%">
                    <label for="class">Start Date</label>
                    <input type="date" name="start_date" id="start_date">
                </div>
                
            </div>
            <div class="inputs">
                <button type="submit" id="add_cat" name="add_cat" onclick="addDepreciation()">Save record <i class="fas fa-layer-group"></i></button>
            </div>
                            </section>    
    </div>
</div>
