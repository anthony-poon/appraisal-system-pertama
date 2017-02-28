<?php 
    /* @var $user User */
?>
<div class='container'>
    <div class='row'>
        <div class='col-sm-offset-2'>
            <?php 
                if (empty($param["show_inactive"])) {
                    echo "<a href='admin?action=userListView&show_inactive=true' class='btn btn-primary btn-sm'>Show Inactive Account</a>";
                } else {
                    echo "<a href='admin?action=userListView' class='btn btn-primary btn-sm'>Hide Inactive Account</a>";
                }
            ?>
            
        </div> 
    </div>
    <div class='row'>        
        <?php 
            foreach ($param["users"] as $depName => $department) {
                echo "<div class='col-sm-8 col-sm-offset-2 page-header'>$depName</div>";
                foreach ($department as  $user) {
        ?>
        <div class='col-sm-8 col-sm-offset-2'>
            <a href='admin?action=viewUser&user_id=<?php echo $user->getUserID() ?>' class='option <?php echo !$user->getIsActive() ? "inactive" : ""?>'>
                <i class="icon-left fa fa-user-circle-o" aria-hidden="true"></i>
                <span class='option-text'>
                    <?php echo $user->getStaffName(); ?>
                </span>
                <i class="icon-right fa fa-chevron-right" aria-hidden="true"></i>
            </a>
        </div>
        <?php
                }
            }
        ?>
    </div>
</div>
