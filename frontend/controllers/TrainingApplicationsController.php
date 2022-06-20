<?php

/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:21 PM
 */

namespace frontend\controllers;

use frontend\models\EmployeeTraining;
use frontend\models\Imprestcard;
use frontend\models\Induction;
use frontend\models\Training;
use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\Response;

class TrainingApplicationsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'index', 'list', 'create', 'update', 'delete', 'view'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'index', 'list', 'create', 'update', 'delete', 'view'],
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
                'only' => ['list'],
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

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {

        return $this->render('index');
    }





    public function actionCreate()
    {

        $model = new Induction();
        $service = Yii::$app->params['ServiceName']['InductionCard'];

        // Once Initial Request is Made Redirect to Update Page

        $model->Employee_No = Yii::$app->user->identity->{'Employee No_'};
        $request = Yii::$app->navhelper->postData($service, $model);
        if (is_object($request)) {
            return $this->redirect(['update', 'Key' => $request->Key]);
        } else { // error situation
            Yii::$app->session->setFlash('error', $request, true);
            return $this->redirect(['index']);
        }
    }



    public function actionUpdate($No = '', $Key = '')
    {
        $model = new EmployeeTraining();
        $service = Yii::$app->params['ServiceName']['TrainingApplicationCard'];
        $model->isNewRecord = false;

        // Get Document
        if (!empty($No)) {
            $document = Yii::$app->navhelper->findOne($service, ['Application_No' => $No]);
        } elseif (!empty($Key)) {
            $document = Yii::$app->navhelper->readByKfey($service, $Key);
        } else {
            Yii::$app->session->setFlash('error', 'We are unable to fetch a document to update', true);
            return Yii::$app->redirect(['index']);
        }

        if (is_object($document)) {
            //load nav result to model
            $model = Yii::$app->navhelper->loadmodel($document, $model); //$this->loadtomodeEmployee_Nol($result[0],$Expmodel);
        } else {
            Yii::$app->session->setFlash('error', $document, true);
            return Yii::$app->redirect(['index']);
        }



        return $this->render('update', [
            'model' => $model,
            'document' => $document,
            'attachments' => Yii::$app->navhelper->getData(Yii::$app->params['ServiceName']['DisciplinaryAttachments'], ['Document_No' => $model->Application_No])
        ]);
    }

    public function actionDelete()
    {
        $service = Yii::$app->params['ServiceName']['AcademicTraining'];
        $result = Yii::$app->navhelper->deleteData($service, Yii::$app->request->get('Key'));
        // Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (!is_string($result)) {

            Yii::$app->session->setFlash('success', 'Record Purged Successfully.');
            return $this->redirect(['index']);
        } else {

            Yii::$app->session->setFlash('error', 'Error Purging Record: ' . $result);
            return $this->redirect(['index']);
        }
    }

    public function actionView($No = '', $Key = '')
    {
        $service = Yii::$app->params['ServiceName']['TrainingApplicationCard'];
        $model = new EmployeeTraining();

        // Get Document
        if (!empty($No)) {
            $document = Yii::$app->navhelper->findOne($service, ['Application_No' => $No]);
        } elseif (!empty($Key)) {
            $document = Yii::$app->navhelper->readByKey($service, $Key);
        } else {
            // Yii::$app->session->setFlash('error', 'We are unable to fetch the document', true);
            return $this->redirect(['index']);
        }

        //load nav result to model
        $model = Yii::$app->navhelper->loadmodel($document, $model);

        return $this->render('view', [
            'model' => $model,
            'document' =>  $document,
            'attachments' => Yii::$app->navhelper->getData(Yii::$app->params['ServiceName']['DisciplinaryAttachments'], ['Document_No' => $model->Application_No])
        ]);
    }

    public function actionUpload()
    {

        $targetPath = '';
        if ($_FILES) {
            $uploadedFile = $_FILES['attachment']['name'];
            list($pref, $ext) = explode('.', $uploadedFile);
            $targetPath = './uploads/' . Yii::$app->security->generateRandomString(5) . '.' . $ext; // Create unique target upload path

            // Create upload directory if it dnt exist.
            if (!is_dir(dirname($targetPath))) {
                FileHelper::createDirectory(dirname($targetPath));
                chmod(dirname($targetPath), 0755);
            }
        }

        // Upload
        if (Yii::$app->request->isPost) {
            $DocumentService = Yii::$app->params['ServiceName'][Yii::$app->request->post('DocumentService')];
            $parentDocument = Yii::$app->navhelper->readByKey($DocumentService, Yii::$app->request->post('Key'));

            $metadata = [];
            if (is_object($parentDocument) && isset($parentDocument->Key)) {
                /* $metadata = [
                    'Application' => $parentDocument->Application_No,
                    'Employee' => $parentDocument->Employee_No,
                    'Leavetype' => 'Imprest - ' . !empty($parentDocument->Purpose) ?? '',
                ];*/
            }
            Yii::$app->session->set('metadata', $metadata);


            $file = $_FILES['attachment']['tmp_name'];
            //Return JSON
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if (move_uploaded_file($file, $targetPath)) {
                // Upload to sharepoint
                //$spResult = Yii::$app->recruitment->sharepoint_attach($targetPath);
                return [
                    'status' => 'success',
                    'message' => 'File Uploaded Successfully',
                    'filePath' => $targetPath
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Could not upload file at the moment.'
                ];
            }
        }


        // Update Nav -  Get Request
        if (Yii::$app->request->isGet) {
            $fileName = basename(Yii::$app->request->get('filePath'));

            $DocumentService = Yii::$app->params['ServiceName'][Yii::$app->request->get('documentService')];
            $AttachmentService = Yii::$app->params['ServiceName'][Yii::$app->request->get('Service')];
            $Document = Yii::$app->navhelper->readByKey($DocumentService, Yii::$app->request->get('Key'));

            $data = [];
            if (is_object($Document) && isset($Document->Application_No)) {
                $data = [
                    'Document_No' => $Document->Application_No,
                    'Name' => Yii::$app->request->get('Name') ?? $fileName,
                    'File_path' => \yii\helpers\Url::home(true) . 'uploads/' . $fileName,
                ];
            }

            // Update Nav
            $result = Yii::$app->navhelper->postData($AttachmentService, $data);

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if (is_object($result)) {
                return $result;
            } else {
                return $result;
            }
        }
    }


    public function actionRead()
    {
        $path = Yii::$app->request->post('path');
        $No = Yii::$app->request->post('No');
        $binary = @file_get_contents($path);
        $content = chunk_split(base64_encode($binary));
        return $this->render('read', [
            'path' => $path,
            'No' => $No,
            'content' => $content
        ]);
    }

    public function actionList()
    {
        $service = Yii::$app->params['ServiceName']['TrainingApplicationsList'];

        $filter = [
            'Employee_No' => \Yii::$app->user->identity->{'Employee No_'},
        ];

        //Yii::$app->recruitment->printrr($filter);
        $records = \Yii::$app->navhelper->getData($service, $filter);

        $result = [];
        $count = 0;

        foreach ($records as $quali) {

            if (empty($quali->Key)) {
                continue;
            }

            ++$count;
            $Deletelink = $updateLink = $viewLink = $applyLink = $sendForApproval =  '';
            $updateLink = Html::a('<i class="fa fa-edit"></i>', ['update', 'Key' => $quali->Key], ['class' => 'update btn btn-outline-info btn-xs', 'title' => 'Update Record']);
            $viewLink = Html::a('<i class="fa fa-eye"></i>', ['view', 'Key' => $quali->Key], ['class' => 'btn btn-outline-info btn-xs mx-2', 'title' => 'View Document']);
            $sendForApproval = ($quali->Status == 'New') ? Html::a('<i class="fa fa-forward"></i>', ['send-for-approval'], [
                'class' => 'btn btn-outline-success btn-xs mx-2',
                'title' => 'Send for Approval',
                'data' => [
                    'params' => [
                        'No' => $quali->Application_No
                    ],
                    'confirm' => 'Are you sure you want to send this request for approval?',
                    'method' => 'post'
                ]
            ]) : '';
            $cancelApproval = ($quali->Status == 'Pending_Approval') ? Html::a('<i class="fa fa-times"></i>', ['cancelApprovalRequest', 'No' => $quali->Application_No], ['class' => 'btn btn-outline-warning btn-xs mx-2', 'title' => 'Cancel Approval Request']) : '';


            $Deletelink = Html::a('<i class="fa fa-trash"></i>', ['delete', 'Key' => $quali->Key], [
                'class' => 'btn btn-outline-danger btn-xs text-danger',
                'title' => 'Delete Record.',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this record?',
                    'method' => 'post',
                ]
            ]);


            $result['data'][] = [

                'Employee_No' => !empty($quali->Employee_No) ? $quali->Employee_No : '',
                'Employee_Name' => !empty($quali->Employee_Name) ? $quali->Employee_Name : '',
                'Application_No' => !empty($quali->Application_No) ? $quali->Application_No : '',
                'Date_of_Application' => !empty($quali->Date_of_Application) ? $quali->Date_of_Application : '',
                'Training_Calender' => !empty($quali->Training_Calender) ? $quali->Training_Calender : '',
                'Period' => !empty($quali->Period) ? $quali->Period : '',
                'Trainer' => !empty($quali->Trainer) ? $quali->Trainer : '',
                'Status' => !empty($quali->Status) ? $quali->Status : '',
                'Action' => $viewLink . $updateLink . $sendForApproval . $cancelApproval
            ];
        }
        return $result;
    }


    public function actionAttended()
    {

        $status = [
            ['Code' => '_blank_', 'Desc' => '_blank_'],
            ['Code' => 'Yes', 'Desc' => 'Yes'],
            ['Code' => 'No', 'Desc' => 'No'],
        ];

        $data =  ArrayHelper::map($status, 'Code', 'Desc');
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $data;
    }


    // Training Cost Drop Down

    public function actionCostDescription()
    {

        $data = Yii::$app->navhelper->dropdown('TrainingCosts', 'Description', 'Description');
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

        $result = Yii::$app->navhelper->Codeunit($service, $data, 'IanSendTrainingForApproval');

        if (!is_string($result)) {
            Yii::$app->session->setFlash('success', 'Document sent for approval Successfully.', true);
            return $this->redirect(['index']);
        } else {

            Yii::$app->session->setFlash('error', 'Error  : ' . $result);
            return $this->redirect(['index']);
        }
    }
    /*Cancel Approval Request */

    public function actionApproveInduction($No)
    {
        $service = Yii::$app->params['ServiceName']['HRAPPRAISALMGT'];

        $data = [
            'inductionNo' => $No,
            'urLToSend' => Yii::$app->urlManager->createAbsoluteUrl(['induction/view', 'No' => $No]),
        ];


        $result = Yii::$app->navhelper->Codeunit($service, $data, 'IanApproveInduction');

        if (!is_string($result)) {
            Yii::$app->session->setFlash('success', 'Document Approved Successfully.', true);
            return $this->redirect(['index']);
        } else {

            Yii::$app->session->setFlash('error', 'Error.  : ' . $result);
            return $this->redirect(['index']);
        }
    }

    // Send Induction To Next Section

    public function actionNextSection()
    {
        $service = Yii::$app->params['ServiceName']['HRAPPRAISALMGT'];
        $No = Yii::$app->request->post('No');
        $Key = Yii::$app->request->post('Key');

        $data = [
            'inductionNo' => $No,
            'approvalURL' => Yii::$app->urlManager->createAbsoluteUrl(['induction/view', 'Key' => $Key]),
        ];


        $result = Yii::$app->navhelper->Codeunit($service, $data, 'IanSendInductionToNextSection');

        if (!is_string($result)) {
            Yii::$app->session->setFlash('success', 'Document Sent to Next Section Successfully.', true);
            return $this->redirect(['update', 'Key' => $Key]);
        } else {
            Yii::$app->session->setFlash('error', 'Error : ' . $result);
            return $this->redirect(['index']);
        }
    }





    /** Updates a single field */
    public function actionSetfield($field)
    {
        $service = 'ImprestRequestSubformPortal';
        $value = Yii::$app->request->post('fieldValue');
        $result = Yii::$app->navhelper->Commit($service, [$field => $value], Yii::$app->request->post('Key'));
        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;
        return $result;
    }

    public function actionAddLine($Service, $Document_No)
    {
        $service = Yii::$app->params['ServiceName'][$Service];
        $data = [
            'Application_No' => $Document_No,
            'Line_No' => time()
        ];

        // Insert Record

        $result = Yii::$app->navhelper->postData($service, $data);

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (is_object($result)) {
            return [
                'note' => 'Record Created Successfully.',
                'result' => $result
            ];
        } else {
            return ['note' => $result];
        }
    }

    public function actionCommit()
    {
        $commitService = Yii::$app->request->post('service');
        $key = Yii::$app->request->post('key');
        $name = Yii::$app->request->post('name');
        $value = Yii::$app->request->post('value');

        $service = Yii::$app->params['ServiceName'][$commitService];
        $request = Yii::$app->navhelper->readByKey($service, $key);
        $data = [];
        if (is_object($request)) {
            $data = [
                'Key' => $request->Key,
                $name => $value
            ];
        } else {
            Yii::$app->response->format = \yii\web\response::FORMAT_JSON;
            return ['error' => $request];
        }

        $result = Yii::$app->navhelper->updateData($service, $data);
        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;
        return $result;
    }




    public function actionDeleteLine($Service, $Key)
    {
        $service = Yii::$app->params['ServiceName'][$Service];
        $result = Yii::$app->navhelper->deleteData($service, Yii::$app->request->get('Key'));
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (!is_string($result)) {

            return ['note' => '<div class="alert alert-success">Record Purged Successfully</div>'];
        } else {
            return ['note' => '<div class="alert alert-danger">Error Purging Record: ' . $result . '</div>'];
        }
    }
}
