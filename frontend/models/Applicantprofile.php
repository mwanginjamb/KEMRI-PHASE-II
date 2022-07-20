<?php

/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 11:45 AM
 */

namespace frontend\models;

use yii\base\Model;
use yii\web\UploadedFile;

class Applicantprofile extends Model
{

    public $No;
    public $First_Name;
    public $Middle_Name;
    public $Last_Name;
    public $Initials;
    public $Full_Name;
    public $Gender;
    public $Address;
    public $Country_Region_Code;
    public $City;
    public $Post_Code;
    public $County;
    public $Phone_No;
    public $Mobile_Phone_No;
    public $E_Mail;
    public $Birth_Date;
    public $Describe_Disability;
    public $Disabled;
    public $Age;
    public $National_ID;
    public $NHIF_Number;
    public $NSSF_Number;
    public $KRA_Number;
    public $Marital_Status;
    public $imageFile;
    public $ImageUrl;
    public $Key;
    public $Citizenship;
    public $Verified;
    public $EmployeeNo;
    public $Motivation;
    public $CommiteeID;
    public $ApplicationID;
    public $PortalId;
    public $Accepted_Data_Protec_Terms;


    public function rules()
    {
        return [
            [['E_Mail', 'First_Name', 'Last_Name', 'Citizenship', 'National_ID', 'NHIF_Number', 'NSSF_Number', 'Verified', 'KRA_Number', 'Marital_Status'],  'required'],
            [['E_Mail'], 'email'],

            //[['Motivation'],'string','max' => 250],
            [['imageFile'], 'file', 'mimeTypes' => ['image/png', 'image/jpeg']]
        ];
    }

    public function attributeLabels()
    {
        return [
            'KRA_Number' => 'KRA P.I.N',
            'NSSF_Number' => 'NSSF Number',
            'Verified' => 'Accept Terms and Conditions'
        ];
    }

    public function upload()
    {
        if ($this->validate('imageFile')) {
            $this->imageFile->saveAs('profile/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            $this->ImageUrl = 'profile/' . $this->imageFile->name;
            return true;
        } else {
            return $this->getErrors();
        }
    }

    public function getInterviewQuestions($CommiteeID, $EmpNo)
    {
        $service = \Yii::$app->params['ServiceName']['InterviewMemberEntries'];
        $filter = [
            'Profile_No' => $this->No,
            'Interview_No' => $CommiteeID,
            'Member_No' => $EmpNo
        ];
        $result = \Yii::$app->navhelper->getData($service, $filter);
        // echo '<pre>';
        // print_r($result);
        // exit;

        if (is_array($result)) {
            return $result;
        }
        return false;
    }
}
