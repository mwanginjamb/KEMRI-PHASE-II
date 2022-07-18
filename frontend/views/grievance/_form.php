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
$activeStatus = $HroActiveStatus = $HRMActiveStatus = $HOHActiveStatus =  $HroAcceptedStatus = [];

if ($model->Status !== 'New' && $model->Status !== 'Awaiting_Consent') {
    $activeStatus = ['readonly' =>  true, 'disabled' => true];
}

if ($model->Status !== 'HRO') {
    $HroActiveStatus = ['readonly' =>  true, 'disabled' => true];
}

if ($model->Status !== 'Accepted') {
    $HroAcceptedStatus = ['readonly' =>  true, 'disabled' => true];
}

if ($model->Status !== 'HRM') {
    $HRMActiveStatus = ['readonly' =>  true, 'disabled' => true];
}

if ($model->Status !== 'HOH') {
    $HOHActiveStatus = ['readonly' =>  true, 'disabled' => true];
}
//Yii::$app->recruitment->printrr($attachment);
?>


<?php if (Yii::$app->session->hasFlash('success')) : ?>
    <div class="alert alert-success"><?= Yii::$app->session->getFlash('success') ?></div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('error')) : ?>
    <div class="alert alert-danger"><?= Yii::$app->session->getFlash('error') ?></div>
<?php endif; ?>


<div class="card">
    <div class="actions card-body">
        <?= $this->render('_buttons', ['model' => $model]); ?>

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

                            <?= $form->field($model, 'No')->textInput(['readonly' => true]) ?>
                            <?= $form->field($model, 'Key')->hiddenInput()->label(false) ?>
                            <?= $form->field($model, 'Employee_No')->textInput(['readonly' => true]) ?>
                            <?= $form->field($model, 'Employee_Name')->textInput(['readonly' =>  true]) ?>
                            <?= ($model->Status == 'New') ? $form->field($model, 'Grievance_Against')->dropdownList($employees, ['prompt' => 'Select ...']) : '' ?>
                            <?= $form->field($model, 'Name')->textInput(['readonly' => true, 'disabled' => true]) ?>
                            <?= $form->field($model, 'Date_of_grievance')->textInput(['readonly' => true, 'disabled' => true]) ?>

                            <?= ($model->Status == 'New' && $model->Employee_No == Yii::$app->user->identity->{'Employee No_'}) ?
                                $form->field($model, 'Grievance_Type')->dropdownList($complaintTypes, ['prompt' => 'Select ...']) :
                                $form->field($model, 'Grievance_Type')->textInput($activeStatus)
                            ?>

                            <?= ($model->Status == 'New' && $model->Employee_No == Yii::$app->user->identity->{'Employee No_'}) ?
                                $form->field($model, 'attachment')->fileInput() : ''

                            ?>

                            <?= $form->field($model, 'Grievance_Description')->textarea(array_merge(['rows' => 2], $activeStatus)) ?>
                            <?= $form->field($model, 'Status')->textInput(['readonly' => true, 'disabled' => true]) ?>
                            <?= $form->field($model, 'Rejection_Comments')->textarea($HroActiveStatus) ?>


                        </div>

                        <div class="col-md-6">

                            <?= $form->field($model, 'HRO_Findings')->textarea($HroAcceptedStatus) ?>

                            <?= $form->field($model, 'Status')->textInput(['readonly' => true]) ?>

                            <?= ($model->Status == 'HRO') ?
                                $form->field($model, 'Severity_of_grievance')->dropdownList($severity, ['prompt' => 'Select ...']) :
                                $form->field($model, 'Severity_of_grievance')->textInput($HroActiveStatus)
                            ?>

                            <?= $form->field($model, 'Employee_Comments')->textarea($activeStatus) ?>
                            <?= ($model->Status == 'HRO') ?
                                $form->field($model, 'Complaint_Classification')->dropdownList($complaintTypes, ['prompt' => 'Select ...']) :
                                $form->field($model, 'Complaint_Classification')->textInput($HroActiveStatus)
                            ?>




                            <?= $form->field($model, 'HRM_Emp_Name')->textInput(['readonly' => true, 'disabled' => true]) ?>
                            <?= $form->field($model, 'HRM_Comment')->textarea(array_merge(['rows' => 2], $HRMActiveStatus)) ?>
                            <?= $form->field($model, 'HRM_Rejection_Comments')->textarea(array_merge(['rows' => 2], $HRMActiveStatus)) ?>
                            <?= $form->field($model, 'HRM_Findings')->textInput($HRMActiveStatus) ?>
                            <?= $form->field($model, 'HOH_Findings')->textarea($HOHActiveStatus) ?>


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
                    <?= ($model->Status == 'New') ? Bootstrap4Html::a('<i class="fa fa-plus-square"></i> Add Witness', ['add-line'], [
                        'class' => 'add btn btn-outline-info',
                        'data-no' => $model->No,
                        'data-service' => 'GrievanceWitnesses'
                    ]) : '' ?>
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
                            <?php if (property_exists($document->Grievance_Witnesses, 'Grievance_Witnesses')) : ?>
                                <?php foreach ($document->Grievance_Witnesses->Grievance_Witnesses as $wit) : ?>
                                    <tr>
                                        <td data-key="<?= $wit->Key ?>" data-name="Employee_No" data-service="GrievanceWitnesses" ondblclick="addDropDown(this,'employees')" data-validate="Employee_Name"><?= !empty($wit->Employee_No) ? $wit->Employee_No : '' ?></td>
                                        <td class="Employee_Name"><?= !empty($wit->Employee_Name) ? $wit->Employee_Name : '' ?></td>
                                        <td><?= ($model->Status == 'New') ? Bootstrap4Html::a('<i class="fa fa-trash"></i>', ['delete-line'], [
                                                'class' => 'del btn btn-outline-danger',
                                                'data-key' => $wit->Key,
                                                'data-service' => 'GrievanceWitnesses'
                                            ]) : ''  ?>
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
        <?php if (is_object($attachment) && $attachment->File_path) : ?>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Attachment View</h3>
                </div>
                <div class="card-body">
                    <?php
                    echo \lesha724\documentviewer\ViewerJsDocumentViewer::widget([
                        'url' => $attachment->File_path,
                        'width' => '100%',
                        'height' => '1100px',
                    ]); ?>
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

$('#grievance-hro_findings').change((e) => {
        globalFieldUpdate('grievance',false,'HRO_Findings', e);
});

$('#grievance-severity_of_grievance').change((e) => {
        globalFieldUpdate('grievance',false,'Severity_of_grievance', e);
});

$('#grievance-employee_comments').change((e) => {
        globalFieldUpdate('grievance',false,'Employee_Comments', e);
});

$('#grievance-complaint_classification').change((e) => {
        globalFieldUpdate('grievance',false,'Complaint_Classification', e);
});

$('#grievance-severity_of_grievance').change((e) => {
        globalFieldUpdate('grievance',false,'Severity_of_grievance', e);
});


$('#grievance-hrm_comment').change((e) => {
        globalFieldUpdate('grievance',false,'HRM_Comment', e);
});


$('#grievance-hrm_rejection_comments').change((e) => {
        globalFieldUpdate('grievance',false,'HRM_Rejection_Comments', e);
});

$('#grievance-hrm_findings').change((e) => {
        globalFieldUpdate('grievance',false,'HRM_Findings', e);
});


$('#grievance-hrm_findings').change((e) => {
        globalFieldUpdate('grievance',false,'HRM_Findings', e);
});

$('#grievance-hoh_findings').change((e) => {
        globalFieldUpdate('grievance',false,'HOH_Findings', e);
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
