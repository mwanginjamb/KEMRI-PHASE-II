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
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="card-body">

                    <?php
                    $form = ActiveForm::begin([
                        'id' => $model->formName()
                    ]); ?>
                <div class="row">

                            <div class="col-md-6">
                                    <?= $form->field($model, 'Key')->hiddenInput(['readonly' => true])->label(false) ?>
                                    <?= $form->field($model, 'Grant_Code')->dropDownList($donors, ['prompt' => 'Select Contract Code...']) ?>
                                    
                                    <?= $form->field($model, 'Contract_Grant_Start_Date')->textInput(['type' => 'date','min' => date('Y-m-d', strtotime($model->Grant_Start_Date)), 'max' => date('Y-m-d', strtotime($model->Grant_End_Date)) ]) ?>
                                    <?= $form->field($model, 'Contract_Grant_End_Date')->textInput(['type' => 'date','min' => date('Y-m-d', strtotime($model->Grant_Start_Date)),'max' => date('Y-m-d', strtotime($model->Grant_End_Date))  ]) ?>
                                    <?= $form->field($model, 'Percentage')->textInput(['type' => 'number']) ?>
                                    <?php $form->field($model, 'Grant_Status')->dropDownList([
                                        '_blank_' => '_blank_',
                                        'Active' => 'Active',
                                        'Expired' => 'Expired',
                                        'Inactive' => 'Inactive'
                                    ],['prompt' => 'Select ...','readonly' => true]) ?>
                                    <?= $form->field($model, 'Employee_No')->hiddenInput(['readonly' => true])->label(false) ?>
                                    <?= $form->field($model, 'Contract_Code')->hiddenInput(['readonly' => true])->label(false) ?>
                                    <?= $form->field($model, 'Change_No')->hiddenInput(['readonly' => true])->label(false) ?>
                                    <?= $form->field($model, 'Contract_Line_No')->hiddenInput(['readonly' => true])->label(false) ?>
                                    <?= $form->field($model, 'Line_No')->hiddenInput(['readonly' => true, 'disabled' => true])->label(false) ?>
                                   
                            </div>

                             <div class="col-md-6">
                                <?php $form->field($model, 'Grant_Name')->textInput(['readonly' => true, 'disabled' => true]) ?>

                                <?= $form->field($model, 'Grant_Activity')->dropdownList($activities,['prompt' => 'Select ...']) ?>
                                <?= $form->field($model, 'Grant_Type')->textInput(['readonly' => true,'disabled' => true]) ?>
                             </div>
                </div>

                <div class="row">

                    <div class="form-group">
                        <?= Html::submitButton(($model->isNewRecord)?'Save':'Update', ['class' => 'btn btn-success','id'=>'submit']) ?>
                    </div>


                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="absolute" value="<?= $absoluteUrl ?>">
<?php
$script = <<<JS

$('.field-donorline-grant_activity').hide();

 $('#donorline-grant_code, #donorline-grant_activity').select2();

 $('#donorline-grant_code').change((e) => {
        globalFieldUpdate('donorline',false,'Grant_Code', e,['Grant_Type','Contract_Grant_End_Date','Contract_Grant_Start_Date']);

        let grantType = $('#donorline-grant_type').val();
        console.log('Grant Type:'+grantType);
       if(grantType)
       {
            if(grantType === 'CORE' )
            {
                $('.field-donorline-grant_activity').fadeIn();
            }else{
                $('.field-donorline-grant_activity').fadeOut();
            }
       }
}); 

 $('#donorline-contract_grant_start_date').change((e) => {
        globalFieldUpdate('donorline',false,'Contract_Grant_Start_Date', e);
});

$('#donorline-contract_grant_end_date').change((e) => {
        globalFieldUpdate('donorline',false,'Contract_Grant_End_Date', e);
});

$('#donorline-percentage').change((e) => {
        globalFieldUpdate('donorline',false,'Percentage', e);
});

$('#donorline-grant_activity').change((e) => {
        globalFieldUpdate('donorline',false,'Grant_Activity', e);
});
 
JS;

$this->registerJs($script);
