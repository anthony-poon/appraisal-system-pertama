$(document).ready(function(){
    $(".togglebutton").change(function(){
        if ($(this).find("input").is(":checked")) {
            $(this).find(".checkbox-text").html("True");
        } else {
            $(this).find(".checkbox-text").html("False");
        }
    });
    
    $(".togglebutton").trigger("change");
    $( "form" ).on( "submit", function( event ) {
        $(".error-msg").remove();
        var formOk = true;
        var errorMsg = $("<div class='error-msg col-sm-4'></div>");
        var firstErrorOffset = 0;
        $.each($("[required='true']"), function(){
            if ($(this).val().trim() === "") {
                formOk = false;
                if (!$.contains($(this), ".error-msg")) {
                    errorMsg.text("Cannot be empty");
                    $(this).parents(".form-group").append(errorMsg.clone());
                }                
                if (firstErrorOffset === 0) {
                    firstErrorOffset = $(this).offset().top;
                }
            }
        });
        var dateString = $("[name='commence_date']").val();
        if (dateString !== "") {
            dateString = dateString.replace(/\//g, "-");
            $("[name='commence_date']").val(dateString);
            if (!moment(dateString, "YYYY-MM-DD", true).isValid()) {
                formOk = false;
                errorMsg.text("Invalid date format");
                if (firstErrorOffset === 0) {
                    firstErrorOffset = $("[name='commence_date']").offset().top;
                }
                if (!$.contains("[name='commence_date']", ".error-msg")) {
                    errorMsg.text("Invalid date format");
                    $("[name='commence_date']").parents(".form-group").append(errorMsg.clone());
                }

            }
        }
        if (!formOk) {
            event.preventDefault();
            $('html,body').animate({
                scrollTop: firstErrorOffset - 50
            }, 500);
        }
        //var userId = $("#user-wrapper").data("user-id"); 
        //console.log($(this).serialize());
        //$.ajax("admin?action=ajaxUserChange&user_id=" + userId, {
            
        //});
    });
});