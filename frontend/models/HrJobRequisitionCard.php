<?php

namespace frontend\models;

use common\models\User;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;


class HrJobRequisitionCard extends Model
{
    public $Key;
    public $Requisition_No;
    public $Job_Id;
    public $Job_Description;
    public $Occupied_Position;
    public $No_Posts;
    public $Requisition_Type;
    public $Employment_Type;
    public $Reasons_For_Requisition;
    public $Status;
    public $Type;
    public $Previous_Requisition;
    public $Closed;
    public $Start_Date;
    public $Requisition_Period;
    public $End_Date;
    public $Probation_Period;
    public $Contract_Period;
    public $Criticality;
    public $Global_Dimension_1_Code;
    public $Global_Dimension_2_Code;
    public $Location;
    public $Contract_Type;
    public $Rejection_Comments;
    public $Is_Replacement;
    public $Replaced_Employee;
    public $Employee_Name;
    public $isNewRecord;
    public $Employee_No;
    public $Department_Name;
    public $Location_Name;
    public $Program_Name;
    public $Qualification_Description;
    public $Requisition_Details;
    public $Vacancies;
    public $Sitting_Location;
    public $Role_Description;
    public function rules()
    {
        return [
            [[
                'Job_Id', 'No_Posts', 'Contract_Period', 'Criticality', 'Type', 'Employment_Type', 'Location', 'Requisition_Details',
                'Start_Date',  'No_Posts', 'Contract_Type', 'Requisition_Type', 'Requisition_Period', 'Sitting_Location', 'Role_Description', 'Qualification_Description'
            ], 'required'],
            [['No_Posts'], 'number', 'min' => 1],

            // [['Contract_Period',], 'number', 'min'=>12, 'max'=>12, 'when' => function ($model) {
            //     return $model->Contract_Type == 'LT';
            // }, 'whenClient' => "function (attribute, value) {
            //     return $('#hrjobrequisitioncard-contract_type').val() == 'LT';
            // }"],

            // [['Contract_Period',], 'number', 'min'=>6, 'max'=>6, 'when' => function ($model) {
            //     return $model->Contract_Type == 'ST';
            // }, 'whenClient' => "function (attribute, value) {
            //     return $('#hrjobrequisitioncard-contract_type').val() == 'LT';
            // }"],

            [['Replaced_Employee'], 'required', 'when' => function ($model) {
                return $model->Type == 'Replacement';
            }, 'whenClient' => "function (attribute, value) {
                return $('#hrjobrequisitioncard-type').val() == 'Replacement';
            }"],



        ];
    }

    public function attributeLabels()
    {
        return [
            'Job_Id' => 'Job Title',
            'Global_Dimension_2_Code' => 'Department',
            'Global_Dimension_1_Code' => 'Programme',
            'End_Date' => 'Application End Date',
            'No_Posts' => 'Required Posts',
            // 'Contract_Period' => 'Contract Period in Months',
            'Type' => 'Reason For Requisition',
            'Start_Date' => 'Contract Start Date'
        ];
    }

    public function Questions()
    {
        $service = Yii::$app->params['ServiceName']['RequisitionQuestions'];
        $filter = [
            'Requisition_No' => $this->Requisition_No,
        ];

        $RequisitionQuestions = Yii::$app->navhelper->getData($service, $filter);
        return $RequisitionQuestions;
    }

    public function Grants()
    {
        $service = Yii::$app->params['ServiceName']['RequisitionGrants'];
        $filter = [
            'Requisition_No' => $this->Requisition_No,
        ];

        $RequisitionGrants = Yii::$app->navhelper->getData($service, $filter);
        return $RequisitionGrants;
    }
}
