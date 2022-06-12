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
                'only' => ['logout', 'signup', 'index', 'display-ess-grants', 'display-fms-grants'],
                'rules' => [
                    [
                        'actions' => ['signup', 'index', 'syncactivities', 'display-ess-grants', 'display-fms-grants'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'create', 'update', 'delete'],
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
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'only' => ['syncactivities', 'index', 'display-ess-grants', 'display-fms-grants'],
                'formatParam' => '_format',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    //'application/xml' => Response::FORMAT_XML,
                ],
            ]
        ];
    }

    public function actionIndex()
    {

        $fmsGrants = $this->getGrants();

        // Yii::$app->recruitment->printrr($fmsGrants);  

        //Yii::$app->recruitment->printrr($this->actionEssGrantCodes());



        if (is_array($fmsGrants)) {
            foreach ($fmsGrants as $grant) {
                if (!in_array($grant->No, $this->actionEssGrantCodes())) {
                    $result = $this->postToEss($grant);
                    $this->GrantLogger($result);
                    return $result;
                }
            }
        }
    }

    public function actionTest()
    {
        return 'Hallo Francis, what are you doing? ';
    }




    public function actionDelete()
    {
        $service = Yii::$app->params['ServiceName']['EmployeeAppraisalKPI'];
        $result = Yii::$app->navhelper->deleteData($service, Yii::$app->request->get('Key'));
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (!is_string($result)) {
            return ['note' => '<div class="alert alert-success">Record Purged Successfully</div>'];
        } else {
            return ['note' => '<div class="alert alert-danger">Error Purging Record: ' . $result . '</div>'];
        }
    }



    // Get FMS Grants

    public function getGrants()
    {
        $service = Yii::$app->params['FMS-ServiceName']['FMSGrants'];
        $data = Yii::$app->fms->getData($service, []);
        return $data;
    }


    public function actionEssGrants()
    {
        $service = Yii::$app->params['ServiceName']['GrantList'];
        $data = Yii::$app->navhelper->getData($service, []);
        // return $data;

        Yii::$app->recruitment->printrr($data);
    }

    public function postToEss($grant)
    {
        // Yii::$app->recruitment->printrr($grant->Name);
        $service = Yii::$app->params['ServiceName']['GrantList'];

        $args = [
            'Donor_Code' => !empty($grant->No) ? $grant->No : '',
            'Donor_Name' => !empty($grant->Name) ? $grant->Name : '',
            'Status' => ($grant->Blocked == '_blank_') ? 'Active' : 'Inactive',
            'Grant_Activity' => '',
            'Grant_Type' => !empty($grant->Class) ? $grant->Class : '',
            'Grant_Start_Date' => !empty($grant->Start_Date) ? $grant->Start_Date : date('Y-m-d'),
            'Grant_End_Date' => !empty($grant->End_Date) ? $grant->End_Date : date('Y-m-d'),
            'Grant_Accountant' => !empty($grant->Grant_Accountant) ? $grant->Grant_Accountant : date('Y-m-d'),
        ];

        // Post to ESS


        $result = Yii::$app->navhelper->postData($service, $args);

        print_r($result);
    }

    public function updateGrant($grant)
    {
        // Yii::$app->recruitment->printrr($grant->Name);
        $service = Yii::$app->params['ServiceName']['GrantList'];

        $args = [
            'Donor_Code' => $grant->No,
        ];

        $result = Yii::$app->navhelper->getData($service, $args);




        if (is_array($result)) {
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

        foreach ($data as $d) {
            if (isset($d->Donor_Code)) {
                array_push($codes, $d->Donor_Code);
            }
        }

        return $codes;

        // Yii::$app->recruitment->printrr($codes);
    }

    // Display Ess Grants

    public function actionDisplayEssGrants()
    {
        $this->layout = 'login';
        $service = Yii::$app->params['ServiceName']['GrantList'];
        $data = Yii::$app->navhelper->getData($service, []);
        $total = count($data);
        $result = [
            'Total' => $total,
            'data' => $data
        ];
        Yii::$app->recruitment->printrr($result);
    }

    // Display FMS Grants

    public function actionDisplayFmsGrants()
    {
        $service = Yii::$app->params['FMS-ServiceName']['FMSGrants'];
        $data = Yii::$app->fms->getData($service, []);
        $total = count($data);
        $result = [
            'Total' => $total,
            'data' => $data
        ];
        Yii::$app->recruitment->printrr($result);
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

        foreach ($data as $d) {
            if (isset($d->Grant_Activity)) {
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

        if (is_array($fmsActivities)) {
            foreach ($fmsActivities as $ac) {
                if (!in_array($ac->Code, $essactivitycodes)) :
                    $data = [
                        'Grant_Activity' => $ac->Code,
                        'Activity_Name' => $ac->Name,
                        'Blocked' => $ac->Blocked,
                    ];

                    $result = Yii::$app->navhelper->postData($service, $data);
                    $this->ActivityLogger($result);
                    return $result;
                endif;
                //exit;
            }
        } else {
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
        exit;
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
}
