<div id="sidebar" class="wrapper">
    <div id="top-section">
        <div id="username" class="wrapper">            
            <div>
                <?php echo $this->user->fullName ?>
            </div>
        </div>
    </div>
    <div id="menu">
        <a href="setting?action=changePWView">
            <div class="selection">
                <div>Change personal password</div>
            </div>
        </a>        
        <?php 
            if ($this->user->isAdmin) {
        ?>
            <a href="setting?action=adminUserView">
                <div class="selection">
                    <div>User administration</div>
                </div>
            </a>
            <div class="selection">
                <div>Admin Selection 2</div>
            </div>
        <?php
            }
        ?>        
    </div>
</div>