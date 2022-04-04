<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 6:09 PM
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Grievance - '.$model->No;
$this->params['breadcrumbs'][] = ['label' => 'Grievance List', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Grievance Card', 'url' => ['view','Key'=> $model->Key]];
/** Status Sessions */

?>


<?php
                    if(Yii::$app->session->hasFlash('success')){
                        print ' <div class="alert alert-success alert-dismissable">
                                 ';
                        echo Yii::$app->session->getFlash('success');
                        print '</div>';
                    }else if(Yii::$app->session->hasFlash('error')){
                        print ' <div class="alert alert-danger alert-dismissable">
                                 ';
                        echo Yii::$app->session->getFlash('error');
                        print '</div>';
                    }
?>

<div class="row actions">
    <div class="col-md-4">

        <?= ($model->Status == 'Inductee')?Html::a('<i class="fas fa-paper-plane"></i> Send Approval Req',['send-for-approval'],['class' => 'btn btn-app submitforapproval',
            'data' => [
                'confirm' => 'Are you sure you want to send imprest request for approval?',
                'params'=>[
                    'No'=> $model->No
                ],
                'method' => 'get',
        ],
            'title' => 'Submit for Approval'

        ]):'' ?>


    </div>

    <?= ($model->Status == 'New' && $model->Employee_No == Yii::$app->user->identity->{'Employee No_'})?Html::a('<i class="fas fa-forward"></i> To HRO.',['send-to-hro'],[
                                'class' => 'btn btn-app bg-success mx-1',
                                'data' => [
                                'confirm' => 'Are you sure you want to send this document to HRO?',
                                'params'=>[
                                    'No'=> $model->No,
                                ],
                                'method' => 'post',
                            ],
                                'title' => 'Send Grievance To HRO for Acceptance.'
    
                            ]):''

        
    ?>

<?= ($model->Status == 'HRO' && $model->Employee_No == Yii::$app->user->identity->{'Employee No_'})?Html::a('<i class="fas fa-times"></i> Withdraw.',['withdraw'],[
                                'class' => 'btn btn-app bg-success mx-1',
                                'data' => [
                                'confirm' => 'Are you sure you want to withdraw this grievance ?',
                                'params'=>[
                                    'No'=> $model->No,
                                ],
                                'method' => 'post',
                            ],
                                'title' => 'Withdraw Grievance.'
    
                            ]):''

        
    ?>


    <?= ($model->Status == 'HRO')?Html::a('<i class="fas fa-check"></i> Accept ',['accept-grievance'],[
                                'class' => 'btn btn-app bg-success mx-1',
                                'data' => [
                                'confirm' => 'Are you sure you want to Accept this Grievance?',
                                'params'=>[
                                    'No'=> $model->No,
                                ],
                                'method' => 'post',
                            ],
                                'title' => 'Accept Grievance.'
    
                            ]):''   
    ?>

    <?= ($model->Status == 'HRO')?Html::a('<i class="fas fa-times"></i> Reject ',['reject-grievance'],[
                                'class' => 'btn btn-app bg-success mx-1',
                                'data' => [
                                'confirm' => 'Are you sure you want to Accept this Grievance?',
                                'params'=>[
                                    'No'=> $model->No,
                                ],
                                'method' => 'post',
                            ],
                                'title' => 'Reject Grievance.'
    
                            ]):''   
    ?>


    


<?= ($model->Status == 'Accepted')?Html::a('<i class="fas fa-forward"></i> To Disciplinary ',['convert-to-disciplinary'],[
                                'class' => 'btn btn-app bg-success mx-1',
                                'data' => [
                                'confirm' => 'Are you sure you want to Convert this grievance to a disciplinary case?',
                                'params'=>[
                                    'No'=> $model->No,
                                ],
                                'method' => 'post',
                            ],
                                'title' => 'Covert to Disciplinary Case.'
    
                            ]):''   
    ?>




<?= ($model->Status == 'HRO')?Html::a('<i class="fas fa-times"></i> Close ',['close-grievance'],[
                                'class' => 'btn btn-app bg-success mx-1',
                                'data' => [
                                'confirm' => 'Are you sure you want to close grievance?',
                                'params'=>[
                                    'No'=> $model->No,
                                ],
                                'method' => 'post',
                            ],
                                'title' => 'Close Grievance.'
    
                            ]):''   
    ?>



</div>

    <div class="row">
        <div class="col-md-12">
            <div class="card-info">
                <div class="card-header">
                    <h3>Grievance Card </h3>
                </div>



            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">




                    <h3 class="card-title"> No : <?= $model->No?></h3>



                </div>
                <div class="card-body">


                    <?php $form = ActiveForm::begin(); ?>


                    <div class="row">
                        <div class=" row col-md-12">
                            <div class="col-md-6">

                            <?= $form->field($model, 'No')->textInput(['readonly'=> true]) ?>
                            <?= $form->field($model, 'Key')->hiddenInput()->label(false) ?>
    
                            <?= $form->field($model, 'Employee_Name')->textInput(['readonly' =>  true]) ?>
                            <?= $form->field($model, 'Grievance_Against')->textInput(['readonly' =>  true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Date_of_grievance')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Grievance_Type')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Grievance_Description')->textarea(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Rejection_Comments')->textarea(['readonly'=> true, 'disabled'=>true]) ?>
                            
                            
                            <p class="parent"><span>+</span>
                            
                            
                            
                            
                        </p>

                        
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'HRO_Findings')->textInput(['readonly'=> true, 'disabled'=>true]) ?>        
                        <?= $form->field($model, 'Complaint_Classification')->dropDownList([],['prompt' => 'Select ...']) ?>
                        
                        <?= $form->field($model, 'Employee_Comments')->textarea(['rows'=> 2]) ?>
                        <?= $form->field($model, 'Severity_of_grievance')->dropDownList([],['prompt' => 'Select ...']) ?>
                        <?= $form->field($model, 'HRM_Emp_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                        <?= $form->field($model, 'HRM_Comment')->textarea(['rows'=> 2]) ?>
                        <?= $form->field($model, 'HRM_Rejection_Comments')->textarea(['rows'=> 2]) ?>
                        <?= $form->field($model, 'HRM_Findings')->textInput(['readonly'=> true, 'disabled'=>true]) ?>        
                        <?= $form->field($model, 'HOH_Findings')->textInput(['readonly'=> true, 'disabled'=>true]) ?>        
                        
                            <p class="parent"><span>+</span>



                                </p>



                            </div>
                        </div>
                    </div>




                    <?php ActiveForm::end(); ?>



                </div>
            </div><!--end header card-->

            <!-- Attachment View -->
            <?php if(is_object($attachment) && $attachment->File_path): ?>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Attachment View</h3>
                        </div>
                        <div class="card-body">
                        <?php
                                echo \lesha724\documentviewer\ViewerJsDocumentViewer::widget([
                                'url' => $attachment->File_path, 
                                'width'=>'100%',
                                'height'=>'1100px',
                                ]);?>
                        </div>
                    </div>

            <?php endif; ?>

            <!-- End Attachment View -->


           
           
          



            








        </>
    </div>

    <!--My Bs Modal template  --->

    <div class="modal fade bs-example-modal-lg bs-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel" style="position: absolute">Imprest Management</h4>
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


<?php

$script = <<<JS

    $(function(){
      
        
    /*Parent-Children accordion*/ 
    
    $('tr.parent').find('span').text('+');
    $('tr.parent').find('span').css({"color":"red", "font-weight":"bolder"});    
    $('tr.parent').nextUntil('tr.parent').slideUp(1, function(){});    
    $('tr.parent').click(function(){
            $(this).find('span').text(function(_, value){return value=='-'?'+':'-'}); //to disregard an argument -event- on a function use an underscore in the parameter               
            $(this).nextUntil('tr.parent').slideToggle(100, function(){});
     });
    
    /*Divs parenting*/
    
     $('p.parent').find('span').text('+');
    $('p.parent').find('span').css({"color":"red", "font-weight":"bolder"});    
    $('p.parent').nextUntil('p.parent').slideUp(1, function(){});    
    $('p.parent').click(function(){
            $(this).find('span').text(function(_, value){return value=='-'?'+':'-'}); //to disregard an argument -event- on a function use an underscore in the parameter               
            $(this).nextUntil('p.parent').slideToggle(100, function(){});
     });
    
       
        
    });//end jquery

    

        
JS;

$this->registerJs($script);

$style = <<<CSS
   
CSS;

$this->registerCss($style);
