<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title></title>
    </head>
    <script>
	$('document').ready(function(){
            $('#submitted_dialog').dialog({
                modal: true,
                buttons: {                
                    OK: function() {
                      $( this ).dialog( "close" );
                    }
                }
            })

            $('#back_button').on('click', function() {
                    window.location.replace("survey");
            });
	})
    </script>
    <body>
        <div class="contentWrapper">
            <div id='submitted_dialog'><div style='text-align:center'>Submitted</div></div>
            <div>
                Thank you. Your form have been submitted for review.
            </div>
			<div>
                <button id='back_button'>Back</button>
            </div>
        </div>

        <?php
        // put your code here
        ?>
    </body>
</html>
