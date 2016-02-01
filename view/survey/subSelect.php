<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<div class='selectionTitle'>
    Please select an Appraisee to proceed further... 
</div>
<div class='wrapper'>
    <!-- Should add instruction about why an element is grayed for better UI -->
    <?php 
    if ($param['r'] == 'app') {
        echo "<div class='instruction'>";
        echo "<img src='public/img/changed.png'> = Recently changed by Appraiser";
        echo "</div>";
        foreach ($param['selection'] as $username => $user) { ?>
        <a <?php //if ($user['status']) { ?>href='survey?action=renderForm&r=<?php echo $param['r'] ?>&u=<?php echo $username ?>&uid=<?php echo $param['uid'] ?>' <?php //} ?>
           class='box subSelection'>
            <div class='full_name'>
                <?php 
                    if ($user['isChanged']) {
                        echo "<div class='changed'></div>";
                    }
                    echo $user['fullName'];
                    //echo ($user['completeness'] ? " <img src='../pa/public/img/checked.png'> " : '');
                ?>
            </div>
        </a>
    <?php                
        }
    } else if ($param['r'] == 'counter') {
        foreach ($param['selection'] as $username => $user) { ?>
        <a <?php if ($user['status']) { ?>href='survey?action=renderForm&r=<?php echo $user['role'] ?>&u=<?php echo $username ?>&uid=<?php echo $param['uid'] ?>' <?php } ?>
           class='box subSelection <?php echo ($user['status'] ? '' : 'disabled'); ?>'>
            <div class='full_name'>
                <?php 
                    echo $user['fullName']; 
                ?>
            </div>
        </a>
    <?php 
        }
    }
    ?>
</div>

