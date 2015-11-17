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

        <div class='contentWrapper'>
            <?php
            if (!empty($this->error)) {
                echo "<div class='error_message'>" . $this->error . "</div>";
            }
            ?>
            <form action="login?action=submitLogin" method="POST">
                <img src="./public/img/logo.png"><br>
                <div class='title'>AML Performance Appraisal Online Form</div>
                <label><b>Username</b></label>
                <input type="text" name="username"> <br>
                <label><b>Password</b></label>
                <input type="password" name="password"> <br>
                <input type="submit" value='Sign In'> <br>
            </form>
        </div>

        <?php
        // put your code here
        ?>
    </body>
</html>
