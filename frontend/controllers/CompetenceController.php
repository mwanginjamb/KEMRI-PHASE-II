<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:21 PM
 */

namespace frontend\controllers;
use frontend\models\Employeeappraisalkra;
use frontend\models\Experience;
use frontend\models\Competence;
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

class CompetenceController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup','index'],
                'rules' => [
                    [
                        'actions' => ['signup','index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','index','create','update','delete'],
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
                'only' => [''],
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

    public function actionCreate($Appraisal_Code){

        $model = new Competence();
        $service = Yii::$app->params['ServiceName']['StEmployeeAppraisalCompetence'];
        $model->Appraisal_Code = $Appraisal_Code;
        $model->Employee_Code = Yii::$app->user->identity->{'Employee No_'};


// Do initial Request
        if(!isset(Yii::$app->request->post()['Competence'])){

            $request = Yii::$app->navhelper->postData($service,$model);
            //Yii::$app->recruitment->printrr($request);
            if(is_object($request) )
            {
                Yii::$app->navhelper->loadmodel($request,$model);
            }else{

                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                if(is_object($request)){

                    return ['note' => '<div class="alert alert-danger">Error : '.$request.'</div>' ];

                }
            }
        }
        

        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Competence'],$model)  && $model->validate() ){


            $result = Yii::$app->navhelper->updateData($service,$model);
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if(is_object($result)){

                return ['note' => '<div class="alert alert-success">Record Added Successfully. </div>'];

            }else{

                return ['note' => '<div class="alert alert-danger">Error : '.$result.'</div>' ];

            }

        }//End Saving experience

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('create', [
                'model' => $model,
                'ratings' => $this->getRatings(),
                'categories' =>  Yii::$app->navhelper->dropdown('CompetenceCategories','Category','Category'),
            ]);
        }

        return $this->render('create',[
            'model' => $model,
            'ratings' => $this->getRatings(),
            'categories' =>  Yii::$app->navhelper->dropdown('CompetenceCategories','Category','Category'),
        ]);
    }


    public function actionUpdate(){
        $model = new Competence() ;
        $model->isNewRecord = false;
        $service = Yii::$app->params['ServiceName']['StEmployeeAppraisalCompetence'];
        $filter = [
            'Line_No' => Yii::$app->request->get('Line_No'),
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        if(is_array($result)){
            //load nav result to model
            $model = Yii::$app->navhelper->loadmodel($result[0],$model) ;
        }else{
            Yii::$app->recruitment->printrr($result);
        }


        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Competence'],$model) && $model->validate() ){
            $result = Yii::$app->navhelper->updateData($service,$model);

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if(!is_string($result)){

                return ['note' => '<div class="alert alert-success">Record Updated Successfully. </div>' ];
            }else{

                return ['note' => '<div class="alert alert-danger">Error Updating Record: '.$result.'</div>'];
            }

        }

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('update', [
                'model' => $model,
                'ratings' => $this->getRatings(),
                'categories' =>  Yii::$app->navhelper->dropdown('CompetenceCategories','Category','Category'),
            ]);
        }

        return $this->render('update',[
            'model' => $model,
            'ratings' => $this->getRatings(),
            'categories' =>  Yii::$app->navhelper->dropdown('CompetenceCategories','Category','Category'),
        ]);
    }

    public function actionDelete(){
        $service = Yii::$app->params['ServiceName']['StEmployeeAppraisalCompetence'];
        $result = Yii::$app->navhelper->deleteData($service,Yii::$app->request->get('Key'));
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!is_string($result)){
            return ['note' => '<div class="alert alert-success">Record Purged Successfully</div>'];
        }else{
            return ['note' => '<div class="alert alert-danger">Error Purging Record: '.$result.'</div>' ];
        }
    }

    public function getRatings()
    {
          $service = Yii::$app->params['ServiceName']['AppraisalRating'];
          $data = Yii::$app->navhelper->getData($service, []);
          $result = Yii::$app->navhelper->refactorArray($data,'Rating','Rating_Description');
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






}