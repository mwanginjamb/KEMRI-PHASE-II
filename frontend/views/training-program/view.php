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

$this->title = 'Training - '.$model->Group_No;
$this->params['breadcrumbs'][] = ['label' => 'Program Training Applications List', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Training Card', 'url' => ['view','Key'=> $model->Key]];
/** Status Sessions */
$absoluteUrl = \yii\helpers\Url::home(true);



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

        <?= ($model->Status == 'New')?Bootstrap4Html::a('<i class="fas fa-check"></i> Apply',['apply'],['class' => 'btn btn-app ',
            'data' => [
                'confirm' => 'Are you sure you want to apply for this training?',
                'params'=>[
                    'groupNoCode' => $model->Group_No ,
                    'empNo' => $model->Requester
                ],
                'method' => 'post',
        ],
            'title' => 'Apply Training?'

        ]):'' ?>


    </div>
</div>

   

    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Program Training Card </h3>
                </div>
            </div>
        </div>
        
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">




                    <h3 class="card-title">Training No : <?= $model->Group_No?></h3>



                </div>
                <div class="card-body">


                    <?php $form = ActiveForm::begin(); ?>


                    <div class="row">
                        <div class=" row col-md-12">
                            <div class="col-md-6">

                            <?= $form->field($model, 'Requester_Name')->textInput(['readonly'=> true]) ?>
                            <?= $form->field($model, 'Key')->hiddenInput()->label(false) ?>
                            <?= $form->field($model, 'Target_Group')->textInput(['readonly'=> true]) ?>
                            <?= $form->field($model, 'Total_No_of_Traininees')->textInput(['readonly' =>  true]) ?>
                            <?= $form->field($model, 'Trainer')->textInput(['readonly' =>  true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Nature_of_training')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Training_Type')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                                        
                            
                            <p class="parent"><span>+</span>                         
                            
                            
                            </p>
                        
                        
                    </div>
                    <div class="col-md-6">
                               
                        <?= $form->field($model, 'Training_Category')->textInput(['readonly'=> true, 'disabled'=>true]) ?>        
                            
                        <?= $form->field($model, 'Training_Need_Description')->textInput(['readonly'=> true, 'disabled'=>true]) ?>        
                        <?= $form->field($model, 'Expected_Start_Date')->textInput(['readonly'=> true]) ?>
                        <?= $form->field($model, 'Expected_End_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?> 
                        <?= $form->field($model, 'Institution')->textInput(['readonly'=> true, 'disabled'=>true]) ?> 
                        <?= $form->field($model, 'Venue')->textInput(['readonly'=> true, 'disabled'=>true]) ?> 
                        
                        <p class="parent"><span>+</span>

                        </p>



                            </div>
                        </div>
                    </div>


                    <?php ActiveForm::end(); ?>



                </div>
            </div><!--end header card-->

           
            <!-- Card Lines -->

            <div class="card">
            <div class="card-header">
                <div class="card-title">
                                    <h3>Program Training Lines</h3>
                </div>
               
            </div>

            <div class="card-body">
                <?php if(property_exists($document->Program_Training_Line,'Program_Training_Line')){ //show Lines ?>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>                               
                               
                                <td class="text-bold">Group No</td>
                                <td class="text-bold">Employee Name</td>
                                <td class="text-bold">Trainer</td>
                                <td class="text-bold">Nature of training</td>
                                <td class="text-bold">Training Type</td>
                                <td class="text-bold">Training Category</td>
                                <td class="text-bold">Training Need</td>
                                <td class="text-bold">Training Need Description</td>
                                <td class="text-bold">Institution</td>
                                <td class="text-bold">Venue</td>
                                <td class="text-bold">Approved Amount</td>
                                <td class="text-bold">Expected Start Date</td>
                                <td class="text-bold">Expected End Date</td>
                                <td class="text-bold">Status</td>                                                                                         
                                 
                            </tr>
                            </thead>
                            <tbody>
                            <?php                          

                            foreach($document->Program_Training_Line->Program_Training_Line as $obj):
                                  
                                ?>
                                <tr class="parent">
                            
                                    <td><?= !empty($obj->Group_No)?$obj->Group_No:'' ?></td>
                                    <td><?= !empty($obj->Employee_Name)?$obj->Employee_Name:'' ?></td>
                                    <td><?= !empty($obj->Trainer)?$obj->Trainer:'' ?></td>
                                    <td><?= !empty($obj->Nature_of_training)?$obj->Nature_of_training:'' ?></td>
                                    <td><?= !empty($obj->Training_Type)?$obj->Training_Type:'' ?></td>
                                    <td><?= !empty($obj->Training_Category)?$obj->Training_Category:'' ?></td>
                                    <td><?= !empty($obj->Training_Need)?$obj->Training_Need:'' ?></td>
                                    <td><?= !empty($obj->Training_Need_Description)?$obj->Training_Need_Description:'' ?></td>
                                    <td><?= !empty($obj->Institution)?$obj->Institution:'' ?></td>
                                    <td><?= !empty($obj->Venue)?$obj->Venue:'' ?></td>
                                    <td><?= !empty($obj->Approved_Amount)? Yii::$app->formatter->asDecimal($obj->Approved_Amount):'' ?></td>
                                    <td><?= !empty($obj->Expected_Start_Date)?$obj->Expected_Start_Date:'' ?></td>
                                    <td><?= !empty($obj->Expected_End_Date)?$obj->Expected_End_Date:'' ?></td>
                                    <td><?= !empty($obj->Status)?$obj->Status:'' ?></td>
                                    
                                    
                                    
                    
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
                    <h4 class="modal-title" id="myModalLabel" style="position: absolute">Training Management</h4>
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

    <!-- Training Application Rejection comment form -->

    <div id="rejgoalsbyoverview" style="display: none">

        <?= Html::beginForm(['training-approved/rejection-linemanager'],'post',['id'=>'reject-form']) ?>

        <?= Html::textarea('comment','',['placeholder'=>'Rejection Comment','row'=> 4,'class'=>'form-control','required'=>true])?>

        <?= Html::input('hidden','applicationNo','',['class'=> 'form-control']); ?>
       


        <?= Html::submitButton('submit',['class' => 'btn btn-warning','style'=>'margin-top: 10px']) ?>

        <?= Html::endForm() ?>
    </div>

    <!-- End Rejection Comment -->
    <input type="hidden" name="absolute" value="<?= $absoluteUrl ?>">
<?php

$script = <<<JS

    $(function(){

        $('#employeetraining-attachment_one').change(function(e){
          globalUpload('DisciplinaryAttachments','EmployeeTraining','attachment_one','TrainingApplicationCard');
          setTimeout(() => {
                    //location.reload(true);
                },1500);
        });


        $('#employeetraining-attachment_two').change(function(e){
                globalUpload('DisciplinaryAttachments','EmployeeTraining','attachment_two','TrainingApplicationCard');
                setTimeout(() => {
                            //location.reload(true);
                        },1500);
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
    
       
         
    // Reject Action

    $('.rejectgoalsettingbyoverview').on('click', function(e){
        e.preventDefault();
        const form = $('#rejgoalsbyoverview').html(); 
        const applicationNo = $(this).data().no;
        const action = $(this).data().action;
        
        console.log('Application No: '+applicationNo);
        console.table($(this).data());
        
        //Display the rejection comment form
        $('.modal').modal('show')
                        .find('.modal-body')
                        .append(form);
        
        //populate relevant input field with code unit required params
                
        $('input[name=applicationNo]').val(applicationNo);
       
        
        //Submit Rejection form and get results in json    
        $('form#reject-form').on('submit', function(e){
            e.preventDefault()
            const data = $(this).serialize();
            const url = action;

           
            $('form#reject-form').html('<p class="alert alert-info">Processing ....</p>');
            $.post(url,data).done(function(msg){
                    $('.modal').modal('show')
                    .find('.modal-body')
                    .html(msg.note);
        
                },'json');
        });
        
        
    });
    
    // End Reject Action
         
         
    // Commit Approval Comments fields
         
    $('#employeetraining-recomended_action').change((e) => {
        globalFieldUpdate('employeetraining','training-approved','Recomended_Action', e);
    });

    $('#employeetraining-line_manager_comments').change((e) => {
        globalFieldUpdate('employeetraining','training-approved','Line_Manager_Comments', e);
    });

    $('#employeetraining-line_manager_rejection_comment').change((e) => {
        globalFieldUpdate('employeetraining','training-approved','Line_Manager_Comments', e);
    });

    $('#employeetraining-hro_comments').change((e) => {
        globalFieldUpdate('employeetraining','training-approved','HRO_Comments', e);
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
    
     @media (max-width: 500px) {
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
    }
CSS;

//$this->registerCss($style);
