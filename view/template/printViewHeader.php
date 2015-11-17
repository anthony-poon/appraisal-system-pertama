<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href="public/css/parsley.css">
<script src="public/js/jquery-1.11.2.js"></script>
<link rel="stylesheet" type="text/css" href="public/css/jquery-ui.css">
<script src="public/js/jquery-ui.js"></script>
<script src="public/js/parsley.min.js"></script>
<script>
    function startTimeout() {
        timeLimit = 1200000;
        if (typeof timer !== 'undefined') {
            clearTimeout(timer);
        }           
        
        timer = setTimeout(function(){
            alert('Your session have been terminated due to long inactivity. You will now be redirected to login.');
            window.location = 'login?action=logout';
        }, timeLimit)
    }
    
    function keepAlive(timeLimit) {
        timeLimit = 900000;
        timer2 = setInterval(function(){
            $.ajax({
                url: "login?action=keepAlive",
                cache: false
            })
        }, timeLimit)
    }
    $(document).ready(function(){          
        startTimeout(); //is in ms. 1000 ms = 1 second
        keepAlive();        
    });
</script>
