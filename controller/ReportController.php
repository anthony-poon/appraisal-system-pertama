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
class ReportController extends PrivilegedZone {

    //put your code here
    function __construct() {
        parent::__construct();
    }
    
    function defaultAction($param = NULL) {
        $userOperator = new UserBatchOperator();
        $data = new ReportData();
        $periodIndex = $data->getAvailablePeriod();
        $accessRight = $userOperator->getUserAccessRight($this->user->username);
        $userList = $accessRight["accessable_user"];
        $this->header = 'surveyHeader.php';
        $this->extraCSS = 'report/report.css';
        $this->content = 'report.php';
        $this->extraCSS = array("report/report.css", "jquery-ui.css");
        $this->extraJS = array("report.js");
        $param['periodIndex'] = $periodIndex;
        if (!empty($param['uid'])) {
            $param['data'] = $data->getFormSummary($param['uid'], $userList);
        }
        foreach ($userOperator->getEmptyUserData($param['uid']) as $emptyUserData) {
            if (in_array($emptyUserData["username"], $userList)) {
                $param['empty_survey'][] = $emptyUserData;
            }
        }
        $this->view($param);
    }
    
    function unlockAll($param = null) {
        $result = $this->isAdmin();
        $operator = new FormBatchOperator($param['uid']);
        $operator->unlockForm();
    }
    
   function lockAll($param = null) {
        $result = $this->isAdmin();
        $operator = new FormBatchOperator($param['uid']);
        $operator->lockForm();
    }
    function toggleLock($param = null) {
        $this->isAdmin();
        $operator = new FormBatchOperator($param['uid']);
        $error = $operator->toggleLock($param['uid'], $param['u']);
        if ($error) {
            echo json_encode($result);
        } else {
            echo json_encode(array(
                "success" => true
            ));
        }
    }
    
    function isAdmin() {
        if (!$this->user->isAdmin){
            throw new Exception("Illegel parameter: Access Denied (Not Admin)");
        } else {
            return true;
        }
    }
    
    function fullExcelReport($param = null) {
        $report = new ExcelReport($param["uid"]);
        $report->generateRawDataSheet();
        $report->generateScoreSheet();
        $report->generateTopAndBottom();        
        $report->generateByOfficeDepartment();
        $report->generateByOfficeByScore();
        $report->generateTraining();
        $report->generateOverallComments();
        $report->generateGoals();
        $report->outputExcel();
    }
    
    function dataDump($param = null) {
        $report = new ExcelReport($param["uid"]);
        $report->generateRawDataSheet();
        $report->generateRawPartA();
        $report->generateRawPartB1();
        $report->generateRawPartB2();
        $report->generateTraining();
        $report->generateOverallComments();
        $report->generateGoals();
        $report->outputExcel();
    }
    
    function outputFile($param = null){
       //Init. PHPExcel Plugin
        require_once(ROOT . DS . 'plugin/PHPExcel.php');
        require_once(ROOT . DS . 'plugin/PHPExcel/IOFactory.php');        
        //Create reader and writer
        $reader = PHPExcel_IOFactory::createReader('Excel5');        
        $excelTemplate = $reader->load(ROOT.DS."view".DS."template".DS."PA_Raw.xls");
        $writer = PHPExcel_IOFactory::createWriter($excelTemplate, 'Excel2007');
        //Check right and param.
        $data = new FormData($param['u'], $param['uid']);
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
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="PA Form ('.$formDetail['staff_name'].').xlsx"');
        $writer->save('php://output');
    }
}
