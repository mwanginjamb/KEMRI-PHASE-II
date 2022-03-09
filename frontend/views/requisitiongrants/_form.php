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
                                    <?= $form->field($model, 'Donor_Code')->dropDownList($donors, ['prompt' => 'Select Contract Code...']) ?>
                                    
                                    <?= $form->field($model, 'Percentage')->textInput(['type' => 'number']) ?>
                                    <?php $form->field($model, 'Grant_Status')->dropDownList([
                                        '_blank_' => '_blank_',
                                        'Active' => 'Active',
                                        'Expired' => 'Expired',
                                        'Inactive' => 'Inactive'
                                    ],['prompt' => 'Select ...','readonly' => true]) ?>
                                    <?= $form->field($model, 'Grant_Start_Date')->hiddenInput(['readonly' => true])->label(false) ?>
                                    <?= $form->field($model, 'Grant_End_Date')->hiddenInput(['readonly' => true])->label(false) ?>
                                    <?= $form->field($model, 'Grant_Activity')->hiddenInput(['readonly' => true])->label(false) ?>
                                    <?= $form->field($model, 'Grant_Type')->hiddenInput(['readonly' => true])->label(false) ?>
                                    <?= $form->field($model, 'Grant_Status')->hiddenInput(['readonly' => true])->label(false) ?>
                                    <?= $form->field($model, 'Line_No')->hiddenInput(['readonly' => true, 'disabled' => true])->label(false) ?>
                                   
                            </div>

                             <div class="col-md-6">

                                <?= $form->field($model, 'Grant_Activity')->dropdownList($activities,['prompt' => 'Select Grant Activity ...']) ?>
                                <?= $form->field($model, 'Grant_Type')->textInput(['readonly' => true,'disabled' => true]) ?>
                             </div>
                </div>

                <div class="row">

                    <div class="form-group">
                        <?php Html::submitButton(($model->isNewRecord)?'Save':'Update', ['class' => 'btn btn-success','id'=>'submit']) ?>
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

$('.field-requisitiongrants-grant_activity').hide();

 $('#requisitiongrants-donor_code, #requisitiongrants-grant_activity').select2();

 $('#requisitiongrants-donor_code').on('change',(e) => {
        globalFieldUpdate('requisitiongrants',false,'Donor_Code', e,['Grant_Activity','Grant_Type']);

      
}); 

$('.field-donorline-contract_grant_start_date, .field-donorline-contract_grant_end_date').hover((e) => {
    let grantType = $('#donorline-grant_type').val();
        console.log('Grant Type:'+grantType);
       if(grantType)
       {
            if(grantType === 'CORE' )
            {
                $('.field-requisitiongrants-grant_activity').fadeIn();
            }else{
                $('.field-requisitiongrants-grant_activity').fadeOut();
            }
       }
});

 $('#donorline-contract_grant_start_date').change((e) => {
        globalFieldUpdate('donorline',false,'Contract_Grant_Start_Date', e);
});

$('#donorline-contract_grant_end_date').change((e) => {
        globalFieldUpdate('donorline',false,'Contract_Grant_End_Date', e);
});

$('#requisitiongrants-percentage').change((e) => {
        globalFieldUpdate('requisitiongrants',false,'Percentage', e);
});

$('#requisitiongrants-grant_activity').change((e) => {
        globalFieldUpdate('requisitiongrants',false,'Grant_Activity', e);
});
 
JS;

$this->registerJs($script);
