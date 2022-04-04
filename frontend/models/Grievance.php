<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use common\models\User;
use Yii;
use yii\base\Model;


class Grievance extends Model
{

public $Key;
public $No;
public $Employee_No;
public $Employee_Name;
public $Grievance_Against;
public $Name;
public $Date_of_grievance;
public $Grievance_Type;
public $Grievance_Description;
public $Witness_Type;
public $Status;
public $Rejection_Comments;
public $HRO_Emp_No;
public $HRO_Findings;
public $Complaint_Classification;
public $Employee_Comments;
public $Severity_of_grievance;
public $HRM_Emp_No;
public $HRM_Emp_Name;
public $HRM_User_ID;
public $HRM_Comment;
public $HRM_Rejection_Comments;
public $HRM_Findings;
public $HOH_Findings;
public $isNewRecord;
public $attachment;




    public function rules()
    {
        return [
            [['attachment'],'file','mimeTypes' => Yii::$app->params['QualificationsMimeTypes']],
            [['attachment'],'file','maxSize' => '5120000'], //50mb
        ];
    }

    public function attributeLabels()
    {
        return [
            'attachment' => 'Grievance Attachment (PDFs only)'
        ];
    }



}