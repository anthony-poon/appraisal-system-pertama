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
        if (!$this->user->isAdmin && !$this->user->isReportUser) {
            header("Location: survey");
        }
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
        $param['emptySurvey'] = array_diff_key($userList, $param['data']);
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
            $data = new reportData($param['uid']);
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
    
    function outputFile($objPHPExcel){
        $result = $this->isAdmin();
        require_once(ROOT . DS . 'plugin/PHPExcel.php');
        require_once(ROOT . DS . 'plugin/PHPExcel/IOFactory.php');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Anthony Poon")
                ->setTitle("PA Form Output");
        $objPHPExcel->getActiveSheet()->setTitle('Raw Data');
        $this->outputFile($objPHPExcel);
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="PA Form Output.xlsx"');
        ob_end_clean();
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
    
    function testing() {
        $result = $this->isAdmin();
        $userOperator = new userBatchOperator();
        var_dump($userOperator->getUserFullData());
    }
}
