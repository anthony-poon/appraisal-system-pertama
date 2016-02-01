<div id="back-plate">
</div>
<div class='wrapper'>
    <?php
    if (!empty($this->error)) {
        echo "<div class='error_message'>" . $this->error . "</div>";
    }
    ?>
    <form action="login?action=submitLogin" method="POST">
        <img src="./public/img/logo.png"><br>
        <div class='title'><?php echo COMPANY_NAME ?> Performance Appraisal Online Form</div>
        <div class="input-row">
            <span>Username</span><input type="text" name="username"> <br>
        </div>
        <div class="input-row">
            <span>Password</span><input type="password" name="password"> <br>
        </div>
        <input id="submit-button" type="submit" value='Sign In'> <br>
    </form>
</div>