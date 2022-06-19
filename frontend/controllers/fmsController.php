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
                'only' => ['logout', 'signup', 'index', 'display-ess-grants', 'display-fms-grants', 'display-fms-activities', 'display-ess-activities'],
                'rules' => [
                    [
                        'actions' => ['signup', 'index', 'syncactivities', 'display-ess-grants', 'display-fms-grants', 'display-fms-activities', 'display-ess-activities'],
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
                'only' => ['syncactivities', 'index', 'display-ess-grants', 'display-fms-grants', 'display-fms-activities', 'display-ess-activities'],
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

    public function actionUnlinkGrants()
    {
        $grants = $this->actionDisplayEssGrants()['data'];
        //Yii::$app->recruitment->printrr($grants);
        foreach ($grants as $grant) {
            $this->actionDeleteEssGrant($grant);
        }
    }

    public function actionUnlinkActivities()
    {
        $activities = $this->actionDisplayEssActivities()['data'];
        //Yii::$app->recruitment->printrr($activities);
        foreach ($activities as $activity) {
            $this->actionDeleteEssActivity($activity);
        }
    }

    public function actionTest()
    {
        return 'Hallo Francis, what are you doing? ';
    }



    // Get FMS Grants

    public function getGrants()
    {
        $service = Yii::$app->params['FMS-ServiceName']['FMSGrants'];
        $data = Yii::$app->fms->getData($service, []);
        return $data;
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

    public function actionDeleteEssGrant($grant)
    {
        $service = Yii::$app->params['ServiceName']['GrantList'];
        $result = Yii::$app->navhelper->deleteData($service, $grant->Key);
        return $result;
    }

    public function actionDeleteEssActivity($activity)
    {
        $service = Yii::$app->params['ServiceName']['GrantActivities'];
        $result = Yii::$app->navhelper->deleteData($service, $activity->Key);
        return $result;
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
        $total = is_array($data) ? count($data) : 0;
        $result = [
            'Total' => $total,
            'data' => $data
        ];

        return $result;
        // Yii::$app->recruitment->printrr($result);
    }

    // Display FMS Grants

    public function actionDisplayFmsGrants()
    {
        $service = Yii::$app->params['FMS-ServiceName']['FMSGrants'];
        $data = Yii::$app->fms->getData($service, []);
        $total = is_array($data) ? count($data) : 0;
        $result = [
            'Total' => $total,
            'data' => $data
        ];
        Yii::$app->recruitment->printrr($result);
    }


    /*Get FMS Grant Codes*/

    public function actionDisplayFmsActivities()
    {
        $service = Yii::$app->params['FMS-ServiceName']['FMSActivities'];
        $data = Yii::$app->fms->getData($service, []);

        $total = is_array($data) ? count($data) : 0;
        return ([
            'Total' => $total,
            'data' =>  $data
        ]);
    }



    /*Get Integrated Grant Activities- Those in ESS*/

    public function actionDisplayEssActivities()
    {
        $service = Yii::$app->params['ServiceName']['GrantActivities'];
        $data = Yii::$app->navhelper->getData($service, []);
        $total = is_array($data) ? count($data) : 0;
        return [
            'Total' => $total,
            'data' =>  $data
        ];
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
        return $codes;
    }


    public function actionSyncactivities()
    {
        $service = Yii::$app->params['ServiceName']['GrantActivities'];
        $fmsActivities = $this->ActionDisplayFmsActivities()['data'];
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
        //exit;
    }

    private function ActivityLogger($message)
    {
        $filename = 'log/activity.txt';
        $req_dump = print_r($message, TRUE);
        $fp = fopen($filename, 'a');
        fwrite($fp, $req_dump);
        fclose($fp);
        // exit;
    }
}
