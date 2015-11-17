<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <script>
        $(document).ready(function() {

            $('#period_select').change(function() {
                if ($('#period_select').val() != '') {
                    window.location.replace("report?uid=" + $('#period_select').val());
                }
            });

            $('.is_locked_checkbox').change(function() {
                if ($(this).is(':checked')) {
                    value = 1
                    
                    var data = {
                        "is_locked" : value,           
                    }

                    $.ajax({
                        url: 'survey?action=postFormData&r=admin&u=' + $(this).attr('username') + '&uid=<?php echo (!empty($param['uid'])) ? $param['uid'] : '' ?>',
                        type: 'POST',
                        data: {
                            "dataArray": data
                        }
                    });
                } else {
                    value = 0
                    var data = {
                        "is_locked" : value,
                        /*"is_final_by_self" : value,
                        "is_final_by_appraiser" : value,
                        "is_confirmed_by_self_after_final": value,
                        "is_confirmed_by_app_after_final": value*/                
                    }

                    $.ajax({
                        url: 'survey?action=postFormData&r=admin&u=' + $(this).attr('username') + '&uid=<?php echo (!empty($param['uid'])) ? $param['uid'] : '' ?>',
                        type: 'POST',
                        data: {
                            "dataArray": data
                        }
                    });
                }
            });

            $('#lock_all').click(function(event) {
                event.preventDefault();

                $.ajax({
                    url: 'report?action=lock&uid=<?php echo (!empty($param['uid'])) ? $param['uid'] : '' ?>',
                    type: 'POST',
                    success: function() {
                        $('.is_locked_checkbox').prop('checked', true);
                    }
                });
            })

            $('#unlock_all').click(function(event) {
                event.preventDefault();

                $.ajax({
                    url: 'report?action=unlock&uid=<?php echo (!empty($param['uid'])) ? $param['uid'] : '' ?>',
                    type: 'POST',
                    success: function() {
                        $('.is_locked_checkbox').prop('checked', false);
                    }
                });
            })
            
            $('#activate_form').click(function(event) {
                event.preventDefault();

                $.ajax({
                    url: 'report?action=activate&uid=<?php echo (!empty($param['uid'])) ? $param['uid'] : '' ?>',
                    type: 'POST',
                    success: function() {
                        location.reload();
                    }
                });
            });
            
            $('#deactivate_form').click(function(event) {
                event.preventDefault();

                $.ajax({
                    url: 'report?action=deactivate&uid=<?php echo (!empty($param['uid'])) ? $param['uid'] : '' ?>',
                    type: 'POST',
                    success: function() {
                        location.reload();
                    }
                });
            });
            
            $('#get_json').click(function(event) {
                event.preventDefault();                
                window.open("report?action=getJSON&uid=<?php echo (!empty($param['uid'])) ? $param['uid'] : '' ?>","_blank");
            });
            
            $('#get_csv').click(function(event) {
                event.preventDefault();                
                window.open("report?action=getCSV&uid=<?php echo (!empty($param['uid'])) ? $param['uid'] : '' ?>","_blank");
            });
        });
    </script>
    <body>
        <div class='contentWrapper'>
            <?php if (!empty($param['periodIndex'])) { ?>
                <form>
                    <select id='period_select'>
                        <option>

                        </option>
                        <?php foreach ($param['periodIndex'] as $uid => $detailArray) { ?>
                            <option value='<?php echo $uid ?>'>
                                <?php echo $detailArray['survey_period'] . " (" . $detailArray['survey_type'] . ")" ?>
                                <?php echo $detailArray['is_active'] ? ' - Active' : '' ?>
                            </option>
                        <?php } ?>
                    </select>
                    <?php if (!empty($param['uid']) && $this->user->isAdmin) { ?>
                        <button id='lock_all'>Lock All form</button>
                        <button id='unlock_all'>Unlock All form</button>
                        <!--<button id='activate_form'>Activate the current survey</button>
                        <button id='deactivate_form'>Deactivate the current survey</button>
                        <button id='get_json'>Download data file for excel</button>-->
                        <button id='get_csv'>Download summary data in CSV</button>
                        <!--<select id='report_select'>
                            <option value="top10">Group PA Scores (Top30 and Bottom10)</option>
                            <option value="byoffice_dept">By Office by dept</option>
                            <option value="byoffice_score">By Office by score</option>
                        </select>-->
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
                        <th>Username</th><th>Department</th><th>Position</th><th>Seniority</th><th>Office</th>
                        <th>Appraiser</th><th>Countersigner</th>
                        <th>Join Date</th><th>Part A</th><th>Part B1</th>
                        <th>Part B2</th><th>Part A Total</th>
                        <th>Part B Total</th><th>Combined Score</th><th>Finalized by Appraisee</th>
                        <th>Finalized by Appraiser</th><?php if ($this->user->isAdmin) { ?><th>Form Locked</th> <?php } ?>
                    </tr>
                    <?php 
                    if (!empty($param['data'])) {
                        foreach ($param['data'] as $username => $data) { ?>
                            <tr>
                                <td> 
                                    <a href="survey?action=renderForm&r=review&u=<?php echo $data['form_username'] ?>&uid=<?php echo $param['uid'] ?>">
                                    <?php echo $data['staff_name'] ?>
                                    </a>
                                </td>
                                <td>
                                    <?php echo $data['staff_department'] ?>
                                </td>
                                <td>
                                    <?php echo $data['staff_position'] ?>
                                </td>
                                <td>
                                    <?php echo ($data['is_senior']? "DGM or above" : "Below DGM") ?>
                                </td>
                                <td>
                                    <?php echo $data['staff_office'] ?>
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
                                <td class='<?php echo ($data['is_confirmed_by_self_after_final']) ? '' : 'alert' ?>'>
                                    <?php echo ($data['is_confirmed_by_self_after_final']) ? 'Yes' : 'No'; ?>
                                </td>
                                <td class='<?php echo ($data['is_confirmed_by_app_after_final']) ? '' : 'alert' ?>'>
                                    <?php echo ($data['is_confirmed_by_app_after_final']) ? 'Yes' : 'No'; ?>
                                </td>
                                <?php if ($this->user->isAdmin) { ?>
                                <td>
                                    <input type="checkbox" class="is_locked_checkbox" username="<?php echo $data['form_username'] ?>" <?php echo ($data['is_locked']) ? 'checked' : '' ?>>
                                </td>
                                <?php } ?>
                            </tr>
                    <?php                         
                        }
                        if (!empty($param['emptySurvey'])) {
                            ksort($param['emptySurvey']);
                            foreach($param['emptySurvey'] as $username => $userData) {
                                echo "<tr>";
                                echo "<td>".$userData['user_full_name']."</td><td>".$userData['user_department']."</td><td>".$userData['user_position']."</td>";
                                if ($userData['is_senior']) {
                                    echo "<td>DGM or above</td>";
                                } else {
                                    echo "<td>Below DGM</td>";
                                }
                                echo "<td>".$userData['user_office']."</td>";
                                echo "<td colspan='12'> User have yet to particpate in the survey </td>";
                                echo "<tr>";
                            }
                        }
                    } else {
                        echo "<th colspan='16'>";
                        echo 'Empty';
                        echo "</th>";
                    }
                    ?>
                </table>
            <?php
            } 
        ?>            
        </div>
    </body>
</html>
