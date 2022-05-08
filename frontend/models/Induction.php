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


class Induction extends Model
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
    public $Overall_Status;

    public $Hr_Overrall_Comments;
    public $Employee_Overall_Comment;

    /*public function __construct(array $config = [])
    {
        return $this->getLines($this->No);
    }*/

    public function rules()
    {
        return [
            [['Employee_No', 'Global_Dimension_1_Code', 'Global_Dimension_2_Code', 'Reliever'], 'string'],
            [['CEO_Comments', 'HOO_Comments', 'HOF_Comments'], 'string', 'max' => 250]
        ];
    }

    public function attributeLabels()
    {
        return [
            'Global_Dimension_1_Code' => 'Program',
            'Global_Dimension_2_Code' => 'Department',
            'CEO_Comments' => 'C.E.O Commets',
            'HOO_Comments' => 'H.O.O Comments',
            'HOF_Comments' => 'H.O.F Comments'
        ];
    }

    public function getnextSection()
    {
        $service = Yii::$app->params['ServiceName']['HRInductionMgt'];
        $data = [
            'inductionNo' => $this->No
        ];

        $result = Yii::$app->navhelper->Codeunit($service, $data, 'IanFindNextSection');
        return ucwords($result['return_value']);
    }

    // Get Overall Lines

    public function getOverallLines($No)
    {
        $filter = [
            'Section' => $this->Action_Section,
            'Induction_No' => $this->No
        ];
        $service = Yii::$app->params['ServiceName']['InductionOverallIN'];
        $lines = Yii::$app->navhelper->getData($service, $filter);

        return $lines;
    }

    // Get Induction Items -  nested inside Overall Items
    public function getLines($Overall_Line_No)
    {
        $service = Yii::$app->params['ServiceName']['InductionLine'];
        $lines = Yii::$app->navhelper->getData($service, ['Overall_Line_No' => $Overall_Line_No]);

        return $lines;
    }

    public function IsThereNextSection()
    {
        $service = Yii::$app->params['ServiceName']['HRInductionMgt'];
        $No = Yii::$app->request->post('No');

        $data = [
            'inductionNo' => $this->No
        ];
        $result = Yii::$app->navhelper->Codeunit($service, $data, 'IanIsThereNextSection');
        //Yii::$app->recruitment->printrr($result);
        return $result['return_value'];
    }
}
