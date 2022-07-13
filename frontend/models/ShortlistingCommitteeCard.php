<?php
namespace frontend\models;
use yii\base\Model;


class ShortlistingCommitteeCard extends Model
{
    public $No;
    public $Requisition_No;
    public $Job_Code;
    public $Job_Description;
    public $Requisition_Purpose;
    public $Status;
    public $Pass_Mark;
    public $Start_Date;
    public $ShortList_Period;
    public $End_Date;

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