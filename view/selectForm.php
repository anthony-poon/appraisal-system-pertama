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
            I am a …
            <div>
            (Please select your appropriate role in the appraisal)
            </div>
        </div>
        <div class='wrapper'>
            <a href='survey?action=renderForm&r=self&uid=<?php echo $this->user->availiblePeriod['uid'] ?>&u=<?php echo $this->user->username ?>' class='box' id='box_1'>
                <div class='left'>Appraisee</div>
                <div class='right'>
                    I have to complete self-assessment on my accomplishments of key responsibilities or objectives (Part A), 
                    and competencies assessment (Part B) with specific examples, before any assessment by appraising officer.
                </div>
            </a>

            <a <?php echo !empty($this->user->appraisee) ? "href='survey?action=subSelect&r=app&uid=".$this->user->availiblePeriod['uid']."'" : ''; ?> class='box <?php echo empty($this->user->appraisee) ? "disabled" : ''; ?>' id='box_2'>
                <div class='left'>Appraising Officer</div>

                <div class='right'>
                    I have to appraise subordinate’s accomplishments of key responsibilities or objectives (Part A), 
                    assessment of his/her competencies (Part B), identify the competency gap, recommending for learning 
                    and development needs (Part C) and individual goal setting for the upcoming year (Part D). 
                </div>
            </a>
            <a <?php echo !empty($this->user->countersignee) ? "href='survey?action=subSelect&r=counter&uid=".$this->user->availiblePeriod['uid']."'" : ''; ?> class='box <?php echo empty($this->user->countersignee) ? "disabled" : ''; ?>' id='box_3'>
                <div class='left'>Countersigning Officer</div>

                <div class='right'>
                    I have to read all Parts and agree with the appraisals done by the Appraising Officer.
                </div>
            </a>
        </div>
        <?php
        // put your code here
        ?>
    </body>
</html>
