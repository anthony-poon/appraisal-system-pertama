<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
    function arrayGetColumn($array, $columnName){
        $result = array();
        foreach ($array as $arrayItem) {
           array_push($result, $arrayItem[$columnName]);
        }
        return $result;
    }
?>
<div class='contentWrapper'>
    <?php if (!empty($param['periodIndex'])) { ?>
        <form data-uid="<?php echo $param['uid'] ?>">
            <select id='period_select'>
                <option>
                    Click here to select previous appraisal
                </option>
                <?php foreach ($param['periodIndex'] as $uid => $detailArray) { ?>
                    <option value='<?php echo $uid ?>'>
                        <?php echo $detailArray['survey_period'] . " (" . $detailArray['survey_type'] . ")" ?>
                        <?php echo $detailArray['is_active'] ? ' - Current' : '' ?>
                    </option>
                <?php } ?>
            </select>
            <?php if (!empty($param['uid']) && $this->user->isAdmin) { ?>
                <button id='lock_all'>Lock All form</button>
                <button id='unlock_all'>Unlock All form</button>
                <button id='get_excel'>Download summary data in excel</button>
                <!--<button id='activate_form'>Activate the current survey</button>
                <button id='deactivate_form'>Deactivate the current survey</button>
                <button id='get_csv'>Download summary data in CSV</button>
                -->
            <?php } ?>
        </form>
    <?php
    }
    if (!empty($param['uid'])) {
    ?>
        <table>
            <tr>
                <th colspan="<?php echo ($this->user->isAdmin)? "17" : "16" ?>17">
                    <?php echo $param['periodIndex'][$param['uid']]['survey_period']?> 
                </th>
            </tr>
            <tr>
                <th>Office</th><th>Department</th><th>Position</th><th>Username</th><th>Seniority</th>
                <th>Appraising Officer</th><th>Countersigning Officer</th>
                <th>Join Date</th><th>Part A</th><th>Part B1</th>
                <th>Part B2</th><th>Part A Total</th>
                <th>Part B Total</th><th>Combined Score</th><th>Submitted by Appraisee</th><th>Submitted by Appraising Officer</th><th>Confirmed by Countersigning Officer 1</th>
                <th>Confirmed by Countersigning Officer 2</th><?php if ($this->user->isAdmin) { ?><th>Form Locked</th> <?php } ?>
            </tr>
            <?php 
            if (!empty($param['data'])) {                 
                $arrayStaffOffice = arrayGetColumn($param['data'], 'staff_office');
                $arrayStaffDepartment = arrayGetColumn($param['data'], 'staff_department');
                $arrayIsSenior = arrayGetColumn($param['data'], 'is_senior');
                //Cannot use due to php version
                //array_multisort(array_column($param['data'], 'staff_office'), array_column($param['data'], 'staff_department'), array_column($param['data'], 'is_senior'), SORT_DESC,$param['data']);
                array_multisort($arrayStaffOffice, $arrayStaffDepartment, $arrayIsSenior, SORT_DESC,$param['data']);
                foreach ($param['data'] as $username => $data) { ?>
                    <tr>
                        <td>
                            <?php echo $data['staff_office'] ?>
                        </td>
                        <td>
                            <?php echo $data['staff_department'] ?>
                        </td>
                        <td>
                            <?php echo $data['staff_position'] ?>
                        </td>
                        <td> 
                            <a href="survey?action=renderForm&r=review&u=<?php echo $data['form_username'] ?>&uid=<?php echo $param['uid'] ?>">
                            <?php echo $data['staff_name'] ?>
                            </a>
                        </td>
                        <td>
                            <?php echo ($data['is_senior']? "DGM or above" : "Below DGM") ?>
                        </td>

                        <td>
                            <?php echo $data['appraiser_name'] ?>
                        </td>
                        <td>
                            <?php echo $data['countersigner_name'] ?>
                        </td>
                        <td>
                            <?php echo $data['survey_commencement_date'] ?>
                        </td>
                        <td>
                            <?php echo $data['part_a_overall_score'] ?>
                        </td>
                        <td>
                            <?php echo $data['part_b1_overall_score'] ?>
                        </td>
                        <td>
                            <?php echo $data['part_b2_overall_score'] ?>
                        </td>
                        <td>
                            <?php echo $data['part_a_total'] ?>
                        </td>
                        <td>
                            <?php echo $data['part_b_total'] ?>
                        </td>
                        <td>
                            <?php echo $data['part_a_b_total'] ?>
                        </td>
                        <td class='<?php echo ($data['is_final_by_self']) ? '' : 'alert' ?>'>
                            <?php echo ($data['is_final_by_self']) ? 'Yes' : 'No'; ?>
                        </td>
                        <td class='<?php echo ($data['is_final_by_appraiser']) ? '' : 'alert' ?>'>
                            <?php echo ($data['is_final_by_appraiser']) ? 'Yes' : 'No'; ?>
                        </td>
                        <td class='<?php echo ($data['is_final_by_counter1']) ? '' : 'alert' ?>'>
                            <?php echo ($data['is_final_by_counter1']) ? 'Yes' : 'No'; ?>
                        </td>
                        <td class='<?php echo ($data['is_final_by_counter2']) ? '' : 'alert' ?>'>
                            <?php echo ($data['is_final_by_counter2']) ? 'Yes' : 'No'; ?>
                        </td>
                        <?php if ($this->user->isAdmin) { ?>
                        <td>
                            <input type="checkbox" class="is_locked_checkbox" username="<?php echo $data['form_username'] ?>" <?php echo ($data['is_locked']) ? 'checked' : '' ?>>
                        </td>
                        <?php } ?>
                    </tr>
            <?php                         
                }
                if (!empty($param['empty_survey'])) {
                    foreach($param['empty_survey'] as $username => $userData) {
                        echo "<tr>";
                        echo "<td>".$userData['user_office']."</td>";
                        echo "<td>".$userData['user_department']."</td>";
                        echo "<td>".$userData['user_position']."</td>";
                        echo "<td>".$userData['user_full_name']."</td>";
                        if ($userData['is_senior']) {
                            echo "<td>DGM or above</td>";
                        } else {
                            echo "<td>Below DGM</td>";
                        }

                        echo "<td colspan='16'> User have yet to particpate in the survey </td>";
                        echo "<tr>";
                    }
                }
            } else {
                echo "<th colspan='19'>";
                echo 'Empty';
                echo "</th>";
            }
            ?>
        </table>
    <?php
    } 
?>            
</div>
