<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/


/*---------Frontend Routes-------------*/
$route['default_controller'] = 'user/login';
/*---------Backend Routes-------------*/

/** Authentication **/
$route['register']    = 'user/register';
$route['login']       = 'user/login';
$route['forgot']      = 'user/forgot';
$route['reset']       = 'user/resetPassword';
$route['dashboard']   = 'user/authenticate';
$route['logout']      = 'user/logout';


/** Admissions **/
//Form 1
$route['uploadAdmission1'] = 'admissions_controller_1/upload';
$route['admission1'] 	 = 'admissions_controller_1';
$route['clearAdmissions1'] = 'admissions_controller_1/clearAdmissions';


//Form 2
$route['uploadAdmission2'] = 'admissions_controller_2/upload';
$route['admission2'] 	 = 'admissions_controller_2';
$route['clearAdmissions2'] = 'admissions_controller_2/clearAdmissions';

//Form 3
$route['uploadAdmission3'] = 'admissions_controller_3/upload';
$route['admission3'] 	 = 'admissions_controller_3';
$route['clearAdmissions3'] = 'admissions_controller_3/clearAdmissions';

//Form 4
$route['uploadAdmission4'] = 'admissions_controller_4/upload';
$route['admission4'] 	 = 'admissions_controller_4';
$route['clearAdmissions4'] = 'admissions_controller_4/clearAdmissions';

//Stakeholders
$route['uploadStaff'] = 'stakeholder_controller/upload';
$route['staff'] 	 = 'stakeholder_controller';
$route['clearStakeholders'] = 'stakeholder_controller/clearStakeholders';



/** Exams **/
//Form 1
$route['uploadExams1'] = 'exams_controller_1/upload';
$route['exams1'] 	  = 'exams_controller_1';
$route['clearExams1'] = 'exams_controller_1/clearExams';

//Form 2
$route['uploadExams2'] = 'exams_controller_2/upload';
$route['exams2'] 	  = 'exams_controller_2';
$route['clearExams2'] = 'exams_controller_2/clearExams';


//Form 3
$route['uploadExams3'] = 'exams_controller_3/upload';
$route['exams3'] 	  = 'exams_controller_3';
$route['clearExams3'] = 'exams_controller_3/clearExams';

//Form 4
$route['uploadExams4'] = 'exams_controller_4/upload';
$route['exams4'] 	  = 'exams_controller_4';
$route['clearExams4'] = 'exams_controller_4/clearExams';


/** Payments **/
//Form 1
$route['uploadPayments1'] = 'payments_controller_1/upload';
$route['payments1'] 	  = 'payments_controller_1';
$route['clearPayments1'] = 'payments_controller_1/clearPayments';

//Form 2
$route['uploadPayments2'] = 'payments_controller_2/upload';
$route['payments2'] 	  = 'payments_controller_2';
$route['clearPayments2'] = 'payments_controller_2/clearPayments';

//Form 3
$route['uploadPayments3'] = 'payments_controller_3/upload';
$route['payments3'] 	  = 'payments_controller_3';
$route['clearPayments3'] = 'payments_controller_3/clearPayments';

//Form 4
$route['uploadPayments4'] = 'payments_controller_4/upload';
$route['payments4'] 	  = 'payments_controller_4';
$route['clearPayments4'] = 'payments_controller_4/clearPayments';

//Fee Structure
$route['uploadFeeStructure'] = 'fee_controller/upload';
$route['FeeStructure'] 	  = 'fee_controller';
$route['clearFeeStructure'] = 'fee_controller/clearFeeStructure';

//Payment Methods
$route['PaymentMethod'] 	  = 'PaymentMethod';
$route['clearPaymentMethod'] = 'PaymentMethod/clearPaymentMethod';

//Terms
$route['terms'] 	  = 'term_controller';
$route['clearTerms'] = 'term_controller/clearTerms';



/** Events **/
$route['events'] 	  = 'events_controller';
$route['clearEvents'] = 'events_controller/clearEvents';



/** SMS **/
$route['QuickSMS'] 	   = 'QuickSms';
$route['BulkSMS'] 	   = 'BulkSms';
$route['sendQuickSMS'] = 'QuickSms/sendQuickSMS';
$route['sendBulkSMS']  = 'BulkSms/sendBulkSMS';
$route['SMSLogs']  = 'SmsLogs';


/** Feedback **/
//Enquiries
$route['Feedback'] 	   = 'feedback_controller';
$route['sendFeedback'] = 'feedback_controller/sendFeedback';

//Bugs
$route['Bugs'] 	   = 'bug_controller';
$route['sendBugs'] = 'bug_controller/sendmail';


/** Settings **/
//Account
$route['profile'] 	     = 'profile_controller';
$route['password'] 	     = 'password_controller';
$route['changePassword'] = 'password_controller/changePassword';

//Groups
$route['groups'] 	  = 'group_controller';
$route['clearGroups'] = 'group_controller/clearGroups';

//Roles
$route['roles'] 	  = 'role_controller';
$route['clearRoles'] = 'role_controller/clearRoles';


/** Reports **/
//Invoice
$route['invoice'] 	   = 'invoice_controller';
$route['viewInvoice'] = 'invoice_controller/invoice';

//Downloads
$route['downloads'] 	= 'downloads_controller';
$route['downloadFile'] 	= 'downloads_controller/download';

/*---------Reserved Routes-------------*/
$route['404_override']         = '';
$route['translate_uri_dashes'] = FALSE;
