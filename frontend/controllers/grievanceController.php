<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:21 PM
 */

namespace frontend\controllers;

use frontend\models\EmployeeTraining;
use frontend\models\Grievance;
use frontend\models\Induction;

use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\Response;

class GrievanceController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','signup','index','list','create','update','delete','list-hro','hro'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','index','list', 'create', 'update','delete','list-hro','hro' ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
            'contentNegotiator' =>[
                'class' => ContentNegotiator::class,
                'only' => ['list','list-hro'],
                'formatParam' => '_format',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    //'application/xml' => Response::FORMAT_XML,
                ],
            ]
        ];
    }

    public function actionIndex(){

        return $this->render('index');

    }

    public function actionHro(){

        return $this->render('hro');

    }

    
 


    public function actionCreate(){

        $model = new Grievance();
        $service = Yii::$app->params['ServiceName']['GrievanceCard'];
       
        // Once Initial Request is Made Redirect to Update Page

            $model->Employee_No = Yii::$app->user->identity->{'Employee No_'};
            $model->Date_of_grievance = date('Y-m-d');
            $request = Yii::$app->navhelper->postData($service,$model);
            if(is_object($request)){
                return $this->redirect(['update','Key' => $request->Key]);
            }else{ // error situation
                Yii::$app->session->setFlash('error',$request, true);
                return $this->redirect(['index']);
            }
       
    }

    

    public function actionUpdate($No = '', $Key = ''){
        $model = new Grievance();
        $service = Yii::$app->params['ServiceName']['GrievanceCard'];
        $model->isNewRecord = false;

        // Get Document
        if(!empty($No))
        {
            $document = Yii::$app->navhelper->findOne($service,'No',$No);    
        }elseif(!empty($Key)){
            $document = Yii::$app->navhelper->readByKey($service,$Key);    
        }else{
            //Yii::$app->session->setFlash('error', 'We are unable to fetch a document to update', true);
            return Yii::$app->redirect(['index']);
        }

        if(is_object($document)){
            //load nav result to model
            $model = Yii::$app->navhelper->loadmodel($document,$model) ;//$this->loadtomodeEmployee_Nol($result[0],$Expmodel);
        }else{
            Yii::$app->session->setFlash('error', $document, true);
            return Yii::$app->redirect(['index']);
        }


    
        return $this->render('update',[
            'model' => $model,
            'document' => $document,
            'employees' =>  Yii::$app->navhelper->dropdown('Employees','No','Full_Name'),
            'complaintTypes' =>  Yii::$app->navhelper->dropdown('TypeofComplaints','Complaint','Complaint'),
            'severity' => Yii::$app->navhelper->dropdown('OffenceSeverity','Severity','Severity')
        ]);
    }

    public function actionDelete(){
        $service = Yii::$app->params['ServiceName']['AcademicTraining'];
        $result = Yii::$app->navhelper->deleteData($service,Yii::$app->request->get('Key'));
        // Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!is_string($result)){

            Yii::$app->session->setFlash('success','Record Purged Successfully.');
            return $this->redirect(['index']);
        }else{
            
            Yii::$app->session->setFlash('error','Error Purging Record: '.$result);
            return $this->redirect(['index']);
        }
    }

    public function actionView($No = '', $Key = ''){
        $service = Yii::$app->params['ServiceName']['GrievanceCard'];
        $model = new Grievance();

       // Get Document
       if(!empty($No))
       {
           $document = Yii::$app->navhelper->findOne($service,'No',$No);
       }elseif(!empty($Key)){
           $document = Yii::$app->navhelper->readByKey($service,$Key);
       }else{
          // Yii::$app->session->setFlash('error', 'We are unable to fetch the document', true);
           return $this->redirect(['index']);
       }

        //load nav result to model
        $model = Yii::$app->navhelper->loadmodel($document, $model);

        return $this->render('view',[
            'model' => $model,
            'document' =>  $document
        ]);
    }


    public function actionList(){
        $service = Yii::$app->params['ServiceName']['GrievanceList'];

        $filter = [
            'Employee_No' => \Yii::$app->user->identity->{'Employee No_'},
        ];
        $records = \Yii::$app->navhelper->getData($service,$filter);

        $result = [];
        $count = 0;
        
            foreach($records as $quali){

                if(empty($quali->Employee_No))
                {
                    continue;
                }

                ++$count;
                $Deletelink = $updateLink = $viewLink = $applyLink = $sendForApproval =  '';
                $updateLink = ($quali->Status == 'New')? Html::a('<i class="fa fa-edit"></i>',['update','Key'=> $quali->Key ],['class'=>' mx-1 update btn btn-outline-info btn-xs', 'title' => 'Update Record']): '';
                $viewLink = Html::a('<i class="fa fa-eye"></i>',['view','Key'=> $quali->Key ],['class'=>'btn btn-outline-info btn-xs mx-2', 'title' => 'View Document']);
                $sendForApproval = ($quali->Status == 'New')? Html::a('<i class="fa fa-forward"></i>',['send-to-hro'],[
                    'class'=>'btn btn-outline-success btn-xs mx-2',
                    'title' => 'Send to HRO',
                    'data' => [
                        'params' => [
                            'No'=> $quali->No
                        ],
                        'confirm' => 'Are you sure you want to send this request for approval?',
                        'method' => 'post'
                    ]
                    ]): '';
                $cancelApproval = ($quali->Status == 'Pending_Approval')? Html::a('<i class="fa fa-times"></i>',['cancelApprovalRequest','No'=> $quali->No ],['class'=>'btn btn-outline-warning btn-xs mx-2', 'title' => 'Cancel Approval Request']): '';


                $Deletelink = Html::a('<i class="fa fa-trash"></i>',['delete','Key'=> $quali->Key ],['class'=>'btn btn-outline-danger btn-xs text-danger',
                    'title' => 'Delete Record.',
                    'data' => [
                    'confirm' => 'Are you sure you want to delete this record?',
                    'method' => 'post',
                ]]);

               
                $result['data'][] = [
                    'index' => $count,
                    'Employee_No' => !empty($quali->Employee_No)?$quali->Employee_No:'',
                    'Employee_Name' => !empty($quali->Employee_Name)?$quali->Employee_Name:'',
                    'Grievance_Against' => !empty($quali->Grievance_Against)?$quali->Grievance_Against:'',
                    'Name' => !empty($quali->Name)?$quali->Name:'',
                    'Grievance_Type' => !empty($quali->Grievance_Type)?$quali->Grievance_Type:'',
                    'Status' => !empty($quali->Status)?$quali->Status:'',
                    'Action' => $viewLink. $updateLink.$sendForApproval ,
                                      
                ];
            
        }
        return $result;

    } 

    public function actionListHro(){
        $service = Yii::$app->params['ServiceName']['HROGrievanceList'];

        $filter = [
            //'HRO_Emp_No' => \Yii::$app->user->identity->{'Employee No_'},
        ];
        $records = \Yii::$app->navhelper->getData($service,$filter);

        $result = [];
        $count = 0;
        
            foreach($records as $quali){

                if(empty($quali->Employee_No))
                {
                    continue;
                }

                ++$count;
                $Deletelink = $updateLink = $viewLink = $applyLink = $sendForApproval =  '';
                $updateLink = ($quali->Status == 'HRO')? Html::a('<i class="fa fa-edit"></i>',['update','Key'=> $quali->Key ],['class'=>' mx-1 update btn btn-outline-info btn-xs', 'title' => 'Update Record']): '';
                $viewLink = Html::a('<i class="fa fa-eye"></i>',['view','Key'=> $quali->Key ],['class'=>'btn btn-outline-info btn-xs mx-2', 'title' => 'View Document']);
                $sendForApproval = ($quali->Status == 'New')? Html::a('<i class="fa fa-forward"></i>',['send-to-hro'],[
                    'class'=>'btn btn-outline-success btn-xs mx-2',
                    'title' => 'Send to HRO',
                    'data' => [
                        'params' => [
                            'No'=> $quali->No
                        ],
                        'confirm' => 'Are you sure you want to send this request for approval?',
                        'method' => 'post'
                    ]
                    ]): '';
                $cancelApproval = ($quali->Status == 'Pending_Approval')? Html::a('<i class="fa fa-times"></i>',['cancelApprovalRequest','No'=> $quali->No ],['class'=>'btn btn-outline-warning btn-xs mx-2', 'title' => 'Cancel Approval Request']): '';


                $Deletelink = Html::a('<i class="fa fa-trash"></i>',['delete','Key'=> $quali->Key ],['class'=>'btn btn-outline-danger btn-xs text-danger',
                    'title' => 'Delete Record.',
                    'data' => [
                    'confirm' => 'Are you sure you want to delete this record?',
                    'method' => 'post',
                ]]);

               
                $result['data'][] = [
                    'index' => $count,
                    'Employee_No' => !empty($quali->Employee_No)?$quali->Employee_No:'',
                    'Employee_Name' => !empty($quali->Employee_Name)?$quali->Employee_Name:'',
                    'Grievance_Against' => !empty($quali->Grievance_Against)?$quali->Grievance_Against:'',
                    'Name' => !empty($quali->Name)?$quali->Name:'',
                    'Grievance_Type' => !empty($quali->Grievance_Type)?$quali->Grievance_Type:'',
                    'Status' => !empty($quali->Status)?$quali->Status:'',
                    'Action' => $viewLink.$updateLink,
                                      
                ];
            
        }
        return $result;

    } 

    


    public function actionAttended()
    {

        $status = [
            ['Code' => '_blank_','Desc' => '_blank_'],
            ['Code' => 'Yes' ,'Desc' =>'Yes'],
            ['Code' => 'No' ,'Desc' => 'No'],
        ];

        $data =  ArrayHelper::map($status,'Code','Desc');
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $data;
    }


    


    /* Call Approval Workflow Methods */

    public function actionSendForApproval()
    {
        $No = Yii::$app->request->post('No');
        $service = Yii::$app->params['ServiceName']['PortalFactory'];

        $data = [
            'applicationNo' => Yii::$app->request->post('No'),
            'approvalUrl' => Yii::$app->urlManager->createAbsoluteUrl(['training-applications/view', 'No' => $No]),
            'sendMail' => 1,
        ];

        $result = Yii::$app->navhelper->Codeunit($service,$data,'IanSendTrainingForApproval');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Document sent for approval Successfully.', true);
            return $this->redirect(['index']);
        }else{

            Yii::$app->session->setFlash('error', 'Error  : '. $result);
            return $this->redirect(['index']);

        }
    }
    /*Cancel Approval Request */

    public function actionSendToHro()
    {
        $No = Yii::$app->request->post('No');
        $service = Yii::$app->params['ServiceName']['GRIEVANCEMGT'];

        $data = [
            'grievanceNo' => $No,
            'urLToSend' => Yii::$app->urlManager->createAbsoluteUrl(['grievance/view', 'No' => $No]),
        ];

       // Yii::$app->recruitment->printrr($data);


        $result = Yii::$app->navhelper->Codeunit($service,$data,'IanSendGrievanceForAcceptance');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Document sent Successfully.', true);
            return $this->redirect(['index']);
        }else{

            Yii::$app->session->setFlash('error', 'Error.  : '. $result);
            return $this->redirect(['index']);

        }
    }

    // Accept Grievance

    public function actionAcceptGrievance()
    {
        $No = Yii::$app->request->post('No');
        $service = Yii::$app->params['ServiceName']['GRIEVANCEMGT'];

        $data = [
            'grievanceNo' => $No,
            //'urLToSend' => Yii::$app->urlManager->createAbsoluteUrl(['grievance/view', 'No' => $No]),
        ];

       // Yii::$app->recruitment->printrr($data);


        $result = Yii::$app->navhelper->Codeunit($service,$data,'IanAcceptGrievance');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Grievance Accepted Successfully.', true);
            return $this->redirect(['hro']);
        }else{

            Yii::$app->session->setFlash('error', 'Error.  : '. $result);
            return $this->redirect(['hro']);

        }
    }


    // Reject Grievenace

    public function actionRejectGrievance()
    {
        $No = Yii::$app->request->post('No');
        $service = Yii::$app->params['ServiceName']['GRIEVANCEMGT'];

        $data = [
            'grievanceNo' => $No,
            'urLToSend' => Yii::$app->urlManager->createAbsoluteUrl(['grievance/view', 'No' => $No]),
            'rejectionComment' => 'REJECTED'
        ];

       // Yii::$app->recruitment->printrr($data);


        $result = Yii::$app->navhelper->Codeunit($service,$data,'IanRejectGrievance');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Grievance Rejected Successfully.', true);
            return $this->redirect(['hro']);
        }else{

            Yii::$app->session->setFlash('error', 'Error.  : '. $result);
            return $this->redirect(['hro']);

        }
    }

    // Withdraw Grievance

    public function actionWithdraw()
    {
        $No = Yii::$app->request->post('No');
        $service = Yii::$app->params['ServiceName']['GRIEVANCEMGT'];

        $data = [
            'grievanceNo' => $No,
            'urLToSend' => Yii::$app->urlManager->createAbsoluteUrl(['grievance/view', 'No' => $No]),
            'withdrawalReason' => 'Withdtwan'
        ];

       // Yii::$app->recruitment->printrr($data);


        $result = Yii::$app->navhelper->Codeunit($service,$data,'IanWithdrawGrievance');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Grievance Rejected Successfully.', true);
            return $this->redirect(['index']);
        }else{

            Yii::$app->session->setFlash('error', 'Error.  : '. $result);
            return $this->redirect(['index']);

        }
    }



    // Convert to Discipline Case

    public function actionConvertToDisciplinary()
    {
        $No = Yii::$app->request->post('No');
        $service = Yii::$app->params['ServiceName']['GRIEVANCEMGT'];

        $data = [
            'grievanceNo' => $No,
           // 'urLToSend' => Yii::$app->urlManager->createAbsoluteUrl(['grievance/view', 'No' => $No]),
           // 'rejectionComment' => 'REJECTED'
        ];

       // Yii::$app->recruitment->printrr($data);


        $result = Yii::$app->navhelper->Codeunit($service,$data,'IanConvertGrievanceToDisciplinary');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Grievance converted to disciplinary case Successfully.', true);
            return $this->redirect(['hro']);
        }else{

            Yii::$app->session->setFlash('error', 'Error.  : '. $result);
            return $this->redirect(['hro']);

        }
    }

    // Close Grievance Case

    public function actionCloseGrievance()
    {
        $No = Yii::$app->request->post('No');
        $service = Yii::$app->params['ServiceName']['GRIEVANCEMGT'];

        $data = [
            'grievanceNo' => $No
        ];

       // Yii::$app->recruitment->printrr($data);


        $result = Yii::$app->navhelper->Codeunit($service,$data,'IanCloseGrievance');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Grievance closed Successfully.', true);
            return $this->redirect(['hro']);
        }else{

            Yii::$app->session->setFlash('error', 'Error.  : '. $result);
            return $this->redirect(['hro']);

        }
    }


    /** Updates a single field */
    public function actionSetfield($field){
        $service = 'GrievanceCard';
        $value = Yii::$app->request->post('fieldValue');
        $result = Yii::$app->navhelper->Commit($service,[$field => $value],Yii::$app->request->post('Key'));
        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;
        return $result;
          
    }

    public function actionAddLine($Service,$Document_No)
    {
        $service = Yii::$app->params['ServiceName'][$Service];
        $data = [
            'Induction_No' => $Document_No,
            'Line_No' => time()
        ];

        // Insert Record

        $result = Yii::$app->navhelper->postData($service, $data);

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(is_object($result))
        {
            return [
                'note' => 'Record Created Successfully.',
                'result' => $result
            ];
        }else{
            return ['note' => $result];
        }
    }

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


    

    public function actionDeleteLine($Service, $Key)
    {
        $service = Yii::$app->params['ServiceName'][$Service];
        $result = Yii::$app->navhelper->deleteData($service,Yii::$app->request->get('Key'));
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!is_string($result)){

            return ['note' => '<div class="alert alert-success">Record Purged Successfully</div>'];
        }else{
            return ['note' => '<div class="alert alert-danger">Error Purging Record: '.$result.'</div>' ];
        }
    }



}