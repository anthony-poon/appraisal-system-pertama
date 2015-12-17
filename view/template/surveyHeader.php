<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href="public/css/parsley.css">
<script src="public/js/jquery-1.11.2.js"></script>
<link rel="stylesheet" type="text/css" href="public/css/jquery-ui.css">
<script src="public/js/jquery-ui.js"></script>
<script src="public/js/parsley.min.js"></script>
<script>
    function startTimeout() {
        timeLimit = 1200000;
        if (typeof timer !== 'undefined') {
            clearTimeout(timer);
        }           
        
        timer = setTimeout(function(){
            alert('Your session have been terminated due to long inactivity. You will now be redirected to login.');
            window.location = 'login?action=logout';
        }, timeLimit)
    }
    
    function keepAlive(timeLimit) {
        timeLimit = 900000;
        timer2 = setInterval(function(){
            $.ajax({
                url: "login?action=keepAlive",
                cache: false
            })
        }, timeLimit)
    }
    $(document).ready(function(){          
        startTimeout(); //is in ms. 1000 ms = 1 second
        keepAlive();        
    });
</script>
<div class='header_bar'>
    <div class='message'>Welcome, 
        <?php 
        echo $this->user->fullName;
        //var_dump($this->user);
        //var_dump($_SESSION['browserInfo']);
        //var_dump(get_browser(NULL));
        ?></div> 
    <div class='control_panel'>
        <ul>
            <!--<li>Account Setting</li>-->
            <?php if ($this->user->isAdmin) { ?>
            <li><a href='report?uid=<?php echo $this->user->activeUid ?>'>Admin Report</a></li>
            <?php } ?>
            <?php if ($this->user->isReportUser) { ?>
            <li><a href='report?uid=<?php echo $this->user->activeUid ?>'>Department Report</a></li>
            <?php } ?>
            <li><a href='survey'>Main Page</a></li>
            <li><a href='setting'>Settings</a></li>
            <li><a href='login?action=logout'>Logout</a></li>
            
        </ul>
    </div>
    <div class='control_panel'>
        <ul>
            <li><a href='public/download/Quick_Guide.pdf'>User guide</a></li>
            <li><a href='public/download/Part_B_Simplified.pdf'>Part B 简体</a></li>
            <li><a href='public/download/Part_B_Traditional.pdf'>Part B 繁體</a></li>            
        </ul>
    </div>
</div>
