<script>
    $(window).load(function(){
        
        $(":input").keydown(function(evt){
            if (evt.which == "13") {
                $("#submit-button").trigger("click");
            }
        })
        
        $("#status-button").click(function(){
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
            var selectedUser = {
                username: $(this).find(":selected").attr("id"),
                accStatus: $(this).find(":selected").attr("data-acc-status")
            }
            $("#user-detail #username").val(selectedUser.username);
            $("#user-detail").addClass("enabled");
            $("#user-detail #new-pw, #old-pw").removeAttr("disabled");
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
            if ($("#user-detail").is(".enabled")) {
                var userId = $("#user-detail #username").val();
                var pwNew = $("#user-detail #new-pw").val();
                var pwCon = $("#user-detail #old-pw").val();
                var pwAjax = $.ajax({
                    url: "admin?action=ajaxCatchFile&userId="+userId,
                    type: "POST",
                    dataType: "json",
                    data: {
                        pwNew: pwNew,
                        pwConfirm: pwCon,
                    }
                });
                var lastTimeoutId = null;
                pwAjax.done(function(json, textStatus){
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
                        echo "<option id='$username' data-acc-status='".$detail["is_active"]."'>".$username."</option>";
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
