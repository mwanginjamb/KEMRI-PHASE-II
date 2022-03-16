<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 6:09 PM
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Job Requisition - '.$model->Requisition_No;
$this->params['breadcrumbs'][] = ['label' => 'Leave List', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Job Requisition Card', 'url' => ['view','No'=> $model->Requisition_No]];
/** Status Sessions */


/* Yii::$app->session->set('MY_Appraisal_Status',$model->MY_Appraisal_Status);
Yii::$app->session->set('EY_Appraisal_Status',$model->EY_Appraisal_Status);
Yii::$app->session->set('isSupervisor',false);*/
$Attachmentmodel = new \frontend\models\Leaveattachment()
?>

<div class="row">
    <div class="col-md-4">

        <?= ($model->Status == 'New')?Html::a('<i class="fas fa-paper-plane"></i> Send Approval Req',['send-for-approval', 'No'=>$model->Requisition_No],['class' => 'btn btn-app submitforapproval',
            'data' => [
                'confirm' => 'Are you sure you want to send this document for approval?',
                'params'=>[
                    'No'=> $_GET['No'],
                    'employeeNo' => Yii::$app->user->identity->{'Employee No_'},
                ],
                'method' => 'get',
        ],
            'title' => 'Submit For Approval'

        ]):'' ?>


        <?php ($model->Status == 'Pending_Approval')?Html::a('<i class="fas fa-times"></i> Cancel Approval Req.',['cancel-request'],['class' => 'btn btn-app submitforapproval',
            'data' => [
            'confirm' => 'Are you sure you want to cancel imprest approval request?',
            'params'=>[
                'No'=> $_GET['No'],
            ],
            'method' => 'get',
        ],
            'title' => 'Cancel Approval Request'

        ]):'' ?>
    </div>
</div>

    <div class="row">
        <div class="col-md-12">
            <div class="card-info">
                <div class="card-header">
                    <h3>Job Reqisition Card </h3>
                </div>



            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">




                    <!-- <h3 class="card-title">Job Requisition : <?= $model->Requisition_No?></h3> -->



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
                </div>
                <div class="card-body">


                    <?php $form = ActiveForm::begin(); ?>
                    <?= $form->field($model, 'Requisition_No')->hiddenInput()->label(false); ?>
                    <?= $form->field($model, 'Key')->hiddenInput()->label(false); ?>



                    <div class="row">
                        <div class=" row col-md-12">
                            <div class="col-md-4">

                                <?= $form->field($model, 'Job_Id')->dropDownList($ApprovedHRJobs,['prompt' => '-- Select Job --']) ?>

                                <!-- <?= $form->field($model, 'Start_Date')->textInput(['type' => 'date','required' => true]) ?> -->
                                <!-- <?= $form->field($model, 'Probation_Period')->textInput(['required' => true]) ?> -->
                                <?= $form->field($model, 'Criticality')->dropDownList([
                                    'High'=>'High',
                                    'Low'=>'Low',
                                ],['prompt' => '-- Select Criticality -- ','required'=> true]) ?>

                                <?= $form->field($model, 'Global_Dimension_1_Code')->dropDownList($Programs,['prompt' => '-- Select Program --']) ?>
                                <?= $form->field($model, 'Type')->dropDownList([
                                    'New'=>'New Position',
                                    'Re_Advert'=>'Re Advertisement',
                                    'Replacement'=>'Replacement'
                                ],['prompt' => '-- Select Type -- ','required'=> true]) ?>
                               
                               <?= $form->field($model, 'Replaced_Employee')->dropDownList($Employees,['prompt' => '-- Select Employee Being Replaced --']) ?>




                            </div>

                            <div class="col-md-4">
                            
                                <?= $form->field($model, 'Occupied_Position')->textInput(['readonly' =>  true]) ?>
                                <!-- <?= $form->field($model, 'Requisition_Period')->textInput(['required' => true]) ?> -->

                                <?= $form->field($model, 'Requisition_Type')->dropDownList([
                                    'Internal'=>'Internal',
                                    'External'=>'External',
                                    'Both'=>'Both',
                                ],['prompt' => '-- Select Requisition Type -- ','required'=> true]) ?>
                                <?= $form->field($model, 'Contract_Period')->textInput(['required' => true]) ?>
                                <?= $form->field($model, 'Global_Dimension_2_Code')->dropDownList($Departments,['prompt' => '-- Select Department --']) ?>
                               

                                
                            </div>

                            <div class="col-md-4">

                                <?= $form->field($model, 'No_Posts')->textInput() ?>

                                <!-- <?= $form->field($model, 'End_Date')->textInput(['readonly' => true]) ?> -->


                                <?= $form->field($model, 'Employment_Type')->dropDownList([
                                    // 'Permanent'=>'Permanent',
                                    'Contract'=>'Contract',
                                    'Consultant'=>'Consultant',
                                    'Intern'=>'Intern',
                                    // 'Board'=>'Board',
                                ],['prompt' => '-- Select Employment Type -- ','required'=> true]) ?>





                                <?= $form->field($model, 'Contract_Type')->dropDownList($ContractTypes,['prompt' => '-- Select Job --']) ?>
                                <?= $form->field($model, 'Location')->dropDownList($Locations,['prompt' => '-- Select Location --']) ?>                                
                                <!-- <?= $form->field($model, 'Reasons_For_Requisition')->textarea(['rows'=> 2,'maxlength' => 250]) ?> -->

                              


                      
                            </div>
                        </div>
                    </div>




                <div class="row">

                    <div class="form-group">
                        <?= Html::submitButton(($model->isNewRecord)?'Save':'Update', ['class' => 'btn btn-success',]) ?>
                    </div>


                </div>

                    <?php ActiveForm::end(); ?>


            <?php if($Attachmentmodel->getPath($model->Requisition_No)){   ?>

                <iframe src="data:application/pdf;base64,<?= $Attachmentmodel->readAttachment($model->Requisition_No); ?>" height="950px" width="100%"></iframe>


            <?php }  ?>

                </div>
            </div><!--end details card-->


            <!--Objectives card -->

            <!--Lines -->

            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <?= ($model->Status == 'New')?Html::a('<i class="fa fa-plus-square"></i> Add Grant',['requisitiongrants/create','No'=>$model->Requisition_No],['class' => 'add-line btn btn-outline-info',
                        ]):'' ?>
                    </div>
                </div>

                <div class="card-body">
                     <?php if(is_array($model->Grants())){ //echo '<pre>'; print_r($model->Grants() ); exit; //show Lines ?>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <td><b>Donor Code</b></td>
                                    <td><b>Donor Name</b></td>
                                    <td><b>Percentage</b></td>
                                    <td><b>Grant Start Date</b></td>
                                    <td><b>Grant End_Date</b></td>
                                    <td><b>Grant Activity</b></td>
                                    <td><b>Grant Type</b></td>

                                    <?php if($model->Status == 'New'): ?>
                                        <td><b>Actions</b></td> 
                                    <?php endif; ?>


                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                // print '<pre>'; print_r($model->lines); exit;

                                foreach($model->Grants() as $Grant):

                                    if(!empty($Grant->Donor_Code)) {
                                        $updateLink = Html::a('<i class="fa fa-edit"></i>', ['requisitiongrants/update', 'LineNo' => $Grant->LineNo], ['class' => 'update-objective btn btn-outline-info btn-xs']);
                                       $deleteLink = Html::a('<i class="fa fa-trash"></i>', ['requisitiongrants/delete', 'Key' => $Grant->Key], ['class' => 'delete btn btn-outline-danger btn-xs']);

                                        $donorDetails = Html::a('<i class="fa fa-plus"></i>', ['donorline/create',

                                                    // 'Contract_Code' => $obj->Contract_Code,
                                                    // 'Contract_Line_No' => $obj->Line_No,
                                                    // 'Employee_No' => $model->Employee_No,
                                                    // 'Change_No' => $model->No,
                                                    // 'Grant_Start_Date' => $obj->Contract_Start_Date,
                                                    // 'Grant_End_Date' => $obj->Contract_End_Date
                                        ],

                                        [
                                            'class' => 'update-objective btn btn-success btn-xs', 'title' => 'Add Donor Details',
                                            'title' => 'Add Donor Line.',
                                            
                                            
                                        ],
                                         
                                    );




                                        ?>
                                        <tr class="parent">

                                            <td><?= !empty($Grant->Donor_Code) ? $Grant->Donor_Code : 'Not Set' ?></td>
                                            <td><?= !empty($Grant->Donor_Name) ? $Grant->Donor_Name : 'Not Set' ?></td>
                                            <td><?= !empty($Grant->Percentage) ? $Grant->Percentage : 'Not Set' ?></td>
                                            <td><?= !empty($Grant->Grant_Start_Date) ? $Grant->Grant_Start_Date : 'Not Set' ?></td>
                                            <td><?= !empty($Grant->Grant_End_Date) ? $Grant->Grant_End_Date : 'Not Set' ?></td>
                                            <td><?= !empty($Grant->Grant_Activity) ? $Grant->Grant_Activity : 'Not Set' ?></td>
                                            <td><?= !empty($Grant->Grant_Type) ? $Grant->Grant_Type : 'Not Set' ?></td>
                                            <?php if($model->Status == 'New'): ?>
                                                <td><?= $updateLink. '| '. $deleteLink ?></td>
                                            <?php endif; ?>

                                        </tr>
                                   
                                        <?php
                                    }
                                endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                    <?php } ?>
                </div>
            </div>

            <!--End Lines -->



    </div>

    <!--My Bs Modal template  --->

    <div class="modal fade bs-example-modal-lg bs-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel" style="position: absolute">Donor Details</h4>
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
        if($('#hrjobrequisitioncard-type').val() == 'Replacement'){
                $('.field-hrjobrequisitioncard-replaced_employee').show();
        }else{
                $('.field-hrjobrequisitioncard-replaced_employee').hide();
        }

        $('#hrjobrequisitioncard-type').change((e) => {
            if($('#hrjobrequisitioncard-type').val() == 'Replacement'){
                $('.field-hrjobrequisitioncard-replaced_employee').show();
                return false;
            }
            $('.field-hrjobrequisitioncard-replaced_employee').hide();
        }); 

     /*Deleting Records*/
     
     $('.delete, .delete-objective').on('click',function(e){
         e.preventDefault();
           var secondThought = confirm("Are you sure you want to delete this record ?");
           if(!secondThought){//if user says no, kill code execution
                return;
           }
           
         var url = $(this).attr('href');
         $.get(url).done(function(msg){
             $('.modal').modal('show')
                    .find('.modal-body')
                    .html(msg.note);
         },'json');
     });
      
    
    /*Evaluate KRA*/
        $('.add-line').on('click', function(e){
             e.preventDefault();
            var url = $(this).attr('href');
            console.log('clicking...');
            $('.modal').modal('show')
                            .find('.modal-body')
                            .load(url); 

        });
        
        
      //Add a training plan
    
     $('.add-objective, .update-objective').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        console.log('clicking...');
        $('.modal').modal('show')
                        .find('.modal-body')
                        .load(url); 

     });
     
     
     //Update a training plan
    
     $('.update-trainingplan').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        console.log('clicking...');
        $('.modal').modal('show')
                        .find('.modal-body')
                        .load(url); 

     });
     
     
     //Update/ Evalute Employeeappraisal behaviour -- evalbehaviour
     
      $('.evalbehaviour').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        console.log('clicking...');
        $('.modal').modal('show')
                        .find('.modal-body')
                        .load(url); 

     });
      
      /*Add learning assessment competence-----> add-learning-assessment */
      
      
      $('.add-learning-assessment').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        console.log('clicking...');
        $('.modal').modal('show')
                        .find('.modal-body')
                        .load(url); 

     });
      
      
     
      
      
      
    
    /*Handle modal dismissal event  */
    $('.modal').on('hidden.bs.modal',function(){
        var reld = location.reload(true);
        setTimeout(reld,1000);
    }); 
        

    
        //Add Career Development Plan
        
        $('.add-cdp').on('click',function(e){
            e.preventDefault();
            var url = $(this).attr('href');
           
            
            console.log('clicking...');
            $('.modal').modal('show')
                            .find('.modal-body')
                            .load(url); 
            
         });//End Adding career development plan
         
         /*Add Career development Strength*/
         
         
        $('.add-cds').on('click',function(e){
            e.preventDefault();
            var url = $(this).attr('href');
            
            $('.modal').modal('show')
                            .find('.modal-body')
                            .load(url); 
            
         });
         
         /*End Add Career development Strength*/
         
         
         /* Add further development Areas */
         
            $('.add-fda').on('click',function(e){
            e.preventDefault();
            var url = $(this).attr('href');
                       
            console.log('clicking...');
            $('.modal').modal('show')
                            .find('.modal-body')
                            .load(url); 
            
         });
         
         /* End Add further development Areas */
         
         /*Add Weakness Development Plan*/
             $('.add-wdp').on('click',function(e){
            e.preventDefault();
            var url = $(this).attr('href');
                       
            console.log('clicking...');
            $('.modal').modal('show')
                            .find('.modal-body')
                            .load(url); 
            
         });
         /*End Add Weakness Development Plan*/

         //Change Action taken

         $('select#probation-action_taken').on('change',(e) => {

            const key = $('input[id=Key]').val();
            const Employee_No = $('input[id=Employee_No]').val();
            const Appraisal_No = $('input[id=Appraisal_No]').val();
            const Action_Taken = $('#probation-action_taken option:selected').val();
           
              

            /* var data = {
                "Action_Taken": Action_Taken,
                "Appraisal_No": Appraisal_No,
                "Employee_No": Employee_No,
                "Key": key

             } 
            */
            $.get('./takeaction', {"Key":key,"Appraisal_No":Appraisal_No, "Action_Taken": Action_Taken,"Employee_No": Employee_No}).done(function(msg){
                 $('.modal').modal('show')
                    .find('.modal-body')
                    .html(msg.note);
                });


            });



            $('#hrjobrequisitioncard-job_id').change(function(e){
                const SelectedJob = e.target.value;
                const No = $('#hrjobrequisitioncard-requisition_no').val();
                if(No.length){
                    
                    const url = 'setjob';
                    $.post(url,{'SelectedJob': SelectedJob,'No': No}).done(function(msg){
                        //populate empty form fields with new data
                            console.log(typeof msg);
                            console.table(msg);
                            if((typeof msg) === 'string') { // A string is an error
                                const parent = document.querySelector('.field-hrjobrequisitioncard-job_id');
                                const helpbBlock = parent.children[2];
                                helpbBlock.innerText = msg;
                                disableSubmit();
                                
                            }else{ // An object represents correct details
                                $('#hrjobrequisitioncard-key').val(msg.Key);
                                $('#hrjobrequisitioncard-occupied_position').val(msg.Occupied_Position);
                                const parent = document.querySelector('.field-hrjobrequisitioncard-job_id');
                                const helpbBlock = parent.children[2];
                                helpbBlock.innerText = ''; 
                                enableSubmit();
                                
                            }
                            
                        },'json');
                    
                }     
            });

            
            $('#hrjobrequisitioncard-requisition_period').change(function(e){
                const ContractPeriod = e.target.value;
                const No = $('#hrjobrequisitioncard-requisition_no').val();
                if(No.length){
                    
                    const url = 'set-contract-period';
                    $.post(url,{'ContractPeriod': ContractPeriod,'No': No}).done(function(msg){
                        //populate empty form fields with new data
                            console.log(typeof msg);
                            console.table(msg);
                            if((typeof msg) === 'string') { // A string is an error
                                const parent = document.querySelector('.field-hrjobrequisitioncard-requisition_period');
                                const helpbBlock = parent.children[2];
                                helpbBlock.innerText = msg;
                                disableSubmit();
                                
                            }else{ // An object represents correct details
                                $('#hrjobrequisitioncard-key').val(msg.Key);
                                $('#hrjobrequisitioncard-end_date').val(msg.End_Date);
                                const parent = document.querySelector('.field-hrjobrequisitioncard-requisition_period');
                                const helpbBlock = parent.children[2];
                                helpbBlock.innerText = ''; 
                                enableSubmit();
                                
                            }
                            
                        },'json');
                    
                }     
            });
    
        
    });//end jquery

    

        
JS;

$this->registerJs($script);

$style = <<<CSS
    p span {
        margin-right: 50%;
        font-weight: bold;
    }

    table td:nth-child(11), td:nth-child(12) {
                text-align: center;
    }
    
    /* Table Media Queries */
    
     /* @media (max-width: 500px) {
          table td:nth-child(2),td:nth-child(3),td:nth-child(6),td:nth-child(7),td:nth-child(8),td:nth-child(9),td:nth-child(10), td:nth-child(11) {
                display: none;
        }
    }
    
     @media (max-width: 550px) {
          table td:nth-child(2),td:nth-child(6),td:nth-child(7),td:nth-child(8),td:nth-child(9),td:nth-child(10), td:nth-child(11) {
                display: none;
        }
    }
    
    @media (max-width: 650px) {
          table td:nth-child(2),td:nth-child(6),td:nth-child(7),td:nth-child(8),td:nth-child(9),td:nth-child(10), td:nth-child(11) {
                display: none;
        }
    }


    @media (max-width: 1500px) {
          table td:nth-child(2),td:nth-child(7),td:nth-child(8),td:nth-child(9),td:nth-child(10), td:nth-child(11) {
                display: none;
        }
    } */
CSS;

$this->registerCss($style);
