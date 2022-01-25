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


class PeriodicInduction extends Model
{

public $Key;
public $No;
public $Employee_No;
public $Employee_Name;
public $Global_Dimension_1_Code;
public $Global_Dimension_2_Code;
public $Global_Dimension_3_Code;
public $Status;
public $CEO_Comments;
public $HOO_Comments;
public $HOF_Comments;
public $Action_Section;
public $Action_ID;
public $isNewRecord;

    /*public function __construct(array $config = [])
    {
        return $this->getLines($this->No);
    }*/

    public function rules()
    {
        return [
            [['Employee_No','Global_Dimension_1_Code','Global_Dimension_2_Code','Reliever'], 'string'],
            [['CEO_Comments','HOO_Comments','HOF_Comments'],'string','max'=> 250]
        ];
    }

    public function attributeLabels()
    {
        return [
            'Global_Dimension_1_Code' => 'Program',
            'Global_Dimension_2_Code' => 'Department',
        ];
    }

    public function getnextSection()
    {
        $service = Yii::$app->params['ServiceName']['HRAPPRAISALMGT'];
        $data = [
            'inductionNo' => $this->No
        ];

        $result = Yii::$app->navhelper->Codeunit($service,$data,'IanFindNextSection');
        return ucwords($result['return_value']);
    }

    // Get Induction Items -  nested inside Overall Items
    public function getLines($Overall_Line_No)
    {
            $service = Yii::$app->params['ServiceName']['PeriodicInductionSubForm'];
            $lines = Yii::$app->navhelper->getData($service, ['Overall_Line_No' => $Overall_Line_No]);

            return $lines;
    }



}