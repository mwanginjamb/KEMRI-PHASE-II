<?php

namespace frontend\models;
use yii\base\Model;


class RequisitionQuestions extends Model
{
    public $Key;
    public $Requisition_No;
    public $Line_No;
    public $Question;
    public $isNewRecord;

    public function rules()
    {
        return [
            [['Question'],'required'],
            ['Email','email'],

        ];
    }

    public function attributeLabels()
    {
        return [

        ];
    }
}