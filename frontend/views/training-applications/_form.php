<?php

/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 6:09 PM
 */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html as Bootstrap4Html;

$this->title = 'Training - ' . $model->Application_No;
//$this->params['breadcrumbs'][] = ['label' => 'Training Applications List', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => 'Training Card', 'url' => ['view', 'Key' => $model->Key]];
/** Status Sessions */
// Yii::$app->recruitment->printrr($attachments);
?>


<?php
if (Yii::$app->session->hasFlash('success')) {
    print ' <div class="alert alert-success alert-dismissable">
                                 ';
    echo Yii::$app->session->getFlash('success');
    print '</div>';
} else if (Yii::$app->session->hasFlash('error')) {
    print ' <div class="alert alert-danger alert-dismissable">
                                 ';
    echo Yii::$app->session->getFlash('error');
    print '</div>';
}
?>

<div class="row actions">
    <div class="col-md-4">

        <?= ($model->Status == 'New') ? Html::a('<i class="fas fa-paper-plane"></i> Send Approval Req', ['send-for-approval'], [
            'class' => 'btn btn-app submitforapproval',
            'data' => [
                'confirm' => 'Are you sure you want to send this request for approval?',
                'params' => [
                    'No' => $model->Application_No
                ],
                'method' => 'post',
            ],
            'title' => 'Submit for Approval'

        ]) : '' ?>


    </div>

    <?= ($model->Status == 'Approved') ? Html::a('<i class="fas fa-forward"></i> To Ln Manager.', ['send-to-lnmgr'], [
        'class' => 'btn btn-app bg-success mx-1',
        'data' => [
            'confirm' => 'Are you sure want to send this document to line manager?',
            'params' => [
                'No' => $model->Application_No,
            ],
            'method' => 'get',
        ],
        'title' => 'Send to Line Manager.'

    ]) : '' ?>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card-info">
            <div class="card-header">
                <h3>Application Training Card </h3>
            </div>



        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">




                <h3 class="card-title">Training No : <?= $model->Application_No ?></h3>



            </div>
            <div class="card-body">


                <?php $form = ActiveForm::begin(); ?>


                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">

                            <?= $form->field($model, 'Application_No')->textInput(['readonly' => true]) ?>
                            <?= $form->field($model, 'Key')->hiddenInput()->label(false) ?>
                            <?= $form->field($model, 'Training_Need')->textInput(['readonly' => true]) ?>
                            <?= $form->field($model, 'Date_of_Application')->textInput(['readonly' =>  true]) ?>
                            <?= $form->field($model, 'Training_Need_Description')->textInput(['readonly' => true, 'disabled' => true]) ?>
                            <?= $form->field($model, 'Venue')->textInput(['readonly' => true, 'disabled' => true]) ?>


                            <p class="parent"><span>+</span>


                                <?= $form->field($model, 'Training_Calender')->textInput(['readonly' =>  true, 'disabled' => true]) ?>
                                <?= $form->field($model, 'Employee_Name')->textInput(['readonly' => true, 'disabled' => true]) ?>
                                <?= $form->field($model, 'Job_Group')->textInput(['readonly' => true, 'disabled' => true]) ?>
                                <?= $form->field($model, 'Job_Title')->textInput(['readonly' => true, 'disabled' => true]) ?>
                                <?= $form->field($model, 'Status')->textInput(['readonly' => true, 'disabled' => true]) ?>
                                <?= $form->field($model, 'Start_Date')->textInput(['readonly' => true, 'disabled' => true]) ?>
                                <?= $form->field($model, 'End_Date')->textInput(['readonly' => true, 'disabled' => true]) ?>
                                <?= $form->field($model, 'Period')->textInput(['readonly' => true, 'disabled' => true]) ?>

                            </p>


                        </div>
                        <div class="col-md-6">

                            <?= $form->field($model, 'Expected_Cost')->textInput(['readonly' => true, 'disabled' => true]) ?>
                            <?= $form->field($model, 'Trainer')->textInput(['readonly' => true, 'disabled' => true]) ?>
                            <?php $form->field($model, 'Exceeds_Expected_Trainees')->checkbox([$model->Exceeds_Expected_Trainees]) ?>
                            <?php $form->field($model, 'Training_Start_Date')->textInput(['readonly' => true, 'disabled' => true]) ?>
                            <?= $form->field($model, 'CPD_Approved_Cost')->textInput(['readonly' => true]) ?>
                            <?= $form->field($model, 'Total_Cost')->textInput(['readonly' => true, 'disabled' => true]) ?>
                            <?= $form->field($model, 'Reason_For_Training')->textInput(['readonly' => true, 'disabled' => true]) ?>



                            <p class="parent"><span>+</span>

                                <?php $form->field($model, 'HRO_No')->textInput(['readonly' => true, 'disabled' => true]) ?>
                                <?= $form->field($model, 'HRO_Name')->textInput(['readonly' => true, 'disabled' => true]) ?>
                                <?php $form->field($model, 'Line_Manager')->textInput(['readonly' => true, 'disabled' => true]) ?>
                                <?= $form->field($model, 'Manager_Name')->textInput(['readonly' => true, 'disabled' => true]) ?>
                                <?= $form->field($model, 'Approval_rejection_Comments')->textarea(['rows' => 1, 'readonly' => true, 'disabled' => true]) ?>
                                <?= $form->field($model, 'Nature_of_Training')->textInput(['readonly' => true, 'disabled' => true]) ?>
                                <?= $form->field($model, 'Training_Type')->textInput(['readonly' => true, 'disabled' => true]) ?>
                                <?= $form->field($model, 'Training_Category')->textInput(['readonly' => true, 'disabled' => true]) ?>


                            </p>



                        </div>
                    </div>
                </div>


                <?php if ($model->Status == 'New') : ?>
                    <div class="card">
                        <div class="card-header">
                            <p class="card-title">Cost Structure / Related Training Facilitation Attachment.</p>
                        </div>
                        <div class="card-body">
                            <?= $form->field($model, 'attachment')->fileInput(['data-name' => 'Cost Structure']) ?>
                        </div>
                    </div>
                <?php endif; ?>


                <?php ActiveForm::end(); ?>



            </div>
        </div>
        <!--end header card-->

        <!-- Attachments -->
        <?php if (is_array($attachments) && count($attachments)) :  //Yii::$app->recruitment->printrr($attachments); 
        ?>
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Files Attachments</h3>
                </div>
                <div class="card-body">
                    <?php $i = 0;
                    foreach ($attachments as $file) : ++$i; ?>


                        <div class="my-2 file border border-info d-flex justify-content-around align-items-center rounded p-3">
                            <p class="my-auto border rounded border-info bg-info p-2">Attachment <?= $file->Name ?></p>
                            <?= Bootstrap4Html::a('<i class="fas fa-file"></i> Open', ['read'], [
                                'class' => 'btn btn-info',
                                'data' => [
                                    'params' => [
                                        'path' => $file->File_path,
                                        'No' => $model->Application_No
                                    ],
                                    'method' => 'POST'
                                ]
                            ]) ?>


                            <?= Html::a(
                                '<i class="fa fa-trash"></i> ',
                                ['delete-line'],
                                [
                                    'class' => 'del delete btn btn-outline-danger',
                                    'title' => 'Delete this record.',
                                    'data-key' => $file->Key,
                                    'data-service' => 'DisciplinaryAttachments',

                                ]
                            )
                            ?>


                        </div>


                    <?php endforeach; ?>
                </div>

            </div>
        <?php endif; ?>
        <!-- / Attachments -->


        <!-- Card Lines -->

        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <h3>Training Cost Breakdown</h3>
                </div>

                <div class="card-tools">
                    <?= ($model->Employee_No == Yii::$app->user->identity->{'Employee No_'}) ? Html::a('<i class="fa fa-plus-square"></i> Add Cost Break-down Line', ['add-line'], [
                        'class' => 'add btn btn-outline-info',
                        'data-no' => $model->Application_No,
                        'data-service' => 'TrainingCostBreakDown'
                    ]) : '' ?>
                </div>
            </div>

            <div class="card-body">
                <?php if (property_exists($document->Training_Cost_Breakdown, 'Training_Cost_Breakdown')) { //show Lines 
                ?>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <!-- <td></td> -->

                                    <td class="text-bold">Application_No</td>
                                    <td class="text-bold text-info">Cost_Description</td>
                                    <td class="text-bold text-info">Amount</td>



                                </tr>
                            </thead>
                            <tbody>
                                <?php


                                foreach ($document->Training_Cost_Breakdown->Training_Cost_Breakdown as $obj) :

                                    $deleteLink = Html::a('<i class="fa fa-trash"></i>', ['delete-line'], [
                                        'class' => 'del btn btn-outline-danger btn-xs',
                                        'data-key' => $obj->Key,
                                        'data-service' => 'InductionOverallIN'
                                    ]);
                                ?>
                                    <tr class="parent">
                                        <!-- <td><span>+</span></td> -->

                                        <td data-key="<?= $obj->Key ?>"><?= !empty($obj->Application_No) ? $obj->Application_No : '' ?></td>
                                        <td data-key="<?= $obj->Key ?>" data-name="Cost_Description" data-service="TrainingCostBreakDown" ondblclick="addDropDown(this,'cost-description')"><?= !empty($obj->Cost_Description) ? $obj->Cost_Description : '' ?></td>
                                        <td data-key="<?= $obj->Key ?>" data-name="Amount" data-service="TrainingCostBreakDown" ondblclick="addInput(this,'number')"><?= !empty($obj->Amount) ? Yii::$app->formatter->asDecimal($obj->Amount) : '' ?></td>



                                        <!-- <td><?= $deleteLink ?></td> -->
                                    </tr>

                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                <?php } ?>
            </div>
        </div>

        <!-- End Lines Card -->













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

        $('#employeetraining-attachment').change(function(e){
          globalUpload('DisciplinaryAttachments','EmployeeTraining','attachment','TrainingApplicationCard');
        });

        $('#employeetraining-attachment_one').change(function(e){
          globalUpload('DisciplinaryAttachments','EmployeeTraining','attachment_one','TrainingApplicationCard');
        
        });


        $('#employeetraining-attachment_two').change(function(e){
                globalUpload('DisciplinaryAttachments','EmployeeTraining','attachment_two','TrainingApplicationCard');
               
        });

        
         // Trigger Creation of a line
            $('.add').on('click',function(e){
                    e.preventDefault();
                    let url = $(this).attr('href');
                
                    let data = $(this).data();
                    const payload = {
                        'Document_No': data.no,
                        'Service': data.service
                    };
                    //console.log(payload);
                    //return;
                    $('a.add').text('Inserting...');
                    $('a.add').attr('disabled', true);
                    $.get(url, payload).done((msg) => {
                        console.log(msg);
                        setTimeout(() => {
                            location.reload(true);
                        },1500);
                    });
                });
      
        
     /*Deleting Records*/
     
     $('.del').on('click',function(e){
            e.preventDefault();
            if(confirm('Are you sure about deleting this record?'))
            {
                let data = $(this).data();
                let url = $(this).attr('href');
                let Key = data.key;
                let Service = data.service;
                const payload = {
                    'Key': Key,
                    'Service': Service
                };
                $(this).text('Deleting...');
                $(this).attr('disabled', true);
                $.get(url, payload).done((msg) => {
                    console.log(msg);
                    setTimeout(() => {
                        location.reload(true);
                    },3000);
                });
            }
            
    });
      
    
    
    /*Handle modal dismissal event  */
    $('.modal').on('hidden.bs.modal',function(){
        var reld = location.reload(true);
        setTimeout(reld,1000);
    }); 
        
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
    p span {
        margin-right: 50%;
        font-weight: bold;
    }

    
    
    
CSS;

    $this->registerCss($style);
