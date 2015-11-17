-- phpMyAdmin SQL Dump
-- version 4.0.10
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 27, 2015 at 10:31 AM
-- Server version: 5.0.75-0ubuntu10.5
-- PHP Version: 5.2.6-3ubuntu4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pa_survey`
--
CREATE DATABASE IF NOT EXISTS `pa_survey` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `pa_survey`;

-- --------------------------------------------------------

--
-- Table structure for table `pa_form_data`
--

CREATE TABLE IF NOT EXISTS `pa_form_data` (
  `form_username` varchar(64) collate utf8_unicode_ci NOT NULL,
  `survey_uid` int(11) NOT NULL,
  `staff_name` varchar(64) collate utf8_unicode_ci default NULL,
  `is_senior` tinyint(1) NOT NULL default '0',
  `staff_department` varchar(64) collate utf8_unicode_ci default NULL,
  `staff_position` varchar(64) collate utf8_unicode_ci default NULL,
  `staff_office` varchar(64) collate utf8_unicode_ci default NULL,
  `appraiser_name` varchar(64) collate utf8_unicode_ci default NULL,
  `countersigner_name` varchar(64) collate utf8_unicode_ci default NULL,
  `countersigner_1_name` varchar(64) collate utf8_unicode_ci default NULL,
  `countersigner_2_name` varchar(64) collate utf8_unicode_ci default NULL,
  `survey_commencement_date` varchar(64) collate utf8_unicode_ci default NULL,
  `survey_period` varchar(64) collate utf8_unicode_ci NOT NULL,
  `survey_type` varchar(64) collate utf8_unicode_ci default NULL,
  `part_a_overall_score` float default NULL,
  `countersigner_1_part_a_score` float default NULL,
  `countersigner_2_part_a_score` float default NULL,
  `part_a_total` float default NULL,
  `part_b1_overall_comment` mediumtext collate utf8_unicode_ci,
  `part_b1_overall_score` float default NULL,
  `part_b2_overall_comment` mediumtext collate utf8_unicode_ci,
  `part_b2_overall_score` float default NULL,
  `countersigner_1_part_b_score` float default NULL,
  `countersigner_2_part_b_score` float default NULL,
  `part_b_total` float default NULL,
  `part_a_b_total` float default NULL,
  `prof_competency_1` varchar(256) collate utf8_unicode_ci default NULL,
  `prof_competency_2` varchar(256) collate utf8_unicode_ci default NULL,
  `prof_competency_3` varchar(256) collate utf8_unicode_ci default NULL,
  `core_competency_1` varchar(256) collate utf8_unicode_ci default NULL,
  `core_competency_2` varchar(256) collate utf8_unicode_ci default NULL,
  `core_competency_3` varchar(256) collate utf8_unicode_ci default NULL,
  `on_job_0_to_1_year` varchar(256) collate utf8_unicode_ci default NULL,
  `on_job_1_to_2_year` varchar(256) collate utf8_unicode_ci default NULL,
  `on_job_2_to_3_year` varchar(256) collate utf8_unicode_ci default NULL,
  `function_training_0_to_1_year` varchar(256) collate utf8_unicode_ci default NULL,
  `function_training_1_to_2_year` varchar(256) collate utf8_unicode_ci default NULL,
  `function_training_2_to_3_year` varchar(256) collate utf8_unicode_ci default NULL,
  `generic_training_0_to_1_year` varchar(256) collate utf8_unicode_ci default NULL,
  `generic_training_1_to_2_year` varchar(256) collate utf8_unicode_ci default NULL,
  `generic_training_2_to_3_year` varchar(256) collate utf8_unicode_ci default NULL,
  `survey_overall_comment` mediumtext collate utf8_unicode_ci,
  `is_final_by_self` tinyint(1) NOT NULL default '0',
  `is_final_by_appraiser` tinyint(1) NOT NULL default '0',
  `is_confirmed_by_self_after_final` tinyint(1) NOT NULL default '0',
  `is_confirmed_by_app_after_final` tinyint(1) NOT NULL default '0',
  `is_recently_changed_by_self` tinyint(1) NOT NULL default '0',
  `is_recently_changed_by_app` tinyint(1) NOT NULL default '0',
  `is_final_by_counter1` tinyint(1) NOT NULL default '0',
  `is_final_by_counter2` tinyint(1) NOT NULL default '0',
  `is_locked` tinyint(1) NOT NULL default '0',
  `last_modify` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`form_username`,`survey_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pa_form_data`
--

INSERT INTO `pa_form_data` (`form_username`, `survey_uid`, `staff_name`, `is_senior`, `staff_department`, `staff_position`, `staff_office`, `appraiser_name`, `countersigner_name`, `countersigner_1_name`, `countersigner_2_name`, `survey_commencement_date`, `survey_period`, `survey_type`, `part_a_overall_score`, `countersigner_1_part_a_score`, `countersigner_2_part_a_score`, `part_a_total`, `part_b1_overall_comment`, `part_b1_overall_score`, `part_b2_overall_comment`, `part_b2_overall_score`, `countersigner_1_part_b_score`, `countersigner_2_part_b_score`, `part_b_total`, `part_a_b_total`, `prof_competency_1`, `prof_competency_2`, `prof_competency_3`, `core_competency_1`, `core_competency_2`, `core_competency_3`, `on_job_0_to_1_year`, `on_job_1_to_2_year`, `on_job_2_to_3_year`, `function_training_0_to_1_year`, `function_training_1_to_2_year`, `function_training_2_to_3_year`, `generic_training_0_to_1_year`, `generic_training_1_to_2_year`, `generic_training_2_to_3_year`, `survey_overall_comment`, `is_final_by_self`, `is_final_by_appraiser`, `is_confirmed_by_self_after_final`, `is_confirmed_by_app_after_final`, `is_recently_changed_by_self`, `is_recently_changed_by_app`, `is_final_by_counter1`, `is_final_by_counter2`, `is_locked`, `last_modify`) VALUES
('adriaan.rossouw', 1, 'Adriaan Rossouw', 0, 'AML SA', 'Project Development Manager', 'South Africa', 'Conri Moolman', 'Hirotaka Suzuki', 'Hirotaka Suzuki', NULL, '2014-12-01', 'March 2015', 'Annual Appraisal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2015-03-26 13:28:38'),
('amy.ong', 1, 'Amg Ong', 0, 'Pertama (HRA)', 'Human Resources Manager', 'Pertama', 'Steven Chang', '', NULL, NULL, '2012-11-12', 'March 2015', 'Annual Appraisal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2015-03-25 01:18:49'),
('andrew.talling', 1, 'Andre Talling', 1, NULL, 'General Manager', 'Pertama', 'Hirotaka Suzuki', 'Setsuo Suzuki', 'Setsuo Suzuki', NULL, '2013-05-20', 'March 2015', 'Annual Appraisal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2015-03-25 04:32:32'),
('anthony.poon', 1, 'Anthony Poon', 0, 'HRA', 'Assistant IT Officer', 'Hong Kong', 'Frankie Chung', 'Carrie Chung', 'Carrie Chung', NULL, '2013-09-10', 'March 2015', 'Annual Appraisal', 3, NULL, NULL, 3, 'No comments.', 3, NULL, NULL, NULL, NULL, 3, 3, 'Company Operation Flow', NULL, NULL, 'Attention to Detail', 'Achieving Results and Compliance', 'Nil', 'Training 1', 'Training 2', 'Training 3', 'Legal Knowledge on Data Protection', 'Data Protection knowledge in Human Resources Management', 'Nil', 'Time Management Skills', 'Creative Problem Solving and Decision Making Skills', 'Nil', 'No comment.', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2015-03-26 03:54:48'),
('carrie.chung', 1, 'Carrie Chung', 0, 'HRA', 'Manager', 'Hong Kong', 'Celia Law', 'Vivien Chan', 'Vivien Chan', NULL, '2004-08-18', 'March 2015', 'Annual Appraisal', 3.15, NULL, NULL, 3.15, 'No further comment.', 3.88, NULL, NULL, NULL, NULL, 3.88, 3.51, 'nil', NULL, NULL, 'Problem Solving and Decision Making', 'Coaching and Developing', NULL, 'nil', 'nil', 'nil', '國內人力資源法律法規更新及證書真偽認證', 'Project Management Skills: The Fundamentals and Process', 'Finance Knowledge for Non-Finance People (General)', 'MS Excel Skills for Expert User', 'Leadership Skills For Supervisor', 'Nil', 'I am more than happy to have two open minded supervisors to lead me and give me many good on-the-job training to further develop my HR skills.\n\n\nFrom Celia to Carrie:\nCarrie is a quick learner and is able to put across her recommendations and ideas sensibly and logically. Apart from demonstrating sound analytical power in daily works, she also demonstrates a good understanding of the operations in HRA by assisting the managers to monitor and maintain the quality works.\n\nCarrie works independently, is committed and shows determination to achieve results with good quality. In view of her quality works in these months, there is no doubt that Carrie has fully met the performance requirements in quality and quantity.\n\nIn the coming year, it was expected Carrie as a HRA Manager can contributing further in supervising the subordinates with higher effectiveness and efficiency while assisting the superiors to implement various projects and annual plan for HRA.', 1, 1, 0, 0, 0, 0, 0, 0, 0, '2015-03-23 02:32:39'),
('celia.law', 1, 'Celia Law', 0, 'HRA', 'Senior Manager', 'Hong Kong', 'Vivien Chan', 'Setsuo Suzuki', 'Setsuo Suzuki', NULL, '2014-03-24', 'March 2015', 'Annual Appraisal', 3.85, NULL, NULL, 3.85, 'Celia is a great team player and encourages effective communication within HRA.  Has a professional attitude with other co-workers which reflects productivity in her work. I appreciate this dignified demeanor.\n\nHas potential to take up extra duties on strategic HR planning for the whole Group.', 3.75, NULL, NULL, NULL, NULL, 3.75, 3.8, 'Global assignment and practices', 'Change Management', NULL, 'Leadership and Strategic Thinking', NULL, NULL, 'Alignment with AML cultural values and management philosophies', NULL, NULL, 'Business Operations Knowledge (Production / Acquisition / Developing Mines and Smelting Plants)', 'Quality System Control and Management', NULL, NULL, NULL, NULL, 'Celia encourages active communication within her team members and her professional attitude with other co-workers which reflects productivity in her work and I appreciate this dignified demeanor.  Very good on follow up and attention to details and her speed and efficiency is an inspirational example to others.\n\nHas potential to take up more high level managerial role and act as strategic partner for the top management.', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2015-03-24 03:02:28'),
('dmitriy.nadtochiy', 1, 'Dmitriy Nadtochiy', 1, 'COM', 'General Manager', 'Hong Kong', 'Setsuo Suzuki', 'Hirotaka Suzuki', 'Hirotaka Suzuki', NULL, '2007-10-01', 'March 2015', 'Annual Appraisal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2015-03-18 07:52:50'),
('frankie.chung', 1, 'Frankie Chung', 0, 'HRA', 'IT Officer', 'Hong Kong', 'Carrie Chung', 'Celia Law', 'Celia Law', NULL, '2012-08-01', 'March 2015', 'Annual Appraisal', 3.5, NULL, NULL, 3.5, 'No other comments.', 3.63, NULL, NULL, NULL, NULL, 3.63, 3.57, 'IT Audit', NULL, NULL, 'Initiative', 'Attention to Detail', NULL, 'Nil', 'Nil', 'Nil', 'Project Management Skills: The Fundamentals and Process', 'Nil', 'Nil', 'Time Management Skills', 'Writing Skills for Business', 'Nil', 'I like Carrie very much, she is look like a "company dictionary" in AML. I also believe she will always back me up.\nFor my career development, I like to have a chance of promotion, because I have confidence to lead "a small IT team" to bring more benefit to company and users.\n\nFrom Carrie to Frankie:\nFrankie is always positive and serve all levels of colleagues with high quality service manner. He is definitely a good teammate to work with. His breakthrough in recent 3 months on leading & completing the ad-hoc projects (online PA form and ESS) with good quality are recognized. He is potential to move up the career ladder, but subject to the opening of next position in the company in near future as well as his continuous good achievements to be made in the coming years.', 1, 1, 0, 0, 0, 0, 0, 0, 0, '2015-03-24 09:02:55'),
('frankie.ho', 1, 'Frankie Ho', 1, 'COM', 'Deputy General Manager', 'Hong Kong', 'Dmitriy Nadtochiy', 'Setsuo Suzuki', 'Setsuo Suzuki', NULL, '2011-07-25', 'March 2015', 'Annual Appraisal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No Comments', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2015-03-23 07:25:17'),
('hidemi.hirasawa', 1, 'Hidemi Hirasawa', 0, 'AML Japan', 'Administration Clerk', 'Japan', NULL, 'Daijiro Murai', 'Daijiro Murai', NULL, '2012-08-06', 'March 2015', 'Annual Appraisal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2015-03-27 00:30:54'),
('jay.cho', 1, 'Jay Cho', 1, 'AML NA', 'President', 'USA', 'Setsuo Suzuki', 'Hirotaka Suzuki', 'Hirotaka Suzuki', NULL, '2007-07-27', 'March 2015', 'Annual Appraisal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2015-03-26 13:18:44'),
('kenny.chan', 1, 'Kenny Chan', 0, 'FNA', 'Assistant Accountant', 'Hong Kong', 'Mark Lam', 'Kenny Kwan', 'Kenny Kwan', NULL, '2010-03-15', 'March 2015', 'Annual Appraisal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2015-03-26 10:19:25'),
('shirla.kwan', 1, 'Shirla Kwan', 0, 'HRA', 'Human Resources Supervisor', 'Hong Kong', 'Carrie Chung', 'Celia Law', 'Celia Law', NULL, '2008-07-21', 'March 2015', 'Annual Appraisal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No comment', 1, 0, 0, 0, 1, 0, 0, 0, 0, '2015-03-26 07:51:25'),
('soohyun.song', 1, 'Soo Hyun Song', 0, 'AML Japan', 'Sales & Purchase Manager', 'Korea', 'Nam Keuk Kim', 'Setsuo Suzuki', 'Setsuo Suzuki', NULL, '2013-01-07', 'March 2015', 'Annual Appraisal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2015-03-26 23:38:43'),
('subhendu.ghosh', 1, 'Subhendu Ghosh', 0, 'AML India', 'Assistant General Manager', 'India', 'Gautam Kumar', 'Setsuo Suzuki', 'Setsuo Suzuki', NULL, '2008-10-01', 'March 2015', 'Annual Appraisal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2015-03-26 13:21:38'),
('suky.lai', 1, 'Suky Lai', 0, 'HRA', 'Secretary', 'Hong Kong', 'Carrie Chung', 'Celia Law', 'Celia Law', NULL, '2006-07-11', 'March 2015', 'Annual Appraisal', 3.3, NULL, NULL, 3.3, 'No other comments.', 3.13, NULL, NULL, NULL, NULL, 3.13, 3.22, NULL, NULL, NULL, 'Ownership', 'Initiative', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Self Leadership Skills', 'Writing Skills on Clear Actionable Emails', NULL, 'I also provide secretarial and administration support to all colleagues (any reasonable enquiry) unless I am not available/able to help.\n\nLooking forward for a good result of the salary review on 2015.', 1, 0, 0, 0, 0, 0, 0, 0, 0, '2015-03-26 03:27:26'),
('tommy.to', 1, 'Tommy To', 0, 'FNA', 'Accounting Clerk', 'Hong Kong', 'Eric Chan', 'Kenny Kwan', 'Kenny Kwan', NULL, '2013-08-07', 'March 2015', 'Annual Appraisal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2015-03-26 10:20:11'),
('vivien.chan', 1, 'Vivien Chan', 1, 'HRA', 'General Manager', 'Hong Kong', 'Setsuo Suzuki', 'Hirotaka Suzuki', 'Hirotaka Suzuki', NULL, '2008-06-23', 'March 2015', 'Annual Appraisal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2015-03-11 08:30:07'),
('youwei.tang', 1, 'Youwei Tang', 0, 'AML China', 'Finance Manager', 'China', 'Linda Xiong', 'Han Cao', 'Han Cao', NULL, '2009-08-17', 'March 2015', 'Annual Appraisal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2015-03-27 01:18:10'),
('yunjung.lee', 1, 'Yun Jung Lee', 0, 'AML Japan', 'Accountant / Sales Administrator', 'Korea', 'Nam Keuk Kim', 'Setsuo Suzuki', 'Setsuo Suzuki', NULL, '2010-03-09', 'March 2015', 'Annual Appraisal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2015-03-26 23:58:09');

-- --------------------------------------------------------

--
-- Table structure for table `pa_form_period`
--

CREATE TABLE IF NOT EXISTS `pa_form_period` (
  `uid` int(11) NOT NULL auto_increment,
  `survey_period` varchar(64) collate utf8_unicode_ci NOT NULL,
  `survey_type` varchar(64) collate utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL default '0',
  `last_modify` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`uid`),
  UNIQUE KEY `survey_period` (`survey_period`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `pa_form_period`
--

INSERT INTO `pa_form_period` (`uid`, `survey_period`, `survey_type`, `is_active`, `last_modify`) VALUES
(1, 'March 2015', 'Annual Appraisal', 1, '2015-03-11 08:02:33');

-- --------------------------------------------------------

--
-- Table structure for table `pa_part_a`
--

CREATE TABLE IF NOT EXISTS `pa_part_a` (
  `form_username` varchar(64) collate utf8_unicode_ci NOT NULL,
  `survey_uid` int(11) NOT NULL,
  `question_no` int(11) NOT NULL,
  `respon_name` mediumtext collate utf8_unicode_ci,
  `respon_result` mediumtext collate utf8_unicode_ci,
  `respon_comment` mediumtext collate utf8_unicode_ci,
  `respon_weight` int(11) default NULL,
  `respon_score` int(11) default NULL,
  `last_modify` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`form_username`,`survey_uid`,`question_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pa_part_a`
--

INSERT INTO `pa_part_a` (`form_username`, `survey_uid`, `question_no`, `respon_name`, `respon_result`, `respon_comment`, `respon_weight`, `respon_score`, `last_modify`) VALUES
('adriaan.rossouw', 1, 1, NULL, NULL, NULL, NULL, NULL, '2015-03-26 13:28:38'),
('adriaan.rossouw', 1, 2, NULL, NULL, NULL, NULL, NULL, '2015-03-26 13:28:38'),
('adriaan.rossouw', 1, 3, NULL, NULL, NULL, NULL, NULL, '2015-03-26 13:28:38'),
('amy.ong', 1, 1, NULL, NULL, NULL, NULL, NULL, '2015-03-25 01:18:49'),
('amy.ong', 1, 2, NULL, NULL, NULL, NULL, NULL, '2015-03-25 01:18:49'),
('amy.ong', 1, 3, NULL, NULL, NULL, NULL, NULL, '2015-03-25 01:18:49'),
('amy.ong', 1, 4, NULL, NULL, NULL, NULL, NULL, '2015-03-25 03:22:25'),
('andrew.talling', 1, 1, NULL, NULL, NULL, NULL, NULL, '2015-03-25 04:32:32'),
('andrew.talling', 1, 2, NULL, NULL, NULL, NULL, NULL, '2015-03-25 04:32:32'),
('andrew.talling', 1, 3, NULL, NULL, NULL, NULL, NULL, '2015-03-25 04:32:32'),
('anthony.poon', 1, 1, 'Troubleshoot and support users', 'a', 'a', 30, 3, '2015-03-26 06:48:53'),
('anthony.poon', 1, 2, 'Archiving Documents for OPS/COM', 'b', 'Agreed.', 30, 3, '2015-03-26 06:48:55'),
('anthony.poon', 1, 3, 'IT Procurement', 'c', 'c', 40, 3, '2015-03-26 06:48:59'),
('carrie.chung', 1, 1, 'Fulfill the obligations (HRA related) of the two critical services agreements signed with KMR ("Technical Services Agreement" and "Distribution Agreement").', '(i) KMR Board approved Skills Transfer Training Plan is executed in regards to the plan in Q1 of FY2014/15; however, the thereafter plan has yet to implement as the trainees are not available.\n\n(ii) Assisted & guided the KMR staff to have completed the majority set (about 80%) of Company Policy & Procedures for KMR.', 'Although the implementation is out of AML control but Carrie is recommended to be more proactive in requesting for monthly progress report for overview and monitoring by management.', 20, 3, '2015-03-19 08:33:37'),
('carrie.chung', 1, 2, 'Enhanced the current performance management system in order to build a more fair and more objective tool to identify high and low performers for next annual performance appraisal cycle, so as for further development and retention of  the high performers in next financial year.', 'Related  procedures and Performance Appraisal forms were updated and communication session to all staff in AML Group were delivered as per schedule.', 'Carrie provides timely and dedicated support in drafting the related policy and forms. HR communication sessions were also successfully done as scheduled with most of the concerns recorded and addressed.', 20, 3, '2015-03-19 08:24:06'),
('carrie.chung', 1, 3, 'Ensure all the mandatory training needs of the staff (whole AML Group excluding IMA) are fulfillled and the training objectives are achieved.', '(i) Related procedures and training evaluation forms have not been updated and the existing one are retained same as they are still practical  for use in the current circumstances.\n(ii)The Supervisor\\''s training evaluation scores given to the Employees (Trainees) within this financial year reached an average of 76% of the full marks.', 'No further comment', 15, 3, '2015-03-19 09:16:02'),
('carrie.chung', 1, 4, 'HRA procedures are updated timely and always in line with the current practices.', 'One (1) Non-Compliance (NC) point was rated in internal audit and none NC rated in the external ISO9001 assessment in relation to HRA area.', 'Carrie shows good understanding of the HRA procedures and ISO requirements with strong sense and insight for continuous improvement e.g. proactive suggestions for improvement in terms of forms.', 5, 4, '2015-03-19 08:30:28'),
('carrie.chung', 1, 5, 'Maintain the ISO9001 accreditation for the Company for the year', 'No Non-Compliance (NC) point in external ISO9001 assessment in relation to HRA area.', 'Carrie is competent to review workflow and identify areas for improvement. She identifies and anticipates potential problems of current workflow and recommended for changes in due course.', 5, 5, '2015-03-19 08:38:03'),
('carrie.chung', 1, 6, 'HRIS - Systemize all the Employee''s personnel profiles as well as streamline the workflow on leave management and payroll & MPF administration.', 'Due to the latest company business situation changed and could not grant new budget to support for this new system development, such HRIS project was put on hold.', 'No further comment', 5, 3, '2015-03-19 08:32:01'),
('carrie.chung', 1, 7, 'Lead and develop the subordinate to perform and grow.', 'Clear individual objectives were set to my direct report and further guidance had been provided to them to get the job done by themselves (e.g. development of online PA form, Office Supplies/Travel Agent vendors\\'' annual review, etc.).', 'Carrie shows readiness to work as a team member and able to strengthen cooperation among the staff. \n\nShe is recommended to be more sensitive to the needs of subordinates and more proactive to promote harmonious team spirit.', 30, 3, '2015-03-19 08:42:14'),
('celia.law', 1, 1, 'Support Pertama Project:\n\n1.1) To monitor the Pertama local HR team to execute the Manpower Plan and ensure sufficient workforce are recruited and on board before production commencement date.\n\n1.2) Lead the Pertama local HR Team to set up Learning & Development Plan, complete the training materials and ensure the recruited workforce are well trained before work.\n', '1/ Two Face to Face Meetings with Pertama HR were coordinated and attended in July 2014 and Mar 2015;\n\n2/ Draft employee Handbook for Pertama was also reviewed and commented for their continuous improvement; \n\n3/ Senior recruitment with various interviews for the replacement of Pertama HRA were arranged with suitable candidates appointed for Pertama w.e.f. Mar 2015.\n\n4/ Professional HR advise and further manpower support from identification, sourcing, planning, budgeting, scheduling and oversea interviews are ongoing throughout the last financial year;\n\n5/ A master Training Implementation Plan and Schedules for production team of Pertama was drafted and proposed; Pertama HR was also briefed in the first face to face meeting and invited to keep them updated in alignment with the changes of recruitment timeline; and\n\n6/ To keep management updated on the HR progress, a regular follow up through telcon / email were arranged though responses and follow up from Pertama were not upto expectations. ', 'Possesses professional HR skills in Pertama Project such as Training and manpower planning. The utilization of these skills lead to an optimum level for Pertama is evident from her performance.\n\nSuggest Celia to communicate with local HR team in a regular basis to ensure they are following Head Office direction and exchange ideas and share HR skills.', 40, 4, '2015-03-24 02:32:34'),
('celia.law', 1, 2, 'Performance Management Revamp: \nReview the current performance management system and develop a more fair and more objective tool to identify high and low performers for next annual performance appraisal cycle, so as for further development and retention of  the high performers in next financial year.', '1/ To be more objective and specific in PA, the 2013 PA System was fully reviewed, revamped and communicated in HR communication sessions with the following changes:\na) addition of counter signer;\nb) Simplification of competencies;\nc) Develop definition by score level;\nd) Request for examples to support your rating;\ne) Calibrate the PA scores among the team with a bell curve; and\nf) Support development of High and Low performers;\n\n2/ The core principles and new PA form was also extended for mid year appraisal and passage of probation while affiliates such as IMA, KMR and Pertama were also briefed for consideration and alignment so all offices have common language and understanding in managing their staff performance;\n\n3/ For ease data consolidation and analysis, the excel PA form was transformed from hard copy to online with technical support from IT team and coordination by HRA manager;\n\n4/ To uphold the management principle of "Pay For Performance", top 30% high performers identified would be granted more opportunities of career development while the bottom 10% low performers would be requested for improvement or else demotion/termination would be applied. \n\n5/ Incentive Scheme was also proposed for consideration by management;\n\n6/ Related parts in Employee Handbook and forms were reviewed, updated and launched with major support from HRA manager.', 'Takes initiative to evaluate the current PA system and made sensible solutions to become more objective. The new changes of the PA will bring significant improvement to all (both employee and management) in terms of quality and efficiency.', 30, 4, '2015-03-20 03:33:49'),
('celia.law', 1, 3, 'Learning and Development Revamp:\nReview and enhance the learning and development system for AML group, in order to facilitate staff development and performance improvement  in terms of competency\n', '1/ With reference to 2013 PA records, a AML Master Training Programs List was recommended and developed; \n\n2/ During the last mid year PA, Training Needs Review and nomination for AML group was invited and managed with support from HRA manager;\n\n3/ Related Training policy and procedures in  AML Employee Handbook and forms were also reviewed, updated and launched with major support from HRA manager.', 'HRA coordinated training programs according to 2013 PA records. However, can''t see positive feedback from department heads about value added after those training.  Improvements on training needs survey is essential for our situation.', 15, 3, '2015-03-24 02:34:19'),
('celia.law', 1, 4, 'Staff Development:\nLead and develop the subordinate to perform and grow', '1/ In alignment with the departmental goals, the Individual Quality Objectives for HRA team members were developed and communicated; \n\n2/ Specific goals, measurement details, deliverable, weighting and target completion date were set with major support from HRA manager; \n\n3/ To closely monitor the overall department implementation / action plan, an annual HRA plan with non-routine tasks and milestones were set, scheduled while progress were checked / reminded during our regular team meeting. Subject to the management, biz needs and priorities, the annual planning would be updated accordingly and shared with related team members timely.', 'Very well done on the design and set up of specific goals for all team members.', 15, 4, '2015-03-20 04:35:06'),
('dmitriy.nadtochiy', 1, 1, NULL, NULL, NULL, NULL, NULL, '2015-03-18 07:52:50'),
('dmitriy.nadtochiy', 1, 2, NULL, NULL, NULL, NULL, NULL, '2015-03-18 07:52:50'),
('dmitriy.nadtochiy', 1, 3, NULL, NULL, NULL, NULL, NULL, '2015-03-18 07:52:50'),
('frankie.chung', 1, 1, 'Ensure all servers in APAC offices (China, Korea, Japan) are backing up in AML HK', 'Completed the review, analysis, audit of IT infrastructure for APAC offices (China, Korea and Japan). During to company business situation / decision, the actual improvements are still pending.', 'The review and analysis were completed on time, though the new company business situation does not support for your proposing long term actions, alternative feasible remedial actions shall also be proposed in order to rectify some critical problem at once so as to protect the company''s data assets (e.g. the data back-up of AML-Korea by using one commonly shared external hard drive).', 20, 3, '2015-03-23 03:34:53'),
('frankie.chung', 1, 2, 'Internal system development (including website page, excel VBA and macro)', '- Performance appraisal form development in very tight schedule\n- Employee Survey development\n- Business trip schedule excel formula with annual leave planning', 'All these ad-hoc projects are developed and completed by Frankie with exceeding expectation and good quality.', 10, 5, '2015-03-23 03:12:11'),
('frankie.chung', 1, 3, 'Design and develop a website for files sharing within the AML group, vendor and banking, instead of using FTP', '- Owncloud system deployed. All main users (CPD) are using it instead of FTP. it also allow user to control the upload files and select who like to share. \nhttp://219.76.227.244/owncloud/', 'The mentioned cloud system is a very convenient tool and user friendly. It shall be further promoted (with briefing/training to staff) within the company and proactively let all staff to aware that there is such a useful tool/resources available.', 20, 4, '2015-03-23 03:07:02'),
('frankie.chung', 1, 4, 'Monitor and maintain stable  & satisfactory performance of the Company server and network\nEnsure IT support and procedures are arranged and updated timely and always in line with the current practices', 'Deployed 2 monitoring systems (Nagios and Zabbix), it can allow check the servers status real time with email alert.\n\nhttp://192.168.0.221/nagios/\nlogin: nagiosadmin\npassword: aml123\n\nhttp://192.168.0.220/zabbix/\nlogin: admin\npassword: aml123', 'Though the new monitoring systems had been deployed duly, but the quarterly reports & recommendation list as requested were missing to submit.', 10, 3, '2015-03-23 03:13:36'),
('frankie.chung', 1, 5, 'Ensure IT support and procedures are arranged and updated timely and always in line with the current practices', '100% compliance in internal audit & external ISO audit\n- Analysed and completed the physical backup rotation\n- Advanced and analysed the Disaster Recovery data center service vendors', 'Agreed that both the internal and external audit results, but the IT procedures (data back-up tape rotation)have not been updated to reflect the latest practices.', 15, 3, '2015-03-23 03:35:00'),
('frankie.chung', 1, 6, 'IT Training and Development:\nIT Training / E-learning resurrection', 'Value added - Training course\n- 1 interactive excel training (Pivot table)\n- 2 video excel training\n(Simple Formulas and Basic Functions)\n- Applied IT orientation section for new comer.', '3 training topics/courses are developed up to now. Better time management on delivering this goal shall be maintained.', 15, 3, '2015-03-23 03:26:34'),
('frankie.chung', 1, 7, 'Lead and develop the subordinate to perform and grow', 'Leaded and developed Anthony to perform and grow. Anthony can handle 70% IT by himself now.', 'Clear goals and guidance had been provided to his direct report and can observe the good achievement (e.g. joint active participating in the IT training courses, online PA form development, etc.) of his direct report in the past year.', 10, 4, '2015-03-23 03:30:33'),
('frankie.ho', 1, 1, NULL, NULL, NULL, NULL, NULL, '2015-03-23 07:01:50'),
('frankie.ho', 1, 2, NULL, NULL, NULL, NULL, NULL, '2015-03-23 07:01:50'),
('frankie.ho', 1, 3, NULL, NULL, NULL, NULL, NULL, '2015-03-23 07:01:50'),
('hidemi.hirasawa', 1, 1, NULL, NULL, NULL, NULL, NULL, '2015-03-27 00:30:54'),
('hidemi.hirasawa', 1, 2, NULL, NULL, NULL, NULL, NULL, '2015-03-27 00:30:54'),
('hidemi.hirasawa', 1, 3, NULL, NULL, NULL, NULL, NULL, '2015-03-27 00:30:54'),
('jay.cho', 1, 1, NULL, NULL, NULL, NULL, NULL, '2015-03-26 13:18:44'),
('jay.cho', 1, 2, NULL, NULL, NULL, NULL, NULL, '2015-03-26 13:18:44'),
('jay.cho', 1, 3, NULL, NULL, NULL, NULL, NULL, '2015-03-26 13:18:44'),
('kenny.chan', 1, 1, NULL, NULL, NULL, NULL, NULL, '2015-03-26 10:19:25'),
('kenny.chan', 1, 2, NULL, NULL, NULL, NULL, NULL, '2015-03-26 10:19:25'),
('kenny.chan', 1, 3, NULL, NULL, NULL, NULL, NULL, '2015-03-26 10:19:25'),
('shirla.kwan', 1, 1, 'Provide efficient recruitment services to all departments', 'No. of days on hiring below position:\n\nMonnie Au (Assistant COM Manager) - 36 days\nMaggie Siu (Accounting Clerk) - 49 days\nMartina Liu (Accounting Clerk, replacement) - 14 days\nSandy Chan (Office Assistant) - 19 days\nDeborah Cheng (Assistant Legal Counsel) - 14 days\nAssistant Operations Manager (on progress - spent 43 days upto 18 Mar)\n\nInformation has been updated on share file\n\nP:\\\\HR_AML Group\\\\Hiring Update - AML Group of Company.xlsx', NULL, NULL, NULL, '2015-03-19 02:01:26'),
('shirla.kwan', 1, 2, 'Employee Engagement', 'The turnover rate of below:\n\nAML Group: 12.66% as of Feb 2015\nIMA: 11.78% as of Jan 2015\n\nInformation has been updated on share file\n\nP:\\\\HR_AML Group\\\\AML Group Turnover Rate (Sales Office)\\\\HK + Sales Office - Turnover Rate (Apr 2014 to Mar 2015).xls\n\nP:\\\\HR_AML Group\\\\AML_IMA\\\\Monthly HR Report\\\\Apr 2014 to Mar 2015\\\\HR Report-Jan 2015.xls', NULL, NULL, NULL, '2015-03-19 02:03:42'),
('shirla.kwan', 1, 3, 'Performance Appraisal', 'As the PA form is submitted optional, only below office/department has been submitted the PA form:\n\nLEG of HK office\nIndia (exclude OA)\nSA (only Delia & Tania)\n\nFile has been saved in sever\nP:\\\\HR_AML Group\\\\AML_HK\\\\Performance Appraisal Forms (Annual & Quarterly) -- Completed by Staff\\\\Performance Appraisal Form - 2014 to 2015', NULL, NULL, NULL, '2015-03-19 01:53:14'),
('shirla.kwan', 1, 4, 'Compensation & Benefit', 'Most of the salary bench mark (except overseas) has been search online from difference source and has been saved in sever.\n\nP:\\\\HR_AML Group\\\\.Market Benchmark on C&B (Surveys)\\\\Year 2015', NULL, NULL, NULL, '2015-03-26 07:51:23'),
('shirla.kwan', 1, 5, 'Training & Development', 'Most of  the training evaluation forms has been received from staff and their supervisor.  The consolidate table has been saved in sever.\n\nP:\\\\HR_AML Group\\\\AML_HK\\\\Training\\\\Training Evaluation\\\\Training Evaluation (Individual)\\\\Staff Evaluation\\\\YE 31 Mar 2015\n\nP:\\\\HR_AML Group\\\\AML_HK\\\\Training\\\\Training Evaluation\\\\Training Evaluation (Individual)\\\\Supervisor Evaluation\\\\YE 31Mar15', NULL, NULL, NULL, '2015-03-19 01:58:29'),
('soohyun.song', 1, 1, NULL, NULL, NULL, NULL, NULL, '2015-03-26 23:38:43'),
('soohyun.song', 1, 2, NULL, NULL, NULL, NULL, NULL, '2015-03-26 23:38:43'),
('soohyun.song', 1, 3, NULL, NULL, NULL, NULL, NULL, '2015-03-26 23:38:43'),
('subhendu.ghosh', 1, 1, NULL, NULL, NULL, NULL, NULL, '2015-03-26 13:21:38'),
('subhendu.ghosh', 1, 2, NULL, NULL, NULL, NULL, NULL, '2015-03-26 13:21:38'),
('subhendu.ghosh', 1, 3, NULL, NULL, NULL, NULL, NULL, '2015-03-26 13:21:38'),
('suky.lai', 1, 1, 'Transportation & Accommodation arrangement for company travellers', '1. Ensure Company is taking the most favorable & feasible option and cost saving purpose.\n\n2. To ensure all travel arrangements were following with the company policy.\n\n3. Submit the monthly report of the travel expenses comparison', 'Monthly "Travel & Accommodation Quotation Comparison" reports are duly submitted. More than 90% of the checked cases are with lowest prices offered by our appointed travel agent, and those balance 10% case are with sensible reasons for selecting higher fare option.', 20, 4, '2015-03-25 01:50:42'),
('suky.lai', 1, 2, 'Satisfactory Office Environment Maintenance', 'Provided a comfortable, safe, organized & clean working environment to all staff with zero complaint from the staff \n\n1) Maintain the first-aid items / facilities of the office\n\n2) Conduct bi-weekly check on all office equipment \n\n3) adopt "5S" principle to maintain the facilities rooms and the cabinets/shelves assigned for HRA', '1) The first-aid items were re-arranged so as to comply with the statutory requirements now.\n\n2) The office equipment check shall be conducted more comprehensively to include every single facility/equipment. Suky shall also make a better planning of the maintenance.\n\n3) Not follow through this assignment completely and missed the deadline for completion. No obvious improvement (in terms of tidiness and adoption of "5S" principle) is found in the small facility room.', 40, 3, '2015-03-25 07:01:33'),
('suky.lai', 1, 3, 'Procurement of Office Supplies', 'Reviewed current suppliers'' products range & pricing:\n\n1) Stationery\nSourced 2 other services providers from comparison and choose the best options offered by the supplier. and negotiate the suppliers to keep the existing price and provide special discount to regular items.\n\n2) Office supplies of pantry\nFound 7s as one of our office supplier as well as the cost of pantry supplies can be decrease 5-10%\n\n3) Archive Storage\nSuccess in cost negotiation with service vendor deduct the price percentage rise from 50% to 30%', 'Overall office supplies expenses could not be reduced by 10%.\nSuky shall be more proactive to complete the office supplies vendors'' review, but Suky''s effort in negotiation with the vendors for the best price is recognized.', 20, 3, '2015-03-26 03:36:01'),
('suky.lai', 1, 4, 'Employee Engagement:\nHold staff events within one year (excluded Annual Dinner), with support from Staff Committee', 'Gather Staff Committee members from every Department and hold the following staff events.\n\n1. Trial Walker\n\n2. Elderly visit activity (Charity)\n\n3. Race for Water 2015', 'Suky has rendered her support to the Staff Committee to hold the staff events, but due to the company''s latest business situation and budget issue, which does not support to hold 4 staff events within the year and to cut out one event (as per direction from Vivien).', 10, 4, '2015-03-25 07:13:18'),
('suky.lai', 1, 5, 'Staff Development', 'Set clear expectations to my direct report and provide proper guidance / coaching to get the job done through subordinate\n\nExample: \n\n1) Screen incoming mails\n2) Regular checking of office equipment\n3) Pantry supplies order', 'Suky can guide her subordinate to complete the job assignments by subordinate''s own self duly.', 10, 3, '2015-03-25 07:18:05'),
('tommy.to', 1, 1, NULL, NULL, NULL, NULL, NULL, '2015-03-26 10:20:11'),
('tommy.to', 1, 2, NULL, NULL, NULL, NULL, NULL, '2015-03-26 10:20:11'),
('tommy.to', 1, 3, NULL, NULL, NULL, NULL, NULL, '2015-03-26 10:20:11'),
('vivien.chan', 1, 1, NULL, NULL, NULL, NULL, NULL, '2015-03-11 08:30:07'),
('vivien.chan', 1, 2, NULL, NULL, NULL, NULL, NULL, '2015-03-11 08:30:07'),
('vivien.chan', 1, 3, NULL, NULL, NULL, NULL, NULL, '2015-03-11 08:30:07'),
('youwei.tang', 1, 1, NULL, NULL, NULL, NULL, NULL, '2015-03-27 01:18:10'),
('youwei.tang', 1, 2, NULL, NULL, NULL, NULL, NULL, '2015-03-27 01:18:10'),
('youwei.tang', 1, 3, NULL, NULL, NULL, NULL, NULL, '2015-03-27 01:18:10'),
('yunjung.lee', 1, 1, NULL, NULL, NULL, NULL, NULL, '2015-03-26 23:58:10'),
('yunjung.lee', 1, 2, NULL, NULL, NULL, NULL, NULL, '2015-03-26 23:58:10'),
('yunjung.lee', 1, 3, NULL, NULL, NULL, NULL, NULL, '2015-03-26 23:58:10');

-- --------------------------------------------------------

--
-- Table structure for table `pa_part_b1`
--

CREATE TABLE IF NOT EXISTS `pa_part_b1` (
  `form_username` varchar(64) collate utf8_unicode_ci NOT NULL,
  `survey_uid` int(11) NOT NULL,
  `question_no` int(11) NOT NULL,
  `self_example` mediumtext collate utf8_unicode_ci,
  `self_score` int(11) default NULL,
  `appraiser_example` mediumtext collate utf8_unicode_ci,
  `appraiser_score` int(11) default NULL,
  `last_modify` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`form_username`,`survey_uid`,`question_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pa_part_b1`
--

INSERT INTO `pa_part_b1` (`form_username`, `survey_uid`, `question_no`, `self_example`, `self_score`, `appraiser_example`, `appraiser_score`, `last_modify`) VALUES
('anthony.poon', 1, 1, 'Example', 3, 'Example', 3, '2015-03-26 03:53:27'),
('anthony.poon', 1, 2, 'Example', 3, 'Example', 3, '2015-03-26 03:53:32'),
('anthony.poon', 1, 3, 'Example', 3, 'Example', 3, '2015-03-26 03:53:34'),
('anthony.poon', 1, 4, 'Example', 3, 'Example', 3, '2015-03-26 03:53:35'),
('anthony.poon', 1, 5, 'Example', 3, 'Example', 3, '2015-03-26 03:53:38'),
('anthony.poon', 1, 6, 'Example', 3, 'Example', 3, '2015-03-26 03:53:40'),
('anthony.poon', 1, 7, 'Example', 3, 'Example', 3, '2015-03-26 03:53:41'),
('anthony.poon', 1, 8, 'Example', 3, 'Example', 3, '2015-03-26 03:53:43'),
('carrie.chung', 1, 1, 'Whenever there is new assignment from my supervisors, no matter it is new scope or not supposed to be handled by me directly (e.g. recruitment project of Pertama), I am more than happy to accept the assignment, support my teammate and render my effort to complete jointly.', 4, 'Agree with the example.', 4, '2015-03-19 08:03:49'),
('carrie.chung', 1, 2, 'For instance is the Michelle (AML-SA consultant) case, I take initiative to further follow up it and seek opinions from my supervisors and revert to with the related staff, while the issue was first raised directly to my subordinate.', 4, 'Agree with the example.\n\nCarrie is recommended to be more proactive in planning, managing the major tasks and performance of subordinates.', 4, '2015-03-19 09:19:16'),
('carrie.chung', 1, 3, 'A related case is for a Medical Claim (Out-patient) case from Belinda (claim for using 脊醫), I made further search and related practice and work out solution together with my supervisor basing on this special request.', 4, 'Agree with the example.\n\nIn addition, Carrie has developed good relationship with most of our customers (internal and external) and is quite familiar with department needs, especially commerce and marketing which she has worked for years, and can understand and response timely to their request in general.', 4, '2015-03-24 07:12:58'),
('carrie.chung', 1, 4, 'After taking the "Personal Data Protection" seminar, I take initiative to revise the existing related HR forms in order to comply with the related ordinance.', 4, 'Agree with the example.\n\nBeing the manager of HRA, Carrie is recommended to be more proactive in coaching the job performance of her subordinates whenever appropriate.', 4, '2015-03-19 09:20:41'),
('carrie.chung', 1, 5, 'I will check even down to the spelling/grammar in the documents/memo/email  and raised for amendment/correction if appropriate(recent case is for the new JD for Arif, as found with minor typo on his surname).', 4, 'Agree with the example.\n\nIn addition, Carrie will check and identify the inconsistent point in  draft contract / agreement prepared by Legal team.', 4, '2015-03-19 08:08:24'),
('carrie.chung', 1, 6, 'I have no specific examples to be quoted here. (Sorry)', 3, 'Carrie can tackle most of the ad hoc operational problems independently e.g. On 12 Mar 2015, both the secretary (sick leave), OA (outdoor assignment) and backup staff (annual leave) are not available in the whole morning, Shirla and Frankie were assigned as backup for reception support till 2:00 pm while OA was arranged to support the reception after lunch time.', 3, '2015-03-19 08:07:42'),
('carrie.chung', 1, 7, 'I usually get my assignment done within deadline (or earlier in most cases).', 4, 'Agree with the example.\n\nIn addition, during the updating of Employee Handbook, PA system and related forms, Carrie has helped to ensure that they are aligned with the Company practice, management expectation and compile to legal requirements.', 4, '2015-03-19 09:21:22'),
('carrie.chung', 1, 8, 'I also show respect to my team members or other colleagues whenever they have complaints/grumbles raised directly to me.', 4, 'Agree with the example.\n\nIn addition to Respect, Carrie creates harmony among the team in general. She has good temper in dealing with difficult staff and shows patience to work / explain again and again with them.', 4, '2015-03-19 09:22:08'),
('celia.law', 1, 1, 'A regular HRA meeting was coordinated and chaired for team sharing and discussion;  During the weekly team meeting, all team members were encouraged to share their major achievements on monthly base. Any valuable news / market information under their responsible job functions, they are also invited to share with all the staff in Hong Kong office.', 5, NULL, 4, '2015-03-19 09:37:47'),
('celia.law', 1, 2, 'Being the Senior Manager of Human Resources and General Affairs in Hong Kong office, an annual HRA plan, covering both HR, Admin and IT functions, with non-routine tasks and milestones were preliminary set and scheduled for ease facilitation of teamwork and reallocation manpower support whenever necessary.', 4, NULL, 4, '2015-03-19 09:37:49'),
('celia.law', 1, 3, '1/ Based on  staff feedback and previous HR  experiences, a regular MPF workshop in Hong Kong office was reactivated for new staff considering that they would be interested on the MPF news and changes on annual basis. Active staff participation proved the customer needs were satisfied and upheld.\n\n2/ An Employee Engagement Survey 2014 was also drafted and developed aims at providing all Employees an opportunity to express their opinions about the Company and management.', 4, 'Improve communication with internal customers.  e.g. keep regular meeting or contacts with department heads about their needs on manpower, training or other HR related issues.', 3, '2015-03-24 02:36:22'),
('celia.law', 1, 4, '1/ For ease data consolidation and analysis for PA, the originated excel form was highly recommended to be transformed from hard copy to online format with technical support from IT team and coordination by HRA manager.\n\n2/ Critical HR news/changes would be observed and shared within the team for timely attention and alignment ', 5, NULL, 4, '2015-03-20 02:55:43'),
('celia.law', 1, 5, 'During the Employee Handbook Review, most of previous request, HR challenges and (e.g. housing allowance for expat, employee records, learning and development scope, normal coverage of outpatient, dental benefit,) were observed and identified. \n\nUpdates / Correction / Clarification / Clear definition in related policy and forms were recommended in one go for continuous improvement of HR operations and management in long term.', 4, NULL, 4, '2015-03-19 09:37:55'),
('celia.law', 1, 6, 'In dealing the management concern of subjective scoring in the annual PA, a relatively objective and fair PA form was recommended with the following changes:\na)Addition of counter signer;\nb)Simplification of competencies;\nc)Develop specific definition by score level;\nd) Request for smart examples to support rating;\ne) Calibrate the PA scores among the team with a bell curve first; and\nf) Support the development of High and Low performers.', 4, '- Often offers workable solutions to problems.\n- Uses good judgment in solving problems and working well with others', 4, '2015-03-24 02:37:02'),
('celia.law', 1, 7, 'In alignment with the Company and departmental goals, the Individual Quality Objectives for HRA team members  and myself were clearly set and defined with specific goals, measurement details, deliverable, weighting and target completion date set. \n\nProgress were updated through the minute of weekly team meeting as well as annual planning on weekly basis.', 4, NULL, 3, '2015-03-20 02:56:00'),
('celia.law', 1, 8, '1/ During the 1st face to face meeting with Pertama HR in July 2014, a cultural awareness and team building workshop was organized and delivered for all their managers working in Bintulu office. After the workshop, more understanding of the cultural difference and trust among team were achieved; \n\n2/ In order to encourage and inspire Wang Ruan to stay claim and motivated at work, some core values of 7 Habits at works with videos were shared with her in early Mar 2015.\n\n3/ Through open and timely HR communication sessions to AML sales offices and affiliates, proper listening and feedback to ensure a common understanding was created and demonstrated.', 5, NULL, 4, '2015-03-24 02:37:51'),
('frankie.chung', 1, 1, 'For Employee Survey and Performance Appraisal Form, I like to discuss detail actively, listening and sharing the idea. And also keep trying to help user to apply excel VBA or function in their daily work.', 4, 'Agreed with the example.\n\nFrankie always shows teamwork to support and back-up the reception/admin duties.', 4, '2015-03-23 04:24:31'),
('frankie.chung', 1, 2, 'Taking the Employee Survey and Performance Appraisal Form ownership and development, and proactive to try review oversea office''s IT equipment and infrastructure.', 3, 'Agreed with the example.\n\nFrankie is responsible and show ownership to customer problems (e.g. the mentioned projects, MOS, company mobile user''s request/problems).', 4, '2015-03-23 03:47:28'),
('frankie.chung', 1, 3, 'Keep building customer confidence via trouble shooting\ne.g. Skype conference call connection problems: I am proactively to help COM''s team to connect with KMR, found the root cause.', 4, 'Agreed with the example.\n\nFrankie always listens patiently to the customers, but the follow-up actions could be delivered better and sooner.', 3, '2015-03-24 06:13:10'),
('frankie.chung', 1, 4, 'Analysed and completed the new backup service vendors.\n\nAnalysed and completed the new mobile supply vendors.\n\nAnalysed and consolidated the Disaster recovery data center service vendors.', 4, 'Frankie shall be more sensitive and proactive in proposing more new / advance IT solutions to cope with the new / ever-changing IT technology which could benefit the company (in terms of IT efficiency) as a whole.', 3, '2015-03-23 04:11:56'),
('frankie.chung', 1, 5, 'For the quality work of Employee Survey and Performance Appraisal Form, I always like to think about "make it better", but I have to avoid typos', 4, 'Frankie''s English writing (grammar/vocabulary) and presentation skills shall be further enhanced in order to increase the work quality and accuracy.', 3, '2015-03-23 04:17:55'),
('frankie.chung', 1, 6, 'Employee Survey and Performance Appraisal Form development on time, even the schedule is very tight', 4, 'Agreed with the example.\n\nFrankie can propose good/sensible recommendation for improvement.', 4, '2015-03-23 04:14:48'),
('frankie.chung', 1, 7, 'I will keep trying to do more and better until the project end\n\n- Deployed a very user-friendly "owncloud" system, fully replaced FTP.\n- Employee Survey Form\n- Performance Appraisal Form.', 5, 'Agreed that the online PA Form and Employee Satisfaction Survey project are nicely completed exceeding expectation, but some other goals and assignments are not completed within time-frame or with adequate interim reporting.', 4, '2015-03-23 04:22:01'),
('frankie.chung', 1, 8, 'Nice to talk with everyone, willing to listen, understand and proactive approach in the meeting.', 4, 'Frankie always show good quality service manner to all level of staff in the Group.', 4, '2015-03-23 04:22:38'),
('shirla.kwan', 1, 1, 'Always share the information to team member if I noted on the issue', 3, NULL, NULL, '2015-03-19 02:19:18'),
('shirla.kwan', 1, 2, 'Always seek for comment for complicate issue', 3, NULL, NULL, '2015-03-19 02:06:07'),
('shirla.kwan', 1, 3, 'N/A for my field as I am not a salesman.\n\nFor HR, I always understanding other staff request and give advise and help to sort out issue.  For complicate issue, I always seek for comment from supervisor', 4, NULL, NULL, '2015-03-19 02:09:37'),
('shirla.kwan', 1, 4, 'I always gets on the jobs', 3, NULL, NULL, '2015-03-19 02:17:56'),
('shirla.kwan', 1, 5, 'I always attend to details, sometime has mistake', 3, NULL, NULL, '2015-03-19 02:21:21'),
('shirla.kwan', 1, 6, 'I always listen and understand other staff request and help to give advise to sort out staff problem.', 4, NULL, NULL, '2015-03-19 02:23:24'),
('shirla.kwan', 1, 7, 'Always follow the company policy and procedure.', 4, NULL, NULL, '2015-03-19 02:24:06'),
('shirla.kwan', 1, 8, 'I always listen and understand other staff request and help to give advise to sort out staff problem.', 4, NULL, NULL, '2015-03-19 02:25:03'),
('suky.lai', 1, 1, '1. Gather all staff committee to encourages our contribution on the company charities and events. \n\n2. Always listens to others either on business and personal and always keep a hand although I am unable to help all enquiries, but I will try to  find out the best solutions for the enquirers.', 5, 'Suky shall be more participative and contribute proactively in team''s tasks/assignment.\n\n(e.g. updating of email addresses/office addresses in global address book/e-office)', 3, '2015-03-25 07:49:25'),
('suky.lai', 1, 2, 'Always give a high attention of enquiries from internal and external of the company, to ensure all the enquiries were completed timely and satisfied by the enquirers.\n\nWhen facing problems, I did seek for help from my supervisors or expert for help.', 5, 'Suky could not show her ownership at all to the assignment and missing deadline.\n\nAn example is for the Stationery Cabinets Re-arrangement  and the Small Facility Room Tidy-up assignment. Guidelines and target completion date had been well communicated to Suky well ahead (more than a month''s time), but only upon my progress checking a few days before deadline, Suky only reported by that time that she could not complete it on time.', 2, '2015-03-25 07:57:42'),
('suky.lai', 1, 3, 'Always welcome and providing professional support to internal and external of the company, get a trust from the customers even on their personal arrangement.', 5, 'Suky manage well for the travel & accommodation arrangement for the company''s travelers / guests as with her good understanding of the customers'' needs and make appropriate arrangement.\nIn addition, Suky could also manage to accomplish the daily /ad-hoc outdoor job assignments requested by other departments with almost none staff complaints.', 4, '2015-03-25 10:28:34'),
('suky.lai', 1, 4, 'Found a new office supply vendors for the company, to deduct the cost on office supply.', 5, 'Agreed with the example, but after finding this new alternative vendor, no significant change to purchase the office supplies (pantry) items from this new vendor in order to cut costs.\nIn addition, for the vendor review on Document Archive Service & Travel Agents, these assignments were raised by her supervisors and with close monitoring on the progress, while Suky could not show her initiative to complete it by herself.', 3, '2015-03-25 08:26:06'),
('suky.lai', 1, 5, 'Providing first class professional support to internal and external of the company, to keep a good image of administration support.', 4, 'For monthly Admin bills verification and payment preparation, more than 95% of the bills are accurately checked by Suky.\n\nFor the other ad-hoc/annual assignments (e.g. vendor review), Suky could submit the required reports by due course, but her supervisors have to re-work on the content (e.g. formula, grammar, vocab, etc.) in order to improve the quality (e.g. comprehensiveness, presentation)', 3, '2015-03-25 08:37:02'),
('suky.lai', 1, 6, 'Quick decision making on travel arrangement and admin issuing when challenging the company policy, and ensure all the arrangement were following with company policy and the costing saving premise.  When facing problems, I will seek for help from my supervisor or expert for help.', 5, 'Suky handled well independently on expat''s company quarters'' arrangement (e.g. negotiation with landlord for tenancy renewal with increased rental, search for new apartments, apartments'' furnishing/maintenance issues)and could make sensible recommendation to solve the problems.', 4, '2015-03-25 08:40:59'),
('suky.lai', 1, 7, 'Renew a new service agreement with difference vendors (e.g. Cannon, Iron Mountain and Tenancy Agreement) in the major premise (cost saving) of the company.', 5, 'Most of the yearly objectives were attained just by meeting average standard, while Suky shows her compliance to the company policies & procedures at all times.', 3, '2015-03-25 08:47:32'),
('suky.lai', 1, 8, 'Provide all secretarial and administration service all around the company and also external customers, got feedback from the customers who were appreciated of our support and help.', 5, 'Both spoken and written English of Suky marginally meets standard which affect the work quality.\n\nOne example is the memos/notices issued by Suky usually contains grammatical errors, spelling mistakes or with inappropriate tone, which can affect the quality of the communication.', 3, '2015-03-25 09:24:03'),
('youwei.tang', 1, 1, NULL, 2, NULL, NULL, '2015-03-27 01:20:14');

-- --------------------------------------------------------

--
-- Table structure for table `pa_part_b2`
--

CREATE TABLE IF NOT EXISTS `pa_part_b2` (
  `form_username` varchar(64) collate utf8_unicode_ci NOT NULL,
  `survey_uid` int(11) NOT NULL,
  `question_no` int(11) NOT NULL,
  `self_example` mediumtext collate utf8_unicode_ci,
  `self_score` int(11) default NULL,
  `appraiser_example` mediumtext collate utf8_unicode_ci,
  `appraiser_score` int(11) default NULL,
  `last_modify` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`form_username`,`survey_uid`,`question_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pa_part_d`
--

CREATE TABLE IF NOT EXISTS `pa_part_d` (
  `form_username` varchar(64) collate utf8_unicode_ci NOT NULL,
  `survey_uid` int(11) NOT NULL,
  `question_no` int(11) NOT NULL,
  `key_respon` mediumtext collate utf8_unicode_ci,
  `goal_name` mediumtext collate utf8_unicode_ci,
  `measurement_name` mediumtext collate utf8_unicode_ci,
  `goal_weight` int(11) default NULL,
  `complete_date` varchar(256) collate utf8_unicode_ci default NULL,
  `last_modify` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`form_username`,`survey_uid`,`question_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pa_part_d`
--

INSERT INTO `pa_part_d` (`form_username`, `survey_uid`, `question_no`, `key_respon`, `goal_name`, `measurement_name`, `goal_weight`, `complete_date`, `last_modify`) VALUES
('anthony.poon', 1, 1, 'IT housekeeping in the office', 'IT housekeeping for server room, meeting room, etc. Tidy up all IT equipment in different area', 'Full lists of IT equipment for different area, and keep it up to date.', 100, '2015-04', '2015-03-26 03:55:19'),
('carrie.chung', 1, 1, 'HR Information System', 'Systemize all the Employee''s personnel profiles as well as streamline the workflow on leave management and payroll & MPF administration.', 'To coordinate with IT for internal development of HRIS in 2015.', 15, '2015-06', '2015-03-19 09:10:24'),
('carrie.chung', 1, 2, 'Support KMR Projects', 'Fulfill the obligations (HRA related) of the two critical services agreements signed with KMR ("Technical Services Agreement" and "Distribution Agreement").', '1/ Ensure all Company Policy and Procedures for KMR is developed in due course; \n\n2/ Ensure all the approved Skills Transfer Training Plan was implemented accordingly.', 30, '2016-03', '2015-03-19 09:13:33'),
('carrie.chung', 1, 3, 'Staff Learning and Development', 'Ensure all the mandatory training needs of the staff (whole AML Group excluding IMA) are fulfillled and the training objectives are achieved.', '1/ In alignment with biz needs, related L&D policy and forms are updated and communicated to all staff. \n\n2/ The supervisor''s training evaluation scores given to trainees shall be reaching at least 80% of full marks', 10, '2015-09', '2015-03-19 09:12:49'),
('carrie.chung', 1, 4, 'Quality Management System 1', 'Fulfill the obligations (HRA related) of the two critical services agreements signed with KMR ("Technical Services Agreement" and "Distribution Agreement").', 'No NC in both internal audit and ISO 9001 assessment in relation to HRA areas.', 10, '2016-03', '2015-03-19 09:07:29'),
('carrie.chung', 1, 5, 'Quality Management System 2', 'Maintain ISO9001 accreditation for the Company for the Year', 'No NC point in external ISO9001 assessment in relation to HRA area', 5, '2016-03', '2015-03-19 09:09:36'),
('carrie.chung', 1, 6, 'Staff Development', 'Lead and Develop the Subordinate to perform and grow', 'Set clear expectations to your direct report and provide proper guidance / coaching to get the job done through your subordinates', 30, '2016-03', '2015-03-19 09:07:10'),
('celia.law', 1, 1, 'Review and improve AML Group subsidiary companies HR', NULL, NULL, NULL, NULL, '2015-03-20 03:48:55'),
('celia.law', 1, 2, NULL, NULL, NULL, NULL, NULL, '2015-03-24 03:03:00'),
('frankie.chung', 1, 1, 'HR Information System', 'Systemize all the Employees'' personnel profiles as well as streamline the workflow on leave management, payroll and MPF administration.', 'In-House HRIS system are developed and deployed.', 15, 'Jun 2015', '2015-03-24 09:00:37'),
('frankie.chung', 1, 2, 'AML Group IT infrastructure review, analysis and audit', 'Ensure all data in all fully-own subsidiary offices (except IMA) are properly back-up regularly and all servers/data are backing up in AML-HK.', 'Conducted IT audit for all offices and all the recommended improvement have been put for effective by each respective office.', 20, 'Oct 2015', '2015-03-23 08:40:32'),
('frankie.chung', 1, 3, 'Electronic Filing', 'Increase the overall efficiency of the Company on documents filing/data storage via electronic means.', 'Develop a user friendly and systematic electronic filing framework of all staff in AML-HK to follow. (Related communication session/training and procedure/user guide shall be delivered).', 15, 'Sep 2015', '2015-03-24 08:50:32'),
('frankie.chung', 1, 4, 'IT Training and Development', 'IT Training/E-learning resurrection', 'Develop training materials and launch 5 topics (IT Security Awareness, Cloud Storage, MS Word, MS Excel, MS PowerPoint, Communication Tool, etc.) through e-office / in-house training.', 20, 'Jan 2016', '2015-03-24 08:50:36'),
('frankie.chung', 1, 5, 'MOS Enhancement', 'Lead and complete all the enhancement proposal proposed by the consultant "Masato Suzuki" and increase the overall work efficiency of the users.', 'Completed all the agreed enhancement tasks within budget and schedule.', 10, 'Mar 2016', '2015-03-24 09:02:23'),
('frankie.chung', 1, 6, 'AML-HK IT Infrastructure', 'Successfully migrate & upgrade the Window Server to latest version without any downtime that interrupt the normal business operations.', 'Complete the installation, user acceptance tests server migration & upgrade as per budget and schedule.', 10, 'Jun 2015', '2015-03-24 09:01:37'),
('frankie.chung', 1, 7, 'Staff Development', 'Lead and develop the subordinate to perform and grow.', 'Set clear expectations to your direct report and provide proper guidance/ coaching to get the job done through subordinate.', 10, 'Mar 2016', '2015-03-24 08:51:36'),
('suky.lai', 1, 1, 'Admin Costs Control', 'Attain 10% annual costs reduction in office supplies, 5% annual costs reduction in transportation and accommodation.', 'Attain 10% annual expenses cut in office supplies & 5% annual expenses cut in transportation & accommodation = score 4; every 2% less expenses cut in each category = -1 score; every 2% more expenses cut in each category = +1 score', 30, 'Mar 2016', '2015-03-26 03:37:43'),
('suky.lai', 1, 2, 'General Office Premises'' Administration', 'Provide an organized working environment to all staff with zero complaint from the staff in the year.', 'Adopt "5S" principle to maintain all facilities rooms, meeting rooms, pantries, all the cabinents/shelves assigned for HRA, with clear labelling, clear items categorization and storage plan.  Monthly checking (as per duly agreed check-list) to be done by HR Manager.\n --> 100% compliance in all months = score 5 ; more than 5 non-compliance items recorded in  every 2 months = - 1 score', 20, 'Mar 2016', '2015-03-26 03:53:01'),
('suky.lai', 1, 3, 'General Office Premises'' Maintenance', 'Provide a safe working environment to all staff with zero complaint from the staff and no work injury in office reported in the year.', 'Conduct bi-weekly check on all office equipment/tools in pantries, facilities rooms, meeting rooms, general office area, reception area, directors'' rooms and to repair/replace any damage / out-of-order items:-\n(i) within 2 working days upon finding for critical items that endanger safety or normal operation of the office;\n(ii)within 2 months for those non-critical items.\n\nSubmit Bi-Weekly Checking Report to HR Manager.\n--> 100% punctual submission of the Bi-Weekly Report and repair/maintenance work done = score 4; every 2 times delay = -0.5 score', 20, 'Mar 2016', '2015-03-26 03:59:18'),
('suky.lai', 1, 4, NULL, NULL, NULL, NULL, NULL, '2015-03-26 03:40:20'),
('suky.lai', 1, 5, 'Staff Development', 'Lead and develop the subordinate to perform and grow.', 'Set clear expectations to your direct report and provide proper guidance / training to get the job done through subordinate.\n\n --> Direct report attain overall average PA score of 3 = score 3; every 0.5 score down = -0.5 score; every 0.5 score up = +0.5 score', 10, 'Mar 2016', '2015-03-26 03:52:41');

-- --------------------------------------------------------

--
-- Table structure for table `pa_user`
--

CREATE TABLE IF NOT EXISTS `pa_user` (
  `user_id` int(8) NOT NULL auto_increment,
  `username` varchar(64) collate utf8_unicode_ci NOT NULL,
  `user_password` varchar(255) collate utf8_unicode_ci NOT NULL default 'password',
  `user_full_name` varchar(64) collate utf8_unicode_ci default NULL,
  `is_senior` tinyint(1) NOT NULL default '0',
  `is_admin` tinyint(1) NOT NULL default '0',
  `is_report_user` tinyint(1) NOT NULL default '0',
  `user_department` varchar(64) collate utf8_unicode_ci default NULL,
  `user_position` varchar(64) collate utf8_unicode_ci default NULL,
  `user_office` varchar(64) collate utf8_unicode_ci default NULL,
  `commence_date` date default NULL,
  `appraiser_username` varchar(64) collate utf8_unicode_ci default NULL,
  `countersigner_username_1` varchar(64) collate utf8_unicode_ci default NULL,
  `countersigner_username_2` varchar(64) collate utf8_unicode_ci default NULL,
  `last_modify` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `admin_user_name` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=88 ;

--
-- Dumping data for table `pa_user`
--

INSERT INTO `pa_user` (`user_id`, `username`, `user_password`, `user_full_name`, `is_senior`, `is_admin`, `is_report_user`, `user_department`, `user_position`, `user_office`, `commence_date`, `appraiser_username`, `countersigner_username_1`, `countersigner_username_2`, `last_modify`) VALUES
(2, 'frankie.chung', 'password', 'Frankie Chung', 0, 0, 0, 'HRA', 'IT Officer', 'Hong Kong', '2012-08-01', 'carrie.chung', 'celia.law', NULL, '2015-03-26 03:56:18'),
(3, 'anthony.poon', 'password', 'Anthony Poon', 0, 0, 0, 'HRA', 'Assistant IT Officer', 'Hong Kong', '2013-09-10', 'frankie.chung', 'carrie.chung', NULL, '2015-03-26 03:56:16'),
(4, 'han.cao', 'n9q5f81', 'Han Cao', 1, 0, 1, 'AML China', 'General Manager', 'China', '2003-04-15', 'adam.jiang', 'hirotaka.suzuki', NULL, '2015-03-26 02:17:22'),
(5, 'amy.cao', 'vn1uakt', 'Amy Cao', 0, 0, 0, 'AML China', 'Assistant Sales Manager', 'China', '2006-04-17', 'kevin.zhang', 'john.liu', NULL, '2015-03-26 02:17:25'),
(6, 'linda.xiong', 'id36ogp', 'Linda Xiong', 1, 0, 0, 'AML China', 'Deputy General Manager , Accounting & Administration', 'China', '2007-01-01', 'han.cao', 'adam.jiang', NULL, '2015-03-26 02:17:26'),
(7, 'kevin.zhang', '7t9s0ze', 'Kevin Zhang', 0, 0, 0, 'AML China', 'Sales Manager', 'China', '2009-02-09', 'john.liu', 'han.cao', NULL, '2015-03-26 02:17:28'),
(8, 'john.liu', '5b6qeth', 'John Liu', 1, 0, 0, 'AML China', 'Deputy General Manager', 'China', '2009-03-25', 'han.cao', 'adam.jiang', NULL, '2015-03-26 02:17:29'),
(9, 'youwei.tang', '5e38m1g', 'Youwei Tang', 0, 0, 0, 'AML China', 'Finance Manager', 'China', '2009-08-17', 'linda.xiong', 'han.cao', NULL, '2015-03-26 02:39:00'),
(10, 'cai.tao.xiang', 'q0wx7a8', 'Cai Tao Xiang', 0, 0, 0, 'AML China', 'Cleaner', 'China', '2009-12-01', 'linda.xiong', 'han.cao', NULL, '2015-03-26 02:17:34'),
(11, 'coco.guo', 'bd2suk5', 'Coco Guo', 0, 0, 0, 'AML China', 'Administration Clerk', 'China', '2013-05-29', 'linda.xiong', 'han.cao', NULL, '2015-03-26 02:17:35'),
(12, 'adam.jiang', 'pl2ktux', 'Adam Jiang', 1, 0, 1, 'MGT', 'Deputy Managing Director', 'Hong Kong', '2015-02-01', NULL, NULL, NULL, '2015-03-26 01:59:07'),
(13, 'setsuo.suzuki', 'fzndkce', 'Setsuo Suzuki', 1, 0, 1, 'MGT', 'Director', 'Hong Kong', '2015-02-01', NULL, NULL, NULL, '2015-03-26 01:59:07'),
(14, 'hirotaka.suzuki', '49hosfd', 'Hirotaka Suzuki', 1, 0, 1, 'MGT', 'Chairman', 'Hong Kong', '2015-02-01', 'admin', NULL, NULL, '2015-03-26 01:59:07'),
(15, 'fu.jun', 'qmc40e3', 'Fu Jun', 1, 0, 1, 'IMA', 'General Manager', 'IMA', '2008-05-01', 'adam.jiang', 'hirotaka.suzuki', '', '2015-03-26 02:18:31'),
(16, 'subhendu.ghosh', 'onwtxqf', 'Subhendu Ghosh', 0, 0, 0, 'AML India', 'Assistant General Manager', 'India', '2008-10-01', 'gautam.kumar', 'setsuo.suzuki', '', '2015-03-26 02:18:42'),
(17, 'carrie.chung', 'sfji1#d', 'Carrie Chung', 0, 1, 0, 'HRA', 'Manager', 'Hong Kong', '2004-08-18', 'celia.law', 'vivien.chan', NULL, '2015-03-11 08:04:47'),
(18, 'gautam.kumar', 'xc710dn', 'Gautam Kumar', 1, 0, 1, 'AML India', 'Director', 'India', '2008-10-01', 'setsuo.suzuki', 'hirotaka.suzuki', '', '2015-03-26 02:19:08'),
(19, 'rajvindkumar.singh', 'wod3lyu', 'Rajvind Kumar Singh', 0, 0, 0, 'AML India', 'Office Assistant', 'India', '2008-10-10', 'subhendu.ghosh', 'gautam.kumar', '', '2015-03-26 02:18:47'),
(20, 'dmitry.yegorov', 'y2w18vb', 'Dmitry Yegorov', 1, 0, 0, 'LOG', 'Deputy General Manager', 'Hong Kong', '2006-05-27', 'takehiko.yamazaki', 'setsuo.suzuki', NULL, '2015-03-26 01:59:07'),
(21, 'suky.lai', '7sj%hjs', 'Suky Lai', 0, 0, 0, 'HRA', 'Secretary', 'Hong Kong', '2006-07-11', 'carrie.chung', 'celia.law', NULL, '2015-03-11 08:10:14'),
(22, 'yuki.nakamura', 'md0agjh', 'Yuki Nakamura', 1, 0, 1, 'CPD', 'General Manager', 'Hong Kong', '2006-08-03', 'setsuo.suzuki', 'hirotaka.suzuki', NULL, '2015-03-26 01:59:07'),
(23, 'may.song', 'usqyhze', 'May Song', 0, 0, 0, 'COM', 'Account Manager', 'Hong Kong', '2007-01-22', 'frankie.ho', 'dmitriy.nadtochiy', NULL, '2015-03-26 01:59:07'),
(24, 'dmitriy.nadtochiy', 'za8d2vg', 'Dmitriy Nadtochiy', 1, 0, 1, 'COM', 'General Manager', 'Hong Kong', '2007-10-01', 'setsuo.suzuki', 'hirotaka.suzuki', NULL, '2015-03-26 01:59:07'),
(25, 'eric.chung', '2unipx7', 'Eric Chung', 0, 0, 0, 'COM', 'Assistant Manager', 'Hong Kong', '2008-02-25', 'frankie.ho', 'dmitriy.nadtochiy', NULL, '2015-03-26 01:59:07'),
(26, 'gladys.wong', 'p73xsyt', 'Gladys Wong', 0, 0, 0, 'COM', 'Assistant Manager, Operations', 'Hong Kong', '2008-06-03', 'angie.mok', 'frankie.ho', NULL, '2015-03-26 01:59:07'),
(27, 'vivien.chan', 'qw1s%2h', 'Vivien Chan', 1, 0, 1, 'HRA', 'General Manager', 'Hong Kong', '2008-06-23', 'setsuo.suzuki', 'hirotaka.suzuki', NULL, '2015-03-11 08:16:43'),
(28, 'shirla.kwan', 'dkd*js2', 'Shirla Kwan', 0, 0, 0, 'HRA', 'Human Resources Supervisor', 'Hong Kong', '2008-07-21', 'carrie.chung', 'celia.law', NULL, '2015-03-11 08:10:35'),
(29, 'kenny.kwan', 'jmfpdzc', 'Kenny Kwan', 1, 0, 1, 'FNA', 'General Manager', 'Hong Kong', '2009-10-19', 'setsuo.suzuki', 'hirotaka.suzuki', NULL, '2015-03-26 01:59:07'),
(30, 'belinda.cheung', '21dqyjt', 'Belinda Cheung', 1, 0, 1, 'LEG', 'Legal Counsel', 'Hong Kong', '2009-10-21', 'setsuo.suzuki', 'hirotaka.suzuki', NULL, '2015-03-26 01:59:07'),
(31, 'theresa.ho', '0malhw2', 'Theresa Ho', 0, 0, 0, 'COM', 'Account Manager', 'Hong Kong', '2010-03-08', 'frankie.ho', 'dmitriy.nadtochiy', NULL, '2015-03-26 01:59:07'),
(32, 'kenny.chan', 'zqiwnsr', 'Kenny Chan', 0, 0, 0, 'FNA', 'Assistant Accountant', 'Hong Kong', '2010-03-15', 'mark.lam', 'kenny.kwan', NULL, '2015-03-26 01:59:07'),
(33, 'lisa.fung', 'hs2783o', 'Lisa Fung', 0, 0, 0, 'FNA', 'Senior Accounting Manager', 'Hong Kong', '2010-10-11', 'kenny.kwan', 'setsuo.suzuki', NULL, '2015-03-26 01:59:07'),
(34, 'sam.leung', '0q4zdkh', 'Sam Leung', 1, 0, 0, 'CPD', 'Deputy General Manager', 'Hong Kong', '2010-11-18', 'yuki.nakamura', 'setsuo.suzuki', NULL, '2015-03-26 01:59:07'),
(35, 'steve.lam', 'uy86vql', 'Steve Lam', 0, 0, 0, 'CPD', 'Manager', 'Hong Kong', '2011-02-10', 'sam.leung', 'yuki.nakamura', NULL, '2015-03-26 01:59:07'),
(36, 'christina.lee', 'q9jekx0', 'Christina Lee', 0, 0, 0, 'LEG', 'Assistant Legal Counsel', 'Hong Kong', '2011-06-15', 'belinda.cheung', 'setsuo.suzuki', NULL, '2015-03-26 01:59:07'),
(37, 'carman.ng', '1w4zmhe', 'Carman Ng', 0, 0, 0, 'FNA', 'Accounting Supervisor', 'Hong Kong', '2011-06-21', 'eric.chan', 'kenny.kwan', NULL, '2015-03-26 01:59:07'),
(38, 'frankie.ho', '2pvi507', 'Frankie Ho', 1, 0, 0, 'COM', 'Deputy General Manager', 'Hong Kong', '2011-07-25', 'dmitriy.nadtochiy', 'setsuo.suzuki', NULL, '2015-03-26 01:59:07'),
(39, 'eric.chan', 'phr7ko4', 'Eric Chan', 0, 0, 0, 'FNA', 'Senior Finance Manager', 'Hong Kong', '2012-05-07', 'kenny.kwan', 'setsuo.suzuki', NULL, '2015-03-26 01:59:07'),
(40, 'tracy.fung', 'y0wrum1', 'Tracy Fung', 0, 0, 0, 'LEG', 'Legal and Legal Compliance Officer', 'Hong Kong', '2012-06-18', 'belinda.cheung', 'setsuo.suzuki', NULL, '2015-03-26 01:59:07'),
(41, 'monnie.au', 'rt9n0b7', 'Monnie Au', 0, 0, 0, 'COM', 'Assistant Manager', 'Hong Kong', '2014-07-02', 'frankie.ho', 'dmitriy.nadtochiy', NULL, '2015-03-26 01:59:07'),
(42, 'conny.tsim', 'sjbc5kd', 'Conny Tsim', 0, 0, 0, 'LOG', 'Manager', 'Hong Kong', '2012-08-20', 'takehiko.yamazaki', 'setsuo.suzuki', NULL, '2015-03-26 01:59:07'),
(43, 'takehiko.yamazaki', 'ml6k5i1', 'Takehiko Yamazaki', 1, 0, 1, 'LOG', 'General Manager', 'Hong Kong', '2013-02-14', 'setsuo.suzuki', 'hirotaka.suzuki', NULL, '2015-03-26 01:59:07'),
(44, 'doris.keung', 'p91cary', 'Doris Keung', 0, 0, 0, 'FNA', 'Project Manager', 'Hong Kong', '2013-07-07', 'kenny.kwan', 'setsuo.suzuki', NULL, '2015-03-26 01:59:07'),
(45, 'lauren.chow', '3cm7rxv', 'Lauren Chow', 0, 0, 0, 'COM', 'Officer, Operations', 'Hong Kong', '2013-07-22', 'angie.mok', 'frankie.ho', NULL, '2015-03-26 01:59:07'),
(46, 'ian.li', 'n6gquyh', 'Ian Li', 0, 0, 0, 'CPD', 'Officer ', 'Hong Kong', '2013-07-22', 'sam.leung', 'yuki.nakamura', NULL, '2015-03-26 01:59:07'),
(47, 'tommy.to', '2lth5e0', 'Tommy To', 0, 0, 0, 'FNA', 'Accounting Clerk', 'Hong Kong', '2013-08-07', 'eric.chan', 'kenny.kwan', NULL, '2015-03-26 01:59:07'),
(48, 'ryan.ho', '4720dgh', 'Ryan Ho', 0, 0, 0, 'CPD', 'Manager', 'Hong Kong', '2013-08-19', 'yuki.nakamura', 'setsuo.suzuki', NULL, '2015-03-26 01:59:07'),
(49, 'mark.lam', 'e2fvm0t', 'Mark Lam', 0, 0, 0, 'FNA', 'Senior Accounting Manager', 'Hong Kong', '2013-09-03', 'kenny.kwan', 'setsuo.suzuki', NULL, '2015-03-26 01:59:07'),
(50, 'martina.liu', 'h1rsdng', 'Martina Liu', 0, 0, 0, 'FNA', 'Accounting Clerk', 'Hong Kong', '2014-10-06', 'eric.chan', 'kenny.kwan', NULL, '2015-03-26 01:59:07'),
(51, 'angie.mok', 'v749bf6', 'Angie Mok', 0, 0, 0, 'COM', 'Head of Operations', 'Hong Kong', '2013-10-09', 'frankie.ho', 'dmitriy.nadtochiy', NULL, '2015-03-26 01:59:07'),
(52, 'kenneth.mok', 'jsg0exn', 'Kenneth Mok', 0, 0, 0, 'FNA', 'Senior Accountant', 'Hong Kong', '2013-10-09', 'mark.lam', 'kenny.kwan', NULL, '2015-03-26 01:59:07'),
(53, 'mallik.tummala', '2lznk06', 'Mallik Tummala', 0, 0, 0, 'CPD', 'Senior Manager', 'Hong Kong', '2013-10-21', 'sam.leung', 'yuki.nakamura', NULL, '2015-03-26 01:59:07'),
(54, 'collins.qian', '2wc0l5j', 'Collins Qian', 1, 0, 1, 'PCM', 'General Manager', 'Hong Kong', '2014-01-06', 'setsuo.suzuki', 'hirotaka.suzuki', NULL, '2015-03-26 01:59:07'),
(55, 'sam.chan', 'nduyqvj', 'Sam Chan', 0, 0, 0, 'COM', 'Assistant Manager', 'Hong Kong', '2014-03-13', 'frankie.ho', 'dmitriy.nadtochiy', NULL, '2015-03-26 01:59:07'),
(56, 'winnie.ko', '2cxb4pa', 'Winnie Ko', 0, 0, 0, 'COM', 'Supervisor, Operations', 'Hong Kong', '2014-03-24', 'angie.mok', 'frankie.ho', NULL, '2015-03-26 01:59:07'),
(57, 'celia.law', '93$j2cv', 'Celia Law', 0, 1, 0, 'HRA', 'Senior Manager', 'Hong Kong', '2014-03-24', 'vivien.chan', 'setsuo.suzuki', NULL, '2015-03-11 08:11:03'),
(58, 'kenji.yamamoto', 'k53pn4t', 'Kenji Yamamoto', 0, 0, 0, 'CPD', 'Senior Manager', 'Hong Kong', '2014-04-07', 'yuki.nakamura', 'setsuo.suzuki', NULL, '2015-03-26 01:59:07'),
(59, 'bhaskar.bhattacharyya', 'r9kyz5c', 'Bhaskar Bhattacharyya', 0, 0, 0, 'AML India', 'Manager, Documentation & Logistics', 'India', '2009-10-20', 'subhendu.ghosh', 'gautam.kumar', '', '2015-03-26 02:18:50'),
(60, 'das.anirban', 'y5vrhme', 'Das Anirban', 0, 0, 0, 'AML India', 'Officer, Documentation & Logistics', 'India', '2011-10-07', 'bhaskar.bhattacharyya', 'subhendu.ghosh', '', '2015-03-26 02:18:52'),
(61, 'paul.monideepa', 'd9fq17b', 'Paul Monideepa', 0, 0, 0, 'AML India', 'Officer, Accounting & Administration', 'India', '2013-10-15', 'subhendu.ghosh', 'gautam.kumar', '', '2015-03-26 02:18:55'),
(62, 'yukio.takase', 'fq593z6', 'Yukio Takase', 1, 0, 0, 'AML Japan', 'Director', 'Japan', '2002-12-16', 'daijiro.murai', 'setsuo.suzuki', '', '2015-03-26 02:19:19'),
(63, 'daijiro.murai', 'b7os0d9', 'Daijiro Murai', 1, 0, 1, 'AML Japan', 'President', 'Japan', '2005-07-01', 'setsuo.suzuki', 'hirotaka.suzuki', '', '2015-03-26 02:19:41'),
(64, 'rieko.iwasaki', 'ib5ea9n', 'Rieko Iwasaki', 0, 0, 0, 'AML Japan', 'Assistant Manager', 'Japan', '2005-08-18', 'daijiro.murai', 'setsuo.suzuki', '', '2015-03-26 02:19:24'),
(65, 'makoto.hazeyama', '8bfq1eh', 'Makoto Hazeyama', 0, 0, 0, 'AML Japan', 'Sales Manager', 'Japan', '2008-06-16', 'yukio.takase ', 'daijiro.murai', '', '2015-03-26 02:19:25'),
(66, 'toshie.kaneko', '4dafve7', 'Toshie Kaneko', 0, 0, 0, 'AML Japan', 'Accountant', 'Japan', '2008-07-16', 'daijiro.murai', 'setsuo.suzuki', '', '2015-03-26 02:19:28'),
(67, 'hidemi.hirasawa', 'n0k8ayj', 'Hidemi Hirasawa', 0, 0, 0, 'AML Japan', 'Administration Clerk', 'Japan', '2012-08-06', 'Toshie Kaneko', 'daijiro.murai', '', '2015-03-26 02:19:29'),
(68, 'yunjung.lee', '4plwit2', 'Yun Jung Lee', 0, 0, 0, 'AML Japan', 'Accountant / Sales Administrator', 'Korea', '2010-03-09', 'namkeuk.kim', 'setsuo.suzuki', '', '2015-03-26 02:19:31'),
(69, 'namkeuk.kim', 'w38z4kx', 'Nam Keuk Kim', 1, 0, 0, 'AML Japan', 'General Manager', 'Korea', '2012-09-10', 'setsuo.suzuki', 'hirotaka.suzuki', '', '2015-03-26 02:19:32'),
(70, 'soohyun.song', '7t4sw2v', 'Soo Hyun Song', 0, 0, 0, 'AML Japan', 'Sales & Purchase Manager', 'Korea', '2013-01-07', 'namkeuk.kim', 'setsuo.suzuki', '', '2015-03-26 02:19:34'),
(71, 'sandhaya.komal', '4nhiu2j', 'Sandhaya Komal', 0, 0, 0, 'AML SA', 'Finance Manager', 'South Africa', '2012-07-16', 'conri.moolman', 'hirotaka.suzuki', '', '2015-03-26 02:21:21'),
(72, 'delia.parsoot', 'h6d4vct', 'Delia Parsoot', 0, 0, 0, 'AML SA', 'Administration Assistant', 'South Africa', '2013-02-05', 'sandhaya.komal', 'conri.moolman', '', '2015-03-26 02:21:23'),
(73, 'paschal.masha', 'qz4wdk2', 'Paschal Masha', 0, 0, 0, 'AML SA', 'Project Engineer', 'South Africa', '2013-05-02', 'conri.moolman', 'hirotaka.suzuki', '', '2015-03-26 02:21:24'),
(74, 'tania.mabusa', '5r6opku', 'Tania Mabusa', 0, 0, 0, 'AML SA', 'Office Cleaner / Tea Lady', 'South Africa', '2013-07-01', 'sandhaya.komal', 'conri.moolman', '', '2015-03-26 02:21:26'),
(75, 'conri.moolman', '0tnjulz', 'Conri Moolman', 1, 0, 1, 'AML SA', 'President', 'South Africa', '2014-05-05', 'hirotaka.suzuki', 'setsuo.suzuki', '', '2015-03-26 02:21:30'),
(76, 'deveena.naido', '84rxcz1', 'Deveena Naido', 0, 0, 0, 'AML SA', 'Junior Accountant', 'South Africa', '2014-08-18', 'sandhaya.komal', 'conri.moolman', '', '2015-03-26 02:21:32'),
(77, 'adriaan.rossouw', 'iqsodrf', 'Adriaan Rossouw', 0, 0, 0, 'AML SA', 'Project Development Manager', 'South Africa', '2014-12-01', 'conri.moolman', 'hirotaka.suzuki', '', '2015-03-26 02:21:33'),
(78, 'alexander.skubenko', 'rlgn7tq', 'Alexander Skubenko', 1, 0, 1, 'AML Ukraine', 'Director', 'Ukraine', '2008-12-01', 'setsuo.suzuki', 'hirotaka.suzuki', '', '2015-03-26 02:21:51'),
(79, 'evgenia.vrubel', 'grqkfmx', 'Evgenia Vrubel', 0, 0, 0, 'AML Ukraine', 'Accountant and Sales Administrator', 'Ukraine', '2009-07-01', 'alexander.skubenko', 'setsuo.suzuki', '', '2015-03-26 02:21:52'),
(80, 'alexander.salnikov', '1kjp7xa', 'Alexander Salnikov', 1, 0, 0, 'AML Ukraine', 'Deputy Director', 'Ukraine', '2009-12-01', 'alexander.skubenko', 'setsuo.suzuki', '', '2015-03-26 02:21:54'),
(81, 'natalya.kluyko', '6uqh8zs', 'Natalya Kluyko', 0, 0, 0, 'AML Ukraine', 'Sales Support Assistant', 'Ukraine', '2011-07-01', 'alexander.skubenko', 'setsuo.suzuki', '', '2015-03-26 02:21:56'),
(82, 'stephanie.pryor', 'u1l5wom', 'Stephanie Pryor', 0, 0, 0, 'AML NA', 'Logistics Supervisor', 'USA', '2005-04-01', 'jay.cho', 'setsuo.suzuki', '', '2015-03-26 02:22:07'),
(83, 'jay.cho', 'kmyefln', 'Jay Cho', 1, 0, 1, 'AML NA', 'President', 'USA', '2007-07-27', 'setsuo.suzuki', 'hirotaka.suzuki', '', '2015-03-26 02:22:19'),
(84, 'edward.federouch', 'yvlco0w', 'Edward Federouch', 0, 0, 0, 'AML NA', 'Accountant', 'USA', '2010-05-01', 'jay.cho', 'setsuo.suzuki', '', '2015-03-26 02:22:12'),
(85, 'steven.chang', 'password', 'Steven Chang', 0, 0, 0, 'Pertama', 'Senior Human Resources & Administration Manager', 'Pertama', '2015-03-18', 'andrew.talling', 'hirotaka.suzuki', NULL, '2015-03-26 02:21:03'),
(86, 'amy.ong', 'password', 'Amg Ong', 0, 0, 0, 'Pertama', 'Human Resources Manager', 'Pertama', '2012-11-12', 'steven.chang', 'andrew.talling', NULL, '2015-03-26 02:21:07'),
(87, 'andrew.talling', 'password', 'Andre Talling', 1, 0, 1, 'Pertama', 'General Manager', 'Pertama', '2013-05-20', 'hirotaka.suzuki', 'setsuo.suzuki', NULL, '2015-03-26 02:21:10');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
