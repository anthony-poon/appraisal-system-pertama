var logoutTimer = {
    logout: function(){
        alert('Your session have been terminated due to long inactivity. You will now be redirected to login.');
        window.location = 'login?action=logout';
    },
    init: function(){
        //clearTimeout(this.logoutTimer);
        //this.logoutTimer = setTimeout(this.logout, 1200000);
        var pingTime = 900000;
        setInterval(function(){
            $.ajax({
                url: "login?action=keepAlive",
                cache: false
            })
        }, pingTime);
    }
}
$(window).load(function(){
    logoutTimer.init();
})
