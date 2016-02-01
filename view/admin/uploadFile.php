<script>
    $(window).load(function(){
        $("#spinner-wrapper").hide();
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
            $("#upload-category :input, #upload :input").removeAttr("disabled");
            $("#upload-category :input, #upfile").val("");
            var username = $("#list :selected").html();
            $("form").attr("action", "admin?action=uploadFile&to="+username);
        });

        $('#submit-button').click(function(evt){
            var category = $("#upload-category :input").val();
            var filePath = $("#upfile").val();
            if (category !== "" && filePath !=="") {
                $("#submit-button").hide();
                $("form").fadeOut(1, function(){
                    $("#spinner-wrapper").fadeIn();
                });
                
                $("form").trigger("submit");
            }
        })
    })
</script>
<div id="content" class="wrapper">
    <?php
    ?>
    <form  enctype="multipart/form-data" method="POST" action="admin?action=uploadFile">
        <div id="user-dropdown">
            <div class="wrapper">
                <span>Select a user here: </span>
                <select name='to' id="list">
                    <option></option>
                    <?php                    
                        foreach ($param["username"] as $username) {
                            echo "<option>".$username."</option>";
                        } 
                    ?>
                </select>
            </div>
        </div>    
        <div id="detail">
            <div class="wrapper">
                <div id="message" >
                    <?php                        
                        if (!empty($param["error"])) {
                            echo $param["error"];
                        }
                    ?>                
                </div>
            </div>
            <div class="wrapper" id="upload-category">
                <div class="label">
                    Upload a file to: 
                </div>
                <select name='category' id='category' disabled>
                    <option></option>
                    <?php 
                        if (!empty($param["fileCategory"])) {
                            foreach ($param["fileCategory"] as $name) {
                                echo "<option>$name</option>";
                            }
                        }
                    ?>
                </select>
            </div>
            <div class="wrapper" id="upload">
                <div class="label">
                </div>
                <input type='file' id='upfile' name='upfile' disabled>
            </div>
            <div class="wrapper">
                <div id="submit-button">
                    <div>
                        Submit
                    </div> 
                    
                </div>
                
            </div>
        </div>
    </form>
    <div id='spinner-wrapper'>
        <div class="text">
            Loading
        </div>  
        <div class="spinner">              
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>
</div>
