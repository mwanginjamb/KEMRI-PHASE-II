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
public $Witness;
public $Witness_Name;
public $Status;
public $Rejection_Comments;
public $HRO_Emp_No;
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