<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 12:13 PM
 */
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
$absoluteUrl = \yii\helpers\Url::home(true);
// Yii::$app->recruitment->printrr($employees);

?>

<div class="card">
    <div class="actions card-body">
            <?= ($model->Status == 'New')?Html::a('<i class="fas fa-forward"></i>Send For Approval',['send-for-approval','employeeNo' => Yii::$app->user->identity->employee[0]->No],['class' => 'btn btn-app bg-success btn-success submitforapproval',
                                'data' => [
                                    'confirm' => 'Are you sure you want to send this document for approval?',
                                    'params'=>[
                                        'No'=> $model->No,
                                        'employeeNo' =>Yii::$app->user->identity->employee[0]->No,
                                    ],
                                    'method' => 'get',
                            ],
                                'title' => 'Submit Imprest Approval'
    
                            ]):'' ?>
    
    
                            <?= ($model->Status == 'Pending_Approval')?Html::a('<i class="fas fa-times"></i> Cancel Approval Req.',['cancel-request'],['class' => 'btn btn-app submitforapproval',
                                'data' => [
                                'confirm' => 'Are you sure you want to cancel this approval request?',
                                'params'=>[
                                    'No'=> $model->No,
                                ],
                                'method' => 'get',
                            ],
                                'title' => 'Cancel Imprest Approval Request'
    
                            ]):'' ?>
    
    
                            
    </div>

</div>

<div class="row">
    
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= Html::encode($this->title) ?></h3>

                <div class="row float-right">
                    <!-- <div class="col-md-4"> -->

                        
                    <!-- </div> -->
                </div>

                <div class= "row">
                       <?php if(Yii::$app->session->hasFlash('success')): ?>
                    <div class="alert alert-success"><?= Yii::$app->session->getFlash('success')?></div>
                <?php endif; ?>

                <?php if(Yii::$app->session->hasFlash('error')): ?>
                    <div class="alert alert-danger"><?= Yii::$app->session->getFlash('error')?></div>
                <?php endif; ?>
                </div>

           </div>

            <div class="card-body">



        <?php

            $form = ActiveForm::begin(); ?>
                <div class="row">
                    <div class="row col-md-12">



                        <div class="col-md-6">

                            <?= $form->field($model, 'No')->textInput(['readonly'=> true]) ?>
                            <?= $form->field($model, 'Key')->hiddenInput()->label(false) ?>
                            <?= $form->field($model, 'Employee_No')->textInput(['readonly'=> true]) ?>
                            <?= $form->field($model, 'Employee_Name')->textInput(['readonly' =>  true]) ?>
                            <?= $form->field($model, 'Global_Dimension_1_Code')->textInput(['readonly' =>  true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Global_Dimension_2_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Global_Dimension_3_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            
                            
                        </div>
                        
                        <div class="col-md-6">
                            <?= $form->field($model, 'Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>        
                            <?= $form->field($model, 'CEO_Comments')->textarea(['rows' => 2]) ?>
                            <?= $form->field($model, 'HOO_Comments')->textarea(['rows' => 2]) ?>        
                            <?= $form->field($model, 'HOF_Comments')->textarea(['rows'=> 2]) ?>        
                            <?= $form->field($model, 'Action_Section')->textInput(['readonly'=> true]) ?>
                            <?= $form->field($model, 'Action_ID')->textInput(['readonly'=> true, 'disabled'=>true]) ?> 


                        </div>
                  



                    </div>
                </div>

               

                <?php ActiveForm::end(); ?>
            </div>
        </div>


        <div class="card">
            <div class="card-header">
                <div class="card-title">
                                    <h3>Employee Induction Lines</h3>
                </div>
                <div class="card-tools">
                        <?= Html::a('<i class="fa fa-plus-square"></i> New Induction Line',['add-line'],[
                            'class' => 'add btn btn-outline-info',
                            'data-no' => $model->No,
                            'data-service' => 'InductionLine'
                            ]) ?>
                </div>
            </div>

            <div class="card-body">
                <?php if(property_exists($document->Employee_Induction_Line,'Employee_Induction_Line')){ //show Lines ?>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <td class="text-bold">Induction_No</td>
                                <td class="text-bold">Induction_Item</td>
                                <td class="text-bold">Expected_Start_Date</td>
                                <td class="text-bold">Expected_End_Date</td>
                                <td class="text-bold">Expected_Start_Time</td>
                                <td class="text-bold">Expected_End_Time</td>
                                <td class="text-bold">Attended</td>
                                <td class="text-bold">Reason_for_Failure</td>
                                <td class="text-bold">Employee_comments</td>
                                <td class="text-bold">Inductor_Comments</td>
                                <td class="text-bold">Section</td>
                                
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                           

                            foreach($document->Employee_Induction_Line->Employee_Induction_Line as $obj):
                                
                                $deleteLink = Html::a('<i class="fa fa-trash"></i>',['delete-line' ],[
                                    'class'=>'del btn btn-outline-danger btn-xs',
                                    'data-key' => $obj->Key,
                                    'data-service' => 'InductionLine'
                                ]);
                                ?>
                                <tr>

                                    <td data-key="<?= $obj->Key ?>" data-name="Induction_No" data-service="InductionLine"><?= !empty($obj->Induction_No)?$obj->Induction_No:'Not Set' ?></td>
                                    <td data-key="<?= $obj->Key ?>" data-name="Induction_Item" data-service="InductionLine"><?= !empty($obj->Induction_Item)?$obj->Induction_Item:'Not Set' ?></td>
                                    <td data-key="<?= $obj->Key ?>" data-name="Expected_Start_Date" data-service="InductionLine" ondblclick="addInput(this,'date')"><?= !empty($obj->Expected_Start_Date)?$obj->Expected_Start_Date:'Not Set' ?></td>
                                    <td data-key="<?= $obj->Key ?>" data-name="Expected_End_Date" data-service="InductionLine" ondblclick="addInput(this,'date')"><?= !empty($obj->Expected_End_Date)?$obj->Expected_End_Date:'Not Set' ?></td>
                                    <td data-key="<?= $obj->Key ?>" data-name="Expected_Start_Time" data-service="InductionLine" ondblclick="addInput(this,'time')"><?= !empty($obj->Expected_Start_Time)?$obj->Expected_Start_Time:'Not Set' ?></td>
                                    <td data-key="<?= $obj->Key ?>" data-name="Expected_End_Time" data-service="InductionLine" ondblclick="addInput(this,'time')"><?= !empty($obj->Expected_End_Time)?$obj->Expected_End_Time:'Not Set' ?></td>
                                    <td data-key="<?= $obj->Key ?>" data-name="Attended" data-service="InductionLine" ondblclick="addDropDown(this,'attended')"><?= !empty($obj->Attended)?$obj->Attended:'Not Set' ?></td>

                                <?php if($obj->Attended == 'No'): ?>
                                    <td data-key="<?= $obj->Key ?>" data-name="Reason_for_Failure" data-service="InductionLine" ondblclick="addInput(this)"><?= !empty($obj->Reason_for_Failure)?$obj->Reason_for_Failure:'Not Set' ?></td>
                                <?php endif; ?>   
                                    <td data-key="<?= $obj->Key ?>" data-name="Employee_comments" data-service="InductionLine" ondblclick="addInput(this)"><?= !empty($obj->Employee_comments)?$obj->Employee_comments:'Not Set' ?></td>
                                    <td data-key="<?= $obj->Key ?>" data-name="Inductor_Comments" data-service="InductionLine" ondblclick="addInput(this)"><?= !empty($obj->Inductor_Comments)?$obj->Inductor_Comments:'Not Set' ?></td>
                                    <td data-key="<?= $obj->Key ?>" data-name="Section" data-service="InductionLine"><?= !empty($obj->Section)?$obj->Section:'Not Set' ?></td>
                                    
                                    <td><?= $deleteLink ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                   
                <?php } ?>
            </div>
        </div>






    </div>
</div>



<input type="hidden" name="url" value="<?= $absoluteUrl ?>">
<input type="hidden" name="absolute" value="<?= $absoluteUrl ?>">
<?php
$script = <<<JS
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
    //hide EmpNo
    $('.field-imprestcard-employee_no').hide();
      
      // Conditionally Display Employee No
     $('#imprestcard-request_for').on('change', () => {
         let selectedValue = $('#imprestcard-request_for :selected').text();
         // console.log(selectedValue);
         if(selectedValue == 'Other')
         {
            $('.field-imprestcard-employee_no').fadeIn();
         }else{
            $('.field-imprestcard-employee_no').fadeOut();
         }
     });
     $('#imprestcard-request_for').on('change',(e) => {
        globalFieldUpdate("Imprestcard",'imprest',"Request_For", e);
    });  
     $('#imprestcard-imprest_type').on('change',(e) => {
        globalFieldUpdate("Imprestcard",'imprest',"Imprest_Type", e);
    });                      
    $('#imprestcard-employee_no').on('change',(e) => {
        globalFieldUpdate("Imprestcard",'imprest',"Employee_No", e);
    });
     
     /*Set Program  */
    
     $('#imprestcard-global_dimension_1_code').change((e) => {
       globalFieldUpdate('Imprestcard','imprest','Global_Dimension_1_Code', e);
    });
     
     
     /* set department */
     
     $('#imprestcard-global_dimension_2_code').change((e) => {
       globalFieldUpdate('Imprestcard','imprest','Global_Dimension_2_Code', e);
    });
    /**Update Purpose */
    $('#imprestcard-purpose').change((e) => {
       globalFieldUpdate('Imprestcard','imprest','Purpose', e);
    });
    $('#imprestcard-exchange_rate').change((e) => {
       globalFieldUpdate('Imprestcard','imprest','Exchange_Rate', e);
    });
    $('#imprestcard-currency_code').change((e) => {
       globalFieldUpdate('Imprestcard','imprest','Currency_Code', e);
    });
    $('#imprestcard-imprest_amount').change((e) => {
       globalFieldUpdate('Imprestcard','imprest','Imprest_Amount', e);
    });
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
       /* Add Line */
     $('.add-line, .update-objective').on('click', function(e){
             e.preventDefault();
            var url = $(this).attr('href');
            console.log(url);
            $('.modal').modal('show')
                            .find('.modal-body')
                            .load(url); 
        });
     
     /*Handle modal dismissal event  */
    $('.modal').on('hidden.bs.modal',function(){
        var reld = location.reload(true);
        setTimeout(reld,1000);
    }); 
     
JS;

$this->registerJs($script);