$(document).ready(function(){
    
    $( "form" ).on( "submit", function( event ) {
        $(".error-msg").remove();
        var formOk = true;
        var errorMsg = $("<div class='error-msg col-sm-3'></div>");
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
        if (formOk) {
            var username = $("[name='username']").val().trim();
            var pattern = /^[a-z\.]+$/;
            if (!pattern.exec(username)) {
                formOk = false;
                errorMsg.text("Lowercase letter and period only.");
                $("[name='username']").parents(".form-group").append(errorMsg.clone());
                if (firstErrorOffset === 0) {
                    firstErrorOffset = $("[name='username']").offset().top;
                }
            }
        }
        if (formOk) {
            var staffName = $("[name='staff_name']").val().trim();
            var pattern = /^[a-z A-Z]+$/;
            if (!pattern.exec(staffName)) {
                formOk = false;
                errorMsg.text("Letter and space only.");
                $("[name='staff_name']").parents(".form-group").append(errorMsg.clone());
                if (firstErrorOffset === 0) {
                    firstErrorOffset = $("[name='staff_name']").offset().top;
                }
            }
        }
        if (!formOk) {
            event.preventDefault();
            $('html,body').animate({
                scrollTop: firstErrorOffset - 50
            }, 500);
        }
    });
});