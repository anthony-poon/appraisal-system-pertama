$(document).ready(function() {
    var user = {
        uid: $("form").attr("data-uid")
    }    
    
    $('#period_select').change(function() {
        if ($('#period_select').val() != '') {
            window.location.replace("report?uid=" + $('#period_select').val());
        }
    });

    $('.is_locked_checkbox').change(function() {
        $.ajax({
            url: 'report?action=toggleLock&r=admin&u=' + $(this).attr('username') + '&uid=' + user.uid,
            type: 'POST',
            dataType: 'json',
            success: function(ajaxData){
                location.reload();
            }
        });
    });

    $('#lock_all').click(function(event) {
        event.preventDefault();

        $.ajax({
            url: 'report?action=lockAll&uid=' + user.uid,
            type: 'POST',
            success: function() {
                location.reload();
            }
        });
    })

    $('#unlock_all').click(function(event) {
        event.preventDefault();

        $.ajax({
            url: 'report?action=unlockAll&uid=' + user.uid,
            type: 'POST',
            success: function() {
                location.reload();
            }
        });
    })          

    $('#get_excel').click(function(event) {
        event.preventDefault();                
        window.open("report?action=dataDump&uid=" + user.uid,"_blank");
    });
});