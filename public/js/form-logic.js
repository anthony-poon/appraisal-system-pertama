$(window).load(function() {
    var notificationTimeout;
    
    function FormChecker() {
        var lastError = []
        var elementArray = [];
        this.addElement = function(ele, handler, errMsg){
            elementArray.push({
                element: ele,
                handler: handler,
                errMsg: errMsg
            });
        }
        this.isValid = function(ele) {
            lastError = [];
            $.each(elementArray, function(){
                if ($(ele).is(this.element)) {
                    var result = this.handler(ele);
                    if (!result) {
                        lastError.push(this.errMsg);
                    }
                }
            })
            if (lastError.length === 0) {
                return true;
            } else {
                return false;
            }
        }
        this.getLastError = function (){
            return lastError;
        }
        return this;
    }    
    function initChecker(){
        
        // addElement(element, handler, error message)
        // handler should return true is checking is passed, otherwise false

        // Checking rules for part A
        checker.addElement($("#part_a textarea, .weight, .a_score"), function(ele){
            var str = $.trim($(ele).val());
            if (str) {
                return true;
            } else {
                return false;
            }
        }, "Part A cannot be empty.");
        
        // Check valid percentage value
        checker.addElement($("#part_a .weight"), function(ele){
            var str = String($.trim($(ele).val()));
            var digitReg = /^(\d{1,2})%{0,1}$/;
            var floatReg = /^(0\.\d{1,2})$/;
            var digitMatch = digitReg.exec(str);
            if (digitMatch !== null) {
                var int = parseInt(digitMatch[1]);
                if (int <= 0 || int > 100) {
                    return false;
                } else {
                    $(ele).val(int);
                }
                return true;
            }
            var floatMatch = floatReg.exec(str);
            if (floatMatch !== null) {
                var int = parseFloat(floatMatch[1])*100;
                if (int <= 0 || int > 100) {
                    return false;
                } else {
                    $(ele).val(int);
                }
                return true;
            }
            return false;
        }, "Please enter a numeric between 1 to 100");

        checker.addElement($("#part_a .a_score"), function(ele){
            var reg = /^[0-5]$/;
            var result = reg.exec($(ele).val());
            if (result !== null) {
                return true;
            } else {
                return false;
            }
        }, "The score must be a integer between 0 to 5")
        
        // Checking rules for part B1 textarea
        checker.addElement($("#part_b1 textarea"), function(ele){
            var str = $.trim($(ele).val());
            if (str) {
                return true;
            } else {
                return false;
            }
        }, "Please provide example");
        
        checker.addElement($("#part_b1 input[type=radio]"), function(ele){
            var parent = $(ele).parents(".radio_container");
            if (parent.find(":checked").length !== 0) {
                return true;
            } else {
                return false;
            }
        }, "Please select a value");
        
        // Checking rules for part B2
        if (user.isSenior !== 0) {
            checker.addElement($("#part_b2 input[type=radio]"), function(ele){
            var parent = $(ele).parents(".radio_container");
            if (parent.find(":checked").length !== 0) {
                return true;
            } else {
                return false;
            }
        }, "Please select a value");
        }
        // Checking rules for part C
        checker.addElement($(".training_needs select"), function(ele){
            if ($("#custom_dropdown").dialog("isOpen")) {
                return true;
            } else {
                var reg = /^(other)|(please select)/i;
                if ($.trim($(ele).val()).match(reg)) {
                    return false;
                } else {
                    return true;
                }
            }
        }, "Please select a valid options");
        
        // Checking rules for part D
        checker.addElement($("#part_d textarea, .weight"), function(ele){
            var str = $.trim($(ele).val());
            if (str) {
                return true;
            } else {
                return false;
            }
        }, "Missing value in part D");
        
        // Checking rules for part E
        checker.addElement($("#part_e textarea"), function(ele){
            var str = $.trim($(ele).val());
            if (str) {
                return true;
            } else {
                return false;
            }
        }, "Missing value in part E");
        
        checker.addElement($(".counter1, .counter2"), function(ele){
            if ($.trim($(ele).val()) === "") {
                return true;
            }
            var score = parseFloat($.trim($(ele).val())).toFixed(2);
            if (!isNaN(score) && score >= 0 && score <= 5) {
                $(ele).val(score);
                return true;
            } else {
                return false;
            }
        }, "The score must be a valid numeric between 0 to 5");
    }
    
    function notification(msg){
        clearTimeout(notificationTimeout);
        $("#notification #message ul li").remove();
        if ($.isArray(msg)) {
            var height = 60 + 25 * msg.length;
            $("#notification").css("height", height+"px");
            $.each(msg, function(){
                $("#notification #message ul").append("<li>" + this + "</li>");
            });
        } else {
            $("#notification").css("height", "150px");
            $("#notification #message ul").append("<li>" + msg + "</li>");
        }
        notificationTimeout = setTimeout(function(){
            $("#notification").css("height", "0px");
            
        }, 5000);
    }
    
    var user = {
        uid: $("#survey").attr("data-uid"),
        role: $("#survey").attr("data-role"),
        userId: $("#survey").attr("data-id"),
        isSenior: $("#survey").attr("data-is-senior")
    }
       
    var checker = FormChecker();
    initChecker();
    
    var form = {};
    
    form.isDebugMode = ($("form").attr("data-debug") !== "0")
    form.shouldShowInstuction = ($("#dialog").length !== 0)
    
    if (form.shouldShowInstuction) {
        $("#dialog").dialog({
            width: 700,
            modal: true,
            buttons: {
                OK: function() {
                    $(this).dialog("close");
                }
            }
        });
    }
    $.ajax({
        url: 'surveyAjax?action=getFormData&u=' + user.userId + '&uid=' + user.uid +'&r=' + user.role,
        type: 'GET',
        dataType: 'json',
        success: function(ajaxData) {

            form.isFinalBySelf = ajaxData['is_final_by_self'];
            form.isFinalByApp = ajaxData['is_final_by_appraiser'];
            form.counter1Weight = parseInt(ajaxData['countersigner_1_weight']);
            form.counter2Weight = parseInt(ajaxData['countersigner_2_weight']);
            if (ajaxData['is_locked'] === '1') {
                $('form :input').prop('disabled', true);
                $('#plus_button_a').hide();
                $('.delete_button_a').hide();
                $('#plus_button_d').hide();
                $('.delete_button_d').hide();
                $('#system_message').text('Your form was locked. Changes are not allowed at the moment.');
            } else if (user.role === 'app') {
                if (form.isFinalBySelf === '1' && form.isFinalByApp === '1') {
                    $('form :input').prop('disabled', true);
                    $('[class^=delete_button], [id^=plus_button]').hide();
                    $('#system_message').append('<div> The form had been submitted. Changes are not allowed. Please contact IT if amendment is needed. </div>');
                }
            } else if (user.role === 'self') {
                if (form.isFinalBySelf === '1' && form.isFinalByApp === '1') {
                    $('form :input').prop('disabled', true);
                    $('[class^=delete_button], [id^=plus_button]').hide();
                    $('#system_message').append('<div>The form had been submitted. Changes are not allowed. Please contact IT if amendment is needed. </div>');
                }
            }
            $('#excel_button').prop('disabled', false);
            $('#other_survey_dropdown').prop('disabled', false);
            $.each(ajaxData, function(fieldName, dbValue) {
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
                        $("[name='" + fieldName + "'][value='" + ajaxData[fieldName] + "']").prop('checked', true);
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
        },
        error: function() {
            alert('Failed to load data. Please press F5 to refresh the page');
        }
    });

    $("#excel_button").click(function(){
        window.location = "report?action=outputFile&u=" + user.userId + "&uid=" + user.uid;
    })

    // !!!!!!!!!!! Add Dialog
    
    $('.system_value').prop('disabled', true);

    $('#plus_button_a').click(function() {
        var fieldName = $('#plus_button_a').attr('next');
        $.ajax({
            url: 'surveyAjax?action=addPartAItem&u=' + user.userId + '&r=' + user.role + '&uid=' + user.uid,
            dataType: 'json',
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

    $('#plus_button_d').click(function() {
        var fieldName = $('#plus_button_d').attr('next');
        $.ajax({
            url: 'surveyAjax?action=postFormData&u=' + user.userId + '&r=' + user.role + '&uid=' + user.uid,
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
            url: 'surveyAjax?action=clearA&u=' + user.userId + '&r=' + user.role + '&uid=' + user.uid + '&qid=' + qid,
            type: 'DELETE',
            success: function() {
                location.reload();
            }
        });
    });

    $('.delete_button_d').click(function() {
        var qid = $(this).attr('qid');
        $.ajax({
            url: 'surveyAjax?action=clearD&u=' + user.userId + '&r=' + user.role + '&uid=' + user.uid + '&qid=' + qid,
            type: 'DELETE',
            success: function() {
                location.reload();
            }
        });
    });
    
    if (!form.isDebugMode) {
        switch (user.role) {
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
    }
    // Overriding enter key, triggerin change event to trigger checking and ajax
    $('input').keydown(function(event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            $(this).trigger('change');
            return false;
        }
    });
    
    function AverageScoreCalculator(targetElement){
        this.condition = function(){
            return true;
        };
        this.getWeight = null;
        this.getScore = null;
        this.getTotal = function() {
            var scoreArray = this.getScore();
            var weightArray = this.getWeight();
            if (scoreArray === null) {
                return null;
            } else {
                if (weightArray === null) {
                    return null;
                } else {
                    if ($.isArray(weightArray)) {
                        var weightTotal = 0;
                        var sum = 0;
                        for (var i = 0; i < scoreArray.length; i++) {
                            sum += scoreArray[i] * weightArray[i];
                            weightTotal += weightArray[i];
                        }
                        return (sum / weightTotal).toFixed(2);
                    } else {
                        // If weightArray is a number or "number"
                        var sum = 0;
                        for (var i = 0; i < scoreArray.length; i++) {
                            sum += scoreArray[i];
                        }
                        return (sum / weightArray).toFixed(2);
                    }
                }
            }
        }
        this.clear = function(){
            $(targetElement).val("")
            $(targetElement).removeClass("validated");
            $(targetElement).removeClass("invalidated");
            $(targetElement).trigger("change");
        }
        this.update = function(){
            var total = this.getTotal();
            if (!isNaN(total)&& this.condition()) {
                $(targetElement).val(total);
                targetElement.trigger("change");
            } else {
                $(targetElement).val("");
            }
        }
        return this;
    }
    // getScore = return all score in a array
    // getWeight must return all the weight of each score and cound of weight must = count of score
    // condition must return boolean. Only run when condition return true.
    // The returned array of getScore and getWeight are order sensative. First item on get Score match with first item of get weight
    // When using jquery selector, and order of DOM element is extremly important
    var partATotal = new AverageScoreCalculator($("[name='part_a_overall_score']"));
    partATotal.getScore = function(){
        var returnArray = [];
        $.each($("#part_a .a_score"), function(){
            returnArray.push(parseInt($(this).val()));
        })
        return returnArray;
    }
    partATotal.getWeight = function(){
        var returnArray = [];
        $.each($("#part_a .weight"), function(){
            returnArray.push(parseInt($(this).val()));
        })
        return returnArray;
    }
    partATotal.condition = function(){
        var isFilled = true;
        var weightTotal = 0;
        $.each($("#part_a .weight"), function(){
            weightTotal += parseInt($.trim($(this).val()));
        });
        
        if (weightTotal !== 100) {
            isFilled = false;
            this.clear();
            partACounterSigned.clear();
            notification("Sum of weight must be equal to 100");
        }
        
        $.each($("#part_a .weight, .a_score"), function(){
            var str = $.trim($(this).val());
            if (!checker.isValid($(this)) || !str) {
                isFilled = false;
            }
        })
        return isFilled;
    }
    // Check input then sumbit via ajax
    var partB1Total = new AverageScoreCalculator($("[name='part_b1_overall_score']"));
    partB1Total.getScore = function(){
        var returnArray = [];
        $.each($(".b1-score.appraiser:checked"), function(){
            var score = parseInt($(this).val());
            returnArray.push(score);
        });
        return returnArray;
    };
    partB1Total.getWeight = function(){
        return this.getScore().length;
    };
    partB1Total.condition = function(){
        return this.getScore().length === 8;
    };
    if (user.isSenior !== "0") {
        var partB2Total = new AverageScoreCalculator($("[name='part_b2_overall_score']"));
        partB2Total.getScore = function(){
            var returnArray = [];
            $.each($(".b2-score.appraiser:checked"), function(){
                var score = parseInt($(this).val());
                returnArray.push(score);
            });
            return returnArray;
        };
        partB2Total.getWeight = function(){
            return $(".b2-score.appraiser:checked").length;
        };
        partB2Total.condition = function(){
            return this.getScore().length === 3;
        };
    }
    var partACounterSigned = new AverageScoreCalculator($("#part-a-countered-score"));
    partACounterSigned.getScore = function(){
        var returnArray = [];
        $.each($("[name='part_a_overall_score'], [name='countersigner_1_part_a_score'], [name='countersigner_2_part_a_score']"), function(){
            var score = parseFloat($(this).val());
            if (score) {
                returnArray.push(score);
            }            
        });
        return returnArray;
    };
    partACounterSigned.getWeight = function(){
        if (isNaN(form.counter1Weight) || isNaN(form.counter2Weight)) {
            return this.getScore().length;
        } else {
            return [form.counter1Weight / (2 * (form.counter1Weight + form.counter2Weight)), form.counter1Weight / (2 * (form.counter1Weight + form.counter2Weight)), form.counter2Weight / (form.counter1Weight + form.counter2Weight)]
        }
    };
    partACounterSigned.condition = function(){
        if ($("[name='part_a_overall_score']")) {
            return true;
        } else{
            return false;
        }
    };
    
    var partBCounterSigned = new AverageScoreCalculator($("#part-b-countered-score"));
    if (user.isSenior === "0") {        
        partBCounterSigned.getScore = function(){
            var b1Score = parseFloat($("[name='part_b1_overall_score']").val());
            var returnArray = [b1Score];
            var counter1Score = parseFloat($("[name='countersigner_1_part_b_score']").val());
            var counter2Score = parseFloat($("[name='countersigner_2_part_b_score']").val());             
            if (counter1Score) {
                returnArray.push(counter1Score);
            }
            if (counter2Score) {
                returnArray.push(counter2Score);
            }
            return returnArray;
        };        
        partBCounterSigned.condition = function(){
            if ($("[name='part_b1_overall_score']")) {
                return true;
            } else{
                return false;
            }
        };
    } else {
        partBCounterSigned.getScore = function(){
            var b1Score = parseFloat($("[name='part_b1_overall_score']").val());
            var b2Score = parseFloat($("[name='part_b2_overall_score']").val());
            var returnArray = [b1Score * 0.6 + b2Score *0.4];
            var counter1Score = parseFloat($("[name='countersigner_1_part_b_score']").val());
            var counter2Score = parseFloat($("[name='countersigner_2_part_b_score']").val());             
            if (counter1Score) {
                returnArray.push(counter1Score);
            }
            if (counter2Score) {
                returnArray.push(counter2Score);
            }
            return returnArray;
        };        
        partBCounterSigned.condition = function(){
            if ($("[name='part_b1_overall_score']") && $("[name='part_b2_overall_score']")) {
                return true;
            } else{
                return false;
            }
        };
    }
    partBCounterSigned.getWeight = function(){
        if (isNaN(form.counter1Weight) || isNaN(form.counter2Weight)) {
            return this.getScore().length;
        } else {
            return [form.counter1Weight / (2 * (form.counter1Weight + form.counter2Weight)), form.counter1Weight / (2 * (form.counter1Weight + form.counter2Weight)), form.counter2Weight / (form.counter1Weight + form.counter2Weight)]
        }
    };
    
    var grandTotal = new AverageScoreCalculator($("[name='part_a_b_total']"));
    grandTotal.getScore = function(){
        var partATotal = parseFloat($("#part-a-countered-score").val());
        var partBTotal = parseFloat($("#part-b-countered-score").val());
        return [partATotal, partBTotal];
    };
    grandTotal.getWeight = function(){
        return this.getScore().length;
    };
    grandTotal.condition = function(){
        return (!isNaN(parseFloat($("#part-a-countered-score").val())) && !isNaN(parseFloat($("#part-b-countered-score").val())));
    };
    
    var autosaveTimer = null;
    
    $(":input").on("input", function(){
        var triggeredElement = this;
        clearTimeout(autosaveTimer);
        autosaveTimer = setTimeout(function(){
            $(triggeredElement).trigger("change");
            console.log("auto saved");
        }, 2000);
    });
    
    $(":input").change(function() {
        var inputElement = this;
        logoutTimer.keepAlive();
        if (checker.isValid(inputElement)) {
            var value = $.trim($(inputElement).val());
            if ($(inputElement).is("#part_a .weight, .a_score")) {
                partATotal.update();
            }
            if ($(inputElement).is(".b1-score.appraiser")) {
                partB1Total.update();
            }
            if ($(inputElement).is(".b2-score.appraiser")) {
                partB2Total.update();
            }
            if ($(inputElement).is("[name='part_a_overall_score'], [name='countersigner_1_part_a_score'], [name='countersigner_2_part_a_score']")) {
                partACounterSigned.update();
            }
            if ($(inputElement).is("[name='part_b1_overall_score'], [name='part_b2_overall_score'], [name='countersigner_1_part_b_score'], [name='countersigner_2_part_b_score']")) {
                partBCounterSigned.update();
            }            
            if ($(inputElement).is("#part-a-countered-score, #part-b-countered-score")) {
                grandTotal.update();
            }
            var updateDataAjax = $.ajax({
                url: 'surveyAjax?action=postFormData&u=' + user.userId + '&uid=' + user.uid + '&r=' + user.role,
                type: 'POST',
                data: {
                    "fieldName": $(inputElement).attr('name'),
                    "value": value
                }
            });
            updateDataAjax.success(function(){
                $(inputElement).removeClass("invalidated");
                $(inputElement).addClass("validated");
            })
            updateDataAjax.fail(function(){
                notification(["Unable to update value. Please press F5 to refresh"]);
            })
        } else {
            $(inputElement).removeClass("validated");
            $(inputElement).addClass("invalidated");
            notification(checker.getLastError());
        }        
    });
    
    // Show dialog if other is selected
    function PartCDialogFactory(){
        var triggerEle = null;
        this.open = function(ele) {
            triggerEle = $(ele);
            $(".ui-dialog").css("position", "fixed");
            $(".ui-dialog").css("top", "45%");
            $(".ui-dialog").find(".validated").removeClass("validated");
            $(".ui-dialog").find(".invalidated").removeClass("invalidated");
            $(".ui-dialog").find(".section_error").html("");
            dialog.dialog("open");
        }
        var dialog = $("#custom_dropdown").dialog({
            autoOpen: false,
            modal: true,
            buttons: {
                OK: function() {
                    var str = $('#custom_dropdown input').val().trim();
                    if (str.match(/[;"'\\]/)) {
                        $('#custom_dropdown .section_error').html("Cannot contain the following characters &quot; &#39; ; \\");
                    } else {
                        if (str.length > 0) {
                            // Remove exisitng custom entry
                            triggerEle.children("[custom='true']").remove();
                            // Insert entry
                            $("<option custom='true' value='" + str + "'>" + str + "</option>").insertBefore(triggerEle.children('[value^="Others"]'));
                            triggerEle.children("[value='" + str + "']").attr('selected', true);
                            triggerEle.trigger("change");
                            $(this).dialog("close");
                            $('#custom_dropdown input').val("")
                        } else {
                            $('#custom_dropdown .section_error').html("This cannot be empty.");
                        }
                    }
                }
            }
        });
        return this;
    };
    var cDialog = new PartCDialogFactory();
    $(".training_needs .list_input select").change(function(){
        var str = $.trim($(this).val());
        var reg = /^others/i;
        var match = reg.exec(str);
        if (match) {
            cDialog.open(this)
        }
    });
    
    $("#confirm-checkbox").change(function(){
        if ($(this).is(":checked")) {
            $("#submit-button").removeClass("disabled");
        } else {
            $("#submit-button").addClass("disabled");
        }
    });
    
    // Confirm submit dialog
    $("#confirm-dialog").dialog({
        width: 500,
        autoOpen: false,
        modal: true,
        buttons: {
            OK: function() {
                $("form").trigger("submit");
                $("#confirm-dialog").dialog("close");
            },
            Cancel: function(){
                $("#confirm-dialog").dialog("close");
            }
        }
    })
    
    // Submiting
    $("#submit-button").on("click", function(evt){
        var preventSubmit = false;
        var isFormValid = true;
        $.each($(":input:enabled"), function(){
            if (isFormValid && !checker.isValid(this)) {
                preventSubmit = true;
                var error = checker.getLastError();
                notification(error);
                isFormValid = false;
                $(window).scrollTop($(this).offset().top - 150);
            }
        })
        
        // Check Part A weight total
        if (user.role === "app") {
            if (isFormValid) {
                var weightTotal = 0;
                $.each($("#part_a .weight"), function(){
                    weightTotal += parseInt($(this).val());
                })

                if (weightTotal !== 100) {
                    preventSubmit = true;
                    notification("Sum of weight must be equal to 100.");
                    $(window).scrollTop($("#part_a .weight").offset().top - 200);
                }
            }

            // Check Part D weight total
            if (isFormValid) {
                var weightTotal = 0;
                $.each($("#part_d .weight"), function(){
                    weightTotal += parseInt($(this).val());
                })

                if (weightTotal !== 100) {
                    preventSubmit = true;
                    notification("Sum of weight must be equal to 100.");
                    $(window).scrollTop($("#part_d .weight").offset().top - 100);
                }
            }
        }
        
        // Form is valid. Confirm if sumbit or not
        if (user.role === "app" || user.role === "self") {
            if (!preventSubmit && $("#confirm-checkbox").is(":checked")) {
                $("#confirm-dialog").dialog("open");
            }
        } else {
            $("form").trigger("submit");
        }
    });
});

