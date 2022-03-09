<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class RequisitionGrants extends Model
{

public $Key;
public $Requisition_No;
public $Donor_Code;
public $Donor_Name;
public $Percentage;
public $Grant_Start_Date;
public $Grant_End_Date;
public $Grant_Activity;
public $Grant_Type;
public $Grant_Status;
public $Line_No;
public $isNewRecord;
public $LineNo;

public $Contract_Grant_End_Date;
public $Contract_Grant_Start_Date;

    public function rules()
    {
        return [

        ];
    }

    public function attributeLabels()
    {
        return [
            // 'Contract_Grant_End_Date' => 'Contract End Date',
            // 'Contract_Grant_Start_Date' => 'Contract Start Date',
        ];
    }
}