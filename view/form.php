<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<script type="text/javascript">
    function checkWeightSum() {
        var sum = 0;
        $('.weight').each(function() {
            sum += Number($(this).val());
        });
        if (sum !== 100) {
            return false;
        } else {
            return true;
        }
    }

    function checkIsFilled(element) {
        var isAllFilled = true;
        element.each(function() {
            if ($(this).val() === '' || $(this).val() === '0') {
                isAllFilled = false;
            }
        })

        return isAllFilled;
    }
    function getPartASubtotal() {
        var weight = [];
        var score = [];
        var result = 0
        $('.weight').each(function() {
            $(this).removeClass('parsley-error').addClass("parsley-success");
            weight.push($(this).val() / 100);

        });
        $('.a_score').each(function() {
            $(this).removeClass('parsley-error').addClass("parsley-success");
            score.push($(this).val());
        });

        $.each(weight, function(index, value) {
            result += value * score[index];
        });

        return result.toFixed(2);
    }

    function getCountersignedScore(preCounterScore, countersigner1Score, proportA, countersigner2Score, proportB) {
        var result = null;
        if (isNaN(proportA) || isNaN(proportB)) {
            if (isNaN(countersigner1Score) && isNaN(countersigner2Score)) {
                result = preCounterScore;
            } else if (!isNaN(countersigner1Score) && !isNaN(countersigner2Score)) {
                result = ((countersigner1Score * 0.5 + countersigner2Score * 0.5) + preCounterScore) * 0.5;
            } else {
                if (isNaN(countersigner1Score)) {
                    result = (preCounterScore + countersigner2Score) / 2;
                } else {
                    result = (preCounterScore + countersigner1Score) / 2;
                }

            }
        } else {
            if (isNaN(countersigner1Score) && isNaN(countersigner2Score)) {
                result = preCounterScore;
            } else if (!isNaN(countersigner1Score) && !isNaN(countersigner2Score)) {
                result = (preCounterScore + countersigner1Score) / 2 * (proportA / (proportA + proportB)) + countersigner2Score * (proportB / (proportA + proportB))
            } else {
                if (isNaN(countersigner1Score)) {
                    result = (preCounterScore + countersigner2Score) / 2;
                } else {
                    result = (preCounterScore + countersigner1Score) / 2;
                }

            }
        }


        console.log(result.toFixed(2));


        return result.toFixed(2);
    }

    $(document).ready(function() {
        
        $("#excel_button").click(function(){
            window.location = "report?action=outputFile&u=<?php echo $_GET['u']?>&uid=<?php echo $_GET['uid']?>"
        })

        var shouldShowInstuction = <?php echo (!empty($param['shouldShowInstuction']) ? '1' : '0' ); ?>;

        if (shouldShowInstuction) {
            $("#dialog").dialog({
                width: 700,
                modal: true,
                buttons: {
                    OK: function() {
                        $(this).dialog("close");
                    }
                }
            });

            $(document).scroll(function(e) {
                if ($(".ui-widget-overlay"))
                {
                    $(".ui-widget-overlay").css({
                        position: 'fixed',
                        top: '0'
                    });

                    pos = $(".ui-dialog").position();

                    $(".ui-dialog").css({
                        position: 'fixed',
                        top: pos.y
                    });
                }
            });
        } else {
            $("#dialog").hide();
        }

        $('.system_value').prop('disabled', true);

        $('input').keydown(function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                $(this).trigger('change');
                return false;
            }
        });

        $('#plus_button_a').click(function() {
            var fieldName = $('#plus_button_a').attr('next');
            $.ajax({
                url: 'survey?action=addPartAItem&u=<?php echo $param['u'] ?>&r=<?php echo $param['r'] ?>&uid=<?php echo $param['uid'] ?>',
                dataType: 'POST',
                data: {
                    "fieldName": fieldName,
                    "value": ''
                },
                success: function() {
                    location.reload();
                }
            });
        });

        $('#plus_button_d').click(function() {
            var fieldName = $('#plus_button_d').attr('next');
            $.ajax({
                url: 'survey?action=postFormData&u=<?php echo $param['u'] ?>&r=<?php echo $param['r'] ?>&uid=<?php echo $param['uid'] ?>',
                type: 'POST',
                data: {
                    "fieldName": fieldName,
                    "value": ''
                },
                success: function() {
                    location.reload();
                }
            });
        });

        $('.delete_button_a').click(function() {
            var qid = $(this).attr('qid');
            $.ajax({
                url: 'survey?action=clearA&u=<?php echo $param['u'] ?>&r=<?php echo $param['r'] ?>&uid=<?php echo $param['uid'] ?>&qid=' + qid,
                type: 'DELETE',
                success: function() {
                    location.reload();
                }
            });
        });

        $('.delete_button_d').click(function() {
            var qid = $(this).attr('qid');
            $.ajax({
                url: 'survey?action=clearD&u=<?php echo $param['u'] ?>&r=<?php echo $param['r'] ?>&uid=<?php echo $param['uid'] ?>&qid=' + qid,
                type: 'DELETE',
                success: function() {
                    location.reload();
                }
            });
        });

        role = '<?php echo $param['r'] ?>';

        switch (role) {
            case 'self':
                $('.appraiser').prop('disabled', true);
                $('.counter1').prop('disabled', true);
                $('.counter2').prop('disabled', true);
                $('[name=part_b1_overall_comment]').prop('disabled', true);
                $('[name=part_b2_overall_comment]').prop('disabled', true);
                $('#plus_button_d').hide();
                $('.delete_button_d').hide();
                break;
            case 'app':
                $('.self').prop('disabled', true);
                $('.counter1').prop('disabled', true);
                $('.counter2').prop('disabled', true);
                $('#plus_button_a').hide();
                $('.delete_button_a').hide();
                
                break;
            case 'counter1':
                $('.self').prop('disabled', true);
                $('.appraiser').prop('disabled', true);
                $('.counter2').prop('disabled', true);
                $('#plus_button_a').hide();
                $('.delete_button_a').hide();
                $('#plus_button_d').hide();
                $('.delete_button_d').hide();
                break;
            case 'counter2':
                $('.self').prop('disabled', true);
                $('.appraiser').prop('disabled', true);
                $('.counter1').prop('disabled', true);
                $('#plus_button_a').hide();
                $('.delete_button_a').hide();
                $('#plus_button_d').hide();
                $('.delete_button_d').hide();
                break;
            case 'review':
                $('#survey :input').prop('disabled', true);
                $('#plus_button_a').hide();
                $('.delete_button_a').hide();
                $('#plus_button_d').hide();
                $('.delete_button_d').hide();
                break;
        }

        var isSenior = true;

        $.ajax({
            url: 'survey?action=getFormData&u=<?php echo $param['u'] ?>&uid=<?php echo $param['uid'] ?>&r=<?php echo $param['r'] ?>',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                if (data['is_senior'] == 0) {
                    isSenior = false;
                    $('#part_b2').hide();
                    $('#part_b2_title').hide();
                }

                var isFinalBySelf = data['is_final_by_self'];

                var isFinalByApp = data['is_final_by_appraiser'];

                var isConfirmedBySelf = data['is_confirmed_by_self_after_final'];

                var isConfirmedByApp = data['is_confirmed_by_app_after_final'];

                var isRecentlyChanged = '<?php echo $param['shouldShowRecentChanges'] ?>';

                counter1Weight = parseInt(data['countersigner_1_weight']);
                counter2Weight = parseInt(data['countersigner_2_weight']);

                if (data['is_locked'] === '1') {
                    $('form :input').prop('disabled', true);
                    $('#plus_button_a').hide();
                    $('.delete_button_a').hide();
                    $('#plus_button_d').hide();
                    $('.delete_button_d').hide();
                    $('#system_message').text('Your form was locked. Changes are not allowed at the moment.');
                } else if (isConfirmedByApp === '1' && isConfirmedBySelf === '1' && (role === 'app' || role === 'self')) {
                    $('form :input').prop('disabled', true);
                    $('[class^=delete_button], [id^=plus_button]').hide();
                    $('#system_message').text('Both parties confirmed the form. Changes are not allowed at the moment.');
                } else if (role === 'app') {
                    //(1/0)-1-0-0
                    if (isFinalByApp === '1' && isConfirmedByApp === '0' && isConfirmedBySelf === '0') {
                        $('form :input').prop('disabled', true);
                        $('[class^=delete_button], [id^=plus_button]').hide();
                        $('#system_message').append('<div> Please inform appraisee to amend or confirm the appraisal. If you need to amend the form, please <input type="button" id="form_change" value="edit here">.</div>');
                    }
                    //1-1-1-0
                    if (isFinalByApp === '1' && isFinalBySelf === '1' && isConfirmedBySelf === '1' && isConfirmedByApp === '0') {
                        $('form :input').prop('disabled', true);
                        $('[class^=delete_button], [id^=plus_button]').hide();
                        $('#system_message').append('<div>Your appraisee has completed his/her parts. Please review and <input type="button" id="confirm_form" value="confirm here">.');
                        $('#system_message').append("<div>If you need to amend the form, please <input type='button' id='form_change' value='edit here'>. (Please inform your appraisee to review and submit if you have changed it)</div>");
                    }
                    if (isFinalByApp === '0' && isRecentlyChanged === '1') {
                        $('#system_message').append('<div>The form was changed recently by appraisee. Please review and submit the form</div>');
                    }
                } else if (role === 'self') {
                    //1-0-0-0
                    if (isFinalBySelf === '1' && isFinalByApp === '0' && isConfirmedByApp === '0' && isConfirmedBySelf === '0') {
                        $('form :input').prop('disabled', true);
                        $('[class^=delete_button], [id^=plus_button]').hide();
                        $('#system_message').append('<div>If you need to amend the form, please <input type="button" id="form_change" value="edit here">. Please inform appraising officer to complete and submit his/her parts.</div>');
                    }
                    //1-1-0-0
                    if (isFinalBySelf === '1' && isFinalByApp === '1' && isConfirmedBySelf === '0' && isConfirmedByApp === '0') {
                        $('form :input').prop('disabled', true);
                        $('[class^=delete_button], [id^=plus_button]').hide();
                        $('#system_message').append('<div>Your appraising officer has completed his/her parts. Please review and <input type="button" id="confirm_form" value="confirm here">.</div>');
                        $('#system_message').append('<div>If you need to amend the form, please <input type="button" id="form_change" value="edit here">. Your appraising officer needs to review and reconfirm the form afterwards</div>');
                    }
                    if (isFinalBySelf === '1' && isFinalByApp === '1' && isConfirmedBySelf === '1' && isConfirmedByApp === '0') {
                        $('form :input').prop('disabled', true);
                        $('[class^=delete_button], [id^=plus_button]').hide();
                        $('#system_message').append("<div>You have confirmed the form. If you need to amend it, please <input type='button' id='form_change' value='edit here'> before the deadline. (Please inform your appraising officer to review and submit if you have changed it)</div>");
                    }
                }
                $('#excel_button').prop('disabled', false);

                $.each(data, function(fieldName, dbValue) {
                    if (dbValue != 0 && dbValue != null) {
                        if ($.isArray(dbValue)) {
                            $.each(dbValue, function(index, value) {
                                if (fieldName == 'partA') {
                                    $.each(value, function(fName, v) {
                                        if (v != 0 && v != null) {
                                            v = $("<div/>").html(v).text();
                                            $("[name='multi_a_" + fName + "_" + value['question_no'] + "']").val(v);
                                        }
                                    });
                                } else if (fieldName == 'partB1') {
                                    $.each(value, function(fName, v) {
                                        if (v != 0 && v != null) {
                                            if ($("[name='multi_b1_" + fName + "_" + value['question_no'] + "']").attr('type') == 'radio') {
                                                $("[name='multi_b1_" + fName + "_" + value['question_no'] + "'][value='" + v + "']").prop('checked', true);
                                            } else {
                                                v = $("<div/>").html(v).text();
                                                $("[name='multi_b1_" + fName + "_" + value['question_no'] + "']").val(v);
                                            }
                                        }
                                    });

                                } else if (fieldName == 'partB2') {
                                    $.each(value, function(fName, v) {
                                        if (v != 0 && v != null) {
                                            if ($("[name='multi_b2_" + fName + "_" + value['question_no'] + "']").attr('type') == 'radio') {
                                                $("[name='multi_b2_" + fName + "_" + value['question_no'] + "'][value='" + v + "']").prop('checked', true);
                                            } else {
                                                v = $("<div/>").html(v).text();
                                                $("[name='multi_b2_" + fName + "_" + value['question_no'] + "']").val(v);
                                            }
                                        }
                                    });
                                } else if (fieldName == 'partD') {
                                    $.each(value, function(fName, v) {
                                        if (v != 0 && v != null) {
                                            if ($("[name='multi_d_" + fName + "_" + value['question_no'] + "']").attr('type') == 'radio') {
                                                $("[name='multi_d_" + fName + "_" + value['question_no'] + "'][value='" + v + "']").prop('checked', true);
                                            } else {
                                                v = $("<div/>").html(v).text();
                                                $("[name='multi_d_" + fName + "_" + value['question_no'] + "']").val(v);
                                            }
                                        }
                                    });
                                }
                            })
                        } else if ($("[name='" + fieldName + "']").attr('type') == 'radio') {
                            $("[name='" + fieldName + "'][value='" + data[fieldName] + "']").prop('checked', true);
                        } else if ($("[name='" + fieldName + "']").is("select")) {
                            dbValue = $("<div/>").html(dbValue).text();
                            if ($("[name='" + fieldName + "'] option[value='" + dbValue + "']").length == 0) {
                                $("<option custom='true' value='" + dbValue + "'>" + dbValue + "</option>").insertBefore($('#part_c select[name=' + fieldName + ']').children('[value^="Others"]'));
                                $('#part_c select[name="' + fieldName + '"]').children("[value='" + dbValue + "']").attr('selected', true);
                            } else {
                                if (dbValue.length > 0) {
                                    $("[name='" + fieldName + "']").val(dbValue);
                                }
                            }
                        } else {
                            dbValue = $("<div/>").html(dbValue).text();
                            $("[name='" + fieldName + "']").val(dbValue);
                        }
                    }
                });

                $('#form_change').on('click', function() {
                    $.ajax({
                        url: 'survey?action=formChange&u=<?php echo $param['u'] ?>&uid=<?php echo $param['uid'] ?>&r=<?php echo $param['r'] ?>',
                        type: 'POST',
                        success: function() {
                            location.reload();
                        }
                    });
                });

                $('#confirm_form').on('click', function() {
                    $.ajax({
                        url: 'survey?action=confirmAfterFinish&u=<?php echo $param['u'] ?>&uid=<?php echo $param['uid'] ?>&r=<?php echo $param['r'] ?>',
                        type: 'POST',
                        success: function() {
                            location.reload();
                        }
                    });
                });

            },
            error: function() {
                alert('Failed to load data. Please press F5 to refresh the page');
            }
        });

        $('#survey').parsley({
            priorityEnabled: 'true',
            excluded: "input[type=button], input[type=submit], input[type=reset], input[type=hidden], [disabled], :hidden",
            errorsWrapper: "<div></div>",
            errorTemplate: "<span class='error_msg'></span>",
        });

        $(":input").change(function() {
            var bypass = false;
            startTimeout();
            $(this).val($.trim($(this).val()));
            $(this).parsley().validate();

            if ($(this).is("#part_c select")) {
                if ($(this).val().substring(0, 6) === "Others") {
                    bypass = true;
                }
            }

            if ($(this).parsley().isValid() && !bypass) {
                var data = {};
                data.value = $(this).val();
                data.fieldName = $(this).attr('name');

                $.ajax({
                    url: 'survey?action=postFormData&u=<?php echo $param['u'] ?>&uid=<?php echo $param['uid'] ?>&r=<?php echo $param['r'] ?>',
                    type: 'POST',
                    data: {
                        "fieldName": $(this).attr('name'),
                        "value": $(this).val()
                    }
                });
            }

            if ($(this).val() === '0') {
                $(this).val("");
                $(this).removeClass("parsley-success");
            }
        });

        $('.weight, .a_score').change(function() {
            if ($(this).parsley().isValid() && checkWeightSum() && checkIsFilled($('.weight, .a_score'))) {

                var result = getPartASubtotal();
                $("[name='part_a_overall_score']").val(result);
                $("[name='part_a_overall_score']").trigger('change');
            } else {
                $("[name='part_a_overall_score']").val('');
                $("[name='part_a_overall_score']").trigger('change');
            }
        });

        $("[name^=multi_b1_appraiser_score_]").change(function() {
            var sum = 0;
            var weight = 1 / $("[name^=multi_b1_appraiser_example_]").length;
            $("[name^=multi_b1_appraiser_score_]:checked").each(function() {
                sum += $(this).val() * weight;
            });
            $("[name='part_b1_overall_score']").val(sum.toFixed(2));
            $("[name='part_b1_overall_score']").trigger('change');
        });

        $("[name^=multi_b2_appraiser_score_]").change(function() {
            var sum = 0;
            var weight = 1 / $("[name^=multi_b2_appraiser_example_]").length;
            $("[name^=multi_b2_appraiser_score_]:checked").each(function() {
                sum += $(this).val() * weight;
            });
            $("[name='part_b2_overall_score']").val(sum.toFixed(2));
            $("[name='part_b2_overall_score']").trigger('change');
        });

        var listeningElementA = $("[name=part_a_overall_score], [name=countersigner_1_part_a_score], [name=countersigner_2_part_a_score]");
        listeningElementA.change(function() {
            if ($(this).parsley().isValid()) {

                var isAllFilled = true;
                $.each($('[name^=multi_a_respon_weight], [name^=multi_a_respon_score]'), function() {
                    if (!$(this).parsley().isValid()) {
                        isAllFilled = false;
                    }
                });

                if (isAllFilled) {
                    var preCounterScore = parseFloat($("[name=part_a_overall_score]").val());
                    var countersigner1Score = parseFloat($('[name=countersigner_1_part_a_score]').val());
                    var countersigner2Score = parseFloat($('[name=countersigner_2_part_a_score]').val());
                    var result = getCountersignedScore(preCounterScore, countersigner1Score, counter1Weight, countersigner2Score, counter2Weight);
                }

                if (!isNaN(result)) {
                    $("[name=part_a_total]").val(result);
                    $("[name=part_a_total]").trigger('change');
                } else {
                    $("[name=part_a_total]").val("");
                    $("[name=part_a_total]").trigger('change');
                }

            }
        });

        var listeningElementB = $("[name=countersigner_1_part_b_score], [name=countersigner_2_part_b_score], [name=part_b1_overall_score], [name=part_b2_overall_score]");
        $(listeningElementB).change(function() {
            if ($(this).parsley().isValid()) {
                var scoreFromAppraiser = null;
                if (isSenior === false) {
                    scoreFromAppraiser = parseFloat($('[name=part_b1_overall_score]').val());
                } else {
                    scoreFromAppraiser = parseFloat($('[name=part_b1_overall_score]').val()) * 0.6 + parseFloat($('[name=part_b2_overall_score]').val()) * 0.4;
                }

                var result = getCountersignedScore(scoreFromAppraiser, parseFloat($('[name=countersigner_1_part_b_score]').val()), counter1Weight, parseFloat($('[name=countersigner_2_part_b_score]').val()), counter2Weight)

                if (!isNaN(result)) {
                    $("[name=part_b_total]").val(result);
                    $("[name=part_b_total]").trigger('change');
                } else {
                    $("[name=part_b_total]").val("");
                    $("[name=part_b_total]").trigger('change');
                }
            }
        });

        $("[name=part_a_total], [name=part_b_total]").change(function() {
            var result = (parseFloat($('[name=part_a_total]').val()) + parseFloat($('[name=part_b_total]').val())) / 2;
            if (!isNaN(result) && $("[name=part_a_total]").val() !== '' && $("[name=part_b_total]").val() !== '') {
                $('[name=part_a_b_total]').val(result.toFixed(2));
                $('[name=part_a_b_total]').trigger('change');
            } else {
                $('[name=part_a_b_total]').val("");
                $('[name=part_a_b_total]').trigger('change');
            }
        })

        $('#custom_dropdown').hide();

        $('#part_c select').change(function(event) {
            var element = $(this);
            if ($(this).val().substring(0, 6) === 'Others') {
                element.children("[value='']").attr('selected', true);
                $('#custom_dropdown .section_error').html("");
                $('#custom_dropdown').dialog({
                    modal: true,
                    buttons: {
                        OK: function() {
                            var str = $('#custom_dropdown input').val().trim();
                            if (str.match(/[;"'\\]/)) {
                                $('#custom_dropdown .section_error').html("Cannot contain the following characters &quot; &#39; ; \\");
                            } else {
                                if (str.length > 0) {
                                    element.children("[custom='true']").remove();
                                    $("<option custom='true' value='" + str + "'>" + str + "</option>").insertBefore(element.children('[value^="Others"]'));
                                    element.children("[value='" + str + "']").attr('selected', true);
                                    element.trigger("change");
                                    $(this).dialog("close");
                                    $('#custom_dropdown input').val("")
                                } else {
                                    $('#custom_dropdown .section_error').html("This cannot be empty.");
                                }
                            }
                        }
                    }
                });
            }
        })

        $('#confirm_checkbox').change(function() {
            if ($('#confirm_checkbox').is(':checked')) {
                $('#submit_button').removeAttr('disabled');
            } else {
                $('#submit_button').prop('disabled', true)
            }
        });


        $('#survey').parsley().subscribe('parsley:form:validated', function(formInstance) {
            var focusElement;
            var isAtLeastOne = false;
            var isAllFilled = true;
            var isFormOk = true;
            //formInstance.submitEvent.preventDefault();
            $('.section_error').html('');

            if (role === 'app') {

                //--------Part A Checking---------

                if (!checkWeightSum()) {
                    if (typeof focusElement === 'undefined') {
                        focusElement = '#part_a .section_error';
                    }
                    $('#part_a .section_error').html("The total of weight must equal 100!").addClass("filled");
                    $('.weight').removeClass('parsley-success').addClass('parsley-error');
                    isFormOk = false;
                } else if (!checkIsFilled($('.weight, .a_score'))) {
                    $('#part_a .section_error').html("Missing weight or score!").addClass("filled");
                    $('.weight').removeClass('parsley-success').addClass('parsley-error');
                    isFormOk = false;
                } else {
                    var result = getPartASubtotal();
                    $("[name='part_a_overall_score']").val(result);
                    $("[name='part_a_overall_score']").trigger('change');
                }

                //--------Part C Checking---------

                $.each($('#professional_competency :input'), function(index, element) {
                    if ($.trim($(element).val()) !== "") {
                        isAtLeastOne = true;
                    }
                });

                if (!isAtLeastOne) {
                    if (typeof focusElement === 'undefined') {
                        focusElement = '#professional_competency .section_error';
                    }

                    $('#professional_competency .section_error').html("Please input at least 1 \"Professional Competency\"").addClass("filled");
                    $('#professional_competency :input').addClass('parsley-error');
                    isFormOk = false;
                }

                isAtLeastOne = false;

                $.each($('#core_competency :input'), function(index, element) {
                    if ($.trim($(element).val()) !== "") {
                        isAtLeastOne = true;
                    }
                });

                if (!isAtLeastOne) {
                    if (typeof focusElement === 'undefined') {
                        focusElement = '#core_competency .section_error';
                    }

                    $('#core_competency .section_error').html("Please input at least 1 \"Core Competency\"").addClass("filled");
                    $('#core_competency :input').addClass('parsley-error');
                    isFormOk = false;
                }

                isAllFilled = true;

                $.each($('#training_need :input'), function(index, element) {
                    if ($(element).val() == null || $(element).val() == '') {
                        $(element).addClass('parsley-error');
                        isAllFilled = false;
                    } else {
                        $(element).addClass('parsley-success');
                    }
                });

                if (!isAllFilled) {
                    if (typeof focusElement === 'undefined') {
                        focusElement = '#training_need .section_error';
                    }
                    $('#training_need .section_error').html("Please fill in all value").addClass("filled");
                    isFormOk = false;
                }

                var sum = 0;
                $('[name^=multi_d_goal_weight_]').each(function() {
                    sum += Number($(this).val());
                });

                if (sum !== 100) {
                    isFormOk = false;
                    if (typeof focusElement === 'undefined') {
                        focusElement = '#part_d';
                    }
                    $('#part_d .section_error').append("<p>Sum of weight must equal 100!</p>");
                    $('[name^=multi_d_goal_weight_]').each(function() {
                        $(this).addClass("parsley-error");
                    });
                }

                //--------Part D Checking---------

                var today = new Date();
                var isDateOK = true;

                $.each($('[name^=multi_d_complete_date_]'), function() {
                    var tarDate = new Date($(this).val())
                    if (tarDate.getYear() - today.getYear() < 0) {
                        isFormOk = false;
                        isDateOK = false;
                        $(this).addClass('parsley-error');

                    } else if (tarDate.getMonth() - today.getMonth() <= 0 && tarDate.getYear() - today.getYear() <= 0) {
                        isFormOk = false;
                        isDateOK = false;
                        $(this).addClass('parsley-error');
                    }
                })

                if (!isDateOK) {
                    $('#part_d .section_error').append("<p>Please insert a date that is later then this month</p>");
                    if (typeof focusElement === 'undefined') {
                        focusElement = '#part_d';
                    }
                }

                if (!isFormOk && $('#survey').parsley().isValid()) {
                    $('html,body').animate({
                        scrollTop: $(focusElement).offset().top
                    }, 200);
                    formInstance.submitEvent.preventDefault();
                }
            }
        });
    });
</script>

<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" charset="UTF-8" />
        <title></title>
    </head>
    <body>        
        <div class="outline">
            <div id='dialog' title="Guidelines:">
                <ul>
                    <li>During the completion of the Performance Appraisal form, you can exit anytime and all data input will be saved automatically.</li>
                    <li>When all mandatory parts are completed, please press “<b>Submit</b>” button at the bottom of the page for submission and confirmation.</li>
                    <li>Before the completion deadline, you can access the form for unlimited times and make adjustment before you re-submit the form.</li>
                    <li>For “<b>Appraisee</b>”, Part A, Part B1 and Part E are mandatory for all job grades; while for Deputy General Manager or above grade, please complete Part B2 as well. If no further comments in Part E, please remark as “No Comment” in the text box.</li>
                    <li>For “<b>Appraising Officer</b>”, please complete Part A to Part E upon the self-assessment submitted by the appraisee.</li>
                    <li>For “<b>Countersigning Officer</b>”, please read all parts and input alternative scores in Part A total and Part B total ONLY IF you disagree with the appraisal scores assessed by the Appraising Officer, so as to calibrate the final results for appraisee.</li>
                </ul>
            </div>
            <form method="post" action="survey?action=finish&r=<?php echo $param['r'] ?>&u=<?php echo $param['u'] ?>&uid=<?php echo $param['uid'] ?>" id="survey" data-parsley-priority-enabled="true" novalidate>
                <div id="headerBar"> </div>
                <div class="contentWrapper">
                    <div>
                        <input type="button" id="excel_button" value="Print in Excel format">
                    </div>
                    <div class='logo'>
                        <img src="public/img/logo.png">
                    </div>
                    <div class='title'>
                        PERFORMANCE APPRAISAL FORM
                    </div>
                    <div class="section_error" id="system_message"></div>
                    <div class='part' id='basic_info'>
                        <div class='part_title' id="info_title">
                            Employee Information
                        </div>
                        <div class="collectionContainer">
                            <div class='collection'>
                                <label class='collectionTitle'>
                                    <div>
                                        Staff Name:
                                    </div>
                                </label>
                                <input type='text' class='system_value' name='staff_name' >
                            </div>
                            <div class='collection'>
                                <label class='collectionTitle'>
                                    <div>
                                        Department/Division:
                                    </div>
                                </label>
                                <input type='text' class='system_value' name='staff_department' >
                            </div>
                            <div class='collection'>
                                <label class='collectionTitle'>
                                    <div>
                                        Position/Grade:
                                    </div>
                                </label>
                                <input type='text' class='system_value' name='staff_position' >
                            </div>
                        </div>
                        <div class='collectionContainer'>
                            <div class='collection'>
                                <label class='collectionTitle'>
                                    <div>
                                        Office:
                                    </div>
                                </label>
                                <input type='text' class='system_value'  name='staff_office' >
                            </div>
                            <div class='collection'>
                                <label class='collectionTitle'>
                                    <div>
                                        Appraising Officer Name:
                                    </div>
                                </label>
                                <input type='text' class='system_value' name='appraiser_name' >
                            </div>
                            <div class='collection'>
                                <label class='collectionTitle'>
                                    <div>
                                        Countersigning Officer Name:
                                    </div>
                                </label>
                                <input type='text' class='system_value' name='countersigner_name' >
                            </div>
                        </div>
                        <div class='collectionContainer'>
                            <div class='collection'>
                                <label class='collectionTitle'>
                                    <div>
                                        Period of Evaluation:
                                    </div>
                                </label>
                                <input type='text' class='system_value' name='survey_period' >
                            </div>
                            <div class='collection'>
                                <label class='collectionTitle'>
                                    <div>
                                        Commencement Date:
                                    </div>
                                </label>
                                <input type='date' class='system_value' name='survey_commencement_date' required>
                            </div>
                            <div class='collection'>
                                <label class='collectionTitle'>
                                    <div>
                                        Types of Appraisal
                                    </div>
                                </label>
                                <input type='text' class='system_value' name='survey_type' id='mid_yearly'>
                            </div>                      
                        </div>
                    </div>
                    <div class='part'>
                        <p>
                            Scoring Scheme: Below Deputy General Manager Level - Part A (50%) + Part B (50%); Deputy General Manager Level and above - Part A (50%) + Part B1 (30%) + Part B2 (20%)
                        </p>
                        <div class='part_title' id="part_a_title">
                            Part A: Accomplishments of Key Responsibilities or Objectives
                        </div>
                        <p>
                            For Employee: please state at least 3 key responsibilities or objectives under the direction of your supervisor, and conduct a self-evaluation on your achievements/results achieved.
                        </p>
                        <p>
                            For Appraising Officer: please evaluate the employee's key responsibilities and results achieved, then assign a reasonable score.
                        </p>
                        <p>
                            * Weight: Appraising Officer has to judge and give weight of each key responsibility that their subordinates are responsible for in terms of importance. Total weight must be equal to 100%.
                        </p>
                    </div>
                    <div class='part' id='part_a'>
                        <div class="section_error">
                        </div>
                        <?php
                        $data = new formData($param['u'], $param['uid']);
                        $rowCount = $data->getPartACount();
                        if ($rowCount <= 2) {
                            $rowCount = 3;
                        }
                        for ($i = 1; $i <= $rowCount; $i ++) {
                            ?>
                            <div class='collectionContainer part_a_set'>
                                <div class='collection delete_button'>
                                    <div class='delete_button_a' qid='<?php echo $i; ?>'></div>
                                </div>
                                <div class='collection left'>
                                    <div class='collectionTitle'>
                                        <div>
                                            For Employee
                                        </div>
                                    </div>
                                    <div class='collectionContainer'>
                                        <div class='collection'>
                                            <label>Key Responsibilities or Objectives: </label>
                                            <textarea type='text' class='self' name='multi_a_respon_name_<?php echo $i; ?>' required></textarea>
                                        </div>
                                        <div class='collection'>
                                            <label>Achievements/Results Achieved</label>
                                            <textarea class='self' name='multi_a_respon_result_<?php echo $i; ?>' required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class='collection right'>
                                    <div class='collectionTitle'>
                                        <div>
                                            For Appraising Officer
                                        </div>
                                    </div>
                                    <div class='collectionContainer'>
                                        <div class='collection comment'>
                                            <label>Comments by Appraising Officer</label>
                                            <textarea class='appraiser' name='multi_a_respon_comment_<?php echo $i; ?>' required></textarea>
                                        </div>
                                        <div class='collection score'>
                                            <label class='collectionTitle'>
                                                <div>
                                                    Weight (%)*
                                                </div>
                                            </label>
                                            <input type='text' class='appraiser weight' name='multi_a_respon_weight_<?php echo $i; ?>' required data-parsley-type="integer" data-parsley-range="[1,100]" data-parsley-error-message="Enter a integer from 1-100">
                                            <label class='collectionTitle'>
                                                <div>
                                                    Score
                                                </div>
                                            </label>
                                            <input type='text' class='appraiser a_score' name='multi_a_respon_score_<?php echo $i; ?>' required data-parsley-type="integer" data-parsley-range="[1,5]" data-parsley-error-message="Enter a integer from 1-5">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class='collectionContainer'> 
                            <div class='collection' id='plus_button_a' next="multi_a_respon_name_<?php echo $rowCount + 1 ?>">
                                +
                            </div>
                        </div>
                        <div class='collectionContainer'>
                            <div class='collection overall_score'>
                                <div class='collectionTitle'>
                                    <div>
                                        Part A subtotal
                                    </div>
                                </div>
                                <div class='subtotal'>
                                    <input class='appraiser subtotal' type='text' name='part_a_overall_score' disabled> 
                                </div>
                            </div>
                        </div>                        
                        <div class='countersigner'>
                            <div class='collectionTitle'>
                                <div>
                                    Scoring from Countersigning Officer:
                                </div>
                            </div>
                            <div class='collectionContainer'>
                                <div class='collection'>
                                    <p><label> Name : </label> <input type='text' class='system_value' name='countersigner_1_name'></p>
                                    <div class='collectionContainer'>
                                        <div class='collection'>
                                            <label> Score : </label> <input type='text' class='counter1' name='countersigner_1_part_a_score' data-parsley-type="number" data-parsley-range="[0,5]">
                                        </div>
                                        <!--<div class='collection'>
                                            <label> Weight : </label> <input type='text' class='system_value' name='countersigner_1_weight'>
                                        </div>-->
                                    </div>
                                </div>
                                <div class='collection'>                                   
                                    <p><label> Name : </label> <input type='text' class='system_value' name='countersigner_2_name'></p>

                                    <div class='collectionContainer'>
                                        <div class='collection'>
                                            <label> Score : </label> <input type='text' class='counter2' name='countersigner_2_part_a_score' data-parsley-type="number" data-parsley-range="[0,5]">
                                        </div>
                                        <!--<div class='collection'>
                                            <label> Weight : </label> <input type='text' class='system_value' name='countersigner_2_weight'>
                                        </div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='collectionContainer'>
                            <div class='collection total_score'>
                                <div class='collectionTitle'>
                                    <div>
                                        Part A Total
                                    </div>
                                </div>
                                <div class='subtotal'>
                                    <input class='system_value subtotal' type='text' name='part_a_total' disabled> 
                                </div>
                            </div>
                        </div> 
                    </div>



                    <div class='part_title' id="part_b_title">
                        Part B: Competencies Assessment
                    </div>
                    <p>
                        This part should be completed by both the Appraising Officer and the Employee.
                    </p>
                    <div class='part_title' id="part_b1_title">
                        Part B1: This section is applicable to all employees
                    </div>
                    <div class='part part_b' id='part_b1'>
                        <?php

                        class scoringScheme {

                            public $name;
                            public $scoreArray = array();

                        }

                        for ($i = 1; $i <= 8; $i++) {
                            $question[$i] = new scoringScheme();
                        }

                        $question[1]->name = "Teamwork and Support";
                        $question[1]->scoreArray = array(
                            "Fosters team spirit, encourages others to contribute and draws on wide variety of others' skills to achieve team success.",
                            "Cooperates with colleagues, willingly shares team values, listens, makes a constructive contribution to teams and builds on team success.",
                            "Liaises with colleagues, willingly shares team information and knowledge and makes a constructive contribution to teams. Recognize one's limit and seek for support without delay.",
                            "Did not demonstrate the willingness to work amicably with colleagues or proactively support others in times of need",
                            "Behaves in a disruptive manner within team, is confrontational and negatively criticises others and their contributions. Not considered a team worker."
                        );

                        $question[2]->name = "Ownership";
                        $question[2]->scoreArray = array(
                            "Has a record of taking ownership for major problems, crises and issues and ensuring timely and well judged decisions are made and involving others as necessary.",
                            "Has a record of taking ownership for customer problems, team goals and challenging objectives and seeks assistance whenever appropriate.",
                            "Has a limited record of taking ownership for own decisions and outcomes and does not depend unduly on others, however, knows when to ask for assistance.",
                            "Has not demonstrated ownership.",
                            "Ignores potential problems, 'not my problem attitude', blames others for problems rather than helps to resolve problems."
                        );

                        $question[3]->name = "Customer Focus";
                        $question[3]->scoreArray = array(
                            "Exceeds customers' expectations, develops mutually beneficial relationships with customers.",
                            "Has an in-depth understanding of customer needs (gained via experience and research), use this build customer confidence, to develop improvements in customer service levels and relationships.",
                            "Has correct understanding of customer needs, received good customer feedback, responding appropriately to customer issues and displays a concern to improve customer service levels.",
                            "Has no record of working with internal or external customers.",
                            "Has no observable desire to provide service to others. Past customers have requested that this person does no further work/is removed from site."
                        );

                        $question[4]->name = "Initiative";
                        $question[4]->scoreArray = array(
                            "Has a record of creating, seizing and driving new ideas and opportunities to implementation.",
                            "Anticipates problems and takes per-emptive action to deal with them, has a record of evaluating problems and developing more effective ways of doing things.",
                            "Gets on with jobs, does not need asking to do things and generates ideas for helping to resolve issues.",
                            "No evidence of using initiative and seizing opportunities to take action.",
                            "Shows no initiative at all, has to be asked to do things and requires supervision and guidance or set procedures to follow."
                        );

                        $question[5]->name = "Attention to Detail";
                        $question[5]->scoreArray = array(
                            "Consistently high standard with work right first time, sets an example to others and source of advice and guidance.",
                            "Shows concern for quality, produces high quality work which is mostly right first time.",
                            "Concentrates, checks that work is accurate, make few mistakes and learns from them. Seeks advice/help as appropriate.",
                            "No evidence of concern for quality of the job.",
                            "Makes careless and simple mistakes, work in generally sloppy and has to be checked or re-worked, shows no concern for quality standards. Mistakes have impact on service quality."
                        );

                        $question[6]->name = "Problem Solving and Decision Making";
                        $question[6]->scoreArray = array(
                            "Has record of developing timely solutions for major problems, looks at wider issues, is creative and uses wide range of tools and sources to develop solutions.",
                            "Has record of analysing and developing solutions to complex problems, searches widely for options, aware and proficient in a variety of techniques. Offered new ideas and solutions that are not tied to past method and result in order to increase the value of work.",
                            "Has record of handling straight forward problems and developing workable solutions including but not limited to reorganize work unit structure, job assignment or resources. Offered constructive and practical suggestions to tackle work problems.",
                            "No evidence of successful problem solving skills and not willing to handle challenging tasks or accept changes in role or situation.",
                            "Is generally unsuccessful in solving problems or takes longer than necessary even with straight forward problems. No concept of whom to ask for support/advice and can handle ordinary routine works only."
                        );

                        $question[7]->name = "Achieving Results and Compliance";
                        $question[7]->scoreArray = array(
                            "Has a record of achieving nearly all goals set on schedule, in budget, and anticipating and managing complexities, changing priorities and needs - 80/20%, while the tasks completed are complying the Company goals, quality objectives, policies and procedures. ",
                            "Has a record of mostly achieving goals agreed or set in budget and generally on schedule - 70/30%, while the tasks completed are complying the Company goals, quality objectives, policies and procedures. ",
                            "Has a record of generally achieving goals agreed - 60/40%, while the tasks completed are complying the quality objectives, policies and procedures.",
                            "Not able to demonstrate record of achieving results or more than half of tasks completed are not complying the quality objectives, policies and procedures.",
                            "Fails to achieve own goals and hinders results of others. "
                        );

                        $question[8]->name = "Communication and Interpersonal";
                        $question[8]->scoreArray = array(
                            "Highly articulate, using appropriate language and communication styles at all times, listening and feeding back to show understanding.",
                            "Listens and appropriately tailors communication approach to suit situation or person. Engages the enthusiastic cooperation and wholehearted participation of others in work tasks and relationships.",
                            "Regularly reports and updates on progress of responsible task, problems and achievements expected by the supervisors. Communicates clearly and concisely, both verbally and written, ensuring information relayed is accurate, listens to what is being communicated and seeks to understand by solid questioning skills.",
                            "No evidence of ability to give and receive information with accuracy, cannot explain one's idea and thoughts for acceptance by others.",
                            "Fails to communicate clearly, struggles to put points across verbally or written"
                        );
                        ?>                        
                        <?php foreach ($question as $key => $q) {
                            ?>
                            <div class='collectionTitle'>
                                <div>
                                    <?php echo $q->name ?>
                                </div>
                            </div>
                            <div class='collectionContainer'>
                                <div class='collection scoring_scheme'>
                                    <ol>
                                        <li value='5'>
                                            <?php echo $q->scoreArray[0] ?>
                                        </li>
                                        <li value='4'>
                                            <?php echo $q->scoreArray[1] ?>
                                        </li>
                                        <li value='3'>
                                            <?php echo $q->scoreArray[2] ?>
                                        </li>
                                        <li value='2'>
                                            <?php echo $q->scoreArray[3] ?>
                                        </li>
                                        <li value='1'>
                                            <?php echo $q->scoreArray[4] ?>
                                        </li>
                                    </ol>
                                </div>

                                <div class='collection user_input'>
                                    <div class='part_b_self'>
                                        <label class='collectionTitle'>
                                            <div>
                                                Self Assessment
                                            </div>
                                        </label>
                                        <div class='collection score'>
                                            <label>Score: </label>
                                            <div class="collectionContainer radio_container">
                                                <span class='collection gray'> 5 </span><span class='collection'> 4 </span><span class='collection gray'> 3 </span><span class='collection'> 2 </span><span class='collection gray'> 1 </span>
                                            </div>
                                            <div class="collectionContainer radio_container">
                                                <span class='collection gray'> <input type='radio' class='self'  name='multi_b1_self_score_<?php echo $key ?>' value='5' data-parsley-errors-container="#error_b1_self_score_<?php echo $key ?>"> </span>
                                                <span class='collection'> <input type='radio' class='self'  name='multi_b1_self_score_<?php echo $key ?>' value='4' data-parsley-errors-container="#error_b1_self_score_<?php echo $key ?>"> </span>
                                                <span class='collection gray'> <input type='radio' class='self'  name='multi_b1_self_score_<?php echo $key ?>' value='3' data-parsley-errors-container="#error_b1_self_score_<?php echo $key ?>"> </span>
                                                <span class='collection'> <input type='radio' class='self'  name='multi_b1_self_score_<?php echo $key ?>' value='2' data-parsley-errors-container="#error_b1_self_score_<?php echo $key ?>"> </span>
                                                <span class='collection gray'> <input type='radio' class='self'  name='multi_b1_self_score_<?php echo $key ?>' value='1' required data-parsley-errors-container="#error_b1_self_score_<?php echo $key ?>"> </span>
                                            </div>
                                            <div id="error_b1_self_score_<?php echo $key ?>">

                                            </div>
                                        </div>

                                        <div class='collection example'>
                                            <label>Example: </label> <br>                                
                                            <textarea class='self' name='multi_b1_self_example_<?php echo $key ?>' required data-parsley-errors-container="#error_b1_self_example_<?php echo $key ?>"></textarea>
                                            <div id="error_b1_self_example_<?php echo $key ?>">

                                            </div>
                                        </div>
                                    </div>
                                    <div class='part_b_app'>
                                        <label class='collectionTitle'>
                                            <div>
                                                Assessment by Appraising Officer
                                            </div>
                                        </label>
                                        <div class='collection score'>
                                            <label>Score: </label>
                                            <div class="collectionContainer radio_container">
                                                <span class='collection gray'> 5 </span><span class='collection'> 4 </span><span class='collection gray'> 3 </span><span class='collection'> 2 </span><span class='collection gray'> 1 </span>
                                            </div>
                                            <div class="collectionContainer radio_container">
                                                <span class='collection gray'> <input type='radio' class='appraiser'  name='multi_b1_appraiser_score_<?php echo $key ?>' value='5' data-parsley-errors-container="#error_b1_app_score_<?php echo $key ?>"> </span>
                                                <span class='collection'> <input type='radio' class='appraiser'  name='multi_b1_appraiser_score_<?php echo $key ?>' value='4' data-parsley-errors-container="#error_b1_app_score_<?php echo $key ?>"> </span>
                                                <span class='collection gray'> <input type='radio' class='appraiser'  name='multi_b1_appraiser_score_<?php echo $key ?>' value='3' data-parsley-errors-container="#error_b1_app_score_<?php echo $key ?>"> </span>
                                                <span class='collection'> <input type='radio' class='appraiser'  name='multi_b1_appraiser_score_<?php echo $key ?>' value='2' data-parsley-errors-container="#error_b1_app_score_<?php echo $key ?>"> </span>
                                                <span class='collection gray'> <input type='radio' class='appraiser'  name='multi_b1_appraiser_score_<?php echo $key ?>' value='1' required data-parsley-errors-container="#error_b1_app_score_<?php echo $key ?>"> </span>
                                            </div>
                                            <div id="error_b1_app_score_<?php echo $key ?>">

                                            </div>
                                        </div>
                                        <div class='collection example'>
                                            <label>Example: </label>  <br>                              
                                            <textarea class='appraiser' name='multi_b1_appraiser_example_<?php echo $key ?>' required data-parsley-errors-container="#error_b1_app_example_<?php echo $key ?>"></textarea>
                                            <div id="error_b1_app_example_<?php echo $key ?>">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>                        
                        <div class='collectionContainer'>
                            <div class='collection overall_comments'>
                                <div class='collectionTitle'>
                                    <div>
                                        Overall Comments
                                    </div>
                                </div>
                                <textarea name='part_b1_overall_comment' required></textarea>
                            </div>

                            <div class='collection overall_score'>
                                <div class='collectionTitle'>
                                    <div>
                                        Part B1 subtotal
                                    </div>
                                </div>
                                <div class='subtotal'>
                                    <input class='appraiser subtotal' type='text' name='part_b1_overall_score' disabled> 
                                </div>
                            </div>
                        </div>              
                    </div>
                    <div class='part_title' id='part_b2_title'>
                        Part B2: This section is applicable to Senior Executive employee (Deputy General Manager level and above)
                    </div>
                    <div class='part part_b' id='part_b2'>
                        <?php
                        $question = array();

                        for ($i = 1; $i <= 3; $i++) {
                            $question[$i] = new scoringScheme();
                        }

                        $question[1]->name = "Influence, Negotiation and Persuasion";
                        $question[1]->scoreArray = array(
                            "Effective influencer and persuader at all levels, able to get most ideas accepted in diverse groups at most levels of seniority.",
                            "Inspires confidence, has credibility with colleagues and customers and is able to get complex ideas accepted. It is generally able to persuade from a basis of openness and clarity.",
                            "Make a positive impact, is clear, concise, articulate and assertive when providing information and considered logical and reasoned in presenting own case. Able to compromise with customers (or other stakeholder) by convincing them of one's ideas and thoughts from various point of view. ",
                            "Has no involvement in making oral or written presentations or in getting ideas or views across to others. Not able to find acceptable solution for all the parties from mid/long term prospective instead of insisting on one's idea.",
                            "Colleagues and/or customers pay little attention to debate, proffered solutions or written work. Contributions within team or at meetings are generally not listened to."
                        );

                        $question[2]->name = "Coaching and Developing";
                        $question[2]->scoreArray = array(
                            "Takes time to coach and develop people for improved performance; Pro-active in idenitifying and developing high calibrae knowledge, and planning for enhancement of managerial qualities in self and others.",
                            "Provides regular feedback on performance, suggests improvements, listens and empathises with others, and gets people to commit to responsibilties and try new techniques; Pro-active in sharing knowledge, leading, training, supporting and motivating people to achieve results and improve their works.",
                            "Translates performance targets into clear objectives. Generally coaches and supports others on low level daily issues.",
                            "Is not involved in coaching and developing others.",
                            "Hinders the development of others and generally provides no or negative feedback. Unwilling to devote time to development of others."
                        );

                        $question[3]->name = "Leadership and Strategic Thinking";
                        $question[3]->scoreArray = array(
                            "Become a role model in upholding the Company philosophy. Has a record of leading teams achieving results in difficult situations and creates a climate where employees are highly motivated to achieve goals.",
                            "Become a role model in upholding the Company philosophy. Has a record of clear motivational leadership, recognition of other's achievements and development of visions, targets and techniques which have kept teams and/or individuals focused on the goals. Has introduced and managed change invitiatives in own team effectively.",
                            "Able to set a good example in terms of diligency, integrity and ethically. Has record of achieving results through others when asked, or opportunities arise. Has explained to subordinates the Company values, goal and team quality objectives for their understanding and support.",
                            "Failed to set any good example in terms of diligency, integrity and ethically. Has not had the opportunity to demonstrate leadership qualities or shared the quality objectives with subordinates.",
                            "Set many bad examples in terms of diligency, integrity and ethically. Unable to lead teams, does not provide direct and lowers morale."
                        );
                        ?>                        
                        <?php foreach ($question as $key => $q) {
                            ?>
                            <div class='collectionTitle'>
                                <div>
                                    <?php echo $q->name ?>
                                </div>
                            </div>
                            <div class='collectionContainer'>
                                <div class='collection scoring_scheme'>
                                    <ol>
                                        <li value='5'>
                                            <?php echo $q->scoreArray[0] ?>
                                        </li>
                                        <li value='4'>
                                            <?php echo $q->scoreArray[1] ?>
                                        </li>
                                        <li value='3'>
                                            <?php echo $q->scoreArray[2] ?>
                                        </li>
                                        <li value='2'>
                                            <?php echo $q->scoreArray[3] ?>
                                        </li>
                                        <li value='1'>
                                            <?php echo $q->scoreArray[4] ?>
                                        </li>
                                    </ol>
                                </div>
                                <div class='collection user_input'>
                                    <div class='part_b_self'>
                                        <label class='collectionTitle'>
                                            <div>
                                                Self Assessment
                                            </div>
                                        </label>
                                        <div class='collection score'>
                                            <label>Score: </label>
                                            <div class="collectionContainer radio_container">
                                                <span class='collection gray'> 5 </span><span class='collection'> 4 </span><span class='collection gray'> 3 </span><span class='collection'> 2 </span><span class='collection gray'> 1 </span>
                                            </div>
                                            <div class="collectionContainer radio_container">
                                                <span class='collection gray'> <input type='radio' class='self'  name='multi_b2_self_score_<?php echo $key ?>' value='5' data-parsley-errors-container="#error_b2_self_score_<?php echo $key ?>"> </span>
                                                <span class='collection'> <input type='radio' class='self'  name='multi_b2_self_score_<?php echo $key ?>' value='4' data-parsley-errors-container="#error_b2_self_score_<?php echo $key ?>"> </span>
                                                <span class='collection gray'> <input type='radio' class='self'  name='multi_b2_self_score_<?php echo $key ?>' value='3' data-parsley-errors-container="#error_b2_self_score_<?php echo $key ?>"> </span>
                                                <span class='collection'> <input type='radio' class='self'  name='multi_b2_self_score_<?php echo $key ?>' value='2' data-parsley-errors-container="#error_b2_self_score_<?php echo $key ?>"> </span>
                                                <span class='collection gray'> <input type='radio' class='self'  name='multi_b2_self_score_<?php echo $key ?>' value='1' required data-parsley-errors-container="#error_b2_self_score_<?php echo $key ?>"> </span>
                                            </div>
                                            <div id="error_b2_self_score_<?php echo $key ?>">

                                            </div>
                                        </div>
                                        <div class='collection'>
                                            <label>Example: </label> <br>                                
                                            <textarea class='self' name='multi_b2_self_example_<?php echo $key ?>' required data-parsley-errors-container="#error_b2_self_example_<?php echo $key ?>"></textarea>
                                        </div>
                                        <div id="error_b2_self_example_<?php echo $key ?>">

                                        </div>
                                    </div>
                                    <div class='part_b_app'>
                                        <label class='collectionTitle'>
                                            <div>
                                                Assessment by Appraising Officer
                                            </div>
                                        </label>
                                        <div class='collection'>
                                            <label>Score: </label>
                                            <div class="collectionContainer radio_container">
                                                <span class='collection gray'> 5 </span><span class='collection'> 4 </span><span class='collection gray'> 3 </span><span class='collection'> 2 </span><span class='collection gray'> 1 </span>
                                            </div>
                                            <div class="collectionContainer radio_container">
                                                <span class='collection gray'> <input type='radio' class='appraiser'  name='multi_b2_appraiser_score_<?php echo $key ?>' value='5' data-parsley-errors-container="#error_b2_app_score_<?php echo $key ?>"> </span>
                                                <span class='collection'> <input type='radio' class='appraiser'  name='multi_b2_appraiser_score_<?php echo $key ?>' value='4' data-parsley-errors-container="#error_b2_app_score_<?php echo $key ?>"> </span>
                                                <span class='collection gray'> <input type='radio' class='appraiser'  name='multi_b2_appraiser_score_<?php echo $key ?>' value='3' data-parsley-errors-container="#error_b2_app_score_<?php echo $key ?>"> </span>
                                                <span class='collection'> <input type='radio' class='appraiser'  name='multi_b2_appraiser_score_<?php echo $key ?>' value='2' data-parsley-errors-container="#error_b2_app_score_<?php echo $key ?>"> </span>
                                                <span class='collection gray'> <input type='radio' class='appraiser'  name='multi_b2_appraiser_score_<?php echo $key ?>' value='1' required data-parsley-errors-container="#error_b2_app_score_<?php echo $key ?>"> </span>
                                            </div>
                                            <div id="error_b2_app_score_<?php echo $key ?>">

                                            </div>
                                        </div>
                                        <div class='collection'>
                                            <label>Example: </label>  <br>                              
                                            <textarea class='appraiser' name='multi_b2_appraiser_example_<?php echo $key ?>' required data-parsley-errors-container="#error_b2_app_example_<?php echo $key ?>"></textarea>
                                            <div id="error_b2_app_example_<?php echo $key ?>">

                                            </div>                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>                        
                        <div class='collectionContainer'>
                            <div class='collection overall_comments'>
                                <div class='collectionTitle'>
                                    <div>
                                        Overall Comments
                                    </div>
                                </div>
                                <textarea name='part_b2_overall_comment' required></textarea>
                            </div>                            
                            <div class='collection overall_score'>
                                <div class='collectionTitle'>
                                    Part B2 subtotal
                                </div>
                                <div class='subtotal'>
                                    <input type='text' class='appraiser subtotal' name='part_b2_overall_score' disabled> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='part'>
                        <div class='countersigner'>
                            <div class='collectionTitle'>
                                <div>
                                    Scoring from Countersigning Officer:
                                </div>
                            </div>
                            <div class='collectionContainer '>
                                <div class='collection'>                                    
                                    <p><label> Name : </label> <input type='text' class='system_value' name='countersigner_1_name'></p>
                                    <div class='collectionContainer '>
                                        <div class='collection'>  
                                            <label> Score : </label> <input type='text' class='counter1' name='countersigner_1_part_b_score' data-parsley-type="number" data-parsley-range="[0,5]"></p>
                                        </div>
                                        <!--<div class='collection'>  
                                            <label> Weight : </label> <input type='text' class='system_value' name='countersigner_1_weight'>
                                        </div>-->
                                    </div> 
                                </div>
                                <div class='collection'>
                                    <p><label> Name : </label> <input type='text' class='system_value' name='countersigner_2_name'></p>
                                    <div class='collectionContainer'>
                                        <div class='collection'>                                    
                                            <label> Score : </label> <input type='text' class='counter2' name='countersigner_2_part_b_score' data-parsley-type="number" data-parsley-range="[0,5]"></p>
                                        </div>
                                        <!--<div class='collection'>
                                            <label> Weight : </label> <input type='text' class='system_value' name='countersigner_2_weight'>
                                        </div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='collectionContainer'>
                            <div class='collection total_score'>
                                <div class='collectionTitle'>
                                    <div>
                                        Part B Total
                                    </div>
                                </div>
                                <div class='subtotal'>
                                    <input class='system_value subtotal' type='text' name='part_b_total' disabled> 
                                </div>
                            </div>
                        </div> 
                        <div class='part_title' id='overall_title'>
                            Overall Performance Rating
                        </div>
                        <div class='collection total_score'>
                            <div class='collectionTitle'>
                                <div>
                                    Part A + B Total
                                </div>
                            </div>
                            <div class='subtotal'>
                                <input class='system_value subtotal' type='text' name='part_a_b_total' disabled> 
                            </div>
                        </div>
                    </div>
                    <div class='part' id='part_c'>
                        <div class='part_title' id='part_c_title'>
                            Part C: Learning and Development Plan (To be completed by Appraising Officer and Employee collaboratively) 
                        </div> 
                        <p>For Appraising Officer: please evaluate the strengths and weaknesses of the employee and develop an action plan to improve the employee's work performance in collaboration with him/her. </p>
                        <div id='professional_competency'>
                            <div class='section_error'>
                            </div>
                            <div id="custom_dropdown">
                                <label>Please specify : </label><input type="text"> </input>
                                <div class='section_error'></div>
                            </div>
                            <div class='collectionTitle'>
                                <div>
                                    Competency Gap Identification
                                </div>
                            </div>
                            <div class='collectionContainer'>
                                <div class='collection list_label'>
                                    Professional Competency
                                </div>
                                <div class='collection list_input'>
                                    <ol>
                                        <li><input class='appraiser' type='text' name='prof_competency_1'></li>
                                        <li><input class='appraiser' type='text' name='prof_competency_2'></li>
                                        <li><input class='appraiser' type='text' name='prof_competency_3'></li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <?php
                        $coreComp = array("Please select",
                            "Teamwork and Support",
                            "Ownership",
                            "Customer Focus",
                            "Initiative",
                            "Attention to Detail",
                            "Problem Solving and Decision Making",
                            "Achieving Results and Compliance",
                            "Communication and Interpersonal",
                            "Influence, Negotiation and Persuasion",
                            "Coaching and Developing",
                            "Leadership and Strategic Thinking",
                            "Nil");
                        ?>
                        <div id='core_competency'>
                            <div class='section_error'>                                
                            </div>
                            <div class='collectionContainer'>
                                <div class='collection  list_label'>
                                    Core Competency
                                </div>
                                <div class='collection list_input'>
                                    <ol>
                                        <!--<li><input class='both' type='text' name='core_competency_1'></li>
                                        <li><input class='both' type='text' name='core_competency_2'></li>
                                        <li><input class='both' type='text' name='core_competency_3'></li>-->
                                        <li>
                                            <select class='appraiser' name='core_competency_1'>
                                                <?php
                                                foreach ($coreComp as $key => $value) {
                                                    if ($key == 0) {
                                                        echo "<option value='' selected disabled>";
                                                    } else {
                                                        echo "<option value='$value'>";
                                                    }
                                                    echo $value;
                                                    echo "</option>";
                                                }
                                                ?>
                                            </select>
                                        </li>
                                        <li>
                                            <select class='appraiser' name='core_competency_2'>
                                                <?php
                                                foreach ($coreComp as $key => $value) {
                                                    if ($key == 0) {
                                                        echo "<option value='' selected disabled>";
                                                    } else {
                                                        echo "<option value='$value'>";
                                                    }
                                                    echo $value;
                                                    echo "</option>";
                                                }
                                                ?>
                                            </select>
                                        </li>
                                        <li>
                                            <select class='appraiser' name='core_competency_3'>
                                                <?php
                                                foreach ($coreComp as $key => $value) {
                                                    if ($key == 0) {
                                                        echo "<option value='' selected disabled>";
                                                    } else {
                                                        echo "<option value='$value'>";
                                                    }
                                                    echo $value;
                                                    echo "</option>";
                                                }
                                                ?>
                                            </select>
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <div id="training_need">
                            <div class="section_error">                                
                            </div>
                            <div class='collectionTitle'>
                                <div>
                                    On the Job Training / Functional / Generic Training Needs
                                </div>
                            </div>
                            <div class='training_needs'>
                                <div class='collectionContainer'>
                                    <div class='collection list_label'>
                                        On the Job Training (Coaching / Mentoring)
                                    </div>
                                    <div class='collection list_label year'>
                                        <div>0-1 year:</div>
                                        <div>1-2 year:</div>
                                        <div>2-3 year:</div>
                                    </div>
                                    <div class='collection list_input'>
                                        <div><input class='appraiser' type='text' name='on_job_0_to_1_year'></div>
                                        <div><input class='appraiser' type='text' name='on_job_1_to_2_year'></div>
                                        <div><input class='appraiser' type='text' name='on_job_2_to_3_year'></div>                           
                                    </div>
                                </div>
                                <?php
                                $functionalList = array("Please select",
                                    "Business Contract Law Knowledge for Non Legal Practitioner",
                                    "Business Law & Practices",
                                    "Business Operations Knowledge (Acquisition of companies or forming strategic alliance)",
                                    "Business Operations Knowledge (Geology / Mining Industry / Plant Knowledge)",
                                    "Business Operations Knowledge (Logistics and Related Legal Requirements)",
                                    "Business Operations Knowledge (Production / Acquisition / Developing Mines and Smelting Plants)",
                                    "Business Operations Knowledge (Sales, Marketing and Operations)",
                                    "Data Protection knowledge in Human Resources Management",
                                    "Data Protection knowledge in Internal IT Management",
                                    "Finance Knowledge for Non-Finance People (General)",
                                    "Legal Knowledge on Data Protection",
                                    "Marketing Knowledge (Manganese Market & Product Knowledge)",
                                    "Project Management Skills: The Fundamentals and Process",
                                    "Stakeholder Relationship Skills for Project Managers",
                                    "Others, please specify",
                                    "Nil");
                                ?>
                                <div class='collectionContainer'>
                                    <div class='collection  list_label'>
                                        Functional Training Needs (Job Related)
                                    </div>
                                    <div class='collection list_label year'>
                                        <div>0-1 year:</div>
                                        <div>1-2 year:</div>
                                        <div>2-3 year:</div>
                                    </div>
                                    <div class='collection list_input'>
                                        <!--<div><input class='both' type='text' name='function_training_0_to_1_year'></div>
                                        <div><input class='both' type='text' name='function_training_1_to_2_year'></div>
                                        <div><input class='both' type='text' name='function_training_2_to_3_year'></div>  -->
                                        <div>
                                            <select class='appraiser' name='function_training_0_to_1_year'>
                                                <?php
                                                foreach ($functionalList as $key => $value) {
                                                    if ($key == 0) {
                                                        echo "<option value='' selected disabled>";
                                                    } else {
                                                        echo "<option value='$value'>";
                                                    }
                                                    echo $value;
                                                    echo "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div>
                                            <select class='appraiser' name='function_training_1_to_2_year'>
                                                <?php
                                                foreach ($functionalList as $key => $value) {
                                                    if ($key == 0) {
                                                        echo "<option value='' selected disabled>";
                                                    } else {
                                                        echo "<option value='$value'>";
                                                    }
                                                    echo $value;
                                                    echo "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div>
                                            <select class='appraiser' name='function_training_2_to_3_year'>
                                                <?php
                                                foreach ($functionalList as $key => $value) {
                                                    if ($key == 0) {
                                                        echo "<option value='' selected disabled>";
                                                    } else {
                                                        echo "<option value='$value'>";
                                                    }
                                                    echo $value;
                                                    echo "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $genericList = array("Please select",
                                    "Team Building and Cross Culture Awareness",
                                    "Change Management Skills",
                                    "Risk and Crisis Management Skills",
                                    "Customer Services Skills",
                                    "Self Leadership Skills",
                                    "Microsoft Excel 2010/2007 VBA Macro Programming Skills",
                                    "MS Access Fundamentals Skills",
                                    "MS Access Skills for Expert User",
                                    "MS Excel Fundamentals Skills",
                                    "MS Excel Skills for Expert User",
                                    "MS PowerPoint Skills for Expert User",
                                    "MS Project Fundamentals Skills",
                                    "MS Project Skills for Proficient User",
                                    "MS Word Fundamentals Skills",
                                    "MS Word Skills Expert User",
                                    "Creative Problem Solving and Decision Making Skills",
                                    "Time Management Skills",
                                    "Elementary Putonghua Skills",
                                    "Phone Manner Skills and Business Etiquette",
                                    "Presentation Skills in English",
                                    "Spoken Business English and Social English Skills",
                                    "Writing Skills for Business",
                                    "Writing Skills on Clear Actionable Emails",
                                    "Negotiation and Persuasion Skills for Business Executives",
                                    "Coaching Skills",
                                    "Leadership Skills For Supervisor",
                                    "Others, please specify",
                                    "Nil");
                                ?>
                                <div class='collectionContainer'>
                                    <div class='collection  list_label'>
                                        Generic Training Needs (Competency Related)
                                    </div>
                                    <div class='collection list_label year'>
                                        <div>0-1 year:</div>
                                        <div>1-2 year:</div>
                                        <div>2-3 year:</div>
                                    </div>
                                    <div class='collection list_input'>
                                        <!--<div><input class='both' type='text' name='generic_training_0_to_1_year'></div>
                                        <div><input class='both' type='text' name='generic_training_1_to_2_year'></div>
                                        <div><input class='both' type='text' name='generic_training_2_to_3_year'></div>-->
                                        <div>
                                            <select class='appraiser' name='generic_training_0_to_1_year'>
                                                <?php
                                                foreach ($genericList as $key => $value) {
                                                    if ($key == 0) {
                                                        echo "<option value='' selected disabled>";
                                                    } else {
                                                        echo "<option value='$value'>";
                                                    }
                                                    echo $value;
                                                    echo "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div>
                                            <select class='appraiser' name='generic_training_1_to_2_year'>
                                                <?php
                                                foreach ($genericList as $key => $value) {
                                                    if ($key == 0) {
                                                        echo "<option value='' selected disabled>";
                                                    } else {
                                                        echo "<option value='$value'>";
                                                    }
                                                    echo $value;
                                                    echo "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div>
                                            <select class='appraiser' name='generic_training_2_to_3_year'>
                                                <?php
                                                foreach ($genericList as $key => $value) {
                                                    if ($key == 0) {
                                                        echo "<option value='' selected disabled>";
                                                    } else {
                                                        echo "<option value='$value'>";
                                                    }
                                                    echo $value;
                                                    echo "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='part' id='part_d'>
                        <div class='part_title' id='part_d_title'>
                            Part D: Goals Setting For The Coming Year (Not applicable for Mid-Yearly Appraisal)
                        </div>
                        <p>This part shall be completed by the Appraising Officer and the Employee collaboratively.</p>
                        <div class='section_error'>

                        </div>
                        <?php
                        $data = new formData($param['u'], $param['uid']);
                        $rowCount = $data->getPartDCount();
                        if ($rowCount == 0) {
                            $rowCount = 1;
                        }
                        for ($i = 1; $i <= $rowCount; $i ++) {
                            ?>
                            <div class='collectionContainer'>
                                <div class='collection delete_button'>
                                    <div class='delete_button_d' qid='<?php echo $i; ?>'></div>
                                </div>
                                <div class='collection'>

                                    <div class='collectionTitle'>
                                        <div>
                                            Key Responsibilities
                                        </div>
                                    </div>
                                    <div class='collection'>
                                        <textarea class='appraiser' name='multi_d_key_respon_<?php echo $i; ?>' required></textarea>
                                    </div>
                                </div>
                                <div class='collection'>
                                    <div class='collectionTitle'>
                                        <div>
                                            Goals
                                        </div>
                                    </div>
                                    <div class='collection'>
                                        <textarea class='appraiser' name='multi_d_goal_name_<?php echo $i; ?>' required></textarea>
                                    </div>
                                </div>
                                <div class='collection'>
                                    <div class='collectionTitle'>
                                        <div>
                                            Measurements
                                        </div>
                                    </div>
                                    <div class='collection'>
                                        <textarea class='appraiser' name='multi_d_measurement_name_<?php echo $i; ?>' required></textarea>
                                    </div>
                                </div>
                                <div class='collection'>
                                    <div class='collectionTitle'>
                                        <div>
                                            Weight
                                        </div>
                                    </div>
                                    <div class='collection'>
                                        <input type='text' class='appraiser' name='multi_d_goal_weight_<?php echo $i; ?>' data-parsley-type="integer" data-parsley-range="[1,100]" data-parsley-error-message="Enter a integer between 1 and 100">
                                    </div>
                                    <div class='collectionTitle'>
                                        <div>
                                            Completion Date
                                        </div>
                                    </div>
                                    <div class='collection'>
                                        <input type='month' class='appraiser' name='multi_d_complete_date_<?php echo $i; ?>' required>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class='collectionContainer'> 
                            <div class='collection' id='plus_button_d' next="multi_d_key_respon_<?php echo $rowCount + 1 ?>">
                                +
                            </div>
                        </div>
                    </div>
                    <div class='part' id='part_e'>
                        <div class='part_title' id='part_e_title'>
                            Part E: Overall comments from Employee / Appraising Officer
                        </div>
                        <div class='collectionTitle'>
                            <div>
                                Please enter your comments
                            </div>
                        </div>
                        <div class='collectionContainer'>
                            <textarea class='both' name='survey_overall_comment' required data-parsley-errors-container='#error_e'></textarea>
                        </div>
                        <div id='error_e'> </div>
                    </div>
                </div>
                <div id='footerBar'>
                    <div>
                        <input type='checkbox' id='confirm_checkbox'> I have read and agreed with the completed parts
                    </div>
                    <div>
                        <?php
                        if ($param['r'] == 'app') {
                            $str = 'Confirm';
                        } else {
                            $str = 'Submit';
                        }
                        ?>
                        <input type='submit' id='submit_button' value='<?php echo $str ?>' disabled>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>