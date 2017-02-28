<script type='text/javascript' src='public/js/timeout-keep-alive.js'></script>
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
            <li><a href='report?uid=<?php echo $param["uid"] ?>'>Admin Panel</a></li>
            <li><a href='admin'>Settings</a></li>
            <?php } else { ?>
            <li><a href='report?uid=<?php echo $param["uid"] ?>'>Report</a></li>
            <?php } ?>
            <li><a href='survey'>Main Page</a></li>            
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
