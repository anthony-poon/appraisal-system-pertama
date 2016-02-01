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
    <body>
        <div class='selectionTitle'>
            <?php if ($param['r'] == 'self') { ?>
                I would like to fill in...
            <?php } else { ?>
            I would like to appraise / countersign...
            <?php } ?>
        </div>
        <?php if ($param['r'] == 'self') { ?>
            <div class='wrapper'>
                <?php foreach ($param['selection'] as $uid => $surveyPeriod) { ?>
                    <a href='survey?action=renderForm&r=<?php echo $param['r'] ?>&u=<?php echo $param['u'] ?>&uid=<?php echo $uid ?>' class='box subSelection'>
                        <div><?php echo $surveyPeriod ?></div>
                    </a>
                    <?php
                }
                ?>
            </div>
        <?php } ?>
        <?php if (($param['r'] == 'app') || ($param['r'] == 'counter')){ ?>
            <div class='wrapper'>
                <?php foreach ($param['selection'] as $uid => $surveyPeriod) { ?>
                    <a href='survey?action=subSelect&r=<?php echo $param['r'] ?>&uid=<?php echo $uid ?>' class='box subSelection'>
                        <div><?php echo $surveyPeriod ?></div>
                    </a>
                    <?php
                }
                ?>
            </div>
        <?php } ?>
    </body>
</html>
