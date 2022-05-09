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


class EmployeeTraining extends Model
{


    public $Key;
    public $Application_No;
    public $Training_Need;
    public $Date_of_Application;
    public $Training_Calender;
    public $Training_Need_Description;
    public $Employee_No;
    public $Employee_Name;
    public $Job_Group;
    public $Job_Title;
    public $Status;
    public $Start_Date;
    public $End_Date;
    public $Period;
    public $Expected_Cost;
    public $Trainer;
    public $Exceeds_Expected_Trainees;
    public $Training_Start_Date;
    public $CPD_Approved_Cost;
    public $Total_Cost;
    public $HRO_No;
    public $HRO_Name;
    public $Line_Manager;
    public $Manager_Name;
    public $Approval_rejection_Comments;
    public $Nature_of_Training;
    public $Training_Type;
    public $Training_Category;
    public $Recomended_Action;
    public $HRO_Comments;
    public $Line_Manager_Comments;
    public $Line_Manager_Rejection_Comment;
    public $attachment_one;
    public $attachment_two;

    public function rules()
    {
        return [
            [['attachment_one', 'attachment_two'], 'file', 'mimeTypes' => Yii::$app->params['QualificationsMimeTypes']],
            [['attachment_one', 'attachment_two'], 'file', 'maxSize' => '5120000'], //50mb
        ];
    }

    public function attributeLabels()
    {
        return [
            'attachment_one' => 'Training Attachment (PDF)',
            'Total_Cost' => 'Extra Cost'
        ];
    }
}
