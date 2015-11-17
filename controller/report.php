<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of report
 *
 * @author anthony.poon
 */
class report extends privilegedZone {

    //put your code here
    function __construct() {
        parent::__construct();
    }

    function defaultAction($param = NULL) {
        if (!$this->user->isReportUser && !$this->user->isAdmin) {
            throw new Exception('Illegel parameter: Access Denied (Not Admin and not report user)');
        }     
        $userOperator = new userBatchOperator();
        $userList = $userOperator->getUserFullData();
        $data = new reportData();
        $periodIndex = $data->getAvailablePeriod();
        $this->header = 'surveyHeader.php';
        $this->extraCSS = 'report.css';
        $this->content = 'report.php';
        $param['periodIndex'] = $periodIndex;
        if (!empty($param['uid'])) {
            $param['data'] = $data->getFormSummary($param['uid']);
        }
        if  (!empty($param['data']) && !$this->user->isAdmin && $this->user->isReportUser) {
            foreach ($param['data'] as $user => $data) {
                if (strcasecmp($data['staff_department'], $this->user->department)) {
                    unset($param['data'][$user]);
                }
            }
            foreach ($userList as $user => $data) {
                if (strcasecmp($data['user_department'], $this->user->department)) {
                    unset($userList[$user]);
                }
            }
        }
        $param['emptySurvey'] = $userOperator->getEmptyUserData();
        $this->view($param);
    }
    
    function unlock($param = null) {
        $result = $this->isAdmin();
        $operator = new formBatchOperator($param['uid']);
        $operator->unlockForm();
    }
    
   function lock($param = null) {
        $result = $this->isAdmin();
        $operator = new formBatchOperator($param['uid']);
        $operator->lockForm();
    }
    
    function activate($param = null) {
        $result = $this->isAdmin();
        $operator = new formBatchOperator($param['uid']);
        $operator->activateForm();
    }
    
   function deactivate($param = null) {
        $result = $this->isAdmin();
        $operator = new formBatchOperator($param['uid']);
        $operator->deactivateForm();
    }
    
    function getJSON($param) {
        $result = $this->isAdmin();
        if (!empty($param['uid'])) {
            $data = new reportData();
            $data->uid = $param['uid'];
            header("Content-type: application/json");
            header("Content-Disposition: attachment; filename=report.JSON");
            echo $data->getJsonReport();
        }
    }
    
    function isAdmin() {
        if (!$this->user->isAdmin){
            throw new Exception("Illegel parameter: Access Denied (Not Admin)");
        } else {
            return true;
        }
    }
    
    function getCSV($param) {
        $result = $this->isAdmin();
        if (!empty($param['uid'])) {
            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename=report.csv");
            $csvObj = new csvDataBuilder($param['uid']);
            $csvObj->setVisibility(array("staff_name" => "Full Name", 
                "staff_department" => "Department", "staff_position" => "Position", "is_senior"=>"Seniority", "staff_office" => "Office", 
                "appraiser_name" => "Appraiser", "countersigner_name" => "Countersigner", "survey_commencement_date" => "Join Date", 
                "part_a_overall_score" => "Part A score before countersigning", "part_b1_overall_score" => "Part B1 score before countersigning", 
                "part_b2_overall_score" => "Part B2 score before countersigning", "part_a_total" => "Part A score after countersigning",
                "part_b_total" => "Part B after countersigning", "part_a_b_total" => "Final Score", "is_final_by_self" => "Finalized by appraisee",
                "is_final_by_appraiser" => "Finalized by Appraiser"));
            
            echo $csvObj->getCSVString();            
        }
    }
    
    function fullExcelReport($param = null) {
        $report = new excelReport($_GET['uid']);
        $report->generateRawDataSheet();
        $report->generateTopAndBottom();        
        $report->generateByOfficeDepartment();
        $report->generateByOfficeByScore();
        $report->generateTraining();
        $report->generateOverallComments();
        $report->generateGoals();
        $report->outputExcel();
    }
    
    /**function excelSummaryReport($param = null) {
        
        function arrayGetColumn($array, $columnName){
            $result = array();
            foreach ($array as $arrayItem) {
               array_push($result, $arrayItem[$columnName]);
            }
            return $result;
        }
        require_once(ROOT . DS . 'plugin/PHPExcel.php');
        require_once(ROOT . DS . 'plugin/PHPExcel/IOFactory.php');
        $userOperator = new userBatchOperator();
        $userList = $userOperator->getUserFullData();
        $workbook = new PHPExcel();
        $writer = PHPExcel_IOFactory::createWriter($workbook, 'Excel2007');
        $sheet = $workbook->getActiveSheet();
        
        if (!empty($param['uid'])) {
            $data = new reportData();
            $summary = $data->getFormSummary($param['uid']);
            $arrayStaffOffice = arrayGetColumn($summary, 'staff_office');
            $arrayStaffDepartment = arrayGetColumn($summary, 'staff_department');
            $arrayIsSenior = arrayGetColumn($summary, 'is_senior');
            $emptySurvey = array_diff_key($userList, $summary);
            array_multisort($arrayStaffOffice, $arrayStaffDepartment, $arrayIsSenior, SORT_DESC,$summary);
            $arrayStaffOffice = arrayGetColumn($emptySurvey, 'user_office');
            $arrayStaffDepartment = arrayGetColumn($emptySurvey, 'user_department');
            $arrayIsSenior = arrayGetColumn($emptySurvey, 'is_senior');
            array_multisort($arrayStaffOffice, $arrayStaffDepartment, $arrayIsSenior, SORT_DESC,$emptySurvey);
            $startingRow = 2;
            $rowOffset = 0;
            $sheet->setCellValueByColumnAndRow(0, 1, "Office");
            $sheet->setCellValueByColumnAndRow(1, 1, "Department");
            $sheet->setCellValueByColumnAndRow(2, 1, "Position");
            $sheet->setCellValueByColumnAndRow(3, 1, "Full Name");
            $sheet->setCellValueByColumnAndRow(4, 1, "Seniority");
            $sheet->setCellValueByColumnAndRow(5, 1, "Appraising Officer");
            $sheet->setCellValueByColumnAndRow(6, 1, "Countersigniner Officer");
            $sheet->setCellValueByColumnAndRow(7, 1, "Join Date");
            $sheet->setCellValueByColumnAndRow(8, 1, "Part A score\nbefore countersigning");
            $sheet->getStyleByColumnAndRow(8, 1)->getAlignment()->setWrapText(true);
            $sheet->setCellValueByColumnAndRow(9, 1, "Part B1 score\nbefore countersigning");
            $sheet->getStyleByColumnAndRow(9, 1)->getAlignment()->setWrapText(true);
            $sheet->setCellValueByColumnAndRow(10, 1, "Part B2 score\nbefore countersigning");
            $sheet->getStyleByColumnAndRow(10, 1)->getAlignment()->setWrapText(true);
            $sheet->setCellValueByColumnAndRow(11, 1, "Part A score\nafter countersigning");
            $sheet->getStyleByColumnAndRow(11, 1)->getAlignment()->setWrapText(true);
            $sheet->setCellValueByColumnAndRow(12, 1, "Part B after\ncountersigning");
            $sheet->getStyleByColumnAndRow(12, 1)->getAlignment()->setWrapText(true);
            $sheet->setCellValueByColumnAndRow(13, 1, "Final Score");
            foreach ($summary as $username => $detail) {
                $sheet->setCellValueByColumnAndRow(0, $startingRow + $rowOffset, $detail['staff_office']);
                $sheet->setCellValueByColumnAndRow(1, $startingRow + $rowOffset, $detail['staff_department']);
                $sheet->setCellValueByColumnAndRow(2, $startingRow + $rowOffset, $detail['staff_position']);
                $sheet->setCellValueByColumnAndRow(3, $startingRow + $rowOffset, $detail['staff_name']);
                if ($detail['is_senior']) {
                    $str = "DGM or above";
                } else {
                    $str = "Below DGM";
                }
                $sheet->setCellValueByColumnAndRow(4, $startingRow + $rowOffset, $str);
                $sheet->setCellValueByColumnAndRow(5, $startingRow + $rowOffset, $detail['appraiser_name']);
                $sheet->setCellValueByColumnAndRow(6, $startingRow + $rowOffset, $detail['countersigner_name']);
                $timestemp = strtotime($detail['survey_commencement_date']);
                $sheet->setCellValueByColumnAndRow(7, $startingRow + $rowOffset, ceil(PHPExcel_Shared_Date::PHPToExcel($timestemp)));
                $sheet->getStyleByColumnAndRow(7, $startingRow + $rowOffset)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
                $sheet->setCellValueByColumnAndRow(8, $startingRow + $rowOffset, $detail['part_a_overall_score']);
                $sheet->setCellValueByColumnAndRow(9, $startingRow + $rowOffset, $detail['part_b1_overall_score']);
                $sheet->setCellValueByColumnAndRow(10, $startingRow + $rowOffset, $detail['part_b2_overall_score']);
                $sheet->setCellValueByColumnAndRow(11, $startingRow + $rowOffset, $detail['part_a_total']);
                $sheet->setCellValueByColumnAndRow(12, $startingRow + $rowOffset, $detail['part_b_total']);
                $sheet->setCellValueByColumnAndRow(13, $startingRow + $rowOffset, $detail['part_a_b_total']);
                $rowOffset = $rowOffset + 1;
            }
            foreach ($emptySurvey as $username => $detail) {
                $sheet->setCellValueByColumnAndRow(0, $startingRow + $rowOffset, $detail['user_office']);
                $sheet->setCellValueByColumnAndRow(1, $startingRow + $rowOffset, $detail['user_department']);
                $sheet->setCellValueByColumnAndRow(2, $startingRow + $rowOffset, $detail['user_position']);
                $sheet->setCellValueByColumnAndRow(3, $startingRow + $rowOffset, $detail['user_full_name']);
                if ($detail['is_senior']) {
                    $str = "DGM or above";
                } else {
                    $str = "Below DGM";
                }
                $sheet->setCellValueByColumnAndRow(4, $startingRow + $rowOffset, $str);
                $rowOffset = $rowOffset + 1;
            }
            for ($i = 0; $i <= 13; $i ++) {
                $sheet->getColumnDimensionByColumn($i)->setAutoSize(TRUE);
            }
            header('Content-type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="report.xlsx"');
            $writer->save('php://output');
        }
        
    }**/
    
    function outputFile($param = null){
       //Init. PHPExcel Plugin
        require_once(ROOT . DS . 'plugin/PHPExcel.php');
        require_once(ROOT . DS . 'plugin/PHPExcel/IOFactory.php');        
        //Create reader and writer
        $reader = PHPExcel_IOFactory::createReader('Excel5');        
        $excelTemplate = $reader->load(ROOT.DS."view".DS."template".DS."PA_Raw.xls");
        $writer = PHPExcel_IOFactory::createWriter($excelTemplate, 'Excel2007');
        //Check right and param.
        $data = new formData($param['u'], $param['uid']);
        if ($data->isNewForm()) {
            throw new Exception("Username not found or User have not filled in survey yet");
        }
        //Get Data to be passed into Excel
        $formDetail = $data->getFormData();
        //Bind data to cell
        $excelTemplate->getProperties()->setCreator("Anthony Poon")
                ->setTitle("PA Form Output");
        $sheet = $excelTemplate->getActiveSheet();
        $sheet->getCell("A5")->setValue($formDetail['staff_name']);
        $sheet->getCell("F5")->setValue($formDetail['staff_department']);
        $sheet->getCell("L5")->setValue($formDetail['staff_position']);
        $sheet->getCell("A7")->setValue($formDetail['staff_office']);
        $sheet->getCell("F7")->setValue($formDetail['appraiser_name']);
        $sheet->getCell("L7")->setValue($formDetail['countersigner_name']);
        $sheet->getCell("A9")->setValue($formDetail['survey_period']);
        $sheet->getCell("F9")->setValue($formDetail['survey_commencement_date']);
        $sheet->getCell("L9")->setValue($formDetail['survey_type']);
        if (!empty($formDetail['partA'])) {
            foreach ($formDetail['partA'] as $index => $valueArray) {
                $row = 21 + ($valueArray['question_no'] - 1);
                if ($valueArray['question_no'] <= 8) { //max 8 entries for now
                    $sheet->getCell("A".$row)->setValue($valueArray['respon_name']);
                    $sheet->getCell("D".$row)->setValue($valueArray['respon_result']);
                    $sheet->getCell("J".$row)->setValue($valueArray['respon_comment']);
                    if (!empty($valueArray['respon_weight'])) {
                        $sheet->getCell("P".$row)->setValue($valueArray['respon_weight']/100);
                    }
                    if (!empty($valueArray['respon_score'])) {
                        $sheet->getCell("Q".$row)->setValue($valueArray['respon_score']);
                    }
                }
            }
        }
        $sheet->getCell("P29")->setValue($formDetail['part_a_overall_score']);
        $sheet->getCell("G31")->setValue($formDetail['countersigner_1_name']);
        $sheet->getCell("L31")->setValue($formDetail['countersigner_2_name']);
        $sheet->getCell("G32")->setValue($formDetail['countersigner_1_part_a_score']);
        $sheet->getCell("L32")->setValue($formDetail['countersigner_2_part_a_score']);
        $sheet->getCell("P34")->setValue($formDetail['part_a_total']);
        if (!empty($formDetail['partB1'])) {
            foreach ($formDetail['partB1'] as $index => $valueArray) {
            $row = 42 + ($valueArray['question_no'] - 1) * 5;
                if ($valueArray['question_no'] >= 7) {
                    $row = $row + 2;
                }
                $sheet->getCell("K".$row)->setValue($valueArray['self_score']);
                $sheet->getCell("L".$row)->setValue($valueArray['self_example']);
                $sheet->getCell("M".$row)->setValue($valueArray['appraiser_score']);
                $sheet->getCell("O".$row)->setValue($valueArray['appraiser_example']);                
            }
        }
        
        $sheet->getCell("B84")->setValue($formDetail['part_b1_overall_comment']);
        $sheet->getCell("P85")->setValue($formDetail['part_b1_overall_score']);
        if (!empty($formDetail['partB2'])) {
            foreach ($formDetail['partB2'] as $index => $valueArray) {
                $row = 90 + ($valueArray['question_no'] - 1)*5;
                $sheet->getCell("K".$row)->setValue($valueArray['self_score']);
                $sheet->getCell("L".$row)->setValue($valueArray['self_example']);
                $sheet->getCell("M".$row)->setValue($valueArray['appraiser_score']);
                $sheet->getCell("O".$row)->setValue($valueArray['appraiser_example']);                
            }
        }
        $sheet->getCell("B105")->setValue($formDetail['part_b2_overall_comment']);
        $sheet->getCell("P106")->setValue($formDetail['part_b2_overall_score']);
        $sheet->getCell("G108")->setValue($formDetail['countersigner_1_name']);
        $sheet->getCell("L108")->setValue($formDetail['countersigner_2_name']);
        $sheet->getCell("G109")->setValue($formDetail['countersigner_1_part_b_score']);
        $sheet->getCell("L109")->setValue($formDetail['countersigner_2_part_b_score']);
        $sheet->getCell("P111")->setValue($formDetail['part_b_total']);
        $sheet->getCell("P116")->setValue($formDetail['part_a_b_total']);
        $sheet->getCell("C122")->setValue($formDetail['prof_competency_1']);
        $sheet->getCell("C123")->setValue($formDetail['prof_competency_2']);
        $sheet->getCell("C124")->setValue($formDetail['prof_competency_3']);
        $sheet->getCell("C125")->setValue($formDetail['core_competency_1']);
        $sheet->getCell("C126")->setValue($formDetail['core_competency_2']);
        $sheet->getCell("C127")->setValue($formDetail['core_competency_3']);
        $sheet->getCell("D129")->setValue($formDetail['on_job_0_to_1_year']);
        $sheet->getCell("D130")->setValue($formDetail['on_job_1_to_2_year']);
        $sheet->getCell("D131")->setValue($formDetail['on_job_2_to_3_year']);
        $sheet->getCell("D132")->setValue($formDetail['function_training_0_to_1_year']);
        $sheet->getCell("D133")->setValue($formDetail['function_training_1_to_2_year']);
        $sheet->getCell("D134")->setValue($formDetail['function_training_2_to_3_year']);
        $sheet->getCell("D135")->setValue($formDetail['generic_training_0_to_1_year']);
        $sheet->getCell("D136")->setValue($formDetail['generic_training_1_to_2_year']);
        $sheet->getCell("D137")->setValue($formDetail['generic_training_2_to_3_year']);
        if (!empty($formDetail['partD'])) {
            foreach ($formDetail['partD'] as $index => $valueArray) {
                $row = 142 + ($valueArray['question_no'] - 1);
                if ($valueArray['question_no'] <= 8) { //max 8 entries for now
                    $sheet->getCell("A".$row)->setValue($valueArray['key_respon']);
                    $sheet->getCell("D".$row)->setValue($valueArray['goal_name']);
                    $sheet->getCell("G".$row)->setValue($valueArray['measurement_name']);
                    $sheet->getCell("M".$row)->setValue($valueArray['goal_weight']);
                    $sheet->getCell("O".$row)->setValue($valueArray['complete_date']);
                }
            }
        }
        $sheet->getCell("A152")->setValue($formDetail['survey_overall_comment']);
        //header("Content-type:application/pdf");
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="PA Form ('.$formDetail['staff_name'].').xlsx"');
        //ob_end_clean();
        $writer->save('php://output');
    }
    
    function testing() {
		require_once(ROOT . DS . 'plugin/PHPExcel.php');
        require_once(ROOT . DS . 'plugin/PHPExcel/IOFactory.php');    
		$excelTemplate = new PHPExcel();
		$writer = PHPExcel_IOFactory::createWriter($excelTemplate, 'Excel2007');
		$excelTemplate->getProperties()->setCreator("Anthony Poon")
                ->setTitle("PA Form Output");
        $sheet = $excelTemplate->getActiveSheet();
		header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="PA Form ().xlsx"');
        //ob_end_clean();
        $writer->save('php://output');	
    }
}
