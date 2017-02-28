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
                <th>Part A</th>
                <th>Part B </th><th>Total</th><th>Submitted by Appraisee</th><th>Submitted by Appraising Officer</th><th>Confirmed by Countersigning Officer 1</th>
                <th>Confirmed by Countersigning Officer 2</th><?php if ($this->user->isAdmin) { ?><th>Form Locked</th> <?php } ?>
            </tr>
            <?php 
            /* @var $entry ReportSummaryData */
            if (!empty($param['data'])) {     
                foreach ($param['data'] as $entry) { ?>
                    <tr>
                        <td>
                            <?php echo $entry->getOffice() ?>
                        </td>
                        <td>
                            <?php echo $entry->getDepartment() ?>
                        </td>
                        <td>
                            <?php echo $entry->getPosition() ?>
                        </td>
                        <td> 
                            <a href="survey?action=renderForm&r=review&u=<?php echo $entry->getUsername() ?>&uid=<?php echo $param['uid'] ?>">
                            <?php echo $entry->getStaffName() ?>
                            </a>
                        </td>
                        <td>
                            <?php echo ($entry->getSeniority() ? "DGM or above" : "Below DGM") ?>
                        </td>

                        <td>
                            <?php echo $entry->getAOName() ?>
                        </td>
                        <td>
                            <?php 
                                if (!empty($entry->getCO2Name())) {
                                    echo $entry->getCO1Name()." & ".$entry->getCO2Name();
                                } else {
                                    echo $entry->getCO1Name();
                                }
                                
                            ?>
                        </td>
                        <td>
                            <?php echo $entry->getPartAScore() ?>
                        </td>
                        <td>
                            <?php echo $entry->getPartBScore() ?>
                        </td>
                        <td>
                            <?php echo $entry->getTotalScore() ?>
                        </td>
                        <td class='<?php echo ($entry->getSelfStatus()) ? '' : 'missing_alert' ?>'>
                            <?php echo ($entry->getSelfStatus()) ? 'Yes' : 'No'; ?>
                        </td>
                        <td class='<?php echo ($entry->getAOStatus()) ? '' : 'missing_alert' ?>'>
                            <?php echo ($entry->getAOStatus()) ? 'Yes' : 'No'; ?>
                        </td>
                        <td class='<?php echo ($entry->getCO1Status()) ? '' : 'missing_alert' ?>'>
                            <?php echo ($entry->getCO1Status()) ? 'Yes' : 'No'; ?>
                        </td>
                        <td class='<?php echo ($entry->getCO2Status()) ? '' : 'missing_alert' ?>'>
                            <?php echo ($entry->getCO2Status()) ? 'Yes' : 'No'; ?>
                        </td>
                        <?php if ($this->user->isAdmin) { ?>
                        <td>
                            <input type="checkbox" class="is_locked_checkbox" username="<?php echo $entry->getUsername() ?>" <?php echo ($entry->getLockStatus()) ? 'checked' : '' ?>>
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
