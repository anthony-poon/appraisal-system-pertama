<script src="public/js/jquery-1.11.2.js"></script>
<script>
    $(window).load(function(){

        $("#submit").click(function(evt){
            evt.preventDefault();
            var pwAjax = $.ajax({
                url: "setting?action=ajaxSelfPW",
                type: "POST",
                dataType: "json",
                data: {
                    pwNew: $("#pw-new").val(),
                    pwConfirm: $("#pw-confirm").val()
                }
            });
            pwAjax.done(function(json, textStatus){                
                if (json.error == "0") {
                    $("#message").html("Amendment is successful");
                } else {
                    $("#message").html(json.msg);
                }
            });
            pwAjax.fail(function(jqXHR, textStatus){
                $("#message").html("Error Code: " + jqXHR.status + " ( " + jqXHR.responseText + " )");
            })
        });
    });
</script>

<div id="content" class="wrapper">
    <form id="reset-pw-box">
        <div id="message">
        </div>
        <div>
            <label> Username: </label> <?php echo $this->user->username?>
        </div>
        <div>
            <label> New Password: </label><input id="pw-new" type="password"/>
        </div>
        <div>
            <label> Enter the new password again: </label><input id="pw-confirm" type="password"/>
        </div>
        <div>
            <button id="submit">Submit</button>
        </div>
    </form>
</div>