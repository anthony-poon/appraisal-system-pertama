<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of excelReport
 *
 * @author anthony.poon
 */
class ExcelReport {
    //put your code here
    private $workbook;
    private $uid;
    private $summary;
    private $goalData;
    
    public function __construct($uid) {
        require_once(ROOT . DS . 'plugin/PHPExcel.php');
        require_once(ROOT . DS . 'plugin/PHPExcel/IOFactory.php');
        $this->uid = $uid;
        $this->workbook = new PHPExcel();
        $this->workbook->getDefaultStyle()
            ->getAlignment()
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $this->workbook->removeSheetByIndex(0);
        $reportData = new ReportData();
        $userOperator = new UserBatchOperator();
        $emptySurvey = $userOperator->getEmptyUserData($uid);
        $populatedData = $this->populateEmptydata($emptySurvey);
        $this->summary = array_merge($reportData->getFormSummary($uid), $populatedData);

        unset($this->summary['hirotaka.suzuki']);
        unset($this->summary['setsuo.suzuki']);
        unset($this->summary['adam.jiang']);
    }
    
    
    private function populateEmptydata($emptySurveyData){
        $userOperator = new UserBatchOperator();
        $returnArray = array();
        foreach ($emptySurveyData as $data) {
            $temp["form_username"] = $data["username"];
            $temp["staff_name"] = $data["user_full_name"];
            $temp["is_senior"] = $data["is_senior"];
            $temp["staff_position"] = $data["user_position"];
            $temp["staff_department"] = $data["user_department"];
            $temp["staff_office"] = $data["user_office"];
            $temp["appraiser_name"] = $userOperator->getFullNameByUsername($data["appraiser_username"]);
            $temp["countersigner_1_name"] = $userOperator->getFullNameByUsername($data["countersigner_username_1"]);
            $temp["countersigner_name"] = $temp["countersigner_1_name"];
            if (!empty($data["countersigner_username_2"])) {
                $temp["countersigner_2_name"] = $userOperator->getFullNameByUsername($data["countersigner_username_2"]);
                $temp["countersigner_name"] .= " & ".$temp["countersigner_2_name"];
            }
            $temp["part_a_b_total"] = null;
            $temp["part_a_overall_score"] = null;
            $temp["part_b1_overall_score"] = null;
            $temp["part_b2_overall_score"] = null;
            $temp["part_a_total"] = null;
            $temp["part_b_total"] = null;
            $temp["function_training_0_to_1_year"] = null;
            $temp["function_training_1_to_2_year"] = null;
            $temp["function_training_2_to_3_year"] = null;
            $temp["generic_training_0_to_1_year"] = null;
            $temp["generic_training_1_to_2_year"] = null;
            $temp["generic_training_2_to_3_year"] = null;
            $temp["survey_overall_comment"] = null;
            $temp["survey_commencement_date"] = $data["commence_date"];
            $returnArray[$data["username"]] = $temp;
        }
        return $returnArray;
    }
    private function officeNameOrdering($firstElement, $secondElement) {
        // Callback for sorting
        $order = array("HK Senior", "HK Junior", "IMA", "South Africa Office", "China Office", "North Amercia Office"
            , "Korea Office", "Japan Office", "Ukraine Office", "India Office", "Pertama Office");
        $firstIndex = array_search($firstElement, $order);
        $secondIndex = array_search($secondElement, $order);
        return ($firstIndex < $secondIndex) ? -1 : 1;
    }
    private function departmentOrdering($firstElement, $secondElement) {
        // Callback for sorting
        $order = array("COM", "CPD", "FNA", "HRA", "LEG", "LOG", "PCM"
            , "AML China", "AML India", "AML Japan", "AML Korea", "AML NA", "AML SA", "AML Ukraine", "IMA", "Pertama");
        $firstIndex = array_search($firstElement, $order);
        $secondIndex = array_search($secondElement, $order);
        return ($firstIndex < $secondIndex) ? -1 : 1;
    }
    private function getFullOfficeNameByDepartment($department) {
        switch ($department) {
            case 'FNA':
            case 'HRA':
            case 'COM':
            case 'CPD':
            case 'LOG':
            case 'MGT':
            case 'LEG':
            case 'PCM':
                return "Hong Kong Office";
            case 'IMA':
                return "IMA";
            case 'AML SA':
                return "South Africa Office";
            case 'AML China':
                return "China Office";
            case 'AML NA':
                return "North Amercia Office";
            case 'AML Korea':
                return "Korea Office";
            case 'AML Japan':
                return "Japan Office";
            case 'AML Ukraine':
                return "Ukraine Office";
            case 'AML India':
                return "India Office";
            case 'Pertama':
                return "Pertama Office";
        }
        return null;
    }
    
    private function arrayGetColumn($array, $columnName){
        // Legacy support for old PHP version
        $result = array();
        foreach ($array as $arrayItem) {
           array_push($result, $arrayItem[$columnName]);
        }
        return $result;
    }    
    
    public function generateRawDataSheet() {
        $sheet = $this->workbook->createSheet();
        $sheet->setTitle("Raw Data");
        
        $arrayStaffOffice = $this->arrayGetColumn($this->summary, 'staff_office');
        $arrayStaffDepartment = $this->arrayGetColumn($this->summary, 'staff_department');
        $arrayStaffName = $this->arrayGetColumn($this->summary, 'staff_name');        

        array_multisort($arrayStaffOffice, $arrayStaffDepartment, $arrayStaffName, SORT_DESC,$this->summary);       
        $rowOffSet = 1;
        $colOffSet = 0;
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Office");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Department");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Position");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Full Name");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Seniority");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Appraising Officer");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Countersigniner Officer");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Join Date");
        $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, "Part A score\nbefore countersigning");
        $sheet->getStyleByColumnAndRow($colOffSet++, 1)->getAlignment()->setWrapText(true);
        $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, "Part B1 score\nbefore countersigning");
        $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setWrapText(true);
        $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, "Part B2 score\nbefore countersigning");
        $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setWrapText(true);
        $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, "Part A score\nafter countersigning");
        $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setWrapText(true);
        $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, "Part B after\ncountersigning");
        $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setWrapText(true);
        $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, "Final Score");
        
        $rowOffSet += 1;
        foreach ($this->summary as $username => $detail) {
            $colOffSet = 0;
            $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['staff_office']);
            $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['staff_department']);
            $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['staff_position']);
            $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['staff_name']);
            if ($detail['is_senior']) {
                $str = "DGM or above";
            } else {
                $str = "Below DGM";
            }
            $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $str);
            $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['appraiser_name']);
            $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['countersigner_name']);
            $timestemp = strtotime($detail['survey_commencement_date']);
            $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, ceil(PHPExcel_Shared_Date::PHPToExcel($timestemp)));
            $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, $detail['part_a_overall_score']);
            $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, $detail['part_b1_overall_score']);
            $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, $detail['part_b2_overall_score']);
            $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, $detail['part_a_total']);
            $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, $detail['part_b_total']);
            $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, $detail['part_a_b_total']);
            $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $rowOffSet += 1;
        }
        for ($i = 0; $i <= $colOffSet; $i ++) {
            $sheet->getColumnDimensionByColumn($i)->setAutoSize(TRUE);
        }
    }
    
    public function generateTopAndBottom() {
        function filterSeniorHaveScore ($data) {
            return $data['is_senior'] && !empty($data['part_a_b_total']);
        }
        function filterNonSeniorHaveScore ($data) {
            return !$data['is_senior'] && !empty($data['part_a_b_total']);
        }
        $sheet = $this->workbook->createSheet();
        $sheet->setTitle("Group PA Scores (Top30_Btm10)");
        $arrayFinalScore = $this->arrayGetColumn($this->summary, 'part_a_b_total');
        $arrayStaffOffice = $this->arrayGetColumn($this->summary, 'staff_office');
        $arrayStaffDepartment = $this->arrayGetColumn($this->summary, 'staff_department');
        $arrayStaffName = $this->arrayGetColumn($this->summary, 'staff_name');        

        array_multisort($arrayFinalScore, SORT_DESC, $arrayStaffOffice, $arrayStaffDepartment, $arrayStaffName, SORT_DESC,$this->summary);
        $colOffSet = 0;
        $rowOffSet = 1;
        $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, "Deputy General Manager or above");
        $sheet->mergeCellsByColumnAndRow($colOffSet, $rowOffSet, ++$colOffSet,$rowOffSet);
        $rowOffSet += 1;
        $colOffSet = 0;
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "No.");      
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Full Name");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Office");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Position");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Join Date");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Years of Service");
        $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, "Part A score\nbefore countersigning");
        $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setWrapText(true);
        $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, "Part B1 score\nbefore countersigning");
        $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setWrapText(true);
        $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, "Part B2 score\nbefore countersigning");
        $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setWrapText(true);
        $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, "Part A score\nafter countersigning");
        $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setWrapText(true);
        $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, "Part B after\ncountersigning");
        $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setWrapText(true);
        $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, "Final Score");

        $rowOffSet += 1;
        
        $countOfHaveScore = count(array_filter($this->summary, "filterSeniorHaveScore"));
        $topCount = ceil($countOfHaveScore*0.3);        
        $bottomCount = ceil($countOfHaveScore*0.1);
        $count = 0;
        $avgSum = 0;
        $avgCount = 0;
        
        foreach ($this->summary as $index => $detail) {
            if ($detail['is_senior']) {
                $count += 1;
                $colOffSet = 0;
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $count);              
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['staff_name']);
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['staff_office']);
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['staff_position']);                
                $timestamp = strtotime($detail['survey_commencement_date']);
                $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, ceil(PHPExcel_Shared_Date::PHPToExcel($timestamp)));
                $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
                $todayTimeStamp = time();
                $dateDiff = floor(($todayTimeStamp - $timestamp) / (365*60*60*24));
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "$dateDiff Years");
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['part_a_overall_score']);
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['part_b1_overall_score']);
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['part_b2_overall_score']);
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['part_a_total']);
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['part_b_total']);
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['part_a_b_total']);
                if (!empty($detail['part_a_b_total'])){
                    $avgSum += $detail['part_a_b_total'];
                    $avgCount += 1;
                }
                if ($count <= $topCount) {
                    $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, "Top 30%");
                }
                if (($count > $countOfHaveScore - $bottomCount) && ($count <= $countOfHaveScore)) {
                    $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, "Bottom 10%");
                }
                $rowOffSet += 1;
            }
        }
        if ($avgCount) {
            --$colOffSet;
            $sheet->setCellValueByColumnAndRow(--$colOffSet, $rowOffSet, "Average: ");
            $sheet->setCellValueByColumnAndRow(++$colOffSet, $rowOffSet, round($avgSum/$avgCount, 2));
            $rowOffSet += 1;
        }
        $rowOffSet += 1;
        $sheet->setCellValueByColumnAndRow(0, $rowOffSet, "Below Deputy General Manager");
        $sheet->mergeCellsByColumnAndRow(0, $rowOffSet,1, $rowOffSet);
        $rowOffSet += 1;
        
        $countOfHaveScore = count(array_filter($this->summary, "filterNonSeniorHaveScore"));
        $topCount = ceil($countOfHaveScore*0.3);        
        $bottomCount = ceil($countOfHaveScore*0.1);
        $count = 0;
        $avgSum = 0;
        $avgCount = 0;
        $colOffSet = 0;
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "No.");      
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Full Name");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Office");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Position");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Join Date");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Years of Service");
        $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, "Part A score\nbefore countersigning");
        $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setWrapText(true);
        $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, "Part B1 score\nbefore countersigning");
        $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setWrapText(true);
        $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, "Part B2 score\nbefore countersigning");
        $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setWrapText(true);
        $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, "Part A score\nafter countersigning");
        $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setWrapText(true);
        $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, "Part B after\ncountersigning");
        $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setWrapText(true);
        $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, "Final Score");
        $rowOffSet += 1;
        
        foreach ($this->summary as $detail) {
            if (!$detail['is_senior']) {
                $count += 1;
                $colOffSet = 0;
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $count);                
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['staff_name']);
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['staff_office']);
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['staff_position']);                
                $timestamp = strtotime($detail['survey_commencement_date']);
                $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, ceil(PHPExcel_Shared_Date::PHPToExcel($timestamp)));
                $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
                $todayTimeStamp = time();
                $dateDiff = floor(($todayTimeStamp - $timestamp) / (365*60*60*24));
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "$dateDiff Years");
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['part_a_overall_score']);
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['part_b1_overall_score']);
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['part_b2_overall_score']);
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['part_a_total']);
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['part_b_total']);
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['part_a_b_total']);
                if (!empty($detail['part_a_b_total'])){
                    $avgSum += $detail['part_a_b_total'];
                    $avgCount += 1;
                }
                if ($count <= $topCount) {
                    $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, "Top 30%");
                }
                if (($count > $countOfHaveScore - $bottomCount) && ($count <= $countOfHaveScore)) {
                    $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, "Bottom 10%");
                }
                $rowOffSet += 1;                
            }
        }
        if ($avgCount) {
            $sheet->setCellValueByColumnAndRow(--$colOffSet, $rowOffSet, "Average: ");
            $sheet->setCellValueByColumnAndRow(++$colOffSet, $rowOffSet, round($avgSum/$avgCount, 2));
        }
        for ($i = 0; $i <= 14; $i ++) {
            $sheet->getColumnDimensionByColumn($i)->setAutoSize(TRUE);
        }
    }
    
    public function generateByOfficeDepartment() {
        $listOfDepartment = $this->arrayGetColumn($this->summary, 'staff_department');
        foreach ($listOfDepartment as $department) {
            $sortedArray[$department] = array();
        }
        foreach($this->summary as $detail) {
            array_push($sortedArray[$detail['staff_department']], $detail);
        }
        $sheet = $this->workbook->createSheet();
        $sheet->setTitle("PA Score (by Office_By Dept)");
        $rowOffSet = 1;       
        uksort($sortedArray, array($this, 'departmentOrdering'));      
        
        foreach($sortedArray as $departmentName => $departmentData) {
            $avgSum = 0;
            $avgCount = 0;
            $sheet->setCellValueByColumnAndRow(0, $rowOffSet, $this->getFullOfficeNameByDepartment($departmentName));
            $rowOffSet += 1;
            $colOffSet = 0;
            $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Department");            
            $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Full Name");
            $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Position");
            $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Join Date");
            $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Years of Service");
            $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, "Part A score\nbefore countersigning");
            $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setWrapText(true);
            $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, "Part B1 score\nbefore countersigning");
            $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setWrapText(true);
            $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, "Part B2 score\nbefore countersigning");
            $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setWrapText(true);
            $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, "Part A score\nafter countersigning");
            $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setWrapText(true);
            $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, "Part B after\ncountersigning");
            $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setWrapText(true);
            $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, "Final Score");
            for ($i = 0; $i <= $colOffSet; $i ++) {
                $sheet->getStyleByColumnAndRow($i, $rowOffSet)->getBorders()->getBottom()->setBorderStyle(TRUE);
            }
            $rowOffSet += 1;  
            $arrayTotalScore = $this->arrayGetColumn($departmentData, 'part_a_b_total');        
            array_multisort($arrayTotalScore, SORT_DESC, $departmentData);            
            foreach ($departmentData as $detail) {
                $colOffSet = 0;
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['staff_department']);
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['staff_name']);
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['staff_position']);
                $timestamp = strtotime($detail['survey_commencement_date']);
                $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, ceil(PHPExcel_Shared_Date::PHPToExcel($timestamp)));
                $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
                $todayTimeStamp = time();
                $dateDiff = floor(($todayTimeStamp - $timestamp) / (365*60*60*24));
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "$dateDiff Years");
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['part_a_overall_score']);
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['part_b1_overall_score']);
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['part_b2_overall_score']);
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['part_a_total']);
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['part_b_total']);
                $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, $detail['part_a_b_total']);
                if (!empty($detail['part_a_b_total'])){
                    $avgSum += $detail['part_a_b_total'];
                    $avgCount += 1;
                }
                $rowOffSet += 1;
            }
            if ($avgCount) {
                $sheet->setCellValueByColumnAndRow(--$colOffSet, $rowOffSet, "Average: ");
                $sheet->setCellValueByColumnAndRow(++$colOffSet, $rowOffSet, round($avgSum/$avgCount, 2));
                $rowOffSet += 1;
            }
            $rowOffSet += 1;
        }
        for ($i = 0; $i <= $colOffSet; $i ++) {
            $sheet->getColumnDimensionByColumn($i)->setAutoSize(TRUE);
        }
    }
    
    public function generateByOfficeByScore() {
        $sheet = $this->workbook->createSheet();
        $sheet->setTitle("PA Score (by Office_by score)");
        $listOfDepartment = $this->arrayGetColumn($this->summary, 'staff_department');
        foreach ($listOfDepartment as $department) {
            $sortedArray[$this->getFullOfficeNameByDepartment($department)] = array();
        }
        unset($sortedArray['Hong Kong Office']);
        $sortedArray['HK Senior'] = array();
        $sortedArray['HK Junior'] = array();            
        foreach($this->summary as $detail) {
            if ($this->getFullOfficeNameByDepartment($detail['staff_department']) == 'Hong Kong Office') {
                if ($detail['is_senior'] == 1) {
                    array_push($sortedArray['HK Senior'], $detail);
                } else {
                    array_push($sortedArray['HK Junior'], $detail);
                }
            } else {
                array_push($sortedArray[$this->getFullOfficeNameByDepartment($detail['staff_department'])], $detail);
            }
        }
        $rowOffSet = 1;
        uksort($sortedArray, array($this, 'officeNameOrdering'));
        
        foreach($sortedArray as $officeName => $officeData) {
            $avgSum = 0;
            $avgCount = 0;
            if ($officeName == 'HK Senior' || $officeName == 'HK Junior') {
                $sheet->setCellValueByColumnAndRow(0, $rowOffSet, "Hong Kong Office");
            } else {
                $sheet->setCellValueByColumnAndRow(0, $rowOffSet, $officeName);
            }
            $rowOffSet += 1;
            $colOffSet = 0;
            $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Full Name");
            $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Position");
            $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Join Date");
            $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Years of Service");
            $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, "Part A score\nbefore countersigning");
            $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setWrapText(true);
            $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, "Part B1 score\nbefore countersigning");
            $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setWrapText(true);
            $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, "Part B2 score\nbefore countersigning");
            $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setWrapText(true);
            $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, "Part A score\nafter countersigning");
            $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setWrapText(true);
            $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, "Part B after\ncountersigning");
            $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setWrapText(true);
            $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, "Final Score");
            for ($i = 0; $i <= $colOffSet; $i ++) {
                $sheet->getStyleByColumnAndRow($i, $rowOffSet)->getBorders()->getBottom()->setBorderStyle(TRUE);
            }
            $rowOffSet += 1;
            $arrayTotalScore = $this->arrayGetColumn($officeData, 'part_a_b_total');        
            array_multisort($arrayTotalScore, SORT_DESC, $officeData);            
            foreach ($officeData as $detail) {
                $colOffSet = 0;                
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['staff_name']);
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['staff_position']);                
                $timestamp = strtotime($detail['survey_commencement_date']);
                $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, ceil(PHPExcel_Shared_Date::PHPToExcel($timestamp)));
                $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
                $todayTimeStamp = time();
                $dateDiff = floor(($todayTimeStamp - $timestamp) / (365*60*60*24));
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "$dateDiff Years");
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['part_a_overall_score']);
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['part_b1_overall_score']);
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['part_b2_overall_score']);
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['part_a_total']);
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['part_b_total']);
                $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, $detail['part_a_b_total']);
                if (!empty($detail['part_a_b_total'])){
                    $avgSum += $detail['part_a_b_total'];
                    $avgCount += 1;
                }
                $rowOffSet += 1;
            }
            if ($avgCount) {
                $sheet->setCellValueByColumnAndRow(--$colOffSet, $rowOffSet, "Average: ");
                $sheet->setCellValueByColumnAndRow(++$colOffSet, $rowOffSet, round($avgSum/$avgCount, 2));
                $rowOffSet += 1;
            }
            $rowOffSet += 1;
        }
        for ($i = 0; $i <= 13; $i ++) {
            $sheet->getColumnDimensionByColumn($i)->setAutoSize(TRUE);
        }
    }
    
    public function generateRawPartA() {
        $sheet = $this->workbook->createSheet();
        $sheet->setTitle("Part A");
        $reportData = new ReportData();
        $partA = $reportData->getPartAData($this->uid);
        $arrayStaffOffice = $this->arrayGetColumn($this->summary, 'staff_office');
        $arrayStaffDepartment = $this->arrayGetColumn($this->summary, 'staff_department');
        $arrayStaffName = $this->arrayGetColumn($this->summary, 'staff_name');        

        array_multisort($arrayStaffOffice, $arrayStaffDepartment, $arrayStaffName, SORT_DESC,$this->summary);       
        $rowOffSet = 1;
        $colOffSet = 0;
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Office");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Department");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Position");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Full Name");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Responsability");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Result");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Comment by Appraiser");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Weight");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Score");
        $rowOffSet += 1;
        foreach ($this->summary as $username => $detail) {
            $colOffSet = 0;
            $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['staff_office']);
            $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['staff_department']);
            $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['staff_position']);
            $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['staff_name']);
            $offSetAnchor = $colOffSet;
            if (array_key_exists($username, $partA)) {
                $atLeastOneRowAdded = false;
                foreach ($partA["$username"] as $partADetail) {
                    $colOffSet = $offSetAnchor;
                    $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, $partADetail['respon_name']);
                    $sheet->getColumnDimensionByColumn($colOffSet)->setWidth('50');
                    $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setWrapText(true);
                    $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, $partADetail['respon_result']);
                    $sheet->getColumnDimensionByColumn($colOffSet)->setWidth('50');
                    $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setWrapText(true);
                    $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, $partADetail['respon_comment']);
                    $sheet->getColumnDimensionByColumn($colOffSet)->setWidth('50');
                    $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setWrapText(true);
                    $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, $partADetail['respon_weight']);
                    $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, $partADetail['respon_score']);
                    $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    // Check if every cell is empty. Dont go to nest row if they are empty
                    if (!empty($partADetail['respon_name']) || !empty($partADetail['respon_result']) || !empty($partADetail['respon_comment']) || !empty($partADetail['respon_weight'])  || !empty($partADetail['respon_score'])) {
                        $rowOffSet += 1;
                        $atLeastOneRowAdded = true;
                    }
                }
                if (!$atLeastOneRowAdded) {
                    $rowOffSet += 1;
                }
            } else {
                $rowOffSet += 1;
            }
        }
        for ($i = 0; $i <= $colOffSet; $i ++) {
            // Skip autosizing for E to G
            if ($i < 4 || $i > 6) {
                $sheet->getColumnDimensionByColumn($i)->setAutoSize(TRUE);
            }
        }
    }
    
    public function generateRawPartB1() {
        $sheet = $this->workbook->createSheet();
        $sheet->setTitle("Part B1");
        $reportData = new ReportData();
        $partA = $reportData->getPartB1Data($this->uid);
        $arrayStaffOffice = $this->arrayGetColumn($this->summary, 'staff_office');
        $arrayStaffDepartment = $this->arrayGetColumn($this->summary, 'staff_department');
        $arrayStaffName = $this->arrayGetColumn($this->summary, 'staff_name');        

        array_multisort($arrayStaffOffice, $arrayStaffDepartment, $arrayStaffName, SORT_DESC,$this->summary);       
        $rowOffSet = 1;
        $colOffSet = 0;
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Office");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Department");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Position");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Full Name");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Item name");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Example Given by Appraisee");
        $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, "Score Given\nby Appraisee");
        $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setWrapText(true);
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Example Given by Appraiser");
        $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, "Score Given\nby Appraiser");
        $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setWrapText(true);
        $rowOffSet += 1;
        $itemName = array("Teamwork and Support", "Ownership", "Customer Focus", "Initiative", "Attention to Detail"
            , "Problem Solving and Decision Making", "Achieving Results and Compliance", "Communication and Interpersonal");
        foreach ($this->summary as $username => $detail) {
            $colOffSet = 0;
            $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['staff_office']);
            $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['staff_department']);
            $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['staff_position']);
            $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['staff_name']);
            $offSetAnchor = $colOffSet;
            if (array_key_exists($username, $partA)) {
                $atLeastOneRowAdded = false;
                foreach ($partA["$username"] as $index => $partADetail) {
                    $colOffSet = $offSetAnchor;
                    $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $itemName[$index]);
                    $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, $partADetail['self_example']);
                    $sheet->getColumnDimensionByColumn($colOffSet)->setWidth('50');
                    $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setWrapText(true);
                    $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, $partADetail['self_score']);
                    $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, $partADetail['appraiser_example']);
                    $sheet->getColumnDimensionByColumn($colOffSet)->setWidth('50');
                    $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setWrapText(true);
                    $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, $partADetail['appraiser_score']);
                    $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    // Check if every cell is empty. Dont go to nest row if they are empty
                    $rowOffSet += 1;
                }
            } else {
                $rowOffSet += 1;
            }
        }
        for ($i = 0; $i <= $colOffSet; $i ++) {
            // Skip autosizing for E and G
            if ($i != 5 && $i != 7) {
                $sheet->getColumnDimensionByColumn($i)->setAutoSize(TRUE);
            }
        }
    }
    
    public function generateRawPartB2() {
        $sheet = $this->workbook->createSheet();
        $sheet->setTitle("Part B2");
        $reportData = new ReportData();
        $partA = $reportData->getPartB2Data($this->uid);
        $arrayStaffOffice = $this->arrayGetColumn($this->summary, 'staff_office');
        $arrayStaffDepartment = $this->arrayGetColumn($this->summary, 'staff_department');
        $arrayStaffName = $this->arrayGetColumn($this->summary, 'staff_name');        

        array_multisort($arrayStaffOffice, $arrayStaffDepartment, $arrayStaffName, SORT_DESC,$this->summary);       
        $rowOffSet = 1;
        $colOffSet = 0;
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Office");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Department");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Position");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Full Name");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Item name");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Example Given by Appraisee");
        $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, "Score Given\nby Appraisee");
        $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setWrapText(true);
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Example Given by Appraiser");
        $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, "Score Given\nby Appraiser");
        $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setWrapText(true);
        $rowOffSet += 1;
        $itemName = array("Influence, Negotiation and Persuasion", "Coaching and Developing", "Leadership and Strategic Thinking");
        foreach ($this->summary as $username => $detail) {
            if ($detail["is_senior"]) {
                $colOffSet = 0;
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['staff_office']);
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['staff_department']);
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['staff_position']);
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['staff_name']);
                $offSetAnchor = $colOffSet;
                if (array_key_exists($username, $partA)) {
                    $atLeastOneRowAdded = false;
                    foreach ($partA["$username"] as $index => $partADetail) {
                        $colOffSet = $offSetAnchor;
                        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $itemName[$index]);
                        $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, $partADetail['self_example']);
                        $sheet->getColumnDimensionByColumn($colOffSet)->setWidth('50');
                        $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setWrapText(true);
                        $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, $partADetail['self_score']);
                        $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, $partADetail['appraiser_example']);
                        $sheet->getColumnDimensionByColumn($colOffSet)->setWidth('50');
                        $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setWrapText(true);
                        $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, $partADetail['appraiser_score']);
                        $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        // Check if every cell is empty. Dont go to nest row if they are empty
                        $rowOffSet += 1;
                    }
                } else {
                    $rowOffSet += 1;
                }
            }
        }
        for ($i = 0; $i <= $colOffSet; $i ++) {
            // Skip autosizing for E and G
            if ($i != 5 && $i != 7) {
                $sheet->getColumnDimensionByColumn($i)->setAutoSize(TRUE);
            }
        }
    }
    
    public function generateOverallComments() {
        $sheet = $this->workbook->createSheet();
        $sheet->setTitle("Overall Comments");
        $arrayStaffOffice = $this->arrayGetColumn($this->summary, 'staff_office');
        $arrayIsSenior = $this->arrayGetColumn($this->summary, 'is_senior');
        array_multisort($arrayStaffOffice, $arrayIsSenior, $this->summary);
        $rowOffSet = 1;
        $colOffSet = 0;
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Office");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Appraisee");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Appraising Officers");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Comments");
        $rowOffSet += 1;        
        foreach ($this->summary as $detail) {
            $colOffSet = 0;
            $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['staff_office']);
            $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['staff_name']);
            $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['appraiser_name']);
            $sheet->setCellValueByColumnAndRow($colOffSet, $rowOffSet, $detail['survey_overall_comment']);
            $sheet->getStyleByColumnAndRow($colOffSet++, $rowOffSet)->getAlignment()->setWrapText(true);
            $rowOffSet += 1;
        }
        for ($i = 0; $i < $colOffSet; $i ++) {
            $sheet->getColumnDimensionByColumn($i)->setAutoSize(TRUE);
        }
    }
    
    public function generateTraining() {
        $sheet = $this->workbook->createSheet();
        $sheet->setTitle("TNA");
        $arrayStaffOffice = $this->arrayGetColumn($this->summary, 'staff_office');
        $arrayStaffName = $this->arrayGetColumn($this->summary, 'is_senior');
        array_multisort($arrayStaffOffice, $arrayStaffName, $this->summary);
        $rowOffSet = 1;
        $sheet->setCellValueByColumnAndRow(3, $rowOffSet, "Functional Training Needs");
        $sheet->setCellValueByColumnAndRow(6, $rowOffSet, "Generic Training Needs");
        $sheet->mergeCellsByColumnAndRow(3,1,5,1);
        $rowOffSet += 1;
        $colOffSet = 0;
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Office/Department");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Staff Name");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Position");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "0-1 year");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "1-2 year");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "2-3 year");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "0-1 year");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "1-2 year");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "2-3 year");
        $rowOffSet += 1;
        foreach ($this->summary as $detail) {
            $colOffSet = 0;
            $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['staff_office']);
            $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['staff_name']);
            $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['staff_position']);
            $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['function_training_0_to_1_year']);
            $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['function_training_1_to_2_year']);
            $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['function_training_2_to_3_year']);
            $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['generic_training_0_to_1_year']);
            $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['generic_training_1_to_2_year']);
            $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['generic_training_2_to_3_year']);
            $rowOffSet += 1;
        }
        for ($i = 0; $i < $colOffSet; $i ++) {
            $sheet->getColumnDimensionByColumn($i)->setAutoSize(TRUE);
        }
        
    }
    
    public function generateGoals() {
        $sheet = $this->workbook->createSheet();
        $sheet->setTitle("Goals");
        $reportData = new ReportData();
        $goalData = $reportData->getGoalData($this->uid);
        foreach ($goalData as $username => $detail) {
            $this->summary[$username]['part_d'] = $detail;
        }
        $rowOffSet = 1;
        $colOffSet = 0;
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Office");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Appraisee");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Appraising Officers");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Key Responsibilities");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Goals");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Measurements");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Weight");
        $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Completion Date");
        $rowOffSet += 1;
        $maxCol = 0;
        foreach ($this->summary as $detail) {      
            if (!empty($detail['part_d'])) {
                foreach ($detail['part_d'] as $entries) {
                    $colOffSet = 0;
                    $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['staff_office']);
                    $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['staff_name']);
                    $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['appraiser_name']);
                    $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $entries['key_respon']);
                    $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $entries['goal_name']);
                    $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $entries['measurement_name']);
                    $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $entries['goal_weight']);
                    $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $entries['complete_date']);
                    $rowOffSet += 1;
                }
            } else {
                $colOffSet = 0;    
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['staff_office']);
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['staff_name']);
                $sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, $detail['appraiser_name']);
                //$sheet->setCellValueByColumnAndRow($colOffSet++, $rowOffSet, "Null");
                $rowOffSet += 1;
            }
            if ($colOffSet > $maxCol) {
                $maxCol = $colOffSet;
            }
        }
        for ($i = 0; $i < $maxCol; $i ++) {
            $sheet->getColumnDimensionByColumn($i)->setAutoSize(TRUE);
        }
    }
    
    public function outputExcel(){
        $this->workbook->setActiveSheetIndex(0);
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="report.xlsx"');
        $writer = PHPExcel_IOFactory::createWriter($this->workbook, 'Excel2007');
        $writer->save('php://output');
    }
}