<script>
    $(window).load(function(){
        
        $(":input").keydown(function(evt){
            if (evt.which == "13") {
                $("#submit-button").trigger("click");
            }
        })
        
        $("#status-button").click(function(){
            logoutTimer.keepAlive();
            if ($("#user-detail").is(".enabled")) {
                var username = $("#user-detail #username").val();
                var statusAjax = $.ajax({
                    url: "admin?action=ajaxToggleStatus&userId="+username,
                    type: "POST",
                    dataType: "json"
                });
                statusAjax.done(function(json, textStatus){
                    if ($("#status-button").is(".true")) {
                        $("#status-button").removeClass("true");
                        $("#status-button").addClass("false");
                        $("#user-dropdown :selected").attr("data-acc-status", "0")
                    } else {
                        $("#status-button").removeClass("false");
                        $("#status-button").addClass("true");
                        $("#user-dropdown :selected").attr("data-acc-status", "0")
                    }
                    $("#message").html(json.msg);
                    $("#message").css("opacity" , "0");
                    $("#message").animate({
                        opacity: 1
                    }, 1000, function(){
                        setTimeout(function(){
                            $("#message").animate({
                                opacity: 0
                            });
                        }, 5000);
                    })

                });                
            }
        });
        
        $("#list").change(function(){
            logoutTimer.keepAlive();
            $("#user-detail #username").val("");
            $("#user-detail #email").val("");
            var selectedUser = {
                username: $(this).find(":selected").attr("id"),
                accStatus: $(this).find(":selected").attr("data-acc-status"),
                email: $(this).find(":selected").attr("data-email")
            }
            $("#user-detail #username").val(selectedUser.username);
            $("#user-detail #email").val(selectedUser.email);
            $("#user-detail").addClass("enabled");
            $("#user-detail #new-pw, #old-pw, #email").removeAttr("disabled");
            $("#user-detail #new-pw, #old-pw").val("");
            if (selectedUser.accStatus === "1") {
                $("#user-detail #status-button").removeClass("false");
                $("#user-detail #status-button").addClass("true");                
            } else {
                 $("#user-detail #status-button").removeClass("true");
                 $("#user-detail #status-button").addClass("false");
            }
        });

        $('#submit-button').click(function(evt){
            logoutTimer.keepAlive();
            if ($("#user-detail").is(".enabled")) {
                var userId = $("#user-detail #username").val();
                var pwNew = String($("#user-detail #new-pw").val()).trim();
                var pwCon = String($("#user-detail #old-pw").val()).trim();
                var userEmail = String($("#user-detail #email").val()).trim();
                var pwAjax = $.ajax({
                    url: "admin?action=ajaxPostChange&userId="+userId,
                    type: "POST",
                    dataType: "json",
                    data: {
                        pwNew: pwNew,
                        pwConfirm: pwCon,
                        userEmail: userEmail
                    }
                });
                var lastTimeoutId = null;
                pwAjax.done(function(json, textStatus){
                    if (json.error === 0) {
                        $("#user-detail #new-pw").val("")
                        $("#user-detail #old-pw").val("")
                        $("#list").find(":selected").attr("data-email", userEmail)
                    }
                    clearTimeout(lastTimeoutId);
                    $("#message").html(json.msg);
                    $("#message").css("opacity" , "0");
                    $("#message").animate({
                        opacity: 1
                    }, 1000, function(){
                        lastTimeoutId = setTimeout(function(){
                            $("#message").animate({
                                opacity: 0
                            });
                        }, 5000);
                    })
                });
            }
        })
    })
</script>
<div id="content" class="wrapper">
    <div id="user-dropdown">
        <div class="wrapper">            
            <span>Select a user here: </span>
            <select id="list">
                <option></option>
                <?php                    
                    foreach ($param["userDetail"] as $username => $detail) {
                        echo "<option id='$username' data-email='".$detail["user_email"]."' data-acc-status='".$detail["is_active"]."'>".$username."</option>";
                    } 
                ?>
            </select>
        </div>
    </div>
    <div id="user-detail">
        <div class="wrapper">
            <div id="message" ></div>
        </div>
        <div class="wrapper">
            <div class="label">Username: </div><input id="username" type='text' disabled>
        </div>
        <div class="wrapper">
            <div class="label">New password: </div><input id="new-pw" type="password" disabled>
        </div>
        <div class="wrapper">
            <div class="label">Confirm password: </div><input id="old-pw" type="password" disabled>
        </div>
        <div class="wrapper">
            <div class="label">Email: </div><input id="email" type='text' disabled>
        </div>
        <div class="wrapper">
            <div class="label">Account status: </div>
            <div id="status-button" class="switch false">
                <div class="inner-box">
                </div>
                <div class="black-bar">
                </div>
            </div>
        </div>
        <div class="wrapper">
            <div id="submit-button">
                <div>
                    Submit
                </div>
            </div>
        </div>
    </div>
</div>
