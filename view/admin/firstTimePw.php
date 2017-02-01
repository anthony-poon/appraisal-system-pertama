<script>
    $(window).load(function(){
        $("#sub-button").click(function(evt){
            evt.preventDefault();
            logoutTimer.keepAlive();
            var pwAjax = $.ajax({
                url: "admin?action=ajaxSelfPW",
                type: "POST",
                dataType: "json",
                data: {
                    pwNew: $("#pw-new").val(),
                    pwConfirm: $("#pw-confirm").val(),
                    shouldUnflag: true
                }
            });
            pwAjax.done(function(json, textStatus){                
                if (json.error == "0") {
                    $("#message").html(json.msg);
                    $("#sub-button").fadeOut();
                    $("#sub-button").unbind("click");
                    $("#message").fadeIn(500, function(){
                        $("#message").delay(3000).fadeOut(500, function(){
                            window.location.replace("survey");
                        });
                    });
                } else {
                    $("#message").html(json.msg);
                    $("#message").fadeIn(500, function(){
                        $("#message").delay(7000).fadeOut();
                    });
                }
            });
            pwAjax.fail(function(jqXHR, textStatus){
                $("#message").html("Error Code: " + jqXHR.status + " ( " + jqXHR.responseText + " )");
                    $("#message").fadeIn(500, function(){
                        $("#message").delay(7000).fadeOut();
                    });
            })
        })
    })
</script>
<div class="wrapper">
    <div id="title">
        Setting up your profile...
    </div>
    <div id="text">
        Please enter a new password for your login. (5 characters or longer)
    </div>
    <form id="pw-form">
        <div>
            <label>New password: </label><input id="pw-new" type="password">
        </div>
        <div>
            <label>Confirm new password: </label><input id="pw-confirm" type="password">
        </div>
        <div id="input-wrapper">
            <input type="submit" id="sub-button"><div id="message"></div>
        </div>
    </form>
</div>
