<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/11/2020
 * Time: 12:17 PM
 */


//var_dump(Yii::$app->recruitment->hasProfile(Yii::$app->session->get('ProfileID')));
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$profileAction = (Yii::$app->recruitment->EmployeeUserHasProfile())?'update?No='.Yii::$app->recruitment->getEmployeeApplicantProfile():'view-profile';

//var_dump(Yii::$app->recruitment->hasProfile(Yii::$app->session->get('ProfileID')));
?>

<style>
    
        /*custom font*/
        @import url(https://fonts.googleapis.com/css?family=Merriweather+Sans);

        * {margin: 0; padding: 0;}

        html, body {min-height: 100%;}

        .breadcrumbb {
            text-align: center;
            /* padding-top: 100px; */
            /* background: #689976; */
            /* background: linear-gradient(#689976, #ACDACC); */
            font-family: 'Merriweather Sans', arial, verdana;
        }

        .breadcrumbb {
            /*centering*/
            display: inline-block;
            box-shadow: 0 0 15px 1px rgba(0, 0, 0, 0.35);
            overflow: hidden;
            border-radius: 5px;
            /*Lets add the numbers for each link using CSS counters. flag is the name of the counter. to be defined using counter-reset in the parent element of the links*/
            counter-reset: flag; 
        }
        .help-block{
            color: red;
        }

        .required>label:after {
            content:" *";
            color: red;
            display: inline-block;
            padding-left: 0.2em;
        }

        .breadcrumbb a {
            text-decoration: none;
            outline: none;
            display: block;
            float: left;
            font-size: 12px;
            line-height: 36px;
            color: white;
            /*need more margin on the left of links to accomodate the numbers*/
            padding: 0 10px 0 60px;
            background: #666;
            background: linear-gradient(#666, #333);
            position: relative;
        }
        /*since the first link does not have a triangle before it we can reduce the left padding to make it look consistent with other links*/
        .breadcrumbb a:first-child {
            padding-left: 46px;
            border-radius: 5px 0 0 5px; /*to match with the parent's radius*/
        }
        .breadcrumbb a:first-child:before {
            left: 14px;
        }
        .breadcrumbb a:last-child {
            border-radius: 0 5px 5px 0; /*this was to prevent glitches on hover*/
            padding-right: 20px;
        }

        /*hover/active styles*/
        .breadcrumbb a.active, .breadcrumbb a:hover{
            background: #333;
            background: linear-gradient(#333, #000);
        }
        .breadcrumbb a.active:after, .breadcrumbb a:hover:after {
            background: #333;
            background: linear-gradient(135deg, #333, #000);
        }

        /*adding the arrows for the breadcrumbbs using rotated pseudo elements*/
        .breadcrumbb a:after {
            content: '';
            position: absolute;
            top: 0; 
            right: -18px; /*half of square's length*/
            /*same dimension as the line-height of .breadcrumb a */
            width: 36px; 
            height: 36px;
            /*as you see the rotated square takes a larger height. which makes it tough to position it properly. So we are going to scale it down so that the diagonals become equal to the line-height of the link. We scale it to 70.7% because if square's: 
            length = 1; diagonal = (1^2 + 1^2)^0.5 = 1.414 (pythagoras theorem)
            if diagonal required = 1; length = 1/1.414 = 0.707*/
            transform: scale(0.707) rotate(45deg);
            /*we need to prevent the arrows from getting buried under the next link*/
            z-index: 1;
            /*background same as links but the gradient will be rotated to compensate with the transform applied*/
            background: #666;
            background: linear-gradient(135deg, #666, #333);
            /*stylish arrow design using box shadow*/
            box-shadow: 
                2px -2px 0 2px rgba(0, 0, 0, 0.4), 
                3px -3px 0 2px rgba(255, 255, 255, 0.1);
            /*
                5px - for rounded arrows and 
                50px - to prevent hover glitches on the border created using shadows*/
            border-radius: 0 5px 0 50px;
        }
        /*we dont need an arrow after the last link*/
        .breadcrumbb a:last-child:after {
            content: none;
        }
        /*we will use the :before element to show numbers*/
        .breadcrumbb a:before {
            content: counter(flag);
            counter-increment: flag;
            /*some styles now*/
            border-radius: 100%;
            width: 20px;
            height: 20px;
            line-height: 20px;
            margin: 8px 0;
            position: absolute;
            top: 0;
            left: 30px;
            background: #444;
            background: linear-gradient(#444, #222);
            font-weight: bold;
        }


        .flat a, .flat a:after {
            background: white;
            color: black;
            transition: all 0.5s;
        }
        .flat a:before {
            background: white;
            box-shadow: 0 0 0 1px #ccc;
        }
        .flat a:hover, .flat a.active, 
        .flat a:hover:after, .flat a.active:after{
            background: #9EEB62;
        }







</style>

<!-- another version - flat style with animated hover effect -->

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="breadcrumbb flat">
                    <a href="<?=  Yii::$app->recruitment->absoluteUrl() .'recruitment/applicant-details?ProfileID='.$model->No.'&ComitteID='.$model->CommiteeID.'&ApplicationID='.$model->ApplicationID?>" <?= Yii::$app->recruitment->currentaction('recruitment',['applicant-details', 'update'])?'class="active"': '' ?>>Personal Info</a>
                    <a href="<?=  Yii::$app->recruitment->absoluteUrl() .'recruitment/qualification/?ProfileID='.$model->No .'&ComitteID='.$model->CommiteeID.'&ApplicationID='.$model->ApplicationID ?>" <?= Yii::$app->recruitment->currentaction('recruitment','qualification')?'class="active"': '' ?>>Academic Qualifications</a>
                    <a href="<?=  Yii::$app->recruitment->absoluteUrl() .'recruitment/proffesional-qualifications?ProfileID='.$model->No .'&ComitteID='.$model->CommiteeID.'&ApplicationID='.$model->ApplicationID ?>" <?= Yii::$app->recruitment->currentaction('recruitment','proffesional-qualifications')?'class="active"': '' ?>>Proffesonal Certifications</a>
                    <a href="<?=  Yii::$app->recruitment->absoluteUrl() .'recruitment/work-experience?ProfileID='.$model->No . '&ComitteID='.$model->CommiteeID.'&ApplicationID='.$model->ApplicationID ?>" <?= Yii::$app->recruitment->currentaction('recruitment','work-experience')?'class="active"': '' ?>>Employment record</a>
                    <!-- <a href="<?=  Yii::$app->recruitment->absoluteUrl() .'hobby/index' ?>" <?= Yii::$app->recruitment->currentaction('hobby','index')?'class="active"': '' ?>>Hobbies</a> -->
                    <!-- <a href="<?=  Yii::$app->recruitment->absoluteUrl() .'language/index' ?>" <?= Yii::$app->recruitment->currentaction('language','index')?'class="active"': '' ?>>Extended profile Questions</a> -->
                    <!-- <a href="<?=  Yii::$app->recruitment->absoluteUrl() .'referee/index' ?>" <?= Yii::$app->recruitment->currentaction('referee','index')?'class="active"': '' ?>>Referees</a> -->
                    <!-- <a href="<?=  Yii::$app->recruitment->absoluteUrl() .'recruitment/declaration' ?>" <?= Yii::$app->recruitment->currentaction('recruitment','declaration')?'class="active"': '' ?>>Declaration</a> -->
                </div>
           <hr>

            <!-- <?= Html::a('<i class="fas fa-backward"></i> Go Back To List',['backtoemp','appraisalNo'=> '','employeeNo' => ''],[
                
                'class' => 'mx-1 btn btn-app bg-primary ',
                'rel' => '',
                'rev' =>'',
                'title' => 'Reject KRAs and Send them Back to Appraisee.',
              ]
            ) ?> -->
            

            <?= Html::a('<i class="fas fa-check"></i> Short List Candidate',['shortlist','ProfileID'=> urlencode($model->ApplicationID), 'ComitteID'=>urlencode($model->CommiteeID)],
                    ['
                    class' => 'mx-1 btn btn-app bg-success ',
                    'title' => 'Shortlist Candidate.',
                    'data' => [
                        'confirm' => 'Are you sure you want to Shortlist this Candidate?',
                        'method' => 'post',
                    ]

            ]) ?>

             <?= Html::a('<i class="fas fa-times"></i> Reject',['reject-candidate', 'ProfileID'=> urlencode( $model->ApplicationID),'ComitteID'=>urlencode($model->CommiteeID)],[
                                'class' => 'btn btn-app bg-warning rejectey',
                                'title' => 'Reject Goals Set by Appraisee',
                                'rel' => $model->ApplicationID,
                                'rev' => $model->CommiteeID,
                                /*'data' => [
                                'confirm' => 'Are you sure you want to Reject this Mid Year Appraisal?',
                                'method' => 'post',]*/
            ]) ?>



        


                            <!--My Bs Modal template  --->

<div class="modal fade bs-example-modal-lg bs-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel" style="position: absolute">Candidate Rejection Reasons</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
            </div>

        </div>
    </div>
</div>

<!-----end modal----------->


    <div id="eyrejform" style="display: none">

        <?= Html::beginForm(['recruitment/reject-candidate'],'post',['id'=>'ey-reject-form']) ?>

        <?= Html::textarea('comment','',['placeholder'=>'Why are You Rejecting this Candidate?','row'=> 4,'class'=>'form-control','required'=>true])?>

        <?= Html::input('hidden','ProfileID','',['class'=> 'form-control','style'=>'margin-top: 10px']); ?>
        <?= Html::input('hidden','ComitteID','',['class'=> 'form-control','style'=>'margin-top: 10px']); ?>


        <?= Html::submitButton('Reject Candidate',['class' => 'btn btn-warning','style'=>'margin-top: 10px']) ?>

        <?= Html::endForm() ?>
    </div>


    <?php

$script = <<<JS

   
        
JS;






