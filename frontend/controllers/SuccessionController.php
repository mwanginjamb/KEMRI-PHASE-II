<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/19/2022
 * Time: 9:25 AM
 */

namespace frontend\controllers;
use frontend\models\Employeeappraisalkra;

use frontend\models\Probation;
use frontend\models\Succession;
use stdClass;
use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;

use yii\web\Response;


class SuccessionController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [
                    'logout',
                     'signup',
                     'index',
                     'create',
                     'update',
                     'delete',
                     'view',
                     'objective-setting',
                     'appraisee-list',
                     'supervisor-list',
                     'hr-list',
                     'closed-list'
                    ],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','index','create','update','delete',
                        'view',
                        'objective-setting',
                        'appraisee-list',
                        'supervisor-list',
                        'hr-list',
                        'closed-list'
                    ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'submit-plan' => ['post'],
                ],
            ],
            'contentNegotiator' =>[
                'class' => ContentNegotiator::class,
                'only' => [
                    'list-evaluation',
                    'list-evaluator',
                    'list-objective-setting',
                    'list-appraisee',
                    'list-supervisor',
                    'list-hr',
                    'list-closed',
                    'answers',
                    'preferred-answers',
                    'recommendations'

                ],
                'formatParam' => '_format',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    //'application/xml' => Response::FORMAT_XML,
                ],
            ]
        ];
    }

    public function beforeAction($action)
    {

        $ExceptedActions = ['answers','preferred-answers','recommendations'];

        if (in_array($action->id , $ExceptedActions) ) {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    public function actionEvaluationList(){

        $service = Yii::$app->params['ServiceName']['SuccessionEvaluationList'];
        $filter = [
            //'Employee_No' => Yii::$app->user->identity->{'Employee No_'},
        ];

        $list = Yii::$app->navhelper->getData($service, $filter);

        return $this->render('evaluation-list', ['model' => $list]);

    }

    public function actionEvaluationListEvaluator(){

        $service = Yii::$app->params['ServiceName']['SuccessionEvaluationListEvaluator'];
        $filter = [
            //'Employee_No' => Yii::$app->user->identity->{'Employee No_'},
        ];

        $list = Yii::$app->navhelper->getData($service, $filter);

        

        return $this->render('evaluation-list-evaluator',['model' => $list]);

    }

    public function actionObjectiveSetting(){


        return $this->render('objective-setting');

    }

    public function actionAppraiseeList(){


        return $this->render('appraisee-list');

    }

     public function actionSupervisorList(){


        return $this->render('supervisor-list');

    }

    public function actionHrList(){


        return $this->render('hr-list');

    }

    public function actionClosedList(){


        return $this->render('closed-list');

    }

    // Answers Endpoint

    public function actionAnswers()
    {
        $answers = [
            '_blank_' => '_blank_',
            'Yes' => 'Yes',
            'No' => 'No'
        ];

        return $answers;
    }

    // Preferred answers Endpoint

    public function actionPreferredAnswers()
    {
        $answers = [
            '_blank_' => '_blank_',
            'Yes' => 'Yes',
            'No' => 'No'
        ];

        return $answers;
    }

    // Recommendation Endpoint

    public function actionRecommendations()
    {
        $answers = [
            '_blank_' => '_blank_',
            'Recomend' => 'Recomend',
            'Decline' => 'Decline'
        ];

        return $answers;
    }

     /** Updates a single field */
     public function actionSetfield($field){
        $service = 'ImprestRequestCardPortal';
        $value = Yii::$app->request->post('fieldValue');
       
        $result = Yii::$app->navhelper->Commit($service,[$field => $value],Yii::$app->request->post('Key'));
        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;
        return $result;
          
    }


    /**
     * Grid Commitment Function
     */

    public function actionCommit(){
        $commitService = Yii::$app->request->post('service');
        $key = Yii::$app->request->post('key');
        $name = Yii::$app->request->post('name');
        $value = Yii::$app->request->post('value');

        $service = Yii::$app->params['ServiceName'][$commitService];
        $request = Yii::$app->navhelper->readByKey($service, $key);
        $data = [];
        if(is_object($request)){
            $data = [
                'Key' => $request->Key,
                $name => $value
            ];
        }else{
            Yii::$app->response->format = \yii\web\response::FORMAT_JSON;
            return ['error' => $request];
        }

        $result = Yii::$app->navhelper->updateData($service,$data);
        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;
        return $result;

    }

   

    


  

    public function actionDelete(){
        $service = Yii::$app->params['ServiceName']['experience'];
        $result = Yii::$app->navhelper->deleteData($service,Yii::$app->request->get('Key'));
        if(!is_string($result)){
            Yii::$app->session->setFlash('success','Work Experience Purged Successfully .',true);
            return $this->redirect(['index']);
        }else{
            Yii::$app->session->setFlash('error','Error Purging Work Experience: '.$result,true);
            return $this->redirect(['index']);
        }
    }

    public function actionView($Employee_No = '', $Appraisal_No = '', $Key = ''){
        $service = Yii::$app->params['ServiceName']['SuccessionAppraisalCard'];
        $model = new Succession();

        $filter = [
            'Appraisal_No' => $Appraisal_No,
            'Employee_No' => $Employee_No,
        ];

        $document = new stdClass();
        if(!empty($Key))
        {
            $document = Yii::$app->navhelper->readByKey($service, $Key);
        }else if(!empty($Employee_No) && !empty($Appraisal_No)){
            $document = Yii::$app->navhelper->getData($service, $filter)[0];
        }

       $model =  Yii::$app->navhelper->loadmodel($document, $model);

    
        //Yii::$app->recruitment->printrr($model->getObjectives());


        $action = [
            '_blank_' => '_blank_',
            'Recomend' => 'Recomend',
            'Reject' => 'Reject'
        ];

        // Make a choice of the render based on model states

        return $this->render('view',[
            'model' => $model,
            'document' => $document,
            'action' => $action
        ]);
    }






    public function actionApprovalRequest($app){
        $service = Yii::$app->params['ServiceName']['Portal_Workflows'];
        $data = ['applicationNo' => $app];

        $request = Yii::$app->navhelper->SendLeaveApprovalRequest($service, $data);

        if(is_array($request)){
            Yii::$app->session->setFlash('success','Leave request sent for approval Successfully',true);
            return $this->redirect(['index']);
        }else{
            Yii::$app->session->setFlash('error','Error sending leave request for approval: '.$request,true);
            return $this->redirect(['index']);
        }
    }

    public function actionCancelRequest($app){
        $service = Yii::$app->params['ServiceName']['Portal_Workflows'];
        $data = ['applicationNo' => $app];

        $request = Yii::$app->navhelper->CancelLeaveApprovalRequest($service, $data);

        if(is_array($request)){
            Yii::$app->session->setFlash('success','Leave Approval Request Cancelled Successfully',true);
            return $this->redirect(['index']);
        }else{
            Yii::$app->session->setFlash('error','Error Cancelling Leave Approval: '.$request,true);
            return $this->redirect(['index']);
        }
    }


    // Lists


    /**
     * Objective setting List
     */
    public function actionListObjectiveSetting(){
        $service = Yii::$app->params['ServiceName']['SuccessionObjectiveSettingList'];
        $filter = [
           // 'Employee_No' => Yii::$app->user->identity->{'Employee No_'},
        ];
        $appraisals = \Yii::$app->navhelper->getData($service,$filter);
        //ksort($appraisals);
        $result = [];

        if(is_array($appraisals)){
            foreach($appraisals as $req){

                $Viewlink = Html::a('View', ['view'], 
                [
                    'class' => 'btn btn-outline-primary btn-xs',
                    'data' => [
                        'params' => [
                            'Key' => $req->Key
                        ],
                        'method' => 'GET'
                    ]
                ]);

                $result['data'][] = [
                    'Appraisal_No' => !empty($req->Appraisal_No) ? $req->Appraisal_No : 'Not Set',
                    'Employee_Name' => !empty($req->Employee_Name) ? $req->Employee_Name : 'Not Set',
                    'Level_Grade' => !empty($req->Level_Grade) ? $req->Level_Grade : 'Not Set',
                    'Job_Title' => !empty($req->Job_Title) ? $req->Job_Title : '',
                    'Appraisal_Start_Date' =>  !empty($req->Appraisal_Start_Date) ?$req->Appraisal_Start_Date : '',
                    'Appraisal_End_Date' =>  !empty($req->Appraisal_End_Date) ?$req->Appraisal_End_Date : '',
                    'Action' => !empty($Viewlink) ? $Viewlink : '',

                ];

            }
        }

        return $result;
    }


    // Supervisor Objectives List

    public function actionGetLinemanagerobjlist(){
        $service = Yii::$app->params['ServiceName']['LnManagerObjList'];
        $filter = [
            'Supervisor_No' => Yii::$app->user->identity->{'Employee No_'},
        ];
        $appraisals = \Yii::$app->navhelper->getData($service,$filter);
        //ksort($appraisals);
        $result = [];

        if(is_array($appraisals)){
            foreach($appraisals as $req){

                $Viewlink = Html::a('View', ['view','Employee_No' => $req->Employee_No, 'Appraisal_No' => !empty($req->Appraisal_No)?$req->Appraisal_No: ''], ['class' => 'btn btn-outline-primary btn-xs']);

                $result['data'][] = [
                    'Appraisal_No' => !empty($req->Appraisal_No) ? $req->Appraisal_No : 'Not Set',
                    'Employee_No' => !empty($req->Employee_No) ? $req->Employee_No : '',
                    'Employee_Name' => !empty($req->Employee_Name) ? $req->Employee_Name : 'Not Set',
                    'Level_Grade' => !empty($req->Level_Grade) ? $req->Level_Grade : 'Not Set',
                    'Job_Title' => !empty($req->Job_Title) ? $req->Job_Title : '',
                    'Appraisal_Start_Date' =>  !empty($req->Appraisal_Start_Date) ?$req->Appraisal_Start_Date : '',
                    'Appraisal_End_Date' =>  !empty($req->Appraisal_End_Date) ?$req->Appraisal_End_Date : '',
                    
                    'Action' => !empty($Viewlink) ? $Viewlink : '',

                ];

            }
        }

        return $result;
    }


    // Overview Mgr Objectives List

    public function actionGetoverviewmgrobjlist(){
        $service = Yii::$app->params['ServiceName']['ProbationOverviewObjList'];
        $filter = [
            'Overview_Manager' => Yii::$app->user->identity->{'Employee No_'},
        ];
        $appraisals = \Yii::$app->navhelper->getData($service,$filter);
        //ksort($appraisals);
        $result = [];

        if(is_array($appraisals)){
            foreach($appraisals as $req){

                $Viewlink = Html::a('View', ['view','Employee_No' => $req->Employee_No, 'Appraisal_No' => !empty($req->Appraisal_No)?$req->Appraisal_No: ''], ['class' => 'btn btn-outline-primary btn-xs']);

               
                $result['data'][] = [
                    'Appraisal_No' => !empty($req->Appraisal_No) ? $req->Appraisal_No : 'Not Set',
                    'Employee_No' => !empty($req->Employee_No) ? $req->Employee_No : '',
                    'Employee_Name' => !empty($req->Employee_Name) ? $req->Employee_Name : 'Not Set',
                    'Level_Grade' => !empty($req->Level_Grade) ? $req->Level_Grade : 'Not Set',
                    'Job_Title' => !empty($req->Job_Title) ? $req->Job_Title : '',
                    'Appraisal_Start_Date' =>  !empty($req->Appraisal_Start_Date) ?$req->Appraisal_Start_Date : '',
                    'Appraisal_End_Date' =>  !empty($req->Appraisal_End_Date) ?$req->Appraisal_End_Date : '',
                    
                    'Action' => !empty($Viewlink) ? $Viewlink : '',

                ];

            }
        }

        return $result;
    }

    public function actionAppraiseeapprovedgoals(){
        $service = Yii::$app->params['ServiceName']['ProbationAppraiseeList'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->{'Employee No_'},
        ];
        $appraisals = \Yii::$app->navhelper->getData($service,$filter);
        //ksort($appraisals);
        $result = [];

        if(is_array($appraisals)){
            foreach($appraisals as $req){

                $Viewlink = Html::a('View', ['view','Employee_No' => $req->Employee_No, 'Appraisal_No' => !empty($req->Appraisal_No)?$req->Appraisal_No: ''], ['class' => 'btn btn-outline-primary btn-xs']);

                $result['data'][] = [
                    'Appraisal_No' => !empty($req->Appraisal_No) ? $req->Appraisal_No : 'Not Set',
                    'Employee_No' => !empty($req->Employee_No) ? $req->Employee_No : '',
                    'Employee_Name' => !empty($req->Employee_Name) ? $req->Employee_Name : 'Not Set',
                    'Level_Grade' => !empty($req->Level_Grade) ? $req->Level_Grade : 'Not Set',
                    'Job_Title' => !empty($req->Job_Title) ? $req->Job_Title : '',
                    'Appraisal_Start_Date' =>  !empty($req->Appraisal_Start_Date) ?$req->Appraisal_Start_Date : '',
                    'Appraisal_End_Date' =>  !empty($req->Appraisal_End_Date) ?$req->Appraisal_End_Date : '',
                    
                    'Action' => !empty($Viewlink) ? $Viewlink : '',

                ];

            }
        }

        return $result;
    }

    public function actionSupervisorprobationlist(){
        $service = Yii::$app->params['ServiceName']['ProbationLnmanagerList'];
        $filter = [
            'Supervisor_No' => Yii::$app->user->identity->{'Employee No_'},
        ];
        $appraisals = \Yii::$app->navhelper->getData($service,$filter);
        //ksort($appraisals);
        $result = [];

        if(is_array($appraisals)){
            foreach($appraisals as $req){

                $Viewlink = Html::a('View', ['view','Employee_No' => $req->Employee_No, 'Appraisal_No' => !empty($req->Appraisal_No)?$req->Appraisal_No: ''], ['class' => 'btn btn-outline-primary btn-xs']);

                $result['data'][] = [
                    'Appraisal_No' => !empty($req->Appraisal_No) ? $req->Appraisal_No : 'Not Set',
                    'Employee_No' => !empty($req->Employee_No) ? $req->Employee_No : '',
                    'Employee_Name' => !empty($req->Employee_Name) ? $req->Employee_Name : 'Not Set',
                    'Level_Grade' => !empty($req->Level_Grade) ? $req->Level_Grade : 'Not Set',
                    'Job_Title' => !empty($req->Job_Title) ? $req->Job_Title : '',
                    'Appraisal_Start_Date' =>  !empty($req->Appraisal_Start_Date) ?$req->Appraisal_Start_Date : '',
                    'Appraisal_End_Date' =>  !empty($req->Appraisal_End_Date) ?$req->Appraisal_End_Date : '',
                    
                    'Action' => !empty($Viewlink) ? $Viewlink : '',

                ];

            }
        }

        return $result;
    }


    public function actionOverviewprobationlist(){
        $service = Yii::$app->params['ServiceName']['OverviewSupervisorList'];
        $filter = [
            'Overview_Manager' => Yii::$app->user->identity->{'Employee No_'},
        ];
        $appraisals = \Yii::$app->navhelper->getData($service,$filter);
        //ksort($appraisals);
        $result = [];

        if(is_array($appraisals)){
            foreach($appraisals as $req){

                $Viewlink = Html::a('View', ['view','Employee_No' => $req->Employee_No, 'Appraisal_No' => !empty($req->Appraisal_No)?$req->Appraisal_No: ''], ['class' => 'btn btn-outline-primary btn-xs']);

                $result['data'][] = [
                    'Appraisal_No' => !empty($req->Appraisal_No) ? $req->Appraisal_No : 'Not Set',
                    'Employee_No' => !empty($req->Employee_No) ? $req->Employee_No : '',
                    'Employee_Name' => !empty($req->Employee_Name) ? $req->Employee_Name : 'Not Set',
                    'Level_Grade' => !empty($req->Level_Grade) ? $req->Level_Grade : 'Not Set',
                    'Job_Title' => !empty($req->Job_Title) ? $req->Job_Title : '',
                    'Appraisal_Start_Date' =>  !empty($req->Appraisal_Start_Date) ?$req->Appraisal_Start_Date : '',
                    'Appraisal_End_Date' =>  !empty($req->Appraisal_End_Date) ?$req->Appraisal_End_Date : '',
                    
                    'Action' => !empty($Viewlink) ? $Viewlink : '',

                ];

            }
        }

        return $result;
    }

    public function actionGetagreementlist(){
        $service = Yii::$app->params['ServiceName']['ProbationAgreementList'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->{'Employee No_'},
        ];
        $appraisals = \Yii::$app->navhelper->getData($service,$filter);
        //ksort($appraisals);
        $result = [];

        if(is_array($appraisals)){
            foreach($appraisals as $req){

                $Viewlink = Html::a('View', ['view','Employee_No' => $req->Employee_No, 'Appraisal_No' => !empty($req->Appraisal_No)?$req->Appraisal_No: ''], ['class' => 'btn btn-outline-primary btn-xs']);

                $result['data'][] = [
                    'Appraisal_No' => !empty($req->Appraisal_No) ? $req->Appraisal_No : 'Not Set',
                    'Employee_No' => !empty($req->Employee_No) ? $req->Employee_No : '',
                    'Employee_Name' => !empty($req->Employee_Name) ? $req->Employee_Name : 'Not Set',
                    'Level_Grade' => !empty($req->Level_Grade) ? $req->Level_Grade : 'Not Set',
                    'Job_Title' => !empty($req->Job_Title) ? $req->Job_Title : '',
                    'Appraisal_Start_Date' =>  !empty($req->Appraisal_Start_Date) ?$req->Appraisal_Start_Date : '',
                    'Appraisal_End_Date' =>  !empty($req->Appraisal_End_Date) ?$req->Appraisal_End_Date : '',
                    
                    'Action' => !empty($Viewlink) ? $Viewlink : '',

                ];

            }
        }

        return $result;
    }


    public function actionClosedappraisallist(){
        $service = Yii::$app->params['ServiceName']['ClosedProbationAppraisal'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->{'Employee No_'},
        ];
        $appraisals = \Yii::$app->navhelper->getData($service,$filter);
        //ksort($appraisals);
        $result = [];

        if(is_array($appraisals)){
            foreach($appraisals as $req){

                $Viewlink = Html::a('View', ['view','Employee_No' => $req->Employee_No, 'Appraisal_No' => !empty($req->Appraisal_No)?$req->Appraisal_No: ''], ['class' => 'btn btn-outline-primary btn-xs']);

                $result['data'][] = [
                    'Appraisal_No' => !empty($req->Appraisal_No) ? $req->Appraisal_No : 'Not Set',
                    'Employee_No' => !empty($req->Employee_No) ? $req->Employee_No : '',
                    'Employee_Name' => !empty($req->Employee_Name) ? $req->Employee_Name : 'Not Set',
                    'Level_Grade' => !empty($req->Level_Grade) ? $req->Level_Grade : 'Not Set',
                    'Job_Title' => !empty($req->Job_Title) ? $req->Job_Title : '',
                    'Appraisal_Start_Date' =>  !empty($req->Appraisal_Start_Date) ?$req->Appraisal_Start_Date : '',
                    'Appraisal_End_Date' =>  !empty($req->Appraisal_End_Date) ?$req->Appraisal_End_Date : '',
                    
                    'Action' => !empty($Viewlink) ? $Viewlink : '',

                ];

            }
        }

        return $result;
    }

    public function actionReportview(){
        return $this->render('_viewreport',[
            'content'=>$this->actionReport()
        ]);
    }

    public function Getleavebalance(){
        $service = Yii::$app->params['ServiceName']['leaveBalance'];
        $filter = [
            'No' => Yii::$app->user->identity->{'Employee No_'},
        ];

        $balances = \Yii::$app->navhelper->getData($service,$filter);
        $result = [];

        //print '<pre>';
        // print_r($balances);exit;

        foreach($balances as $b){
            $result = [
                'Key' => $b->Key,
                'Annual_Leave_Bal' => $b->Annual_Leave_Bal,
                'Maternity_Leave_Bal' => $b->Maternity_Leave_Bal,
                'Paternity' => $b->Paternity,
                'Study_Leave_Bal' => $b->Study_Leave_Bal,
                'Compasionate_Leave_Bal' => $b->Compasionate_Leave_Bal,
                'Sick_Leave_Bal' => $b->Sick_Leave_Bal
            ];
        }

        return $result;

    }



    public function getAppraisalrating(){
        $service = Yii::$app->params['ServiceName']['AppraisalRating'];
        $filter = [
        ];

        $ratings = \Yii::$app->navhelper->getData($service,$filter);
        return $ratings;
    }

    public function getPerformancelevels(){
        $service = Yii::$app->params['ServiceName']['PerformanceLevel'];

        $ratings = \Yii::$app->navhelper->getData($service);
        return $ratings;
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

    public function getReligion(){
        $service = Yii::$app->params['ServiceName']['Religion'];
        $filter = [
            'Type' => 'Religion'
        ];
        $religion = \Yii::$app->navhelper->getData($service, $filter);
        return $religion;
    }



/**
 * Actions
 */


    //Submit Appraisal to supervisor

    public function actionSubmit($appraisalNo,$employeeNo)
    {
        $service = Yii::$app->params['ServiceName']['AppraisalWorkflow'];
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 1,
            'approvalURL' => Yii::$app->urlManager->createAbsoluteUrl(['succession/view', 'Appraisal_No' =>$appraisalNo, 'Employee_No' =>$employeeNo ])
        ];

        $result = Yii::$app->navhelper->Codeunit($service,$data,'IanSendGoalSettingForApproval');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Document Submitted Successfully.', true);
            return $this->redirect(['index']);
        }else{

            Yii::$app->session->setFlash('error', 'Error Submitting Document : '. $result);
            return $this->redirect(['index']);

        }

    }




    /*Send to Agreement*/

    public function actionAgreementlevel($appraisalNo,$employeeNo)
    {
        $service = Yii::$app->params['ServiceName']['AppraisalWorkflow'];
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 1,
            'approvalURL' => Yii::$app->urlManager->createAbsoluteUrl(['probation/superproblist'])
        ];

        $result = Yii::$app->navhelper->Codeunit($service,$data,'IanSendEYAppraisalToAgreementLevel');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Probation Appraisal Send to Agreement Successfully.', true);
            return $this->redirect(['view','Appraisal_No' => $appraisalNo,'Employee_No' => $employeeNo]);
        }else{

            Yii::$app->session->setFlash('error', 'Error Sending to Agreement : '. $result);
            return $this->redirect(['view','Appraisal_No' => $appraisalNo,'Employee_No' => $employeeNo]);

        }

    }



    public function actionSubmittooverview($appraisalNo,$employeeNo)
    {
        $service = Yii::$app->params['ServiceName']['AppraisalWorkflow'];
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 1,
            'approvalURL' => Yii::$app->urlManager->createAbsoluteUrl(['succession/view', 'Appraisal_No' =>$appraisalNo, 'Employee_No' =>$employeeNo ])
        ];

        $result = Yii::$app->navhelper->Codeunit($service,$data,'IanSendGoalSettingToOverview');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Document Submitted Successfully.', true);
            return $this->redirect(['supervisor-list']);
        }else{

            Yii::$app->session->setFlash('error', 'Error Submitting Document : '. $result);
            return $this->redirect(['supervisor-list']);

        }

    }





    public function actionApprovegoals($appraisalNo,$employeeNo)
    {
        $service = Yii::$app->params['ServiceName']['AppraisalWorkflow'];
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 1,
            
        ];

        $result = Yii::$app->navhelper->Codeunit($service,$data,'IanApproveGoalSetting');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Appraisal Goals Approved Successfully.', true);
            return $this->redirect(['hr-list']);
        }else{

            Yii::$app->session->setFlash('error', 'Error   : '. $result);
            return $this->redirect(['hr-list']);

        }

    }


     public function actionBacktosuper($appraisalNo,$employeeNo)
    {
        $service = Yii::$app->params['ServiceName']['AppraisalWorkflow'];
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 1,
            'approvalURL' => 1,
            'rejectionComments' => 'The Appraisal is not conclusive and hence rejected.'
        ];

        $result = Yii::$app->navhelper->IanSendNewEmployeeAppraisalBackToSupervisor($service,$data);

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Document Sent Back to Supervisor Successfully.', true);
            return $this->redirect(['hr-list']);
        }else{

            Yii::$app->session->setFlash('error', 'Error Sending Document Back to Supervisor  : '. $result);
            return $this->redirect(['hr-list']);

        }

    }

    public function actionBacktoemp()
    {
        $service = Yii::$app->params['ServiceName']['AppraisalWorkflow'];
        $appraisalNo = Yii::$app->request->post('Appraisal_No');
        $employeeNo = Yii::$app->request->post('Employee_No');
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 1,
            'approvalURL' => Yii::$app->urlManager->createAbsoluteUrl(['probation/view', 'Appraisal_No' =>$appraisalNo, 'Employee_No' =>$employeeNo ]),
            'rejectionComments' => Yii::$app->request->post('comment'),
        ];

        $result = Yii::$app->navhelper->Codeunit($service,$data,'IanSendGoalSettingBackToAppraisee');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Document Sent Back to Appraisee Successfully.', true);
            return $this->redirect(['supervisor-list']);
        }else{

            Yii::$app->session->setFlash('error', 'Error Sending Document Back to Appraisee  : '. $result);
            return $this->redirect(['supervisor-list']);

        }

    }


    /*Submit Back to Line Mgr*/

    public function actionBacktolinemgr()
    {
        $service = Yii::$app->params['ServiceName']['AppraisalWorkflow'];
        $appraisalNo = Yii::$app->request->post('Appraisal_No');
        $employeeNo = Yii::$app->request->post('Employee_No');
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 1,
            'approvalURL' => Yii::$app->urlManager->createAbsoluteUrl(['probation/view', 'Appraisal_No' =>$appraisalNo, 'Employee_No' =>$employeeNo ]),
            'rejectionComments' => Yii::$app->request->post('comment'),
        ];

        $result = Yii::$app->navhelper->Codeunit($service,$data,'IanSendGoalSettingBackToLineManager');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Document sent to Supervisor with comments Successfully.', true);
            return $this->redirect(['hr-list']);
        }else{

            Yii::$app->session->setFlash('error', 'Error  : '. $result);
            return $this->redirect(['hr-list']);

        }

    }

    // Submit Probation to Line Mgr

    public function actionSubmitprobationtolinemgr($appraisalNo,$employeeNo)
    {
        $service = Yii::$app->params['ServiceName']['AppraisalWorkflow'];
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 1,
            'approvalURL' => Yii::$app->urlManager->createAbsoluteUrl(['succession/view', 'Appraisal_No' =>$appraisalNo, 'Employee_No' =>$employeeNo ])
        ];

        $result = Yii::$app->navhelper->Codeunit($service,$data,'IanSendEYAppraisalForApproval');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Document Submitted Successfully.', true);
            return $this->redirect(['appraisee-list']);
        }else{

            Yii::$app->session->setFlash('error', 'Error Submitting Document : '. $result);
            return $this->redirect(['appraisee-list']);

        }

    }

    // Reject Probation and send it back to appraisee

    public function actionProbationbacktoappraisee()
    {
        $service = Yii::$app->params['ServiceName']['AppraisalWorkflow'];
        $appraisalNo = Yii::$app->request->post('Appraisal_No');
        $employeeNo = Yii::$app->request->post('Employee_No');
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 1,
            'approvalURL' => Yii::$app->urlManager->createAbsoluteUrl(['succession/view', 'Appraisal_No' =>$appraisalNo, 'Employee_No' =>$employeeNo ]),
            'rejectionComments' => Yii::$app->request->post('comment'),
        ];

        $result = Yii::$app->navhelper->Codeunit($service,$data,'IanSendEYAppraisaBackToAppraisee');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Document Sent Back to Appraisee with Comments Successfully.', true);
            return $this->redirect(['supervisor-list']);
        }else{

            Yii::$app->session->setFlash('error', 'Error  : '. $result);
            return $this->redirect(['supervisor-list']);

        }

    }


    
// Overview Manager Sending Probation Appraisal Back to Line Mgr

     public function actionOverviewbacktolinemgr()
    {
        $service = Yii::$app->params['ServiceName']['AppraisalWorkflow'];
        $appraisalNo = Yii::$app->request->post('Appraisal_No');
        $employeeNo = Yii::$app->request->post('Employee_No');
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 1,
            'approvalURL' => Yii::$app->urlManager->createAbsoluteUrl(['succession/view','Appraisal_No' => $appraisalNo,'Employee_No' => $employeeNo]),
            'rejectionComments' => Yii::$app->request->post('comment'),
        ];

        $result = Yii::$app->navhelper->Codeunit($service,$data,'IanSendEYAppraisaBackToLineManager');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Document sent Bank to Supervisor with Comments Successfully.', true);
            return $this->redirect(['hr-list']);
        }else{

            Yii::$app->session->setFlash('error', 'Error  : '. $result);
            return $this->redirect(['hr-list']);

        }

    }





    public function actionReport(){

        $service = Yii::$app->params['ServiceName']['PortalReports'];

        if(Yii::$app->request->post()){

            $data = [
                'appraisalNo' =>Yii::$app->request->post('appraisalNo'),
                'employeeNo' => Yii::$app->request->post('employeeNo')
            ];
            $path = Yii::$app->navhelper->Codeunit($service,$data,'IanGenerateNewEmployeeAppraisalReport');
            //Yii::$app->recruitment->printrr($path);
            if(!is_file($path['return_value'])){

                return $this->render('report',[
                    'report' => false,
                    'message' => $path['return_value']
                ]);
            }
            $binary = file_get_contents($path['return_value']); //fopen($path['return_value'],'rb');
            $content = chunk_split(base64_encode($binary));
            //delete the file after getting it's contents --> This is some house keeping
            //unlink($path['return_value']);

            // Yii::$app->recruitment->printrr($path);
            return $this->render('report',[
                'report' => true,
                'content' => $content,
            ]);
        }

        return $this->render('report',[
            'report' => false,
            'content' => '',
        ]);

    }

    // Planning Actions

    public function actionSubmitPlan()
    {
        $service = Yii::$app->params['ServiceName']['HRSUCCESSIONPLANNING'];
        $params = [
            'evaluationNo' => Yii::$app->request->post('evaluationNo')
        ];

        $result = Yii::$app->navhelper->codeunit($service, $params,'IanSubmitSuccessionPlanningCandidate');
        
        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Document sent Successfully.', true);
            return $this->redirect(['evaluation-list']);
        }else{

            Yii::$app->session->setFlash('error', 'Error  : '. $result);
            return $this->redirect(['evaluation-list']);

        }
    }

    public function actionSubmitPlanEvaluator()
    {
        $service = Yii::$app->params['ServiceName']['HRSUCCESSIONPLANNING'];
        $params = [
            'evaluationNo' => Yii::$app->request->post('evaluationNo')
        ];

        $result = Yii::$app->navhelper->codeunit($service, $params,'IanSubmitSuccessionPlanningEvaluator');
        
        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Document sent Successfully.', true);
            return $this->redirect(['evaluation-list']);
        }else{

            Yii::$app->session->setFlash('error', 'Error  : '. $result);
            return $this->redirect(['evaluation-list']);

        }
    }

}