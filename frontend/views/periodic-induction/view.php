<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 6:09 PM
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Induction - '.$model->No;
$this->params['breadcrumbs'][] = ['label' => 'Induction List', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Period Induction Card', 'url' => ['view','No'=> $model->No]];
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

    <?= ($model->Status == 'Inductor' && $model->Action_ID == Yii::$app->user->identity->{'Employee No_'})?Html::a('<i class="fas fa-check"></i> Approve.',['approve-induction'],['class' => 'btn btn-app bg-success mx-1',
                                'data' => [
                                'confirm' => 'Are you sure you want to approve this document?',
                                'params'=>[
                                    'No'=> $model->No,
                                ],
                                'method' => 'get',
                            ],
                                'title' => 'Approve Document.'
    
                            ]):'' ?>
</div>

    <div class="row">
        <div class="col-md-12">
            <div class="card-info">
                <div class="card-header">
                    <h3>Induction Card </h3>
                </div>



            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">




                    <h3 class="card-title">Induction No : <?= $model->No?></h3>



                </div>
                <div class="card-body">


                    <?php $form = ActiveForm::begin(); ?>


                    <div class="row">
                        <div class=" row col-md-12">
                            <div class="col-md-6">

                            <?= $form->field($model, 'No')->textInput(['readonly'=> true]) ?>
                            <?= $form->field($model, 'Key')->hiddenInput()->label(false) ?>
                            <?= $form->field($model, 'Employee_No')->textInput(['readonly'=> true]) ?>
                            <?= $form->field($model, 'Employee_Name')->textInput(['readonly' =>  true]) ?>
                            <?= $form->field($model, 'Global_Dimension_1_Code')->textInput(['readonly' =>  true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Global_Dimension_2_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Global_Dimension_3_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>


                                <p class="parent"><span>+</span>




                                </p>


                            </div>
                            <div class="col-md-6">
                            <?= $form->field($model, 'Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>        
                            <?= $form->field($model, 'CEO_Comments')->textarea(['rows' => 2,'readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'HOO_Comments')->textarea(['rows' => 2,'readonly'=> true, 'disabled'=>true]) ?>        
                            <?= $form->field($model, 'HOF_Comments')->textarea(['rows'=> 2,'readonly'=> true, 'disabled'=>true]) ?>        
                            <?= $form->field($model, 'Action_Section')->textInput(['readonly'=> true]) ?>
                            <?= $form->field($model, 'Action_ID')->textInput(['readonly'=> true, 'disabled'=>true]) ?> 
                               
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
                                    <h3>Employee Induction Lines</h3>
                </div>
                <div class="card-tools">
                        <?php Html::a('<i class="fa fa-plus-square"></i> New Induction Line',['add-line'],[
                            'class' => 'add btn btn-outline-info',
                            'data-no' => $model->No,
                            'data-service' => 'InductionOverallPE'
                            ]) ?>
                </div>
            </div>

            <div class="card-body">
                <?php if(property_exists($document->Employee_Induction_Overall_Pe,'Employee_Induction_Overall_Pe')){ //show Lines ?>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <td></td>
                                <!-- <td class="text-bold">Induction_No</td> -->
                                <td class="text-bold">Section</td>
                                <td class="text-bold">Expected Start Date</td>
                                <td class="text-bold">Expected End Date</td>
                                <td class="text-bold">Expected Start Time</td>
                                <td class="text-bold">Expected End Time</td>
                                <td class="text-bold">Attended</td>
                                
                                <td class="text-bold">Reason for Failure</td>
                               
                                <td class="text-bold">Employee comments</td>
                                <td class="text-bold">Inductor Comments</td>
                               
                                <!-- <td class="text-bold">Action</td> -->
                                
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                           

                            foreach($document->Employee_Induction_Overall_Pe->Employee_Induction_Overall_Pe as $obj):
                                
                                $deleteLink = Html::a('<i class="fa fa-trash"></i>',['delete-line' ],[
                                    'class'=>'del btn btn-outline-danger btn-xs',
                                    'data-key' => $obj->Key,
                                    'data-service' => 'InductionOverallPE'
                                ]);
                                ?>
                                <tr class="parent">
                                    <td><span>+</span></td>
                                    
                                    <td data-key="<?= $obj->Key ?>" ><?= !empty($obj->Section)?$obj->Section:'' ?></td>
                                    <td data-key="<?= $obj->Key ?>" ><?= !empty($obj->Expected_Start_Date)?$obj->Expected_Start_Date:'' ?></td>
                                    <td data-key="<?= $obj->Key ?>" ><?= !empty($obj->Expected_End_Date)?$obj->Expected_End_Date:'' ?></td>
                                    <td data-key="<?= $obj->Key ?>" ><?= !empty($obj->Expected_Start_Time)?Yii::$app->formatter->asTime($obj->Expected_Start_Time):'' ?></td>
                                    <td data-key="<?= $obj->Key ?>" ><?= !empty($obj->Expected_End_Time)?Yii::$app->formatter->asTime($obj->Expected_End_Time):'' ?></td>
                                    <td data-key="<?= $obj->Key ?>" ><?= !empty($obj->Attended)?$obj->Attended:'' ?></td>
                                    <td data-key="<?= $obj->Key ?>" ><?= !empty($obj->Reason_for_Failure)?$obj->Reason_for_Failure:'' ?></td>
                                    <td data-key="<?= $obj->Key ?>" ><?= !empty($obj->Employee_comments)?$obj->Employee_comments:'' ?></td>
                                    <td data-key="<?= $obj->Key ?>" ><?= !empty($obj->Inductor_Comments)?$obj->Inductor_Comments:'' ?></td>
                                    
                                    
                                    <!-- <td><?= $deleteLink ?></td> -->
                                </tr>
                                <tr class="child">
                                    <td colspan="11" >
                                        <div class="table-responsive">
                                            <table class="table table-hover ">
                                                <thead>
                                                    <tr>
                                                        <td>#</td>
                                                        <td class="text-bold">Induction Item</td>   
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    
                                                    //print_r($model->getLines($obj->Line_No)); 
                                                    $counter = 0;                                               
                                                    if(is_array($model->getLines($obj->Line_No))): 
                                                        foreach($model->getLines($obj->Line_No) as $ln):
                                                            $counter++;
                                                        ?>

                                                        <tr>
                                                            <td><?= $counter ?></td>
                                                            <td><?= $ln->Induction_Item ?></td>
                                                        </tr>
                                                        
                                                    <?php endforeach;
                                                 endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
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
        $('.evalkra').on('click', function(e){
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

$this->registerCss($style);
