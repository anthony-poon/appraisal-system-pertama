<script src="public/js/jquery-1.11.2.js"></script>
<script>
    $(window).load(function(){
        var lastClickedContainer = null;
        $(".ch-pw-button").click(function(){
            $(".hidden-form").hide();
            $(".buttons-row").show();
            $(".message").hide();
            if (lastClickedContainer !== null) {
                $(lastClickedContainer).css("height", "50");
            }
            lastClickedContainer = $(this).parents(".row");
            $(this).parent().parent().children(".hidden-form").show();
            $(this).parent().parent().children(".message").show();
            $(this).parent().hide();
            $(this).parents(".row").css("height", "120");
        })
        $('.sub-button').click(function(evt){
            evt.preventDefault();
            var container = $(this).parents(".right-wrapper");
            var userId = $(this).parents(".hidden-form").attr("data-user");
            var pwNew = $(this).parents(".hidden-form").find("#pw-new").val();
            var pwCon = $(this).parents(".hidden-form").find("#pw-confirm").val();
            console.log(pwNew);
            console.log(pwCon);
            var pwAjax = $.ajax({
                url: "setting?action=ajaxAdminPW",
                type: "POST",
                dataType: "json",
                data: {
                    userId: userId,
                    pwNew: pwNew,
                    pwConfirm: pwCon
                }
            });
            pwAjax.done(function(json, textStatus){                
                if (json.error == "0") {
                    $(container).find(".message").html(json.msg);
                    console.log($(container).find(".message"));
                    console.log(json.msg);
                } else {
                    $(container).find(".message").html(json.msg);
                    console.log($(container).find(".message"));
                    console.log(json.msg);
                }
            });
            pwAjax.fail(function(jqXHR, textStatus){
                console.log("Error Code: " + jqXHR.status + " ( " + jqXHR.responseText + " )");
            })
        })
    })
</script>
<div id="content" class="wrapper">
    <div id="user-table">
    <?php
        foreach ($param["userDetail"] as $username => $detail) {
            if ($detail["is_active"] === "1") {
                $accStatusStr = "Disable Account";
            } else {
                $accStatusStr = "Enable Account";
            }
            echo "<div class='row'>";
                echo "<div class='username'><span>$username</span></div>";
                echo "<div class='right-wrapper'>";
                    echo "<div class='buttons-row'>";
                        echo "<div class='clickable ch-pw-button'><span>Change Password</span></div><div class='clickable status-button'><span>$accStatusStr</span></div>";
                        echo "</div>";
                        echo "<div class='message' style='display: none'>";
                        echo "</div>";
                        echo "<form data-user='$username' class='hidden-form' style='display: none'>";
                            echo "<div><label>New Password: </label><input id='pw-new' type='password'></div>";
                            echo "<div><label>Confirm Password: </label><input id='pw-confirm' type='password'></div>";
                            echo "<div><input class='sub-button' type='submit'></div>";
                        echo "</form>";
                        
                    echo "</div>";
                echo "</div>";
        }
    ?>
    </div>
</div>
