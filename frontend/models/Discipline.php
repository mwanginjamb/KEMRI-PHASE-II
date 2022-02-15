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


class Discipline extends Model
{

public $Key;
public $No;
public $Employee_No;
public $Employee_Name;
public $Global_Dimension_1_Code;
public $Global_Dimension_2_Code;
public $Offender;
public $Name_of_Offender;
public $Type_of_Offense;
public $Offense_Description;
public $Witness;
public $Witness_Name;
public $Policy_Violated;
public $Disciplinary_Findings;
public $Verdict;
public $Surcharge_Employee;
public $Amount;
public $Status;
public $isNewRecord;



    public function rules()
    {
        return [
           ['Verdict', 'string','max' => '250'],
           [['Verdict','Surcharge_Employee','Amount'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'Global_Dimension_1_Code' => 'Section',
            'Global_Dimension_2_Code' => 'Department'
        ];
    }



}