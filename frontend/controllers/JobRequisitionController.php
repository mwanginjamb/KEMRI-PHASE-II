<?php

namespace frontend\controllers;
use frontend\models\Careerdevelopmentstrength;
use frontend\models\Employeeappraisalkra;
use frontend\models\Experience;
use frontend\models\Imprestcard;
use frontend\models\Imprestline;
use frontend\models\Imprestsurrendercard;
use frontend\models\Leaveattachment;
use frontend\models\Leaveplancard;
use frontend\models\Leave;
use frontend\models\Salaryadvance;
use frontend\models\Trainingplan;
use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\BadRequestHttpException;

use yii\web\Response;
use kartik\mpdf\Pdf;
use yii\web\UploadedFile;
use yii\web\ForbiddenHttpException;
use frontend\models\HrJobRequisitionCard;

class JobRequisitionController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','signup','index','advance-list','create','update','delete','view','listactive','listbalances','listactivehod','activeleaves','activeleaveshod'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','index','advance-list','create','update','delete','view','listactive','listbalances','listactivehod','activeleaves','activeleaveshod'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post']
                ],
            ],
            'contentNegotiator' =>[
                'class' => ContentNegotiator::class,
                'only' => ['list','listactive','listbalances','listactivehod','listbalancesdivision'],
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

    public function actionActiveleaves()
    {
        return $this->render('activeleaves');
    }

    public function actionActiveleaveshod()
    {
        
        return $this->render('activeleaveshod');
    }

    public function actionBalances()
    {
        // Yii::$app->recruitment->printrr(Yii::$app->user->identity->{'Head of Department'});
        if(!Yii::$app->user->identity->{'Head of Department'})
        {
            throw new ForbiddenHttpException('You do not have permission to view this information, Pole!');
        }
        return $this->render('balances');
    }

    public function actionBalancesDivision()
    {
        if(!Yii::$app->user->identity->{'Head of Division'})
        {
            throw new ForbiddenHttpException('You do not have permission to view this information, Pole!');
        }

        return $this->render('balancesdivision');
    }


    public function actionCreate(){

        $model = new HrJobRequisitionCard();
        $service = Yii::$app->params['ServiceName']['HrJobRequisitionCard'];

        /*Do initial request */
        if(!isset(Yii::$app->request->post()['HrJobRequisitionCard']) && empty($_FILES) ){

            $now = date('Y-m-d');
            $model->Start_Date = date('Y-m-d', strtotime($now));
            $model->Employee_No = Yii::$app->user->identity->{'Employee No_'};
            $request = Yii::$app->navhelper->postData($service,$model);
            //Yii::$app->recruitment->printrr($request);
            if(is_object($request) )
            {
                Yii::$app->navhelper->loadmodel($request,$model);
                return $this->redirect(['view','No' => $model->Requisition_No]);

            }else{
                Yii::$app->session->setFlash('error',  $request);
                return $this->redirect(['index']);
            }
        } /*End Application Initialization*/

        if(Yii::$app->request->post() && !empty(Yii::$app->request->post()['Leave']) && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Leave'],$model) ){

            $filter = [
                'Application_No' => $model->Application_No,
            ];
            /*Read the card again to refresh Key in case it changed*/
            $refresh = Yii::$app->navhelper->getData($service,$filter);
            $model->Key = $refresh[0]->Key;

            //Yii::$app->recruitment->printrr($refresh );
            Yii::$app->navhelper->loadmodel($refresh[0],$model);
            $result = Yii::$app->navhelper->updateData($service,$model);
            if(!is_string($result)){

                Yii::$app->session->setFlash('success','Leave Request Created Successfully.' );
                return $this->redirect(['view','No' =>  $refresh[0]->Application_No]);

            }else{
                Yii::$app->session->setFlash('error','Error Creating Leave Request : '.$result );
                return $this->redirect(['view','No' => $refresh[0]->Application_No]);

            }

        }


        // Upload Attachment File
        if(!empty($_FILES)){
            $Attachmentmodel = new Leaveattachment();
            $Attachmentmodel->Document_No =  Yii::$app->request->post()['Leaveattachment']['Document_No'];
            $Attachmentmodel->attachmentfile = UploadedFile::getInstanceByName('attachmentfile');

            $result = $Attachmentmodel->Upload($Attachmentmodel->Document_No);

            
             if(!is_string($result) || $result == true){
                Yii::$app->session->setFlash('success','Leave Application and Attachement Saved Successfully. ', true);
                 return $this->redirect(['index']);
            }else{
                Yii::$app->session->setFlash('error','Could not save attachment.'.$result, true);
                 return $this->redirect(['index']);
            }
            
        }

        return $this->render('create',[
            'model' => $model,
            'ApprovedHRJobs' => $this->getApprovedHRJobs(),
            'ContractTypes'=>$this->getContractTypes(),
            'Programs'=>$this->getPrograms(),
            'Departments'=>$this->getDepartments(),
            'Locations'=>$this->getLocations(),
        ]);
    }

    public function getPrograms(){
        $service = Yii::$app->params['ServiceName']['DimensionValueList'];

        $filter = [
            'Global_Dimension_No' => 1
        ];

        $result = \Yii::$app->navhelper->getData($service, $filter);
        return ArrayHelper::map($result,'Code','Name');
    }

    /* Get Department*/

    public function getDepartments(){
        $service = Yii::$app->params['ServiceName']['DimensionValueList'];

        $filter = [
            'Global_Dimension_No' => 2
        ];
        $result = \Yii::$app->navhelper->getData($service, $filter);
        return ArrayHelper::map($result,'Code','Name');
    }

    public function getLocations(){
        $service = Yii::$app->params['ServiceName']['DimensionValueList'];

        $filter = [
            'Global_Dimension_No' => 5
        ];
        $result = \Yii::$app->navhelper->getData($service, $filter);
        return ArrayHelper::map($result,'Code','Name');
    }

    public function actionAttach()
    {
         // Upload Attachment File
        if(!empty($_FILES)){
            $Attachmentmodel = new Leaveattachment();
            $Attachmentmodel->Document_No =  Yii::$app->request->post()['Leaveattachment']['Document_No'];
            $Attachmentmodel->attachmentfile = UploadedFile::getInstanceByName('attachmentfile');

            $result = $Attachmentmodel->Upload($Attachmentmodel->Document_No);

            
            return $result;
            
        }
    }




    public function actionUpdate(){
        $model = new Leave();
        $service = Yii::$app->params['ServiceName']['LeaveCard'];
        $model->isNewRecord = false;

        $filter = [
            'Application_No' => Yii::$app->request->get('No'),
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        // check Authoruty To view the document
        Yii::$app->navhelper->checkAuthority($result[0]);

        if(is_array($result)){
            //load nav result to model
            $model = Yii::$app->navhelper->loadmodel($result[0],$model) ;//$this->loadtomodeEmployee_Nol($result[0],$Expmodel);
        }else{
            Yii::$app->recruitment->printrr($result);
        }

        // Upload Attachment File
        if(!empty($_FILES)){
          //  Yii::$app->recruitment->printrr($_FILES);
            $Attachmentmodel = new Leaveattachment();
            $Attachmentmodel->Document_No =  Yii::$app->request->post()['Leaveattachment']['Document_No'];
            $Attachmentmodel->attachmentfile = UploadedFile::getInstanceByName('attachmentfile');
            $result = $Attachmentmodel->Upload($Attachmentmodel->Document_No);
            if(!is_string($result) || $result == true){
                Yii::$app->session->setFlash('success','Leave Attachement Saved Successfully. ', true);
            }else{
                Yii::$app->session->setFlash('error','Could not save attachment.'.$result, true);
            }

            return $this->render('update',[
                'model' => $model,
                'leavetypes' => $this->getLeaveTypes(),
                'employees' => $this->getEmployees(),

            ]);
        }

        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Leave'],$model) ){
            $filter = [
                'Requisition_No' => $model->Requisition_No,
            ];
            /*Read the card again to refresh Key in case it changed*/
            $refresh = Yii::$app->navhelper->getData($service,$filter);
            $model->Key = $refresh[0]->Key;
            // Yii::$app->navhelper->loadmodel($refresh[0],$model);

            $result = Yii::$app->navhelper->updateData($service,$model);

            if(!is_string($result)){

                Yii::$app->session->setFlash('success','Updated Successfully.' );

                return $this->redirect(['view','No' => $result->Requisition_No]);

            }else{
                Yii::$app->session->setFlash('error',$result );
                return $this->render('update',[
                    'model' => $model,
                ]);

            }

        }



        if(Yii::$app->request->isAjax){
            return $this->renderAjax('update', [
                'model' => $model,
                'leavetypes' => $this->getLeaveTypes(),
                'employees' => $this->getEmployees(),


            ]);
        }



        return $this->render('update',[
            'model' => $model,
            'leavetypes' => $this->getLeaveTypes(),
            'employees' => $this->getEmployees(),

        ]);
    }

    public function actionDelete(){
        $service = Yii::$app->params['ServiceName']['LeaveCard'];
        $result = Yii::$app->navhelper->deleteData($service,Yii::$app->request->get('Key'));
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!is_string($result)){
            return ['note' => '<div class="alert alert-success">Record Purged Successfully</div>'];
        }else{
            return ['note' => '<div class="alert alert-danger">Error Purging Record: '.$result.'</div>' ];
        }
    }

    public function actionView($No,$Approval = false){
       // exit($No);
        $model = new HrJobRequisitionCard();
        $model->isNewRecord = false;
        $service = Yii::$app->params['ServiceName']['HrJobRequisitionCard'];

        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['HrJobRequisitionCard'],$model) ){
            $filter = [
                'Requisition_No' => $model->Requisition_No,
            ];
            /*Read the card again to refresh Key in case it changed*/
            $refresh = Yii::$app->navhelper->getData($service,$filter);
            $model->Key = $refresh[0]->Key;
            // Yii::$app->navhelper->loadmodel($refresh[0],$model);

            $result = Yii::$app->navhelper->updateData($service,$model);

            if(!is_string($result)){

                Yii::$app->session->setFlash('success','Updated Successfully.' );

                return $this->redirect(Yii::$app->request->referrer);

            }else{
                Yii::$app->session->setFlash('error',$result );
                return $this->redirect(Yii::$app->request->referrer);


            }

        }

        $filter = [
            'Requisition_No' => $No
        ];

        $result = Yii::$app->navhelper->getData($service, $filter);

         // check Authority To view the document
        if(!$Approval)
        {
            // Yii::$app->navhelper->checkAuthority($result[0]);
        }
        

        //load nav result to model
        $model = $this->loadtomodel($result[0], $model);

        //Yii::$app->recruitment->printrr($model);

        return $this->render('view',[
            'model' => $model,
            'ApprovedHRJobs' => $this->getApprovedHRJobs(),
            'ContractTypes'=>$this->getContractTypes(),
            'Programs'=>$this->getPrograms(),
            'Departments'=>$this->getDepartments(),
            'Locations'=>$this->getLocations(),
            'Employees'=>$this->getEmployees(),
        ]);
    }

    public function getEmployees(){

        //Yii::$app->recruitment->printrr(Yii::$app->user->identity->Employee[0]->Global_Dimension_3_Code);
        $service = Yii::$app->params['ServiceName']['Employees'];
        $filter = [
            // 'Global_Dimension_3_Code' => Yii::$app->user->identity->Employee[0]->Global_Dimension_3_Code
        ];
        $employees = \Yii::$app->navhelper->getData($service, $filter);
        $data = [];
        $i = 0;
        if(is_array($employees)){

            foreach($employees as  $emp){
                $i++;
                if(!empty($emp->Full_Name) && !empty($emp->No)){
                    $data[$i] = [
                        'No' => $emp->No,
                        'Full_Name' => $emp->Full_Name
                    ];
                }

            }
        }
        return ArrayHelper::map($data,'No','Full_Name');
    }

    



    // Get Leave list

    public function actionList(){
        $service = Yii::$app->params['ServiceName']['HrJobRequisition'];
        $filter = [
            'Status' => 'New',
        ];

        $results = \Yii::$app->navhelper->getData($service,$filter);
        // echo '<pre>';
        // print_r($results);
        // exit;

        $result = [];
        foreach($results as $item){
            $link = $updateLink = $deleteLink =  '';
            $Viewlink = Html::a('<i class="fas fa-eye"></i>',['view', 'No' => $item->Requisition_No
        ],[
                'class'=>'btn btn-outline-primary btn-xs',
                'data' => [
                    'params' => [
                        'No' => $item->Requisition_No
                    ],
                    'method' => 'GET'
                ]

            ]);
            // if($item->Status == 'New'){
            //     $link = Html::a('<i class="fas fa-paper-plane"></i>',['send-for-approval'],['title'=>'Send Approval Request','class'=>'btn btn-primary btn-xs']);
            //     $updateLink = Html::a('<i class="far fa-edit"></i>',['update'],[
            //         'class'=>'btn btn-info btn-xs',
            //         'data' => [
            //             'params' => [
            //                 'No' => $item->Application_No
            //             ],
            //             'method' => 'GET'
            //         ]
            // ]);
            // }else if($item->Status == 'Pending_Approval'){
            //     $link = Html::a('<i class="fas fa-times"></i>',['cancel-request','No'=> $item->Application_No ],['title'=>'Cancel Approval Request','class'=>'btn btn-warning btn-xs']);
            // }

            $result['data'][] = [
                'Key' => $item->Key,
                'No' => $item->Requisition_No,
                'Occupied_Position' => !empty($item->Occupied_Position)?$item->Occupied_Position:'',
                'Job_Description' => !empty($item->Job_Description)?$item->Job_Description:'',
                'No_Posts' => !empty($item->No_Posts)?$item->No_Posts:'',
                // 'Status' => $item->Status,
                // 'Action' => $link,
                // 'Update_Action' => $updateLink,
                'view' => $Viewlink
            ];
        }

        return $result;
    }

    /*Get Active Leaves*/

    public function actionListactive(){
        $service = Yii::$app->params['ServiceName']['StaffOnLeave'];
        $filter = [
            'Department' => Yii::$app->user->identity->Employee[0]->Department_Name,
        ];

        $results = \Yii::$app->navhelper->getData($service,$filter);
        $result = [];
        foreach($results as $item){


          
            $result['data'][] = [

                'Key' => !empty($item->Key)?$item->Key:'',
                'Employee_Name' => !empty($item->Employee_Name)?$item->Employee_Name:'',
                'Leave_Type' => !empty($item->Leave_Type)?$item->Leave_Type:'',
                'Start_Date' => !empty($item->Start_Date)?$item->Start_Date:'',
                'End_Date' => !empty($item->End_Date)?$item->End_Date:'',
                'Reliever' => !empty($item->Reliever)?$item->Reliever:'',
                'Department' => !empty($item->Department)?$item->Department:'',
                                
            ];
        }

        return $result;
    }

    /*Get HODs on Leave*/

    public function actionListactivehod(){
       // var_dump(Yii::$app->user->identity->Employee[0]->Global_Dimension_1_Code); exit;
        //Yii::$app->recruitment->printrr(Yii::$app->user->identity->Employee[0]);
        $service = Yii::$app->params['ServiceName']['StaffOnLeave'];
        $filter = [
            'Division' => Yii::$app->user->identity->Employee[0]->Global_Dimension_1_Code,
            'Is_HOD' => 1
        ];

        $results = \Yii::$app->navhelper->getData($service,$filter);
        $result = [];
        foreach($results as $item){

            if(empty($item->Employee_Name) || empty($item->Leave_Type))
            {
                continue;
            }
          
            $result['data'][] = [

                'Key' => !empty($item->Key)?$item->Key:'',
                'Employee_Name' => !empty($item->Employee_Name)?$item->Employee_Name:'',
                'Leave_Type' => !empty($item->Leave_Type)?$item->Leave_Type:'',
                'Start_Date' => !empty($item->Start_Date)?$item->Start_Date:'',
                'End_Date' => !empty($item->End_Date)?$item->End_Date:'',
                'Reliever' => !empty($item->Reliever)?$item->Reliever:'',
                'Department' => !empty($item->Department)?$item->Department:'',
                                
            ];
        }

        return $result;
    }

    /*Employee Leave Balances*/

     public function actionListbalances(){
        $service = Yii::$app->params['ServiceName']['EmployeeLeaveBalances'];
        $filter = [
            'Global_Dimension_2_Code' => Yii::$app->user->identity->Employee[0]->Global_Dimension_2_Code,
        ];

        $results = \Yii::$app->navhelper->getData($service,$filter);
        $result = [];
        foreach($results as $item){

            if(empty($item->Full_Name))
            {
                continue;
            }
          
            $result['data'][] = [

                'Key' => $item->Key,
                'No' => !empty($item->No)?$item->No:'',
                'Full_Name' => !empty($item->Full_Name)?$item->Full_Name:'',
                'Annual_Leave_Balance' => !empty($item->Annual_Leave_Balance)?$item->Annual_Leave_Balance:'',
                'Global_Dimension_1_Code' => !empty($item->Global_Dimension_1_Code)?$item->Global_Dimension_1_Code:'',
                                
            ];
        }

        return $result;
    }

    // Head Of Departments Leave Balance List

    
    public function actionListbalancesdivision(){
        $service = Yii::$app->params['ServiceName']['HODLeaveBalances'];
        $filter = [
            'Global_Dimension_1_Code' => Yii::$app->user->identity->Employee[0]->Global_Dimension_1_Code,
            'Is_HOD' => 1
        ];

        $results = \Yii::$app->navhelper->getData($service,$filter);
        $result = [];
        foreach($results as $item){

            if(empty($item->Full_Name))
            {
                continue;
            }
          
            $result['data'][] = [

                'Key' => $item->Key,
                'No' => !empty($item->No)?$item->No:'',
                'Full_Name' => !empty($item->Full_Name)?$item->Full_Name:'',
                'Annual_Leave_Balance' => !empty($item->Annual_Leave_Balance)?$item->Annual_Leave_Balance:'',
                'Global_Dimension_1_Code' => !empty($item->Global_Dimension_1_Code)?$item->Global_Dimension_1_Code:'',
                'Global_Dimension_2_Code' => !empty($item->Global_Dimension_2_Code)?$item->Global_Dimension_2_Code:'',
                                
            ];
        }

        return $result;
    }
    

    public function getCovertypes(){
        $service = Yii::$app->params['ServiceName']['MedicalCoverTypes'];

        $results = \Yii::$app->navhelper->getData($service);
        $result = [];
        $i = 0;
        if(is_array($results)){
            foreach($results as $res){
                if(!empty($res->Code) && !empty($res->Description)){
                    $result[$i] =[
                        'Code' => $res->Code,
                        'Description' => $res->Description
                    ];
                    $i++;
                }

            }
        }
        return ArrayHelper::map($result,'Code','Description');
    }

    /* My Imprests*/

    public function getmyimprests(){
        $service = Yii::$app->params['ServiceName']['PostedImprestRequest'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->Employee[0]->No,
            'Surrendered' => false,
        ];

        $results = \Yii::$app->navhelper->getData($service,$filter);

        $result = [];
        $i = 0;
        if(is_array($results)){
            foreach($results as $res){
                $result[$i] =[
                    'No' => $res->No,
                    'detail' => $res->No.' - '.$res->Imprest_Amount
                ];
                $i++;
            }
        }
        // Yii::$app->recruitment->printrr(ArrayHelper::map($result,'No','detail'));
        return ArrayHelper::map($result,'No','detail');
    }

    /*Get Staff Loans */

    public function getLoans(){
        $service = Yii::$app->params['ServiceName']['StaffLoans'];

        $results = \Yii::$app->navhelper->getData($service);
        return ArrayHelper::map($results,'Code','Loan_Name');
    }

    /* Get My Posted Imprest Receipts */

    public function getimprestreceipts($imprestNo){
        $service = Yii::$app->params['ServiceName']['PostedReceiptsList'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->Employee[0]->No,
            'Imprest_No' => $imprestNo,
        ];

        $results = \Yii::$app->navhelper->getData($service,$filter);

        $result = [];
        $i = 0;
        if(is_array($results)){
            foreach($results as $res){
                $result[$i] =[
                    'No' => $res->No,
                    'detail' => $res->No.' - '.$res->Imprest_No
                ];
                $i++;
            }
        }
        // Yii::$app->recruitment->printrr(ArrayHelper::map($result,'No','detail'));
        return ArrayHelper::map($result,'No','detail');
    }



    public function actionRequiresattachment($Code)
    {
        $service = Yii::$app->params['ServiceName']['LeaveTypesSetup'];
        $filter = [
            'Code' => $Code
        ];

        $result = \Yii::$app->navhelper->getData($service,$filter);

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['Requires_Attachment' => $result[0]->Requires_Attachment ];
    }

    public function getApprovedHRJobs(){

        //Yii::$app->recruitment->printrr(Yii::$app->user->identity->Employee[0]->Global_Dimension_3_Code);
        $service = Yii::$app->params['ServiceName']['ApprovedHRJobs'];
        $ApprovedHRJobs = \Yii::$app->navhelper->getData($service);
        $data = [];
        $i = 0;
        if(is_array($ApprovedHRJobs)){

            foreach($ApprovedHRJobs as  $ApprovedHRJob){
                $i++;
                if(!empty($ApprovedHRJob->Job_ID) && !empty($ApprovedHRJob->Job_Description)){
                    $data[$i] = [
                        'No' => $ApprovedHRJob->Job_ID,
                        'Name' => $ApprovedHRJob->Job_Description
                    ];
                }

            }
        }
        return ArrayHelper::map($data,'No','Name');
    }

    public function getContractTypes(){

        //Yii::$app->recruitment->printrr(Yii::$app->user->identity->Employee[0]->Global_Dimension_3_Code);
        $service = Yii::$app->params['ServiceName']['EmployeeContracts'];
        $EmployeeContracts = \Yii::$app->navhelper->getData($service);
        $data = [];
        $i = 0;
        if(is_array($EmployeeContracts)){

            foreach($EmployeeContracts as  $EmployeeContract){
                $i++;
                if(!empty($EmployeeContract->Code) && !empty($EmployeeContract->Description)){
                    $data[$i] = [
                        'No' => $EmployeeContract->Code,
                        'Name' => $EmployeeContract->Description
                    ];
                }

            }
        }
        return ArrayHelper::map($data,'No','Name');
    }

    




    public function actionSetleavetype(){
        $model = new Leave();
        $service = Yii::$app->params['ServiceName']['LeaveCard'];

        $filter = [
            'Application_No' => Yii::$app->request->post('No')
        ];
        $request = Yii::$app->navhelper->getData($service, $filter);

        if(is_array($request)){
            Yii::$app->navhelper->loadmodel($request[0],$model);
            $model->Key = $request[0]->Key;
            $model->Leave_Code = Yii::$app->request->post('Leave_Code');
        }


        $result = Yii::$app->navhelper->updateData($service,$model);

        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;

        return $result;

    }

    public function actionSetjob(){
        $model = new HrJobRequisitionCard();
        $service = Yii::$app->params['ServiceName']['HrJobRequisitionCard'];

        $filter = [
            'Requisition_No' => Yii::$app->request->post('No')
        ];
        $request = Yii::$app->navhelper->getData($service, $filter);

        if(is_array($request)){
            Yii::$app->navhelper->loadmodel($request[0],$model);
            $model->Key = $request[0]->Key;
            $model->Job_Id = Yii::$app->request->post('SelectedJob');
        }


        $result = Yii::$app->navhelper->updateData($service,$model);

        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;

        return $result;

    }

    public function actionSetPosts(){
        $model = new HrJobRequisitionCard();
        $service = Yii::$app->params['ServiceName']['HrJobRequisitionCard'];

        $filter = [
            'Requisition_No' => Yii::$app->request->post('No')
        ];
        $request = Yii::$app->navhelper->getData($service, $filter);

        if(is_array($request)){
            Yii::$app->navhelper->loadmodel($request[0],$model);
            $model->Key = $request[0]->Key;
            $model->No_Posts = (int)Yii::$app->request->post('Posts');
        }

        $result = Yii::$app->navhelper->updateData($service,$model);

        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;

        return $result;

    }

    public function actionSetPeriod(){
        $model = new HrJobRequisitionCard();
        $service = Yii::$app->params['ServiceName']['HrJobRequisitionCard'];

        $filter = [
            'Requisition_No' => Yii::$app->request->post('No')
        ];
        $request = Yii::$app->navhelper->getData($service, $filter);

        if(is_array($request)){
            Yii::$app->navhelper->loadmodel($request[0],$model);
            $model->Key = $request[0]->Key;
            $model->Contract_Period = Yii::$app->request->post('Period');
        }

        $result = Yii::$app->navhelper->updateData($service,$model);

        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;

        return $result;

    }

    /*Set Start Date */
    public function actionSetstartdate(){
        $model = new Leave();
        $service = Yii::$app->params['ServiceName']['LeaveCard'];

        $filter = [
            'Application_No' => Yii::$app->request->post('No')
        ];
        $request = Yii::$app->navhelper->getData($service, $filter);

        if(is_array($request)){
            Yii::$app->navhelper->loadmodel($request[0],$model);
            $model->Key = $request[0]->Key;
            $model->Start_Date = Yii::$app->request->post('Start_Date');
        }

        $result = Yii::$app->navhelper->updateData($service,$model);

        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;

        return $result;

    }

    /* Set Imprest Type */

    public function actionSetimpresttype(){
        $model = new Imprestcard();
        $service = Yii::$app->params['ServiceName']['ImprestRequestCardPortal'];

        $filter = [
            'No' => Yii::$app->request->post('No')
        ];
        $request = Yii::$app->navhelper->getData($service, $filter);

        if(is_array($request)){
            Yii::$app->navhelper->loadmodel($request[0],$model);
            $model->Key = $request[0]->Key;
            $model->Imprest_Type = Yii::$app->request->post('Imprest_Type');
        }


        $result = Yii::$app->navhelper->updateData($service,$model,['Amount_LCY']);

        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;

        return $result;

    }

        /*Set Imprest to Surrend*/

    public function actionSetimpresttosurrender(){
        $model = new Imprestsurrendercard();
        $service = Yii::$app->params['ServiceName']['ImprestSurrenderCardPortal'];

        $filter = [
            'No' => Yii::$app->request->post('No')
        ];
        $request = Yii::$app->navhelper->getData($service, $filter);

        if(is_array($request)){
            Yii::$app->navhelper->loadmodel($request[0],$model);
            $model->Key = $request[0]->Key;
            $model->Imprest_No = Yii::$app->request->post('Imprest_No');
        }


        $result = Yii::$app->navhelper->updateData($service,$model);

        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;

        return $result;

    }

    public function loadtomodel($obj,$model){

        if(!is_object($obj)){
            return false;
        }
        $modeldata = (get_object_vars($obj)) ;
        foreach($modeldata as $key => $val){
            if(is_object($val)) continue;
            $model->$key = $val;
        }

        return $model;
    }

    /* Call Approval Workflow Methods */

    public function actionSendForApproval($No)
    {
        $service = Yii::$app->params['ServiceName']['PortalFactory'];

        $data = [
            'applicationNo' => $No,
            'sendMail' => 1,
            'approvalUrl' => Yii::$app->urlManager->createAbsoluteUrl(['job-requisition/viewsubmitted', 'No' =>$No ])
        ];


        $result = Yii::$app->navhelper->PortalWorkFlows($service,$data,'IanSendEmployeeRequisitionForApproval');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Request Sent to Supervisor for Approval Successfully.', true);
            //return $this->redirect(['view','No' => $No]);
             return $this->redirect(['index']);
        }else{

            Yii::$app->session->setFlash('error', 'Error Sending Request for Approval  : '. $result);
            return $this->redirect(['view','No' => $No]);
            //  return $this->redirect(['index']);

        }
    }


    public function actionViewsubmitted($No, $Approval = true){
        $model = new HrJobRequisitionCard();
        $model->isNewRecord = false;
        $service = Yii::$app->params['ServiceName']['HrJobRequisitionCard'];

      
        $filter = [
            'Requisition_No' => urldecode($No)
        ];

        $result = Yii::$app->navhelper->getData($service, $filter);

         // check Authority To view the document
        if(!$Approval)
        {
            Yii::$app->navhelper->checkAuthority($result[0]);
        }
        

        //load nav result to model
        $model = $this->loadtomodel($result[0], $model);

        //Yii::$app->recruitment->printrr($model);

        return $this->render('view-submitted',[
            'model' => $model,
            'ApprovedHRJobs' => $this->getApprovedHRJobs(),
            'ContractTypes'=>$this->getContractTypes(),
            'Programs'=>$this->getPrograms(),
            'Departments'=>$this->getDepartments(),
            'Locations'=>$this->getLocations(),
            'Employees'=>$this->getEmployees(),
            'ApprovalDetails'=>$this->getApprovlDetails(urldecode($No)),
        ]);
    }

    public function  getApprovlDetails($No){

    }

    /*Cancel Approval Request */

    public function actionCancelRequest($No)
    {
        $service = Yii::$app->params['ServiceName']['PortalFactory'];

        $data = [
            'applicationNo' => $No,
        ];


        $result = Yii::$app->navhelper->PortalWorkFlows($service,$data,'IanCancelLeaveApprovalRequest');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Approval Request Cancelled Successfully.', true);
            return $this->redirect(['view','No' => $No]);
        }else{

            Yii::$app->session->setFlash('error', 'Error Cancelling Approval Request.  : '. $result);
            return $this->redirect(['view','No' => $No]);

        }
    }



}