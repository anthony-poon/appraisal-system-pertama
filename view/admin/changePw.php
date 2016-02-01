<script>
    $(window).load(function(){
        $(":input").keydown(function(evt){
            if (evt.which == "13") {
                $("#submit").trigger("click");
            }
        })
        $("#submit").click(function(evt){
            var pwAjax = $.ajax({
                url: "admin?action=ajaxSelfPW",
                type: "POST",
                dataType: "json",
                data: {
                    pwNew: $("#pw-new").val(),
                    pwConfirm: $("#pw-confirm").val()
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
                    }, 3000);
                })
            });
        });
    });
</script>

<div id="content" class="wrapper">
    <div id="reset-pw-box">
        <div class="wrapper">
            <div id="message">
            </div>
        </div>
        <div class="wrapper">
            <div class="label"> Username: </div> <?php echo $this->user->username?>
        </div>
        <div class="wrapper">
            <div class="label"> New Password: </div><input id="pw-new" type="password"/>
        </div>
        <div class="wrapper">
            <div class="label"> Confirm again: </div><input id="pw-confirm" type="password"/>
        </div>
        <div class="wrapper">
            <div id="submit">Submit</div>
        </div>
    </div>
</div>