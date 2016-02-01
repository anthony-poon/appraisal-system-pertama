<div id="sidebar" class="wrapper">
    <div id="top-section">
        <div id="username" class="wrapper">            
            <div>
                <?php echo $this->user->fullName ?>
            </div>
        </div>
    </div>
    <div id="menu">
        <a href="admin?action=changePWView">
            <div class="selection">
                <div>Change personal password</div>
            </div>
        </a>
        <?php if (ENABLE_FILE_UPLOAD) { ?>
            <a href="admin?action=documentView">
                <div class="selection">
                    <div>View documents</div>
                </div>
            </a>
        <?php } ?>
        <?php 
            if ($this->user->isAdmin) {
        ?>
            <a href="admin?action=adminUserView">
                <div class="selection">
                    <div>User administration</div>
                </div>
            </a>
            <?php if (ENABLE_FILE_UPLOAD) { ?>
                <a href="admin?action=uploadFileView">
                    <div class="selection">
                        <div>File Upload</div>
                    </div>
                </a>
            <?php } ?>
        <?php
            }
        ?>
        <a href="survey" class="selection">
            <div>Go Back</div>
        </a>
    </div>
</div>