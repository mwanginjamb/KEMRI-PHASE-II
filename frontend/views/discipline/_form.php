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
//Yii::$app->recruitment->printrr(Yii::$app->user->identity->{'Employee No_'});

?>


<?php if (Yii::$app->session->hasFlash('success')) : ?>
    <div class="alert alert-success"><?= Yii::$app->session->getFlash('success') ?></div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('error')) : ?>
    <div class="alert alert-danger"><?= Yii::$app->session->getFlash('error') ?></div>
<?php endif; ?>


<div class="card">
    <div class="actions card-body">
        <?= ($model->Status == 'New') ? Html::a('<i class="fas fa-times"></i> Close Case', ['close-case'], [
            'class' => 'btn btn-app bg-success mx-1',
            'data' => [
                'confirm' => 'Are you sure you want to close this case?',
                'params' => [
                    'No' => $model->No,
                ],
                'method' => 'get',
            ],
            'title' => 'Close Disciplinary Case.'

        ]) : '' ?>



    </div>

</div>



<div class="row">

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= Html::encode($this->title) ?></h3>

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
                            <?= $form->field($model, 'Global_Dimension_1_Code')->textInput(['readonly' =>  true, 'disabled' => true]) ?>
                            <?= $form->field($model, 'Global_Dimension_2_Code')->textInput(['readonly' => true, 'disabled' => true]) ?>
                            <?= $form->field($model, 'Offender')->textInput(['readonly' => true, 'disabled' => true]) ?>
                            <?= $form->field($model, 'Name_of_Offender')->textInput(['readonly' => true, 'disabled' => true]) ?>
                            <?= $form->field($model, 'Type_of_Offense')->textInput(['readonly' => true, 'disabled' => true]) ?>


                        </div>

                        <div class="col-md-6">
                            <?= $form->field($model, 'attachment_multiple[]')->fileInput(['accept' => 'application/pdf', 'id' => 'select_multiple', 'multiple' => true]) ?>

                            <div id="upload-note"></div>
                            <div class="progress" id="progress_bar" style="display:none">
                                <div class="progress-bar" id="progress_bar_process" role="progressbar" style="width:0%"></div>
                            </div>
                            <?= $form->field($model, 'Offense_Description')->textInput(['readonly' => true, 'disabled' => true]) ?>
                            <?= $form->field($model, 'Witness')->textInput(['readonly' => true]) ?>
                            <?= $form->field($model, 'Witness_Name')->textInput(['readonly' =>  true]) ?>
                            <?= $form->field($model, 'Policy_Violated')->textarea(['rows' => 2]) ?>
                            <?= $form->field($model, 'Disciplinary_Findings')->textarea(['rows' => 2]) ?>
                            <?= $form->field($model, 'Verdict')->textarea(['rows' => 2]) ?>
                            <?= $form->field($model, 'Surcharge_Employee')->checkbox([$model->Surcharge_Employee]) ?>
                            <?= $form->field($model, 'Amount')->textInput(['type' => 'number']) ?>
                            <?= $form->field($model, 'Status')->textInput(['readonly' => true, 'disabled' => true]) ?>


                        </div>




                    </div>
                </div>



                <?php ActiveForm::end(); ?>
            </div>
        </div>

    </div>
</div>



<input type="hidden" name="url" value="<?= $absoluteUrl ?>">
<input type="hidden" name="absolute" value="<?= $absoluteUrl ?>">
<?php
$script = <<<JS


$('#discipline-verdict').change((e) => {
        globalFieldUpdate('discipline',false,'Verdict', e);
});

$('#discipline-surcharge_employee').change((e) => {
        globalFieldUpdate('discipline',false,'Surcharge_Employee', e);
});

$('#discipline-amount').change((e) => {
        globalFieldUpdate('discipline',false,'Amount', e);
});

$('#discipline-policy_violated').change((e) => {
        globalFieldUpdate('discipline',false,'Policy_Violated', e);
});


$('#discipline-disciplinary_findings').change((e) => {
        globalFieldUpdate('discipline',false,'Disciplinary_Findings', e);
});

$('#select_multiple').change(function(e){
          globalUploadMultiple('DisciplinaryAttachments','discipline','discipline','DisciplinaryCard');
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
    
     
JS;

$this->registerJs($script);
