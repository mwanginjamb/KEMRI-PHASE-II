<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 12:13 PM
 */
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html as Bootstrap4Html;

$absoluteUrl = \yii\helpers\Url::home(true);
 //Yii::$app->recruitment->printrr(Yii::$app->user->identity->{'Employee No_'});
$activeStatus = $HroActiveStatus = $HrmActiveStatus = $HOHActiveStatus =  [];

 if($model->Status !== 'New'){ 
     $activeStatus = ['readonly' =>  true, 'disabled' => true];
 }

 if($model->Status !== 'HRO'){
    $HroActiveStatus = ['readonly' =>  true, 'disabled' => true];
 }

 if($model->Status !== 'HRM'){
    $HrmActiveStatus = ['readonly' =>  true, 'disabled' => true];
 }

 if($model->Status !== 'HOH'){
    $HOHActiveStatus = ['readonly' =>  true, 'disabled' => true];
 }
 //Yii::$app->recruitment->printrr($attachment);
?>


                    <?php if(Yii::$app->session->hasFlash('success')): ?>
                        <div class="alert alert-success"><?= Yii::$app->session->getFlash('success')?></div>
                    <?php endif; ?>

                    <?php if(Yii::$app->session->hasFlash('error')): ?>
                        <div class="alert alert-danger"><?= Yii::$app->session->getFlash('error')?></div>
                    <?php endif; ?>
                

<div class="card">
    <div class="actions card-body">
                         <?= ($model->Status == 'New' && $model->Employee_No == Yii::$app->user->identity->{'Employee No_'}  )?Html::a('<i class="fas fa-forward"></i>To HRO',['send-to-hro'],['class' => 'btn btn-app bg-success btn-success',
                                'data' => [
                                    'confirm' => 'Are you sure you want to send this Document to HRO?',
                                    'params'=>[
                                        'No'=> $model->No
                                    ],
                                    'method' => 'post',
                            ],
                                'title' => 'Send Document to HRO for Acceptance'
    
                            ]):'' ?>
    
    
                           

                           
    
    
                            
    </div>

</div>

               

<div class="row">
    
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
                <div class="card-tools">
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
                                            <?= ($model->Status == 'New')?$form->field($model, 'Grievance_Against')->dropdownList($employees,['prompt'=> 'Select ...']):'' ?>
                                            <?= $form->field($model, 'Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                            <?= ($model->Status == 'New')?
                                                $form->field($model, 'Date_of_grievance')->textInput(['type'=> 'date']):
                                                    $form->field($model, 'Date_of_grievance')->textInput($activeStatus)
                                                    ?>


                                            <?= ($model->Status == 'HRO' && $model->HRO_Emp_No == Yii::$app->user->identity->{'Employee No_'})?
                                                $form->field($model, 'HRO_Findings')->textarea(['rows'=> 2]):
                                                    $form->field($model, 'HRO_Findings')->textInput($HroActiveStatus)
                                                    ?> 
                                            
                                            <?= $form->field($model, 'Employee_Comments')->textInput(['readonly'=> true, 'disabled'=>true]) ?> 
                                            
                                            <?= $form->field($model, 'attachment')->fileInput(['accept' => 'application/*']) ?>
                                            
                                            <?php $form->field($model, 'HRO_Emp_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?> 
                                            <?= $form->field($model, 'HRM_Emp_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?> 

                                            
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <?= ($model->Status == 'New')?
                                            $form->field($model, 'Grievance_Type')->dropdownList($complaintTypes, ['prompt'=> 'Select ...']):
                                                $form->field($model, 'Grievance_Type')->textInput($activeStatus)
                                                ?>        
                                                    
                                            <?= $form->field($model, 'Status')->textInput(['readonly'=> true]) ?>
                                            <?= $form->field($model, 'Rejection_Comments')->textInput(['readonly'=> true, 'disabled'=>true]) ?> 
                                            
                                            <?= ($model->Status == 'HRO' && $model->HRO_Emp_No == Yii::$app->user->identity->{'Employee No_'})?
                                                $form->field($model, 'Severity_of_grievance')->dropdownList($severity, ['prompt'=> 'Select ...']):
                                                    $form->field($model, 'Severity_of_grievance')->textInput($HroActiveStatus)
                                                    ?> 

                                            <?= ($model->Status == 'HRO' && $model->HRO_Emp_No == Yii::$app->user->identity->{'Employee No_'})?
                                                $form->field($model, 'Complaint_Classification')->dropdownList($complaintTypes, ['prompt'=> 'Select ...']):
                                                    $form->field($model, 'Complaint_Classification')->textInput($HroActiveStatus)
                                                    ?> 

                                                <?= (($model->Status == 'HRM' && $model->HRM_Emp_No == Yii::$app->user->identity->{'Employee No_'}))?
                                                        
                                                        $model->Status .$form->field($model, 'HRM_Rejection_Comments')->textInput() :

                                                        $form->field($model, 'HRM_Rejection_Comments')->textInput($HrmActiveStatus)
                                                        
                                                        ?> 
                                        </div>
                                



                                    </div>
                                </div>

                            

                                <?php ActiveForm::end(); ?>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Witnesses</h3>
                <div class="card-tools">
                        <?= Bootstrap4Html::a('<i class="fa fa-plus-square"></i> Add Witness',['add-line'],[
                            'class' => 'add btn btn-outline-info',
                            'data-no' => $model->No,
                            'data-service' => 'GrievanceWitnesses'
                            ]) ?>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td class="text text-bold text-info">Employee No</td>
                                <td class="text text-bold text-info">Employee Name</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(property_exists($document->Grievance_Witnesses,'Grievance_Witnesses')): ?>
                                <?php foreach($document->Grievance_Witnesses->Grievance_Witnesses as $wit): ?>
                                    <tr>
                                        <td  data-key="<?= $wit->Key ?>"  data-name="Employee_No" data-service="GrievanceWitnesses" ondblclick="addDropDown(this,'employees')" data-validate="Employee_Name"><?= !empty($wit->Employee_No)?$wit->Employee_No:'' ?></td>
                                        <td  class="Employee_Name"><?= !empty($wit->Employee_Name)?$wit->Employee_Name:'' ?></td>
                                        <td><?= Bootstrap4Html::a('<i class="fa fa-trash"></i>',['delete-line'],[
                                                    'class' => 'del btn btn-outline-danger',
                                                    'data-key' => $wit->Key,
                                                    'data-service' => 'GrievanceWitnesses'
                                                    ])  ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

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


       





    </div>
</div>



<input type="hidden" name="url" value="<?= $absoluteUrl ?>">
<input type="hidden" name="absolute" value="<?= $absoluteUrl ?>">
<?php
$script = <<<JS

$('#grievance-witness, #grievance-grievance_against').select2();

$('#grievance-grievance_against').change((e) => {
        globalFieldUpdate('grievance',false,'Grievance_Against', e,['Name']);
});

$('#grievance-witness').change((e) => {
        globalFieldUpdate('grievance',false,'Witness', e,['Witness_Name']);
});

$('#grievance-date_of_grievance').change((e) => {
        globalFieldUpdate('grievance',false,'Date_of_grievance', e);
});

$('#grievance-grievance_type').change((e) => {
        globalFieldUpdate('grievance',false,'Grievance_Type', e);
});

$('#grievance-grievance_description').change((e) => {
        globalFieldUpdate('grievance',false,'Grievance_Description', e);
});

$('#grievance-rejection_comments').change((e) => {
        globalFieldUpdate('grievance',false,'Rejection_Comments', e);
});

$('#grievance-attachment').change(function(e){
          globalUpload('DisciplinaryAttachments','grievance','attachment');
          setTimeout(() => {
                    location.reload(true);
                },1000);
});

$('#grievance-witness_type').change(function(e){
    let selectedOption = e.target.value;
    // console.log(selectedOption);
    if(selectedOption === 'Self')
    {
        $('.field-grievance-witness, .field-grievance-witness_name').hide();
    } else if(selectedOption === 'Employee')
    {
        $('.field-grievance-witness, .field-grievance-witness_name').show();
    }
    globalFieldUpdate('grievance',false,'Witness_Type', e);
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
                },50);
            });
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
                    },300);
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
    
     
JS;

$this->registerJs($script);