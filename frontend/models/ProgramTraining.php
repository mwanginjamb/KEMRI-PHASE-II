<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;
use Yii;


class ProgramTraining extends Model
{


    public $Key;
    public $Group_No;
    public $Requester;
    public $Requester_Name;
    public $Target_Group;
    public $Total_No_of_Traininees;
    public $Trainer;
    public $Nature_of_training;
    public $Training_Type;
    public $Training_Category;
    public $Training_Need;
    public $Training_Need_Description;
    public $Expected_Start_Date;
    public $Expected_End_Date;
    public $Institution;
    public $Venue;
    public $Training_Calender;
    public $Status;

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