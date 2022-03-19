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
use frontend\models\Misc;
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

class FmsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup','index'],
                'rules' => [
                    [
                        'actions' => ['signup','index','syncactivities'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','create','update','delete'],
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
                'only' => ['syncactivities','index'],
                'formatParam' => '_format',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    //'application/xml' => Response::FORMAT_XML,
                ],
            ]
        ];
    }

    public function actionIndex(){

         $fmsGrants = $this->getGrants();

         // Yii::$app->recruitment->printrr($fmsGrants);  

         //Yii::$app->recruitment->printrr($this->actionEssGrantCodes());

         
        
        if(is_array($fmsGrants))
		{
			foreach($fmsGrants as $grant)
			 {

                // Always check got updated  grants
               // $this->actionUpdated($grant);
              
				if(!in_array($grant->No,$this->actionEssGrantCodes()))
				{
					$result = $this->postToEss($grant);
					$this->GrantLogger($result);					
					return $result;
 
				}else{
                    print('No Grant to Sync....');
                }

                   
	  
			 }
		}
         

    }

    public function actionTest()
    {
        return 'Hallo Francis, what are you doing? ';
    }

    // Fetch Grants to post to HRMIS

    public function getGrants()
    {
          $service = Yii::$app->params['FMS-ServiceName']['FMSGrants'];
          $data = Yii::$app->fms->getData($service, []);
          return $data;
    }

    // A Diagnosis function to display all grants from FMS - ON BROWSER

    public function actionShowGrants()
    {
          $service = Yii::$app->params['FMS-ServiceName']['FMSGrants'];
          $data = Yii::$app->fms->getData($service, []);
          Yii::$app->recruitment->printrr($data);
    }

    // Check Update Grants

    public function actionUpdated($grant){
        $service = Yii::$app->params['FMS-ServiceName']['FMSGrants'];
        $res = Yii::$app->fms->isUpdated($service, $grant->Key);
        

        // Log updated Grants

        $obj = print_r($grant, true);

        $result = var_dump($res);
        if($res){
            
            $this->UpdateLogger($result);
            $this->UpdateLogger($obj);
            Yii::$app->session->set('ugrant', $grant);
            $this->UpdateLogger($grant);
        }

        
        $this->UpdateLogger($result);
        $this->UpdateLogger($obj);
 
    }

    public function actionInspect()
    {
        Yii::$app->recruitment->printrr(Yii::$app->session->get('ugrant'));
    }


     // A Diagnosis function to display all synced Grants in HRMIS - ON BROWSER

     public function actionEssGrants()
    {
          $service = Yii::$app->params['ServiceName']['GrantList'];
          $data = Yii::$app->navhelper->getData($service, []);
          // return $data;

          Yii::$app->recruitment->printrr($data);
    }

    // A function to send Grants to HRMIS - Main sync Function

    public function postToEss($grant)
    {
        // Yii::$app->recruitment->printrr($grant->Name);
        $service = Yii::$app->params['ServiceName']['GrantList'];

        $args = [
            'Donor_Code' => !empty($grant->No)?$grant->No:'',
            'Donor_Name' => !empty($grant->Name)?$grant->Name:'',
            'Status' => ($grant->Blocked == '_blank_')?'Active':'Inactive',
            'Grant_Activity' => '',
            'Grant_Type' => !empty($grant->Class)?$grant->Class:'' ,
            'Grant_Start_Date' => !empty($grant->Start_Date)?$grant->Start_Date: date('Y-m-d'),
            'Grant_End_Date' => !empty($grant->End_Date)?$grant->End_Date: date('Y-m-d'),
            'Grant_Accountant' => !empty($grant->Grant_Accountant)?$grant->Grant_Accountant: date('Y-m-d'),
        ];

        // Post to ESS


        $result = Yii::$app->navhelper->postData($service, $args);

        if(is_object($result)){
            return $result;
        }else if(is_string($result) && $result !== 'null'){
            return $result; // ERP Error
        }
        else{
            return 'No Grants to sync at the moment from FMS. Turus!!';
        }

       
        
    }

    public function updateGrant($grant)
    {
        // Yii::$app->recruitment->printrr($grant->Name);
        $service = Yii::$app->params['ServiceName']['GrantList'];

        $args = [
            'Donor_Code' => $grant->No ,
        ];

        $result = Yii::$app->navhelper->getData($service, $args);

       


        if(is_array($result))
        {
             $data = [
                    
                    
                    'Key' => $result[0]->Key
                ];


                // Post to ESS

                $res = Yii::$app->navhelper->updateData($service, $data);


                print '<br>';
                print_r($res);
                exit(true);
        }
        

       
    }


    public function actionEssGrantCodes()
    {
          $service = Yii::$app->params['ServiceName']['GrantList'];
          $data = Yii::$app->navhelper->getData($service, []);

           

          $codes = [];

          foreach($data as $d)
          {
            if(isset($d->Donor_Code)){
                 array_push($codes, $d->Donor_Code);
            }
           
          }

          return $codes;

         // Yii::$app->recruitment->printrr($codes);
    }


    /*Get FMS Grant Codes*/

     public function actionFmsactivities()
    {
          $service = Yii::$app->params['FMS-ServiceName']['FMSActivities'];
          $data = Yii::$app->fms->getData($service, []);

          //Yii::$app->recruitment->printrr($data);
          return $data;
    }



    /*Get Integrated Grant Activities- Those in ESS*/

    public function actionEssactivities()
    {
          $service = Yii::$app->params['ServiceName']['GrantActivities'];
          $data = Yii::$app->navhelper->getData($service, []);

          //Yii::$app->recruitment->printrr($data);
          return $data;
    }

     public function actionEssactivitycodes()
    {
          $service = Yii::$app->params['ServiceName']['GrantActivities'];
          $data = Yii::$app->navhelper->getData($service, []);

           

          $codes = [];

          foreach($data as $d)
          {
            if(isset($d->Grant_Activity)){
                 array_push($codes, $d->Grant_Activity);
            }
           
          }
           //Yii::$app->recruitment->printrr($codes);
          return $codes;

         
    }


    public function actionSyncactivities()
    {

        $service = Yii::$app->params['ServiceName']['GrantActivities'];
        $fmsActivities = $this->ActionFmsactivities();
        $essActivities = $this->ActionEssactivities();
        $essactivitycodes = $this->ActionEssactivitycodes();

        if(is_array($fmsActivities))
        {
            foreach($fmsActivities as $ac)
            {
                if(!in_array($ac->Code, $essactivitycodes)):
                    $data = [
                        'Grant_Activity' => $ac->Code ,
                        'Activity_Name' => $ac->Name ,
                        'Blocked' => $ac->Blocked ,
                    ];

                    $result = Yii::$app->navhelper->postData($service, $data);
					$this->ActivityLogger($result);
                    return $result;
                endif;
            //exit;
            }
        }else{
            return ['Message' => 'No Grant Activities To Synchronize.'];
        }

    }
	
	
	private function GrantLogger($message)
	{
		$filename = 'log/grant.txt';
		$req_dump = print_r($message, TRUE);
		$fp = fopen($filename, 'a');
		fwrite($fp, $req_dump);
		fclose($fp);
		
	}
	
	private function ActivityLogger($message)
	{
		$filename = 'log/activity.txt';
		$req_dump = print_r($message, TRUE);
		$fp = fopen($filename, 'a');
		fwrite($fp, $req_dump);
		fclose($fp);
       
       exit;
		
	}

    private function UpdateLogger($message)
	{
		$filename = 'log/update.txt';
		//$req_dump = print_r($message, TRUE);
		$fp = fopen($filename, 'a');
		fwrite($fp, $message);
		fclose($fp);
       
		
	}



}