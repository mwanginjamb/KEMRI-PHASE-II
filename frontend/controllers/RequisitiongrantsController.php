<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:21 PM
 */

namespace frontend\controllers;
use frontend\models\RequisitionGrants;

use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\BadRequestHttpException;

use yii\web\Response;


class RequisitiongrantsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup','index','create','update','delete','view'],
                'rules' => [
                    [
                        'actions' => ['signup','index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','index','create','update','delete','view'],
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
                'only' => ['setquantity','setitem','setlocation','setfield'],
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

       $service = Yii::$app->params['ServiceName']['RequisitionGrants'];
       $model = new RequisitionGrants();

        //Yii::$app->recruitment->printrr(Yii::$app->request->get());
        if(Yii::$app->request->isGet && !isset(Yii::$app->request->post()['RequisitionGrants'])){

               
                $model->Requisition_No = Yii::$app->request->get('No');//$Contract_Code;
                $result = Yii::$app->navhelper->postData($service, $model);
                if(is_string($result)){
                    return $result;
                }
                $model = Yii::$app->navhelper->loadmodel($result,$model);
        }
        

        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Donorline'],$model) ){



            $result = Yii::$app->navhelper->updateData($service,$model);

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if(!is_string($result)){

                return ['note' => '<div class="alert alert-success">Line Added Successfully. </div>' ];
            }else{

                return ['note' => '<div class="alert alert-danger">Error Adding Line: '.$result.'</div>'];
            }

        }

               // $model->Grant_Start_Date = date('Y-m-d');
               // $model->Grant_End_Date = date('Y-m-d');
                $model->isNewRecord = true;

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('create', [
                'model' => $model,
                'donors' => $this->getDonors(),
                'activities' => Yii::$app->navhelper->dropdown('GrantActivity','Grant_Activity','Activity_Name')
            ]);
        }


    }


    public function actionUpdate($LineNo){
       
       $service = Yii::$app->params['ServiceName']['RequisitionGrants'];
       $model = new RequisitionGrants();
        $model->isNewRecord = false;
       
        $filter = [
            
            'LineNo' => $LineNo,
            
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        if(is_array($result)){
            //load nav result to model
            Yii::$app->navhelper->loadmodel($result[0],$model) ;
        }else{
            Yii::$app->recruitment->printrr($result);
        }


        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Donorline'],$model,['Grant_Name']) ){

            $filter = [
                 
                'LineNo' => $model->LineNo,
                
            ];
            $refresh = Yii::$app->navhelper->getData($service, $filter);
            $model->Key = $refresh[0]->Key;

            //Yii::$app->recruitment->printrr($model);

            $result = Yii::$app->navhelper->updateData($service,$model,['Grant_Name']);

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if(!is_string($result)){

                return ['note' => '<div class="alert alert-success"> Line Updated Successfully. </div>' ];
            }else{

                return ['note' => '<div class="alert alert-danger">Error Updating Line: '.$result.'</div>'];
            }

        }

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('update', [
                'model' => $model,
                'donors' => $this->getDonors(),
                'activities' => Yii::$app->navhelper->dropdown('GrantActivity','Grant_Activity','Activity_Name')
            ]);
        }

        return $this->render('update',[
            'model' => $model,
            'donors' => $this->getDonors()
        ]);
    }

    public function actionDelete(){
        $service = Yii::$app->params['ServiceName']['RequisitionGrants'];
        $model = new RequisitionGrants();
        $result = Yii::$app->navhelper->deleteData($service,Yii::$app->request->get('Key'));
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!is_string($result)){
            return ['note' => '<div class="alert alert-success">Record Purged Successfully</div>'];
        }else{
            return ['note' => '<div class="alert alert-danger">Error Purging Record: '.$result.'</div>' ];
        }
    }

    

   
    /*Get Emp Contracts */

    public function getContracts(){
        $service = Yii::$app->params['ServiceName']['EmployeeContracts'];
        $filter = [];
        $result = \Yii::$app->navhelper->getData($service, $filter);

        $arr = [];
        $i = 0;

        if(is_array($result)){
            foreach($result as $res)
            {
                ++$i;
                $arr[$i] = [
                    'Code' => $res->Code,
                    'Description' => $res->Description
                ];
            }
            return ArrayHelper::map($arr,'Code','Description');
        }

        return $arr;

    }

    /*Get Donor List */

    public function getDonors(){
        $service = Yii::$app->params['ServiceName']['DonorList'];
        $filter = [];
        $result = \Yii::$app->navhelper->getData($service, $filter);
        $data = [];
        

        foreach($result as $res)
        {
            if(empty($res->Donor_Code) || empty($res->Donor_Name)) {
                continue;
            }
            $data[] = [
                'Donor_Code' => $res->Donor_Code,
                'Donor_Name' => $res->Donor_Code.' - '.$res->Donor_Name
            ];
        }
        return ArrayHelper::map($data, 'Donor_Code','Donor_Name');
       // return Yii::$app->navhelper->refactorArray($data,'Donor_Code','Donor_Name');

    }

    /*Get Locations*/

    public function getLocations(){
        $service = Yii::$app->params['ServiceName']['Locations'];
        $filter = [];
        $result = \Yii::$app->navhelper->getData($service, $filter);
        return ArrayHelper::map($result,'Code','Name');
    }

    /*Get Items*/

    public function getItems(){
        $service = Yii::$app->params['ServiceName']['Items'];
        $filter = [];
        $result = \Yii::$app->navhelper->getData($service, $filter);
        return ArrayHelper::map($result,'No','Description');
    }




    

    /*Get Vehicles */
    public function getVehicles(){
        $service = Yii::$app->params['ServiceName']['AvailableVehicleLookUp'];

        $result = \Yii::$app->navhelper->getData($service, []);
        $arr = [];
        $i = 0;
        foreach($result as $res){
            if(!empty($res->Vehicle_Registration_No) && !empty($res->Make_Model)){
                ++$i;
                $arr[$i] = [
                    'Code' => $res->Vehicle_Registration_No,
                    'Description' => $res->Make_Model
                ];
            }
        }

        return ArrayHelper::map($arr,'Code','Description');
    }


     /** Updates a single field */
     public function actionSetfield($field){
        $service = 'RequisitionGrants';
        $value = Yii::$app->request->post('fieldValue');
        $result = Yii::$app->navhelper->Commit($service,[$field => $value],Yii::$app->request->post('Key'));
        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;
        return $result;
          
    }






    
}