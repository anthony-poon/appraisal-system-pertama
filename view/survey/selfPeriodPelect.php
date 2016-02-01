<?php
    $survey = $param["data"];
?>
<script>
    $(window).load(function(){
        $("select").change(function(){
            var uid = $(this).find(":selected").attr("id");
            var user = $("#period-select").attr("data-user");
            window.location.replace("survey?role=review&uid=" + uid + "u=" + user);
        })
    })
</script>
<div>
    <div id="period-select" class="wrapper" data-user="<?php echo $param["u"]?>">
        <?php if (!empty($survey)) { ?>
        <div id="label">
            Please select a survey
        </div>
        <div>
            <select>
                <option></option>
                <?php foreach ($survey as $detail) {
                    echo "<option value='".$detail["survey_uid"]."'>".$detail["survey_type"]." - ".$detail["survey_period"]."</option>";
                } ?>
            </select>
        </div>
        <?php } ?>
    </div>
</div>