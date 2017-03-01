<div class="outline">
    <?php 
        $form = $param["data"];
        /* @var $form FormData */
    ?>
    <div id='form-wrapper'>
        <div class="contentWrapper">
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
                        <input disabled type='text' class='system_value' name='staff_name' value='<?php echo $form["staff_name"]?>'>
                    </div>
                    <div class='collection'>
                        <label class='collectionTitle'>
                            <div>
                                Department/Division:
                            </div>
                        </label>
                        <input disabled type='text' class='system_value' name='staff_department' value='<?php echo $form["staff_department"]?>'>
                    </div>
                    <div class='collection'>
                        <label class='collectionTitle'>
                            <div>
                                Position/Grade:
                            </div>
                        </label>
                        <input disabled type='text' class='system_value' name='staff_position' value='<?php echo $form["staff_position"]?>'>
                    </div>
                </div>
                <div class='collectionContainer'>
                    <div class='collection'>
                        <label class='collectionTitle'>
                            <div>
                                Office:
                            </div>
                        </label>
                        <input disabled type='text' class='system_value'  name='staff_office' value='<?php echo $form["staff_office"]?>'>
                    </div>
                    <div class='collection'>
                        <label class='collectionTitle'>
                            <div>
                                Appraising Officer Name:
                            </div>
                        </label>
                        <input disabled type='text' class='system_value' name='appraiser_name' value='<?php echo $form["appraiser_name"]?>'>
                    </div>
                    <div class='collection'>
                        <label class='collectionTitle'>
                            <div>
                                Countersigning Officer Name:
                            </div>
                        </label>
                        <input disabled type='text' class='system_value' name='countersigner_name' value='<?php echo $form["countersigner_name"]?>'>
                    </div>
                </div>
                <div class='collectionContainer'>
                    <div class='collection'>
                        <label class='collectionTitle'>
                            <div>
                                Period of Evaluation:
                            </div>
                        </label>
                        <input disabled type='text' class='system_value' name='survey_period' value='<?php echo $form["survey_period"]?>'>
                    </div>
                    <div class='collection'>
                        <label class='collectionTitle'>
                            <div>
                                Commencement Date:
                            </div>
                        </label>
                        <input disabled type='date' class='system_value' name='survey_commencement_date' value='<?php echo $form["survey_commencement_date"]?>'>
                    </div>
                    <div class='collection'>
                        <label class='collectionTitle'>
                            <div>
                                Types of Appraisal
                            </div>
                        </label>
                        <input disabled type='text' class='system_value' name='survey_type' id='mid_yearly' value='<?php echo $form["survey_period"]?>'>
                    </div>                      
                </div>
            </div>
            <div class='part'>
                <p>
                    Scoring Scheme: Below Manager Level - Part A (50%) + Part B (50%); Manager Level and above - Part A (50%) + Part B1 (30%) + Part B2 (20%)
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
                    $rowCount = count($form["partA"]);
                    if ($rowCount <= 2) {
                        $rowCount = 3;
                    }
                    for ($i = 0; $i < $rowCount; $i ++) {
                        if (empty($form["partA"])) {
                ?>                
                    <div class='collectionContainer part_a_set'>
                        <div class='collection left'>
                            <div class='collectionTitle'>
                                <div>
                                    For Employee
                                </div>
                            </div>
                            <div class='collectionContainer'>
                                <div class='collection'>
                                    <label>Key Responsibilities or Objectives: </label>
                                    <textarea disabled type='text' class='self'></textarea>
                                </div>
                                <div class='collection'>
                                    <label>Achievements/Results Achieved</label>
                                    <textarea disabled class='self'></textarea>
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
                                    <textarea disabled class='appraiser'></textarea>
                                </div>
                                <div class='collection score'>
                                    <label class='collectionTitle'>
                                        <div>
                                            Weight (%)*
                                        </div>
                                    </label>
                                    <input disabled type='text' class='appraiser weight'>
                                    <label class='collectionTitle'>
                                        <div>
                                            Score
                                        </div>
                                    </label>
                                    <input disabled type='text' class='appraiser a_score'>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php   } else { ?>
                    <div class='collectionContainer part_a_set'>
                        <div class='collection left'>
                            <div class='collectionTitle'>
                                <div>
                                    For Employee
                                </div>
                            </div>
                            <div class='collectionContainer'>
                                <div class='collection'>
                                    <label>Key Responsibilities or Objectives: </label>
                                    <textarea disabled type='text' class='self'><?php echo $form["partA"][$i]["respon_name"]?></textarea>
                                </div>
                                <div class='collection'>
                                    <label>Achievements/Results Achieved</label>
                                    <textarea disabled class='self'><?php echo $form["partA"][$i]["respon_result"]?></textarea>
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
                                    <textarea disabled class='appraiser'><?php echo $form["partA"][$i]["respon_comment"]?></textarea>
                                </div>
                                <div class='collection score'>
                                    <label class='collectionTitle'>
                                        <div>
                                            Weight (%)*
                                        </div>
                                    </label>
                                    <input disabled type='text' class='appraiser weight' value='<?php echo $form["partA"][$i]["respon_weight"]?>'>
                                    <label class='collectionTitle'>
                                        <div>
                                            Score
                                        </div>
                                    </label>
                                    <input disabled type='text' class='appraiser a_score' value='<?php echo $form["partA"][$i]["respon_score"]?>'>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php   }                    
             
                }?>

                <div class='collectionContainer'>
                    <div class='collection overall_score'>
                        <div class='collectionTitle'>
                            <div>
                                Part A subtotal
                            </div>
                        </div>
                        <div class='subtotal'>
                            <input class='appraiser subtotal' type='text' name='part_a_overall_score' disabled value='<?php echo $form["part_a_overall_score"] ?>'> 
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
                            <p><label> Name : </label> <input disabled type='text' class='system_value' name='countersigner_1_name' value='<?php echo $form["countersigner_1_name"]?>'></p>
                            <div class='collectionContainer'>
                                <div class='collection'>
                                    <label> Score : </label> <input disabled type='text' class='counter1' name='countersigner_1_part_a_score' value='<?php echo $form["countersigner_1_part_a_score"]?>'>
                                </div>
                            </div>
                        </div>
                        <div class='collection'>                                   
                            <p><label> Name : </label> <input disabled type='text' class='system_value' name='countersigner_2_name' value='<?php echo $form["countersigner_2_name"]?>'></p>

                            <div class='collectionContainer'>
                                <div class='collection'>
                                    <label> Score : </label> <input disabled type='text' class='counter2' name='countersigner_2_part_a_score' value='<?php echo $form["countersigner_2_part_a_score"]?>'>
                                </div>
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
                            <input class='system_value subtotal' id='part-a-countered-score' type='text' name='part_a_total' disabled value='<?php echo $form["part_a_total"]?>'> 
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

                class ScoringScheme {

                    public $name;
                    public $scoreArray = array();

                }

                for ($i = 0; $i < 8; $i++) {
                    $question[$i] = new ScoringScheme();
                }

                $question[0]->name = "Teamwork and Support";
                $question[0]->scoreArray = array(
                    "Fosters team spirit, encourages others to contribute and draws on wide variety of others' skills to achieve team success.",
                    "Cooperates with colleagues, willingly shares team values, listens, makes a constructive contribution to teams and builds on team success.",
                    "Liaises with colleagues, willingly shares team information and knowledge and makes a constructive contribution to teams. Recognize one's limit and seek for support without delay.",
                    "Did not demonstrate the willingness to work amicably with colleagues or proactively support others in times of need",
                    "Behaves in a disruptive manner within team, is confrontational and negatively criticises others and their contributions. Not considered a team worker."
                );

                $question[1]->name = "Ownership";
                $question[1]->scoreArray = array(
                    "Has a record of taking ownership for major problems, crises and issues and ensuring timely and well judged decisions are made and involving others as necessary.",
                    "Has a record of taking ownership for customer problems, team goals and challenging objectives and seeks assistance whenever appropriate.",
                    "Has a limited record of taking ownership for own decisions and outcomes and does not depend unduly on others, however, knows when to ask for assistance.",
                    "Has not demonstrated ownership.",
                    "Ignores potential problems, 'not my problem attitude', blames others for problems rather than helps to resolve problems."
                );

                $question[2]->name = "Customer Focus";
                $question[2]->scoreArray = array(
                    "Exceeds customers' expectations, develops mutually beneficial relationships with customers.",
                    "Has an in-depth understanding of customer needs (gained via experience and research), use this build customer confidence, to develop improvements in customer service levels and relationships.",
                    "Has correct understanding of customer needs, received good customer feedback, responding appropriately to customer issues and displays a concern to improve customer service levels.",
                    "Has no record of working with internal or external customers.",
                    "Has no observable desire to provide service to others. Past customers have requested that this person does no further work/is removed from site."
                );

                $question[3]->name = "Initiative";
                $question[3]->scoreArray = array(
                    "Has a record of creating, seizing and driving new ideas and opportunities to implementation.",
                    "Anticipates problems and takes per-emptive action to deal with them, has a record of evaluating problems and developing more effective ways of doing things.",
                    "Gets on with jobs, does not need asking to do things and generates ideas for helping to resolve issues.",
                    "No evidence of using initiative and seizing opportunities to take action.",
                    "Shows no initiative at all, has to be asked to do things and requires supervision and guidance or set procedures to follow."
                );

                $question[4]->name = "Attention to Detail";
                $question[4]->scoreArray = array(
                    "Consistently high standard with work right first time, sets an example to others and source of advice and guidance.",
                    "Shows concern for quality, produces high quality work which is mostly right first time.",
                    "Concentrates, checks that work is accurate, make few mistakes and learns from them. Seeks advice/help as appropriate.",
                    "No evidence of concern for quality of the job.",
                    "Makes careless and simple mistakes, work in generally sloppy and has to be checked or re-worked, shows no concern for quality standards. Mistakes have impact on service quality."
                );

                $question[5]->name = "Problem Solving and Decision Making";
                $question[5]->scoreArray = array(
                    "Has record of developing timely solutions for major problems, looks at wider issues, is creative and uses wide range of tools and sources to develop solutions.",
                    "Has record of analysing and developing solutions to complex problems, searches widely for options, aware and proficient in a variety of techniques. Offered new ideas and solutions that are not tied to past method and result in order to increase the value of work.",
                    "Has record of handling straight forward problems and developing workable solutions including but not limited to reorganize work unit structure, job assignment or resources. Offered constructive and practical suggestions to tackle work problems.",
                    "No evidence of successful problem solving skills and not willing to handle challenging tasks or accept changes in role or situation.",
                    "Is generally unsuccessful in solving problems or takes longer than necessary even with straight forward problems. No concept of whom to ask for support/advice and can handle ordinary routine works only."
                );

                $question[6]->name = "Achieving Results and Compliance";
                $question[6]->scoreArray = array(
                    "Has a record of achieving nearly all goals set on schedule, in budget, and anticipating and managing complexities, changing priorities and needs - 80/20%, while the tasks completed are complying the Company goals, quality objectives, policies and procedures. ",
                    "Has a record of mostly achieving goals agreed or set in budget and generally on schedule - 70/30%, while the tasks completed are complying the Company goals, quality objectives, policies and procedures. ",
                    "Has a record of generally achieving goals agreed - 60/40%, while the tasks completed are complying the quality objectives, policies and procedures.",
                    "Not able to demonstrate record of achieving results or more than half of tasks completed are not complying the quality objectives, policies and procedures.",
                    "Fails to achieve own goals and hinders results of others. "
                );

                $question[7]->name = "Communication and Interpersonal";
                $question[7]->scoreArray = array(
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
                                        <span class='collection gray'> <input disabled type='radio' class='self' value='5' <?php echo ($form["partB1"][$key]["self_score"] == "5") ? "checked" : "" ?>> </span>
                                        <span class='collection'> <input disabled type='radio' class='self' value='4' <?php echo ($form["partB1"][$key]["self_score"] == "4") ? "checked" : "" ?>> </span>
                                        <span class='collection gray'> <input disabled type='radio' class='self' value='3' <?php echo ($form["partB1"][$key]["self_score"] == "3") ? "checked" : "" ?>> </span>
                                        <span class='collection'> <input disabled type='radio' class='self' value='2' <?php echo ($form["partB1"][$key]["self_score"] == "2") ? "checked" : "" ?>> </span>
                                        <span class='collection gray'> <input disabled type='radio' class='self' value='1' <?php echo ($form["partB1"][$key]["self_score"] == "1") ? "checked" : "" ?>> </span>
                                    </div>
                                </div>

                                <div class='collection example'>
                                    <label>Example: </label> <br>                                
                                    <textarea disabled class='self'><?php echo $form["partB1"][$key]["self_example"]?></textarea>
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
                                        <span class='collection gray'> <input disabled type='radio' class='appraiser b1-score' value='5' <?php echo ($form["partB1"][$key]["appraiser_score"] == "5") ? "checked" : "" ?>> </span>
                                        <span class='collection'> <input disabled type='radio' class='appraiser b1-score' value='4' <?php echo ($form["partB1"][$key]["appraiser_score"] == "4") ? "checked" : "" ?>> </span>
                                        <span class='collection gray'> <input disabled type='radio' class='appraiser b1-score' value='3' <?php echo ($form["partB1"][$key]["appraiser_score"] == "3") ? "checked" : "" ?>> </span>
                                        <span class='collection'> <input disabled type='radio' class='appraiser b1-score' value='2' <?php echo ($form["partB1"][$key]["appraiser_score"] == "2") ? "checked" : "" ?>> </span>
                                        <span class='collection gray'> <input disabled type='radio' class='appraiser b1-score' value='1' <?php echo ($form["partB1"][$key]["appraiser_score"] == "1") ? "checked" : "" ?>> </span>
                                    </div>
                                </div>
                                <div class='collection example'>
                                    <label>Example: </label>  <br>                              
                                    <textarea disabled class='appraiser'><?php echo $form["partB1"][$key]["appraiser_example"]?></textarea>
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
                        <textarea disabled name='part_b1_overall_comment' required><?php echo $form["part_b1_overall_comment"] ?></textarea>
                    </div>

                    <div class='collection overall_score'>
                        <div class='collectionTitle'>
                            <div>
                                Part B1 subtotal
                            </div>
                        </div>
                        <div class='subtotal'>
                            <input class='appraiser subtotal' type='text' name='part_b1_overall_score' disabled value='<?php echo $form["part_b1_overall_score"] ?>'> 
                        </div>
                    </div>
                </div>              
            </div>
            <?php if ($form["is_senior"]) {?>
            <div class='part_title' id='part_b2_title'>
                Part B2: This section is applicable to Senior Executive employee (Manager level and above)
            </div>
            <div class='part part_b' id='part_b2'>
                <?php
                $question = array();

                for ($i = 0; $i < 3; $i++) {
                    $question[$i] = new scoringScheme();
                }

                $question[0]->name = "Influence, Negotiation and Persuasion";
                $question[0]->scoreArray = array(
                    "Effective influencer and persuader at all levels, able to get most ideas accepted in diverse groups at most levels of seniority.",
                    "Inspires confidence, has credibility with colleagues and customers and is able to get complex ideas accepted. It is generally able to persuade from a basis of openness and clarity.",
                    "Make a positive impact, is clear, concise, articulate and assertive when providing information and considered logical and reasoned in presenting own case. Able to compromise with customers (or other stakeholder) by convincing them of one's ideas and thoughts from various point of view. ",
                    "Has no involvement in making oral or written presentations or in getting ideas or views across to others. Not able to find acceptable solution for all the parties from mid/long term prospective instead of insisting on one's idea.",
                    "Colleagues and/or customers pay little attention to debate, proffered solutions or written work. Contributions within team or at meetings are generally not listened to."
                );

                $question[1]->name = "Coaching and Developing";
                $question[1]->scoreArray = array(
                    "Takes time to coach and develop people for improved performance; Pro-active in idenitifying and developing high calibrae knowledge, and planning for enhancement of managerial qualities in self and others.",
                    "Provides regular feedback on performance, suggests improvements, listens and empathises with others, and gets people to commit to responsibilties and try new techniques; Pro-active in sharing knowledge, leading, training, supporting and motivating people to achieve results and improve their works.",
                    "Translates performance targets into clear objectives. Generally coaches and supports others on low level daily issues.",
                    "Is not involved in coaching and developing others.",
                    "Hinders the development of others and generally provides no or negative feedback. Unwilling to devote time to development of others."
                );

                $question[2]->name = "Leadership and Strategic Thinking";
                $question[2]->scoreArray = array(
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
                                        <span class='collection gray'> <input disabled type='radio' class='self'  name='multi_b2_self_score_<?php echo $key ?>' value='5' <?php echo ($form["partB2"][$key]["self_score"] == "5") ? "checked" : "" ?>> </span>
                                        <span class='collection'> <input disabled type='radio' class='self'  name='multi_b2_self_score_<?php echo $key ?>' value='4' <?php echo ($form["partB2"][$key]["self_score"] == "4") ? "checked" : "" ?>> </span>
                                        <span class='collection gray'> <input disabled type='radio' class='self'  name='multi_b2_self_score_<?php echo $key ?>' value='3' <?php echo ($form["partB2"][$key]["self_score"] == "3") ? "checked" : "" ?>> </span>
                                        <span class='collection'> <input disabled type='radio' class='self'  name='multi_b2_self_score_<?php echo $key ?>' value='2' <?php echo ($form["partB2"][$key]["self_score"] == "2") ? "checked" : "" ?>> </span>
                                        <span class='collection gray'> <input disabled type='radio' class='self'  name='multi_b2_self_score_<?php echo $key ?>' value='1' <?php echo ($form["partB2"][$key]["self_score"] == "1") ? "checked" : "" ?>> </span>
                                    </div>
                                </div>
                                <div class='collection'>
                                    <label>Example: </label> <br>                                
                                    <textarea disabled class='self' name='multi_b2_self_example_<?php echo $key ?>'><?php echo $form["partB2"][$key]["self_example"]?></textarea>
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
                                        <span class='collection gray'> <input disabled type='radio' class='appraiser b2-score' id='q<?php echo $key ?>' name='multi_b2_appraiser_score_<?php echo $key ?>' value='5' <?php echo ($form["partB2"][$key]["appraiser_score"] == "5") ? "checked" : "" ?>> </span>
                                        <span class='collection'> <input disabled type='radio' class='appraiser b2-score' id='q<?php echo $key ?>' name='multi_b2_appraiser_score_<?php echo $key ?>' value='4' <?php echo ($form["partB2"][$key]["appraiser_score"] == "4") ? "checked" : "" ?>> </span>
                                        <span class='collection gray'> <input disabled type='radio' class='appraiser b2-score' id='q<?php echo $key ?>' name='multi_b2_appraiser_score_<?php echo $key ?>' value='3' <?php echo ($form["partB2"][$key]["appraiser_score"] == "3") ? "checked" : "" ?>> </span>
                                        <span class='collection'> <input disabled type='radio' class='appraiser b2-score' id='q<?php echo $key ?>' name='multi_b2_appraiser_score_<?php echo $key ?>' value='2' <?php echo ($form["partB2"][$key]["appraiser_score"] == "2") ? "checked" : "" ?>> </span>
                                        <span class='collection gray'> <input disabled type='radio' class='appraiser b2-score' id='q<?php echo $key ?>' name='multi_b2_appraiser_score_<?php echo $key ?>' value='1' <?php echo ($form["partB2"][$key]["appraiser_score"] == "1") ? "checked" : "" ?>> </span>
                                    </div>
                                </div>
                                <div class='collection'>
                                    <label>Example: </label>  <br>                              
                                    <textarea disabled class='appraiser' name='multi_b2_appraiser_example_<?php echo $key ?>'><?php echo $form["partB2"][$key]["appraiser_example"]?></textarea>                                    
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
                        <textarea disabled name='part_b2_overall_comment' required><?php echo $form["part_b2_overall_comment"]?></textarea>
                    </div>                            
                    <div class='collection overall_score'>
                        <div class='collectionTitle'>
                            Part B2 subtotal
                        </div>
                        <div class='subtotal'>
                            <input disabled type='text' class='appraiser subtotal' name='part_b2_overall_score' value='<?php echo $form["part_b2_overall_score"]?>'> 
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class='part'>
                <div class='countersigner'>
                    <div class='collectionTitle'>
                        <div>
                            Scoring from Countersigning Officer:
                        </div>
                    </div>
                    <div class='collectionContainer '>
                        <div class='collection'>                                    
                            <p><label> Name : </label> <input disabled type='text' class='system_value' name='countersigner_1_name' value='<?php echo $form["countersigner_1_name"]?>'></p>
                            <div class='collectionContainer '>
                                <div class='collection'>  
                                    <label> Score : </label> <input disabled type='text' class='counter1' name='countersigner_1_part_b_score' value='<?php echo $form["countersigner_1_part_b_score"]?>'>
                                </div>
                            </div> 
                        </div>
                        <div class='collection'>
                            <p><label> Name : </label> <input disabled type='text' class='system_value' name='countersigner_2_name' value='<?php echo $form["countersigner_2_name"]?>'></p>
                            <div class='collectionContainer'>
                                <div class='collection'>                                    
                                    <label> Score : </label> <input disabled type='text' class='counter2' name='countersigner_2_part_b_score' value='<?php echo $form["countersigner_2_part_b_score"]?>'>
                                </div>
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
                            <input class='system_value subtotal' type='text' id='part-b-countered-score' name='part_b_total' disabled value='<?php echo $form["part_b_total"]?>'> 
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
                        <input class='system_value subtotal' type='text' name='part_a_b_total' disabled value='<?php echo $form["part_a_b_total"] ?>'> 
                    </div>
                </div>
            </div>
            <div class='part' id='part_c'>
                <div class='part_title' id='part_c_title'>
                    Part C: Learning and Development Plan (To be completed by Appraising Officer and Employee collaboratively) 
                </div> 
                <p>For Appraising Officer: please evaluate the strengths and weaknesses of the employee and develop an action plan to improve the employee's work performance in collaboration with him/her. </p>
                <div id='professional_competency'>
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
                                <li><?php echo $form["prof_competency_1"]?></li>
                                <li><?php echo $form["prof_competency_2"]?></li>
                                <li><?php echo $form["prof_competency_3"]?></li>
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
                                <li>
                                    <?php echo $form["core_competency_1"]?>
                                </li>
                                <li>
                                    <?php echo $form["core_competency_2"]?>
                                </li>
                                <li>
                                    <?php echo $form["core_competency_3"]?>
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
                                <div><?php echo $form["on_job_0_to_1_year"]?></div>
                                <div><?php echo $form["on_job_1_to_2_year"]?></div>
                                <div><?php echo $form["on_job_2_to_3_year"]?></div>                           
                            </div>
                        </div>
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
                                <div>
                                    <?php echo $form["function_training_0_to_1_year"]?>
                                </div>
                                <div>
                                    <?php echo $form["function_training_1_to_2_year"]?>
                                </div>
                                <div>
                                    <?php echo $form["function_training_2_to_3_year"]?>
                                </div>
                            </div>
                        </div>
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
                                <div>
                                    <?php echo $form["generic_training_0_to_1_year"]?>
                                </div>
                                <div>
                                    <?php echo $form["generic_training_1_to_2_year"]?>
                                </div>
                                <div>
                                    <?php echo $form["generic_training_2_to_3_year"]?>
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
                $rowCount = count($form["partD"]);
                if ($rowCount == 0) {
                    $rowCount = 1;
                }
                for ($i = 0; $i < $rowCount; $i ++) {
                    if (!empty($form["partD"][$i])) {
                    ?>
                    <div class='collectionContainer'>
                        <div class='collection'>
                            <div class='collectionTitle'>
                                <div>
                                    Key Responsibilities
                                </div>
                            </div>
                            <div class='collection'>
                                <textarea disabled class='appraiser'><?php echo $form["partD"][$i]["key_respon"] ?></textarea>
                            </div>
                        </div>
                        <div class='collection'>
                            <div class='collectionTitle'>
                                <div>
                                    Goals
                                </div>
                            </div>
                            <div class='collection'>
                                <textarea disabled class='appraiser'><?php echo $form["partD"][$i]["goal_name"] ?></textarea>
                            </div>
                        </div>
                        <div class='collection'>
                            <div class='collectionTitle'>
                                <div>
                                    Measurements
                                </div>
                            </div>
                            <div class='collection'>
                                <textarea disabled class='appraiser name'><?php echo $form["partD"][$i]["measurement_name"] ?></textarea>
                            </div>
                        </div>
                        <div class='collection'>
                            <div class='collectionTitle'>
                                <div>
                                    Weight
                                </div>
                            </div>
                            <div class='collection'>
                                <input disabled type='text' class='appraiser weight' value='<?php echo $form["partD"][$i]["goal_weight"] ?>'>
                            </div>
                            <div class='collectionTitle'>
                                <div>
                                    Completion Date
                                </div>
                            </div>
                            <div class='collection'>
                                <input disabled type='text' class='appraiser date' value='<?php echo $form["partD"][$i]["complete_date"] ?>'>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class='collectionContainer'>
                        <div class='collection'>
                            <div class='collectionTitle'>
                                <div>
                                    Key Responsibilities
                                </div>
                            </div>
                            <div class='collection'>
                                <textarea disabled class='appraiser'></textarea>
                            </div>
                        </div>
                        <div class='collection'>
                            <div class='collectionTitle'>
                                <div>
                                    Goals
                                </div>
                            </div>
                            <div class='collection'>
                                <textarea disabled class='appraiser'></textarea>
                            </div>
                        </div>
                        <div class='collection'>
                            <div class='collectionTitle'>
                                <div>
                                    Measurements
                                </div>
                            </div>
                            <div class='collection'>
                                <textarea disabled class='appraiser name'></textarea>
                            </div>
                        </div>
                        <div class='collection'>
                            <div class='collectionTitle'>
                                <div>
                                    Weight
                                </div>
                            </div>
                            <div class='collection'>
                                <input disabled type='text' class='appraiser weight'>
                            </div>
                            <div class='collectionTitle'>
                                <div>
                                    Completion Date
                                </div>
                            </div>
                            <div class='collection'>
                                <input disabled type='month' class='appraiser date'>
                            </div>
                        </div>
                    </div>
                <?php                        
                    }
                }?>
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
                    <textarea disabled class='both' name='survey_overall_comment'><?php echo $form["survey_overall_comment"] ?></textarea>
                </div>
            </div>
        </div>
    </div>
</div>