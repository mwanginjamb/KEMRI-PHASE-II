<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:21 PM
 */

namespace frontend\controllers;

use frontend\models\Imprestcard;
use frontend\models\Induction;
use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\Response;

class InductionController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','signup','index','list','create','update','delete'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','index','list', 'create', 'update','delete' ],
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
                'only' => ['list'],
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

    
 


    public function actionCreate(){

        $model = new Induction();
        $service = Yii::$app->params['ServiceName']['InductionCard'];
       
        // Once Initial Request is Made Redirect to Update Page

            $model->Employee_No = Yii::$app->user->identity->{'Employee No_'};
            $request = Yii::$app->navhelper->postData($service,$model);
            if(is_object($request)){
                return $this->redirect(['update','Key' => $request->Key]);
            }else{ // error situation
                Yii::$app->session->setFlash('error',$request, true);
                return $this->redirect(['index']);
            }
       
    }

    

  

    public function actionUpdate($No = '', $Key = ''){
        $model = new Induction();
        $service = Yii::$app->params['ServiceName']['InductionCard'];
        $model->isNewRecord = false;

        // Get Document
        if(!empty($No))
        {
            $document = Yii::$app->navhelper->findOne($service, '','No',$No);    
        }elseif(!empty($Key)){
            $document = Yii::$app->navhelper->readByKey($service,$Key);    
        }else{
            Yii::$app->session->setFlash('error', 'We are unable to fetch a document to update', true);
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
            'document' => $document
        ]);
    }

    public function actionDelete(){
        $service = Yii::$app->params['ServiceName']['ImprestRequestCardPortal'];
        $result = Yii::$app->navhelper->deleteData($service,Yii::$app->request->get('Key'));
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!is_string($result)){

            return ['note' => '<div class="alert alert-success">Record Purged Successfully</div>'];
        }else{
            return ['note' => '<div class="alert alert-danger">Error Purging Record: '.$result.'</div>' ];
        }
    }

    public function actionView($No = '', $Key = ''){
        $service = Yii::$app->params['ServiceName']['InductionCard'];
        $model = new Induction();

       // Get Document
       if(!empty($No))
       {
           $document = Yii::$app->navhelper->findOne($service, '','No',$No);
           $pageRecord = Yii::$app->navhelper->findOne($service, '','No',$No);
       }elseif(!empty($Key)){
           $document = Yii::$app->navhelper->readByKey($service,$Key);
           $pageRecord = Yii::$app->navhelper->readByKey($service,$Key);
       }else{
           Yii::$app->session->setFlash('error', 'We are unable to fetch the document', true);
           return Yii::$app->redirect(['index']);
       }

        //load nav result to model
        $model = Yii::$app->navhelper->loadmodel($document, $model);

        return $this->render('view',[
            'model' => $model,
            'document' =>  $document
        ]);
    }


    public function actionList(){
        $service = Yii::$app->params['ServiceName']['InductionList'];

        $filter = [
            'Employee_No' => \Yii::$app->user->identity->{'Employee No_'},
        ];
        $records = \Yii::$app->navhelper->getData($service,$filter);

        $result = [];
        $count = 0;
        
            foreach($records as $quali){

                if(empty($quali->Key))
                {
                    continue;
                }

                ++$count;
                $link = $updateLink =  '';
                $updateLink = Html::a('<i class="fa fa-edit"></i>',['update','Key'=> $quali->Key ],['class'=>'update btn btn-outline-info btn-xs']);

                $link = Html::a('<i class="fa fa-trash"></i>',['delete','Key'=> $quali->Key ],['class'=>'btn btn-outline-warning btn-xs','data' => [
                    'confirm' => 'Are you sure you want to delete this record?',
                    'method' => 'post',
                ]]);

               
                $result['data'][] = [
                    'index' => $count,
                    'Employee_No' => !empty($quali->Employee_No)?$quali->Employee_No:'',
                    'Employee_Name' => !empty($quali->Employee_Name)?$quali->Employee_Name:'',
                    'Global_Dimension_1_Code' => !empty($quali->Global_Dimension_1_Code)?$quali->Global_Dimension_1_Code:'',
                    'Global_Dimension_2_Code' => !empty($quali->Global_Dimension_2_Code)?$quali->Global_Dimension_2_Code:'',
                    'Status' => !empty($quali->Status)?$quali->Status:'',                     
                    'Action' => $updateLink.' | '.$link                    
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

    public function actionSendForApproval($No)
    {
        $service = Yii::$app->params['ServiceName']['PortalFactory'];

        $data = [
            'applicationNo' => $No,
            'sendMail' => 1,
            'approvalUrl' => '',
        ];


        $result = Yii::$app->navhelper->PortalWorkFlows($service,$data,'IanSendImprestForApproval');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Imprest Request Sent to Supervisor Successfully.', true);
            return $this->redirect(['view']);
        }else{

            Yii::$app->session->setFlash('error', 'Error Sending Imprest Request for Approval  : '. $result);
            return $this->redirect(['view']);

        }
    }

    /*Cancel Approval Request */

    public function actionCancelRequest($No)
    {
        $service = Yii::$app->params['ServiceName']['PortalFactory'];

        $data = [
            'applicationNo' => $No,
        ];


        $result = Yii::$app->navhelper->PortalWorkFlows($service,$data,'IanCancelImprestForApproval');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Imprest Request Cancelled Successfully.', true);
            return $this->redirect(['view']);
        }else{

            Yii::$app->session->setFlash('error', 'Error Cancelling Imprest Approval Request.  : '. $result);
            return $this->redirect(['view']);

        }
    }

    /** Updates a single field */
    public function actionSetfield($field){
        $service = 'ImprestRequestSubformPortal';
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