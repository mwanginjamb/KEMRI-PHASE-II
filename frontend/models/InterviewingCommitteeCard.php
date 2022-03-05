<?php
namespace frontend\models;
use yii\base\Model;


class InterviewingCommitteeCard extends Model
{
    public $No;
    public $Requisition_No;
    public $Job_Code;
    public $Job_Description;
    public $Requisition_Purpose;
    public $Key;
    public $isNewRecord;

    public function rules()
    {
        return [
        ];
    }

    public function attributeLabels()
    {
        return [
        ];
    }
}