<?php
namespace frontend\models;
use common\models\User;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;


class HrJobRequisitionCard extends Model{
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
    public $isNewRecord;

    public function rules(){
        return [
        ];
    }

    public function attributeLabels()
    {
        return [
            'Global_Dimension_1_Code'=> 'Program',
            'Global_Dimension_2_Code'=> 'Department',
            'Start_Date'=>'Application Start Date',
            'End_Date'=>'Application End Date',
            'No_Posts'=>'Required Posts'
        ];
    }

    /*Get Dues*/
    public function getDues(){
        $service = Yii::$app->params['ServiceName']['FinalDues'];
        $filter = [
            'Exit_No' => $this->Exit_No,
        ];

        $lines = Yii::$app->navhelper->getData($service, $filter);
        return $lines;

    }




}