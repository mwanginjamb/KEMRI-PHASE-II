<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/28/2020
 * Time: 12:27 AM
 */


namespace frontend\controllers;

use common\models\HrloginForm;
use common\models\Hruser;
use common\models\SignupForm;
use frontend\models\Coverletter;
use frontend\models\Cv;
use frontend\models\HRPasswordResetRequestForm;
use frontend\models\HRResetPasswordForm;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use frontend\models\Applicantprofile;
use common\models\JobApplicationCard;
use frontend\models\ShortlistingCommitteeCard;



use frontend\models\Employeerequisition;
use frontend\models\Employeerequsition;
use frontend\models\Job;
use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use frontend\models\Employee;
use yii\web\Controller;
use yii\web\Response;

class RecruitmentController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','vacancies'],
                'rules' => [
                    [
                        'actions' => ['vacancies'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index','vacancies'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get'],
                ],
            ],
            'contentNegotiator' =>[
                'class' => ContentNegotiator::class,
                'only' => ['getvacancies','getexternalvacancies', 'getexperience', 'getprofessionalqualifications', 'getqualifications', 'get-my-short-listing-committees', 'get-applicants', 'getinternalvacancies','requirementscheck','getapplications','getinternalapplications',  'can-apply',  'get-requiremententries'],
                'formatParam' => '_format',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    //'application/xml' => Response::FORMAT_XML,
                ],
            ]
        ];
    }

    public function beforeAction($action){
        if(Yii::$app->user->isGuest){
            $this->layout = 'guest';
        }

        if (!parent::beforeAction($action)) {
            return false;
        }
        return true; // or false to not run the action
    }

    public function actionIndex(){

        //return $this->render('index');
        return $this->redirect(['recruitment/vacancies']);
    }



    public function actionDeclaration(){
        $model = new Applicantprofile();
        $service = Yii::$app->params['ServiceName']['JobApplicantProfile'];
        $filter = [
            'No' => Yii::$app->recruitment->getEmployeeApplicantProfile(),
        ];
        $modelData = Yii::$app->navhelper->getData($service, $filter);
        $model = $this->loadtomodel($modelData[0],$model);

        if($model->load(Yii::$app->request->post()) && Yii::$app->request->post()){
         
            $result = Yii::$app->navhelper->updateData($service,Yii::$app->request->post()['Applicantprofile']);

            if(is_object($result)){

                Yii::$app->session->setFlash('success','Profile Sucesfully Updated');
                return $this->redirect(Yii::$app->request->referrer);

            }else{

                Yii::$app->session->setFlash('error',$result);
                return $this->redirect(Yii::$app->request->referrer);

            }

        }

        

        return $this->render('declaration', [
            'model' => $model,
        ]);
    }

    public function actionApplications(){

        if(Yii::$app->session->has('HRUSER')){
            $this->layout = 'external';
        }
        return $this->render('applications');
    }

    public function actionInternalapplications(){
        return $this->render('internalapplications');
    }

    public function actionCreate(){

        $model = new Employeerequsition();


        $service = Yii::$app->params['ServiceName']['RequisitionEmployeeCard'];

        if(\Yii::$app->request->get('create') ){
            //make an initial empty request to nav
            $req = Yii::$app->navhelper->postData($service,[]);
            $model = $this->loadtomodel($req,$model);
        }

        $jobs = $this->getJobs();
        $requestReasons = $this->getRequestReasons();
        $employmentTypes = $this->getEmploymentTypes();
        $priority = $this->getPriority();
        $requisitionType = $this->getRequisitionTypes();
        $message = "";
        $success = false;

        if($model->load(Yii::$app->request->post()) && Yii::$app->request->post()){

            $result = Yii::$app->navhelper->updateData($service,Yii::$app->request->post()['Leave']);

            if(is_object($result)){

                Yii::$app->session->setFlash('success','Leave request Created Successfully',true);
                return $this->redirect(['view','ApplicationNo' => $result->Application_No]);

            }else{

                Yii::$app->session->setFlash('error','Error Creating Leave request: '.$result,true);
                return $this->redirect(['index']);

            }

        }



        return $this->render('create',[
            'model' => $model,
            'jobs' => $jobs,
            'requestReasons' => $requestReasons,
            'employmentTypes' => $employmentTypes,
            'priority' => $priority,
            'requisitionType' => $requisitionType

        ]);
    }

    public function actionUpdate($ApplicationNo){
        $service = Yii::$app->params['ServiceName']['reqApplicationCard'];
        $leaveTypes = $this->getLeaveTypes();
        $employees = $this->getEmployees();


        $filter = [
            'Application_No' => $ApplicationNo
        ];
        $result = Yii::$app->navhelper->getData($service, $filter);



        //load nav result to model
        $leaveModel = new Leave();

        $model = $this->loadtomodel($result[0],$leaveModel);



        if($model->load(Yii::$app->request->post()) && Yii::$app->request->post()){
            $result = Yii::$app->navhelper->updateData($model);


            if(!empty($result)){
                Yii::$app->session->setFlash('success','Leave request Updated Successfully',true);
                return $this->redirect(['view','ApplicationNo' => $result->Application_No]);
            }else{
                Yii::$app->session->setFlash('error','Error Updating Leave Request : '.$result,true);
                return $this->redirect(['index']);
            }

        }

        return $this->render('update',[
            'model' => $model,
            'leaveTypes' => ArrayHelper::map($leaveTypes,'Code','Description'),
            'relievers' => ArrayHelper::map($employees,'No','Full_Name')
        ]);
    }

    public function actionView($Job_ID){

       
        $service = Yii::$app->params['ServiceName']['JobsCard'];

        $filter = [
            'Job_Id' => $Job_ID
        ];

        $job = Yii::$app->navhelper->getData($service, $filter);
        // Yii::$app->recruitment->printrr($job);


    
        //Get the Job Requisition No

        if(empty($job[0]->Requisition_No)){
            Yii::$app->session->setFlash('error','You cannot apply for this job : Job ID ('.$job[0]->Requisition_No.') cannot be found in HR Requisitions List',true);
            return $this->redirect(['vacancies']);
        }

        
        return $this->render('view',[
            'model' => $job[0],
        ]);
    }

    public function getJobs(){
        $service = Yii::$app->params['ServiceName']['JobsList'];
        $jobs = \Yii::$app->navhelper->getData($service);
        (object)$result = [];

        foreach($jobs as $j){
            $result []= [
                'Job_ID' =>$j->Job_ID,
                'Job_Description' => !empty($j->Job_Description)? $j->Job_Description: 'Not Set'
            ];
        }

        return ArrayHelper::map($result,'Job_ID','Job_Description');
    }

    public function getRequestReasons(){

        $result = [
            ['Code' => 'New_Vacancy', 'Description' => 'New Vacancy'],
            ['Code' => 'Replacement', 'Description' => 'Replacement'],
            ['Code' => 'Retirement', 'Description' => 'Retirement'],
            ['Code' => 'Retrenchment', 'Description' => 'Retrenchment'],
            ['Code' => 'Demise', 'Description' => 'Demise'],
            ['Code' => 'Other', 'Description' => 'Other'],
        ];

        return ArrayHelper::map($result,'Code','Description');

    }

    public function getEmploymentTypes(){

        $result = [
            ['Code' => 'Permanent', 'Description' => 'Permanent'],
            ['Code' => 'Temporary', 'Description' => 'Temporary'],
            ['Code' => 'Voluntary', 'Description' => 'Voluntary'],
            ['Code' => 'Contract', 'Description' => 'Contract'],
            ['Code' => 'Interns', 'Description' => 'Interns'],
            ['Code' => 'Casuals', 'Description' => 'Casuals'],
        ];

        return ArrayHelper::map($result,'Code','Description');

    }

    public function getPriority(){
        $result = [
            ['Code' => '_blank_', 'Description' => '_blank_'],
            ['Code' => 'High', 'Description' => 'High'],
            ['Code' => 'Medium', 'Description' => 'Medium'],
            ['Code' => 'Low', 'Description' => 'Low'],

        ];

        return ArrayHelper::map($result,'Code','Description');
    }

    public function getRequisitionTypes(){

        $result = [
            ['Code' => '_blank_', 'Description' => '_blank_'],
            ['Code' => 'Internal', 'Description' => 'Internal'],
            ['Code' => 'External', 'Description' => 'External'],
            ['Code' => 'Both', 'Description' => 'Both'],

        ];

        return ArrayHelper::map($result,'Code','Description');

    }

    public function actionVacancies(){
        return $this->render('vacancies');
    }

    public function actionExternalvacancies(){
        if(Yii::$app->user->isGuest){
            $this->layout = 'external';
        }
        return $this->render('externalvacancies');
    }


    public function actionCanApply1($ProfileId, $JobId){
        //Get Job Requirements
       


        $data = [
            'profileNo' => $ProfileId,
            'requisitionNo' => $JobId,
        ];
        $Requirements = $this->ApplyForJob($data);
        

        // exit;

        if(is_array($Requirements)){
            //Render Ajax Modal

            return $this->renderAjax('confrim-requirements', [
                'Requirements' => $Requirements,
                'ProfileId'=>$ProfileId
            ]);

        }

        //Error Manenos

    }

    public function actionCanApply($ProfileId, $JobId){
        //Get Job Requirements

      

        $data = [
            'profileNo' => $ProfileId,
            'requisitionNo' => $JobId,
        ];


        $msg = [];

        // if(Yii::$app->recruitment->EmployeeUserHasProfile() === false){ //Employee has no Profile
        //     return $msg[] = [
        //         'error'=>1,
        //         'eror_message'=>'Kindly Fill in Your Recruitment Profile and Submit the Profile Before Applying for the Job',
        //     ];
        // }

        // if( Yii::$app->recruitment->HasApplicantAcceptedTermsAndConditions()){
        //     return $msg[] = [
        //         'error'=>1,
        //         'eror_message'=>'Kindly Accept out Terms and Conditions in your Profile Before Applying for the Job',
        //     ];
        // }

        // $HasAppliedForTheJob =  Yii::$app->recruitment->HasApplicantAppliedForTheJob(Yii::$app->recruitment->getEmployeeApplicantProfile(), $JobId);
        // if($HasAppliedForTheJob === true){
        //     return $msg[] = [
        //         'error'=>1,
        //         'eror_message'=>'You Have Already Applied For This Job',
        //     ];
        // }

        ///Apply for Job 
        $JobApplicationResult = $this->ApplyForJob($data);
        

        if(is_array($JobApplicationResult) && isset($JobApplicationResult['return_value'])){ //Success

            return $msg[] = [
                'error'=>0,
                'success'=>1,
                'success_message'=>'Succesfully Applied for This Job. Your Application No is '. $JobApplicationResult['return_value']
            ];

        }else{

            return $msg[] = [
                'error'=>1,
                'eror_message'=>$JobApplicationResult
            ];
        }     

    }
 

    public function actionGetexternalvacancies(){
        $service = Yii::$app->params['ServiceName']['JobsList'];
        $filter = [];
        $requisitions = \Yii::$app->navhelper->getData($service,$filter);
        // echo '<pre>';
        // print_r($requisitions);
        // exit;
        $result = [];

        if(!is_object($requisitions)){
            foreach($requisitions as $req){
                if(($req->No_Posts >= 0 && !empty($req->Job_Description) && !empty($req->Job_Id)) && ($req->Requisition_Type == 'External' || $req->Requisition_Type == 'Both')  ) {
                    
                    $ApplyLink = Html::a('Apply', ['view', 'Job_ID' => $req->Job_Id], [
                        'class' => 'btn btn-outline-success btn-md',
                        'data' => [
                            'params' => ['type' => 'External'],
                            'method' => 'post',
                        ],
                    ]);

                    $ViewJobLink = Html::a('View Details', ['view', 'Job_ID' => $req->Job_Id], [
                        'class' => 'btn btn-outline-success btn-md',
                        'data' => [
                            'params' => ['type' => 'External', ],
                            // 'method' => 'get',
                        ],
                    ]);
    
                    $result['data'][] = [
                        'Contract_Period' => !empty($req->Contract_Period) ? $req->Contract_Period : 'Not Set',
                        'Job_Description' => !empty($req->Job_Description) ? $req->Job_Description : '',
                        'No_of_Posts' => !empty($req->No_Posts) ? $req->No_Posts : 'Not Set',
                        'Start_Date' => !empty($req->Start_Date) ? $req->Start_Date : 'Not Set',
                        'End_Date' => !empty($req->End_Date) ? $req->End_Date : 'Not Set',
                        'ReqType' => !empty($req->Employment_Type) ? $req->Employment_Type : 'Not Set',
                        'action' => !empty($ViewJobLink) ? $ViewJobLink : '',
    
                    ];
    
                }
    
            }
        }
     
        return $result;
    }

    public function actionGetinternalvacancies(){
        $service = Yii::$app->params['ServiceName']['JobsList'];
        $filter = [];
        $requisitions = \Yii::$app->navhelper->getData($service,$filter);
        // echo '<pre>';
        // print_r($requisitions);
        // exit;
        $result = [];

        if(!is_object($requisitions)){
            foreach($requisitions as $req){
                if($req->Requisition_Type == 'External'){
                    continue;
                }
                if(($req->No_Posts >= 0 && !empty($req->Job_Description) && !empty($req->Job_Id))) {
                    
                    $ApplyLink = Html::a('Apply', ['view', 'Job_ID' => $req->Job_Id], [
                        'class' => 'btn btn-outline-success btn-md',
                        'data' => [
                            'params' => ['type' => 'External'],
                            'method' => 'post',
                        ],
                    ]);

                    $ViewJobLink = Html::a('View Details', ['view', 'Job_ID' => $req->Job_Id], [
                        'class' => 'btn btn-outline-success btn-md',
                        'data' => [
                            'params' => ['type' => 'External', ],
                            // 'method' => 'get',
                        ],
                    ]);
    
                    $result['data'][] = [
                        'Contract_Period' => !empty($req->Contract_Period) ? $req->Contract_Period : 'Not Set',
                        'Job_Description' => !empty($req->Job_Description) ? $req->Job_Description : '',
                        'No_of_Posts' => !empty($req->No_Posts) ? $req->No_Posts : 'Not Set',
                        'Start_Date' => !empty($req->Start_Date) ? $req->Start_Date : 'Not Set',
                        'End_Date' => !empty($req->End_Date) ? $req->End_Date : 'Not Set',
                        'ReqType' => !empty($req->Employment_Type) ? $req->Employment_Type : 'Not Set',
                        'action' => !empty($ViewJobLink) ? $ViewJobLink : '',
    
                    ];
    
                }
    
            }
        }
     
        return $result;
    }

    public function actionGetapplications(){

        $filter = [];
        $service = Yii::$app->params['ServiceName']['JobApplicationList'];

            if(!Yii::$app->user->isGuest){

                $filter = [
                    'Profile_No' => Yii::$app->recruitment->getEmployeeApplicantProfile()
                ];
            $applications = \Yii::$app->navhelper->getData($service,$filter);
            }
        $result = [];
        if(is_array($applications)){
            foreach($applications as $req){

                if(property_exists($req,'Requisition_No') && property_exists($req,'No') ) {
    
                    $result['data'][] = [
                        'No' => !empty($req->No) ? $req->No : 'Not Set',
                        'Applicant_Name' => !empty($req->Full_Name) ? $req->Full_Name : '',
                        'Requisition_No' => !empty($req->Job_Description) ? $req->Job_Description : 'Not Set',
                        'Application_Status' => !empty($req->Job_Application_status) ? $req->Job_Application_status : '',
    
                    ];
    
                }
    
            }
        }
        
        return $result;
    }

    public function actionGetApplicants($committeeId){
        if(!Yii::$app->user->isGuest){

            $filter = [
                'Shortlist_No'=>urldecode($committeeId),
                'Member_No'=> Yii::$app->user->identity->employee[0]->No,
            ];

            $service = Yii::$app->params['ServiceName']['ShortlistMemberEntries'];
    
            $Applicants = \Yii::$app->navhelper->getData($service,$filter);
        
    
            $result = [];
            if(is_array($Applicants)){
                foreach($Applicants as $Applicant){
    
                    if(property_exists($Applicant,'Profile_No') && property_exists($Applicant,'Applicant_Name') ) {
        
                        $ViewApplicantProfile = Html::a('View Applicant Details', [
                            'applicant-details', 
                            'ProfileID' => $Applicant->Profile_No ,
                            'ComitteID'=>urlencode($committeeId),
                            'ApplicationID'=>$Applicant->Applicant_No,
                            ], [
                        ]);
    
                                // Yii::$app->recruitment->printrr($ComiteeDetails);
                        $result['data'][] = [
                            'ApplicantName' => !empty($Applicant->Applicant_Name) ? $Applicant->Applicant_Name : 'Not Set',
                            'Shotlisting Status' => !empty($Applicant->Status) ? $Applicant->Status : '',
                            'Action'=>$ViewApplicantProfile  
                        ];
        
                    }
        
                }
            }
            
            return $result;

        }
    }

    public function actionApplicantDetails($ProfileID, $ComitteID, $ApplicationID){

            $model = new Applicantprofile();
            $service = Yii::$app->params['ServiceName']['JobApplicantProfile'];
    
            $filter = [
                'No' => urldecode($ProfileID),
            ];
            $result = Yii::$app->navhelper->getData($service, $filter);
            $model->CommiteeID = urldecode($ComitteID);
            $model->ApplicationID = urldecode($ApplicationID);
   
            $model = $this->loadtomodel($result[0],$model);  
    
            // Yii::$app->recruitment->printrr($result);  
    
          
    
            $Countries = $this->getCountries();
            $PostalCodes = $this->getPostalCodes();
            return $this->render('update',[
                'model' => $model,
                'countries' => ArrayHelper::map($Countries,'Code','Name'),
                'PostalCodes' => ArrayHelper::map($PostalCodes,'Code','Name'),
    
                // 'religion' => [],
    
            ]);
    }

    public function actionQualification($ProfileID, $ComitteID, $ApplicationID){

        $model = new Applicantprofile();
        $service = Yii::$app->params['ServiceName']['JobApplicantProfile'];

        $filter = [
            'No' => urldecode($ProfileID),
        ];
        $result = Yii::$app->navhelper->getData($service, $filter);
        $model->CommiteeID = urldecode($ComitteID);
        $model->ApplicationID = urldecode($ApplicationID);


        $model = $this->loadtomodel($result[0],$model);  

        return $this->render('qualification', [
            'model' => $model,
        ]);

    }


    

    public function actionGetprofessionalqualifications($ProfileID){
        $service = Yii::$app->params['ServiceName']['ApplicantProfQualifications'];

        $filter = [
            //'Qualification_Code' => 'PROFESSIONAL',
            'Employee_No' =>urldecode($ProfileID)
        ];
        $EducationQualifications = \Yii::$app->navhelper->getData($service,$filter);
        
        // print '<pre>';
        // print_r($EducationQualifications); exit;

        $result = [];
        $count = 0;
        if(is_array($EducationQualifications)){
            foreach($EducationQualifications as $quali){

                ++$count;
                $link = $updateLink =  '';
                $updateLink = Html::a('Edit',['update','Line'=> $quali->Line_No , 'DocNo'=> $quali->Employee_No],['class'=>'update btn btn-outline-info btn-md']);

                $link = Html::a('Delete',['delete','Key'=> $quali->Key ],['class'=>'btn btn-outline-warning btn-md','data' => [
                    'confirm' => 'Are you sure you want to delete this qualification?',
                    'method' => 'post',
                ]]);

                $qualificationLink = !empty($quali->Attachement_path)? Html::a('View Document',['read','path'=> $quali->Attachement_path ],['class'=>'btn btn-outline-warning btn-xs']):$quali->Line_No;
                $result['data'][] = [
                    'index' => $count,
                    'Key' => $quali->Key,
                    'Employee_No' => !empty($quali->Employee_No)?$quali->Employee_No:'',
                    'Professional_Examiner' => !empty($quali->Professional_Examiner)?$quali->Professional_Examiner:'',
                    'From_Date' => !empty($quali->From_Date)?$quali->From_Date:'',
                    'To_Date' => !empty($quali->To_Date)?$quali->To_Date:'',
                    'Specialization' => !empty($quali->Specialization)?$quali->Specialization:'',
                    'Action' => $updateLink . $link,
                    'Remove' => $link,
                    'Edit' => $updateLink

                ];
            }
        }
            
        
        return $result;



    }


    public function actionProffesionalQualifications($ProfileID, $ComitteID, $ApplicationID){
        
        $model = new Applicantprofile();
        $service = Yii::$app->params['ServiceName']['JobApplicantProfile'];
        $model->CommiteeID = urldecode($ComitteID);


        $filter = [
            'No' => urldecode($ProfileID),
        ];
        $result = Yii::$app->navhelper->getData($service, $filter);
        $model->CommiteeID = urldecode($ComitteID);
        $model->ApplicationID = urldecode($ApplicationID);
        $model = $this->loadtomodel($result[0],$model);  


        return $this->render('proffesional-qualifications', [
            'model' => $model,
        ]);


    }

    public function actionSubmitAssesment($ComiteeID){
        $service = Yii::$app->params['ServiceName']['JobApplication'];
       $data = [
           'shortListNo' => urldecode( $ComiteeID),
           'memberNo' => Yii::$app->user->identity->employee[0]->No ,
       ];

       $result = Yii::$app->navhelper->CodeUnit($service,$data,'IanSubmitAssesment');

       if(!is_string($result))
       {
           Yii::$app->session->setFlash('success', 'Assesment Submitted Successfuly');
       }else
       {
           Yii::$app->session->setFlash('error', $result);
       }

       return $this->redirect(['my-short-lisitng-committees']);
   }

    public function actionWorkExperience($ProfileID, $ComitteID, $ApplicationID){
        $model = new Applicantprofile();
        $service = Yii::$app->params['ServiceName']['JobApplicantProfile'];
        $model->CommiteeID = urldecode($ComitteID);

        $filter = [
            'No' => urldecode($ProfileID),
        ];
        $result = Yii::$app->navhelper->getData($service, $filter);
        $model->CommiteeID = urldecode($ComitteID);
        $model->ApplicationID = urldecode($ApplicationID);

        $model = $this->loadtomodel($result[0],$model);  

        return $this->render('experience', [
            'model' => $model,
        ]);
    }

    public function actionGetexperience($ProfileID){
        $service = Yii::$app->params['ServiceName']['experience'];
        $filter = ['Job_Application_No' => urldecode($ProfileID)];
        $experience = \Yii::$app->navhelper->getData($service, $filter);

        $result = [];
        $count = 0;
        foreach($experience as $exp){
          if(!empty($exp->Job_Application_No) && !empty($exp->Position)){
              ++$count;
              $link = $updateLink =  '';


              $updateLink = Html::a('Edit',['update','Line'=> $exp->Line_No ],['class'=>'update btn btn-info btn-md']);

              $link = Html::a('Delete',['delete','Key'=> $exp->Key ],['class'=>'btn btn-danger btn-md','data' => [
                  'confirm' => 'Are you sure you want to delete this record?',
                  'method' => 'post',
              ]]);

              if($exp->Currently_Working_Here == 1){
                  $WorksHere = 'Yes';
              }else{
                $WorksHere = 'No';
              }


              $result['data'][] = [
                  'index' => $count,
                  'Key' => $exp->Key,
                  'Position' => $exp->Position,
                  'End_Date'=>$exp->End_Date,
                  'Start_Date'=>$exp->Start_Date,
                  'Job_Description' => $exp->Job_Description,
                  'Institution' => !empty($exp->Institution)? $exp->Institution : '',
                  'Action' => $updateLink.' | '.$link,
                  'Currently_Working_Here' =>$WorksHere
                  //'Remove' => $link
              ];
          }

        }

        return $result;
    }

    public function actionShortlist($ProfileID, $ComitteID){
         $service = Yii::$app->params['ServiceName']['JobApplication'];
        $data = [
            'applicantNo' => urldecode( $ProfileID),
            'memberNo' => Yii::$app->user->identity->employee[0]->No ,
        ];

        $result = Yii::$app->navhelper->CodeUnit($service,$data,'IanShortListEntry');

        if(!is_string($result))
        {
            Yii::$app->session->setFlash('success', 'Candidate Shorlisted Successfuly');
        }else
        {
            Yii::$app->session->setFlash('error', $result);
        }

        return $this->redirect(['applicants', 'ComiteeID'=>urlencode($ComitteID)]);
    }

    public function actionRejectCandidate(){
        $service = Yii::$app->params['ServiceName']['JobApplication'];
        $ComitteID = Yii::$app->request->post('ComitteID');

        $data = [
            'applicantNo' =>Yii::$app->request->post('ProfileID'),
            'memberNo' => Yii::$app->user->identity->employee[0]->No ,
            'rejectionComment' =>Yii::$app->request->post('comment'),
        ];

       $result = Yii::$app->navhelper->CodeUnit($service,$data,'IanRejectListEntry');

       Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

       if(!is_string($result)){
           //Yii::$app->session->setFlash('success', 'Perfomance Appraisal Goals Rejected and Sent Back to Appraisee Successfully.', true);
           return ['note' => '<div class="alert alert-success alert-dismissable">Candidate Rejected Succesfully.</div>'];
       }else{

          // Yii::$app->session->setFlash('error', 'Error Rejecting Performance Appraisal Goals : '. $result);
           return ['note' => '<div class="alert alert-danger alert-dismissable">'.$result];


       }

       return $this->redirect(['applicants', 'ComiteeID'=>urlencode($ComitteID)]);
    }


    

    public function actionGetqualifications($ProfileID){
        $service = Yii::$app->params['ServiceName']['EducationQualifications'];

        $filter = [
            'Employee_No' =>  $ProfileID

        ];
        $EducationQualifications = \Yii::$app->navhelper->getData($service,$filter);
        // print '<pre>';
        // print_r($EducationQualifications); exit;
        $result = [];
        $count = 0;
        if(is_array($EducationQualifications)){
            foreach($EducationQualifications as $quali){

                ++$count;
                $link = $updateLink =  '';
    
    
                $updateLink = Html::a('<i class="fa fa-edit"></i>',['update','Line'=> $quali->Line_No ],['class'=>'update btn btn-outline-info btn-xs','title' => 'Update Qualification']);
    
                if(!empty($quali->Attachement_path)){
                    $deletelink = Html::a('<i class="fa fa-trash"></i>',['delete','Key'=> $quali->Key,'path' => $quali->Attachement_path ],['class'=>'btn btn-outline-warning btn-xs','title' => 'Remove Qualification','data' => [
                        'confirm' => 'Are you sure you want to delete this qualification?',
                        'method' => 'post',
                    ]]);
                }else{
                    $deletelink = Html::a('<i class="fa fa-trash"></i>',['delete','Key'=> $quali->Key ],['class'=>'btn btn-outline-warning btn-xs','title' => 'Remove Qualification','data' => [
                        'confirm' => 'Are you sure you want to delete this qualification?',
                        'method' => 'post',
                    ]]);
                }
    
                //for sharepoint use "download" for local fs use "read"
                $qualificationLink = !empty($quali->Attachement_path)? Html::a('View Document',['read','path'=> $quali->Attachement_path ],['class'=>'btn btn-outline-warning btn-xs']):$quali->Line_No;
    
    
                $result['data'][] = [
                    'index' => $count,
                    'Key' => $quali->Key,
                    'Level' => !empty($quali->Level)?$quali->Level:'',
                    'Academic_Qualification' => !empty($quali->Academic_Qualification)?$quali->Academic_Qualification:'',
                    'Employee_No' => !empty($quali->Employee_No)?$quali->Employee_No:'',
                    'Qualification_Code' => $qualificationLink,
                    'From_Date' => !empty($quali->From_Date)?$quali->From_Date:'',
                    'To_Date' => !empty($quali->To_Date)?$quali->To_Date:'',
                    'Description' => !empty($quali->Description)?$quali->Description:'',
                    'Institution_Company' => !empty($quali->Institution_Company)?$quali->Institution_Company:'',
                    //'Comment' => !empty($quali->Comment)?$quali->Comment:'',
    
                    'Action' => $updateLink.' | '.$deletelink,
                    //'Remove' => $link
                ];
            }
        }
        

        return $result;
    }

    public function getCountries(){
        $service = Yii::$app->params['ServiceName']['Countries'];

        $res = [];
        $countries = \Yii::$app->navhelper->getData($service);
        foreach($countries as $c){
            if(!empty($c->Name))
            $res[] = [
                'Code' => $c->Code,
                'Name' => $c->Name
            ];
        }

        return $res;
    }


    
    public function getPostalCodes(){
        $service = Yii::$app->params['ServiceName']['PostalCodes'];

        $res = [];
        $PostalCodes = \Yii::$app->navhelper->getData($service);
        foreach($PostalCodes as $PostalCode){
            if(!empty($PostalCode->Code))
            $res[] = [
                'Code' => $PostalCode->Code,
                'Name' => $PostalCode->City
            ];
        }

        return $res;
    }

    public function getReligion(){
        $service = Yii::$app->params['ServiceName']['Religion'];
        $filter = [
            'Type' => 'Religion'
        ];
        $religion = \Yii::$app->navhelper->getData($service, $filter);
        return $religion;
    }


    public function actionMyShortLisitngCommittees(){//shortlist-committee.php
        if(!Yii::$app->user->isGuest){
            return $this->render('shortlist-committee');
        }
    }

    public function actionGetMyShortListingCommittees(){//shortlist-committee.php

        $filter = [];
        $service = Yii::$app->params['ServiceName']['ShortlistingCommitteeMembers'];

            if(!Yii::$app->user->isGuest){
                $filter = [
                    'Commitee_No' => Yii::$app->user->identity->employee[0]->No,
                    'Invite_Status'=>'In_Progress'
                ];
                $CommitteeMembers = \Yii::$app->navhelper->getData($service,$filter);
            }

        $result = [];
        if(is_array($CommitteeMembers)){
            foreach($CommitteeMembers as $CommitteeMember){

                if(property_exists($CommitteeMember,'ShortList_No') && property_exists($CommitteeMember,'Commitee_No') ) {

                    $ComiteeDetails = $this->getComiteeDetails($CommitteeMember->ShortList_No);

                    if ($ComiteeDetails == false){ //No Comitee Found
                        continue;
                    }

                    $ViewApplicantsLink = Html::a('view Applicants', ['applicants', 'ComiteeID' => $ComiteeDetails[0]->No], [
                        'class' => 'btn btn-outline-success btn-md',
                    ]);

                            // Yii::$app->recruitment->printrr($ComiteeDetails);

                    $result['data'][] = [
                        'No' => !empty($CommitteeMember->ShortList_No) ? $CommitteeMember->ShortList_No : 'Not Set',
                        'JobDescription' => !empty($ComiteeDetails[0]->Job_Description) ? $ComiteeDetails[0]->Job_Description : '',
                        'Requisition_Purpose' => !empty($ComiteeDetails[0]->Requisition_Purpose) ? $ComiteeDetails[0]->Requisition_Purpose : 'Not Set',  
                        'Action'=>$ViewApplicantsLink  
                    ];
    
                }
    
            }
        }
        
        return $result;
    }

    public function getComiteeDetails($commiteeNo){
        $service = Yii::$app->params['ServiceName']['ShortlistingCommitteeCard'];
        $filter = [
            'No' => $commiteeNo
        ];
        $result = \Yii::$app->navhelper->getData($service,$filter);
        if(is_array($result)){ //Comiteee Exists
            return $result;
        }
        return false;
    }

    public function actionApplicants($ComiteeID){
        if(!Yii::$app->user->isGuest){
            $model = new ShortlistingCommitteeCard();
            $data =  $this->getComiteeDetails(urldecode($ComiteeID));
            if($data){
                $this->loadtomodel($data[0], $model);
                return $this->render('applicants', [
                    'model' => $model,
                ]);
            }
        }
    }


    //Get Internal Applications

    public function actionGetinternalapplications(){
        if(!Yii::$app->user->isGuest){
            $srvc = Yii::$app->params['ServiceName']['employeeCard'];
            $filter = [
                'No' => Yii::$app->user->identity->employee[0]->No
            ];
            $Employee = Yii::$app->navhelper->getData($srvc,$filter);
            if(empty($Employee[0]->ProfileID)){
                return [];
            }
            $profileID = $Employee[0]->ProfileID;

        }else{ //if for some reason this check is called by a guest ,return false;
            return [];
        }

        $service = Yii::$app->params['ServiceName']['HRJobApplicationsList'];
        $filter = [
            'Applicant_No' => $profileID
        ];
        $applications = \Yii::$app->navhelper->getData($service,$filter);
        $result = [];
        foreach($applications as $req){

            if(property_exists($req,'Job_Description') && property_exists($req,'Applicant_No') ) {

                $result['data'][] = [
                    'Job_Application_No' => !empty($req->Job_Application_No) ? $req->Job_Application_No : 'Not Set',
                    'Applicant_Name' => !empty($req->Applicant_Name) ? $req->Applicant_Name : '',
                    'Job_Description' => !empty($req->Job_Description) ? $req->Job_Description : 'Not Set',
                    'Application_Status' => !empty($req->Application_Status) ? $req->Application_Status : '',

                ];

            }

        }
        return $result;
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $this->layout = 'login';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new HrloginForm();


        if ($model->load(Yii::$app->request->post()) && $model->login()) {
           // Yii::$app->recruitment->printrr(Yii::$app->session->get('HRUSER'));
            //var_dump(Yii::$app->session->get('HRUSER')->username); exit;
            //return $this->goBack();//reroute to recruitment profile page
            return $this->redirect(['recruitment/externalvacancies']);

        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        if(Yii::$app->session->has('HRUSER')){
            Yii::$app->session->remove('HRUSER');
            return $this->redirect(['recruitment/externalvacancies']);
        }
        return $this->redirect(['recruitment/externalvacancies']);

       // return $this->goHome();
    }

    public function actionSignup()
    {
        $this->layout = 'login';
        $model = new SignupForm(); //This signup form in common is for registering external hrusers
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $model->goHome();//redirect to recruitment login
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }





    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $this->layout = 'login';
        $model = new HRPasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->redirect(['recruitment/login']);
                //return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        $this->layout = 'login';
        try {
            $model = new HRResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->redirect(['recruitment/login']);

            // return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }





    public function actionVerifyEmail($token)
    {

        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }


        if ($user = $model->verifyEmail($HRUser = true)) {
           /* if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }*/
           Yii::$app->session->setFlash('success', 'Your email has been confirmed, Welcome !');
           return $this->redirect(['applicantprofile/create']);
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    public function actionSubmit(){
        // Yii::$app->recruitment->printrr($_SESSION);
        if(Yii::$app->session->has('mode') && Yii::$app->session->get('mode') == 'external'){
            $this->layout = 'external';
        }

        //Check if the user has a requisition no

        if(!Yii::$app->session->has('REQUISITION_NO')){
            Yii::$app->session->setFlash('error','Kindly select a position to apply for.');
                if(Yii::$app->session->has('HRUSER')){
                    return $this->redirect(['externalvacancies']);
                }else{
                    return $this->redirect(['vacancies']);
                }

        }



        $model = new Applicantprofile();

        //get Applicant No
        $ApplicationNo = Yii::$app->recruitment->getEmployeeApplicantProfile();




        if(Yii::$app->request->isPost){

            if(!empty(Yii::$app->request->post()['Applicantprofile']['Motivation'])){ //Update motivation letter
                $service = Yii::$app->params['ServiceName']['applicantProfile'];
                $filter = [
                    'No' => $ApplicationNo,
                ];
                $modelData = Yii::$app->navhelper->getData($service, $filter);
                $model = $this->loadtomodel($modelData[0],$model);
                $model->Motivation = Yii::$app->request->post()['Applicantprofile']['Motivation'];
                $res = Yii::$app->navhelper->updateData($service,$model);
            }










            $data = [
                'profileNo' => $ApplicationNo,
                'requisitionNo' => Yii::$app->session->get('REQUISITION_NO'),
            ];
            $res = [];
            if(!strlen(Yii::$app->session->get('Job_Applicant_No'))){
                $res = $this->getRequiremententries($data);
                Yii::$app->session->set('REQ_ENTRIES',$res);
                $refreshed_entries = [];
                if(is_array($res)){ // refresh the entries to get this that are marked as met

                }
            }else{
                $requirementEntriesService = Yii::$app->params['ServiceName']['JobApplicantRequirementEntries'];
                $Job_Applicant_No = Yii::$app->session->get('Job_Applicant_No');
                $refreshed_entries = Yii::$app->navhelper->getData($requirementEntriesService,['Job_Applicant_No' => $Job_Applicant_No]);
            }


            if(!is_string($res)){
                Yii::$app->session->setFlash('success', 'Congratulations, Job Application submitted successfully.', true);
            }else{
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to submit your application now : '. $result);
            }
        }
        

       // Yii::$app->recruitment->printrr(Yii::$app->session->get('REQ_ENTRIES'));
        return $this->render('submit',[
            'model' => $model,
            'requirements' => !empty($refreshed_entries)?$refreshed_entries:Yii::$app->session->get('REQ_ENTRIES'),
            'cvmodel' => new Cv(),
            'covermodel' => new Coverletter()
        ]);

    }

    public function ApplyForJob($data){
        $HRJobApplicationsCardService = Yii::$app->params['ServiceName']['HRJobApplicationsCard'];

        $service = Yii::$app->params['ServiceName']['JobApplication'];

        return Yii::$app->navhelper->Jobs($service,$data,'IanGenerateEmployeeRequirementEntries');


    }

    public function actionRequirementscheck(){
        $service = Yii::$app->params['ServiceName']['JobApplicantRequirementEntries'];
        $data = [
            'Key' => Yii::$app->request->post('Key'),
            'Line_No' => Yii::$app->request->post('Line_No'),
            'Met' => True,
        ];

        $result = Yii::$app->navhelper->updateData($service,$data);
        Yii::$app->session->setFlash('success','Job Requirement Specification Updated Successfully.');
        return $result;
    }

//Downloads cv or cover letter from share point and renders it in html view
    public function actionDownload($path){
        if(Yii::$app->session->has('mode') && Yii::$app->session->get('mode') == 'external'){
            $this->layout = 'external';
        }
        $base = basename($path);
        /* $ctx = Yii::$app->recruitment->connectWithAppOnlyToken(
             Yii::$app->params['sharepointUrl'],
             Yii::$app->params['clientID'],
             Yii::$app->params['clientSecret']
         );*/
        $ctx = Yii::$app->recruitment->connectWithUserCredentials(Yii::$app->params['sharepointUrl'],Yii::$app->params['sharepointUsername'],Yii::$app->params['sharepointPassword']);
        $fileUrl = '/'.Yii::$app->params['library'].'/'.$base;
        $targetFilePath = './qualifications/download.pdf';
        $resource = Yii::$app->recruitment->downloadFile($ctx,$fileUrl,$targetFilePath);

        return $this->render('readsharepoint',[
            'content' => $resource
        ]);


    }

    public function loadtomodel($obj,$model){

        if(!is_object($obj)){
            return false;
        }
        $modeldata = (get_object_vars($obj)) ;//get properties of given object
        foreach($modeldata as $key => $val){
            if(is_object($val)) continue;
            $model->$key = $val;
        }

        return $model;
    }

    

}