<?php 
    /* @var $user User */
    $user = $param["user"];

?>
<div class='container'>
    <form novalidate="true" class='row' action='admin?action=submitUser&user_id=<?php echo $user->getUserID() ?>' method='POST' id='user-wrapper' data-user-id='<?php echo $user->getUserID() ?>'>
        <div class='container-fluid'>
            <div class='row form-group'>
                <div class='col-sm-2 col-sm-offset-1'>
                    Username:
                </div>
                <div class='col-sm-5'>
                    <input type='text' class='form-control' value='<?php echo $user->getUsername(); ?>' disabled>   
                </div>
            </div>
            <div class='row form-group'>
                <div class='col-sm-2 col-sm-offset-1'>
                    Staff Name:
                </div>
                <div class='col-sm-5'>
                    <input required='true' type='text' name='staff_name' class='form-control' value='<?php echo $user->getStaffName(); ?>'>   
                </div>                
            </div>
            <div class='row form-group'>
                <div class='col-sm-2 col-sm-offset-1'>
                    Appraising Officer:
                </div>
                <div class='col-sm-5'>
                    <select name='ao_username' class='form-control'>
                        <option></option>
                        <?php
                            foreach ($param["user_enum"] as $username => $fullName) {
                                if ($username === $user->getAoUsername()) {
                                    echo "<option value='$username' selected>$fullName</option>";
                                } else {
                                    echo "<option value='$username'>$fullName</option>";
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class='row form-group'>
                <div class='col-sm-2 col-sm-offset-1'>
                    Countersigning Officer 1:
                </div>
                <div class='col-sm-5'>
                    <select name='co_username_1' class='form-control'>
                        <option></option>
                        <?php
                            foreach ($param["user_enum"] as $username => $fullName) {
                                if ($username === $user->getCo1Username()) {
                                    echo "<option value='$username' selected>$fullName</option>";
                                } else {
                                    echo "<option value='$username'>$fullName</option>";
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class='row form-group'>
                <div class='col-sm-2 col-sm-offset-1'>
                    Countersigning Officer 2:
                </div>
                <div class='col-sm-5'>
                    <select name='co_username_2' class='form-control'>
                        <option></option>
                        <?php
                            foreach ($param["user_enum"] as $username => $fullName) {
                                if ($username === $user->getCo2Username()) {
                                    echo "<option value='$username' selected>$fullName</option>";
                                } else {
                                    echo "<option value='$username'>$fullName</option>";
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class='row form-group'>
                <div class='col-sm-2 col-sm-offset-1'>
                    Email:
                </div>
                <div class='col-sm-5'>
                    <input type='email' name='email' class='form-control' value='<?php echo $user->getEmail(); ?>'>   
                </div>                
            </div>
            <div class='row form-group'>
                <div class='col-sm-2 col-sm-offset-1'>
                    Senior Staff:
                </div>                
                <div class='col-sm-5 togglebutton'>
                    <label><input name='is_senior' type="checkbox" <?php echo $user->getIsSenior() ? "checked" : "" ?>><span class='checkbox-text'></span></label>
                </div>                
            </div>
            <div class='row form-group'>
                <div class='col-sm-2 col-sm-offset-1'>
                    Administrator:
                </div>                
                <div class='col-sm-5 togglebutton'>
                    <label><input name='is_admin' type="checkbox" <?php echo $user->getIsAdmin() ? "checked" : "" ?>><span class='checkbox-text'></span></label>
                </div>                
            </div>
            <div class='row form-group'>
                <div class='col-sm-2 col-sm-offset-1'>
                    Report User:
                </div>                
                <div class='col-sm-5 togglebutton'>
                    <label><input name='is_report_user' type="checkbox" <?php echo $user->getIsReportUser() ? "checked" : "" ?>><span class='checkbox-text'></span></label>
                </div>                
            </div>
            <div class='row form-group'>
                <div class='col-sm-2 col-sm-offset-1'>
                    Department:
                </div>
                <div class='col-sm-5'>
                    <select name='department' class='form-control'>
                        <?php
                            foreach ($param["department_enum"] as $deptStr) {
                                if ($deptStr === $user->getDepartment()) {
                                    echo "<option value='$deptStr' selected>$deptStr</option>";
                                } else {
                                    echo "<option value='$deptStr'>$deptStr</option>";
                                }

                            }
                        ?>

                    </select>
                </div>
            </div>
            <div class='row form-group'>
                <div class='col-sm-2 col-sm-offset-1'>
                    Job Title:
                </div>                
                <div class='col-sm-5'>
                    <input required='true' type='text' name='position' class='form-control' value='<?php echo $user->getPosition(); ?>'>   
                </div>                  
            </div>
            <div class='row form-group'>
                <div class='col-sm-2 col-sm-offset-1'>
                    Office:
                </div>                
                <div class='col-sm-5'>
                    <select name='office' class='form-control'>
                        <?php
                            foreach ($param["office_enum"] as $officeStr) {
                                if ($officeStr === $user->getOffice()) {
                                    echo "<option value='$officeStr' selected>$officeStr</option>";
                                } else {
                                    echo "<option value='$officeStr'>$officeStr</option>";
                                }

                            }
                        ?>

                    </select>
                </div>               
            </div>
            <div class='row form-group'>
                <div class='col-sm-2 col-sm-offset-1'>
                    Commence Date: (yyyy-mm-dd)
                </div>      
                <div class='col-sm-5'>
                    <input type='text' name='commence_date' class='form-control' value='<?php echo $user->getCommenceDateStr(); ?>'>   
                </div>                 
            </div>
            <div class='row form-group'>
                <div class='col-sm-2 col-sm-offset-1'>
                    Active User:
                </div>                
                <div class='col-sm-5 togglebutton'>
                    <label><input type="checkbox" name='is_active' <?php echo $user->getIsActive() ? "checked" : "" ?>><span class='checkbox-text'></span></label>
                </div>                
            </div>
            <div class='row'>
                <div class='col-sm-offset-1'>
                    <button class="btn btn-primary btn-sm" id='submit-button'>Submit</button>
                    <a href='admin?action=userListView' class="btn btn-primary btn-sm" id='submit-button'>Cancel</a> 
                </div> 
            </div>
        </div>
    </form>
</div>
